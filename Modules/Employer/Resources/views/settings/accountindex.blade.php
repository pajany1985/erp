@extends('employer::layouts.master')
@section('pagetitle','Manage Settings')

@section('content')
<!-- if(auth()->user()->master_empid=='') -->
    <input type="hidden" value="{{$authuser_id}}" name="authuser" id="authuser">
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
                @if (session('success'))
                        <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row px-3 py-1 mb-10">
                            <div class="d-flex flex-column text-light pe-0 pe-sm-10 py-4">
                                <span>{{ session('success') }}</span>
                            </div>
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
                                <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">Account Settings</h1>
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
                                                    <li class="breadcrumb-item text-dark">Account Settings</li>
                                                    <!--end::Item-->
                                    </ul>                 
                            

                                <!--end::Title-->

                        <!--end::Title-->
                    </div>
                </div>
            <!--begin::Row-->
            <div class="row ">
                <div class="col-xl-9">
                        <div class="card mb-5 mb-xl-10">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <span class="svg-icon svg-icon-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#0086FF"><g><path d="M0,0h24v24H0V0z" fill="none"></path><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"></path></g></svg>
                                    </span>
                                    <span class="px-2">
                                    Account Settings
                                    <span>
                                </h3>
                            </div>
                            
                            <!--begin::Form-->
                            <form id="kt_account_setting_form" class="form" method="post" action="settings/accountsetting">
                                <div class="card-body p-9 pb-0">
                                    @csrf
                                    <input type="hidden" value="{{$authuser_id}}" name="loginuser_id" id="loginuser_id">
                                            <!--begin::Input group-->
                                            <div class="row mb-6">
                                                <label class="col-lg-4 text-end col-form-label required fw-bold fs-6">First Name</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-8 fv-row">
                                                            <div class="input-group ">
                                                                <span class="input-group-text">
                                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                    <span class="svg-icon ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <input type="text" name="firstname" class="form-control form-control-lg " placeholder="First name" value="{{ucfirst($authemployer->first_name)}}" />
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-6">
                                                <!--begin::Label-->
                                                <label class="col-lg-4 text-end col-form-label required fw-bold fs-6">Last Name</label>
                                                <!--end::Label-->
                                                <!--begin::Col-->
                                                <div class="col-lg-8">
                                                    <!--begin::Row-->
                                                    <div class="row">
                                                        <!--begin::Col-->
                                                        <div class="col-lg-8 fv-row">
                                                            <div class="input-group ">
                                                                <span class="input-group-text">
                                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                    <span class="svg-icon ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <input type="text" name="lastname" class="form-control form-control-lg " placeholder="Last name" value="{{ucfirst($authemployer->last_name)}}" />
                                                            </div>
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Row-->
                                                </div>
                                                <!--end::Col-->
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-4 text-end col-form-label required fw-bold fs-6">Email</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-8 fv-row">
                                                            <div class="input-group ">
                                                                <span class="input-group-text">
                                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                    <span class="svg-icon">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <input type="email" name="email" class="form-control form-control-lg " placeholder="Enter Email" value="{{$authemployer->email}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-4 text-end col-form-label fw-bold fs-6">Password</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-4 fv-row">
                                                            <span class="form-control form-control-lg form-control-solid fw-bold fs-6 text-gray-800 ">*********</span>
                                                        </div>
                                                        <div class="col-lg-4 text-end fv-row">
                                                            <a href="#" class="btn btn-light btn-active-light-primary me-2 change_pass" data-bs-toggle="modal" data-bs-target="#kt_modal_updatepass">Change Password</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-4 text-end col-form-label fw-bold fs-6">
                                                    <span class="required">Phone Number</span>
                                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Phone number must be active"></i>
                                                </label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-8 fv-row">
                                                            <div class="input-group ">
                                                                <span class="input-group-text">
                                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                    <span class="svg-icon">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <input type="tel" name="phone" class="form-control form-control-lg " placeholder="Phone number" value="{{ucfirst($authemployer->phone_no)}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row mb-6">
                                                <label class="col-lg-4 text-end col-form-label fw-bold fs-6">Alt Number</label>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-8 fv-row">
                                                            <div class="input-group ">
                                                                <span class="input-group-text">
                                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                                    <span class="svg-icon">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <input type="tel" name="alt_no" class="form-control form-control-lg " placeholder="Alternate Number" value="{{ucfirst($authemployer->alter_phone)}}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary" id="kt_account_setting_submit">Save</button>
                                    </div>
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                </div>
                <div class="col-xl-3">
                   
                    <!-- <div class="page-title d-flex  flex-column align-items-center pt-10">
                        <p class="d-flex text-gray-500 fw-bolder my-1 fs-7 mb-3 color-D6E">Your account is set to expire on &nbsp;<span class="text-primary">08-03-2022</span></p>
                    </div>
                    
                    <div class="row px-2">
                        <div class="card mb-5 mb-xxl-8">
                            <div class="card-body px-2 ">
                                <div>
                                    <h4>Renew Your Annual Plan</h4>

                                </div>
                                <div class="text-gray-400 fw-bold pb-5">Renew your IdealTraits account and continue hiring your Ideal Talent.</div>

                            </div>
                            <div class="card-footer py-5 text-center">
                                <a href="#" class="btn btn btn-primary">Buy for $1,299</a>
                            </div>
                        </div>
                    </div>
                    <div class="row px-2">
                        <div class="card mb-5 mb-xxl-8">
                            <div class="card-body px-2 ">
                                <div>
                                    <h4>Purchase a Quarterly Plan</h4>

                                </div>
                                <div class="text-gray-400 fw-bold pb-5">Renew your IdealTraits account today and extend your expiration date by 90 days.</div>

                            </div>
                            <div class="card-footer py-5 text-center">
                                <a href="#" class="btn btn btn-primary">Buy for $699</a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <!--end::Row-->
            
        </div>
        <!--end::Post-->
    </div>
    @include('employer::settings.updatepass')
<!-- else -->
    <!-- <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body">
                    <div class="card-px text-center pt-15 pb-15">
                        <h2 class="fs-2x fw-bolder mb-0">You are not authorized to access this page</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
<!-- endif -->
@endsection

@section('scripts')
<script src="{{asset('js/cropper.bundle.js')}}"></script>
<script src="{{asset('js/employer/settings/settings.js')}}"></script>
<script src="{{asset('js/employer/settings/updatepass.js')}}"></script>
@endsection