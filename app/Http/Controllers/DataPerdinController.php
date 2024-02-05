<?php

namespace App\Http\Controllers;

use App\Models\AlatAngkut;
use App\Models\DataPerdin;
use App\Models\JenisPerdin;
use App\Models\Ketentuan;
use App\Models\KwitansiPerdin;
use App\Models\Lama;
use App\Models\LaporanPerdin;
use App\Models\Pegawai;
use App\Models\StatusPerdin;
use App\Models\TandaTangan;
use App\Models\UangHarian;
use App\Models\UangPenginapan;
use App\Models\UangTransport;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DataPerdinController extends Controller
{
    public function getTujuan($jenisPerdinId)
    {
        $jenisPerdin = JenisPerdin::find($jenisPerdinId);
        $tujuan = $jenisPerdin->wilayahs->map(function ($wilayah) {
            return [
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
            ];
        });

        return response()->json($tujuan);
    }

    public function getPegawaiInfo($tujuanId, $pegawaiId)
    {
        $pegawai = Pegawai::find($pegawaiId);
        $pegawaiGolongan = str_replace('-', '_', $pegawai->golongan->slug);

        $uangHarian = UangHarian::where('wilayah_id', $tujuanId)->value($pegawaiGolongan);

        return response()->json(['data_pegawai' => [
            'nip' => $pegawai->nip ?? '-',
            'jabatan' => $pegawai->jabatan->nama,
            'uang_harian'=> $uangHarian ?? 0,
            ]
        ]);
    }

    private function getDataPerdins($queryConditions, $jabatan_id = null)
    {
        return DataPerdin::when($queryConditions, function ($query) use ($queryConditions) {
            return $query->whereHas('status', function ($query) use ($queryConditions) {
                $query->where($queryConditions);
            });
        })
        ->orderBy('id', 'desc')
        ->get()
        ->filter(function ($data_perdin) use ($jabatan_id) {
            return $jabatan_id ? $data_perdin->tanda_tangan->pegawai->jabatan->id == $jabatan_id : true;
        })
        ->map(function ($data_perdin) {
            $status = ($data_perdin->status->approve === null) ? 'Baru' : (($data_perdin->status->approve === 0) ? 'Ditolak' : 'Diterima');

            return [
                'id' => $data_perdin->id,
                'status' => $status,
                'alasan_tolak' => $data_perdin->status->alasan_tolak,
                'pegawai_diperintah' => $data_perdin->pegawai_diperintah->nama,
                'pegawai_mengikuti' => $data_perdin->pegawai_mengikuti->pluck('nama'),
                'tujuan' => $data_perdin->tujuan->nama,
                'tgl_berangkat' => $data_perdin->tgl_berangkat,
                'lama' => $data_perdin->lama,
                'tanda_tangan' => $data_perdin->tanda_tangan->pegawai->jabatan->nama,
            ];
        })
        ->values();
    }

    public function apiDataPerdins(Request $request, $status = null, $jabatan_id = null)
    {
        $queryConditions = [];

        if ($status === 'baru') {
            $queryConditions = ['approve' => null];
        } elseif ($status === 'tolak') {
            $queryConditions = ['approve' => 0];
        } elseif ($status === 'terima') {
            $queryConditions = ['approve' => 1];
        } else {
            $queryConditions = null;
        }

        $data_perdins = $this->getDataPerdins($queryConditions, $jabatan_id);
        return response()->json($data_perdins);
    }

    /**
    * Display a listing of the resource.
    */
    public function index($status = null)
    {
        $authUser = auth()->user();

        if ($authUser->level_admin->slug === 'approval' && $authUser->jabatan_id) {
            $data_perdins = DataPerdin::filterByStatus($status)->whereHas('tanda_tangan.pegawai.jabatan', function ($query) use ($authUser) {
                $query->where('id', $authUser->jabatan_id);
            })->get();
        } else {
            $data_perdins = DataPerdin::filterByStatus($status)->get();
        }

        return view('dashboard.perdin.data-perdin.index', [
            'title' => 'Daftar Data Perdin',
            'data_perdins' => $data_perdins,
        ]);
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $authBidangId = auth()->user()->bidang_id;

        if (empty($authBidangId)) {
            $pegawais = Pegawai::whereNotNull('golongan_id')->whereHas('ketentuan', function ($query) {
                $query->where('tersedia', 1);
            })->get();
        } else {
            $kabid = Pegawai::whereHas('jabatan', function ($query) {
                        $query->where('nama', 'like', '%Kepala Bidang%');
                    })->get();
            $sekdis = Pegawai::whereHas('jabatan', function ($query) {
                        $query->where('nama', 'like', '%Sekretaris Dinas%');
                    })->get();
            $pegawai = Pegawai::whereNotNull('golongan_id')
                        ->where('bidang_id', $authBidangId)
                        ->whereHas('ketentuan', function ($query) {
                            $query->where('tersedia', 1);
                        })->get();

            $pegawais = $pegawai->merge($kabid)->merge($sekdis);
        }

        return view('dashboard.perdin.data-perdin.create', [
            'title' => 'Tambah Data Perdin',
            'alat_angkuts' => AlatAngkut::all(),
            'jenis_perdins' => JenisPerdin::all(),
            'tanda_tangans' => TandaTangan::all(),
            'lamas' => Lama::all(),
            'pegawais' => $pegawais
        ]);
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $request->validate([
                'surat_dari' => 'nullable',
                'nomor_surat' => 'nullable',
                'tgl_surat' => 'nullable|date',
                'perihal' => 'nullable',
                'tanda_tangan_id' => 'required',
                'maksud' => 'required',
                'lama' => 'required',
                'tgl_berangkat' => 'required|date',
                'tgl_kembali' => 'required|date',
                'alat_angkut_id' => 'required',
                'jenis_perdin_id' => 'required',
                'tujuan_id' => 'required',
                'lokasi' => 'required',
                'pegawai_diperintah_id' => 'required',
                'pegawai_mengikuti_id' => 'nullable',
            ]);

            $validatedData['slug'] = SlugService::createSlug(DataPerdin::class, 'slug', $request->maksud);
            $validatedData['author_id'] = auth()->user()->id;
            $validatedData['kedudukan'] = 'Kota Serang';

            $selectedPegawaiIds = explode(',', $request->pegawai_mengikuti_id);
            $validatedData['jumlah_pegawai'] = count($selectedPegawaiIds);

            $status = StatusPerdin::create();
            $validatedData['status_id'] = $status->id;

            $laporan_perdin = LaporanPerdin::create();
            $validatedData['laporan_perdin_id'] = $laporan_perdin->id;

            $kwitansi_perdin = KwitansiPerdin::create();
            $validatedData['kwitansi_perdin_id'] = $kwitansi_perdin->id;

            foreach ($selectedPegawaiIds as $pegawaiId) {
                $pegawai = Pegawai::find($pegawaiId);
                $pegawaiGolongan = str_replace('-', '_', $pegawai->golongan->slug);
                $uangHarian = UangHarian::where('wilayah_id', $validatedData['tujuan_id'])->value($pegawaiGolongan);
                $uangTransport = UangTransport::where('wilayah_id', $validatedData['tujuan_id'])->value($pegawaiGolongan);
                $uangTiket = UangTransport::where('wilayah_id', $validatedData['tujuan_id'])->value('harga_tiket');
                $uangPenginapan = UangPenginapan::where('wilayah_id', $validatedData['tujuan_id'])->value($pegawaiGolongan);
                $kwitansi_perdin->pegawais()->attach($pegawaiId, [
                    'uang_harian' => $uangHarian ?? 0,
                    'uang_transport' => $uangTransport ?? 0,
                    'uang_tiket' => $uangTiket ?? 0,
                    'uang_penginapan' => $uangPenginapan ?? 0,
                ]);
            }

            $perdin = DataPerdin::create($validatedData);

            $pegawaiDiperintahId = $request->pegawai_diperintah_id;
            $selectedPegawaiIds = array_diff($selectedPegawaiIds, [$pegawaiDiperintahId]);
            if($selectedPegawaiIds){
                $perdin->pegawai_mengikuti()->attach($selectedPegawaiIds);
            }

            $allKetentuanIds = collect([$perdin->pegawai_diperintah->ketentuan_id])->merge($perdin->pegawai_mengikuti->pluck('ketentuan_id'))->unique();
            $ketentuans = Ketentuan::whereIn('id', $allKetentuanIds)->get();
            $pegawaiBatasMaksimal = [];

            foreach ($ketentuans as $ketentuan) {
                if ($ketentuan->jumlah_perdin >= $ketentuan->max_perdin) {
                    $pegawaiBatasMaksimal[] = $ketentuan->pegawai->nama;
                }
            }

            if (!empty($pegawaiBatasMaksimal)) {
                return redirect()->back()->withInput()->with('failedSave', implode(', ', $pegawaiBatasMaksimal) . ' telah mencapai batas maksimal perdin!');
            }

            Ketentuan::whereIn('id', $allKetentuanIds)->increment('jumlah_perdin');

            Artisan::call('availability:update');
            return redirect()->route('data-perdin.index', 'baru')->with('success', 'Data Perdin berhasil ditambahkan!');
        }, 2);
    }

    /**
    * Display the specified resource.
    */
    public function show(DataPerdin $dataPerdin)
    {
        return view('dashboard.perdin.data-perdin.show', [
            'title' => 'Detail Data Perdin',
            'data_perdin' => $dataPerdin,
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(DataPerdin $dataPerdin)
    {
        $authBidangId = auth()->user()->bidang_id;

        if (empty($authBidangId)) {
            $pegawais = Pegawai::whereNotNull('golongan_id')->whereHas('ketentuan', function ($query) {
                $query->where('tersedia', 1);
            })->get();
        } else {
            $kabid = Pegawai::whereHas('jabatan', function ($query) {
                        $query->where('nama', 'like', '%Kepala Bidang%');
                    })->get();
            $sekdis = Pegawai::whereHas('jabatan', function ($query) {
                        $query->where('nama', 'like', '%Sekretaris Dinas%');
                    })->get();
            $pegawai = Pegawai::whereNotNull('golongan_id')
                        ->where('bidang_id', $authBidangId)
                        ->whereHas('ketentuan', function ($query) {
                            $query->where('tersedia', 1);
                        })->get();

            $pegawais = $pegawai->merge($kabid)->merge($sekdis);
        }

        $selectedPegawai = collect();

        // Pegawai diperintah
        $pegawaiDiperintah = $dataPerdin->pegawai_diperintah;
        $selectedPegawai->push([
            'id' => strval($pegawaiDiperintah->id),
            'nama' => $pegawaiDiperintah->nama,
            'nip' => $pegawaiDiperintah->nip,
            'jabatan' => $pegawaiDiperintah->jabatan->nama,
            'uang_harian' => UangHarian::where('wilayah_id', $dataPerdin->tujuan_id)->value(str_replace('-', '_', $pegawaiDiperintah->golongan->slug)),
            'keterangan' => 'Pegawai yang ditugaskan'
        ]);

        // Pegawai mengikuti
        $pegawaiMengikuti = $dataPerdin->pegawai_mengikuti->map(function ($pegawai) use ($dataPerdin) {
            return [
                'id' => strval($pegawai->id),
                'nama' => $pegawai->nama,
                'nip' => $pegawai->nip,
                'jabatan' => $pegawai->jabatan->nama,
                'uang_harian' => UangHarian::where('wilayah_id', $dataPerdin->tujuan_id)->value(str_replace('-', '_', $pegawai->golongan->slug)),
                'keterangan' => 'Pegawai sebagai pengikut'
            ];
        });

        $selectedPegawai = $selectedPegawai->merge($pegawaiMengikuti);

        return view('dashboard.perdin.data-perdin.edit', [
            'title' => 'Perbarui Data Perdin',
            'alat_angkuts' => AlatAngkut::all(),
            'jenis_perdins' => JenisPerdin::all(),
            'tanda_tangans' => TandaTangan::all(),
            'lamas' => Lama::all(),
            'pegawais' => $pegawais,
            'data_perdin' => $dataPerdin,
            'selected_pegawai' => $selectedPegawai
        ]);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, DataPerdin $dataPerdin)
    {
        return DB::transaction(function () use ($request, $dataPerdin) {
            $validatedData = $request->validate([
                'surat_dari' => 'nullable',
                'nomor_surat' => 'nullable',
                'tgl_surat' => 'nullable|date',
                'perihal' => 'nullable',
                'tanda_tangan_id' => 'required',
                'maksud' => 'required',
                'lama' => 'required',
                'tgl_berangkat' => 'required|date',
                'tgl_kembali' => 'required|date',
                'alat_angkut_id' => 'required',
                'jenis_perdin_id' => 'required',
                'tujuan_id' => 'required',
                'lokasi' => 'required',
                'pegawai_diperintah_id' => 'required',
                'pegawai_mengikuti_id' => 'nullable',
            ]);

            $validatedData['slug'] = SlugService::createSlug(DataPerdin::class, 'slug', $request->maksud);
            $validatedData['author_id'] = auth()->user()->id;

            $selectedPegawaiIds = explode(',', $request->pegawai_mengikuti_id);
            $validatedData['jumlah_pegawai'] = count($selectedPegawaiIds);

            $ketentuanSebelumnya = array_merge([$dataPerdin->pegawai_diperintah->ketentuan_id], $dataPerdin->pegawai_mengikuti->pluck('ketentuan_id')->toArray());
            Ketentuan::whereIn('id', $ketentuanSebelumnya)->decrement('jumlah_perdin');

            $dataPerdin->pegawai_mengikuti()->detach();
            $dataPerdin->kwitansi_perdin->pegawais()->detach();

            foreach ($selectedPegawaiIds as $pegawaiId) {
                $pegawai = Pegawai::find($pegawaiId);
                $pegawaiGolongan = str_replace('-', '_', $pegawai->golongan->slug);
                $uangHarian = UangHarian::where('wilayah_id', $validatedData['tujuan_id'])->value($pegawaiGolongan);
                $uangTransport = UangTransport::where('wilayah_id', $validatedData['tujuan_id'])->value($pegawaiGolongan);
                $uangTiket = UangTransport::where('wilayah_id', $validatedData['tujuan_id'])->value('harga_tiket');
                $uangPenginapan = UangPenginapan::where('wilayah_id', $validatedData['tujuan_id'])->value($pegawaiGolongan);
                $dataPerdin->kwitansi_perdin->pegawais()->attach($pegawaiId, [
                    'uang_harian' => $uangHarian ?? 0,
                    'uang_transport' => $uangTransport ?? 0,
                    'uang_tiket' => $uangTiket ?? 0,
                    'uang_penginapan' => $uangPenginapan ?? 0,
                ]);
            }

            $dataPerdin->update($validatedData);

            $pegawaiDiperintahId = $request->pegawai_diperintah_id;
            $selectedPegawaiIds = array_diff($selectedPegawaiIds, [$pegawaiDiperintahId]);
            if($selectedPegawaiIds){
                $dataPerdin->pegawai_mengikuti()->attach($selectedPegawaiIds);
            }

            $allKetentuanIds = Pegawai::whereIn('id', [$pegawaiDiperintahId, ...$selectedPegawaiIds])->pluck('ketentuan_id')->toArray();
            $ketentuans = Ketentuan::whereIn('id', $allKetentuanIds)->get();
            $pegawaiBatasMaksimal = [];

            foreach ($ketentuans as $ketentuan) {
                if ($ketentuan->jumlah_perdin >= $ketentuan->max_perdin) {
                    $pegawaiBatasMaksimal[] = $ketentuan->pegawai->nama;
                }
            }

            if ($pegawaiBatasMaksimal) {
                return redirect()->back()->withInput()->with('failedSave', implode(', ', $pegawaiBatasMaksimal) . ' telah mencapai batas maksimal perdin!');
            }

            Ketentuan::whereIn('id', $allKetentuanIds)->increment('jumlah_perdin');

            Artisan::call('availability:update');
            return redirect()->route('data-perdin.index', 'baru')->with('success', 'Data Perdin berhasil ditambahkan!');
        }, 2);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(DataPerdin $dataPerdin)
    {
        return DB::transaction(function () use ($dataPerdin) {
            $pegawaiDiperintah = $dataPerdin->pegawai_diperintah;
            $pegawaiMengikuti = $dataPerdin->pegawai_mengikuti;

            $pegawaiDiperintah->ketentuan->decrement('jumlah_perdin');
            $pegawaiDiperintah->ketentuan->update(['tersedia' => 1]);

            foreach ($pegawaiMengikuti as $pegawai) {
                $pegawai->ketentuan->decrement('jumlah_perdin');
                $pegawai->ketentuan->update(['tersedia' => 1]);
            }

            $dataPerdin->delete();

            return redirect()->route('data-perdin.index', 'baru')->with('success', 'Data Perdin berhasil dihapus!');
        }, 2);
    }
}
