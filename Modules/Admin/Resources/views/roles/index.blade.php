@extends('admin::layouts.master')
@section('pagetitle','Manage Roles')

@section('content')
    @if (session('success'))
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row px-3 py-1 mb-10 ms-10 me-10">
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
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                <!--begin::Col-->
                @foreach ($roles as $key=>$role)
                    <div class="col-md-4">
                        <!--begin::Card-->
                        <div class="card card-flush h-md-100">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{ ucfirst($role->name) }}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-1">
                                <!--begin::Users-->
                                <div class="fw-bolder text-gray-600 mb-5">
                                    Total users with this role: {{ $role->user_count }} 
                                </div>
                                <!--end::Users-->
                                <!--begin::Permissions-->
                                <div class="d-flex flex-column text-gray-600">
                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>All Admin Controls
                                    </div>

                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>View and Edit Financial Summaries
                                    </div>

                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>Enabled Bulk Reports
                                    </div>

                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>View and Edit Payouts
                                    </div>

                                    <div class="d-flex align-items-center py-2">
                                        <span class="bullet bg-primary me-3"></span>View and Edit Disputes
                                    </div>                     
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            <div class="card-footer flex-wrap pt-0">
                                @can('list role')
                                <a href="roles/{{ $role->id}}" class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                                @endcan
                                @can('update role')
                                <button type="button" class="editrole btn btn-light btn-active-light-primary my-1"  onclick="window.location.href='roles/{{ encryptId($role->id) }}/edit'" data-roleid="{{ encryptId($role->id) }}" >Edit Role</button>
                                @endcan
                            </div>
                            <!--end::Card footer-->
                        </div>
                        <!--end::Card-->
                    </div>
                <!--end::Col-->
                @endforeach

                @can('create role')
                <!--begin::Add new card-->
                <div class="ol-md-4">
                    <!--begin::Card-->
                    <div class="card h-md-100">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center">
                            <!--begin::Button-->
                            <button type="button" class="btn btn-clear d-flex flex-column flex-center" onclick="window.location.href='roles/create'">
                                <!--begin::Illustration-->
                                <img src="{{asset('media/illustrations/sketchy-1/4.png')}}" alt="" class="mw-100 mh-150px mb-7" />
                                <!--end::Illustration-->
                                <!--begin::Label-->
                                <div class="fw-bolder fs-3 text-gray-600 text-hover-primary">Add Role</div>
                                <!--end::Label-->
                            </button>
                            <!--begin::Button-->
                        </div>
                        <!--begin::Card body-->
                    </div>
                    <!--begin::Card-->
                </div>
                <!--begin::Add new card-->
                @endcan
            </div>
            <!--end::Row-->
            <!--begin::Modals-->
            @include('admin::roles.mdl_role')

            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->

@endsection

@section('scripts')
<script src="{{asset('js/admin/roles/addrole.js')}}"></script>
@endsection