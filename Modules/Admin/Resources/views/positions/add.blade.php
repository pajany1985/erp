@extends('admin::layouts.master')
@section('pagetitle','Manage Position')

@section('content')

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_create_account_stepper">
            <!--begin::Aside-->
            <div class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px me-9">
                <!--begin::Wrapper-->
                <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
                    <!--begin::Nav-->
                    <div class="stepper-nav">
                        <!--begin::Step 1-->
                        <div class="stepper-item current" data-kt-stepper-element="nav">
                            <!--begin::Line-->
                            <div class="stepper-line w-40px"></div>
                            <!--end::Line-->
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">1</span>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">Basic Position Details</h3>
                                <div class="stepper-desc fw-bold">Setup Your Basic Position Information</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Step 1-->
                        <!--begin::Step 2-->
                        <div class="stepper-item" data-kt-stepper-element="nav">
                            <!--begin::Line-->
                            <div class="stepper-line w-40px"></div>
                            <!--end::Line-->
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">2</span>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">Create Questions</h3>
                                <div class="stepper-desc fw-bold">Setup Your Questions </div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Step 2-->
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="card d-flex flex-row-fluid flex-center">
                <!--begin::Form-->
                <form class="card-body py-20 w-100 w-xl-700px px-9"  id="kt_create_position_form" method="post" enctype="multipart/form-data"  action="{{ route('positions.store') }}">
                    <!--begin::Step 1-->

                    <div class="current" data-kt-stepper-element="content">
                           @csrf
                        <input type="hidden"  id="max_qtn_allowed" name="max_qtn_allowed" >
                        <input type="hidden"  id="max_qtn_attempt" name="max_qtn_attempt" >
                        <input type="hidden"  id="max_qtn_min" name="max_qtn_min" >
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-5 pb-lg-10">
                                <!--begin::Title-->
                                <h2 class="fw-bolder d-flex align-items-center text-dark">Enter Your Basic position Details
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Account Information About Employer"></i></h2>
                                    <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-12">
                                        <label class="required fs-5 fw-bold mb-2" for="name">Position Name</label>
                                        <input type="text" class="form-control" name="name"  id="name" placeholder="Position Name"  required /> 
                                    </div>
                                </div>
                                <!--end::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-12">
                                        <!--end::Label-->
                                        <label class="required fs-5 fw-bold mb-2">Position Description</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea name="position_description" id="position_description" class="form-control"></textarea>
                                        <!--end::Input-->
                                    </div>
                                </div>

                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-12">
                                        <label class="required fs-5 fw-bold mb-2" for="employer_id">Employer</label>
                                        <select name="employer_id" id="employer_id" data-control="select2"  data-placeholder="Select a Employer..." class="form-select" data-allow-clear="true">
                                            <option></option>
                                            @foreach ($employers as $key=>$employer)
                                                <option value="{{$employer->id}}" data-maxqstnattemp="{{$employer->package->max_retake_question}}" data-maxqstnmin="{{$employer->package->question_max_min}}"  data-package_maxquestion="{{$employer->package->max_question}}" >{{ucfirst($employer->first_name)}} {{ucfirst($employer->last_name)}} - {{ucfirst($employer->company_name)}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-stack col-lg-6">
                                <!--begin::Label-->
                                <div class="me-5">
                                    <label class="fs-6 fw-bold form-label">Position Status</label>
                                </div>
                                <!--end::Label-->
                                <!--begin::Switch-->
                                <input type="hidden" name="status" value="1"  />
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input check_status"  type="checkbox" checked="checked" value="1"  name="status_hidden" />
                                </label>
                                <!--end::Switch-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 1-->
    
                     <!--begin::Step 4-->
                     <div data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-10 pb-lg-15">
                                <!--begin::Title-->
                                <h2 class="fw-bolder text-dark">Create Assessment Questions</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <!--begin::Repeater-->
                                <div id="kt_question_repeater">
                                    <!--begin::Form group-->
                                    <div class="form-group ">
                                        <div data-repeater-list="kt_question_repeater">
                                            <div data-repeater-item class="repeat_items">
                                                <div class="form-group  fv-row mb-5 border border-hover-primary p-7 rounded">
                                                    <div class="row mb-5">
                                                        <div class="col-lg-12">
                                                            <label class="required fs-5 fw-bold mb-2" for="question">Question</label>
                                                            <!-- <input type="text" class="form-control" name="question"   placeholder="Enter Question"   /> -->
                                                            <textarea class="form-control " maxlength="300" placeholder="Enter Question" name="question"  data-kt-autosize="true" required></textarea> 
                                                            <div class="form-text">Maximum 300 characters allowed.</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-7">
                                                        <div class="col-lg-5">
                                                            <label class="required fs-5 fw-bold mb-2" for="max_attempts">Maximum Attempts</label>
                                                            <input type="text" class="form-control" name="max_attempts"   placeholder="Enter max attempts allowed"  />
                                                            
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <label class="required fs-5 fw-bold mb-2" for="max_minutes">Maximum Minutes</label>
                                                            <input type="text" class="form-control" name="max_minutes"   placeholder="Enter no of minutes allowed"  />
                                                        </div>
                                                        <div class="col-lg-2 text-end">
                                                            <a href="javascript:;" data-repeater-delete name="deletebtn" class="btn btn-sm btn-light-danger mt-3 mt-md-9 ">
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
                           
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 4-->

                    <!--begin::Actions-->
                    <div class="d-flex flex-stack pt-10">
                            <!--begin::Wrapper-->
                            <div class="mr-2">
                                <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="currentColor" />
                                            <path d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Back</button>
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Wrapper-->
                        <div>
                            <button type="button" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
                                <span class="indicator-label">Submit
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-3 ms-2 me-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                            <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon--></span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-4 ms-1 me-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                            <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                            </button>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Stepper-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@endsection

@section('scripts')
<script src="{{asset('js/formrepeater.bundle.js')}}"></script>
<script src="{{asset('js/Tachyons.min.js')}}"></script>
<script src="{{asset('js/admin/positions/add.js')}}"></script>
@endsection