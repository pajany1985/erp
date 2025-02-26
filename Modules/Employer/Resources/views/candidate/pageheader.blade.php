<div class="card mb-5 mb-xxl-8">
    <div class="card-body pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-circle">
                    <span class="symbol-label fs-1 bg-light-primary text-primary fw-bold">{{ ucwords(substr($candidate->first_name,0,1)) }}{{ ucwords(substr($candidate->last_name,0,1)) }}</span>
                </div>
            </div>  
            <!--end::Pic-->
            
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2 mt-5">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{ ucfirst($candidate->first_name) }} {{ ucfirst($candidate->last_name) }}</a>
                            <a href="#">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                <!--    <span class="svg-icon svg-icon-1 svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                            <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF"></path>
                                            <path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white"></path>
                                        </svg>
                                </span> -->
                                <!--end::Svg Icon-->
                            </a>
                        </div>
                        <!--end::Name-->
                        <!--begin::Info-->
                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                <i class="bi bi-person-fill mx-1"></i>
                                <!--end::Svg Icon-->{{ ucfirst($candidate->position->name) }}</a>

                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            </span>
                            <!--end::Svg Icon-->{{ $candidate->email }}</a>
                        </div>
                        <!--end::Info-->
                    </div>  
                    <!--end::User-->
                    <!--begin::Actions-->
                    <div class="d-flex my-4">
                        <div class="rating" id="rating" data-candidateid="{{ $encrypt_cid }}" data-score="{{ $candidate->star_rate }}"></div>
                        <div class="vr mx-2"></div>
                        <!--begin::Menu-->
                        <div class="me-0">
                            <form method="post" id='frmcandidate'>
                                @csrf
                                <input type="hidden" name="cid" value='{{ $encrypt_cid }}'>
                                <input type="hidden" name="pid" value='{{ $candidate->position->id }}'>
                            </form>    
                            @if($candidate->trashed()) 
                                <!-- <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected"> <span class="svg-icon svg-icon-2">
                                    <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#ffffff" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                    </svg>
                                </span>Delete </button>   -->
                                <button type="button" class="btn btn-primary" id='restore' data-kt-customer-table-select="delete_selected"> <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="50px" viewBox="0 0 24 24" version="1.1">
                                        <g id="surface1">
                                            <path style=" stroke:none;fill-rule:nonzero;fill:#ffffff;fill-opacity:1;" d="M 12 5 L 12 2 L 8 6 L 12 10 L 12 7 C 15.308594 7 18 9.691406 18 13 C 18 15.96875 15.828125 18.429688 13 18.910156 L 13 20.929688 C 16.949219 20.441406 20 17.078125 20 13 C 20 8.578125 16.421875 5 12 5 Z M 6 13 C 6 11.351562 6.671875 9.851562 7.761719 8.761719 L 6.339844 7.339844 C 4.898438 8.789062 4 10.789062 4 13 C 4 17.078125 7.050781 20.441406 11 20.929688 L 11 18.910156 C 8.171875 18.429688 6 15.96875 6 13 Z M 6 13 "/>
                                        </g>
                                    </svg>
                                </span>Restore </button>                    

                            @else 
                                @switch($candidate->status)
                                    @case(1)
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"> New
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>

                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-125px py-3" data-kt-menu="true">

                                            <div class="menu-item ">
                                                <a href="javascript:void(0);" class="menu-link px-3" data-candidateid="{{ $encrypt_cid }}"  data-bs-toggle="modal" data-bs-target="#mdl_hire" >
                                                    <svg viewBox="0 0 16 20" class="bi bi-star-fill kt-nav__link-icon" fill="#FFAA00" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                    </svg>
                                                    <span class="px-3 color-D6E">Hire<span>
                                                </a>
                                            </div>

                                            <div class="menu-item ">
                                                <a href="javascript:void(0);" class="menu-link px-3 cfrmarchive" data-candidateid="{{ $encrypt_cid }}"   >
                                                    <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                                    </svg>
                                                    <span class="px-3 text-danger">Archive<span>
                                                </a>
                                            </div>
                                        </div>
                                    @break

                                    @case(2)
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"> Incomplete
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>

                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-125px py-3" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item ">
                                                <a href="javascript:void(0);" class="menu-link px-3" data-candidateid="{{ $encrypt_cid }}"  data-bs-toggle="modal" data-bs-target="#mdl_hire" >
                                                    <svg viewBox="0 0 16 20" class="bi bi-star-fill kt-nav__link-icon" fill="#FFAA00" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                    </svg>
                                                    <span class="px-3 color-D6E">Hire<span>
                                                </a>
                                            </div>

                                            <div class="menu-item ">
                                                <a href="javascript:void(0);" class="menu-link px-3 cfrmarchive" data-candidateid="{{ $encrypt_cid }}"   >
                                                    <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                                    </svg>
                                                    <span class="px-3 text-danger">Archive<span>
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->  
                                    @break

                                    @case(3)
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"> Completed
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>

                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-125px py-3" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item ">
                                                <a href="javascript:void(0);" class="menu-link px-3" data-candidateid="{{ $encrypt_cid }}"  data-bs-toggle="modal" data-bs-target="#mdl_hire" >
                                                    <svg viewBox="0 0 16 20" class="bi bi-star-fill kt-nav__link-icon" fill="#FFAA00" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                    </svg>
                                                    <span class="px-3 color-D6E">Hire<span>
                                                </a>
                                            </div>
                                            <div class="menu-item ">
                                                <a href="javascript:void(0);" class="menu-link px-3 cfrmarchive" data-candidateid="{{ $encrypt_cid }}"   >
                                                    <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                                    </svg>
                                                    <span class="px-3 text-danger">Archive<span>
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->  
                                    @break

                                    @case(4)
                                        <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"> Hired
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>

                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-125px py-3" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item ">
                                                <a href="javascript:void(0);" class="menu-link px-3 cfrmarchive" data-candidateid="{{ $encrypt_cid }}"   >
                                                    <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                                                    </svg>
                                                    <span class="px-3 text-danger">Archive<span>
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->  
                                    @break
                                @endswitch
                            @endif

                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Title-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
    </div>
</div>