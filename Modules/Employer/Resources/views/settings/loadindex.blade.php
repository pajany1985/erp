@foreach($positions as $key => $position)
    <div class="row">
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
                                    <span class="badge badge-light-success">Open</span>
                                </td>
                            
                                <td class="text-center ">
                                    <div class="border-gray-200 border-dotted px-1 py-3">
                                        <span class="color-D6E fw-bolder d-block ">Invitation Send</span>
                                        <span class="text-dark fw-bolder mb-1 fs-6" data-kt-countup="true" data-kt-countup-value="{{$position->candidates_count}}">{{$position->candidates_count}}</span>
                                    </div>
                                </td>

                                <td  class="text-center">
                                    <div class="border-gray-200 border-dotted px-1 py-3">
                                        <span class="color-D6E fw-bolder d-block">Completed</span>
                                        <span class="text-dark fw-bolder mb-1 fs-6" data-kt-countup="true" data-kt-countup-value="10">10</span>
                                    </div>
                                </td>

                                <td  class="text-center">
                                    <div class="border-gray-200 border-dotted px-1 py-3">
                                        <span class="color-D6E fw-bolder d-block">Reviewed</span>
                                        <span class="text-dark fw-bolder mb-1 fs-6" data-kt-countup="true" data-kt-countup-value="8">8</span>
                                    </div>
                                </td>

                                <td  class="text-center">
                                    <div class="border-gray-200 border-dotted px-1 py-3">
                                        <span class="color-D6E fw-bolder d-block">Need Review</span>
                                        <span class="text-dark fw-bolder mb-1 fs-6" data-kt-countup="true" data-kt-countup-value="2">2</span>
                                    </div>
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
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                                                <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    Send Invitation
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
                                                      <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-union" viewBox="0 0 16 16">
                                                                <path d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2z"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    Duplicate Request
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3 mb-2">
                                                <a href="#" class="menu-link px-3">
                                                      <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                      <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    Close Project
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
{{$positions->links()}}