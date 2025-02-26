@extends('admin::layouts.master')
@if(isset($employer))
    @section('pagetitle','Edit Employer')
    @section('pagedescription',$employer->first_name.' '.$employer->last_name)
@else
    @section('pagetitle','Add New Employer')
@endif
@section('content')
   
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_create_account_stepper">
            <!--begin::Aside-->
            <div class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px me-9">
                <div class="card-header border-0 pt-5">					
                    <div class="card-toolbar">
                        <a href="{{route('subemployers.index')}}" class="btn btn-sm btn-light btn-active-primary" >
                        <!-- svg-icon svg-icon-3 -->

                        <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr002.svg-->
                        <span class="svg-icon  svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9.60001 11H21C21.6 11 22 11.4 22 12C22 12.6 21.6 13 21 13H9.60001V11Z" fill="currentColor"/>
                                <path opacity="0.3" d="M9.6 20V4L2.3 11.3C1.9 11.7 1.9 12.3 2.3 12.7L9.6 20Z" fill="currentColor"/>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--end::Svg Icon-->Back to view list</a>
                    </div>
                </div>
                <!--begin::Wrapper-->
                <div class="card-body px-6 px-lg-10 px-xxl-15 py-15">
                    <!--begin::Nav-->
                    <div class="stepper-nav">
                        <!--begin::Step 1-->
                        <div class="stepper-item current" data-kt-stepper-element="nav" data-kt-stepper-action="step">
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
                                <h3 class="stepper-title">Subuser Information</h3>
                                <div class="stepper-desc fw-bold">Subuser Account Information</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Step 1-->

                        <!--begin::Step 3-->
                        <div class="stepper-item" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                            <!--begin::Line-->
                            <div class="stepper-line w-40px"></div>
                            <!--end::Line-->
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">3</span>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">Company Information</h3>
                                <div class="stepper-desc fw-bold">Your Business Related Info</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Step 3-->

                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="card d-flex flex-row-fluid flex-center">
                
                <!--begin::Form-->
                <form class="card-body py-20 w-100 w-xl-700px px-9" method='post' novalidate="novalidate" id="kt_create_account_form" enctype="multipart/form-data"  action="@if(isset($employer))/admin/subemployers/{{$employer_id}}@else{{ route('subemployers.store') }}@endif">
                    <!--begin::Step 1-->
                    <div class="current" data-kt-stepper-element="content">
                        @csrf
                        @if(isset($employer))
                            @method('PUT')
                            <input type="hidden" name="addoredit" id="addoredit" value="edit">
                        @else
                            <input type="hidden" name="addoredit" id="addoredit" value="add">
                        @endif
                        <input type="hidden" name="employer_id" id="employer_id" value="@if(isset($employer)){{$employer_id}}@endif">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-5 pb-lg-10">
                                <!--begin::Title-->
                                <h2 class="fw-bolder d-flex align-items-center text-dark">Subuser Information
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Information About Subuser"></i></h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="first_name">First Name</label>
                                        <div class="input-group ">
                                            <span class="input-group-text">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <input type="text" class="form-control" name="first_name"  id="first_name" placeholder="First Name" value="@isset($employer->first_name){{$employer->first_name}}@endisset" /> 
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="last_name">Last Name</label>
                                        <div class="input-group ">
                                            <span class="input-group-text">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <input type="text" class="form-control" name="last_name"  id="last_name" placeholder="Last Name" value="@isset($employer->last_name){{$employer->last_name}}@endisset" />
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->

                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-12">
                                        <label class="required fs-5 fw-bold mb-2" for="email">Email</label>
                                        <div class="input-group ">
                                            <span class="input-group-text">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <input type="text" class="form-control" name="email"  id="email" placeholder="Email" value="@isset($employer->email){{$employer->email}}@endisset" />
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->


                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 1-->

                    <!--begin::Step 3-->
                    <div data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-5 pb-lg-10">
                                <!--begin::Title-->
                                <h2 class="fw-bolder text-dark">Company Information</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="form-label required">Select Subuser Employer Account</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="input-group ">
                                    <span class="input-group-text">
                                        <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                        <span class="svg-icon ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                                <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <div class="overflow-hidden flex-grow-1">
                                        <select name="masteremp"  id="masteremp" data-control="select2"  data-placeholder="Select Employer..." class="form-select rounded-start-0" data-allow-clear="true">
                                            <option></option>
                                            @foreach($masteremployers as $masteremployer)
                                            <option value='{{ $masteremployer->id}}' @if(isset($employer)) @if ($masteremployer->id == $employer->master_empid) selected @endif @endif >{{ucfirst($masteremployer->first_name) }} {{ucfirst($masteremployer->last_name) }} - {{$masteremployer->id}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <div class="px-13 masteremp_details">
                            @if(isset($masteremp_details))
                                <div class="row">
                                        <div class="col-6 ">
                                            <div class="pb-3 fs-6">
                                                <div class="fw-bold mt-2">Employer ID</div>
                                                <div class="text-gray-600">#{{$masteremp_details->id}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="pb-3 fs-6">
                                                <div class="fw-bold mt-2">Company Name</div>
                                                <div class="text-gray-600">{{$masteremp_details->company_name}}</div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-6 ">
                                            <div class="pb-3 fs-6">
                                                <div class="fw-bold mt-2">Email</div>
                                                <div class="text-gray-600">{{$masteremp_details->email}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="pb-3 fs-6">
                                                <div class="fw-bold mt-2">Website</div>
                                                <div class="text-gray-600">{{$masteremp_details->website}}</div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-6 ">
                                            <div class="pb-3 fs-6">
                                                <div class="fw-bold mt-2">Phone Number</div>
                                                <div class="text-gray-600">{{$masteremp_details->phone_no}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="pb-3 fs-6">
                                                <div class="fw-bold mt-2">Address</div>
                                                <div class="text-gray-600">{{$masteremp_details->address}},{{$masteremp_details->city}},{{$masteremp_details->state->state}}, {{$masteremp_details->country->country}}, {{$masteremp_details->zip}}</div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-6 ">
                                            <div class="pb-3 fs-6">
                                                <div class="fw-bold mt-2">Current Pacakge</div>
                                                <div class="text-gray-600">{{$masteremp_details->package->name}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="pb-3 fs-6">
                                                <div class="fw-bold mt-2">Company Logo</div>
                                                <div class="text-gray-600">{!!getEmployerLogo($masteremp_details->id)!!}</div>
                                            </div>
                                        </div>
                                </div>
                            @endif
                            </div>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 3-->
                  
                    

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
                            <!--end::Svg Icon--></button>
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

@if(isset($employer))
<div class="modal fade" id="mdlcomments" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_comments_header">
            <h3 class="fw-bolder m-0 text-gray-800 ">
                <span class="svg-icon svg-icon-1 svg-icon-primary me-3 lh-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#0086FF" class="bi bi-chat-left-dots-fill kt-nav__link-icon pt-1" viewBox="0 0 16 16">
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
                    </svg>
                </span>
                Comments</h3>
            </div>
            <!--end::Modal header-->
            <!--begin::Form-->
            <form id="frmnotes" method="post" action="/admin/employer/empnotes">
                @csrf
                <input type="hidden" name="employer_id" id="cmtemployer_id" value="@if(isset($employer)){{$employer_id}}@endif">
                <input type="hidden" name="admin_id" id="admin_id" value="{{auth()->user()->id}}">
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5  my-7">

                        <div class="d-flex flex-column mb-8">
                            <textarea class="form-control " maxlength="300" rows="3" name="cmnt_area" id="cmnt_area" placeholder="Type notes" data-kt-autosize="true"></textarea>
                            <div class="form-text">Maximum 300 characters allowed.</div>
                        </div>
                        
                        <div class="row mb-5 pb-4">
                            <div class="col-6">
                                <button type="submit" id="cmnt_submit" class="btn btn btn-primary">Submit</button>
                            </div>
                        </div>
                </div>
                <!--end::Modal body-->
            </form>
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endif

@endsection

@section('scripts')
<script src="{{asset('js/admin/subemployers/addedit.js')}}"></script>
@endsection