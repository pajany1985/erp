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
	<title>Idealtraits | Career Page </title>
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
    @if(isset($career_setting->career_theme) && $career_setting->career_theme !='')
        <link href="{{asset('css/theme/'.$career_setting->career_theme.'.css')}}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{asset('css/theme/theme9.css')}}" rel="stylesheet" type="text/css" />
    @endif
    @php 
        $linkcolor = '#000000';
        if(isset($career_setting->link_color) && $career_setting->link_color !='')
            $linkcolor = '#'.$career_setting->link_color;
    @endphp
	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<!-- <body id="kt_body"  class="page-bg header-fixed header-tablet-and-mobile-fixed aside-enabled"> -->
	<body id="kt_body" class=" page-bg" >
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid theme_bg">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container border-radius-none">
                             <!--begin::Hero-->
                                <div class="position-relative">
                                    <!--begin::Overlay-->
                                    <div class="overlay overlay-show">
                                        <!--begin::Image-->
                                        <div class="bgi-no-repeat bgi-position-center bgi-size-cover min-h-350px" style="background-image:url({{$career_logourl}})"></div>
                                        <!--end::Image-->
                                        <!--begin::layer-->
                                        <div class="overlay-layer  bg-black" style="opacity: 0.4"></div>
                                        <!--end::layer-->
                                    </div>
                                    <!--end::Overlay-->
                                    <!--begin::Heading-->
                                    <!-- <div class="position-absolute text-white mb-8 ms-10 bottom-0">
                                        <h3 class="text-white fs-2qx fw-bolder mb-3 m">Careers</h3>                                        
                                        <div class="fs-5 fw-bold">You sit down. You stare at your screen. The cursor blinks.</div>
                                    </div> -->
                                    <!--end::Heading-->
                                </div>
                            <!--end::-->
                            <!--begin::Careers - List-->
                            <div class="card border-radius-none">
                                <!--begin::Body-->
                                <div class="card-body">
                                   
                                    <!--begin::Layout-->
                                    <div class="d-flex flex-column flex-lg-row">
                                        <!--begin::Content-->
                                        <!-- <div class="flex-lg-row-fluid me-0 me-lg-20"> -->
                                            <!--begin::Job-->
                                            <div class="mb-7">
                                                <!--begin::Description-->
                                                <div class="m-0 mb-5">
                                                    <!-- <h4 class="fs-1 text-gray-800 w-bolder mb-6">Junior React Developer</h4>
                                                    <p class="fw-bold fs-4 text-gray-600 mb-2">First, a disclaimer – the entire process of writing a blog post often takes more than a couple of hours, even if you can type eighty words as per minute and your writing skills are sharp.</p> -->
                                                    @if($employer->company_logo !='')
                                                        @if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).$employer->company_logo))
                                                        <img src="{{asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$employer->company_logo}}"  height="{{Config::get('constants.BUSINESS_IMAGES_HEIGHT')}}" width="{{Config::get('constants.BUSINESS_IMAGES_WIDTH')}}"  />
                                                        @else
                                                        <div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>{{$employer->company_name}}</h1></div>
                                                        @endif
                                                    @else
                                                    <div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>{{$employer->company_name}}</h1></div>
                                                    @endif

                                                </div>
                                                <!--end::Description-->
                                               
                                                 <!--begin::Careers about-->
                                                <div class="card bg-light m-0 div_bg">
                                                    <!--begin::Body-->
                                                    <div class="card-body">
                                                        <h4 class="fs-1 text-gray-800 w-bolder mb-6"><div class="text-dark">{{$employer->company_name}}</div></h4>
                                                        <p class="fw-bold fs-4 text-gray-600 mb-2">@if(isset($career_setting->company_description) && $career_setting->company_description != ''){!! html_entity_decode(str_replace('"', "'" ,trim($career_setting->company_description))) !!}@endif</p>
                                                    </div>
                                                    <!--end::Body-->
                                                </div>
                                                <!--end::Careers about-->
                                         
                                            </div>
                                            <!--end::Job-->
                                          
                                        <!-- </div> -->
                                        <!--end::Content-->
                                   
                                    </div>
                                    <!--end::Layout-->
                                    <!--begin::Section-->
                                    <div class="mb-10">
                                        <!--begin::Top-->
                                        <div class="text-start mb-7">
                                            <!--begin::Title-->
                                            <h3 class="fs-1 text-dark mb-5">Open Opportunities</h3>
                                            <!--end::Title-->
                                            <!--begin::Text-->
                                            <!-- <div class="fs-5 text-muted fw-bold">Our goal is to provide a complete and robust theme solution
                                            <br />to boost all of our customer’s project deployments</div> -->
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Top-->
                                        <!--begin::Row-->
                                        <div class="row g-10">
                                           @if(isset($positions) && ($positions->count()>0))
                                                @foreach($positions as $key => $position)
                                                    <div class="col-md-6">
                                                    <!--begin::Careers about-->
                                                        <div class="card bg-light m-0 div_bg">
                                                            <!--begin::Body-->
                                                            <div class="card-body">
                                                                <a href="{{URL::to('/pid/login/'.encryptId($position->id))}}" target="_blank" class="fs-5  fw-bolder mb-6 underlinetrue" style="color:{{$linkcolor}};">{{ucfirst($position->name)}}</a>
                                                                <!-- <p class="fw-bold fs-4 text-gray-600 mb-2">First, a disclaimer – the entire process of writing a blog post often takes more than a couple of hours, even if you can type eighty words as per minute and your writing skills are sharp.</p> -->
                                                            </div>
                                                            <!--end::Body-->
                                                        </div>
                                                        <!--end::Careers about-->
                                                    </div>
                                                @endforeach
                                            @endif
                                          
                                           
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Card-->
                                    <div class="card mb-4 bg-light text-center div_bg">
                                        <!--begin::Body-->
                                        <div class="card-body py-12">
                                                <!--begin::Icon-->
                                                <a href="@if(isset($career_setting->facebook_career_url) && $career_setting->facebook_career_url != ''){{$career_setting->facebook_career_url}} @else javascript:void(0);@endif" class="mx-2" @if(isset($career_setting->facebook_career_url) && $career_setting->facebook_career_url != '') target="_blank" @endif>
                                                    <img src="{{asset('media/svg/brand-logos/facebook-4.svg')}}" class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->
                                            
                                                <!--begin::Icon-->
                                                <a href="@if(isset($career_setting->instragram_career_url) && $career_setting->instragram_career_url != ''){{$career_setting->instragram_career_url}}@else javascript:void(0);@endif" class="mx-2" @if(isset($career_setting->instragram_career_url) && $career_setting->instragram_career_url != '') target="_blank" @endif>
                                                    <img src="{{asset('media/svg/brand-logos/instagram-2-1.svg')}}" class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->
                                            
                                                <!--begin::Icon-->
                                                <a href="@if(isset($career_setting->twitter_career_url) && $career_setting->twitter_career_url != ''){{$career_setting->twitter_career_url}}@else javascript:void(0);@endif" class="mx-2" @if(isset($career_setting->twitter_career_url) && $career_setting->twitter_career_url != '') target="_blank" @endif>
                                                    <img src="{{asset('media/svg/brand-logos/twitter.svg')}}" class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->
                                            
                                                <!--begin::Icon-->
                                                <a href="@if(isset($career_setting->linkedin_career_url) && $career_setting->linkedin_career_url != ''){{$career_setting->linkedin_career_url}}@else javascript:void(0);@endif" class="mx-2" @if(isset($career_setting->linkedin_career_url) && $career_setting->linkedin_career_url != '') target="_blank" @endif>
                                                    <img src="{{asset('media/svg/brand-logos/linkedin-2.svg')}}" class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Careers - List-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
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
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
	</html>