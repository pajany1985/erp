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
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Two-stes -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" >
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="{{$candidate->employer->website}}" class="mb-12">
						{!! $employer_logo !!}
					</a>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                        <input type="hidden" name="position_id" id="position_id" value="{{$candidate->position_id}}">
                        <input type="hidden" name="employer_id" id="employer_id" value="{{$candidate->employer_id}}">
                        <input type="hidden" name="candidate_id" id="candidate_id" value="{{$candidate->id}}">

						<!--begin::Form-->
						<form class="form w-100 mb-10" novalidate="novalidate" data-kt-redirect-url="{{URL::to('/pid/'.encryptId($candidate->id))}}" id="kt_sing_in_two_steps_form">
							<!--begin::Icon-->
							<div class="text-center mb-10">
								<img alt="Logo" class="mh-125px" src="{{asset('media/svg/social-logos/delivered-mail-70.png')}}" />
							</div>
							<!--end::Icon-->
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">OTP Verification</h1>
								<!--end::Title-->
								<!--begin::Sub-title-->
								<div class="text-muted fw-bold fs-5 mb-5">Enter the verification code we sent to</div>
								<!--end::Sub-title-->
								<!--begin::Mobile no-->
								<div class="fw-bolder text-dark fs-3">{{$candidate->email}}</div>
								<!--end::Mobile no-->
							</div>
							<!--end::Heading-->
							<!--begin::Section-->
							<div class="mb-10 px-md-10">
								<!--begin::Label-->
								<div class="fw-bolder text-start text-dark fs-6 mb-1 ms-1">Type your 6 digit security code</div>
								<!--end::Label-->
								<!--begin::Input group-->
								<div class="d-flex flex-wrap flex-stack">
									<input type="text" id="box1" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" data-maxval="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2 otpclass" value="" onkeyup="move(event,'','box1','box2')" />
									<input type="text" id="box2" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" data-maxval="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2 otpclass" value="" onkeyup="move(event,'box1','box2','box3')" />
									<input type="text" id="box3" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" data-maxval="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2 otpclass" value="" onkeyup="move(event,'box2','box3','box4')" />
									<input type="text" id="box4" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" data-maxval="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2 otpclass" value="" onkeyup="move(event,'box3','box4','box5')" />
									<input type="text" id="box5" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" data-maxval="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2 otpclass" value="" onkeyup="move(event,'box4','box5','box6')" />
									<input type="text" id="box6" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" data-maxval="1" class="form-control form-control-solid h-60px w-60px fs-2qx text-center border-primary border-hover mx-1 my-2 otpclass" value="" onkeyup="move(event,'box5','box6','')" />
								</div>
								<!--begin::Input group-->
							</div>
							<!--end::Section-->
							<!--begin::Submit-->
							<div class="d-flex flex-center">
								<button type="button" id="kt_sing_in_two_steps_submit" class="btn btn-lg btn-primary fw-bolder">
									<span class="indicator-label">Submit</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
							<!--end::Submit-->
						</form>
						<!--end::Form-->
						<!--begin::Notice-->
						<div class="text-center fw-bold fs-5">
							<span class="text-muted me-1">Didn't get the code ?</span>
							<a href="javascript:void(0);" class="link-primary fw-bolder fs-5 me-1 resendotp">Resend</a>
							<!-- <span class="text-muted me-1">or</span> -->
							<!-- <a href="#" class="link-primary fw-bolder fs-5">Call Us</a> -->
						</div>
						<!--end::Notice-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->
					<div class="d-flex align-items-center fw-bold fs-6">
						<a href="https://keenthemes.com" class="text-muted text-hover-primary px-2">About</a>
						<a href="mailto:support@keenthemes.com" class="text-muted text-hover-primary px-2">Contact</a>
						<a href="https://1.envato.market/EA4JP" class="text-muted text-hover-primary px-2">Contact Us</a>
					</div>
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Two-stes-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{asset('js/plugins.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>
        <script src="{{asset('js/candidate/login/otp.js')}}"></script>
		<script>
			function move(e, p, c, n){
				var length = document.getElementById(c).value.length;
				//alert(length);
				var maxlength = document.getElementById(c).getAttribute("data-maxval");
				//alert(maxlength);
				if(length==maxlength){
					if(n !== ""){
						document.getElementById(n).focus();
					}
				}

				if(e.key === 'Backspace'){
					if(p !== ""){
						document.getElementById(p).focus();
					}
				}
			}
		</script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>