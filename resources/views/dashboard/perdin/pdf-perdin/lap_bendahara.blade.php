<html>
<head>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        td {
            padding: 1px 7px 1px 7px;
            vertical-align: top;
        }

        p, td {
            font-size: 16px;
        }
    </style>
</head>
<body style="font-family: Times, serif; margin: 30px;">
    <table>
        <tr>
            <td>
                <img src="data:image/png;base64,{{ $imgLogo }}" width="80">
            </td>
            <td style="width: 100%;">
                <div style="text-align: center;">
                    <p style="font-size: x-large;">PEMERINTAH PROVINSI BANTEN</p>
                    <h2>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</h2>
                    <small>
                        Kawasan Pusat Pemerintahan Provinsi Banten (KP3B) <br>
                        Jalan Syech Nawawi Al Bantani, Palima Serang Banten <br>
                        Laman : dpupr.bantenprov.go.id Pos-el : dpupr@bantenprov.go.id Kode Pos 42171
                    </small>
                </div>
            </td>
        </tr>
    </table>

    <hr style="
    border-top: 3px solid;
    border-bottom: 1px solid;
    padding: 1px 0;
    margin: 10px 0;
    ">

    <div style="margin: 20px;">
        <table style="margin-bottom: 20px;">
            <tr>
                <td>Dari</td>
                <td>: Pengguna Anggaran</td>
            </tr>
            <tr>
                <td>Untuk</td>
                <td>: Bendahara Pengeluaran</td>
            </tr>
        </table>

        <div style="text-align: center; margin-bottom: 30px">
            <p style="margin: 0; font-size: 20px;">SURAT PERINTAH</p>
            <p style="margin: 0;">
                <span style="padding-right: 100px;">NOMOR : 900.1.7.2/</span>
                /2024
            </p>
		</div>

        <table style="margin-top: 20px;">
            <tr>
                <td>Berikan/Keluarkan uang sebesar</td>
                <td>:</td>
                <td style="font-weight: bold;">Rp. {{ number_format($total_uang, 0, '.', '.') }},-</td>
            </tr>
        </table>
        <table style="margin-bottom: 20px;">
            <tr>
                <td>Terbilang</td>
                <td>:</td>
                <td style="font-weight: bold; font-style: italic;">{{ ucwords($kwitansi_perdin->terbilang($total_uang)) }}</td>
            </tr>
            <tr>
                <td>Kepada</td>
                <td>:</td>
                <td style="font-weight: bold;">{{ $kwitansi_perdin->data_perdin->pegawai_diperintah->nama }} Dkk</td>
            </tr>
            <tr>
                <td>Keperluan</td>
                <td>:</td>
                <td>
                    Belanja {{ $kwitansi_perdin->data_perdin->jenis_perdin->nama }} ke {{ $kwitansi_perdin->data_perdin->lokasi }}, tanggal {{ Carbon\Carbon::parse($kwitansi_perdin->data_perdin->tgl_berangkat)->isoFormat('D MMMM YYYY') }}
                </td>
            </tr>
            <tr>
                <td>Kegiatan</td>
                <td>:</td>
                <td>{{ $kwitansi_perdin->kegiatan_sub->kegiatan->nama }}</td>
            </tr>
            <tr>
                <td>Sub Kegiatan</td>
                <td>:</td>
                <td>{{ $kwitansi_perdin->kegiatan_sub->nama }}</td>
            </tr>
            <tr>
                <td style="white-space: nowrap;">Kode Rekening</td>
                <td>:</td>
                <td>{{ $kwitansi_perdin->no_rek }}</td>
            </tr>
        </table>

        <table style="width: 100%;">
			<tr>
				<td style="width: 50%"></td>
				<td>
					<div style="text-align: center;">
						<div style="display: inline-block; text-align: left;">
							<p style="margin-top: 20px;">
								<span style="padding-right: 100px;">Serang,</span> {{ now()->isoFormat('YYYY') }} <br>
								Pengguna Anggaran
							</p>
							<img src="data:image/png;base64,{{ $kwitansi_perdin->data_perdin->tanda_tangan->fileTtdEncoded }}" alt="{{ $kwitansi_perdin->data_perdin->tanda_tangan->nama }}" height="70">
							<p>{{ $kwitansi_perdin->data_perdin->tanda_tangan->pegawai->nama }}</p>
                            <p>{{ $kwitansi_perdin->data_perdin->tanda_tangan->pegawai->pangkat->nama ?? '' }}</p>
							<p>NIP {{ $kwitansi_perdin->data_perdin->tanda_tangan->pegawai->nip }}</p>
						</div>
					</div>
				</td>
			</tr>
		</table>
    </div>
</body>
</html>