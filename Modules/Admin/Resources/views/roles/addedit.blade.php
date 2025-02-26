@extends('admin::layouts.master')
@section('pagetitle','Add/Edit Roles')

@section('content')
@if (session('success'))
<!--begin::Alert-->
<div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row px-3 py-1 mb-10">
    <!--begin::Wrapper-->
    <div class="d-flex flex-column text-light pe-0 pe-sm-10 py-4">

        <!--begin::Content-->
        <span>{{ session('success') }}</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->

    <!--begin::Close-->
    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <span class="svg-icon svg-icon-2x svg-icon-light">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
        </span>

    </button>
    <!--end::Close-->
</div>
<!--end::Alert-->
@endif  
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Row-->
        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-1 g-5 g-xl-9">
           <div class="card card-docs flex-row-fluid mb-2"> 
            <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
                
                  @if(isset($roles)) 
        <form class="kt-form" id="frmroleadd" name='frmroleadd' enctype="multipart/form-data"  method='post' action="/admin/roles/{{$roles->id}}" >
            <input type='hidden' id='role_id' name='role_id' value='{{$roles->id}}' />
            @method('put')
            @else 
            <form name='frmroleadd' id='frmroleadd' method="post" action="{{ route('roles.store') }}" >   
                @endif  

                @csrf 
                <div class="mb-10">
                    <label class="form-label">Role Name</label>
                    <input type="text" name="role_name" id="role_name" class="form-control" placeholder="Enter Role Name" value="@isset($roles){{ ucfirst($roles->name) }}@endisset">
                </div>

                <!--begin::Accordion-->
                <div class="accordion" id="kt_accordion_1">
                    @foreach ($navigations as $navi)
                    <div class="accordion-item" id="switch_{{ $navi->id }}">
                        <h2 class="accordion-header" id="kt_accordion_1_header_{{ $navi->id  }} ">
                            <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_{{ $navi->id  }} " aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                              {{ $navi->menu_title }}  <label class="px-5 form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input check_status" type="checkbox" name="modules_id[]" @if(isset($permissions)) @if(in_array($navi->menu_keyword, $permissions)) checked @endif  @endif value="{{ $navi->menu_keyword }}" >
                                <span class="form-check-label fw-bold text-muted">
                                </span>
                            </label>
                        </button>
                    </h2>
                    @foreach ($navi->children as $submenu)
                    <div id="kt_accordion_1_{{ $navi->id  }}" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_{{ $navi->id  }}" data-bs-parent="#kt_accordion_1">

                        <div class="accordion-body">
                           <div id="submenu_{{ $submenu->id }}" class="submenudiv d-flex flex-stack flex-root flex-row">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input type="checkbox" class="form-check-input submenus" data-id = "actions_{{ $submenu->id }}" data-parentid = "switch_{{ $navi->id }}" name="modules_id[]" @if(isset($permissions)) @if(in_array($submenu->menu_keyword, $permissions)) checked @endif  @endif value="{{ $submenu->menu_keyword }}">
                                <span class="fw-bold ps-2 fs-6">{{ $submenu->menu_title }}</span>
                            </label>

                            <div class="">
                             @foreach ($submenu->navaction as $actions)
                             <div class="mb-3">

                              <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input actions" type="checkbox"  data-parentid = "switch_{{ $navi->id }}" data-id = "submenu_{{ $submenu->id }}" name="modules_id[]" @if(isset($permissions)) @if(in_array($actions->module_keyword, $permissions)) checked @endif @endif  value="{{ $actions->module_keyword }}" />
                                <span class="fw-bold ps-2 fs-6">{{$actions->module_title}}</span>
                            </label>
                        </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
<!--end::Accordion-->
</div>

<div class="card-footer d-flex justify-content-center py-6 px-9">
    <button type="submit" class="btn btn-primary" id="">Save Changes</button>
</div>
</form>
</div>

</div>
<!--end::Row-->
<!--begin::Modals-->


<!--end::Modals-->
</div>
<!--end::Container-->
</div>
<!--end::Post-->

@endsection

@section('scripts')
<script src="{{asset('js/admin/roles/addrole.js')}}"></script>
@endsection