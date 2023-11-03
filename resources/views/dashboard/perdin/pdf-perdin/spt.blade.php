<html>
<head>
	<style>
		* {
			margin: 0;
			padding: 0;
		}
		
		td {
			padding: 5px;
			vertical-align: top;
		}
	</style>
</head>
<body style="font-family: Times, serif; margin: 30px;">
	<div style="float: left;">
		<img src="{{ public_path('/assets/img/logo-banten.png') }}" width="80">
	</div>
	<div style="text-align: center;">
		<h2>
			PEMERINTAH PROVINSI BANTEN <br>
			DINAS PEKERJAAN UMUM DAN PENATAAN RUANG
		</h2>
		<small>
			Kawasan Pusat Pemerintahan Provinsi Banten (KP3B) <br>
			Jln. Syekh Nawawi Al Bantani, Palima Serang-Banten Telp.(0254) 267053, Fax.(0254) 267052 Serang
		</small>
	</div>

	<hr style="
	border-top: 3px solid;
	border-bottom: 1px solid;
	padding: 1px 0;
	margin: 10px 0;
	">
	
	<div style="margin: 20px 60px 0 60px;">

		<div style="text-align: center;">
			<p style="text-decoration: underline; font-weight: bold;">SURAT PERINTAH TUGAS</p>
			<p>No. {{ $data_perdin->id }}</p>
			<p style="margin: 10px 0;">Kepala Dinas Pekerjaan Umum dan Penataan Ruang Provinsi Banten.</p>
			<p>MEMERINTAHKAN:</p>
		</div>
		
		<table style="width: 100%;">
			<tr>
				<td>Kepada</td>
				<td colspan="2">:</td>
			</tr>
			<tr>
				<td style="text-align: end;">1. </td>
				<td>Nama</td>
				<td>: <b>{{ $data_perdin->pegawai_diperintah->nama }}</b></td>
				<tr>
					<td rowspan="3"></td>
					<td>NIP</td>
					<td>: {{ $data_perdin->pegawai_diperintah->nip }}</td>
				</tr>
				<tr>
					<td>Pangkat/Gol Ruang</td>
					<td>: {{ $data_perdin->pegawai_diperintah->ruang->nama }}</td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td>: {{ $data_perdin->pegawai_diperintah->jabatan->nama }}</td>
				</tr>
			</tr>
			
			<tr>
				<td>Untuk</td>
				<td colspan="2">: {{ $data_perdin->perihal }}</td>
			</tr>
			<tr>
				<td rowspan="4"></td>
				<td>Hari</td>
				<td>: {{ Carbon\Carbon::parse($data_perdin->tgl_berangkat)->formatLocalized('%A') }}</td>
				<tr>
					<td>Tanggal</td>
					<td>: {{ Carbon\Carbon::parse($data_perdin->tgl_berangkat)->formatLocalized('%d %B %Y') }}</td>
				</tr>
				<tr>
					<td>Tempat</td>
					<td>: {{ $data_perdin->lokasi }}, {{ $data_perdin->kedudukan->nama }}, {{ $data_perdin->kedudukan->provinsi->nama }}</td>
				</tr>
			</tr>
		</table>
		
		<p style="margin: 30px 0;">Demikian Surat Perintah Tugas ini dibuat, untuk dilaksanakan dengan penuh rasa tanggung jawab.</p>
		
		<div style="float: right;">
			<table style="margin-left: auto;">
				<tr>
					<td>Ditetapkan di</td>
					<td>: Serang</td>
				</tr>
				<tr>
					<td>Pada Tanggal</td>
					<td>: {{ now()->formatLocalized('%d %B %Y') }}</td>
				</tr>
			</table>
	
			<div style="text-align: center;">
				<h4 style="margin: 30px 0 80px 0; text-transform: uppercase">
					{{ $data_perdin->tanda_tangan->pegawai->jabatan->nama }} <br>
					{{ $data_perdin->tanda_tangan->pegawai->seksi->nama }} <br>
					provinsi banten
				</h4>
				
				<p style="text-decoration: underline; font-weight: bold;">{{ $data_perdin->tanda_tangan->pegawai->nama }}</p>
				<p>{{ $data_perdin->tanda_tangan->pegawai->nip }}</p>
			</div>
		</div>
	</div>
</body>
</html>