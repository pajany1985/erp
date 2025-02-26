<div class="modal fade" id="mdlcomments" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_comments_header">
            <h3 class="fw-bolder m-0 text-gray-800 ">
                <span class="svg-icon svg-icon-1 svg-icon-primary me-3 lh-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0086FF" class="bi bi-chat-left-dots-fill kt-nav__link-icon pt-1" viewBox="0 0 16 16">
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
                    </svg>
                </span>
                Comments</h3>
                
                <!--begin::Close-->
                
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Form-->
            <form id="frmnotes" method="post" action="/admin/employer/empnotes">
                @csrf
                <input type="hidden" name="employer_id" id="employer_id" value="">
                                <input type="hidden" name="admin_id" id="admin_id" value="">
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5  my-7">

                        <div class="d-flex flex-column mb-8">
                            <textarea class="form-control " maxlength="300" rows="3" name="cmnt_area" id="cmnt_area" placeholder="Type notes" data-kt-autosize="true"></textarea>
                            <div class="form-text">Maximum 300 characters allowed.</div>
                        </div>
                        
                        <div class="row mb-5 pb-4">
                            <div class="col-6">
                                <button type="submit" class="btn btn btn-primary">Submit</button>
                            </div>
                        </div>
                    
                            <div class="separator mb-5"></div>
                        <div class="tab-content" style="height:600px;overflow:auto;">
                            <!--begin::Tab panel-->
                            <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                                <div class="timeline" id="commentlist">
                                    
                                </div>
                            </div>
                            <!--end::Tab panel-->
                        </div>
                </div>
                <!--end::Modal body-->
            </form>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>


