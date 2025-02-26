@extends('candidate::layouts.master')
@section('pagetitle','Manage Interview')
@section('content')

    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid mt-5" id="kt_content">
            
            <!--begin::Row-->
                <!-- <div class="row p-3"> -->
                    <!--begin::Tables Widget 5-->
                    <div class="card card-bordered  mb-xl-8">
                        @if($candidate->first_name!='')
                            <form class="form" novalidate="novalidate"  method="post" action="/" id="cms_form">
                                <input type="hidden" value="{{$candidate->id}}" id="candidate_id" name="candidate_id">
                                <!-- <div class="card-header">
                                    <h3 class="card-title">Question:</h3>
                                    <div class="card-toolbar">
                                        
                                    </div>
                                </div> -->
                                <!--begin::Body-->
                                <div class="card-body cmscontent">
                                    <div class="row ">
                                        <div class="col-xl-3">
                                        </div>
                                        <div class="col-xl-6">
                                    
                                            {!! $content !!}

                                        </div>

                                        <div class="col-xl-3">
                                        </div>
                                    </div>
                                </div>
                                <!--end::Body-->
                                <div class="card-footer text-center p-2"> 
                                    <span class="text-muted px-5">
                                        Good Luck!
                                    </span>
                                    <input type="hidden" name="encptcandid" id="encptcandid" value="{{$enpt_candidid}}">
                                    <button type="button" data-encptcandid="{{$enpt_candidid}}" class="btn btn-sm btn-primary tocontinue">
                                        <span class="indicator-label">Continue</span>
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        @else
                            <form class="form" novalidate="novalidate"  method="post" action="/" id="cmsname_form">
                                <input type="hidden" value="{{$candidate->id}}" id="candidate_id" name="candidate_id">
                                <!-- <div class="card-header">
                                    <h3 class="card-title">Question:</h3>
                                    <div class="card-toolbar">
                                        
                                    </div>
                                </div> -->
                                <!--begin::Body-->
                                <div class="card-body ">
                                    <div class="row mb-5 ">
                                        <div class="col-xl-3">
                                        </div>
                                        <div class="col-xl-6">
                                            <p class="fs-3 fw-bolder mb-5">Hi, enter your first and last name to get started!
                                            </p>
                                            <div class="fv-row fv-plugins-icon-container ">
                                                <!--begin::Row-->
                                                <div class="row mb-7">
                                                    <div class="col-lg-6">
                                                        <label class="required fs-5 fw-bold mb-2" for="first_name">First Name</label>
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">
                                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                <span class="svg-icon ">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="@if($candidate->first_name!=''){{$candidate->first_name}}@endif" autocomplete="off"> 
                                                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="required fs-5 fw-bold mb-2" for="last_name">Last Name</label>
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">
                                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                <span class="svg-icon ">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="@if($candidate->last_name!=''){{$candidate->last_name}}@endif" autocomplete="off">
                                                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                                    </div>
                                                </div>
                                                <div class="row mb-7">
                                                    <div class="col-lg-6">
                                                        <label class="required fs-5 fw-bold mb-2" for="email">Email</label>
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">
                                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                <span class="svg-icon ">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <input type="text" disabled class="form-control" name="email" id="email" placeholder="First Name" value="@if($candidate->email!=''){{$candidate->email}}@endif" autocomplete="off"> 
                                                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="required fs-5 fw-bold mb-2" for="phone_no">Phone Number</label>
                                                        <div class="input-group has-validation">
                                                            <span class="input-group-text">
                                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                <span class="svg-icon ">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone Number" value="@if(isset($candidate->phone_no)&& ($candidate->phone_no!='')){{$candidate->last_name}}@endif" autocomplete="off">
                                                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                                    </div>
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                        </div>

                                        <div class="col-xl-3">
                                        </div>
                                    </div>
                                </div>
                                <!--end::Body-->
                                <div class="card-footer text-center"> 
                                    <input type="hidden" name="encptcandid" id="encptcandid" value="{{$enpt_candidid}}">
                                    <button type="submit" data-encptcandid="{{$enpt_candidid}}" class="btn btn-sm btn-primary tocontinuename">
                                        <span class="indicator-label">Continue</span>
                                        <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                    <!--end::Tables Widget 5-->
                <!-- </div> -->
            <!--end::Row-->

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection

@section('scripts')
<script src="{{asset('js/candidate/candidate.js')}}"></script>
@endsection