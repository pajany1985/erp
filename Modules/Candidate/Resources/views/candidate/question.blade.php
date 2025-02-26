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
			<div class="content flex-row-fluid mt-15" id="kt_content">

				<div class="mb-3 " >
				<span class="px-1 align-self-center text-nowrap text-dark fw-bolder mb-1 fs-6">Interviewing for {{ucfirst($question->position->name)}}</span> 
				
				</div>
				

				<div class="card mb-5 mb-xl-8">
					<input type='hidden' name='cid' id='cid' value='{{ $enpt_candidid }}' >
					<input type='hidden' name='qid' id='qid' value='{{ $qid }}' >
					<input type='hidden' name='auth_token' id='auth_token' value='{{ $auth_token }}' >
					<div class="card-header">
						<h3 class="card-title">Question @if (session('qstn_index')) {{ session('qstn_index') }} @endif:</h3>
						<div class="card-toolbar">
						</div>
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
												<div  class="text-center" width="100" id='videoelement'>

													<!--begin::Card-->
													<div class="card overlay overlay-block" id='streamBlock'>
														<div class="card-body p-0">
															<div class="overlay-wrapper">
																<video id="streamVideo" playsinline autoplay muted  width="100%" height="auto" class="no-mirror"> </video> 
																
															</div>
															<div class="overlay-layer card-rounded bg-dark bg-opacity-25">

																<h3 id='notrecording' style='display:none;'>Not Recording</h3>
																<h3 id='counter' style='display:none;font-size: 50px'></h3>
															</div>
														</div>
													</div>
													<!--end::Card-->

													<!--begin::Card-->
													<div class="card d-none overlay overlay-block" id='playblock' style="cursor:default;">
														<div class="card-body p-0">
																<div class="overlay-wrapper">
																	<video id="playvideo"  width="100%" height="auto"> </video>  
																</div>
																<div class="overlay-layer card-rounded bg-dark bg-opacity-25 " id="custom-opacity">
																	<div class="videodiv">
																		<img src="{{asset('media/svg/misc/video-play.svg')}}" class="h-60px "  id="videoplay" alt="">
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
									<span>Attempts Left: <span class="text-dark fw-bolder mb-1 fs-6 attempt" data-attempt="{{ $attempt_left }}">{{ $attempt_left }}</span></span>
								</div>

								<div class="btn-group me-4 timecount">
									<span>Time Left:<span class="text-dark fw-bolder mb-1 fs-6 countdown" data-timecount="{{$question->allowed_ans_time}}" data-minsec="{{$question->minsec_enablebtn}}"> {{numTimeFormatToAlpha($question->allowed_ans_time)}}</span></span>
								</div>
							<a href="javascript:void(0);" class="text-muted fw-bolder mb-1 fs-6 backto_overview ">Back to Overview</a>
							<!--end::Actions-->
							<!--begin::Toolbar-->

								<div class="startfunction">
									<button href="javascript:void(0);" id='record' class="btn btn-sm btn-primary startrecord">
										Start Recording
									</button>
									<button href="javascript:void(0);" class="btn btn-sm btn-danger stoprecord" style="display:none;" disabled>
										Stop Recording
									</button>
								</div>
								<div class="completefunction" style="display:none;">
									<button href="javascript:void(0);" class="btn btn-sm btn-warning retakerecord">
										Re-take
									</button>
									<!-- <button href="javascript:void(0);" class="btn btn-sm btn-primary completerecord">
										Done
									</button> -->
									<button type="button" class="btn btn-sm btn-primary completerecord">
										<span class="indicator-label">Done</span>
										<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
							<!--end::Toolbar-->
						</div>

					

				</div>
			</div>
			<!--end::Post-->
			
        </div>
        <!--end::Container-->
        @endsection

        @section('scripts')
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script src="{{asset('js/candidate/record.js')}}?rand=<?php echo rand(); ?>"></script>
        @endsection