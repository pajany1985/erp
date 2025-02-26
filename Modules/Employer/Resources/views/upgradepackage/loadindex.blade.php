@foreach($positions as $key => $position)
    <div class="row p-2">
        <!--begin::Tables Widget 5-->
        <div class="card  mb-5 mb-xl-8">
            
            <!--begin::Body-->
            <div class="card-body py-3 ">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="border-0">
                                
                                <!-- <th class="p-0 min-w-110px"></th>
                                <th class="p-0 min-w-50px"></th>
                                <th class="p-0 min-w-110px"></th>
                                <th class="p-0 min-w-50px"></th>
                                <th class="p-0 min-w-50px"></th>
                                <th class="p-0 min-w-50px"></th>
                                <th class="p-0 min-w-50px"></th> -->
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            <tr class="color-D6E">

                                <td class="text-start d-flex flex-column flex-row-auto w-150px">
                                    <div class=" border-none py-3">
                                        <a href="#" class=" d-flex flex-column-auto h-1% text-dark fw-bolder text-hover-primary mb-1 fs-6 ">{{ucfirst($position->name)}}</a>
                                        <span class="color-D6E fw-bold d-block">{{$position->created_at}}</span>
                                    </div>
                                </td>

                                <td class="text-center" >
                                    <span class="badge badge-light-success px-4" >
                                        <span class="px-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                </svg>
                                        </span>Active</span>
                                </td>
                            
                                <td class="text-end border-end">
                                    <!-- <div class="border-gray-200   px-1 py-3"> -->
                                        <span class="text-purple ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 20 20">
                                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                            </svg>
                                        </span>
                                        <span class="color-D6E fw-bolder px-2">All Candidates</span>
                                        <span class="text-purple fw-bolder mb-1 fs-4 underlinehover" data-kt-countup="true" data-kt-countup-value="{{$position->candidates_count}}">{{$position->candidates_count}}</span>
                                    <!-- </div> -->
                                </td>

                                <td  class="text-start ">
                                    <!-- <div class="border-gray-200 border-dotted px-1 py-3"> -->
                                        <span class="px-1 text-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z"/>
                                            </svg>
                                        </span>
                                        <span class="color-D6E fw-bolder">Completed</span>
                                        <span class="text-success fw-bolder mb-1 fs-4 px-2 underlinehover" data-kt-countup="true" data-kt-countup-value="10">10</span>
                                    <!-- </div> -->
                                </td>
                                
                                <td  class="text-start ">
                                    <span class="badge badge-light-primary">
                                        New!
                                    </span>
                                </td>

                                <td class="text-end">
                                    <!--begin::Toolbar-->
                                        <!--begin::Menu-->
                                        <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen053.svg-->
                                                <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/>
                                                    <rect x="10" y="3" width="4" height="4" rx="2" fill="currentColor"/>
                                                    <rect x="10" y="17" width="4" height="4" rx="2" fill="currentColor"/>
                                                    </svg>
                                                </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                        <!--begin::Menu 2-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-700 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                                           
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3 pt-2">
                                                <a href="#" class="menu-link px-3">
                                                     <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                                                <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    Share Interview
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">
                                                      <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                      <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    View Candidates
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3">
                                                      <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                      <span class="menu-icon">(
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    Duplicate Interview
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3 mb-2">
                                                <a href="#" class="menu-link px-3">
                                                      <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                      <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#BE0000" class="bi bi-trash-fill kt-nav__link-icon" viewBox="0 0 16 16">
                                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    Archive Interview
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 2-->
                                        <!--end::Menu-->
                                    <!--end::Toolbar-->
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Tables Widget 5-->
    </div>
    
@endforeach
<div class="row p-2">
    <!--begin::Tables Widget 5-->
    <div class="card  mb-5 mb-xl-8">
        
        <!--begin::Body-->
        <div class="card-body py-3 ">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="border-0">
                            
                            <!-- <th class="p-0 min-w-110px"></th>
                            <th class="p-0 min-w-50px"></th>
                            <th class="p-0 min-w-110px"></th>
                            <th class="p-0 min-w-50px"></th>
                            <th class="p-0 min-w-50px"></th>
                            <th class="p-0 min-w-50px"></th>
                            <th class="p-0 min-w-50px"></th> -->
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <tr class="color-D6E">

                            <td class="text-start d-flex flex-column flex-row-auto w-150px">
                                <div class=" border-none py-3">
                                    <a href="#" class=" d-flex flex-column-auto h-1% text-dark fw-bolder text-hover-primary mb-1 fs-6 ">{{ucfirst($position->name)}}</a>
                                    <span class="color-D6E fw-bold d-block">{{$position->created_at}}</span>
                                </div>
                            </td>

                            <td class="text-center" >
                                <span class="badge badge-light-warning px-5">
                                    <span class="px-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                        </svg>
                                    </span>Draft</span>
                            </td>
                        
                            <td class="text-end border-end">
                                <!-- <div class="border-gray-200   px-1 py-3"> -->
                                    <span class="text-purple ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 20 20">
                                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                        </svg>
                                    </span>
                                    <span class="color-D6E fw-bolder px-2">All Candidates</span>
                                    <span class="text-purple fw-bolder mb-1 fs-4 underlinehover" data-kt-countup="true" data-kt-countup-value="{{$position->candidates_count}}">{{$position->candidates_count}}</span>
                                <!-- </div> -->
                            </td>

                            <td  class="text-start ">
                                <!-- <div class="border-gray-200 border-dotted px-1 py-3"> -->
                                    <span class="px-1 text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z"/>
                                        </svg>
                                    </span>
                                    <span class="color-D6E fw-bolder">Completed</span>
                                    <span class="text-success fw-bolder mb-1 fs-4 px-2 underlinehover" data-kt-countup="true" data-kt-countup-value="10">10</span>
                                <!-- </div> -->
                                
                            </td>

                            <td  class="text-start ">
                                <span class="badge badge-light-primary">
                                    New!
                                </span>
                            </td>

                            <td class="text-end">
                                <!--begin::Toolbar-->
                                    <!--begin::Menu-->
                                    <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen053.svg-->
                                            <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/>
                                                <rect x="10" y="3" width="4" height="4" rx="2" fill="currentColor"/>
                                                <rect x="10" y="17" width="4" height="4" rx="2" fill="currentColor"/>
                                                </svg>
                                            </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu 2-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-700 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                                        
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 pt-2">
                                            <a href="#" class="menu-link px-3">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                <span class="menu-icon">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                                                        </svg>
                                                    </span>
                                                </span>
                                                <!--end::Svg Icon-->
                                                Edit Interview
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <span class="menu-icon">(
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                        </svg>
                                                    </span>
                                                </span>
                                                <!--end::Svg Icon-->
                                                Duplicate Interview
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 mb-2">
                                            <a href="#" class="menu-link px-3">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <span class="menu-icon">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#BE0000" class="bi bi-trash-fill kt-nav__link-icon" viewBox="0 0 16 16">
                                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                                        </svg>
                                                    </span>
                                                </span>
                                                <!--end::Svg Icon-->
                                                Archive Interview
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->
                                    <!--end::Menu-->
                                <!--end::Toolbar-->
                            </td>
                        </tr>
                    </tbody>
                    <!--end::Table body-->
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Tables Widget 5-->
</div>
<div class="row p-2">
    <!--begin::Tables Widget 5-->
    <div class="card  mb-5 mb-xl-8">
        
        <!--begin::Body-->
        <div class="card-body py-3 ">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="border-0">
                            
                            <!-- <th class="p-0 min-w-110px"></th>
                            <th class="p-0 min-w-50px"></th>
                            <th class="p-0 min-w-110px"></th>
                            <th class="p-0 min-w-50px"></th>
                            <th class="p-0 min-w-50px"></th>
                            <th class="p-0 min-w-50px"></th>
                            <th class="p-0 min-w-50px"></th> -->
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        <tr class="color-D6E">

                            <td class="text-start d-flex flex-column flex-row-auto w-150px">
                                <div class=" border-none py-3">
                                    <a href="#" class=" d-flex flex-column-auto h-1% text-dark fw-bolder text-hover-primary mb-1 fs-6 ">{{ucfirst($position->name)}}</a>
                                    <span class="color-D6E fw-bold d-block">{{$position->created_at}}</span>
                                </div>
                            </td>

                            <td class="text-center">
                                <span class="badge badge-light-danger">
                                    <span class="px-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#BE0000" class="bi bi-trash-fill kt-nav__link-icon" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                        </svg>
                                    </span>Archived</span>
                            </td>
                        
                            <td class="text-end border-end">
                                <!-- <div class="border-gray-200   px-1 py-3"> -->
                                    <span class="text-purple ">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 20 20">
                                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                        </svg>
                                    </span>
                                    <span class="color-D6E fw-bolder px-2">All Candidates</span>
                                    <span class="text-purple fw-bolder mb-1 fs-4 underlinehover" data-kt-countup="true" data-kt-countup-value="{{$position->candidates_count}}">{{$position->candidates_count}}</span>
                                <!-- </div> -->
                            </td>

                            <td  class="text-start ">
                                <!-- <div class="border-gray-200 border-dotted px-1 py-3"> -->
                                    <span class="px-1 text-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z"/>
                                        </svg>
                                    </span>
                                    <span class="color-D6E fw-bolder">Completed</span>
                                    <span class="text-success fw-bolder mb-1 fs-4 px-2 underlinehover" data-kt-countup="true" data-kt-countup-value="10">10</span>
                                <!-- </div> -->
                               
                            </td>
                            <td  class="text-start ">
                                <span class="badge badge-light-primary">
                                    New!
                                </span>
                            </td>

                            <td class="text-end">
                                <!--begin::Toolbar-->
                                    <!--begin::Menu-->
                                    <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen053.svg-->
                                            <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect x="10" y="10" width="4" height="4" rx="2" fill="currentColor"/>
                                                <rect x="10" y="3" width="4" height="4" rx="2" fill="currentColor"/>
                                                <rect x="10" y="17" width="4" height="4" rx="2" fill="currentColor"/>
                                                </svg>
                                            </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu 2-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-700 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                                        
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <span class="menu-icon">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                                        </svg>
                                                    </span>
                                                </span>
                                                <!--end::Svg Icon-->
                                                View Candidates
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                    <span class="menu-icon">(
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                        </svg>
                                                    </span>
                                                </span>
                                                <!--end::Svg Icon-->
                                                Duplicate Position
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->
                                    <!--end::Menu-->
                                <!--end::Toolbar-->
                            </td>
                        </tr>
                    </tbody>
                    <!--end::Table body-->
                </table>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Tables Widget 5-->
</div>
{{$positions->links()}}