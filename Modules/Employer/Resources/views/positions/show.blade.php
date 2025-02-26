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
                            <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">@if(isset($position)){{$position->name}}@endif</h1>
                                    <span class="h-20px border-gray-300 border-start mx-3 my-1"></span>
                                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 p-1 mx-0">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('position') }}" class="text-muted text-hover-primary">Interview</a>
                                    </li>
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
                    
                
            <div class="col-xl-12 ">
                <!--begin::Row-->
                <!--begin::Card-->
                    <div class="card mb-5 mb-xxl-8">
                        <div class="card-body pt-9 pb-0">
                            <!--begin::Details-->
                            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                                
                                <!--begin::Wrapper-->
                                <div class="flex-grow-1">
                                    <!--begin::Head-->
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-column">
                                            <!--begin::Status-->
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="text-gray-800 text-hover-primary fs-2 fw-bolder me-3">@if(isset($position)){{$position->name}}@endif</span>
                                                @if(isset($position))
                                                    @if($position->trashed())
                                                    <span class="badge badge-light-danger me-auto">Archived</span>
                                                    @elseif($position->status == '1')
                                                    <span class="badge badge-light-success me-auto">Active</span>
                                                    @elseif($position->status == '0')
                                                    <span class="badge badge-light-warning me-auto">Draft</span>
                                                    @endif
                                                @endif
                                            </div>
                                            <!--end::Status-->
                                            <!--begin::Description-->
                                            <div class="d-flex flex-wrap fw-bold mb-4 fs-5 text-gray-400">@if(isset($position)){{$position->description}}@endif</div>
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Actions-->
                                        @if(isset($position))
                                            @if($position->status == '0' && !$position->trashed())
                                                <div class="d-flex mb-4">
                                                    <a href="{{ route('position.edit',encryptId($position->id)) }}" class="btn btn-sm btn-primary me-3 " >Edit Interview</a>
                                                </div>
                                            @endif
                                        @endif
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Head-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap justify-content-start">
                                        <!--begin::Stats-->
                                        <div class="d-flex flex-wrap">
                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bolder color-D6E">@if(isset($position)){{$position->created_at}}@endif</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-bold fs-6 text-gray-400">Created Date</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->
                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
                                                 
                                                    <!--end::Svg Icon-->
                                                    <a href="/employer/{{encryptId($position->id)}}/candidate" class="fs-4 fw-bolder text-primary" data-kt-countup="true" data-kt-countup-value="@if(isset($position)){{$position->candidates->count()}}@endif">0</a>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-bold fs-6  text-primary">All Candidates</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->
                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                   
                                                    <!--end::Svg Icon-->
                                                    <a  href="/employer/{{encryptId($position->id)}}/candidate?status=3" class="fs-4 fw-bolder text-success" data-kt-countup="true" data-kt-countup-value="@if(isset($position)){{$position->candidates_count}}@endif" >0</a>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-bold fs-6  text-success">Completed</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->
                                        </div>
                                        <!--end::Stats-->
                                        
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Details-->
                            <div class="separator"></div>
                            
                        </div>
                    </div>

                    <div class="card">
                        <!--begin::Card header-->
                        <div class=" pt-6">
                        </div>

                            <!--end::Card header-->
                            <!--begin::Card body-->
                            
                            <div class="card-body pt-3">
                                <!--begin::Section-->
                                <div class="mb-0">
                                    <!--begin::Title-->
                                    <h5 class="mb-4 color-D6E">Questions</h5>
                                    <!--end::Title-->
                                    <!--begin::Product table-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-4 mb-0">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="border-bottom border-gray-200 text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                    <th class="min-w-10px">S.No.</th>
                                                    <th class="min-w-300px">Question Title</th>
                                                    <th class="min-w-15px">Minimum Sec.</th>
                                                    <th class="min-w-15px">Maximum Min.</th>
                                                    <th class="text-center min-w-70px">No. Of Attempts</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-800">
                                            @if(isset($position->questions) && $position->questions->count()>0)
                                                @foreach($position->questions as $key => $question)
                                                    <tr>
                                                        <td>
                                                            <label class="w-10px">{{$key+1}}</label>
                                                        </td>
                                                        <td>
                                                            <label class="w-300px">{{$question->question}}</label>
                                                        </td>
                                                        <td>
                                                            <span >{{$question->minsec_enablebtn}} Sec</span>
                                                        </td>
                                                        <td>{{$question->allowed_ans_time}} Min</td>
                                                        <td class="text-center">{{$question->allowed_attempts}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                                
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Product table-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Card body-->
                    </div>
                <!--end::Card-->
                <!--end::Row-->
            </div>
        </div>
    </div>

    <!--end::Post-->
</div>

    <!--begin::Engage toolbar-->
    <div class="engage-toolbar d-flex position-fixed px-2 bg-body fw-bolder zindex-2 top-25 end-0 flex-column mt-20 ">
        @if(isset($position))
                @if($position->status == '1' && !$position->trashed())
                <!--begin::Menu item-->
                <a href="javascript:void(0);" data-href="{{ url('/pid/login') }}/{{ encryptId($position->id) }}" data-pid="{{$position->id}}"  class=" px-2 colorD6E-hover-primary @if(session('postPid')==$position->id)shareurl @endif  @if($storagedetails['allow_recording']=='0') storagefull @else modalshare @endif" title="Share Interview" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                    <div class="symbol symbol-30px  pt-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg>
                    </div>
                </a>
                @endif
                <!--end::Menu item-->
                @if($position->status == '0' && !$position->trashed())
                <!--begin::Menu item-->
                <a href="{{ route('position.edit',encryptId($position->id)) }}"  class="px-2 colorD6E-hover-primary" title="Edit Interview" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                    <div class="symbol symbol-30px  pt-2 mb-2">
                            <!-- <span class="svg-icon svg-icon-3 colorD6E-hover-primary"> -->
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                            <!-- </span> -->
                    </div>
                </a>
                @endif
                <!--end::Menu item-->
                <!--begin::Menu item-->
                @if($position->status == '1' || $position->trashed())
                <a href="/employer/{{encryptId($position->id)}}/candidate"  class="px-2 colorD6E-hover-primary" title="View Candidates " data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                    <div class="symbol symbol-30px  pt-2 mb-2">
                            <!-- <span class="svg-icon svg-icon-3 colorD6E-hover-primary"> -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                            <!-- </span> -->
                    </div>
                </a>
                @endif
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <!-- Duplicate Position -->
                <a href="javascript:void(0);" data-urldup="{{ route('duplicatep',encryptId($position->id)) }}" class="px-2 duplicate colorD6E-hover-primary" title="Duplicate Interview" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                    <div class="symbol symbol-30px  pt-2 mb-2">
                            <!-- <span class="svg-icon svg-icon-3 colorD6E-hover-primary"> -->
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 8h-2v3h-3v2h3v3h2v-3h3v-2h-3zM2 12c0-2.79 1.64-5.2 4.01-6.32V3.52C2.52 4.76 0 8.09 0 12s2.52 7.24 6.01 8.48v-2.16C3.64 17.2 2 14.79 2 12zm13-9c-4.96 0-9 4.04-9 9s4.04 9 9 9 9-4.04 9-9-4.04-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7z"/></svg>
                            <!-- </span> -->
                    </div>
                </a>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                @if(!$position->trashed())
                <!-- Archive Position -->
                <a href="javascript:void(0);" data-id='{{ encryptId($position->id) }}' class="px-2 cfrmarchive" title="Archive Interview" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                    <div class="symbol symbol-30px  pt-2 mb-2">
                            <!-- <span class="svg-icon svg-icon-3"> -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#BE0000" class="bi bi-trash-fill kt-nav__link-icon" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                </svg>
                            <!-- </span> -->
                    </div>
                </a>
                @endif
        @endif
    </div>
    <!--end::Engage toolbar-->

    @include('employer::positions.mdlshare')
@endsection

@section('scripts')

<!-- <script src="https://cdn.jsdelivr.net/gh/T-vK/DynamicQuillTools@master/DynamicQuillTools.js"></script> -->
<!-- <script src="{{asset('js/formrepeater.bundle.js')}}"></script> -->
<script src="{{asset('js/employer/positions/positionview.js')}}"></script>
<script src="{{asset('js/employer/positions/shareposition.js')}}"></script>
@endsection