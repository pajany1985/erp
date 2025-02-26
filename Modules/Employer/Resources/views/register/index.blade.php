@extends('employer::layouts.masternoauth')
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
    <div id="kt_content_container" class="container-xxl pt-10 pb-10">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_create_account_stepper">
            <!--begin::Aside-->
            <div class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px me-9">
                <div class="card-header border-0 pt-5">					
                    
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
                                <h3 class="stepper-title">Account Information</h3>
                                <div class="stepper-desc fw-bold">Setup Your Account Information</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Step 1-->
                        <!--begin::Step 2-->
                        <div class="stepper-item" data-kt-stepper-element="nav" data-kt-stepper-action="step">
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
                                <h3 class="stepper-title">Setup Location</h3>
                                <div class="stepper-desc fw-bold">Setup Your Location</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Step 2-->
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
                        @if($package_amount!='0')
                        <!--begin::Step 4-->
                        <div class="stepper-item" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                            <!--begin::Line-->
                            <div class="stepper-line w-40px"></div>
                            <!--end::Line-->
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">4</span>
                            </div>
                            <!--end::Icon-->
                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">Payments</h3>
                                <div class="stepper-desc fw-bold">Make the payment to get access</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Step 4-->
                        @endif

                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="card d-flex flex-row-fluid flex-center">
                
                <!--begin::Form-->
                <form class="card-body py-20 w-100 w-xl-700px px-9" method='post' novalidate="novalidate" id="kt_create_account_form" enctype="multipart/form-data"  action="{{ route('register.store') }}">
                    <!--begin::Step 1-->
                    <div class="current" data-kt-stepper-element="content">
                        @csrf
                        @if(isset($employer))
                            @method('PUT')
                            <input type="hidden" name="addoredit" id="addoredit" value="edit">
                        @else
                            <input type="hidden" name="addoredit" id="addoredit" value="add">
                        @endif
                        <input type="hidden" name="package_id" id="package_id" value="@if(isset($package_id)){{$package_id}}@endif">
                         <input type="hidden" name="amount" id="amount" value="{{ $package_amount }}">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-5 pb-lg-10">
                                <!--begin::Title-->
                                <h2 class="fw-bolder d-flex align-items-center text-dark">Account Information
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Account Information About Employer"></i></h2>
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

                                <!--begin::Row-->
                                <div class="row mb-7">
                                     <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="phone">Phone Number</label>
                                        
                                        <div class="input-group ">
                                            <span class="input-group-text">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                                    </svg>
                                                </span>
                                            </span>
                                            <input type="text" class="form-control" name="phone"  id="phone" placeholder="Phone Number" value="@isset($employer->phone_no){{$employer->phone_no}}@endisset" />
                                        </div>
                                    </div>

                                     <div class="col-lg-6">
                                        <!-- <label class=" @if(!isset($employer)) required @endif fs-5 fw-bold mb-2" for="password">Password @if(isset($employer))<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Please leave password empty retain old password"></i>@endif</label>
                                        <input type="password" class="form-control" name="password"  id="password"  @if(!isset($employer)) required="required" placeholder="Enter Password" @else placeholder="Please leave password empty retain old password" @endif /> -->

                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                                            <!--begin::Wrapper-->
                                            <div class="mb-1">
                                                <!--begin::Label-->
                                                <label class=" @if(!isset($employer)) required @endif fs-5 fw-bold mb-2" for="password">Password @if(isset($employer))<i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Please leave password empty retain old password"></i>@endif</label>
                                                <!--end::Label-->
                                                <!--begin::Input wrapper-->
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-lg bg-image-none" type="password" name="password" id="password" @if(!isset($employer)) required="required" placeholder="Enter Password" @else placeholder="Please leave password empty retain old password" @endif autocomplete="off" />
                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                        <i class="bi bi-eye-slash fs-2"></i>
                                                        <i class="bi bi-eye fs-2 d-none"></i>
                                                    </span>
                                                </div>
                                                <!--end::Input wrapper-->
                                                <!--begin::Meter-->
                                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                                </div>
                                                <!--end::Meter-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Hint-->
                                            <div class="text-muted fs-8">Use 8 or more characters with a mix of atleast 1 capital and small letters, numbers &amp; symbols.</div>
                                            <!--end::Hint-->
                                        </div>
                                        <!--end::Input group=-->

                                    </div>
                                </div>
                                <!--end::Row-->

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 1-->
                    <!--begin::Step 2-->
                    <div data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-5 pb-lg-10">
                                <!--begin::Title-->
                                <h2 class="fw-bolder text-dark">Setup Location</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
        
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-12">
                                        <label class="required fs-5 fw-bold mb-2" for="country">Country</label>
                                        <select name="country"  id="country" data-control="select2"  data-placeholder="Select a Country..." class="form-select" data-allow-clear="true">
                                            <option></option>
                                            @foreach($country as $cntry)
                                            <option value='{{ $cntry->country_id}}' @if(isset($employer)) @if ($cntry->country_id == $employer->country_id) selected @endif @elseif($cntry->country_id == '254') selected @endif >{{$cntry->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end::Row-->
                                 <!--begin::Row-->
                                 <div class="row mb-7">

                                    <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="address">Address</label>
                                        <div class="input-group ">
                                            <span class="input-group-text">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <input type="text" class="form-control" name="address"  id="address" placeholder="Address" value="@if(isset($employer->address)){{$employer->address}}@endif"  /> 
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="city">City</label>
                                        <div class="input-group ">
                                            <span class="input-group-text">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path d="M480 192H592C618.5 192 640 213.5 640 240V464C640 490.5 618.5 512 592 512H48C21.49 512 0 490.5 0 464V144C0 117.5 21.49 96 48 96H64V24C64 10.75 74.75 0 88 0C101.3 0 112 10.75 112 24V96H176V24C176 10.75 186.7 0 200 0C213.3 0 224 10.75 224 24V96H288V48C288 21.49 309.5 0 336 0H432C458.5 0 480 21.49 480 48V192zM576 368C576 359.2 568.8 352 560 352H528C519.2 352 512 359.2 512 368V400C512 408.8 519.2 416 528 416H560C568.8 416 576 408.8 576 400V368zM240 416C248.8 416 256 408.8 256 400V368C256 359.2 248.8 352 240 352H208C199.2 352 192 359.2 192 368V400C192 408.8 199.2 416 208 416H240zM128 368C128 359.2 120.8 352 112 352H80C71.16 352 64 359.2 64 368V400C64 408.8 71.16 416 80 416H112C120.8 416 128 408.8 128 400V368zM528 256C519.2 256 512 263.2 512 272V304C512 312.8 519.2 320 528 320H560C568.8 320 576 312.8 576 304V272C576 263.2 568.8 256 560 256H528zM256 176C256 167.2 248.8 160 240 160H208C199.2 160 192 167.2 192 176V208C192 216.8 199.2 224 208 224H240C248.8 224 256 216.8 256 208V176zM80 160C71.16 160 64 167.2 64 176V208C64 216.8 71.16 224 80 224H112C120.8 224 128 216.8 128 208V176C128 167.2 120.8 160 112 160H80zM256 272C256 263.2 248.8 256 240 256H208C199.2 256 192 263.2 192 272V304C192 312.8 199.2 320 208 320H240C248.8 320 256 312.8 256 304V272zM112 320C120.8 320 128 312.8 128 304V272C128 263.2 120.8 256 112 256H80C71.16 256 64 263.2 64 272V304C64 312.8 71.16 320 80 320H112zM416 272C416 263.2 408.8 256 400 256H368C359.2 256 352 263.2 352 272V304C352 312.8 359.2 320 368 320H400C408.8 320 416 312.8 416 304V272zM368 64C359.2 64 352 71.16 352 80V112C352 120.8 359.2 128 368 128H400C408.8 128 416 120.8 416 112V80C416 71.16 408.8 64 400 64H368zM416 176C416 167.2 408.8 160 400 160H368C359.2 160 352 167.2 352 176V208C352 216.8 359.2 224 368 224H400C408.8 224 416 216.8 416 208V176z"/>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <input type="text" class="form-control" name="city"  id="city" placeholder="City" value="@if(isset($employer->city)){{$employer->city}}@endif"  />
                                        </div>
                                    </div>

                                </div>
                                <!--end::Row-->

                                <div class="row mb-7">
                                    <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="state">State</label>
                                        <select name="state"  id="state"  data-control="select2"  data-placeholder="Select a State..." class="form-select" data-allow-clear="true">
                                            <option></option>
                                            @foreach($state as $statemst)
                                                <option value='{{ $statemst->state_id}}'>{{$statemst->state }} </option>
                                            @endforeach 
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="postcode">Postcode</label>
                                        <div class="input-group ">
                                            <span class="input-group-text">
                                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                <span class="svg-icon ">
                                                    <svg version="1.1" fill="currentColor"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                                        <g><path d="M534.3,840.2h37.2l0.3-0.6h-37.2L534.3,840.2z M430.3,840.2h37.2l0.3-0.6h-37.2L430.3,840.2z M640.4,840.2h37.2l0.3-0.6h-37.1L640.4,840.2z M572,555.9l417.9-320c0-70.9-66.7-76.1-66.7-76.1H79.7c-72.4,0-69.7,71.6-69.7,71.6l424.1,324.5C507.5,627.9,572,555.9,572,555.9z M308,375.9c-48.8,0-88.4-37.6-88.4-87.8c0-50.2,39.6-95.3,88.4-95.3c28.8,0,54.9,14.2,71.1,36.2l176.9-0.3c10.3,0,18.6,8.9,18.6,19.5c0,10.6-8.3,17.6-18.6,17.6l-161.4,0.3c1.2,6.1,1.8,16.8,1.8,21.9c0,4.6-0.3,8-1,12.4l122.9,0.3c9.7,0,17.5,10.7,17.5,20.6c0,10-7.9,16.5-17.5,16.5L380,337.4C364,360.5,346.5,375.9,308,375.9z M324.2,840.2h37.2l0.3-0.6h-37.2L324.2,840.2z M307.8,229.8c-28.7,0-52,23.9-52,53.4c0,29.5,23.3,53.4,52,53.4c28.7,0,52-23.9,52-53.4C359.7,253.8,336.5,229.8,307.8,229.8z M850.5,840.2h37.2l0.3-0.6h-37.2L850.5,840.2z M744.4,840.2h37.2l0.3-0.6h-37.2L744.4,840.2z M220.2,840.2h37.2l0.3-0.6h-37.2L220.2,840.2z M48.6,298.1l-1,0.2l33.1,26l0,0L48.6,298.1z M10.7,306.4l36.9-8l-36.9-29.1V306.4z M990,306.4v-31.5L606.6,573c-64.5,59.6-107.9,52.9-107.9,52.9c-49.2,0-105-55.1-105-55.1l-313-246.4l-70,16.9v73.1l70.1-38.2v38.2l-70.1,34.8v73.2l70.1-38.3v38.3l-70.1,34.9v73.1l70.1-38.3v38.3l-70.1,34.8v67.5l70.1-38.2v38.2l-70.1,34.9v1.1c0,19.1,4.9,33.1,12.1,43.3l23.4-43.8h33.9l-28,66c14.1,5.4,26.3,5.4,26.3,5.4h35.9l36.9-71.4h33.9l-33.6,71.4h68.9l36.9-71.4h33.9l-33.6,71.4h66.8l36.9-71.4h33.9l-33.6,71.4h69l36.9-71.4h33.9l-33.6,71.4h66.8l36.9-71.4h33.9l-33.6,71.4h69l36.9-71.4h33.9l-33.6,71.4h66.8l36.9-71.4h33.9l-33.6,71.4h68.9l36.9-71.4h33.9L888,839.6h35.3c65.6,0,66.7-66.4,66.7-66.4l-70-34.9v-38.2l70,38.2v-73.1l-70-34.8v-38.3l70,38.3v-73.1l-70-34.9v-38.3l70,38.3v-73.2l-70-34.8v-38.2l70,38.2v-73.1l-52.5-23.6l20.8-18L990,306.4z M114.1,840.2h37.2l0.3-0.6h-37.2L114.1,840.2z M37.2,826.2l-9.6-8.4C30.6,821.1,33.8,823.9,37.2,826.2z M50.6,837.9l1.6-3.8c-4.9-1.9-10.1-4.5-15-7.9L50.6,837.9z M22.2,813.2l5.4,4.7c-1.7-1.8-3.3-3.8-4.8-5.9L22.2,813.2z"/></g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <input type="text" class="form-control" name="postcode"  id="postcode" placeholder="Postcode" value="" />
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->

                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 2-->
                    <!--begin::Step 3-->
                    <div data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-5 pb-lg-10">
                                <!--begin::Title-->
                                <h2 class="fw-bolder text-dark">Business Details</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="form-label required">Company Name</label>
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
                                    <input type="text" name="company_name" id="company_name" class="form-control form-control-lg " placeholder="Company Name" required value="@if(isset($employer->company_name)){{$employer->company_name}}@endif" />
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label required">Company Website</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="input-group ">
                                    <span class="input-group-text">
                                        <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                        <span class="svg-icon ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16">
                                                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"/>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <input  type="text" name="company_website" id="company_website" class="form-control form-control-lg" placeholder="Eg: http://yoursite.domain" required  value="" />
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row ">
                                <!--begin::Label-->
                                <label class="d-block fw-bold fs-6 mb-5">Company Logo</label>
                                <!--end::Label-->
                                <!--begin::Image input-->
                               
                                <div class="image-input image-input-outline image-input-empty" id="kt_image_input_control" data-kt-image-input="true" style="background-image: url({{asset('media/svg/avatars/blank.svg')}})">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px"></div>
                         
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-dismiss="click" data-bs-toggle="tooltip" title="Change Logo">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="company_logo" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="company_logo_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel"  data-bs-dismiss="click" data-bs-toggle="tooltip" title="Cancel Logo">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-dismiss="click" data-bs-toggle="tooltip" title="Remove Logo">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                            </div>
                            <!--end::Input group-->

                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 3-->
                    @if($package_amount!='0')
                    <!--begin::Step 4-->
                    <div data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-10 pb-lg-15">
                                <!--begin::Title-->
                                <h2 class="fw-bolder text-dark">Billing Information</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                     <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="billing_address">Address</label>
                                        <input type="text"  id="billing_address" class="form-control" name="billing_address" placeholder="Address" value="">
                                    </div>

                                     <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="billing_state">State
                                           </label>
                                            <select name="billing_state"  id="billing_state"  data-control="select2"  data-placeholder="Select a State..." class="form-select" data-allow-clear="true">
                                            <option></option>
                                            @foreach($state as $statemst)
                                                <option value='{{ $statemst->code}}'>{{$statemst->state }} </option>
                                            @endforeach 
                                        </select>
                                        
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                     <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="address">City</label>
                                        <input type="text"  id="billing_city" class="form-control" name="billing_city" placeholder="City" value="">
                                    </div>

                                     <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="billing_zip">Zip
                                           </label>
                                            <input type="text"  id="billing_zip" class="form-control" name="billing_zip" placeholder="Zip Code" value="">
                                        
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                     <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="cc_number">Card Number</label>
                                     <!--    <input type="text"  id="cc_number" class="form-control" name="cc_number" placeholder="Credit Card Number" value=""> -->
                                        <div class="position-relative">
                                    <!--begin::Input-->
                                    <input type="text" class="form-control" placeholder="Credit Card Number" name="card_number" value="">
                                    <!--end::Input-->
                                </div>
                                    </div>

                                     <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="exp_date">Expiration Date
                                           </label>
                                          <div class="row fv-row">
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <select name="card_exp_month" class="form-select" data-control="select2" data-hide-search="true" data-placeholder="Month">
                                                                        <option></option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                </div>
                                                                <!--end::Col-->
                                                                <!--begin::Col-->
                                                                <div class="col-6">
                                                                    <select name="card_exp_year" class="form-select" data-control="select2" data-hide-search="true" data-placeholder="Year">
                                                                        <option></option>
                                                                        @for($i=\Carbon\Carbon::now()->format('Y');$i< (\Carbon\Carbon::now()->format('Y') + 20); $i++)
                                                                        <option value="{{$i}}">{{ $i }}</option>
                                                                        @endfor
                                                                     

                                                                    </select>
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Row-->
                                        
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                     <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="cvv">Card Verification No</label>
                                       <!--  <input type="text"  id="cvv" class="form-control" name="cvv" placeholder="cvv" value=""> -->
                                       <div class="position-relative">
                                        <!--begin::Input-->
                                        <input type="text" class="form-control" minlength="3" maxlength="4" placeholder="CVV" name="cvv">
                                        <!--end::Input-->
                                        <!--begin::CVV icon-->
                                        <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                            <!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
                                            <span class="svg-icon svg-icon-2hx">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22 7H2V11H22V7Z" fill="currentColor"></path>
                                                    <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </div>
                                        <!--end::CVV icon-->
                                    </div>
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Input group-->
                           
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 4-->
                    @endif

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

@endsection

@section('scripts')
<script src="{{asset('js/employer/register/addedit.js')}}"></script>
@endsection