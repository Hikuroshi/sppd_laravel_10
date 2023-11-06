<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
	<meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="Keywords"
	content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4" />
	
	<!-- Title -->
	<title>SPPD | {{ $title }}</title>
	
	<!-- Favicon -->
	<link rel="icon" href="/assets/img/brand/favicon.png" type="image/x-icon" />
	
	<!-- Icons css -->
	<link href="/assets/css/icons.css" rel="stylesheet">
	
	<!-- Bootstrap css -->
	<link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- style css -->
	<link href="/assets/css/style.css" rel="stylesheet">
	
	<!--- Animations css-->
	<link href="/assets/css/animate.css" rel="stylesheet">
	
</head>

<body class="ltr error-page1 main-body bg-light text-dark error-3">
	
	
	<!-- Loader -->
	<div id="global-loader">
		<img src="/assets/img/loader.svg" class="loader-img" alt="Loader">
	</div>
	<!-- /Loader -->
	
	<!-- Page -->
	<div class="page">
		
		<div class="main-container container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="/assets/img/logo-banten.png"
							class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white py-4">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
										<div class="card-sigin">
											<div class="main-signup-header">
												<h2>Selamat Datang!</h2>
												<h5 class="fw-semibold mb-4">Silahkan masuk untuk melanjutkan.</h5>
												<form action="{{ route('login') }}" method="post">
													@csrf
													
													<div class="form-group">
														<label>Username</label> 
														<input name="username" class="form-control" placeholder="Masukan Username" type="text">
													</div>
													<div class="form-group">
														<label>Password</label>
														<input name="password" class="form-control" placeholder="Masukan Password" type="password">
													</div>
													<button class="btn btn-main-primary btn-block">
														Masuk
													</button>
													
												</form>
												<div class="main-signin-footer mt-4">
													<p><a href="">Lupa kata sandi?</a></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
		
	</div>
	<!-- End Page -->
	
	<!-- JQuery min js -->
	<script src="/assets/plugins/jquery/jquery.min.js"></script>
	
	<!-- Bootstrap Bundle js -->
	<script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
	<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Moment js -->
	<script src="/assets/plugins/moment/moment.js"></script>
	
	<!-- P-scroll js -->
	<script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	
	<!-- eva-icons js -->
	<script src="/assets/js/eva-icons.min.js"></script>
	
	<!-- Rating js-->
	<script src="/assets/plugins/ratings-2/jquery.star-rating.js"></script>
	<script src="/assets/plugins/ratings-2/star-rating.js"></script>
	
	<!--themecolor js-->
	<script src="/assets/js/themecolor.js"></script>
	
	<!-- custom js -->
	<script src="/assets/js/custom.js"></script>
	
	<script src="/assets/plugins/sweet-alert/sweetalert2.all.min.js"></script>

	@if(session()->has('loginError'))
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
            icon: 'error',
            title: '{{ session('loginError') }}'
        });
    });
	</script>
	@endif
	
</body>
</html>