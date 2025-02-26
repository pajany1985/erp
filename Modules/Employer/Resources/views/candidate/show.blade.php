@extends('employer::layouts.master')
@section('pagetitle','Manage Interviews')

@section('content')
   

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">

    <div class="content flex-row-fluid" id="kt_content">
     <div id="kt_toolbar_container" class="d-flex flex-stack flex-wrap m-5">
        <div class="page-title d-flex  flex-row align-items-start ">
            <!--begin::Title-->
           

             <!--begin::Title-->
                    <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">{{ ucfirst($candidate->first_name) }} {{ ucfirst($candidate->last_name) }}</h1>
                            <span class="h-20px border-gray-300 border-start mx-3 my-1"></span>
                        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 p-1 mx-0">
                                        <!--begin::Item-->
                                        <li class="breadcrumb-item text-muted">
                                            <a href="{{ route('position') }}" class="text-muted text-hover-primary">Interview</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                        </li>
                                        <li class="breadcrumb-item text-muted"><a href="{{ route('candidate',encryptId($candidate->position->id)) }}" class="text-muted text-hover-primary">Candidates</a></li>
                                         <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                        </li>
                                        <li class="breadcrumb-item text-dark">Details</li>
                                        <!--end::Item-->
                        </ul>                 
                  

                    <!--end::Title-->

            <!--end::Title-->
        </div>
    </div>
            
            @include('employer::candidate.pageheader')

            <div class="row " style="padding-left: 0.7rem">

                <div class="col-xl-3 card card-xl-stretch">
                    <!--begin::List Widget 3-->
                    <div class="">
                        <!--begin::Header-->
                        <div class="card-header ">
                            <h3 class="card-title fw-bolder text-dark">Menu</h3>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body px-0">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary " data-kt-menu="true">


                                <!--begin::Menu item-->
                                <div class="menu-item ">
                                    <a href="/employer/candidate/detail/{{$encrypt_cid}}" class="menu-link py-3 active emp_position_menulink" data-status="all">
                                        <span class="menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 0 24 24" width="16px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                                    </span>
                                    <span class="menu-title">Videos</span>
                                </a>
                            </div>
                            <!--end::Menu item-->


                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="/employer/candidate/commentsactivity/{{$encrypt_cid}}" class="menu-link py-3 emp_position_menulink" data-status="5">
                                    <span class="menu-icon">
                                       <i class="bi bi-chat-left-dots-fill"></i> 
                                    </span>
                                    <span class="menu-title">Comments & Activity</span>

                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->                        
                    </div>
                    <!--end::Body-->
                </div>
                <!--end:List Widget 3-->
            </div>

            <div class="col-xl-9">
            @if($question_attempt->count()>0)
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
                            <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-danger">Notice</h4>
                        <span>Video Recordings will automatically erase after <span class="fw-bolder">{{$candidate->employer->package->retain_video_prd}}</span> days of being submitted. Download your recordings to always have them on hand or upgrade your package to maintain videos longer.</span>
                    </div>
                </div>

                    <!--begin::Row-->
                    <div class="card " style="border-radius:0;">
                        <div class="card-header">
                            <h3 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                            </svg><span class="px-2">Videos</span></h3>
                            <div class="card-toolbar">
                                @if($candidate->status=='3')
                                        <div class="text-hover-primary justify-content-end px-5">
                                            <!-- <a href="/employer/logout" class="btn btn-light btn-active-light-primary">Sign Out</a> -->
                                            <a  href="javascript:void(0);" data-url="/employer/candidate/downloadzip/cid/{{ encryptId($candidate->id) }}" class="downloadzip btn btn-light btn-active-light-primary"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path></svg> Download All Recordings</a>
                                        </div>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="separator mt-10"></div> -->
                        
                        
                    </div>
                    <div style="height:400px;overflow-x:hidden;overflow-y:scroll;border-radius:0;" class="card">
                        @foreach($questions as $key => $question)
                            @if($question['attempt_exist']=='1')
                                <div class="card card-flush" style="border-radius:0;">
                                    <!-- <div class="card-header">
                                        <h3 class="card-title ">Question {{$key+1}}:</h3>
                                    
                                        <div class="card-toolbar">
                                            <h6 class="pt-2">Answer {{ $loop->index + 1 }}</h6>
                                            @if($question['attempt_exist']) 
                                                @if(file_exists(public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).$question['employer_id'].'/'.$question['record_file']))
                                                    <div class="text-hover-primary justify-content-end px-3">
                                                        <a class="text-muted text-hover-primary" href='/employer/candidate/download/qid/{{ $question["id"]}}/cid/{{ $candidate->id }}/qindex/{{$key+1}}'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path></svg></a>
                                                    </div>
                                                @endif
                                            @endif

                                            @if($question['attempt_exist']) 
                                                @if(file_exists(public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).$question['employer_id'].'/'.$question['record_file']))
                                                    <div class="text-hover-primary justify-content-end">
                                                        <a class="text-muted text-hover-primary open_cmtmdl" data-cmtqstn="Question:{{$key+1}}" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-left-dots-fill kt-nav__link-icon pt-1" viewBox="0 0 16 16">
                                                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        
                                    </div> -->
                                    <div class="tab-content py-10">
                                            <!--begin:Tab pane-->
                                            <div class="tab-pane active w-lg-1050px" id="kt_app_header_menu_pages_pages" role="tabpanel">
                                                <!--begin:Row-->
                                                <div class="row">
                                                    <!--begin:Col-->
                                                    <div class="col-lg-8 px-8">
                                                        <!--begin:Row-->
                                                        <div class="row mb-5">
                                                            <!--begin:Col-->
                                                            <div class="col-lg-6 mb-6 mb-lg-0">
                                                                <!--begin:Menu section-->
                                                                <!-- <div class="mb-6">
                                                                    
                                                                </div> -->
                                                                <!--end:Menu section-->
                                                                <!--begin:Menu section-->
                                                                <div class="mb-6">
                                                                    <!--begin:Menu heading-->
                                                                    <h4 class="fs-6 fs-lg-4 fw-bold mb-3 ms-4">Question {{$key+1}}: {{$question['question']}}</h4>
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
                                                        <div class="row px-5">
                                                            <div class="rounded border p-3">
                                                                <div class="tab-content" style="height:150px;overflow:auto;">
                                                                    <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                                                                        <div class="timeline" id="commentlist{{$key+1}}">
                                                                            @if($question['question_comments']->count()>0)
                                                                                @foreach($question['question_comments'] as $commentkey => $candidatecomments)
                                                                                <div class="timeline-item">
                                                                                    <div class="timeline-line w-40px"></div>
                                                                                    <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                                                        <div class="symbol-label bg-light">
                                                                                            @if($candidatecomments->system_msg !='')
                                                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                                                                                            <span class="svg-icon svg-icon-2 svg-icon-gray-500">
                                                                                                <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"></path></svg>
                                                                                            </span>
                                                                                            <!--end::Svg Icon-->
                                                                                            @elseif($candidatecomments->comments !='')
                                                                                            <span class="">
                                                                                                <i class="text-primary fw-bolder">{{nameFirstLetter($candidatecomments->employer->first_name)}}{{nameFirstLetter($candidatecomments->employer->last_name)}}</i>
                                                                                            </span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                   
                                                                                    <div class="timeline-content mb-3">
                                                                                        <div class="pe-3">
                                                                                            <div class="fs-5 fw-bold mb-2 color-D6E fw-bolder">
                                                                                            @if($candidatecomments->system_msg !='')
                                                                                                System Message 
                                                                                            @elseif($candidatecomments->comments !='')
                                                                                                Comment
                                                                                            @endif                                                            
                                                                                            <span class="text-muted   me-1 fs-7">{{converdate($candidatecomments->created_at)}}</span></div>
                                                                                            <div class="overflow-auto pb-5">
                                                                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                                                                    <div class="text-muted me-2 fs-7 color-D6E">
                                                                                                    @if($candidatecomments->system_msg !='')
                                                                                                    {{$candidatecomments->system_msg}}
                                                                                                    @elseif($candidatecomments->comments !='')
                                                                                                        {{nameFirstLetter($candidatecomments->employer->first_name)}}{{nameFirstLetter($candidatecomments->employer->last_name)}} added a comment:<span class="text-muted   me-1 fs-7"> {{$candidatecomments->comments}}</span>
                                                                                                    @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <form id="idealcommentform{{$key+1}}" class="idealcommentform">
                                                                        <input type="hidden" id="question_id{{$key+1}}" name="question_id" value="{{$question['id']}}">
                                                                        <input type="hidden" id="employer_id{{$key+1}}" name="employer_id" value="{{$question['employer_id']}}">
                                                                        <input type="hidden" id="candidate_id{{$key+1}}" name="candidate_id" value="{{$candidate->id}}">
                                                                        <div class="row pb-4">
                                                                            <div class="col-9">
                                                                                <textarea style="resize:none;" class="form-control idealcomments" rows="1" name="idealcomments" id="idealcomments{{$key+1}}" placeholder="Type notes"></textarea>
                                                                            </div>
                                                                            <div class="col-2">
                                                                                <button type="button" class="btn btn btn-primary submitcomment" data-txtname="idealcomments{{$key+1}}" data-loopid="{{$key+1}}" data-formid="idealcommentform{{$key+1}}">Submit</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
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
                                                                @if($question['attempt_exist'] && $question['record_file'] != '')
                                                                    @if(file_exists(public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).$question['employer_id'].'/'.$question['record_file']))
                                                                        <!-- <div class="card overlay overflow-hidden "  >
                                                                            <div class="card-body p-0">
                                                                                <div class="overlay-wrapper">
                                                                                    <video src="{{asset(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')) .'/'.$question['employer_id'].'/'.$question['record_file'] }}"id="upload_videotag{{$key}}" data-finishedtime="{{$question['finished_time']}}" width="240" class="h-210px w-100 d-lg-block" preload="metadata"  style="float:right;">
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
                                                                        </div> -->

                                                                        <div class="card  overlay overlay-block" id="videocard{{$key}}" >
                                                                            <div class="card-body p-0">
                                                                                <div class="overlay-wrapper">
                                                                                    <video src="{{asset(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')) .'/'.$question['employer_id'].'/'.$question['record_file'] }}"id="upload_videotag{{$key}}" data-finishedtime="{{$question['finished_time']}}" width="240" class="h-210px w-100 d-lg-block rounded" preload="metadata"  >
                                                                                        Your browser does not support the video tag.
                                                                                    </video>
                                                                                </div>
                                                                                <div class="overlay-layer bg-dark bg-opacity-25 align-items-end justify-content-center">
                                                                                    <div class="d-flex flex-grow-1 flex-center  py-5">
                                                                                        
                                                                                        <div class=" mt-2  d-flex  flex-center video_player_box" style="background-color: rgba(74, 73, 72, 0.9); border-radius: 0.4rem">
                                                                                            <button id="playpausebtn{{$key}}"  class="playpause_btn px-3" data-loopid="{{$key}}" style="width:10%"></button>
                                                                                            <span id="curtimetext{{$key}}" class="text-white fs-8 px-2">00:00</span> 
                                                                                            <input id="seekslider{{$key}}" class="seeksliderrange w-50" type="range" min="0" max="100" value="0" step="1" data-finishedtime="{{$question['finished_time']}}" >
                                                                                           </span> <span id="durtimetext{{$key}}" class="text-white fs-8" style="padding-left: 3px;">00:00</span>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        @if($question['attempt_exist']) 
                                                                            @if(file_exists(public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).$question['employer_id'].'/'.$question['record_file']))
                                                                                <div class="text-hover-primary text-end px-3 pt-1">
                                                                                    <a class="text-muted text-hover-primary" href='/employer/candidate/download/qid/{{ $question["id"]}}/cid/{{ $candidate->id }}/qindex/{{$key+1}}'><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"></path></svg></a>
                                                                                </div>
                                                                            @endif
                                                                        @endif
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
                                    <div class="separator mt-10"></div>
                                </div>
                            @endif
                        @endforeach
                        @if($candidate->status=='1'||$candidate->status=='2')
                            <div class="card mb-5 mb-xl-8 card-flush" style="border-radius:0;">
                                    
                                    <div class="card-body ">
                                    <div class="d-flex flex-column flex-root text-center">
                                    <!--begin::Authentication - 404 Page-->
                                    <div class="d-flex flex-column flex-center flex-column-fluid p-10">
                                        <!--begin::Illustration-->
                                        <h1 class="mw-100  fs-5 color-D6E mb-3" >Interview Not Completed</h1>
                                        <!--end::Illustration-->
                                        <!--begin::Message-->
                                        <div class="fw-bold fs-7 text-muted mb-6 ">Your candidate has not yet completed this section.  
                                                <br>Use the button below to resend your interview invite.</div>
                                                <a href="javascript:void(0);" class="btn btn-light btn-active-light-primary px-6 align-self-center text-nowrap sendinvite" data-candidateid="{{$encrypt_cid}}" >Resend Invite</a>
                                        <!--end::Message-->
                                        <!--begin::Link-->
                                        <!-- <a href="../../demo1/dist/index.html" class="btn btn-primary">Return Home</a> -->
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Authentication - 404 Page-->
                                </div>
                                            </div>
                                            
                            </div>
                        @endif
                    </div>
            @elseif($candidate->status==3)
            <div class="card mb-5 mb-xl-8 card-flush" style="border-radius:0;">
                <div class="card-body ">
                    <div class="d-flex flex-column flex-root text-center">
                        <!--begin::Authentication - 404 Page-->
                        <div class="d-flex flex-column flex-center flex-column-fluid p-10">
                            <!--begin::Illustration-->
                            <h1 class="mw-100  fs-5 color-D6E mb-3" >Interview Completed</h1>
                            <!--end::Illustration-->
                            <!--begin::Message-->
                            <div class="fw-bold fs-7 text-muted mb-6 ">Your candidate has directly completed this section from admin. So the video is not present
                                    <!-- <br>Use the button below to resend your interview invite. -->
                            </div>
                                    <!-- <a href="javascript:void(0);" class="btn btn-light btn-active-light-primary px-6 align-self-center text-nowrap sendinvite" data-candidateid="{{$encrypt_cid}}" >Resend Invite</a> -->
                            <!--end::Message-->
                            <!--begin::Link-->
                            <!-- <a href="../../demo1/dist/index.html" class="btn btn-primary">Return Home</a> -->
                            <!--end::Link-->
                        </div>
                        <!--end::Authentication - 404 Page-->
                    </div>
                </div>
            </div>
                @if($candidate->status=='1'||$candidate->status=='2')
                    <div class="card mb-5 mb-xl-8 card-flush" style="border-radius:0;">
                            
                            <div class="card-body ">
                            <div class="d-flex flex-column flex-root text-center">
                            <!--begin::Authentication - 404 Page-->
                            <div class="d-flex flex-column flex-center flex-column-fluid p-10">
                                <!--begin::Illustration-->
                                <h1 class="mw-100  fs-5 color-D6E mb-3" >Interview Not Completed</h1>
                                <!--end::Illustration-->
                                <!--begin::Message-->
                                <div class="fw-bold fs-7 text-muted mb-6 ">Your candidate has not yet completed this section.  
                                        <br>Use the button below to resend your interview invite.</div>
                                        <a href="javascript:void(0);" class="btn btn-light btn-active-light-primary px-6 align-self-center text-nowrap sendinvite" data-candidateid="{{$encrypt_cid}}" >Resend Invite</a>
                                <!--end::Message-->
                                <!--begin::Link-->
                                <!-- <a href="../../demo1/dist/index.html" class="btn btn-primary">Return Home</a> -->
                                <!--end::Link-->
                            </div>
                            <!--end::Authentication - 404 Page-->
                        </div>
                                    </div>
                                    
                    </div>
                @endif
            @endif

           
<!--begin::Modal - Hire-->
<div class="modal fade" id="mdl_hire" tabindex="-1" aria-hidden="true" >
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder color-D6E">Congratulations on the hiring of your new employee</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_candidates_export_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_candidates_export_form" class="form" action="#">

                    <!--begin::Input group-->
                    <div class="fv-row mb-5">
                        <!--begin::Label-->
                        <label class="fs-5 fw-bold form-label  required  mb-5 color-D6E">Hired Date</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input class="form-control form-control-solid required" placeholder="Hire Date" id="hire_date"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->


                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
            <div class="modal-footer">
             <button type="button" class="btn btn-light btn-active-light-primary" data-bs-dismiss="modal">Close</button>
             <button type="button" class="btn btn-primary" id='save_hire'>Save changes</button>
         </div>
     </div>
     <!--end::Modal content-->
 </div>
 <!--end::Modal dialog-->
</div>
<!--end::Modal - New Card-->


<div class="modal fade custom-bottom" id="comment_modal" tabindex="-1"  role="dialog" data-backdrop="false" aria-hidden="true" >
    <!--begin::Modal dialog-->
    <div class="modal-dialog ">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder color-D6E">{{ucfirst(Auth::user()->first_name)}} {{ucfirst(Auth::user()->last_name)}}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_candidates_comment_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Form-->
            <form id="kt_candidates_comment_form" method="post" class="form" action="/candidate/questioncomment">
                <!--begin::Modal body-->
                <div class="modal-body scroll-y ">
                        @csrf
                        <!--begin::Input group-->
                        <div class="fv-row mb-5">
                        <input type="hidden" name="candidate_id" id="candidate_id" value="{{$encrypt_cid}}">
                        <input type="hidden" name="cmnt_question_no" id= "cmnt_question_no" value="">

                            <!--begin::Input-->
                            <textarea class="form-control" name="comment" id="comment" rows="9" placeholder="Type Comments" style="resize:none;" spellcheck="false"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="add_cmnt">Submit</button>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

</div>

</div>
</div></div>

@endsection

@section('scripts')
<script src="{{asset('js/employer/candidate/candidateview.js')}}?version={{rand()}}"></script>
<script src="{{asset('js/jquery.raty.js')}}?version={{rand()}}"></script>
@endsection