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
			<!--begin::Authentication - 404 Page-->
			<div class="d-flex flex-column flex-center flex-column-fluid p-10">
				<!--begin::Illustration-->
				<img src="{{asset('media/illustrations/sketchy-1/18-dark.png')}}" alt="" class="mw-100 mb-10 h-lg-450px" />
				<!--end::Illustration-->
				<!--begin::Message-->
				<h1 class="fw-bold mb-10" style="color: #A3A3C7">Seems there is nothing here</h1>
				<!--end::Message-->
				<!--begin::Link-->
				<!-- <a href="../../demo1/dist/index.html" class="btn btn-primary">Return Home</a> -->
				<!--end::Link-->
			</div>
			<!--end::Authentication - 404 Page-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{asset('js/plugins.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>