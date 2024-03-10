<html>
<head>
	<style>
		* {
			margin: 0;
			padding: 0;
		}

		.gap-t td, th {
			padding: 1px 5px;
			vertical-align: top;
		}

		ul {
			list-style-type: none;
			padding-left: 0;
		}

		ul li {
			padding-left: 10px;
			text-indent: -9px;
		}

		ul li::before {
			content: "\003A";
			margin-right: 1px;
		}
	</style>
</head>
<body style="font-family: Times, serif; margin: 30px;">
	@foreach ($kwitansi_perdin->pegawais as $index => $pegawai)

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
	margin: 10px 0 5px 0;
	">

	<div style="text-align: center; margin: 0 0 5px 0;">
		<h2 style="word-spacing: 5px;">K U I T A N S I</h2>
	</div>

	<table class="gap-t" style="width: 100%; border-collapse: collapse;">
		<tr>
			<td style="white-space: nowrap;">Telah diterima dari</td>
            <td>:</td>
			<td colspan="5">Kepala Dinas Pekerjaan Umum dan Penataan Ruang Provinsi Banten Selaku Pengguna Anggaran</td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Dengan Cara</td>
            <td>:</td>
			<td colspan="5">Transfer Bendahara Pengeluaran Dinas Pekerjaan Umum dan Penataan Ruang Provinsi Banten</td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Uang Sejumlah</td>
            <td>:</td>
			<td colspan="5" style="text-transform: capitalize">{{ $kwitansi_perdin->terbilang($pegawai->pivot->uang_harian + $pegawai->pivot->uang_transport + $pegawai->pivot->uang_tiket + $pegawai->pivot->uang_penginapan) }} Rupiah</td>
		</tr>
		<tr>
			<td style="white-space: nowrap;">Untuk Pembayaran</td>
            <td>:</td>
			<td colspan="5">Biaya Perjalanan Dinas Sdr. {{ $pegawai->nama }} ke {{ $kwitansi_perdin->data_perdin->kabupaten->nama ?? '' }} selama {{ $kwitansi_perdin->data_perdin->lama }} hari sesuai SPD Nomor : {{ $kwitansi_perdin->data_perdin->no_spt }} tanggal {{ Carbon\Carbon::parse($kwitansi_perdin->data_perdin->tgl_berangkat)->isoFormat('D MMMM YYYY') }}</td>
		</tr>

		<tr>
			<td></td>
			<td></td>
			<td style="white-space: nowrap;">dengan perincian sbb:</td>
			<td style="white-space: nowrap;">
				<span style="margin: 0 20px 0 50px;">-</span>
				<span>Uang Harian</span>
			</td>
			<td>Rp.</td>
			<td style="text-align: right;">{{ number_format($pegawai->pivot->uang_harian, 2, ',', '.') }}</td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td style="white-space: nowrap;">
				<span style="margin: 0 20px 0 50px;">-</span>
				<span>Uang Transport</span>
			</td>
			<td>Rp.</td>
			<td style="text-align: right;">{{ number_format($pegawai->pivot->uang_transport, 2, ',', '.') }}</td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td style="white-space: nowrap;">
				<span style="margin: 0 20px 0 50px;">-</span>
				<span>Uang Akomodasi</span>
			</td>
			<td>Rp.</td>
			<td style="text-align: right;">{{ number_format($pegawai->pivot->uang_tiket + $pegawai->pivot->uang_penginapan, 2, ',', '.') }}</td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td style="white-space: nowrap;">
				<span style="margin: 0 20px 0 50px;">-</span>
				<span>Total</span>
			</td>
			<td>Rp.</td>
			<td style="text-align: right; text-decoration: underline;">{{ number_format($pegawai->pivot->uang_harian + $pegawai->pivot->uang_transport + $pegawai->pivot->uang_tiket + $pegawai->pivot->uang_penginapan, 2, ',', '.') }}</td>
		</tr>

        <tr>
            <td style="white-space: nowrap;">Kegiatan</td>
            <td>:</td>
            <td colspan="5">{{ $kwitansi_perdin->kegiatan_sub->kegiatan->nama }}</td>
        </tr>
        <tr>
            <td style="white-space: nowrap;">Sub Kegiatan</td>
            <td>:</td>
            <td colspan="5">{{ $kwitansi_perdin->kegiatan_sub->nama }}</td>
        </tr>

		<tr>
            <td style="white-space: nowrap;">Kode Rekening</td>
            <td>:</td>
			<td colspan="5">{{ $kwitansi_perdin->no_rek }}</td>
		</tr>

		<tr>
            <td style="white-space: nowrap; padding: 10px 5px;">Jumlah</td>
            <td style="padding: 10px 5px;">:</td>
			<td style="padding: 10px 5px;" colspan="5">
                <span style="vertical-align: 1.1em; padding-right: 30px;">Rp.</span>
                <div style="display: inline-block; border: 2px solid black; transform: skewX(-40deg); text-align: center; padding: 10px 15px;">
                    <span style="display: inline-block; transform: skewX(40deg);">
                        {{ number_format($pegawai->pivot->uang_harian + $pegawai->pivot->uang_transport + $pegawai->pivot->uang_tiket + $pegawai->pivot->uang_penginapan, 2, ',', '.') }}
                    </span>
                </div>
            </td>
		</tr>
	</table>

    <p style="text-align: right; margin-right: 20%; margin-top: 30px;">Serang,</p>

	<table class="gap-t" style="width: 100%; border-collapse: collapse;">
		<tr>
            <td style="text-align: center;">
                <span style="text-decoration: underline;">Lunas Dibayar</span><br>
                Bendahara Pengeluaran
            </td>
			<td style="text-align: center;">
				<span style="text-decoration: underline;">Pejabat Pelaksana Teknis</span><br>
				Kegiatan
			</td>
			<td style="text-align: center;">
				<span style="text-decoration: underline;">Yang Menerima</span><br>
			</td>
		</tr>
		<tr>
			<td style="padding-top: 60px;" colspan="3"></td>
		</tr>
		<tr>
            <td style="text-align: center;">
                <span style="text-decoration: underline;">{{ $bendahara->pegawai->nama ?? '' }}</span><br>
                NIP {{ $bendahara->pegawai->nip ?? '' }}
            </td>
			<td style="text-align: center;">
				<span style="text-decoration: underline;">{{ $kwitansi_perdin->data_perdin->pptk->pegawai->nama ?? '' }}</span><br>
				NIP {{ $kwitansi_perdin->data_perdin->pptk->pegawai->nip ?? '' }}
			</td>
            <td style="text-align: center;">
                <span style="text-decoration: underline;">{{ $pegawai->nama }}</span><br>
                NIP {{ $pegawai->nip }}
            </td>
		</tr>
		<tr>
			<td style="padding-top: 60px;" colspan="3"></td>
		</tr>
        <tr>
            <td colspan="3" style="text-align: center;">
                <span style="text-decoration: underline;">Menyetujui</span><br>
                Pengguna Anggaran
            </td>
        </tr>
        <tr>
			<td style="padding-top: 60px;" colspan="3"></td>
		</tr>
        <tr>
			<td colspan="3" style="text-align: center;">
				<span style="text-decoration: underline;">{{ $kwitansi_perdin->data_perdin->tanda_tangan->pegawai->nama }}</span><br>
				NIP {{ $kwitansi_perdin->data_perdin->tanda_tangan->pegawai->nip }}
			</td>
        </tr>
	</table>

	@if ($index != count($kwitansi_perdin->pegawais) - 1)
        <div style="page-break-before: always;"></div>
    @endif
	@endforeach
</body>
</html>