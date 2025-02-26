<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head>
    <title>Idealtraits</title>
		<meta charset="utf-8" />
		<meta name="description" content="Idealtraits video Tool for Interview" />
		<meta name="keywords" content="Idealtraits, ideal, interview, assessment, job, video assessment" />
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->
		<meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0, user-scalable=no"/>
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
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('css/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Signup Welcome Message -->
			<div class="d-flex flex-column flex-column-fluid">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
					
					<!--begin::Wrapper-->
					<div class="pt-lg-10 mb-10">
						<!--begin::Logo-->
						<h1 class="fw-bolder fs-2qx text-gray-800 mb-7">@if(isset($message)){{$message}} @else Position Not Available @endif</h1>
						<!--end::Logo-->
						<!--begin::Message-->
						<div class="fw-bold fs-3 text-muted mb-3">Sorry! @if(isset($message_text)){{$message_text}} @else This position is no longer accepting interviews.. @endif</div>
						<div class="fw-bold fs-3 text-muted mb-12">@if(isset($small_text)){{$small_text}}@endif</div>
						<!--end::Message-->
						<!--begin::Action-->
						<!--<div class="text-center">
							<a href="../../demo12/dist/index.html" class="btn btn-lg btn-primary fw-bolder">Go to homepage</a>
						</div>-->
						<!--end::Action-->
					</div>
					<!--end::Wrapper-->
					<!--begin::Illustration-->
					<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(/media/illustrations/sigma-1/17.png"></div>
					<!--end::Illustration-->
				</div>
				<!--end::Content-->
				
			</div>
			<!--end::Authentication - Signup Welcome Message-->
		</div>
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{asset('js/plugins.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>
		
		
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>