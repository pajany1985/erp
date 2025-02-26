<div class="modal fade" id="mdlcandidate_add" data-backdrop="static" data-keyboard="false" tabindex="-1"  role="dialog" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_candidate_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Add Candidate</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                
                <div class="btn btn-icon btn-sm  ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Form-->
            <form id="kt_modal_add_candidate_form" method="post" class="form" enctype="multipart/form-data"  action="{{ route('candidates.store') }}">
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                   
                </div>
                <!--end::Modal body-->

                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> -->
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-3" id="close_button" data-kt-candidates-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary setassessment"  id="send" data-assessment="0"  data-kt-candidates-modal-action="submit">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>

                        <button type="submit" class="btn btn-primary setassessment"  id="send_link"  data-assessment="1"  data-kt-candidates-modal-action="sendinvite">
                            <span class="indicator-label">Send Invite</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
            </form>
             <!--end::Form-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
