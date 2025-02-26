@extends('employer::layouts.master')
@section('pagetitle','Manage Settings')

@section('content')
@if(auth()->user()->master_empid=='')
    <input type="hidden" value="{{$authuser_id}}" name="authuser" id="authuser">
   
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">

            @if (session('success'))
                <!--begin::Alert-->
                    <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row px-3 py-1 mb-10">
                        <div class="d-flex flex-column text-light pe-0 pe-sm-10 py-4">
                            <span>{{ session('success') }}</span>
                        </div>

                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                            <span class="svg-icon svg-icon-2x svg-icon-light">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                            </span>
                            
                        </button>
                    </div>
                <!--end::Alert-->

            @elseif(session('error'))
                <!--begin::Alert-->
                <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row px-3 py-1 mb-10">
                    <div class="d-flex flex-column text-light pe-0 pe-sm-10 py-4">
                        <span>{{ session('error') }}</span>
                    </div>

                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <span class="svg-icon svg-icon-2x svg-icon-light">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                        </span>
                        
                    </button>
                </div>
                <!--end::Alert-->
            @endif
            
             <div id="kt_toolbar_container" class="d-flex flex-stack flex-wrap m-5">
        <div class="page-title d-flex  flex-row align-items-start ">
            <!--begin::Title-->
           

             <!--begin::Title-->
                    <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">Company Settings</h1>
                            <span class="h-20px border-gray-300 border-start mx-3 my-1"></span>
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 p-1 mx-0">
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="{{ route('position') }}" class="text-muted text-hover-primary">Home</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                        </li>
                                        <li class="breadcrumb-item text-muted"><a href="" class="text-muted text-hover-primary">Settings</a></li>
                                         <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                        </li>
                                        <li class="breadcrumb-item text-dark">Company Settings</li>
                                        <!--end::Item-->
                        </ul>                 
                  

                    <!--end::Title-->

            <!--end::Title-->
        </div>
    </div>
            <!--begin::Row-->
                    <div class="card mb-5 mb-xl-10  ">
                            <div class="card-header">
                                
                                <h3 class="card-title">
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#0086FF"><path d="M0 0h24v24H0z" fill="none"></path><path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"></path></svg>                                    </span>
                                    <span class="px-2">
                                    Company Settings
                                    <span>
                                </h3>
                                
                            </div>
                        <!--begin::Form-->
                            <form id="kt_company_setting_form" class="form" method="post" action="settings/companysetting" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Card body-->
                                <div class="card-body  p-9">
                                    <!--begin::Input group-->
                                    <div class="row mb-6">
                                        <label class="col-lg-4 text-end col-form-label required fw-bold fs-6">Company Name</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-8 fv-row">
                                                    <div class="input-group ">
                                                        <span class="input-group-text">
                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                            <span class="svg-icon ">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                                                    <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        <input type="text" name="company_name" id="company_name" class="form-control form-control-lg  " placeholder="Company name" value="{{$employer->company_name}}" />
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-6">
                                        <label class="col-lg-4 text-end col-form-label required fw-bold fs-6">Website</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-8 fv-row">
                                                    <div class="input-group ">
                                                        <span class="input-group-text">
                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                            <span class="svg-icon ">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16">
                                                                    <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"></path>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                        <input type="text" name="website" id="website" class="form-control form-control-lg  " placeholder="https://www.example.com" value="{{$employer->website}}" />
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-6">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 text-end col-form-label  fw-bold fs-6">Company Logo</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <div class="row mb-3">
                                                        <div class="fileUpload" style="overflow:inherit; display:inline-block;">
                                                    
                                                            <input type="file"  id="business_logo" class="upload" name="business_logo" hidden accept="image/*"/>
                                                            <input type="hidden" id="logofile" name="logofile">
                                                            <label for="business_logo" type="button"  class=" imglibrary btn btn-primary" ><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/></svg>&nbsp;Choose File</label>
                                                    
                                                        </div>  
                                                    </div>
                                                    <div class="pl-7 border " style="width:fit-content;">
                                                    
                                                        <div  id="" class="kt-avatar p-3" >
                                                            <!-- <a class="kt-avatar__upload del_link" style="background-color: #591df1;"  onclick="deleteimage('1')" data-toggle="kt-tooltip" title="" data-original-title="Remove Image">
                                                                <i class="fa fa-trash-alt " style="color: #ffffff;"></i>
                                                            </a> -->
                                                            <div class="upl_image p-4 border rounded border-primary border-dashed" id="business_logo_preview1" style="width:fit-content;">
                                                            @if($employer->company_logo !='')
                                                                @if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).$employer->company_logo))
                                                                    <img src="{{asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$employer->company_logo}}"  height="{{Config::get('constants.BUSINESS_IMAGES_HEIGHT')}}" width="{{Config::get('constants.BUSINESS_IMAGES_WIDTH')}}" data-url = '{{asset(Config::get("constants.BUSINESS_IMAGES_PATH"))."/".$employer->company_logo}}' class="open_image" />
                                                                @else
                                                                    <img src="{{asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/blank.png'}}"  height="{{Config::get('constants.BUSINESS_IMAGES_HEIGHT')}}" width="{{Config::get('constants.BUSINESS_IMAGES_WIDTH')}}" data-url ='{{asset(Config::get("constants.BUSINESS_IMAGES_PATH"))."/blank.png"}}' class="open_image" />
                                                                @endif
                                                            @else
                                                                    <div class="text-center kt-font-bold "><h5 class="color-D6E">Upload your Logo</h5></div>
                                                                    <div class="text-center">
                                                                        <!-- <small>Tip: for display purposes upload a landscape style </br>
                                                                    logo (width > height) that is 269 px by 73 px</small> -->
                                                                    </div>
                                                            @endif   
                                                            </div>
                                                            
                                                        </div>
                                                    
                                                        <div class="text-end p-1" id="editorremove">    
                                                            
                                                        @if($employer->company_logo !='')
                                                            <a  class="imgremovelink editimage" data-toggle="kt-tooltip" title="" data-original-title="Edit Image" ><svg class="kt-font-brandideal " fill="currentColor" width="18px" viewBox="0 0 24 24" height="18px" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></a>
                                                            <a class="imgremovelink deletelogoimage" data-toggle="kt-tooltip" title="" data-original-title="Remove Image" ><svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-font-brandideal " fill="currentColor" height="18" width="18" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                                                </svg>
                                                            </a>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <input type="hidden" name="videoorurl" id="videoorurl"
                                    @if($employer->company_video!='') value="video" @elseif($employer->embedded_url!='') value="embedded_url" @else value="empty" @endif/>
                                    <div class="row mb-6">
                                        <label class="col-lg-4 text-end col-form-label required fw-bold fs-6">Welcome Video</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-8 fv-row">
                                                    <div class="fv-row mb-3">
                                                        <!--begin::Radio group-->
                                                        <div data-kt-buttons="true">
                                                            <!--begin::Radio button-->
                                                            <label class="btn btn-outline btn-outline-dashed   text-start p-3 mb-5">
                                                                <!--end::Description-->
                                                                <div class="d-flex align-items-center me-2">
                                                                    <!--begin::Radio-->
                                                                    <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                                        <input class="form-check-input welcomeradio" type="radio" name="welcome_radio" @if($employer->company_video!=''|| $employer->embedded_url=='') checked="checked" @endif  value="upload"/>
                                                                    </div>
                                                                    <!--end::Radio-->

                                                                    <!--begin::Info-->
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex align-items-center  fw-bolder flex-wrap color-D6E">
                                                                            Upload Video
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Info-->
                                                                </div>
                                                                <!--end::Description-->
                                                            </label>
                                                            <!--end::Radio button-->

                                                            <!--begin::Radio button-->
                                                            <label class="btn btn-outline btn-outline-dashed  text-start p-3 mb-5 ">
                                                                <!--end::Description-->
                                                                <div class="d-flex align-items-center me-2">
                                                                    <!--begin::Radio-->
                                                                    <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                                        <input class="form-check-input welcomeradio" type="radio" name="welcome_radio"  @if($employer->embedded_url!='') checked="checked" @endif  value="url"/>
                                                                    </div>
                                                                    <!--end::Radio-->

                                                                    <!--begin::Info-->
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex align-items-center  fw-bolder flex-wrap color-D6E">
                                                                        Video Url Or Embedded Url 
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    <!--end::Info-->
                                                                </div>
                                                                <!--end::Description-->
                                                            </label>
                                                            <!--end::Radio button-->
                                                        </div>
                                                        <!--end::Radio group-->
                                                    </div>
                                                    <div id="upload_videodiv" @if($employer->company_video!=''|| $employer->embedded_url=='') style="overflow:inherit; display:inline-block;" @else style="display:none" @endif>
                                                        <div class="row mb-3">
                                                            <div class="fileUploadvideo" style="overflow:inherit; display:inline-block;"  >
                                                        
                                                                <input type="file"  id="company_video" class="upload_video" name="company_video" accept=" video/*" hidden/>
                                                                <label for="company_video" type="button"  class=" videolibrary btn btn-primary btn_videofile" ><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/></svg>&nbsp;Choose File</label>
                                                        
                                                            </div>  
                                                        </div>
                                                        <!-- <div class="pl-7 border rounded border-primary border-dashed">
                                                        
                                                            <div  id="" class="kt-avatar p-3" > -->
                                                            @if($employer->company_video!='')
                                                                @if(file_exists(public_path(Config::get('constants.BUSINESS_VIDEO_PATH')).$employer->company_video))
                                                                        <video id="upload_videotag" height="250" controls src="{{asset(Config::get('constants.BUSINESS_VIDEO_PATH')).'/'.$employer->company_video}}">
                                                                        Your browser does not support the video tag.
                                                                        </video>
                                                                @else
                                                                    <video id="upload_videotag" height="250" controls>
                                                                        Your browser does not support the video tag.
                                                                        </video>
                                                                @endif
                                                            @else
                                                                <video id="upload_videotag" height="250" controls>
                                                                Your browser does not support the video tag.
                                                                </video>
                                                            @endif
                                                            <!-- </div>
                                                        
                                                        </div> -->
                                                    </div>
                                                    <div id="videourl_embedurl" @if($employer->embedded_url!='') style="overflow:inherit; display:inline-block;" @else style="display:none" @endif>
                                                        <div class="input-group ">
                                                            <span class="input-group-text">
                                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                <span class="svg-icon ">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-video-fill" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2V5z"/>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <input  type="text" name="company_videourl" id="company_videourl" class="form-control form-control-lg" placeholder="" required  value="@if(isset($employer->embedded_url)){{$employer->embedded_url}}@endif" />
                                                        </div>     
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                       
                                    <div class="row mb-6">
                                        <!-- <div class="col-lg-8"> -->
                                            <label class="col-lg-4 text-end col-form-label  fw-bold fs-6">Storing Videos for:</label>
                                            <div class="col-lg-4">
                                                <div class="col-lg-8 fv-row text-start">
                                                    <button type="button" class="btn btn-bg-white  fw-bolder flex-wrap px-0 color-D6E" id="kt_company_settings_upgrade">30 Days</button>
                                                </div>  
                                            </div>
                                        <!-- </div>  -->
                                        <div class="col-lg-4">
                                        @if(auth()->user()->master_empid=='')
                                            <!-- <div class="col-lg-8 fv-row text-end">
                                                <button type="button" class="btn btn-primary" id="kt_company_settings_upgrade">Upgrade</button>
                                            </div>   -->
                                        @endif
                                        </div>
                                    </div>

                                </div>
                                <!--end::Card body-->
                                <div class="card-footer">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary" id="kt_company_setting_submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        <!--end::Form-->
                    </div>
            <!--end::Row-->
        </div>
    <!--end::Post-->
    </div>
    @include('employer::settings.imageeditor_mdl')
@else
<div class="post d-flex flex-column-fluid p-5" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body">
                    <!-- <div class="card-px text-center pt-15 pb-15">
                        <h2 class="fs-2x fw-bolder mb-0">You are not authorized to access this page</h2>
                    </div> -->
                    <div class="row gx-9 gy-6 text-center ">
                        <div class="col-xl-3">
                        </div>
                        <div class="col-xl-6">
                            <!--begin::Notice-->
                            <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed flex-stack h-xl-100 mb-4 p-6">
                                <!--begin::Wrapper-->
                                <div class=" flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                    <!--begin::Content-->
                                    <div class="mb-1 mb-md-0 fw-bold">
                                        <h5 class="fs-4 fw-bolder text-primary">Sorry! You cannot access this page.</h4>
                                        <div class="fs-6  pe-7 text-primary mb-2">Only the account holder has permission to view & edit these settings</div>
                                    </div>
                                    <!--end::Content-->
                                    <!--begin::Action-->
                                    <!-- <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal" data-bs-target="#kt_modal_new_user">Add User</a> -->
                                    <!--end::Action-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Notice-->
                        </div>
                        <div class="col-xl-3">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script src="{{asset('js/cropper.bundle.js')}}"></script>
<script src="{{asset('js/employer/settings/companysettings.js')}}"></script>
@endsection