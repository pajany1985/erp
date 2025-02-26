@extends('employer::layouts.master')
@section('pagetitle','Manage Settings')

@section('content')

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
                    <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">Career Page</h1>
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
                                <li class="breadcrumb-item text-dark">Career Page</li>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#0086FF"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 3h8v8H3zm10 0h8v8h-8zM3 13h8v8H3zm15 0h-2v3h-3v2h3v3h2v-3h3v-2h-3z"/></svg>
                                    <span class="px-2">
                                    Career Setting Page
                                    <span>
                                </h3>

                                <div class="card-toolbar">
                                   
                                    <small class="curdefault px-2">Total page views: {{$careertrack_count}}</small>&nbsp;

                                    <a href="{{$career_url}}" target="_blank" class="btn btn-light btn-active-light-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg> Preview Page
                                    </a>
                                </div>
                                
                            </div>
                        <!--begin::Form-->
                            <form id="kt_company_setting_form" class="form" method="post" action="settings/careersettingupdate" enctype="multipart/form-data">
                                @csrf
                                <!--begin::Card body-->
                                <div class="card-body  p-9">
                                    <!--begin::Input group-->

                                    <div class="row mb-8">
                                        <label class="col-lg-4 text-start col-form-label  fw-bold fs-6">Career Page QR Code</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-8 fv-row">
                                                    <label for="" type="button" class="btn btn-primary btn-icon-sm  btn_file mb-3 showdownloadQR">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>&nbsp;Download QR Code
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 text-start col-form-label  fw-bold fs-6">Career Page URL</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <div class="input-group mb-5">
                                                        <input readonly type="text" class="form-control border-radius-none" id="landingPageUrl3" name="landingPageUrl3" value="{{$career_url}}">
                                                        <span class="input-group-text border-radius-none btn-primary" id="tooltip_url" data-bs-toggle="tooltip" data-clipboard1="true"  data-bs-placement="top" data-clipboard-target="#landingPageUrl3">
                                                            <i class="la la-copy fs-4" style="color:#ffff;"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row mb-8">
                                        <label class="col-lg-4 text-start col-form-label required fw-bold fs-6">Color Theme</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row">
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme1') selectedcolor @endif" id="theme1" style="background-color:#606060;" data-themeid="1" ></div>
                                                        <div  class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme1') selectedcolor @endif " id="bottom-theme1" style="background-color:#F2F2F2;" data-themeid="1" ></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme2') selectedcolor @endif" id="theme2" style="background-color:#D3D3D3;" data-themeid="2"  ></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme2') selectedcolor @endif" id="bottom-theme2" style="background-color:#F6F6F6;" data-themeid="2" ></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme3') selectedcolor @endif" id="theme3" style="background-color:#B26161;" data-themeid="3"></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme3') selectedcolor @endif" id="bottom-theme3" style="background-color:#FBF0F0;" data-themeid="3"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme4') selectedcolor @endif" id="theme4" style="background-color:#E4D0BA;" data-themeid="4"></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme4') selectedcolor @endif " id="bottom-theme4" style="background-color:#FBF5EF;" data-themeid="4"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme5') selectedcolor @endif" id="theme5" style="background-color:#CECCB4;" data-themeid="5"></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme5') selectedcolor @endif" id="bottom-theme5" style="background-color:#F0EFE4;" data-themeid="5"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme6') selectedcolor @endif" id="theme6" style="background-color:#E4DD8E;" data-themeid="6"></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme6') selectedcolor @endif" id="bottom-theme6" style="background-color:#FAF9ED;" data-themeid="6"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme7') selectedcolor @endif" id="theme7" style="background-color:#BED3C4;" data-themeid="7" ></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme7') selectedcolor @endif" id="bottom-theme7" style="background-color:#F1F6EF;" data-themeid="7"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme8') selectedcolor @endif" id="theme8" style="background-color:#A5D5D5;" data-themeid="8"></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme8') selectedcolor @endif" id="bottom-theme8" style="background-color:#EAF2F2;" data-themeid="8"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(!isset($career_setting->career_theme) || $career_setting->career_theme =='' || $career_setting->career_theme =='theme9') selectedcolor @endif" id="theme9" style="background-color:#CADBEC;" data-themeid="9"></div>
                                                        <div class="btn themecolor themebottom @if(!isset($career_setting->career_theme) || $career_setting->career_theme =='' || $career_setting->career_theme =='theme9') selectedcolor @endif" id="bottom-theme9" style="background-color:#F7FAFC;" data-themeid="9"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme10') selectedcolor @endif" id="theme10" style="background-color:#4B6C8B;" data-themeid="10"></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme10') selectedcolor @endif" id="bottom-theme10" style="background-color:#EBF3FC;" data-themeid="10"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn themecolor themetop @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme11') selectedcolor @endif" id="theme11" style="background-color:#D0C6DE;" data-themeid="11"></div>
                                                        <div class="btn themecolor themebottom @if(isset($career_setting->career_theme) && $career_setting->career_theme !='' && $career_setting->career_theme =='theme11') selectedcolor @endif" id="bottom-theme11" style="background-color:#F9F6FF;" data-themeid="11"></div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $theme9 ='theme9';
                                        $linkcolor= '000000';
                                    @endphp
                                    <input type="hidden" value="@if(!isset($career_setting->career_theme) || $career_setting->career_theme =='' || $career_setting->career_theme =='theme9'){{$theme9}}@else{{$career_setting->career_theme}}@endif" id="selected_theme" name="selected_theme">
                                    <input type="hidden" value="@if(!isset($career_setting->link_color) || $career_setting->link_color == '' || $career_setting->link_color =='000000'){{$linkcolor}}@else{{$career_setting->link_color}}@endif" id="selected_linkcolor" name="selected_linkcolor">

                                    <div class="row mb-8">
                                        <label class="col-lg-4 text-start col-form-label required fw-bold fs-6">Link Color</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 fv-row ">
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(!isset($career_setting->link_color) || $career_setting->link_color == '' || $career_setting->link_color =='000000') selectedcolor @endif" id="link_theme1" style="background-color:#000000;" data-linkcolor="000000" data-linkid="1"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='999999')  selectedcolor @endif " id="link_theme2" style="background-color:#999999;" data-linkcolor="999999" data-linkid="2"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='CF2E2E')  selectedcolor @endif " id="link_theme3" style="background-color:#CF2E2E;" data-linkcolor="CF2E2E" data-linkid="3"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor  @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='FE0002')  selectedcolor @endif" id="link_theme4" style="background-color:#FE0002;" data-linkcolor="FE0002" data-linkid="4"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='FB4501')  selectedcolor @endif" id="link_theme5" style="background-color:#FB4501;" data-linkcolor="FB4501" data-linkid="5"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='FDD016')  selectedcolor @endif" id="link_theme6" style="background-color:#FDD016;" data-linkcolor="FDD016" data-linkid="6"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='64991F')  selectedcolor @endif" id="link_theme7" style="background-color:#64991F;" data-linkcolor="64991F" data-linkid="7"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='2699AB')  selectedcolor @endif" id="link_theme8" style="background-color:#2699AB;" data-linkcolor="2699AB" data-linkid="8"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='2E76CF')  selectedcolor @endif" id="link_theme9" style="background-color:#2E76CF;" data-linkcolor="2E76CF" data-linkid="9"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='993CF3')  selectedcolor @endif" id="link_theme10" style="background-color:#993CF3;" data-linkcolor="993CF3" data-linkid="10"></div>
                                                    </div>
                                                    <div class="btn-group-vertical curpointer" role="group">
                                                        <div class="btn linkcolor @if(isset($career_setting->link_color) && $career_setting->link_color != '' && $career_setting->link_color =='D622CB')  selectedcolor @endif" id="link_theme11" style="background-color:#D622CB;" data-linkcolor="D622CB" data-linkid="11"></div>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 text-start col-form-label  fw-bold fs-6">Banner Image</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    

                                                        <input type="hidden" id="photo_id" name="photo_id" value="" />
                                                        <div class="fileupload_div mb-3">
                                                            <div class="fileUpload" style="overflow:inherit; display:inline-block;">
                                                                <input type="hidden" id="cimage_baseid" name="cimage_baseid" value="" />
                                                                <input type="file" id="company_photo1" class="upload" name="company_photo1" hidden accept="image/*">
                                                                    <label for="company_photo1" type="button" class="imglibrary btn btn-primary btn-icon-sm btn_file"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"></path><path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"></path></svg>&nbsp;Choose File</label>
                                                                <label type="button" id="imglibrary" class="imglibrary btn btn-primary btn-icon-sm btn_file showlibraryimages" data-val="1" ><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M22 16V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zm-11-4l2.03 2.71L16 11l4 5H8l3-4zM2 6v14c0 1.1.9 2 2 2h14v-2H4V6H2z"/></svg>&nbsp;Select from library</label>                          
                                                            </div>
                                                            
                                                        </div>
                                                        <div  id="company_photo1_preview1" class="kt-avatar" style="border: 1px solid #e1e1ef;">
                                                          
                                                            <div class="upl_image p-3" id="company_photo1_preview2">
                                                                @if(isset($career_setting->banner_image) && $career_setting->banner_image !='')
                                                                    @if(file_exists(public_path(Config::get('constants.BUSINESS_BANNER_PATH')).''.$career_setting->banner_image))
                                                                        <img src="{{asset(Config::get('constants.BUSINESS_BANNER_PATH')).'/'.$career_setting->banner_image}}" style="max-width:100%;" width="100%" data-url ="{{asset(Config::get('constants.BUSINESS_BANNER_PATH')).'/'.$career_setting->banner_image}}" class="open_image" id="bannerimageurl" />
                                                                    @else
                                                                        <img src="{{Config::get('constants.BUSINESS_DEFAULT_BANNERURL')}}" class="open_image" style="max-width:100%;" width="100%"  id="bannerimageurl" data-url ="{{Config::get('constants.BUSINESS_DEFAULT_BANNERURL')}}"  />
                                                                    @endif
                                                                @else 
                                                                    <img src="{{Config::get('constants.BUSINESS_DEFAULT_BANNERURL')}}" class="open_image" style="max-width:100%;" width="100%"  id="bannerimageurl" data-url ="{{Config::get('constants.BUSINESS_DEFAULT_BANNERURL')}}"  />
                                                                @endif  
                                                            </div>

                                                            
                                                            <div class="text-end" id="editorremove">  
                                                                @if(isset($career_setting->banner_image) && $career_setting->banner_image !='')  
                                                                    @if(file_exists(public_path(Config::get('constants.BUSINESS_BANNER_PATH')).''.$career_setting->banner_image))
                                                                        <button type="button" class="btn  btn-sm btn-icon   editimage btn-iconcustom-dark" data-toggle="kt-tooltip" title="" data-original-title="Edit Image"><svg class="kt-font-brandideal " fill="currentColor" width="18px" viewBox="0 0 24 24" height="18px" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></button>                                                                
                                                                    @endif
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

                                    <input type="hidden" id="chooseFromLibrary1" name="chooseFromLibrary1" value="0"/>
                                    <input type="hidden" id="library_filename1" name="library_filename1" value=""/>

                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 text-start col-form-label  fw-bold fs-6">Company Description</label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <label for="" type="button" class="btn btn-primary btn-icon-sm  btn_file template mb-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9h-4v4h-2v-4H9V9h4V5h2v4h4v2z"/></svg>&nbsp;Use a Template</label>



                                                    <div  contenteditable="true"  style="height: 200px; overflow-y:scroll;" class="form-control border-radius-none color-D6E fs-6" id="business_description_area">@if(isset($career_setting->company_description) && $career_setting->company_description != ''){!! html_entity_decode(str_replace('"', "'" ,trim($career_setting->company_description))) !!}@endif</div>
                                                    <input type="hidden"  id="business_description" name="business_description" value="@if(isset($career_setting->company_description) && $career_setting->company_description != ''){{str_replace('"', "'" ,trim($career_setting->company_description))}}@endif" />
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                       
                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 text-start col-form-label  fw-bold fs-6"><a href="javascript:void(0)" class="btn btn-facebook btn-icon curdefault"><i class="fab fa-facebook-f fs-4"></i></a> </label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input class="form-control border-radius-none" type="text" id="company_fb_url" name="company_fb_url" value="@if(isset($career_setting->facebook_career_url) && $career_setting->facebook_career_url != ''){{$career_setting->facebook_career_url}}@endif">
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 text-start col-form-label  fw-bold fs-6"><a href="javascript:void(0)" class="btn btn-linkedin btn-icon curdefault"><i class="fab fa-linkedin fs-4"></i></a></label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input class="form-control border-radius-none" type="text"  id="company_linked_url" name="company_linked_url" value="@if(isset($career_setting->linkedin_career_url) && $career_setting->linkedin_career_url != ''){{$career_setting->linkedin_career_url}}@endif">
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 text-start col-form-label  fw-bold fs-6"><a href="javascript:void(0)" class="btn btn-twitter  btn-icon curdefault"><i class="fab fa-twitter fs-4"></i></a></label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input class="form-control border-radius-none" type="text" id="company_twitter_url" name="company_twitter_url" value="@if(isset($career_setting->twitter_career_url) && $career_setting->twitter_career_url != ''){{$career_setting->twitter_career_url}}@endif">
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <div class="row mb-8">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 text-start col-form-label  fw-bold fs-6"><a href="javascript:void(0)" class="btn btn-instagram btn-icon curdefault"><i class="fab fa-instagram fs-4"></i></a> </label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-8">
                                            <!--begin::Row-->
                                            <div class="row">
                                                <!--begin::Col-->
                                                <div class="col-lg-8 fv-row">
                                                    <input class="form-control border-radius-none" type="text" id="company_instagram_url" name="company_instagram_url" value="@if(isset($career_setting->instragram_career_url) && $career_setting->instragram_career_url != ''){{$career_setting->instragram_career_url}}@endif">
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                </div>
                                <!--end::Card body-->
                                <div class="card-footer">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary" id="kt_career_setting_submit">
                                            <span class="indicator-label">Save</span>
                                            <span class="indicator-progress">Please wait... 
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>

                                    </div>
                                </div>


                            </form>
                        <!--end::Form-->
                    </div>
            <!--end::Row-->
        </div>
    <!--end::Post-->
    </div>
    @include('employer::settings.careerimageeditor_mdl')
    @include('employer::settings.mdl_qrcode')

@endsection

@section('scripts')
<script src="{{asset('js/coloris.min.js')}}"></script>
<script src="{{asset('js/cropper.bundle.js')}}"></script>
<script src="{{asset('js/employer/settings/careersettings.js')}}"></script>
<script src="{{asset('js/employer/settings/qrcode.js')}}"></script>
@endsection