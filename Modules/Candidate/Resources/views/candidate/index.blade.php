@extends('candidate::layouts.master')
@section('pagetitle','Manage Interview')
@section('content')
<!--begin::Container-->
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid mt-15" id="kt_content">
        @if($completion != '3') 
            @if(session('runtest')=='')
                <div class="d-flex align-items-center bg-primary rounded p-5 mb-7">

                    <!--begin::Title-->
                    <!-- <div class="flex-grow-1 pt-1 me-2 text-gray-100">
                        <span class="fw-bolder text-gray-100 fs-6">Recommended:</span> Test your camera & microphone before beginning your interview
                    </div> -->
                    <!--end::Title-->
                    <!--begin::Lable-->
                    <!-- <a href="javascript:void(0);" class="fw-bolder text-white py-1 " data-bs-toggle="modal" data-bs-target="#mdldevice_test"><u>Run Test</u></a> -->
                    <!--end::Lable-->
                </div>
            @endif
        @endif

        <div class="mb-3 " >
        <span class="px-1 align-self-center text-nowrap text-dark fw-bolder mb-1 fs-6">Interviewing for {{ucfirst($position->name)}}</span> 
        </div>
        <!--begin::Row-->
        @if(isset($questions_det))
            @foreach($questions_det as $key => $question)
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header">
                        <h3 class="card-title">Question {{$key+1}}:</h3>
                        @if($question['attempt_exist'])
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-sm btn-success" ><i class="fa fa-check"></i>Completed</button>
                        </div>
                        @endif
                    </div>
                    <div class="tab-content py-4">
                            <!--begin:Tab pane-->
                            <div class="tab-pane active w-lg-1050px" id="kt_app_header_menu_pages_pages" role="tabpanel">
                                <!--begin:Row-->
                                <div class="row">
                                    <!--begin:Col-->
                                    <div class="col-lg-8 px-8">
                                        <!--begin:Row-->
                                        <div class="row">
                                            <!--begin:Col-->
                                            <div class="col-lg-6 mb-6 mb-lg-0">
                                                <!--begin:Menu section-->
                                                <div class="mb-6">
                                                    
                                                </div>
                                                <!--end:Menu section-->
                                                <!--begin:Menu section-->
                                                <div class="mb-6">
                                                    <!--begin:Menu heading-->
                                                    <h4 class="fs-6 fs-lg-4 fw-bold mb-3 ms-4">{{$question['question']}}</h4>
                                                    <!--end:Menu heading-->
                                                
                                                </div>
                                                <!--end:Menu section-->
                                                <!--begin:Menu section-->
                                                <div class="mb-0">
                                                    
                                                </div>
                                                <!--end:Menu section-->
                                            </div>
                                            <!--end:Col-->
                                            <!--begin:Col-->
                                            <div class="col-lg-6 mb-6 mb-lg-0 ">
                                                <!--begin:Menu section-->
                                                <div class="mb-6">
                                                    
                                                </div>
                                                <!--end:Menu section-->
                                                <!--begin:Menu section-->
                                                <div class="mb-6">
                                                    <div class="row">
                                                        <!-- Attempts start -->
                                                        <div class="col-6">
                                                            <!--begin:Menu heading-->
                                                            <h4 class="fs-6 fs-lg-4 text-muted mb-3 ms-4 text-center">Attempts</h4>
                                                            <div class="text-center">
                                                                <!--begin:Menu link-->
                                                                    <span class="text-dark fw-bolder mb-1 fs-3 " data-kt-countup="true" data-kt-countup-value="{{$question['attempt_left']}}">{{$question['attempt_left']}}</span>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu heading-->
                                                        </div>
                                                        <!-- Attempts End -->

                                                        <!-- Time Limit start -->
                                                        <div class="col-6">
                                                            <!--begin:Menu heading-->
                                                            <h4 class="fs-6 fs-lg-4 text-muted mb-3 ms-4 text-center">Time Limit</h4>
                                                            <div class="text-center">
                                                                <!--begin:Menu link-->
                                                                    <span class="text-dark fw-bolder mb-1 fs-3 " >{{numTimeFormatToAlpha($question['max_time'])}}</span>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu heading-->
                                                        </div>
                                                         <!-- Time Limit End -->
                                                    </div>
                                                </div>
                                                <!--end:Menu section-->
                                                <!--begin:Menu section-->
                                                <div class="mb-0">
                                                    
                                                </div>
                                                <!--end:Menu section-->
                                            </div>
                                            <!--end:Col-->
                                        
                                        </div>
                                        <!--end:Row-->
                                    </div>
                                    <!--end:Col-->

                                    <!--begin:Col-->
                                    <div class="col-lg-4" >
                                        <div class=" row" >
                                            <div class="col-1">
                                            </div>
                                            <div class="col-10">
                                                <!-- <img src="{{asset('media/stock/600x600/img-82.jpg')}}" class="rounded mw-100" alt=""> -->
                                                @if($question['record_file'] != '')
                                                    @if(file_exists(public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).$question['employer_id'].'/'.$question['record_file']))
                                                        <div class="card overlay overflow-hidden "  >
                                                            <div class="card-body p-0">
                                                                <div class="overlay-wrapper">
                                                                    <video src="{{asset(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')) .'/'.$question['employer_id'].'/'.$question['record_file'] }}"id="upload_videotag{{$key}}"  width="240" class="h-210px w-100 d-lg-block"   style="float:right;">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25 " id="custom-opacity{{$key}}" style="opacity:1">
                                                                    <div class="videodiv" data-keyval="{{$key}}">
                                                                        <img src="{{asset('media/svg/misc/video-play.svg')}}" class="h-60px "  id="videoplay{{$key}}" alt="" >
                                                                    </div>
                                                                    <div class="videodivpause" data-keyval="{{$key}}">
                                                                        <img src="{{asset('media/svg/misc/pause.png')}}" class="h-30px "  id="videopause{{$key}}" style="display:none; opacity:0.5;" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="border-gray-100 border  py-16 bg-dark bg-opacity-25 d-none d-lg-block">
                                                            <span class="text-dark fw-bolder d-block text-center">
                                                            {{Str::upper('Video Deleted')}}</span>
                                                            <span class="text-dark fw-bolder mb-1 fs-3"></span>
                                                        </div>
                                                    @endif
                                                @else
                                                <div class="border-gray-100 border  py-16 bg-dark bg-opacity-25 d-none d-lg-block">
                                                    <span class="text-dark fw-bolder d-block text-center">
                                                    {{Str::upper('UnAnswered')}}</span>
                                                    <span class="text-dark fw-bolder mb-1 fs-3"></span>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-1">
                                            </div>
                                        </div>

                                    </div>
                                    <!--end:Col-->
                                </div>
                                <!--end:Row-->
                            </div>
                            <!--end:Tab pane-->
                            
                    </div>
                    @if($completion != '3') 
                    <div class="card-footer quiz-footer text-end">
                        @if($question['attempt_exist'] && $question['attempt_left'] > 0 )
                            <button type="submit" class="btn btn-sm btn-warning qstndetail" data-url="/ques/{{encryptId($question['id'])}}" data-indexid="{{$key}}" >
                                ReTake
                            </button>
                        @elseif(!$question['attempt_exist'])
                            <button type="submit" class="btn btn-sm btn-primary qstndetail" data-url="/ques/{{encryptId($question['id'])}}" data-indexid="{{$key}}" >
                                Start
                            </button>
                        @endif
                    </div>
                    @endif
                </div>
            @endforeach
        @endif
        <!--end::Row-->
        @if($qcompleted &&  $completion != '3')       
        <div class="row p-3 text-center">   
        <div class='col-md-12'>     
                <button type="submit" class="btn btn-sm btn-primary px-12 " data-bs-toggle="modal" data-bs-target="#kt_modal_completeall" data-backdrop="static" data-keyboard="false">Submit</button>  
            </div>
        </div>
        @endif    


        <!-- Modal start -->
        <div class="modal fade" tabindex="-1" id="mdldevice_test">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Testing your Camera & Microphone</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                            </span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <p class="mb-7">Move in front of your camera and speak so we can detect your camera & microphone.</p>
                        <div class="row">
                            <div class="col-6 pt-10">

                                <p>Testing your microphone 

                                    <span id='elem_mic'>    
                                        <span class="checkmedia spinner-border text-success spinner-border-sm align-middle ms-2"></span>
                                        
                                    </span>
                                </p>
                                <p>Testing your camera 
                                    <span  id='elem_camera'> 
                                        <span class="checkmedia spinner-border spinner-border-sm align-middle text-success ms-2"></span>
                                        <i class="fa fa-check text-success d-none"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="col-6" id='elem_strvideo'>
                                <video id="test_video" playsinline autoplay muted  width="100%" height="auto"> </video>
                                
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <p class='text-danger d-none failedblock'> We're having trouble connecting to your hardwares, Please try using a different browser or switch to a device with built-in capabilities.</p>
                        <button type="button" class="btn btn-primary  d-none successblock" data-bs-dismiss="modal">Continue</button>
                        <button type="button" class="btn btn-danger failedblock d-none" id='retry'>Retry</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end -->

        <!-- Modal completeall -->
        <div class="modal fade" tabindex="-1" id="kt_modal_completeall" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                <div class="modal-header border-0 pt-10 pb-2">
                    <h5 class="modal-title">Are you sure your ready to submit your answers?</h5>
                </div>
                    <div class="modal-body py-2">
                        
                        <p>If you'd like to review your answers or re-take a question, click 'Not Yet' to go back to the main screen.</p>
                    </div>

                    <div class="modal-footer border-0">
                        <input type="hidden" name="candid_id" value="{{Auth::user()->id}}" id="candid_id"> 
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Not Yet</button>
                        <button type="button" class="btn btn-primary allqstn_submit">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- Modal completeall end-->

    </div>
    <!--end::Post-->
</div>
<!--end::Container-->
@endsection

@section('scripts')
<script src="{{asset('js/candidate/candidate.js')}}"></script>
<script src="{{asset('js/candidate/device_test.js')}}?rand=<?php echo rand(); ?>"></script>
@endsection