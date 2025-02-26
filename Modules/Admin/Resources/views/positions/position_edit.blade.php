@csrf
@if(isset($position))
@method('PUT')
@endif
<input type='hidden' id='position_id' name='position_id'  />
<input type="hidden" name="status" @if (@isset ($position->status) && $position->status == "0") value="0" @else value="1" @endif />
<input type="hidden" name="editempid" id="editempid" @if (@isset ($position->employer_id)) value="{{$position->employer_id}}" @endif/>
<input type="hidden" name="edit" value="edit" >
<!--begin::Scroll-->
<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_position_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_position_header" data-kt-scroll-wrappers="#kt_modal_edit_position_scroll" data-kt-scroll-offset="300px">

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Position Name</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="name" class="form-control mb-3 mb-lg-0" placeholder="Position name" value="@isset($position->name){{$position->name}}@endisset" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Description</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="position_description" id="position_description" class="form-control mb-3 mb-lg-0" placeholder="Position Description" value="@isset($position->description){{$position->description}}@endisset" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->

   
    <!--begin::Input group-->
    <div class="mb-7">
       <!--begin::Input group-->
            <div class="d-flex flex-stack w-lg-50">
                <!--begin::Label-->
                <div class="me-5">
                    <label class="fs-6 fw-bold form-label">Status</label>
                    <!-- <div class="fs-7 fw-bold text-muted">If you need more info, please check budget planning</div> -->
                </div>
                <!--end::Label-->

                <!--begin::Switch-->
                <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input check_status" type="checkbox" @if (@isset ($position->status) && $position->status == '0') value="0" @else checked="checked" value="1" @endif name="status_hidden" >
                    <span class="form-check-label fw-bold text-muted">
                    </span>
                </label>
                <!--end::Switch-->
            </div>
        <!--end::Input group-->
    </div>
    <!--end::Input group-->

</div>
<!--end::Scroll-->
<!--begin::Actions-->

<!--end::Actions-->
