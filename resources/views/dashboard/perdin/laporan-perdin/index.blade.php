@extends('layouts.main')

@section('container')

<div class="row row-sm">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="d-flex align-items-center">
					<h3 class="card-title">{{ $title }}</h3>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table border-top-0 table-bordered text-nowrap border-bottom" id="responsive-datatable">
						<thead>
							<tr>
								<th class="border-bottom-0" style="width: 1%">No</th>
								<th class="border-bottom-0">Surat Dari</th>
								<th class="border-bottom-0">Tanggal Surat</th>
								<th class="border-bottom-0">Maksud</th>
								<th class="border-bottom-0">Petugas</th>
								<th class="border-bottom-0">Tanggal Berangkat</th>
								<th class="border-bottom-0" style="width: 1%">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($laporan_perdins as $laporan_perdin)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $laporan_perdin->data_perdin->surat_dari }}</td>
								<td>{{ $laporan_perdin->data_perdin->tgl_surat }}</td>
								<td>{{ $laporan_perdin->data_perdin->maksud }}</td>
								<td>{{ $laporan_perdin->data_perdin->pegawai_diperintah->nama }}</td>
								<td>{{ $laporan_perdin->data_perdin->tgl_berangkat }}</td>
								<td>
									<a class="modal-effect btn btn-primary btn-sm" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#lap-{{ $laporan_perdin->id }}">
										<i class="fas fa-folder"></i>
										View
									</a>
									<a class="modal-effect btn btn-info btn-sm" data-bs-effect="effect-scale" data-bs-toggle="modal" href="#lap-{{ $laporan_perdin->id }}">
										<i class="fas fa-pencil-alt"></i>
										Edit
									</a>
									<form action="{{ route('laporan-perdin.destroy', $laporan_perdin->id) }}" method="post" class="d-inline">
										@method('delete')
										@csrf
										<button class="btn btn-danger btn-sm" id='deleteData' data-title="{{ $laporan_perdin->nama }}">
											<i class="fas fa-trash"></i>
											Delete
										</button>
									</form>
								</td>
								@include('dashboard.perdin.status-perdin.lap_cetak')
								@include('dashboard.perdin.status-perdin.lap')
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')

<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

<!-- JQuery min js -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>

<!-- Sweet-alert js  -->
<script src="/assets/plugins/sweet-alert/sweetalert2.all.min.js"></script>

@if(session()->has('success'))
<script>
    $(document).ready(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    });
</script>
@endif

<script>
	$(document).ready(function() {
		$('#deleteData').click(function(e) {
			e.preventDefault();
			var title = $(this).data('title');
			
			Swal.fire({
				title: 'Hapus ' + title + '?',
				html: "Apakah kamu yakin ingin menghapus <b>" + title + "</b>? Data yang sudah dihapus tidak bisa dikembalikan!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					$(this).closest('form').submit();
				}
			});
		});
	});
</script>

<!-- Bootstrap Bundle js -->
<script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Moment js -->
<script src="/assets/plugins/moment/moment.js"></script>

<!-- P-scroll js -->
<script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/assets/plugins/perfect-scrollbar/p-scroll.js"></script>

<!-- Internal Select2.min js -->
<script src="/assets/plugins/select2/js/select2.min.js"></script>

<!-- DATA TABLE JS-->
<script src="/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
<script src="/assets/plugins/datatable/js/jszip.min.js"></script>
<script src="/assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
<script src="/assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
<script src="/assets/plugins/datatable/js/buttons.html5.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.print.min.js"></script>
<script src="/assets/plugins/datatable/js/buttons.colVis.min.js"></script>
<script src="/assets/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="/assets/plugins/datatable/responsive.bootstrap5.min.js"></script>

<!--Internal  Datatable js -->
<script src="/assets/js/table-data.js"></script>

<!-- Rating js-->
<script src="/assets/plugins/ratings-2/jquery.star-rating.js"></script>
<script src="/assets/plugins/ratings-2/star-rating.js"></script>

<!-- Sidebar js -->
<script src="/assets/plugins/side-menu/sidemenu.js"></script>

<!-- Right-sidebar js -->
<script src="/assets/plugins/sidebar/sidebar.js"></script>
<script src="/assets/plugins/sidebar/sidebar-custom.js"></script>

<!-- Sticky js -->
<script src="/assets/js/sticky.js"></script>

<!-- eva-icons js -->
<script src="/assets/js/eva-icons.min.js"></script>

<!--themecolor js-->
<script src="/assets/js/themecolor.js"></script>

<!-- custom js -->
<script src="/assets/js/custom.js"></script>

@endsection