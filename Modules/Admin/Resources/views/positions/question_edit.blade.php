@csrf
@if(isset($question))
@method('POST')
@endif
<input type="hidden"  id="max_qtn_attempt" name="max_qtn_attempt" value="{{$max_qtn_attempt}}">
<input type="hidden"  id="max_qtn_min" name="max_qtn_min" value="{{$max_qtn_min}}">
<input type='hidden' id='question_id' name='question_id'  />
<input type='hidden' id='employer_id' name='employer_id' @if (@isset ($question)) value="{{$question->employer_id}}" @else value="{{$position->employer_id}}" @endif   />
<input type='hidden' id='addedit_position_id' name='addedit_position_id'  @if (@isset ($question)) value="{{$question->position_id}}" @else value="{{$position->id}}" @endif  />
<input type="hidden" name="status" @if (@isset ($question->status) && $question->status == "0") value="0" @else value="1" @endif />
<input type="hidden" name="addoredit" @if (@isset ($question)) value="edit" @else value="add" @endif >
<!--begin::Scroll-->
<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_question_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_question_header" data-kt-scroll-wrappers="#kt_modal_edit_question_scroll" data-kt-scroll-offset="300px">

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Question</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="question" class="form-control mb-3 mb-lg-0" maxlength="300" placeholder="Enter Question" value="@isset($question->question){{$question->question}}@endisset" />
        <div class="form-text">Maximum 300 characters allowed.</div>
        <!--end::Input-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <div class="row mb-7">
            <div class="col-lg-6">
                <label class="required fs-5 fw-bold mb-2" for="max_attempts">Maximum Attempts</label>
                <input type="text" class="form-control" name="max_attempts"   placeholder="Enter max attempts allowed" value="@isset($question->allowed_attempts){{$question->allowed_attempts}}@endisset" />
            </div>
            <div class="col-lg-6">
                <label class="required fs-5 fw-bold mb-2" for="max_minutes">Maximum Minutes</label>
                <input type="text" class="form-control" name="max_minutes"   placeholder="Enter no of minutes allowed" value="@isset($question->allowed_ans_time){{$question->allowed_ans_time}}@endisset" /> 
            </div>
        </div>
    </div>
    <!--end::Input group-->


</div>
<!--end::Scroll-->
<!--begin::Actions-->

<!--end::Actions-->
