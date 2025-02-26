<div class="modal fade" id="mdluser_view" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
         <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">User Details</h3>
                </div>
                <!--end::Card title-->
                @can('update users')
                <!--begin::Action-->
                <a href="javascript:;" class="btn btn-primary align-self-center useredit" data-userid=''>Edit User</a>
                <!--end::Action-->
                @endcan
            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9 ">
                <div class="d-flex flex-center flex-column pt-3 p-9 profilediv">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-100px symbol-circle mb-5" id="profile_pic">
                        
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Name-->
                    <a href="#" id="username" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0"></a>
                    <!--end::Name-->
                    <!--begin::Position-->
                    <div class="fw-bold text-gray-400 mt-4">
                        <div id="role_name"class="badge badge-lg badge-light-primary d-inline"></div>
                    </div>
                    <!--end::Position-->

                </div>
                 <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-bold text-muted">Contact Phone
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Phone number must be active" aria-label="Phone number must be active"></i></label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <span class="fw-bolder fs-6 text-gray-800 me-2" id="phoneno"></span>
                            <span class="badge badge-success">Verified</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-bold text-muted">Email</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <span class="fw-bolder fs-6 text-gray-800" id="email"></span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Input group-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-bold text-muted">Login ID</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6" id="login_id"></span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
               
                  
                    
                        <!--begin::Input group-->
                        <div class="row mb-10">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-bold text-muted">Status</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-8 status">
                               
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Notice-->
                        <div class="notice bg-light-warning rounded border-warning border border-dashed
                        ">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
                                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            If role changed for the user access may differ. 
                        </div>
                        <!--end::Notice-->
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>


