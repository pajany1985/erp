@extends('employer::layouts.master')
@section('pagetitle','Manage Interviews')

@section('content')

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <input type="hidden" name="pid" id='pid' value="">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">


        <div class="row ">

            <div id="kt_toolbar_container" class="d-flex flex-stack flex-wrap m-5">
                <div class="page-title d-flex  flex-row align-items-start ">
                    <!--begin::Title-->
                    
                    <h1 class="d-flex text-gray-800 fw-bolder my-1 fs-4 mb-3">All Candidates        


                        <!--end::Title-->

                    </div>



                </div>
                <div class="col-xl-3 mb-5">
                    <!--begin::List Widget 3-->
                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header ">
                            <h3 class="card-title fw-bolder text-dark">Candidates by Status</h3>

                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body px-0">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary " data-kt-menu="true">


                                <!--begin::Menu item-->
                                <div class="menu-item ">
                                    <a href="javascript:void(0);" class="menu-link py-3 active emp_position_menulink" data-status="all">
                                        <span class="menu-icon">
                                         <i class="bi bi-people-fill"></i>
                                     </span>
                                     <span class="menu-title">All Candidates</span>
                                     <span class="badge badge-circle badge-light-primary cntall"></span>
                                 </a>
                             </div>
                             <!--end::Menu item-->
                             <!--begin::Menu item-->
                             <div class="menu-item ">
                                <a href="javascript:void(0);" class="menu-link py-3 emp_position_menulink" data-status="2">
                                    <span class="menu-icon">
                                        <img src="/media/svg/Assessment2.svg" width="16px" height="16px">
                                    </span>
                                    <span class="menu-title">Incomplete</span>
                                    <!-- <span class="menu-badge menu-badge-circle fs-7 fw-normal text-muted">2</span> -->
                                    <span class="badge badge-circle badge-light-primary cntincomp"></span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item ">
                                <a href="javascript:void(0);" class="menu-link py-3 emp_position_menulink completed" data-status="3">
                                    <span class="menu-icon">
                                        <img src="/media/svg/Assessment1.svg" width="16px" height="16px">
                                    </span>
                                    <span class="menu-title">Completed</span>
                                    <!-- <span class="menu-badge menu-badge-circle fs-7 fw-normal text-muted">2</span> -->
                                    <span class="badge badge-circle badge-light-success cntcomp"></span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item ">
                                <a href="javascript:void(0);" class="menu-link py-3 emp_position_menulink" data-status="4">
                                    <span class="menu-icon">
                                        <svg viewBox="0 0 16 20" class="bi bi-star-fill kt-nav__link-icon" fill="#FFAA00" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                        </svg>
                                    </span>
                                    <span class="menu-title">Hired</span>
                                    <!-- <span class="menu-badge fs-7 fw-normal text-muted">4</span> -->
                                    <span class="badge badge-circle badge-light-warning cnthired"></span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="javascript:void(0);" class="menu-link py-3 emp_position_menulink" data-status="5">
                                    <span class="menu-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#BE0000" class="bi bi-trash-fill kt-nav__link-icon" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                        </svg>
                                    </span>
                                    <span class="menu-title">Archived</span>
                                    <!-- <span class="menu-badge fs-7 fw-normal text-muted">139</span> -->
                                    <span class="badge badge-circle badge-light-danger cntarch"></span>
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
                <!--begin::Row-->
                <!--begin::Card-->

                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center my-1">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-1 color-D6E">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0086FF" class="bi bi-people-fill" viewBox="0 0 16 16">
                                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                                        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"></path>
                                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <span class="px-2">
                                    Candidate List
                                    <span>
                                    </div>
                                    <!--end::Search-->
                                    
                                </div>
                                <!--end::Card title-->
                                <div class="card-toolbar">
                                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-candidate-table-toolbar="selected">
                                        <button type="button" class="btn btn-danger" id="kt_datatable_delete_all" data-kt-candidate-table-select="delete_selected">Archive</button>
                                    </div>
                                </div>

                            </div>
                            <div class="card-header border-0 py-6">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6 color-D6E">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-candidate-table-filter="search" class="form-control form-control-solid w-250px ps-15 color-D6E" placeholder="Search candidates" />
                                    </div>
                                    <!--end::Search-->
                                    <!--begin::Filter-->
                                    <div class="d-flex align-items-end position-relative my-1 px-2 ratingdiv" data-kt-candidate-table-toolbar="base">
                                        <button type="button" class="btn btn-bg-light btn-active-primary " id="kt_drawer_example_dismiss_button">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" >
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="currentColor"></path>
                                                    </g>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--begin::Menu 1-->
                                        
                                        <!--end::Menu 1-->
                                    </div>
                                    <div class="px-3">
                                     <button type="reset" class="btn btn-light btn-active-light-primary fw-bold me-2 px-6  resetbtn d-none" data-kt-menu-dismiss="true" data-kt-candidate-table-filter="reset">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                        </svg> Reset Filter
                                    </button>
                                </div>
                            </div>
                            <!--end::Card title-->

                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">

                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5" name="candidate_datatable" id="kt_table_candidates">
                                <input type="hidden" value="" name="position_id" id="position_id">
                                <input type="hidden" value="all" name="candidate_status" id="candidate_status">
                                <input type="hidden" value="" name="star_rating" id="star_rating">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_candidates .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-85px">Created Date</th>
                                        <th class="min-w-140px">Name</th>
                                        <th class="min-w-125px">Email</th>
                                        <th class="min-w-50px"></th>
                                        <th class="min-w-70px">Ranking</th>
                                        <th class="text-end min-w-150px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600"></tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->


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
                   <!--end::Modals - Hire-->
                   <!--end::Row-->
               </div>
           </div>
       </div>
       <!--end::Post-->
   </div>
   @include('employer::allcandidates.filterdrawer')

   @endsection

   @section('scripts')
   <script src="{{asset('js/employer/allcandidates/candidate.js')}}"></script>
   <script src="{{asset('js/jquery.raty.js')}}?version={{rand()}}"></script>
   @endsection