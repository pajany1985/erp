@extends('admin::layouts.master')
@section('pagetitle','Edit CMS Page')

@section('content')

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
      
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title fs-3 fw-bolder">{{$cmspage->page_title}}</div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Form-->
            <form id="kt_editcmspage_form"  method="post" class="form" action="{{route('cmspage.update',$encryptId)}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" @if (@isset ($cmspage->status) && $cmspage->status == "0") value="0" @else value="1" @endif />
                <!--begin::Card body-->
                <div class="card-body p-9">
            
                    <!--begin::Row-->
                    <div class="row mb-8">
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <div class="fs-6 fw-bold mt-2 mb-3 required">CMS Page</div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-xl-9 fv-row">
                            <textarea name="cmspage" id="cmspage" class="form-control form-control-solid h-100px">{{$cmspage->page_content}}</textarea>
                        </div>
                        <!--begin::Col-->
                    </div>
                    <!--end::Row-->
                   
                   
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-xl-3">
                            <div class="fs-6 fw-bold mt-2 mb-3">Status</div>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-xl-9">
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input check_status" type="checkbox" @if (@isset ($cmspage->status) && $cmspage->status == '0') value="0" @else checked="checked" value="1" @endif name="status_hidden" />
                                <label class="form-check-label fw-bold text-gray-400 ms-3" for="status"></label>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="/admin/cmspage" class="btn btn-light btn-active-light-primary me-2">Discard</a>
                    <button type="button" class="btn btn-primary" id="kt_editcmspage_submit">
                            <span class="indicator-label">Update Changes</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Card footer-->
            </form>
            <!--end:Form-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@endsection

@section('scripts')
<script src="{{asset('js/tinymce.bundle.js')}}"></script>
<script src="{{asset('js/admin/cmspage/editcmspage.js')}}"></script>
@endsection