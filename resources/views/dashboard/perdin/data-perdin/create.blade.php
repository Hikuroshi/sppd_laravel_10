@extends('layouts.main')

@section('container')

<div class="row row-sm">
	<div class="col-xl-12">
		<div class="card box-shadow-0 ">
			<div class="card-header">
				@if(session()->has('failedSave'))
				<div class="alert alert-danger mg-b-0 mb-5" role="alert">
					<button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
						<span aria-hidden="true">×</span>
					</button>
					<strong>Peringatan!</strong> <br>
					{{ session('failedSave') }}
				</div>
				@endif
				<div class="d-flex justify-content-between">
					<h4 class="card-title mb-1">{{ $title }}</h4>
					<a class="btn btn-secondary btn-sm" href="{{ route('data-perdin.index', 'baru') }}">
						<i class="fa fa-reply"></i>
					</a>
				</div>
			</div>
			<div class="card-body pt-0">
				<form action="{{ route('data-perdin.store') }}" method="post">
					@csrf
					
					<div class="row row-sm">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="surat_dari">Surat Dari</label>
								<input name="surat_dari" value="{{ old('surat_dari') }}" type="text" class="form-control @error('surat_dari') is-invalid @enderror" id="surat_dari" placeholder="Masukan surat_dari">
								@error('surat_dari')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="nomor_surat">Nomor Surat</label>
								<input name="nomor_surat" value="{{ old('nomor_surat') }}" type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" placeholder="Masukan nomor_surat">
								@error('nomor_surat')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="tgl_surat">Tanggal Surat</label>
						<input name="tgl_surat" value="{{ old('tgl_surat') }}" type="date" class="form-control @error('tgl_surat') is-invalid @enderror" id="tgl_surat" placeholder="Masukan tgl_surat">
						@error('tgl_surat')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="perihal">Perihal</label>
						<textarea name="perihal" class="form-control @error('perihal') is-invalid @enderror" id="perihal" placeholder="Masukan perihal" rows="3">{{ old('perihal') }}</textarea>
						@error('perihal')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					
					<hr>
					
					<div class="form-group">
						<label for="tanda_tangan_id" class="form-label">Pejabat yang memberi perintah</label>
						<select name="tanda_tangan_id" id="tanda_tangan_id" class="form-control form-select select2 @error('tanda_tangan_id') is-invalid @enderror">
							<option value="">Pilih Pejabat</option>
							@foreach ($tanda_tangans as $tanda_tangan)
							<option value="{{ $tanda_tangan->id }}" @selected(old('tanda_tangan_id') == $tanda_tangan->id)>
								{{ $tanda_tangan->pegawai->jabatan->nama }}
							</option>
							@endforeach
						</select>
						@error('tanda_tangan_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="maksud">Madsud Perjalanan Dinas</label>
						<textarea name="maksud" class="form-control @error('maksud') is-invalid @enderror" id="maksud" placeholder="Masukan maksud" rows="3">{{ old('maksud') }}</textarea>
						@error('maksud')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="lama" class="form-label">Lamanya Perjalanan Dinas</label>
						<select name="lama" id="lama" class="form-control form-select select2 @error('lama') is-invalid @enderror">
							<option value="">Pilih Lama Hari</option>
							@foreach ($lamas as $lama)
							<option value="{{ $lama->lama_hari }}" @selected(old('lama') == $lama->lama_hari)>
								{{ $lama->lama_hari }} hari
							</option>
							@endforeach
						</select>
						@error('lama')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="row row-sm">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="tgl_berangkat">Tanggal Berangkat</label>
								<input name="tgl_berangkat" value="{{ old('tgl_berangkat') }}" type="date" class="form-control @error('tgl_berangkat') is-invalid @enderror" id="tgl_berangkat" placeholder="Masukan tgl_berangkat">
								@error('tgl_berangkat')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="tgl_kembali">Tanggal Kembali</label>
								<input readonly name="tgl_kembali" value="{{ old('tgl_kembali') }}" type="date" class="form-control @error('tgl_kembali') is-invalid @enderror" id="tgl_kembali" placeholder="Masukan tgl_kembali">
								@error('tgl_kembali')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="alat_angkut_id" class="form-label">Alat Angkut</label>
						<select name="alat_angkut_id" id="alat_angkut_id" class="form-control form-select select2 @error('alat_angkut_id') is-invalid @enderror">
							<option value="">Pilih Alat Angkut</option>
							@foreach ($alat_angkuts as $alat_angkut)
							<option value="{{ $alat_angkut->id }}" @selected(old('alat_angkut_id') == $alat_angkut->id)>
								{{ $alat_angkut->nama }}
							</option>
							@endforeach
						</select>
						@error('alat_angkut_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="kedudukan" class="form-label">Tempat Kedudukan</label>
						<select name="kedudukan" id="kedudukan" class="form-control form-select @error('kedudukan') is-invalid @enderror" disabled>
							<option value="Kota Serang">Kota Serang</option>
						</select>
						@error('kedudukan')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="jenis_perdin_id" class="form-label">Jenis Perdin</label>
						<select name="jenis_perdin_id" id="jenis_perdin_id" class="form-control form-select @error('jenis_perdin_id') is-invalid @enderror">
							<option value="">Pilih Jenis Perdin</option>
							@foreach ($jenis_perdins as $jenis_perdin)
							<option value="{{ $jenis_perdin->id }}" @selected(old('jenis_perdin_id') == $jenis_perdin->id)>
								{{ $jenis_perdin->nama }}
							</option>
							@endforeach
						</select>
						@error('jenis_perdin_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="tujuan_id" class="form-label">Tujuan</label>
						<select name="tujuan_id" id="tujuan_id" class="form-control form-select select2 @error('tujuan_id') is-invalid @enderror">
							<option value="">Pilih Tujuan</option>
						</select>
						@error('tujuan_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="lokasi">Lokasi</label>
						<textarea name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" placeholder="Masukan lokasi" rows="3">{{ old('lokasi') }}</textarea>
						@error('lokasi')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="pegawai_diperintah_id" class="form-label">Pegawai Yang Diperintahkan</label>
						<select name="pegawai_diperintah_id" id="pegawai_diperintah_id" class="form-control form-select select2 @error('pegawai_diperintah_id') is-invalid @enderror" disabled>
							<option value="">Pilih Pegawai Yang Diperintahkan</option>
							@foreach ($pegawais as $pegawai)
							<option value="{{ $pegawai->id }}" @selected(old('pegawai_diperintah_id') == $pegawai->id)>
								{{ $pegawai->nama }}
							</option>
							@endforeach
						</select>
						@error('pegawai_diperintah_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					
					<div class="form-group">
						<label for="pegawai_mengikuti_id" class="form-label">Pegawai Yang Mengikuti</label>
						<select name="pegawai" id="pegawai_mengikuti_id" class="form-control form-select select2 @error('pegawai_mengikuti_id') is-invalid @enderror" disabled>
							<option value="">Pilih Pegawai Yang Mengikuti</option>
							@foreach ($pegawais as $pegawai)
							<option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
							@endforeach
						</select>
						<input type="hidden" name="pegawai_mengikuti_id" id="selected_pegawais">
						
						@error('pegawai_mengikuti_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
						@enderror
					</div>
					
					<hr>
					<div class="table-responsive">
						<table class="table mg-b-0 text-md-nowrap">
							<thead>
								<tr>
									<th style="width: 1%">No</th>
									<th>Nama</th>
									<th>NIP</th>
									<th>Jabatan</th>
									<th>Uang Harian</th>
									<th>Keterangan</th>
									<th style="width: 1%">Aksi</th>
								</tr>
							</thead>
							<tbody id="pegawai-list"></tbody>
							<tfoot id="pegawai-total"></tfoot>
						</table>
					</div>
					<hr>
					
					<hr>
					
					<div class="form-group mb-0 mt-3 justify-content-end">
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn btn-secondary ms-3">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')
<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="ti-angle-double-up"></i></a>

<!-- JQuery min js -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>

<script>
	$(document).ready(function() {
		// Tanggal kembali otomatis
		function hitungTanggalKembali() {
			let tanggalBerangkat = new Date($('#tgl_berangkat').val());
			let lama = parseInt($('#lama').val());
			
			if (!isNaN(lama) && tanggalBerangkat instanceof Date && !isNaN(tanggalBerangkat.getTime())) {
				let tanggalKembali = new Date(tanggalBerangkat);
				tanggalKembali.setDate(tanggalKembali.getDate() + lama);
				let formattedDate = tanggalKembali.toISOString().split('T')[0];
				$('#tgl_kembali').val(formattedDate);
			} else {
				$('#tgl_kembali').val('');
			}
		}
		
		$('#lama').on('change', hitungTanggalKembali);
		$('#tgl_berangkat').on('input', hitungTanggalKembali);
		
		// Tujuan yang menyesuaikan wilayah
		$('#jenis_perdin_id').on('change', function() {
			let jenisPerdinId = $('#jenis_perdin_id').val();
			
			$('#tujuan_id').empty();
			$('#tujuan_id').append('<option value="">Pilih Tujuan</option>');
			
			$.ajax({
				url: '/get-tujuan/' + jenisPerdinId,
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					$.each(data, function(key, value) {
						$('#tujuan_id').append('<option value="' + value.id + '">' + value.nama + '</option>');
					});
				}
			});
		});
		
		
		// Pegawai disable
		$('#tujuan_id').on('change', function() {
			if ($('#tujuan_id').val() !== '') {
				$('#pegawai_diperintah_id').prop('disabled', false);
				$('#pegawai_mengikuti_id').prop('disabled', false);
			} else {
				$('#pegawai_diperintah_id').prop('disabled', true);
				$('#pegawai_mengikuti_id').prop('disabled', true);
			}
		});
		
		// Pilih pegawai
		let selectedPegawai = [];
		
		function addPegawaiDiperintah() {
			let pegawaiDiperintahSelect = $('#pegawai_diperintah_id');
			let selectedOption = pegawaiDiperintahSelect.find(':selected');
			let pegawaiId = selectedOption.val();
			let pegawaiNama = selectedOption.text();
			let tujuanId = $('#tujuan_id').val();
			
			selectedPegawai = selectedPegawai.filter(pegawai => pegawai.keterangan !== 'Pegawai yang ditugaskan');
			
			if (!selectedPegawai.find(pegawai => pegawai.id === pegawaiId)) {
				getPegawaiInfo(tujuanId, pegawaiId, function(dataPegawai) {
					selectedPegawai.push({
						id: pegawaiId,
						nama: pegawaiNama,
						nip: dataPegawai.nip,
						jabatan: dataPegawai.jabatan,
						uang_harian: dataPegawai.uang_harian,
						keterangan: 'Pegawai yang ditugaskan'
					});
					updatePegawaiList();
					updateSelectedPegawaiInput();
				});
			}
		}
		
		function addPegawaiToSelected() {
			let pegawaiSelect = $('#pegawai_mengikuti_id');
			let selectedOption = pegawaiSelect.find(':selected');
			let pegawaiId = selectedOption.val();
			let pegawaiNama = selectedOption.text();
			let tujuanId = $('#tujuan_id').val();
			
			if (!selectedPegawai.find(pegawai => pegawai.id === pegawaiId)) {
				getPegawaiInfo(tujuanId, pegawaiId, function(dataPegawai) {
					selectedPegawai.push({
						id: pegawaiId,
						nama: pegawaiNama,
						nip: dataPegawai.nip,
						jabatan: dataPegawai.jabatan,
						uang_harian: dataPegawai.uang_harian,
						keterangan: 'Pegawai sebagai pengikut'
					});
					updatePegawaiList();
					updateSelectedPegawaiInput();
					
					pegawaiSelect.val('');
				});
			} else {
				pegawaiSelect.val('');
			}
		}
		
		
		function getPegawaiInfo(tujuanId, pegawaiId, callback) {
			$.ajax({
				url: `/get-pegawai-info/${tujuanId}/${pegawaiId}`,
				success: function(data) {
					callback(data.data_pegawai);
				},
			});
		}
		
		
		function removePegawaiFromSelected(pegawaiId) {
			selectedPegawai = selectedPegawai.filter(pegawai => pegawai.id !== pegawaiId);
			updatePegawaiList();
			updateSelectedPegawaiInput();
		}
		
		function updateSelectedPegawaiInput() {
			let selectedPegawaiInput = $('#selected_pegawais');
			selectedPegawaiInput.val(selectedPegawai.map(pegawai => pegawai.id).join(','));
		}
		
		function updatePegawaiList() {
			let pegawaiList = $('#pegawai-list');
			pegawaiList.empty();
			
			selectedPegawai.forEach((pegawai, index) => {
				let row = `
				<tr>
					<td>${index + 1}</td>
					<td>${pegawai.nama}</td>
					<td>${pegawai.nip}</td>
					<td>${pegawai.jabatan}</td>
					<td>${formatToRupiah(pegawai.uang_harian)}</td>
					<td>${pegawai.keterangan}</td>
					<td>
						<button type="button" class="btn btn-danger btn-sm btn-hapus-pegawai" onclick="removePegawaiFromSelected('${pegawai.id}')">Hapus</button>
					</td>
				</tr>
				`;
				pegawaiList.append(row);
			});
			
			calculateTotal();
		}
		
		$('#pegawai_diperintah_id').on('change', addPegawaiDiperintah);
		$('#pegawai_mengikuti_id').on('change', addPegawaiToSelected);
		
		function resetSelectedEmployees() {
			$('#pegawai_diperintah_id').val('');
			$('#pegawai_mengikuti_id').val('');
			selectedPegawai = [];
			updatePegawaiList();
			updateSelectedPegawaiInput();
		}
		
		$('#jenis_perdin_id').on('change', function() {
			resetSelectedEmployees();
		});
		$('#tujuan_id').on('change', function() {
			resetSelectedEmployees();
		});
		
		function formatToRupiah(angka) {
			return new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR'
			}).format(angka);
		}
		
		function calculateTotal() {
			let totalUangHarian = 0;
			
			selectedPegawai.forEach(pegawai => {
				totalUangHarian += pegawai.uang_harian;
			});
			
			let tfootRow = `
			<tr>
				<th colspan="4">Total:</th>
				<td colspan="4">${formatToRupiah(totalUangHarian)}</td>
			</tr>
			`;
			
			$('#pegawai-total').html(tfootRow);
		}
	});
</script>

<!--Internal  Datepicker js -->
<script src="/assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

<!-- Bootstrap Bundle js -->
<script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Moment js -->
<script src="/assets/plugins/moment/moment.js"></script>

<!--Internal  jquery.maskedinput js -->
<script src="/assets/plugins/jquery.maskedinput/jquery.maskedinput.js"></script>

<!--Internal  spectrum-colorpicker js -->
<script src="/assets/plugins/spectrum-colorpicker/spectrum.js"></script>

<!-- Internal Select2.min js -->
<script src="/assets/plugins/select2/js/select2.min.js"></script>

<!--Internal Ion.rangeSlider.min js -->
<script src="/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

<!--Internal  jquery-simple-datetimepicker js -->
<script src="/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>

<!-- Ionicons js -->
<script src="/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js"></script>

<!--Internal  pickerjs js -->
<script src="/assets/plugins/pickerjs/picker.min.js"></script>

<!--internal color picker js-->
<script src="/assets/plugins/colorpicker/pickr.es5.min.js"></script>
<script src="/assets/js/colorpicker.js"></script>

<!--Bootstrap-datepicker js-->
<script src="/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<!-- Rating js-->
<script src="/assets/plugins/ratings-2/jquery.star-rating.js"></script>
<script src="/assets/plugins/ratings-2/star-rating.js"></script>

<!-- P-scroll js -->
<script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/assets/plugins/perfect-scrollbar/p-scroll.js"></script>

<!-- Sidebar js -->
<script src="/assets/plugins/side-menu/sidemenu.js"></script>

<!-- Right-sidebar js -->
<script src="/assets/plugins/sidebar/sidebar.js"></script>
<script src="/assets/plugins/sidebar/sidebar-custom.js"></script>

<!-- eva-icons js -->
<script src="/assets/js/eva-icons.min.js"></script>

<!-- Sticky js -->
<script src="/assets/js/sticky.js"></script>

<!--themecolor js-->
<script src="/assets/js/themecolor.js"></script>

<!-- custom js -->
<script src="/assets/js/custom.js"></script>

<!-- Internal form-elements js -->
<script src="/assets/js/form-elements.js"></script>
@endsection