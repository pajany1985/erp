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

                <div class="col-xl-3 card card-xl-stretch mb-3">
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
                                    <a href="/employer/candidate/detail/{{$encrypt_cid}}" class="menu-link py-3  emp_position_menulink" data-status="all">
                                        <span class="menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 0 24 24" width="16px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                                    </span>
                                    <span class="menu-title">Videos</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->





                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="/employer/candidate/commentsactivity/{{$encrypt_cid}}" class="menu-link py-3 active emp_position_menulink" data-status="5">
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

           

                    <!--begin::Timeline-->
                    <div class="card">
                        <!--begin::Card head-->
                        <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                <span class="svg-icon svg-icon-1 svg-icon-primary me-3 lh-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0086FF" class="bi bi-chat-left-dots-fill kt-nav__link-icon pt-1" viewBox="0 0 16 16">
                                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <h3 class="fw-bolder m-0 text-gray-800">Comments & Activity</h3>
                            </div>
                            <!--end::Title-->
                            
                        </div>
                        <!--end::Card head-->
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Tab Content-->
                            <form id="frmcomment" method="post" action="/employer/candidate/createactivity">
                                @csrf
                                <input type="hidden" name="candidate_id" id="candidate_id" value="{{$encrypt_cid}}">
                                <div class="d-flex flex-column mb-8">
                                    <textarea class="form-control " rows="3" name="cmnt_area" id="cmnt_area" placeholder="Type notes"></textarea>
                                </div>
                                
                                <div class="row mb-5 pb-4">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn btn-primary">Submit</button>
                                    </div>
                                    <div class="col-6">
                                            <select class="form-select kt-selectpicker" id="activity" name="activity" data-control="select2"  data-hide-search="true">
                                                <option value="">All Activity</option>
                                                <option value="comment">Comment Activity</option>
                                                <option value="system">System Activity</option>
                                            </select>
                                    </div>
                                </div>
                            </form>
                            <div class="separator mb-5"></div>
                            <div class="tab-content" style="height:700px;overflow:auto;">
                                <!--begin::Tab panel-->
                                <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                                    <!--begin::Timeline-->
                                    <div class="timeline" id="commentlist">
                                        @if($candidatecomment->count()>0)
                                            @foreach($candidatecomment as $candidatecomments)
                                                <!--begin::Timeline item-->
                                                <div class="timeline-item">
                                                    <!--begin::Timeline line-->
                                                    <div class="timeline-line w-40px"></div>
                                                    <!--end::Timeline line-->
                                                    <!--begin::Timeline icon-->
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
                                                    <!--end::Timeline icon-->
                                                    <!--begin::Timeline content-->
                                                    <div class="timeline-content mb-10 mt-n1">
                                                        <!--begin::Timeline heading-->
                                                        <div class="pe-3 mb-5">
                                                            <!--begin::Title-->
                                                            <div class="fs-5 fw-bold mb-2 color-D6E fw-bolder">
                                                            @if($candidatecomments->system_msg !='')
                                                                System Message 
                                                            @elseif($candidatecomments->comments !='')
                                                                Comment
                                                            @endif                                                            
                                                            <span class="text-muted   me-1 fs-7">{{converdate($candidatecomments->created_at)}}</span></div>
                                                            <!--end::Title-->
                                                            <!--begin::Description-->
                                                            <div class="overflow-auto pb-5">
                                                                <!--begin::Wrapper-->
                                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                                    <!--begin::Info-->
                                                                    <div class="text-muted me-2 fs-7 color-D6E">
                                                                    @if($candidatecomments->system_msg !='')
                                                                    {{$candidatecomments->system_msg}}
                                                                    @elseif($candidatecomments->comments !='')
                                                                        {{nameFirstLetter($candidatecomments->employer->first_name)}}{{nameFirstLetter($candidatecomments->employer->last_name)}} added a comment:<span class="text-muted   me-1 fs-7"> {{$candidatecomments->comments}}</span>
                                                                    @endif
                                                                    </div>
                                                                    <!--end::Info-->
                                                                    <!--begin::User-->
                                                                    <!--end::User-->
                                                                </div>
                                                                <!--end::Wrapper-->
                                                            </div>
                                                            <!--end::Description-->
                                                        </div>
                                                        <!--end::Timeline heading-->
                                                    </div>
                                                    <!--end::Timeline content-->
                                                </div>
                                                <!--end::Timeline item-->
                                            @endforeach
                                        @endif
                                    </div>
                                    <!--end::Timeline-->
                                </div>
                                <!--end::Tab panel-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Timeline-->


            
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
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id='save_hire'>Save changes</button>
                            </div>
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - New Card-->
            </div>

</div>
</div>
</div>

@endsection

@section('scripts')
<script src="{{asset('js/employer/candidate/candidateview.js')}}"></script>
<script src="{{asset('js/jquery.raty.js')}}?version={{rand()}}"></script>
@endsection