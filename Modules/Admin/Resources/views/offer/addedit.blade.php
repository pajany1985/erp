@extends('admin::layouts.master')
@section('pagetitle','Add/Edit Offer')

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_create_account_stepper">
            <!--begin::Aside-->
            <div class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px me-9">
                <!--begin::Wrapper-->
                <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
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
                                <h3 class="stepper-title">Basic Offer Details</h3>
                                <div class="stepper-desc fw-bold">Setup Your Basic Offer Information</div>
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
                                <h3 class="stepper-title">Credit & Expiry Settings</h3>
                                <div class="stepper-desc fw-bold">Setup Your Offer Credits & Expiry</div>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Step 2-->
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="card d-flex flex-row-fluid flex-center">
                <!--begin::Form-->
                <form class="card-body py-20 w-100 w-xl-700px px-9"  id="kt_create_offer_form" method="post" enctype="multipart/form-data"  action="@if(isset($offer))/admin/offers/{{$offer->id}}@else{{ route('offers.store') }}@endif">
                    <!--begin::Step 1-->

                    <div class="current" data-kt-stepper-element="content">
                           @csrf
                            @if(isset($offer))
                                 @method('PUT')
                                <input type="hidden" name="addoredit" id="addoredit" value="edit">
                                <input type="hidden" name="hidden_fromdate" id="hidden_fromdate" value="{{$offer->from_date}}">
                                <input type="hidden" name="hidden_todate" id="hidden_todate" value="{{$offer->to_date}}">

                            @else
                                <input type="hidden" name="addoredit" id="addoredit" value="add">
                            @endif
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-5 pb-lg-10">
                                <!--begin::Title-->
                                <h2 class="fw-bolder d-flex align-items-center text-dark">Enter Your Basic Offer Details</h2>
                                    <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-12">
                                        <label class="required fs-5 fw-bold mb-2" for="package">Package Name</label>
                                        <input type="hidden" name="existing_packageid" id="existing_packageid" value="@if(isset($offer)){{$offer->package_id}}@endif">
                                        <select name="package" id="package" data-control="select2"  data-placeholder="Select a Package..." class="form-select" data-allow-clear="true">
                                            <option></option>
                                            @foreach ($packages as $key=>$package)
                                                <option value="{{$package->id}}" @if(isset($offer)) @if ($package->id == $offer->package_id) selected @endif @endif>{{ucfirst($package->name)}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                </div>
                                <!--end::Row-->

                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-12">
                                        <label class="required fs-5 fw-bold mb-2" for="offername">Offer Name</label>
                                        <input type="text" class="form-control" name="offername"  id="offername" placeholder="Offer Name" value="@isset($offer->offername){{$offer->offername}}@endisset" required /> 
                                    </div>
                                </div>
                                <!--end::Row-->

                                <div class="row mb-7">
                                    <div class="col-lg-12">
                                        <!--end::Label-->
                                        <label class="fs-5 fw-bold mb-2">Offer Description</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea name="offer_description" id="offer_description" class="form-control">@isset($offer->description){{$offer->description}}@endisset</textarea>
                                        <!--end::Input-->
                                    </div>
                                </div>

        
                                <!--end::Row-->

                                <!--begin::Row-->
                                <div class="row mb-7 align-items-center">
                                    <div class="col-lg-4 ">
                                        <div class="d-flex flex-stack">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <label class="fs-6 fw-bold form-label">Status</label>
                                                <!-- <div class="fs-7 fw-bold text-muted">If you need more info, please check budget planning</div> -->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            
                                             <input type="hidden" name="status" @if (@isset ($offer->status) && $offer->status == "0") value="0" @else value="1" @endif />
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input check_status"  type="checkbox" @if (@isset ($offer->status) && $offer->status == '0') value="0" @else checked="checked" value="1" @endif name="status_hidden" />
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 1-->
    
                     <!--begin::Step 4-->
                     <div data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->
                            <div class="pb-10 pb-lg-15">
                                <!--begin::Title-->
                                <h2 class="fw-bolder text-dark">Offer Credit & Expiry Settings</h2>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row mb-7">
                                    <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" id="offer_amountlabel" for="offer_amount">Offer Amount</label>
                                        <input type="hidden" name="offercost" id="offercost" value="@isset($offer->price){{$offer->price}}@endisset" />
                                        <input type="text" class="form-control " name="offer_amount"  id="offer_amount" placeholder="Offer Amount" value="@isset($offer->price){{$offer->price}}@endisset"  required  />
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="required fs-5 fw-bold mb-2" for="expiryindays">Expire in days</label>
                                        <input type="text" class="form-control" name="expiryindays"  id="expiryindays" placeholder="Enter Expire in days" value="@isset($offer->extent_expiry_days){{$offer->extent_expiry_days}}@endisset" required />
                                    </div>
                                </div>
                                <!--end::Row-->

                                 <!--begin::Row-->
                                 <div class="row mb-7">
                                    <div class="col-lg-6">
                                        <label class=" fs-5 fw-bold mb-2 required" for="package">Offer Active Period(From - To)</label>
                                        <div class="mb-10">
                                            <!--begin::Input group-->
                                            <div class="input-group mb-5">
                                            <input class="form-control" autocomplete="off" readonly placeholder="Pick a date" id="activefrom_date" name="activefrom_date" value="@if(isset($offer)){{$offer->from_date}} to {{$offer->to_date}}@endif"/>
                                                <span class="input-group-text datebtn-clear">
                                                    <!-- <i class="fas fa-envelope-open-text fs-4"></i> -->
                                                    <i class="bi bi-x-lg"></i>
                                                </span>
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-6">
                                        <label class=" fs-5 fw-bold mb-2 required" for="package">Offer Active To</label>
                                        <div class="mb-10">
                                            <div class="input-group mb-5">
                                            <input class="form-control" disabled placeholder="Pick a date" id="activeto_date" name="activeto_date" value="@if(isset($offer)){{$offer->to_date}}@endif"/>
                                                <span class="input-group-text datebtn-clear">
                                                    <i class="bi bi-x-lg"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Input group-->
                           
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 4-->

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
                                    <!--end::Svg Icon-->
                            </button>
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
<script src="{{asset('js/admin/offers/addedit.js')}}"></script>
@endsection