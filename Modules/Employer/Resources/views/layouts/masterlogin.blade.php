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
	<title>Idealinterviews |  @yield('pagetitle')</title>
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
	<!--begin::Page Vendor Stylesheets(used by this page)-->
	<link href="{{asset('css/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Page Vendor Stylesheets-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="{{asset('css/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="bg-body">
	<!--begin::Main-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Authentication - Sign-in -->
		<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" >
			<!--begin::Content-->
			<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				<!--begin::Logo-->
				<a href="../../demo12/dist/index.html" class="mb-12">
					<img alt="Logo" src="{{asset('logo/logo.png')}}" class="h-80px" />
				</a>
				<!--end::Logo-->
				@if (session('error'))
				<!--begin::Alert-->
				<div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row px-3 py-1 mb-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column text-light pe-0 pe-sm-10 py-4">
						
						<!--begin::Content-->
						<span>{{ session('error') }}</span>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->

					<!--begin::Close-->
					<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
						<span class="svg-icon svg-icon-2x svg-icon-light">
							<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
						</span>
						
					</button>
					<!--end::Close-->
				</div>
				<!--end::Alert-->
				@elseif(session('warning'))
				<!--begin::Alert-->
				<div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row px-3 py-1 mb-10 align-items-center">
					<!--begin::Wrapper-->
					<div class="d-flex flex-column text-light fw-bolder pe-0 pe-sm-10 py-4">
						
						<!--begin::Content-->
						<span>{!! session('warning') !!}</span>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->

					<!--begin::Close-->
					<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
						<span class="svg-icon svg-icon-2x svg-icon-light">
							<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
						</span>
						
					</button>
					<!--end::Close-->
				</div>
				<!--end::Alert-->
				@endif	
				<!--begin::Wrapper-->
				@yield('content')
				<!--end::Wrapper-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Authentication - Sign-in-->
	</div>
	<!--end::Root-->
	<!--end::Main-->
	<!--begin::Javascript-->
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="{{asset('js/plugins.bundle.js')}}"></script>
	<script src="{{asset('js/scripts.bundle.js')}}"></script>
	<script src="{{asset('js/jquery.validate.min.js')}}"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Page Custom Javascript(used by this page)-->
	<!-- <script src="assets/js/custom/authentication/sign-in/general.js"></script> -->
	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
	@yield('scripts')

	<script>
		window.intercomSettings = {
			api_base: "https://api-iam.intercom.io",
			app_id: "py7w6cny"
		};
	</script>

	<script>
// We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/py7w6cny'
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/py7w6cny';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
</body>
<!--end::Body-->
</html>