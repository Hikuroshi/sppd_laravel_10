<?php

namespace App\Http\Controllers;

use App\Models\LaporanPerdin;
use App\Models\StatusPerdin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanPerdinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.perdin.laporan-perdin.index', [
            'title' => 'Daftar Laporan Perdin',
            'laporan_perdins' => LaporanPerdin::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanPerdin $laporanPerdin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanPerdin $laporanPerdin)
    {
        return view('dashboard.perdin.laporan-perdin.edit', [
            'title' => 'Perbarui Laporan Perdin',
            'laporan_perdin' => $laporanPerdin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LaporanPerdin $laporanPerdin)
    {
        $validatedData = $request->validate([
            'maksud1' => 'required',
            'maksud2' => 'required',
            'maksud3' => 'required',
            'kegiatan1' => 'required',
            'kegiatan2' => 'required',
            'kegiatan3' => 'required',
            'hasil1' => 'required',
            'hasil2' => 'required',
            'hasil3' => 'required',
            'kesimpulan1' => 'required',
            'kesimpulan2' => 'required',
            'kesimpulan3' => 'required',
            'file_laporan' => 'mimes:pdf|file|max:10000',
        ]);

        if ($request->file('file_laporan')) {
            if($request->oldLaporan){
                Storage::delete($request->oldLaporan);
            }
            $validatedData['file_laporan'] = $request->file('file_laporan')->store('file-laporan');
        }

        $validatedData['author_id'] = auth()->user()->id;
        
        LaporanPerdin::where('id', $laporanPerdin->id)->update($validatedData);
        StatusPerdin::where('id', $laporanPerdin->data_perdin->status_id)->update(['lap' => 1]);
        return redirect()->back()->with('success', 'Laporan Perdin berhasil disimpan! Silahkan cetak Laporan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanPerdin $laporanPerdin)
    {
        $laporanPerdin->delete();
        return redirect()->route('laporan-perdin.index')->with('success', 'Laporan Perdin berhasil dihapus!');
    }
}
