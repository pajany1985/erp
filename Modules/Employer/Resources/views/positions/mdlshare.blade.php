<!-- New Modal start -->
<div class="modal fade" id="mdlshare" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
           
                <input type='hidden' id='upd_passmaster_id' name='upd_passmaster_id' value='' />
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_updatepass_header">
                    <!--begin::Modal title-->
                    <h2 class="color-D6E"><i class="bi bi bi-share-fill fs-4 text-primary"></i> Share Interview</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary cancelbtn" data-bs-dismiss="modal">
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
                <div class="modal-body py-5 ">
                   <!--begin::Scroll-->
                   
                    <!--begin::Card body-->
                    <form id="shareform" class="form" method="post" action="{{ route('sharedirectinvite') }}">
                            @csrf
                            <input type="hidden" id="toemaildummy"  name='toemaildummy' >
                            <input type="hidden" id="routeurl" name="routeurl" value="{{ route('sharedirectinvite') }}">
                            <input type="hidden" id="position_id" name="position_id" >
                            <div class="card-body pt-10">
                                <div class="row mb-6">
                                    <label class="col-lg-4 text-start col-form-label fw-bold fs-6">Invitation URL</label>
                                    <div class="col-lg-8">


                                        <div class="input-group">
                                        <!--begin::Input-->
                                        <input id="link_val" name='link_val'  type="text" class="form-control required" placeholder="" readonly>
                                        <!--end::Input-->
                                        <!--begin::Button-->
                                        <button id='cpy_link' type="button" class="btn btn-primary" data-clipboard-target="#link_val">Copy</button>
                                        <!--end::Button-->
                                    </div>


                                </div>
                            </div>

                            <div class="row mb-6">
                                <label class="col-lg-4 text-start col-form-label fw-bold fs-6">Email Invitation</label>
                                <div class="col-lg-8">

                                    <input id="shareemail" class="form-control"  name='shareemail' pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" value="" />
                                    <!--end::Input-->
                                    <span class="color-D6E fw-bold d-block fs-8">For multiple emails separate by comma or tab.</span>
                                </div>


                            </div>
                        </div>

                
                            <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                        

                        <button type="button" data-bs-dismiss="modal" id="sharelater" class="btn btn-light btn-active-light-primary me-3 ">Share Later</button>

                            <button type="submit" id='btnshare' class="btn btn-primary"> 
                                <span class="indicator-label">Send</span>
                                <span class="indicator-progress">Please wait... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </form>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
        
            <!--end::Form-->
        </div>
    </div>
</div>
<!-- New Modal end -->