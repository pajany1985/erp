@extends('employer::layouts.master')
@section('pagetitle','Manage Interviews')

@section('content')

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">

    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row ">

            <div id="kt_toolbar_container" class="d-flex flex-stack flex-wrap m-5">
        <div class="page-title d-flex  flex-row align-items-start ">
            <!--begin::Title-->
           

             <!--begin::Title-->
                    <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">@if(isset($position)) Edit @else Add @endif Interview</h1>
                            <span class="h-20px border-gray-300 border-start mx-3 my-1"></span>
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 p-1 mx-0">
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="{{ route('position') }}" class="text-muted text-hover-primary">Interview</a>
                                        </li>
                                       
                                       
                                        <!--end::Item-->
                        </ul>                 
                  

                    <!--end::Title-->

            <!--end::Title-->
        </div>
    </div>
            
                
            <div class="col-xl-12 ">
                <!--begin::Row-->
                <!--begin::Card-->

                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header  pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 color-D6E">
                                    <!-- <i class="bi bi-pencil-fill fs-4 text-primary"></i> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#0086FF"><g><rect fill="none" height="24" width="24"/></g><g><g/><g><path d="M17,19.22H5V7h7V5H5C3.9,5,3,5.9,3,7v12c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2v-7h-2V19.22z"/><path d="M19,2h-2v3h-3c0.01,0.01,0,2,0,2h3v2.99c0.01,0.01,2,0,2,0V7h3V5h-3V2z"/><rect height="2" width="8" x="7" y="9"/><polygon points="7,12 7,14 15,14 15,12 12,12"/><rect height="2" width="8" x="7" y="15"/></g></g></svg>
                                    @if(isset($position)) Edit @else Add @endif Interview
                                </span>
                                <!--end::Svg Icon-->
                                    <span class="px-2">

                                    <span>
                            </div>
                                    <!--end::Search-->
                                    
                        </div>
                                <!--end::Card title-->

                    </div>

                        <!--end::Card header-->
                        <!--begin::Card body-->
                        @if(isset($position)) 
                        <form id="position_addfrm" class="form" method="post" action="/employer/position/{{$position_encryptid}}">
                        @method('PUT') 
                        @else 
                        <form id="position_addfrm" class="form" method="post" action="{{ route('position.store') }}"> 
                        @endif
                            <div class="card-body pt-10">
                            @csrf

                                <input type="hidden"  id="max_qtn_allowed" name="max_qtn_allowed" value="{{$employer->package->max_question}}">
                                <input type="hidden"  id="max_qtn_attempt" name="max_qtn_attempt" value="{{$employer->package->max_retake_question}}" >
                                <input type="hidden"  id="max_qtn_min" name="max_qtn_min" value="{{$employer->package->question_max_min}}">
                                <input type="hidden"  id="repeatinput_name" name="repeatinput_name" >
                                <input type="hidden"  id="draft_ornot" name="draft_ornot" >
                                <input type="hidden"  id="storageallow" name="storageallow"  value="{{$storagedetails['allow_recording']}}">
                                <input type="hidden"  id="addmore_button" name="addmore_button" value="@if(isset($position->questions)){{$position->questions->count()}}@endif" >
                                <input type="hidden"  id="create_positionallowed" name="create_positionallowed"  value="{{$isposition_createallowed}}">

                                <div class="form-group  fv-row mb-5 p-7 rounded">
                                    <div class="row mb-6">
                                        <label class="col-md-3 col-sm-12  col-form-label required fw-bold fs-6">Position Title</label>
                                        <div class="col-md-9 col-sm-12">
                                            <div class="row">
                                                <input type="text" name="position_title" class="form-control form-control-lg " placeholder="Position Title" value="@if(isset($position)){{$position->name}}@endif" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <label class="col-md-3 col-sm-12  col-form-label required fw-bold fs-6">Interview Description</label>
                                        <div class="col-md-9 col-sm-12">
                                            <div class="row">
                                                <textarea name="position_description" id="position_description" class="form-control" placeholder="Enter Description of Interview">@if(isset($position)){{$position->description}}@endif</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="kt_question_repeater">
                                    <div data-repeater-list="kt_question_repeater">
                                        @if(isset($position->questions) && $position->questions->count()>0)
                                            @foreach($position->questions as $key => $question)
                                                <div data-repeater-item class="repeat_items ">
                                                    <div class="form-group  fv-row mb-5 border border-hover-primary p-7 rounded">

                                                        <div class="form-group  row mb-3">
                                                            <label class="col-md-3 col-sm-12 col-form-label  fw-bold fs-6"></label>
                                                            <div class="col-md-9 col-sm-12 col-lg-9 px-0 pb-10 mb-5">
                                                                    <p class="use_template_btn_pos" style="position: absolute;right: 9px;">                                                                
                                                                        <span style="padding-right:0.5rem">
                                                                            <button type="button" class="btn btn-primary btn-icon-sm questemplate"  name="usetemplate" style="/* padding: 0.35rem 1rem;margin: 6px; */" >
                                                                                <svg xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18" fill="#fff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9h-4v4h-2v-4H9V9h4V5h2v4h4v2z"></path></svg>
                                                                                Use a template
                                                                            </button>
                                                                        </span>                                                             
                                                                    </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group  row mb-2 ">
                                                            <label class="col-md-3 col-sm-12 col-form-label required fw-bold fs-6" name="questionlabel">Question {{$key+1}}</label>
                                                            <div class="col-md-9 col-sm-12 col-lg-9 px-0  pt-5">
                                                                <!-- <input type="text" class="form-control questiondiv" name="question" placeholder="Enter Question" value="{{$question->question}}"> -->
                                                                <textarea class="form-control questiondiv" maxlength="300" placeholder="Enter Question" name="question" value="{{$question->question}}" data-kt-autosize="true">{{$question->question}}</textarea>
                                                                <div class="form-text">Maximum 300 characters allowed.</div>
                                                            </div>
                                                        </div>
                                                        <div class="row pt-10">

                                                            <div class="col-3"></div>  
                                                            <div class="col-md-9 col-sm-12 px-0">
                                                                <div class="row">
                                                                    <input type="hidden" name="time_minsec" >
                                                                    <input type="hidden" name="allowed_time_min" >
                                                                    <input type="hidden" name="db_time_min" value="@if($question->allowed_ans_time!='0'){{timetoseconds($question->allowed_ans_time)}}@else {{$employer->package->question_max_min * 60}}@endif">
                                                                    <input type="hidden" name="db_time_sec" value="@if($question->minsec_enablebtn!='0'){{$question->minsec_enablebtn}}@else {{10}}@endif">

                                                                    <div class="col-4 col-lg-3 color-D6E">Time Limit</div>
                                                                    <div class="col-8 col-lg-4 pt-2 mb-5"> <div id="kt_slider_basic1" name="min_maxslider" class="kt_slider_sizes_sm noUi-sm "></div></div>
                                                                    <div class="col-md-8 col-sm-12 col-lg-5 color-D6E">
                                                                        <div class="row">
                                                                            <div class='col-7 '>Required Minimum</div>
                                                                            <div class='col-5 text-end'><span name="minval" class="minval1">{{$question->minsec_enablebtn}}</span> Sec</div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class='col-7'>Maximum</div>
                                                                            <div class='col-5 text-end '><span name="maxval" class="maxval1">{{$question->allowed_ans_time}}</span> Min</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row pt-10">

                                                            <div class="col-3"></div>  
                                                            <div class="col-md-9 col-sm-12 px-0">
                                                                <div class="row">
                                                                    <div class="col-5 col-lg-3 pt-3 color-D6E">Attempts Allowed</div>
                                                                    <div class="col-5 col-lg-7">
                                                                        <div class="input-group w-md-125px" data-kt-dialer="true" data-kt-dialer-min="1" data-kt-dialer-max="{{$employer->package->max_retake_question}}" data-kt-dialer-step="1" data-kt-dialer-prefix="">
                                                                            <!--begin::Decrease control-->
                                                                            <button class="btn btn-icon btn-outline btn-outline-secondary" type="button" data-kt-dialer-control="decrease">
                                                                                <i class="bi bi-dash fs-1"></i>
                                                                            </button>
                                                                            <!--end::Decrease control-->
                                                                            <!--begin::Input control-->
                                                                            <input type="text" class="form-control" name="attempts_allowed" readonly="readonly"  value="{{$question->allowed_attempts}}" data-kt-dialer-control="input" >
                                                                            <!--end::Input control-->
                                                                            <!--begin::Increase control-->
                                                                            <button class="btn btn-icon btn-outline btn-outline-secondary" type="button" data-kt-dialer-control="increase">
                                                                                <i class="bi bi-plus fs-1"></i>
                                                                            </button>
                                                                            <!--end::Increase control-->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2 text-end">
                                                                        <a href="javascript:;" data-repeater-delete name="deletebtn" class="btn btn-sm btn-light-danger  ">
                                                                            <i class="la la-trash-o fs-3"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="separator mt-10 mb-5"></div> -->
                                                        <div class="separator my-10"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div data-repeater-item class="repeat_items ">
                                                <div class="form-group  fv-row mb-5 border border-hover-primary p-7 rounded">

                                                    <div class="form-group  row mb-3">
                                                        <label class="col-md-3 col-sm-12 col-form-label  fw-bold fs-6"></label>
                                                        <div class="col-md-9 col-sm-12 col-lg-9 px-0 pb-10 mb-5">
                                                                <p class="use_template_btn_pos" style="position: absolute;right: 9px;">                                                                
                                                                    <span style=" padding-right:0.5rem ">
                                                                        <button type="button" class="btn btn-primary btn-icon-sm questemplate "  name="usetemplate" style="/* padding: 0.35rem 1rem;margin: 6px; */" >
                                                                            <svg xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18" fill="#fff"><path d="M0 0h24v24H0z" fill="none"></path><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9h-4v4h-2v-4H9V9h4V5h2v4h4v2z"></path></svg>
                                                                            Use a template
                                                                        </button>
                                                                    </span>                                                             
                                                                </p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  row mb-2 ">
                                                        <label class="col-md-3 col-sm-12 col-form-label required fw-bold fs-6" name="questionlabel">Question 1</label>
                                                        <div class="col-md-9 col-sm-12 col-lg-9 px-0  ">
                                                            <!-- <input type="text" class="form-control questiondiv" name="question" placeholder="Enter Question"> -->
                                                            <textarea class="form-control questiondiv" maxlength="300" placeholder="Enter Question" name="question"  data-kt-autosize="true"></textarea>
                                                            <div class="form-text">Maximum 300 characters allowed.</div>
                                                        </div>
                                                    </div>
                                                    <div class="row pt-10">

                                                        <div class="col-3"></div>  
                                                        <div class="col-md-9 col-sm-12 px-0">
                                                            <div class="row">
                                                                <input type="hidden" name="time_minsec" >
                                                                <input type="hidden" name="allowed_time_min" >
                                                                <input type="hidden" name="db_time_min" >
                                                                <input type="hidden" name="db_time_sec" value="10">
                                                                <div class="col-4 col-lg-3 color-D6E">Time Limit</div>
                                                                <div class="col-8 col-lg-4 pt-2 mb-5"> <div id="kt_slider_basic1" name="min_maxslider" class="kt_slider_sizes_sm noUi-sm "></div></div>
                                                                <div class="col-md-8 col-sm-12 col-lg-5 color-D6E">
                                                                    <div class="row">
                                                                        <div class='col-7'>Required Minimum</div>
                                                                        <div class='col-5 text-end'><span name="minval" class="minval1">10</span> Sec</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class='col-7'>Maximum</div>
                                                                        <div class='col-5 text-end '><span name="maxval" class="maxval1">{{$employer->package->question_max_min * 60}}</span> Min</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row pt-10">

                                                        <div class="col-3"></div>  
                                                        <div class="col-md-9 col-sm-12 px-0">
                                                            <div class="row">
                                                                <div class="col-5 col-lg-3 pt-3 color-D6E">Attempts Allowed</div>
                                                                <div class="col-5 col-lg-7">
                                                                    <div class="input-group w-md-125px" data-kt-dialer="true" data-kt-dialer-min="1" data-kt-dialer-max="{{$employer->package->max_retake_question}}" data-kt-dialer-step="1" data-kt-dialer-prefix="">
                                                                        <!--begin::Decrease control-->
                                                                        <button class="btn btn-icon btn-outline btn-outline-secondary" type="button" data-kt-dialer-control="decrease">
                                                                            <i class="bi bi-dash fs-1"></i>
                                                                        </button>
                                                                        <!--end::Decrease control-->
                                                                        <!--begin::Input control-->
                                                                        <input type="text" class="form-control" name="attempts_allowed" readonly="readonly"  value="1" data-kt-dialer-control="input" >
                                                                        <!--end::Input control-->
                                                                        <!--begin::Increase control-->
                                                                        <button class="btn btn-icon btn-outline btn-outline-secondary" type="button" data-kt-dialer-control="increase">
                                                                            <i class="bi bi-plus fs-1"></i>
                                                                        </button>
                                                                        <!--end::Increase control-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 text-end">
                                                                    <a href="javascript:;" data-repeater-delete name="deletebtn" class="btn btn-sm btn-light-danger  ">
                                                                        <i class="la la-trash-o fs-3"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="separator mt-10 mb-5"></div> -->
                                                    <div class="separator my-10"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="pt-4 px-3 color-D6E">Max Question Slots Allowed: {{$employer->package->max_question}} Questions</div>
                                       
                                        <a  href="javascript:;" class="btn btn-primary " data-repeater-create id="addmore_question">
                                            <i class="bi bi-plus fs-1"></i>Add Question
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Card body-->
                </div>
                <!--end::Card-->

                @include('employer::positions.mdlques')

                <!--end::Row-->
            </div>
        </div>
    <div class="d-flex float-end pt-5">
        <button class="btn btn-light btn-active-light-primary mx-3 savedraft" id="draft_position_submit">
            <span class="indicator-label">Save Draft</span>
            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
        <!-- <button class="btn btn-primary savejob">Post Position</button> -->
        <button type="submit" id="post_position_submit" class="btn btn-primary savejob">
            <span class="indicator-label">Post Interview</span>
            <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
</div>

<!--end::Post-->



</div>
@endsection

@section('scripts')
<!-- <script src="https://cdn.jsdelivr.net/gh/T-vK/DynamicQuillTools@master/DynamicQuillTools.js"></script> -->
<script src="{{asset('js/formrepeater.bundle.js')}}"></script>
<script src="{{asset('js/employer/positions/positionadd.js')}}"></script>
<!--   <script src="{{asset('js/jquery.raty.js')}}?version={{rand()}}"></script> -->
@endsection