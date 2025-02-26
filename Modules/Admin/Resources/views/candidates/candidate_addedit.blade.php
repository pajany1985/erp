@csrf
@if(isset($candidate))
@method('PUT')
@endif

<input type='hidden' id='candidate_id' name='candidate_id' value='@if(isset($candidate)){{$candidate->id}}@endif' />
<input type="hidden" name="addoredit" @if (@isset ($candidate)) value="edit" @else value="add" @endif >
<input type="hidden" name="saveandsendlink" id="saveandsendlink" value="0"/>
<input type="hidden" name="editempid" id="editempid" @if (@isset ($candidate->employer_id)) value="{{$candidate->employer_id}}" @endif/>
<input type="hidden" name="editposition_id" id="editposition_id" @if (@isset ($candidate->position_id)) value="{{$candidate->position_id}}" @endif/>
<input type="hidden" name="status" id="status" @if (@isset ($candidate->status)) value="{{$candidate->status}}" @endif/>

<!--begin::Scroll-->
<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_candidate_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_candidate_header" data-kt-scroll-wrappers="#kt_modal_add_candidate_scroll" data-kt-scroll-offset="300px">
    <!--begin::Input group-->
    <div class="row mb-7">
        <div class="col-lg-6">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Candidate First Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group ">
                <span class="input-group-text">
                    <span class="svg-icon ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                    </span>
                </span>
                <input type="text" name="first_name" id="first_name" class="form-control mb-3 mb-lg-0" placeholder="First Name" value="@isset($candidate->first_name){{$candidate->first_name}}@endisset" />
            </div>
            <!--end::Input-->
        </div>
        <div class="col-lg-6">
            <!--begin::Label-->
            <label class="required fw-bold fs-6 mb-2">Last Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="input-group ">
                <span class="input-group-text">
                    <span class="svg-icon ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                    </span>
                </span>
                <input type="text" name="last_name" id="last_name" class="form-control mb-3 mb-lg-0" placeholder="Last Name" value="@isset($candidate->last_name){{$candidate->last_name}}@endisset" />
            </div>
            <!--end::Input-->
        </div>
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Email</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="input-group ">
            <span class="input-group-text">
                <span class="svg-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                    </svg>
                </span>
            </span>
            <input type="email" name="email" id="email" class="form-control mb-3 mb-lg-0" placeholder="example@domain.com" value="@isset($candidate->email){{$candidate->email}}@endisset" />
        </div>
        <!--end::Input-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-5">Employer</label>
        <!--end::Label-->
        <!--begin::Employers-->
        <select class="form-select" id="employer_id" name="employer_id" data-control="select2"  data-placeholder="Select an option" data-allow-clear="true" >
            <option></option>
        @foreach ($employers as $key=>$employer)
            <option value="{{$employer->id}}" @if (@isset ($candidate->employer_id) && $candidate->employer_id == $employer->id) checked='checked' @endif >{{ucfirst($employer->first_name)}} {{ucfirst($employer->last_name)}}</option>
        @endforeach 
        </select>
        <!--end::Employers-->
    </div>
    <!--end::Input group-->

       <!--begin::Input group-->
       <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-5">Position</label>
        <!--end::Label-->
        <!--begin::Positions-->
        <select disabled class="form-select " id="position_id" name="position_id" data-control="select2"  data-placeholder="Select an option" data-allow-clear="true" >
            <option></option>
        @foreach ($positions as $key=>$position)
            <option value="{{$position->id}}" @if (@isset ($candidate->position_id) && $candidate->position_id == $position->id) checked='checked' @endif >{{ucfirst($position->name)}}</option>
        @endforeach 
        </select>
        <!--end::Positions-->
    </div>
    <!--end::Input group-->

</div>
<!--end::Scroll-->
<!--begin::Actions-->

<!--end::Actions-->
