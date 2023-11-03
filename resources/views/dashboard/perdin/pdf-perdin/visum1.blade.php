<html>
<head>
	<style>
		* {
			margin: 0;
			padding: 0;
		}
		
		.gap-t td {
			padding: 5px;
			border: 1px solid black;
		}
	</style>
</head>
<body style="font-family: Times, serif; margin: 30px;">
	<div style="float: left;">
		<img src="logo.png" width="80">
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
	margin: 10px 0 0 0;
	">

	<div style="text-align: end;">
		<table style="margin-left: auto;">
			<tr>
				<td>Lembar</td>
				<td style="width: 150px;">:</td>
			</tr>
			<tr>
				<td>Kode No.</td>
				<td>:</td>
			</tr>
			<tr>
				<td>Nomor</td>
				<td>:</td>
			</tr>
		</table>
	</div>
	
	<div style="margin: 5px 0;">

		<div style="text-align: center; margin: 0 0 5px 0;">
			<h2 style="text-decoration: underline;">"SURAT PERINTAH PERJALANAN DINAS"</h2>
			<h2>(SPPD)</h2>
		</div>
		
		<div style="border: 1px solid black; padding: 2px;">
			<table class="gap-t" style="width: 100%; border-collapse: collapse; border: 1px solid black;">
				<tr>
					<td style="text-align: center;">1</td>
					<td>Pejabat yang memberi perintah 1</td>
					<td colspan="2">{{ $data_perdin->author->jabatan->nama }}</td>
				</tr>
				<tr>
					<td style="text-align: center;">2</td>
					<td>Nama/NIP yang diperintahkan</td>
					<td colspan="2">
						{{ $data_perdin->pegawai_diperintah->nama }} <br>
						{{ $data_perdin->pegawai_diperintah->nip }}
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">3</td>
					<td>
						<ol style="list-style-type: lower-alpha; padding-left: 20px;">
							<li>Pangkat dan Golongan ruang gaji menurut <br> PP No.11/Tahun 2011</li>
							<li>Jabatan/Instansi</li>
							<li>Tingkat Biaya</li>
						</ol>
					</td>
					<td colspan="2">
						<ol style="list-style-type: lower-alpha; padding-left: 20px;">
							<li>{{ $data_perdin->pegawai_diperintah->nip }}</li>
							<li>{{ $data_perdin->pegawai_diperintah->jabatan->nama }}</li>
							<li>{{ $data_perdin->biaya }}</li>
						</ol>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">4</td>
					<td>Maksud Perjalanan Dinas</td>
					<td colspan="2">{{ $data_perdin->maksud }}</td>
				</tr>
				<tr>
					<td style="text-align: center;">5</td>
					<td>Alat Angkut yang di Pergunakan</td>
					<td colspan="2">{{ $data_perdin->alat_angkut->nama }}</td>
				</tr>
				<tr>
					<td style="text-align: center;">6</td>
					<td>
						<ol style="list-style-type: lower-alpha; padding-left: 20px;">
							<li>Tempat Berangkat</li>
							<li>Tempat Tujuan</li>
						</ol>
					</td>
					<td colspan="2">
						<ol style="list-style-type: lower-alpha; padding-left: 20px;">
							<li>{{ $data_perdin->kedudukan->nama }}</li>
							<li>{{ $data_perdin->tujuan->nama }}</li>
						</ol>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">7</td>
					<td>
						<ol style="list-style-type: lower-alpha; padding-left: 20px;">
							<li>Lamanya Perjalanan Dinas</li>
							<li>Tgl Berangkat</li>
							<li>Tgl harus kembali/Tiba ditempat baru*</li>
						</ol>
					</td>
					<td colspan="2">
						<ol style="list-style-type: lower-alpha; padding-left: 20px;">
							<li>{{ $data_perdin->lama }}</li>
							<li>{{ $data_perdin->tgl_berangkat }}</li>
							<li>{{ $data_perdin->tgl_kembali }}</li>
						</ol>
					</td>
				</tr>
				<tr>
					<td rowspan="6" style="text-align: center;">8</td>
					<td style="text-align: center;">Pengikut/Nama</td>
					<td style="text-align: center;">NIP</td>
					<td style="text-align: center;">Keterangan</td>
				</tr>
				<tr>
					<td>.</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>.</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>.</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>.</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>.</td>
					<td></td>
					<td></td>
				</tr>

				<tr>
					<td style="text-align: center;">9</td>
					<td>
						<p>Pembebanan Anggaran</p>
						<ol style="list-style-type: lower-alpha; padding-left: 20px;">
							<li>Instansi</li>
							<li>Mata Anggaran</li>
						</ol>
					</td>
					<td colspan="2">
						<ol style="list-style-type: lower-alpha; padding-left: 20px;">
							<li>Dinas Pekerjaan Umum dan Penataan Ruang</li>
							<li>5.1.02.04.01.0003</li>
						</ol>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">10</td>
					<td>Keterangan Lain-lain</td>
					<td colspan="2"></td>
				</tr>
			</table>
		</div>

		<table style="margin-left: auto;">
			<tr>
				<td>Dikeluarkan di</td>
				<td>: Serang</td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>: 28 Maret 2023</td>
			</tr>
		</table>

		<div style="float: right;">
			<div style="text-align: center;">
				<p style="margin: 10px 0 50px 0;">Kepala Dinas</p>
				
				<p style="text-decoration: underline; font-weight: bold;">Arlan Marzan, ST, MT</p>
				<p>NIP.19791014 200212 1 004</p>
			</div>
		</div>
	</div>
</body>
</html>
