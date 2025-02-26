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
	<link href="{{asset('css/cropper.bundle.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<!-- <body id="kt_body"  class="page-bg header-fixed header-tablet-and-mobile-fixed aside-enabled"> -->
	<body id="kt_body" class=" page-bg header-fixed header-tablet-and-mobile-fixed " >
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" style="" class="header align-items-stretch">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between ">
							
							<!--begin::Mobile logo-->
							<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
								<a href="/employer" class="d-lg-none">
									<!-- <img alt="Logo" src="assets/media/logos/logo-2.svg" class="h-30px" /> -->
									<img alt="Logo" src="{{asset('logo/logo2.png')}}" class="d-lg-none h-25px" />

								</a>
							</div>
							<!--end::Mobile logo-->
							<!--begin::Wrapper-->
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
								<!--begin::Navbar-->
								<div class="d-flex align-items-stretch" id="kt_header_nav">
									<!--begin::Menu wrapper-->
									<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
										<!--begin::Menu-->
										<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" >
											<a href="/employer" class="menu-item here show menu-lg-down-accordion me-lg-1 position">
												<span class="menu-link py-3">
												<!-- 	<span class="menu-title">Positions</span>
													<span class="menu-arrow d-lg-none"></span> -->
												</span>
											</a>
										
										</div>
										<!--end::Menu-->
									</div>
									<!--end::Menu wrapper-->
								</div>
								<!--end::Navbar-->
								<!--begin::Header Logo-->
								<div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
									<a href="/employer">
										<img alt="Logo" src="{{asset('logo/logo.png')}}" class="d-none d-lg-block h-60px" />
									</a>
								</div>
								<!--end::Header Logo-->
								<!--begin::Toolbar wrapper-->
								<div class="d-flex align-items-stretch flex-shrink-0">
									<!--begin::Search-->
									<div class="d-flex align-items-stretch ms-1 ms-lg-3">
										<!--begin::Search-->
										
										<!--end::Search-->
									</div>
									<!--end::Search-->
									

									<!--end::User menu-->
									<!--begin::Header menu toggle-->
									<div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
										<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
											<!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
											<span class="svg-icon svg-icon-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor" />
													<path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</div>
									</div>
									<!--end::Header menu toggle-->
								</div>
								<!--end::Toolbar wrapper-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Container-->
					@yield('content')
					<!--end::Container-->

					<!--begin::Footer-->
					@include('employer::layouts.footer')
					<!--end::Footer-->

				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		<!--begin::Modals-->
		@yield('model')
		<!--end::Modals-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{asset('js/plugins.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>
		<script src="{{asset('js/jquery.validate.min.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="{{asset('js/datatables.bundle.js')}}"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script type="text/javascript">

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$(document).ready(function(){
				var url = $(location).attr("href");
				if(url.indexOf('settings') > -1){
					$('.position').removeClass('here show');
					$('.setting').addClass('here show');
				}

				$(document).on("click", ".emp_position_menulink", function(e) {
					$('.emp_position_menulink').removeClass('active');
					$(this).addClass('active');
				});
			});

		</script>
		@yield('scripts')
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
	</html>