@extends('candidate::layouts.master')
@section('pagetitle','Manage Interview')
@section('content')
<style>
    .no-mirror {
    transform: scaleX(-1);
}
</style>
    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid mt-5" id="kt_content">
            
            <!--begin::Row-->
                <!-- <div class="row p-3"> -->
                    <!--begin::Tables Widget 5-->
                    <div class="card card-bordered  mb-xl-8">
                        <form class="form" novalidate="novalidate"  method="post" action="/" id="mediatest">
                            <input type="hidden" value="{{$candidate_id}}" id="candidate_id" name="candidate_id">
                            <div class="card-header">
                                <h3 class="card-title">Testing your Camera & Microphone</h3>
                                <div class="card-toolbar">
                                    
                                </div>
                            </div>
                            <!--begin::Body-->
                            <div class="card-body ">
                                <div class="row mb-5 ">
                                    <div class="col-xl-3">
                                    </div>
                                    <div class="col-xl-6">
                                        <p class="mb-7">Move in front of your camera and speak so we can detect your camera & microphone.</p>
                                        <div class="row">
                                            <div class="col-md-6 pt-10" id="mdldevice_test">

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
                                            <div class="col-md-6" id='elem_strvideo'>
                                                <video id="test_video" playsinline autoplay muted  width="100%" height="auto" class="no-mirror"> </video>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                            <div class="card-footer text-center"> 
                                <p class='text-danger d-none failedblock'> We're having trouble connecting to your hardware. Please try using a different browser or switch to a device with built-in hardware capabilities.</p>
                                <button type="button" class="btn btn-primary  d-none successblock tocontinuemedia">
                                    <span class="indicator-label">Continue</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <button type="button" class="btn btn-danger failedblock d-none" id='retry'>
                                    <span class="indicator-label">Retry</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!-- <button type="submit"  class="btn btn-sm btn-primary tocontinuemedia">
                                    <span class="indicator-label">Continue</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button> -->
                            </div>
                        </form>
                    </div>
                    <!--end::Tables Widget 5-->
                <!-- </div> -->
            <!--end::Row-->

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection

@section('scripts')
<!-- <script src="{{asset('js/candidate/candidate.js')}}"></script> -->
<script src="{{asset('js/candidate/device_test.js')}}?rand=<?php echo rand(); ?>"></script>
@endsection