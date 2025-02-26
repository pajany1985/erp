@extends('candidate::layouts.master')
@section('pagetitle','Manage Interview')
@section('content')
<style>
	.overlay {
        background: 'grey';
    opacity: '0.75';
    min-height: 215px;
    display: -webkit-box;
    display: -ms-flexbox;
    /* display: flex; */
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    /* justify-content: center; */
    width: 285px;
    /* top: -16px; */
    background-color: grey;
     border-radius: 6px;

}
.overlay h3 {
   
    color: #ffffff;
    font-weight: 600;
    margin: 2rem 3rem 0;
    mix-blend-mode: overlay;
    padding: 5px 15px;
    text-align: center;
    width: '100%';
    text-transform: uppercase;

}
.no-mirror {
    transform: scaleX(-1);
}
</style>

		<!--begin::Container-->
		<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
			<!--begin::Post-->
			<div class="content flex-row-fluid mt-9" id="kt_content">

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
				<div class="mb-1 text-center" >
				<span class="px-1 align-self-center text-dark fw-bolder  fs-6">Interviewing for {{ucfirst($position->name)}}</span> 
				
				</div>
				

				<!--begin::Stepper-->
					<div class="stepper stepper-pills" id="kt_stepper_example_basic1">
						<!--begin::Nav-->
						<div class="stepper-nav flex-center flex-wrap mb-2">
							<!--begin::Step 1-->
							@foreach($questions_det as $key => $question)
								<div class="stepper-item  my-4 @if($question['current_step']==1)current @elseif($question['attempt_exist']==1) completed @endif" data-stepid="{{($key+1)}}" data-kt-stepper-element="nav" data-kt-stepper-action="step">
									<!-- <div class="stepper-line w-40px"></div> -->
									<!--begin::Icon-->
									<div class="stepper-icon customstep mx-0 h-10px w-50px" style="border:1px #009ef7 solid;">
										<span class="stepper-check "></span>
										<span class="stepper-number fs-5"></span>
									</div>
									<!--end::Icon-->
								</div>
							@endforeach
							<!--end::Step 1-->
						</div>
						<!--end::Nav-->

							<input type="hidden" name="candid_id" id="candid_id" value="{{$candidate_id}}">
							<!--begin::Form-->
								<div class="mb-5">
									<!--begin::Step 1-->
									@foreach($questions_det as $key => $question)
										<div class="flex-column @if($question['current_step']==1)current @elseif($question['attempt_exist']==1) completed @endif" data-kt-stepper-element="content">
											
											<div class="card mb-1 mb-xl-8">
												<input type='hidden' name='cid' id='cid_{{$key+1}}' value='{{ $enpt_candidid }}' >
												<input type='hidden' name='qid' id='qid_{{$key+1}}' value="{{encryptId($question['id'])}}" >
												<input type='hidden' name='auth_token' id='auth_token_{{$key+1}}' value="{{$question['auth_token']}}" >
												<input type="hidden" name="recorded_sec" id="recorded_sec_{{$key+1}}">


												<div class="tab-content py-lg-10">
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
																				<h4 class="fs-6 fs-lg-4 fw-bold mb-3 ms-4">{{$key+1}}. {{$question['question']}}</h4>
																				<!--end:Menu heading-->
																			
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
																			<div  class="text-center" width="100" id='videoelement_{{$key+1}}'>

																				<!--begin::Card-->
																				<div class="card overlay overlay-block" id='streamBlock_{{$key+1}}' style="width: auto;display:inline-flex;">
																					<div class="card-body p-0">
																						<div class="overlay-wrapper" id="stremdiv_{{$key+1}}">
																							<!-- <video id="streamVideo_{{$key+1}}" playsinline autoplay muted  width="100%" height="auto"> </video>  -->
																							
																						</div>
																						<div class="overlay-layer card-rounded bg-dark bg-opacity-25">

																							<h3 id='notrecording_{{$key+1}}' class="notrecording_{{$key+1}}" style='display:none;'>Not Recording</h3>
																							<h3 id='counter_{{$key+1}}' class="counter_{{$key+1}}" style='display:none;font-size: 50px'></h3>
																						</div>
																					</div>
																				</div>
																				<!--end::Card-->

																				<!--begin::Card-->
																				<div class="card d-none overlay overlay-block" id='playblock_{{$key+1}}' style="width: auto;cursor:default;display:inline-flex;">
																					<div class="card-body p-0">
																							<div class="overlay-wrapper" id="viddiv_{{$key+1}}">
																								<!-- <video id="playvideo_{{$key+1}}"  width="100%" height="auto"> </video>   -->
																							</div>
																							<div class="overlay-layer card-rounded bg-dark bg-opacity-25 " id="custom-opacity_{{$key+1}}">
																								<div class="videodiv_{{$key+1}}">
																									<img src="{{asset('media/svg/misc/video-play.svg')}}" class="h-60px "  id="videoplay_{{$key+1}}" alt="">
																								</div>
																							</div>
																					</div>
																				</div>
																				<!--end::Card-->





																			</div>
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
												
												<div class="d-flex flex-stack flex-wrap gap-2 py-5 ps-8 pe-5 border-top">
													<!--begin::Actions-->
														<div class="btn-group me-4">
															<span>Attempts Left: <span class="text-dark fw-bolder mb-1 fs-6 attempt_{{$key+1}}" data-attempt="{{$question['attempt_left']}}">{{$question['attempt_left']}}</span></span>
														</div>

														<div class="btn-group me-4 timecount_{{$key+1}}">
															<span>Time Left:<span class="text-dark fw-bolder mb-1 fs-6 countdown_{{$key+1}}" data-timecount="{{$question['max_time']}}" data-minsec="{{$question['minsec_enablebtn']}}" data-timedisplay=" {{numTimeFormatToAlpha($question['max_time'])}}"> {{numTimeFormatToAlpha($question['max_time'])}}</span></span>
														</div>
													<!--end::Actions-->
													
												</div>
											</div>
										</div>
									@endforeach
									<!--begin::Step 1-->
								</div>
								<!--end::Group-->

								<!--begin::Actions-->
								<!-- <div class="d-flex flex-stack"> -->

										<div class="text-center">
											<!--begin::Toolbar-->
											<div class="startfunction">
												<button href="javascript:void(0);" id='record' class="btn btn-primary  w-100 w-lg-300px w-xl-300px startrecord">
													Start Recording
												</button>
												<button href="javascript:void(0);" class="btn  w-100 btn-dark w-100 w-lg-300px w-xl-300px stoprecord" style="display:none;" disabled>
													Stop Recording
												</button>
											</div>
											<div class="completefunction   " style="display:none;">
											<div class="d-flex justify-content-center">
												<button href="javascript:void(0);" class="btn  btn-warning retakerecord w-25 w-lg-100px w-xl-100px w-xxl-100px">
													Re-take
												</button>
												<div class="w-25px mid_div"> </div>
												<!-- <button type="button" id="submitrecord" class="btn  btn-success submitrecord w-75 w-lg-300px w-xl-300px w-xxl-300px" >
													<span class="indicator-label">
														Submit
													</span>
													<span class="indicator-progress">
														Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2 "></span>
													</span>
												</button> -->
												<a href="javascript:void(0);"id="submitrecord" class="btn  btn-success submitrecord w-75 w-lg-300px w-xl-300px w-xxl-300px" style="display:none;pointer-events:none;" >
												Submit
												</a>

												<button type="button" class="btn  btn-primary completerecord w-75 w-lg-300px w-xl-300px w-xxl-300px" data-kt-stepper-action="next">
													Continue
												</button>
											</div>
												<!-- <button type="button" class="btn btn-sm btn-primary completerecord">
													<span class="indicator-label">Done</span>
													<span class="indicator-progress">Please wait...
													<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
												</button> -->
											</div>
											<!--end::Toolbar-->
										</div>
								<!-- </div> -->
								<!--end::Actions-->
							<!--end::Form-->
					</div>
				<!--end::Stepper-->

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
											<video id="test_video" playsinline autoplay muted  width="100%" height="auto" class="no-mirror"> </video>
											
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<p class='text-danger d-none failedblock'> We're having trouble connecting to your hardwares, Please try again or switch to different device.</p>
									<!--<button type="button" class="btn btn-primary  d-none successblock" data-bs-dismiss="modal">Continue</button>-->
									<button type="button" class="btn btn-danger failedblock d-none" id='retry'>Retry</button>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal end -->
			
			</div>
			<!--end::Post-->
			
			
        </div>
        <!--end::Container-->
		
        @endsection

        @section('scripts')
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script src="{{asset('js/candidate/record.js')}}?rand=<?php echo rand(); ?>"></script>
		
        @endsection