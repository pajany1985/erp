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

             <div id="kt_toolbar_container" class="d-flex flex-stack flex-wrap m-5">
        <div class="page-title d-flex  flex-row align-items-start ">
            <!--begin::Title-->
           

             <!--begin::Title-->
                    <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">Manage Users</h1>
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
                                        <li class="breadcrumb-item text-dark">Users List</li>
                                        <!--end::Item-->
                        </ul>                 
                  

                    <!--end::Title-->

            <!--end::Title-->
        </div>
    </div>
          
            <div class="card mb-5 mb-xl-10 " >
                        <input type="hidden" value="{{$subusers->count()}}" name="usercount" id="usercount">
                        <div class="card-header userpresent @if($subusers->count()!=0)  @else d-none @endif "  >
                             <h3 class="card-title">
                                    <span class="svg-icon svg-icon-1">
                                       <svg fill="#0086FF" xmlns="http://www.w3.org/2000/svg" height="24" width="24"><path d="M1 20v-2.8q0-.85.438-1.563.437-.712 1.162-1.087 1.55-.775 3.15-1.163Q7.35 13 9 13t3.25.387q1.6.388 3.15 1.163.725.375 1.162 1.087Q17 16.35 17 17.2V20Zm18 0v-3q0-1.1-.612-2.113-.613-1.012-1.738-1.737 1.275.15 2.4.512 1.125.363 2.1.888.9.5 1.375 1.112Q23 16.275 23 17v3ZM9 12q-1.65 0-2.825-1.175Q5 9.65 5 8q0-1.65 1.175-2.825Q7.35 4 9 4q1.65 0 2.825 1.175Q13 6.35 13 8q0 1.65-1.175 2.825Q10.65 12 9 12Zm10-4q0 1.65-1.175 2.825Q16.65 12 15 12q-.275 0-.7-.062-.425-.063-.7-.138.675-.8 1.037-1.775Q15 9.05 15 8q0-1.05-.363-2.025Q14.275 5 13.6 4.2q.35-.125.7-.163Q14.65 4 15 4q1.65 0 2.825 1.175Q19 6.35 19 8ZM3 18h12v-.8q0-.275-.137-.5-.138-.225-.363-.35-1.35-.675-2.725-1.013Q10.4 15 9 15t-2.775.337Q4.85 15.675 3.5 16.35q-.225.125-.362.35-.138.225-.138.5Zm6-8q.825 0 1.413-.588Q11 8.825 11 8t-.587-1.412Q9.825 6 9 6q-.825 0-1.412.588Q7 7.175 7 8t.588 1.412Q8.175 10 9 10Zm0 8ZM9 8Z"/></svg>
                                    </span>
                                    <span class="px-2">
                                    Manage users
                                    <span>
                                </h3>
                            <div class="card-toolbar " >
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_user"><i class="bi bi-plus fs-1"></i> Add User</a> 
                            </div>
                            
                        </div>
                                                                  
                        <div class="card-body border-top p-9">
                            <div class="usernotpresent" @if($subusers->count()==0) style="display:block" @else style="display:none" @endif>
                                <div class="row gx-9 gy-6 text-center ">
                                    <div class="col-xl-3">
                                    </div>
                                    <div class="col-xl-6">
                                        <!--begin::Notice-->
                                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed flex-stack h-xl-100 mb-10 p-6">
                                            <!--begin::Wrapper-->
                                            <div class=" flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                <!--begin::Content-->
                                                <div class="mb-3 mb-md-0 fw-bold">
                                                    <h4 class="text-gray-900 fw-bolder color-D6E">No Users to Display!</h4>
                                                    <div class="fs-6 text-gray-700 pe-7 color-D6E mb-2">Click "Add User" to allow someone access to your account</div>
                                                    <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal" data-bs-target="#kt_modal_new_user">Add User</a>

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
                                <!--begin::Table-->
                                <div class="userpresent" @if($subusers->count()!=0) style="display:block" @else style="display:none" @endif>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 " id="kt_table_users" >
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">Name</th>
                                                <th class="min-w-125px">Username</th>
                                                <th class="min-w-125px">Status</th>
                                                <th class="min-w-125px">Created Date</th>
                                                <th class="text-end min-w-100px">Actions</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="text-gray-600 fw-bold"></tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                                <!--end::Table--> 
                                                                    
                            <!-- New Modal start -->
                            <div class="modal fade" id="kt_modal_new_user" tabindex="-1" aria-hidden="true">
                                    <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Form-->
                                        <form class="form fv-plugins-bootstrap5 fv-plugins-framework"   method="post" action="settings/createsubemployer" id="kt_modal_new_user_form">
                                            @csrf
                                            <input type='hidden' id='master_id' name='master_id' value='{{$master_id}}' />
                                            <!--begin::Modal header-->
                                            <div class="modal-header" id="kt_modal_new_user_header">
                                                <!--begin::Modal title-->
                                                <h2 class="color-D6E">Add New User</h2>
                                                <!--end::Modal title-->
                                                <!--begin::Close-->
                                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                    <span class="svg-icon svg-icon-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                            <!--end::Modal header-->
                                            <!--begin::Modal body-->
                                            <div class="modal-body py-10 px-lg-17">
                                                <!--begin::Scroll-->
                                                <div class="scroll-y me-n7 pe-7" id="kt_modal_new_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_user_header" data-kt-scroll-wrappers="#kt_modal_new_user_scroll" data-kt-scroll-offset="300px" style="max-height: 50px;">
                                    
                                                    <!--begin::Input group-->
                                                    <div class="row mb-5">
                                                        <!--begin::Col-->
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <!--begin::Label-->
                                                            <label class="required fs-5 fw-bold mb-2 color-D6E">First name</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
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
                                                                <input type="text" class="form-control " placeholder="First Name" name="fname" id="fname">
                                                            </div>
                                                            <!--end::Input-->
                                                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                                        <!--end::Col-->
                                                        <!--begin::Col-->
                                                        <div class="col-md-6 fv-row fv-plugins-icon-container">
                                                            <!--end::Label-->
                                                            <label class="required fs-5 fw-bold mb-2 color-D6E">Last name</label>
                                                            <!--end::Label-->
                                                            <!--end::Input-->
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
                                                                <input type="text" class="form-control " placeholder="Last Name" name="lname" id="lname">
                                                            </div>
                                                            <!--end::Input-->
                                                        <div class="fv-plugins-message-container invalid-feedback"></div></div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    
                                                    <div class="d-flex flex-column mb-5 fv-row fv-plugins-icon-container">
                                                        <!--begin::Label-->
                                                        <label class="fs-5 fw-bold mb-2 color-D6E">Email</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
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
                                                            <input type="text" class="form-control " name="email" id="email" placeholder="Email" >
                                                        </div>
                                                        <!--end::Input-->
                                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                                    </div>


                                                </div>
                                                <!--end::Scroll-->
                                            </div>
                                            <!--end::Modal body-->
                                            <!--begin::Modal footer-->
                                            <div class="modal-footer flex-center">
                                                <!--begin::Button-->
                                                <button type="reset" id="close_button"  class="btn btn-light btn-active-light-primary me-3" data-kt-users-modal-action="cancel">Discard</button>
                                                <!--end::Button-->
                                                <!--begin::Button-->
                                                <button type="submit" id="kt_modal_new_user_submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                    <span class="indicator-label">Submit</span>
                                                    <span class="indicator-progress">Please wait... 
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                                <!--end::Button-->
                                            </div>
                                            <!--end::Modal footer-->
                                        <div></div></form>
                                        <!--end::Form-->
                                    </div>
                                </div>
                            </div>
                            <!-- New Modal end -->
                        </div>
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
<script src="{{asset('js/employer/settings/settings.js')}}"></script>
<!-- <script src="{{asset('js/employer/settings/updatepass.js')}}"></script> -->
@endsection