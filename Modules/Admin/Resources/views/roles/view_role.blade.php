@extends('admin::layouts.master')
@section('pagetitle','View Roles')

@section('content')
<!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container-xxl">
                                <!--begin::Layout-->
                                <div class="d-flex flex-column flex-lg-row">
                                    <!--begin::Sidebar-->
                                    <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
                                        <!--begin::Card-->
                                        <div class="card card-flush">
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h2 class="mb-0">{{ ucfirst($roles->name) }}</h2>
                                                    <input type="hidden" name="role" id="role" value="{{ $roles->id }}" />
                                                </div>
                                                <!--end::Card title-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Permissions-->
                                                <div class="d-flex flex-column text-gray-600">
                                                    <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>Some Admin Controls</div>
                                                    <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>View Financial Summaries only</div>
                                                    <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>View and Edit API Controls</div>
                                                    <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>View Payouts only</div>
                                                    <div class="d-flex align-items-center py-2">
                                                    <span class="bullet bg-primary me-3"></span>View and Edit Disputes</div>
                                                  
                                                </div>
                                                <!--end::Permissions-->
                                            </div>
                                            <!--end::Card body-->
                                            <!--begin::Card footer-->
                                             <div class="card-footer flex-wrap pt-0">
                                            @can('update role')
                                                <button type="button" class="editrole btn btn-light btn-active-light-primary my-1"  onclick="window.location.href='../roles/{{ encryptId($roles->id) }}/edit'" data-roleid="{{ encryptId($roles->id) }}" >Edit Role</button>
                                            @endcan
                                            </div>
                                                <!--end::Card footer-->
                                        </div>
                                        <!--end::Card-->
                                       
                                    </div>
                                    <!--end::Sidebar-->
                                    <!--begin::Content-->
                                    <div class="flex-lg-row-fluid ms-lg-10">
                                        <!--begin::Card-->
                                        <div class="card card-flush mb-6 mb-xl-9">
                                            <!--begin::Card header-->
                                            <div class="card-header pt-5">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <h2 class="d-flex align-items-center">Users Assigned
                                                    <span class="text-gray-600 fs-6 ms-1">({{ $user_cnt }})</span></h2>
                                                </div>
                                                <!--end::Card title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <!--begin::Search-->
                                                    <div class="d-flex align-items-center position-relative my-1" data-kt-view-roles-table-toolbar="base">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        <input type="text" data-kt-roles-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Users" />
                                                    </div>
                                                    <!--end::Search-->
                                                    <!--begin::Group actions-->
                                                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-view-roles-table-toolbar="selected">
                                                        <div class="fw-bolder me-5">
                                                        <span class="me-2" data-kt-view-roles-table-select="selected_count"></span>Selected</div>
                                                        <button type="button" class="btn btn-danger" data-kt-view-roles-table-select="delete_selected">Delete Selected</button>
                                                    </div>
                                                    <!--end::Group actions-->
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                               <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Name</th>
                            <th class="min-w-125px">Email</th>
                            <th class="min-w-125px">Username</th>
                            <th class="min-w-125px">Status</th>
                            <th class="min-w-125px">Created Date</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-bold"></tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Layout-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Post-->

@endsection

@section('scripts')
<script src="{{asset('js/admin/roles/viewrole.js')}}"></script>
@endsection