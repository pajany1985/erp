@extends('employer::layouts.master')
@section('pagetitle','Manage Interviews')

@section('content')

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <div class="row ">
                <div id="kt_toolbar_container" class="d-flex flex-stack flex-wrap">
                        <div class="page-title d-flex  flex-column align-items-start px-2">
                        <!--begin::Title-->
                                <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">My Interviews
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-3 py-md-1  mb-3">
                                <a href="javascript:void(0);" class="btn btn-primary mx-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Career Page
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Menu-->
                                <!-- menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary  -->
                                <!-- menu menu-sub menu-sub-dropdown menu-column  menu-gray-600 menu-state-bg menu-active-primary menu-hover-primary  fw-bold fs-7 w-125px py-4 -->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-200px py-3" data-kt-menu="true">
                                
                                    <!--begin::Menu item-->

                                        <div class="menu-item ">
                                            <a href="{{ $career_url }}" class="menu-link px-3" target="_blank">
                                            <span class="px-3 color-D6E">View<span>
                                            </a>
                                        </div>

                                    <div class="menu-item ">
                                        <a href="employer/careersetting" class="menu-link px-3" target="_blank">
                                            <span class="px-3 color-D6E">Edit<span>
                                        </a>
                                    </div>

                                    <div class="menu-item ">
                                        <a href="javascript:void(0);" class="menu-link px-3 showdownloadQR" >
                                            <span class="px-3 color-D6E">Download QR code<span>
                                        </a>
                                    </div>

                                    <div class="menu-item ">
                                        <a href="javascript:void(0);" class="menu-link px-3 copyurl"  >
                                            <span class="px-3 color-D6E" id="kt_clipboard_3" data-clipboard-text="{{ $career_url }}">Copy URL<span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            <!--begin::Button-->
                            @if($isposition_createallowed)
                            <a href=" {{ route('position.create') }}" class="btn btn-primary" >
                            @else
                            <a href="javascript:void(0);" class="btn btn-primary createposition" >
                            @endif
                                <i class="bi bi-plus fs-1"></i>
                                Add New
                            </a>
                            <!--end::Button-->
                        </div>
                </div>
                <div class="col-xl-3 p-2">
                    <!--begin::List Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header ">
                            <h3 class="card-title fw-bolder text-dark">Interviews by Status</h3>
                            <div class="card-toolbar">
                                
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <input type="hidden" name="aside_status" id="aside_status" value="all">
                        <div class="card-body px-0">
                                <!--begin::Menu-->
                                <div class="menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary " data-kt-menu="true">
                                    

                                    <!--begin::Menu item-->
                                    <div class="menu-item ">
                                        <a href="javascript:void(0);" class="menu-link py-3 active emp_position_menulink" data-status='all'>
                                            <span class="menu-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                    <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                    <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                </svg>
                                            </span>
                                            <span class="menu-title">All</span>
                                            <span class="badge badge-circle badge-light-primary">{{ $all_cnt }}</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                     <!--begin::Menu item-->
                                     <div class="menu-item ">
                                        <a href="javascript:void(0);" class="menu-link py-3 emp_position_menulink" data-status='active'>
                                            <span class="menu-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#5fc541" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                </svg>
                                                <!-- <span class="badge badge-light-success " style="border-radius:0;"> -->
                                             

                                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 0 24 24" width="14px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"></path><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg> -->
                                                <!-- </span> -->
                                            </span>
                                            <span class="menu-title">Active</span>
                                            <!-- <span class="menu-badge menu-badge-circle fs-7 fw-normal text-muted">2</span> -->
                                            <span class="badge badge-circle badge-light-success">{{ $active_cnt }}</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                     <!--begin::Menu item-->
                                     <div class="menu-item ">
                                        <a href="javascript:void(0);" class="menu-link py-3 emp_position_menulink" data-status='draft'>
                                            <span class="menu-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                                </svg>
                                            </span>
                                            <span class="menu-title">Draft</span>
                                            <!-- <span class="menu-badge fs-7 fw-normal text-muted">4</span> -->
                                            <span class="badge badge-circle badge-light-warning">{{ $draft_cnt }}</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item">
                                        <a href="javascript:void(0);" data-status='archive' class="menu-link py-3 emp_position_menulink">
                                            <span class="menu-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#BE0000" class="bi bi-trash-fill kt-nav__link-icon" viewBox="0 0 16 16">
                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                                </svg>
                                            </span>
                                            <span class="menu-title">Archived</span>
                                            <!-- <span class="menu-badge fs-7 fw-normal text-muted">139</span> -->
                                            <span class="badge badge-circle badge-light-danger">{{ $archived_count }}</span>
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->                        
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end:List Widget 3-->
                </div>
                <div class="col-xl-9">
                    <input type="hidden" name="post_success" id="post_success" value="@if(session('postSuccess')=='1'){{1}}@endif"/>
                    <!--begin::Row-->
                    <section class="loadpositions">
                    @if(isset($positions) && $positions->count()>0)
                        
                        @if(session('success'))
                            <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row px-3 py-1 mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column text-light pe-0 pe-sm-10 py-4">
                            
                                    <!--begin::Content-->
                                    <span>{{ session('success') }}</span>
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
                            @elseif(session('warning'))
                                <!--begin::Alert-->
                                    <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row px-3 py-1 mb-10">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-column text-light pe-0 pe-sm-10 py-4">
                                    
                                            <!--begin::Content-->
                                            <span>{{ session('warning') }}</span>
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
                            @elseif(session('error'))
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
                            @endif
                            @include('employer::positions.loadindex')
                        
                    @else
                        <div class="row">
                            <!--begin::Tables Widget 5-->
                            <div class="card card-xxl-stretch mb-5 mb-xl-8">
                                
                                <!--begin::Body-->
                                <div class="card-body py-3 ">
                                    <span class="text-center">
                                        <span class="text-muted fw-bolder d-block ">No Interviews are found!</span>
                                    </span>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Tables Widget 5-->
                        </div>
                    @endif
                    </section>
                    <!--end::Row-->
                </div>
            </div>
        </div>
        <!--end::Post-->
        
</div>
 @include('employer::positions.mdlshare')
 @include('employer::settings.mdl_qrcode')
@endsection

@section('scripts')
<script src="{{asset('js/coloris.min.js')}}"></script>
<script src="{{asset('js/employer/positions/positions.js')}}"></script>
<script src="{{asset('js/employer/positions/shareposition.js')}}"></script>
<script src="{{asset('js/employer/settings/qrcode.js')}}"></script>
@endsection