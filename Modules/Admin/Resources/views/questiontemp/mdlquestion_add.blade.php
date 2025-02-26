<div class="modal fade" id="mdlquestion_add" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_question_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Add Questions</h2>
                <!--end::Modal title-->
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
            <form id="kt_modal_add_question_form" method="post" class="form" enctype="multipart/form-data"  action="{{ route('questiontemp.store') }}">
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    @csrf
                    @if(isset($question))
                    @method('POST')
                    @endif
                    
                    <!--begin::Scroll-->
                    <!-- <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_question_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_question_header" data-kt-scroll-wrappers="#kt_modal_add_question_scroll" data-kt-scroll-offset="300px"> -->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Row-->
                            <!--begin::Repeater-->
                            <div id="kt_question_repeater">
                                <!--begin::Form group-->
                                <div class="form-group ">
                                    <div data-repeater-list="kt_question_repeater">
                                        <div data-repeater-item class="repeat_items">
                                            <div class="form-group  fv-row mb-5 border border-hover-primary p-7 rounded">
                                                <div class="row mb-5">
                                                    <div class="col-lg-10">
                                                        <label class="required fs-5 fw-bold mb-2" for="question">Question</label>
                                                        <!-- <input type="text" class="form-control" name="question"   placeholder="Enter Question"   />  -->
                                                        <textarea class="form-control " maxlength="300" placeholder="Enter Question" name="question"  data-kt-autosize="true" required></textarea> 
                                                        <div class="form-text">Maximum 300 characters allowed.</div>
                                                    </div>
                                                    <div class="col-lg-2 text-end">
                                                        <a href="javascript:;" data-repeater-delete name="deletebtn" class="btn btn-sm btn-light-danger mt-3 mt-md-10 ">
                                                            <i class="la la-trash-o fs-3"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->

                                <!--begin::Form group-->
                                <div class="form-group">
                                    <a href="javascript:;" id="addmore_question" data-repeater-create class="btn btn-light-primary">
                                        <i class="la la-plus"></i>Add More Questions
                                    </a>
                                </div>
                                <!--end::Form group-->
                            </div>
                            <!--end::Repeater-->
                            <!--end::Row-->
                        </div>
                        <!--end::Input group-->
                                                
                    <!-- </div> -->
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->

                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> -->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-3" id="add_close_button" data-kt-questions-modal-action="cancel">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-questions-modal-action="submit">
                            <span class="indicator-label">Submit</span>
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