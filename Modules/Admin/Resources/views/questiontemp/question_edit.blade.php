@csrf
@if(isset($question))
@method('PUT')
@endif
<!--begin::Scroll-->
<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_question_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_question_header" data-kt-scroll-wrappers="#kt_modal_edit_question_scroll" data-kt-scroll-offset="300px">

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Question</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="question" maxlength="300" class="form-control mb-3 mb-lg-0" placeholder="Enter Question" value="@isset($question->question){{$question->question}}@endisset" />
        <div class="form-text">Maximum 300 characters allowed.</div>
        <!--end::Input-->
    </div>
    <!--end::Input group-->

</div>
<!--end::Scroll-->
<!--begin::Actions-->

<!--end::Actions-->
