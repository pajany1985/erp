<!DOCTYPE html>
<!--
Author: Idealtraits
Product Name: Idealtraits video Tool for Interview
Website: http://www.Idealtraits.com
Contact: support@Idealtraits.com
Follow: www.twitter.com/Idealtraits
Dribbble: www.dribbble.com/Idealtraits
Like: www.facebook.com/Idealtraits
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>Idealtraits |  @yield('pagetitle')</title>
		<meta charset="utf-8" />
		<meta name="description" content="Idealtraits video Tool for Interview" />
		<meta name="keywords" content="Idealtraits, ideal, interview, assessment, job, video assessment" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Idealtraits video Tool for Interview" />
		<meta property="og:url" content="https://idealtraits.com" />
		<meta property="og:site_name" content="Idealtraits | Interview" />
		<link rel="canonical" href="https://idealtraits.com" />
		<link rel="shortcut icon" href="{{asset('logo/favicon.ico')}}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{asset('css/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('css/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/cropper.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root text-center">
			<!--begin::Authentication - 404 Page-->
			<div class="d-flex flex-column flex-center flex-column-fluid p-10">
				<input type="hidden" id='paystatus' name="paystatus" value="{{ session()->get('paystatus') }}">
				@if (session()->get('paystatus') == '1')
				<!--begin::Illustration-->
				<h1 class="mw-100 mb-10  fs-1 fw-bolder mb-5" >Congratulations!</h1>
				<!--end::Illustration-->
				<!--begin::Message-->
				<div class="fw-bold fs-3 text-muted mb-15 ">Your account is currently being processed,this may take up to 5 seconds. </div>
                <i class=" text-muted fs-7">You will be redirected to login in <span id="timer">5</span>….</i>
				<!--end::Message-->
				<!--begin::Link-->
				<!-- <a href="/employer/login" class="btn btn-primary">Click to Login</a> -->
				<!--end::Link-->
				@else
				<input type='hidden' id='package_id' name='package_id' value="{{ session()->get('package_id') }}" />
				<h1 class="mw-100 mb-10  fs-1 fw-bolder mb-5" >Payment Failed!</h1>
				
				<div class="fw-bold fs-3 text-muted mb-15 ">Please Try again with valid details
						<br>It will take Up to 5 Seconds, </div>
                <i class=" text-muted fs-7">You will be redirected to registration in <span id="timer">5</span>….</i>

				@endif
			</div>
			<!--end::Authentication - 404 Page-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{asset('js/plugins.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>
        <script type="text/javascript">
            
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $(document).ready(function(){

			
				var counter = 5;
				var interval = setInterval(function() {
					counter--;
					// Display 'counter' wherever you want to display it.
					if (counter <= 0) {
					clearInterval(interval);  
						if($('#paystatus').val() == '1')
						window.location.replace('/employer/login');
					    else {
					    	// var package_id = $('#package_id').val();
					    	// window.location.replace('/employer/register/pid/' + package_id);
							window.history.back();
					    }
					}else{
						$('#timer').text(counter);
					}
				}, 1000);
				
			});
        </script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>