@extends('employer::layouts.master')
@section('pagetitle','Manage Interviews')

@section('content')

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">

    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row ">
            <div id="kt_toolbar_container" class="d-flex flex-stack flex-wrap">
                <div class="page-title d-flex  flex-column align-items-start ">

                    <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">My Interviews
                        <li class="breadcrumb-item px-3 py-1 fs-6 text-muted">Add/Edit Interview</li>

                    </div>

                </div>
                <div class="col-xl-3 mb-5">
                    <!--begin::List Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header ">
                            <h3 class="card-title fw-bolder text-dark">Menu</h3>
                            
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body px-0">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary " data-kt-menu="true">


                                <!--begin::Menu item-->
                                <div class="menu-item ">
                                    <a href="javascript:void(0);" class="menu-link py-3  emp_position_menulink" data-status="all">
                                        <span class="menu-icon">
                                            <i class="bi bi-pencil-fill"></i>
                                        </span>
                                        <span class="menu-title">Add/Edit Interview</span>

                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item ">
                                    <a href="javascript:void(0);" class="menu-link py-3 active emp_position_menulink" data-status="3">
                                        <span class="menu-icon">
                                          <i class="bi bi-share-fill"></i>
                                      </span>
                                      <span class="menu-title">Share Interview</span>
                                      <!-- <span class="menu-badge menu-badge-circle fs-7 fw-normal text-muted">2</span> -->


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
              <div class="col-xl-9 ">
                <!--begin::Row-->
                <!--begin::Card-->

                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header  pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <i class="bi bi bi-share-fill fs-4 text-primary"></i> Share Interview
                                </span>
                                <!--end::Svg Icon-->
                                <span class="px-2">

                                    <span>
                                    </div>
                                    <!--end::Search-->
                                    
                                </div>
                                <!--end::Card title-->

                            </div>

                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <form id="shareform" class="form" method="post" action="">
                                <div class="card-body pt-10">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 text-start col-form-label fw-bold fs-6">Shareable Link</label>
                                        <div class="col-lg-8">


                                         <div class="input-group">
                                            <!--begin::Input-->
                                            <input id="sharelink" type="text" class="form-control" placeholder="" value="http://testurl.com">
                                            <!--end::Input-->
                                            <!--begin::Button-->
                                            <button type="button" class="btn btn-primary" data-clipboard-target="#sharelink">Copy</button>
                                            <!--end::Button-->
                                        </div>


                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-4 text-start col-form-label fw-bold fs-6">Share Directly</label>
                                    <div class="col-lg-8">

                                        <input id="shareemail"  name='shareemail' pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" value="">
                                        <!--end::Input-->

                                    </div>


                                </div>
                            </div>


                            <div class="d-flex justify-content-end pb-10 px-10"><button class="btn btn-light btn-active-light-primary me-3">Share Later</button><button class="btn btn-primary">Send</button></div>


                    </form>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

                <!--end::Row-->
            </div>
        </div>

    </div>
    <!--end::Post-->


</div>
@endsection

@section('scripts')
<!-- <script src="https://cdn.jsdelivr.net/gh/T-vK/DynamicQuillTools@master/DynamicQuillTools.js"></script> -->
<script src="{{asset('js/employer/positions/shareposition.js')}}"></script>
<!--   <script src="{{asset('js/jquery.raty.js')}}?version={{rand()}}"></script> -->
@endsection