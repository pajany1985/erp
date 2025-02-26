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
	<link href="{{asset('css/coloris.css')}}" rel="stylesheet" type="text/css" > 
	<link href="{{asset('css/custom.css')}}?version={{rand()}}" rel="stylesheet" type="text/css" />
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
											<a href="/employer" class="menu-item here show menu-lg-down-accordion me-lg-1 position" id="position">
												<span class="menu-link py-3">
													<span class="menu-title">Interviews</span>
													<span class="menu-arrow d-lg-none"></span>
												</span>
											</a>
											@if(auth()->user()->master_empid=='')
											<!-- <a href="/employer/settings" class="menu-item menu-lg-down-accordion me-lg-1 setting">
												<span class="menu-link py-3">
													<span class="menu-title">Settings</span>
													<span class="menu-arrow d-lg-none"></span>
												</span>
											</a> -->
											@endif
											<a href="/employer/candidates"   class="menu-item menu-lg-down-accordion me-lg-1 custom_menu" id="candidates">
												<span class="menu-link py-3">
													<span class="menu-title">Candidates</span>
													<span class="menu-arrow d-lg-none"></span>
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
									<!--begin::Notifications-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Menu- wrapper-->
										<div class="d-flex align-items-center ms-1 ms-lg-3 @if($storagedetails['used_percentage']>='80') text-danger @else text-success @endif  btn btn-sm btn-active-light " data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<span>{{$storagedetails['useddisk_space']}} of {{$storagedetails['totalspace']}} GB used <br>
												<progress class=" @if($storagedetails['used_percentage']>='80') text-ascentdanger @else text-ascentsuccess @endif" id="file" value="{{$storagedetails['used_percentage']}}"  min="0" max="100">{{$storagedetails['used_percentage']}}%</progress>
											</span>
										</div>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
											<!--begin::Tab content-->
											<div class="tab-content">
												<!--begin::Tab panel-->
												<div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
													<!--begin::Wrapper-->
													<div class="d-flex flex-column px-9">
														<!--begin::Section-->
														<div class="pt-10 pb-0">
															<!--begin::Title-->
															<!-- <h3 class="text-dark text-center">Date From : <span class="text-dark fw-bolder">{{$viewemployer->created_at}}</span></h3> -->
															<!--end::Title-->
															<!--begin::Action-->
															<!-- <div class="text-center mt-5 mb-9">
															</div> -->
															<!--end::Action-->
														</div>
														<!--end::Section-->
														
														<!--begin::Item-->
														<div class="d-flex align-items-center bg-light-warning rounded p-5 mb-7">
															<!--begin::Icon-->
															<span class="svg-icon svg-icon-warning me-5">
																<!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
																		<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</span>
															<!--end::Icon-->
															<!--begin::Title-->
															<div class="flex-grow-1 me-2">
																<span class="fw-bolder text-gray-800 fs-6">Total Videos</span>
																<span class="text-muted fw-bold d-block"></span>
															</div>
															<!--end::Title-->
															<!--begin::Lable-->
															<span class="fw-bolder text-warning py-1">{{$storagedetails['videocount']}}</span>
															<!--end::Lable-->
														</div>
														<!--end::Item-->

														<!--begin::Item-->
														<div class="d-flex align-items-center bg-light-info rounded p-5 mb-7">
															<!--begin::Icon-->
															<span class="svg-icon svg-icon-info me-5">
																<!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
																		<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</span>
															<!--end::Icon-->
															<!--begin::Title-->
															<div class="flex-grow-1 me-2">
																<span class="fw-bolder text-gray-800 fs-6">Total Space</span>
																<span class="text-muted fw-bold d-block"></span>
															</div>
															<!--end::Title-->
															<!--begin::Lable-->
															<span class="fw-bolder text-info py-1">{{$storagedetails['totalspace']}} GB</span>
															<!--end::Lable-->
														</div>
														<!--end::Item-->

														<!--begin::Item-->
														<div class="d-flex align-items-center @if($storagedetails['used_percentage']>='80') bg-light-danger @else bg-light-success @endif  rounded p-5 mb-7">
															<!--begin::Icon-->
															<span class="svg-icon @if($storagedetails['used_percentage']>='80') svg-icon-danger @else svg-icon-success @endif  me-5">
																<!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
																		<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</span>
															<!--end::Icon-->
															<!--begin::Title-->
															<div class="flex-grow-1 me-2">
																<span class="fw-bolder text-gray-800 fs-6">Used Space</span>
																<span class="text-muted fw-bold d-block"></span>
															</div>
															<!--end::Title-->
															<!--begin::Lable-->
															<span class="fw-bolder @if($storagedetails['used_percentage']>='80') text-danger @else text-success @endif  py-1">{{$storagedetails['useddisk_space']}}</span>
															<!--end::Lable-->
														</div>
														<!--end::Item-->

														<!--begin::Item-->
														<div class="d-flex align-items-center @if($storagedetails['used_percentage']>='80') bg-light-danger @else bg-light-success @endif rounded p-5 mb-7">
															<!--begin::Icon-->
															<span class="svg-icon @if($storagedetails['used_percentage']>='80') svg-icon-danger @else svg-icon-success @endif me-5">
																<!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
																		<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</span>
															<!--end::Icon-->
															<!--begin::Title-->
															<div class="flex-grow-1 me-2">
																<span class="fw-bolder text-gray-800 fs-6">Remaining Space</span>
																<span class="text-muted fw-bold d-block"></span>
															</div>
															<!--end::Title-->
															<!--begin::Lable-->
															<span class="fw-bolder @if($storagedetails['used_percentage']>='80') text-danger @else text-success @endif py-1">{{$storagedetails['diskremaining']}}</span>
															<!--end::Lable-->
														</div>
														<!--end::Item-->

														<!--begin::Item-->
														<div class="d-flex align-items-center @if($storagedetails['used_percentage']>='80') bg-light-danger @else bg-light-success @endif rounded p-5 mb-7">
															<!--begin::Icon-->
															<span class="svg-icon @if($storagedetails['used_percentage']>='80') svg-icon-danger @else svg-icon-success @endif me-5">
																<!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
																		<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</span>
															<!--end::Icon-->
															<!--begin::Title-->
															<div class="flex-grow-1 me-2">
																<span class="fw-bolder text-gray-800 fs-6">Used Percentage</span>
																<span class="text-muted fw-bold d-block"></span>
															</div>
															<!--end::Title-->
															<!--begin::Lable-->
															<span class="fw-bolder @if($storagedetails['used_percentage']>='80') text-danger @else text-success @endif py-1">{{$storagedetails['used_percentage']}}%</span>
															<!--end::Lable-->
														</div>
														<!--end::Item-->

														<!--begin::Item-->
														<div class="d-flex align-items-center bg-light-primary rounded p-5 mb-7">
															<!--begin::Icon-->
															<span class="svg-icon svg-icon-primary me-5">
																<!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
																<span class="svg-icon svg-icon-1">
																	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																		<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
																		<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
																	</svg>
																</span>
																<!--end::Svg Icon-->
															</span>
															<!--end::Icon-->
															<!--begin::Title-->
															<div class="flex-grow-1 me-2">
																<span class="fw-bolder text-gray-800 fs-6">Total Duration</span>
																<span class=" fw-bold d-block text-muted"></span>
															</div>
															<!--end::Title-->
															<!--begin::Lable-->
															<span class="fw-bolder text-primary py-1">{{$storagedetails['duration']}}</span>
															<!--end::Lable-->
														</div>
														<!--end::Item-->

													</div>
													<!--end::Wrapper-->
												</div>
												<!--end::Tab panel-->
											</div>
											<!--end::Tab content-->
										</div>
										<!--end::Menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::Notifications-->

									<!--begin::Quick links-->
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<!--begin::Menu wrapper-->
										<div class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
											<span class="svg-icon svg-icon-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
													<path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
													<path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
												</svg>
											</span>
											<!--end::Svg Icon-->
										</div>
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
											<!--begin::Heading-->
											<div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10" >
												@if(auth()->user()->company_logo !='')
												@if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).auth()->user()->company_logo))
												<img src="{{asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.auth()->user()->company_logo}}"  height="{{Config::get('constants.BUSINESS_IMAGES_HEIGHT')}}" width="{{Config::get('constants.BUSINESS_IMAGES_WIDTH')}}"  />
												@else
												<div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>{{auth()->user()->company_name}}</h1></div>
												@endif
												@else
												<div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>{{auth()->user()->company_name}}</h1></div>
												@endif 
												<!-- <img alt="Pic" src="{{asset('media/misc/pattern-1.jpg')}}" height="73"> -->
											</div>
											<!--end::Heading-->
											<!--begin:Nav-->
											<div class="row g-0">
												
												<!--begin::Menu-->
												<div class="menu menu-column  menu-title-gray-800 menu-state-bg fw-bold menu-active-primary menu-hover-primary menu-icon-primary" data-kt-menu="true">

													<!--begin::Menu item-->
													<div class="menu-item mb-5">
														<a href="/employer/accountsetting" class="menu-link py-3  ">
															<span class="menu-icon svg-icon svg-icon-1">
																<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#0086FF"><g><path d="M0,0h24v24H0V0z" fill="none"/><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></g></svg>
															</span>
															<div class="flex-grow-1">
																<span class="menu-title">Account Settings</span>
																<span class="text-muted d-block fw-bold">Login, Password & upgrade settings</span>
															</div>
															<span class="menu-arrow"></span>
														</a>
													</div>
													<!--end::Menu item-->

													<!--begin::Menu item-->
													<div class="menu-item mb-5">
														<a href="/employer/companysetting" class="menu-link py-3  ">
															<span class="menu-icon svg-icon svg-icon-1">
																<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#0086FF"><path d="M0 0h24v24H0z" fill="none"></path><path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"></path></svg>
															</span>
															<div class="flex-grow-1">
																<span class="menu-title">Company Settings</span>
																<span class="text-muted d-block fw-bold">Company name, address, logo, etc.</span>
															</div>
															<span class="menu-arrow"></span>
														</a>
													</div>
													<!--end::Menu item-->

													<!--begin::Menu item-->
													<div class="menu-item mb-5">
														<a href="/employer/manageusers" class="menu-link py-3  ">
															<span class="menu-icon svg-icon svg-icon-1">
																<svg fill="#0086FF" xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M1 20v-2.8q0-.85.438-1.563.437-.712 1.162-1.087 1.55-.775 3.15-1.163Q7.35 13 9 13t3.25.387q1.6.388 3.15 1.163.725.375 1.162 1.087Q17 16.35 17 17.2V20Zm18 0v-3q0-1.1-.612-2.113-.613-1.012-1.738-1.737 1.275.15 2.4.512 1.125.363 2.1.888.9.5 1.375 1.112Q23 16.275 23 17v3ZM9 12q-1.65 0-2.825-1.175Q5 9.65 5 8q0-1.65 1.175-2.825Q7.35 4 9 4q1.65 0 2.825 1.175Q13 6.35 13 8q0 1.65-1.175 2.825Q10.65 12 9 12Zm10-4q0 1.65-1.175 2.825Q16.65 12 15 12q-.275 0-.7-.062-.425-.063-.7-.138.675-.8 1.037-1.775Q15 9.05 15 8q0-1.05-.363-2.025Q14.275 5 13.6 4.2q.35-.125.7-.163Q14.65 4 15 4q1.65 0 2.825 1.175Q19 6.35 19 8ZM3 18h12v-.8q0-.275-.137-.5-.138-.225-.363-.35-1.35-.675-2.725-1.013Q10.4 15 9 15t-2.775.337Q4.85 15.675 3.5 16.35q-.225.125-.362.35-.138.225-.138.5Zm6-8q.825 0 1.413-.588Q11 8.825 11 8t-.587-1.412Q9.825 6 9 6q-.825 0-1.412.588Q7 7.175 7 8t.588 1.412Q8.175 10 9 10Zm0 8ZM9 8Z"/></svg>
															</span>
															<div class="flex-grow-1">
																<span class="menu-title">Manage Users</span>
																<span class="text-muted d-block fw-bold">Add & view users in your account</span>
															</div>
															<span class="menu-arrow"></span>
														</a>
													</div>
													<!--end::Menu item-->

													<!--begin::Menu item-->
													<div class="menu-item mb-5">
														<a href="/employer/careersetting" class="menu-link py-3  ">
															<span class="menu-icon svg-icon svg-icon-1">
																<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#0086FF"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 3h8v8H3zm10 0h8v8h-8zM3 13h8v8H3zm15 0h-2v3h-3v2h3v3h2v-3h3v-2h-3z"/></svg>
															</span>
															<div class="flex-grow-1">
																<span class="menu-title">Manage Career Page</span>
																<span class="text-muted d-block fw-bold">Customize Career Page Settings</span>
															</div>
															<span class="menu-arrow"></span>
														</a>
													</div>
													<!--end::Menu item-->

													<!--begin::View more-->
													<div class="d-flex justify-content-between py-2 border-top">

														
														<div class="d-flex flex-stack flex-wrap flex-grow-1 px-3 pt-2 pb-3">
															<div class="me-2">
																<a href="/employer/logout" class="btn btn-light btn-active-light-primary">Sign Out</a>
															</div>
															@if(auth()->user()->master_empid=='')
															<!-- <a href="/employer/settings/upgradepackage" class="btn btn btn-primary" >
																Upgrade Plan
															</a> -->
															@endif
														</div>
													</div>
													
													<!--end::View more-->
												</div>
												<!--end::Menu-->  
											</div>
											<!--end:Nav-->
											
										</div>
										<!--end::Menu-->
										<!--end::Menu wrapper-->
									</div>
									<!--end::Quick links-->

									<!--begin::User menu-->
									<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
										<!--begin::Menu wrapper-->
										<div class="cursor-pointer symbol symbol-30px symbol-md-40px color-D6E" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											Hi, {{ucfirst(auth()->user()->first_name)}}
										</div>
										
										<!--end::Menu wrapper-->
									</div>
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

		<div class="modal fade" tabindex="-1" id="emp_expiremdl" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered mw-550px">
				<div class="modal-content">
					<div class="modal-header pb-2">
						<h5 class="modal-title">Expired</h5>
						
						<a href="/employer/logout" class="btn btn-light btn-active-light-primary">Sign Out</a>
						
					</div>

					<div class="modal-body">
							<div class="text-center mb-13">
								<h1 class="mb-10">Welcome back {{ucfirst(auth()->user()->first_name)}},</h1>
								<div class="text-muted fw-bold fs-5">You're subscription has expired, please contact <br> salesmanager@idealtraits.com to discuss your renewal <br>options.</div>
							</div>
							<div class="text-center text-muted fw-bold fs-7">After renewing, you will gain immediate access to create and send interviews.</div>
					</div>
				</div>
			</div>
		</div>

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
				if(url.indexOf('candidates') > -1){
					$('#position').removeClass('here show');
					$('#candidates').addClass('here show');
				}else{
					
					$('#candidates').removeClass('here show');
					$('#position').addClass('here show');
				}

				$(document).on("click", ".emp_position_menulink", function(e) {
					$('.emp_position_menulink').removeClass('active');
					$(this).addClass('active');
				});

				<?php
					if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
						$ip = $_SERVER['HTTP_CLIENT_IP'];  
						}  
					elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
						$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
					}  
					else{  
						$ip = $_SERVER['REMOTE_ADDR'];  
					} 

				if($ip != '103.8.117.128' && $ip != '192.168.0.121' && $ip != '192.168.0.144'  && $ip !='127.0.0.1' && $ip !='127.0.1.1'){
				?>
					$(document).bind("contextmenu",function(e) {
						e.preventDefault();
					});
					$(document).keydown(function(e){
						if(e.which === 123){
							return false;
						}
					});
				<?php
				}
				?>

				<?php
				if(Auth::user()->payment_status=='3'){
				?>
					$('#emp_expiremdl').modal({backdrop:'static', keyboard:false});
					$('#emp_expiremdl').modal('show');

					
					$('#emp_expiremdl').on('hidden.bs.modal', function () 
					{
						window.location.replace('/employer/logout') ; 
					})
				<?php
				}
				?>
			});

		</script>
		<?php if(auth()->user()->master_empid=='') {

			?>
		<script>
			window.intercomSettings = {
				api_base: "https://api-iam.intercom.io",
				app_id: "py7w6cny",
    			name: <?php echo json_encode(auth()->user()->first_name.' '.auth()->user()->last_name) ?>, // Full name
    			email: <?php echo json_encode(auth()->user()->email) ?>, // Email address
                created_at: "<?php echo strtotime(auth()->user()->created_at) ?>", // Signup date
                phone: <?php echo json_encode(auth()->user()->phone_no) ?>,
                user_id: '<?php echo auth()->user()->id ?>',
                address: '<?php echo auth()->user()->address ?>',
                city: '<?php echo auth()->user()->city ?>',
                zip: '<?php echo auth()->user()->zip ?>',
                active_position : '<?php echo $intercom_arr["no_active_position"] ?>',
                active_candidate : '<?php echo $intercom_arr["no_active_candidates"] ?>'
};
</script>

<script>
// We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/py7w6cny'
(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/py7w6cny';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<?php } ?>
@yield('scripts')
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>