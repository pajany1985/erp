<!--begin::Modal - Question Template-->
<div class="modal fade" id="mdltemplate" tabindex="-1" aria-hidden="true" >
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Question Templates</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_candidates_export_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
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
            <div class="modal-body scroll-y mx-5 mx-xl-15 mt-7">
                <!--begin::Form-->
                <form id="mdl_qstn_form" class="form" action="#">

                 <div class="card-body pt-2">
                    @if(isset($default_questions) && $default_questions->count()>0)
                        @foreach($default_questions as $default)
                        <!--begin::Item-->
                        <div class="d-flex align-items-center mb-8">
                            <!--begin::Bullet-->
                            <span class="bullet bullet-vertical h-40px bg-primary"></span>
                            <!--end::Bullet-->
                            <div class="form-check form-check-custom form-check-solid mx-5">
                                <input class="form-check-input qstn_check" type="radio" name="quesval" value="{{$default->question}}" />
                            </div>
                            <!--begin::Description-->
                            <div class="flex-grow-1">
                            
                                <span class="text-muted fw-bold d-block">{{$default->question}}</span>
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end:Item-->
                        @endforeach
                    @endif
                </div>

            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal body-->
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary insertqstn"  id="save_hire" >
                <span class="indicator-label">Insert</span>
                <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
                        <!--end::Modal - New Card-->