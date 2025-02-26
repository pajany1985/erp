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
	<head><base href="../../../">
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
		<link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-up -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative" >
					<!--begin::Wrapper-->
					<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                            <!--begin::Wrapper-->
                            <div class="w-lg-600px p-10 p-lg-15 mx-auto">
                                <!--begin::Form-->
                                <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="post" action="/pid/register">
									@csrf
									<input type="hidden" name="position_id" id="position_id" value="{{$position->id}}">
									<input type="hidden" name="employer_id" id="employer_id" value="{{$position->employer->id}}">
									<input type="hidden" name="employer_website" id="employer_website" value="{{$position->employer->website}}">
                                    <!--begin::Heading-->
                                        <!--begin::Logo-->
                                        <div class=" text-center">
                                                <!-- <img alt="Logo" src="{{asset('logo/logo.png')}}" class="h-60px" /> -->
                                                @if($position->employer->company_logo !='')
													@if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).$position->employer->company_logo))
														<img src="{{asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$position->employer->company_logo}}"  height="{{Config::get('constants.BUSINESS_IMAGES_HEIGHT')}}"  data-url = '{{asset(Config::get("constants.BUSINESS_IMAGES_PATH"))."/".$position->employer->company_logo}}' class="h-60px" />
													@else
														<div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>{{ $position->employer->company_name }}</h1></div>
													@endif
												@else
														<div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>{{ $position->employer->company_name }}</h1></div>
														
												@endif  
                                        </div>
                                        <!--end::Logo-->
                                    
                                    <!--begin::Separator-->
                                    <div class="d-flex align-items-center mb-1">
                                    
                                    </div>
                                    <p class="fw-bolder fs-2qx pb-5 pb-md-0" >Hello!</p>
                                        <!--end::Title-->
                                        <!--begin::Description-->
                                        <p class=" fs-6" ><span class="fw-bold">{{ucfirst($position->employer->first_name)}}</span> from <span class="fw-bold">{{$position->employer->company_name}}</span> invited you to complete a video interview. <span class="fw-bold fs-6 text-primary">Enter Email below to get started!</span></p>
                                    <!--end::Separator-->
                                    <!--begin::Input group-->
                                    <!-- <div class="fv-row mb-7"> -->
                                        <!-- <label class="form-label fw-bolder text-dark fs-6">Full Name</label> -->
                                        <!-- <input class="form-control form-control-lg " type="text" placeholder="Enter your Full Name" id="name" name="name" autocomplete="off" /> -->
                                    <!-- </div> -->
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!-- <label class="form-label fw-bolder text-dark fs-6">Email</label> -->
                                        <input class="form-control form-control-lg " type="email" placeholder="Enter your Email" id="email" name="email" autocomplete="off" />
                                    </div>
                                    <!--end::Input group-->
                                    
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-10">
                                        <label class="form-check form-check-custom form-check-solid form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="toc" name="toc" value="1" />
                                            <span class="form-check-label fw-bold text-gray-700 fs-6">I Agree
                                            <a href="https://dashboard.idealtraits.com/navigation/index/page/Terms_of_Use"  target="_blank" class="ms-1 link-primary">Terms and conditions</a>.</span>
                                        </label>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                                <!--end::Form-->
								<form class="form w-100" novalidate="novalidate" id="sendotp" method="post" action="/otpverify">
									@csrf
									<input type="hidden" name="otpposition_id" id="otpposition_id" value="{{$position->id}}">
									<input type="hidden" name="otpemployer_id" id="otpemployer_id" value="{{$position->employer->id}}">
									<input type="hidden" name="otpemail_id" id="otpemail_id" value="">
								</form>
                            </div>
                            <!--end::Wrapper-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid py-7 " id="loginbackground" style="background-image: url({{asset('logo/bg-4.jpg')}});">
					<!--begin::Content-->
					<div class="d-flex flex-center flex-column flex-column-fluid">
						<!--begin::Content-->
						<!-- flex-row-fluid -->
						<div class="d-flex  flex-column text-center p-20 pt-lg-5 d-none d-md-block">
						</div>
						<div class="d-flex  flex-column text-center pt-lg-20">
							@if($isvideo=='1')
							<!-- <video id="upload_videotag" src="{{$video}}" controls style="height:75%;">
								Your browser does not support the video tag.
							</video> -->
							<iframe class="d-none d-md-block" width="500" height="300" src="{{$video}}" title="video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
								
							</iframe>
							<iframe class="d-md-none d-lg-none  d-sm-block" height="200"  src="{{$video}}" title="video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
								
							</iframe>
							@else
								<?php //echo $video;?>
								<video src="{{$video}}#t=0.001" controls  class="d-none d-md-block" width="500" height="300"> </video>
								<video src="{{$video}}#t=0.001" controls  class="d-md-none d-lg-none  d-sm-block" height="200"> </video>
							@endif
						
						</div>
						<!--end::Content-->
					
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
						<div class="d-flex  flex-wrap fs-6 p-5 pb-0" >
							<!--begin::Container-->
							<div class="container-fluid d-flex flex-column align-items-center justify-content-between">
								<!--begin::Copyright-->
								<div class="text-gray-100 order-2 order-md-1">
									<span class="text-gray-100 fw-bold me-1">2022©</span>
									<a href="https://idealtraits.com" target="_blank" class="text-gray-100 ">IdealTraits</a>
								</div>
								<!--end::Copyright-->
							</div>
							<!--end::Container-->
						</div>
					<!--end::Footer-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-up-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{asset('js/plugins.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>
		<script src="{{asset('js/candidate/login/login.js')}}"></script>
		<script type="text/javascript">
            
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

			
        </script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>