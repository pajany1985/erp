@if($candidate->trashed())
    <!-- archived -->
    <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary restore" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-candidateid='{{ $candidate_id }}'>
        <!-- <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
         <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
     </svg> -->
     Restore
     
 </a>
@elseif($candidate->status=='4') 
<!-- Hired -->
<a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-toggle="modal" data-target="#mdl_hire">
     <svg viewBox="0 0 16 20" class="bi bi-star-fill kt-nav__link-icon" fill="#FFAA00" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>Hired
 <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
 <span class="svg-icon svg-icon-5 m-0">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
    </svg>
</span>
<!--end::Svg Icon-->
</a>
<!--begin::Menu-->
<!-- menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary  -->
<!-- menu menu-sub menu-sub-dropdown menu-column  menu-gray-600 menu-state-bg menu-active-primary menu-hover-primary  fw-bold fs-7 w-125px py-4 -->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-125px py-3" data-kt-menu="true">
  
    <!--begin::Menu item-->
    <div class="menu-item ">
        <a href="javascript:void(0);" class="menu-link px-3 cfrmarchive" data-candidateid='{{ $candidate_id }}' >
            <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
            </svg>
            <span class="px-3 text-danger">Archive<span>
            </a>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::Menu-->
  
 @elseif($candidate->status=='3')
 <!-- Candidate -->
 <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Completed
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
    <span class="svg-icon svg-icon-5 m-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
        </svg>
    </span>
    <!--end::Svg Icon-->
</a>
<!--begin::Menu-->
<!-- menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary  -->
<!-- menu menu-sub menu-sub-dropdown menu-column  menu-gray-600 menu-state-bg menu-active-primary menu-hover-primary  fw-bold fs-7 w-125px py-4 -->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-125px py-3" data-kt-menu="true">
   
    <!--begin::Menu item-->
    <div class="menu-item ">
        <a href="javascript:void(0);" class="menu-link px-3" data-candidateid='{{ $candidate_id }}' data-bs-toggle="modal" data-bs-target="#mdl_hire" >
         <svg viewBox="0 0 16 20" class="bi bi-star-fill kt-nav__link-icon" fill="#FFAA00" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
        </svg>
        <span class="px-3 color-D6E">Hire<span>
        </a>
    </div>
    <div class="menu-item ">
        <a href="javascript:void(0);" class="menu-link px-3 cfrmarchive" data-candidateid='{{ $candidate_id }}' data-toggle="modal" data-target="#kt_candidates_export_modal" >
            <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
            </svg>
            <span class="px-3 text-danger">Archive<span>
            </a>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::Menu-->   

    @elseif($candidate->status=='2')
    <!-- Candidate -->
    <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Incomplete
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
        <span class="svg-icon svg-icon-5 m-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </a>
    <!--begin::Menu-->
    <!-- menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary  -->
    <!-- menu menu-sub menu-sub-dropdown menu-column  menu-gray-600 menu-state-bg menu-active-primary menu-hover-primary  fw-bold fs-7 w-125px py-4 -->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-125px py-3" data-kt-menu="true">
     
        <!--begin::Menu item-->

        <div class="menu-item ">
            <a href="javascript:void(0);" class="menu-link px-3" data-candidateid='{{ $candidate_id }}' data-bs-toggle="modal" data-bs-target="#mdl_hire" >
            <svg viewBox="0 0 16 20" class="bi bi-star-fill kt-nav__link-icon" fill="#FFAA00" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
            </svg>
            <span class="px-3 color-D6E">Hire<span>
            </a>
        </div>

        <div class="menu-item ">
            <a href="javascript:void(0);" class="menu-link px-3 cfrmarchive" data-candidateid='{{ $candidate_id }}' data-toggle="modal" data-target="#kt_candidates_export_modal" >
                <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                </svg>
                <span class="px-3 text-danger">Archive<span>
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->

        @elseif($candidate->status=='1')

        <!-- Candidate -->
        <a href="javascript:void(0);" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Incomplete <!-- This New status as client want to change incomplete staus-->
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
            <span class="svg-icon svg-icon-5 m-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </a>
        <!--begin::Menu-->
        <!-- menu menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary  -->
        <!-- menu menu-sub menu-sub-dropdown menu-column  menu-gray-600 menu-state-bg menu-active-primary menu-hover-primary  fw-bold fs-7 w-125px py-4 -->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-700 menu-state-bg fw-bold menu-active-primary menu-hover-primary fs-7 w-125px py-3" data-kt-menu="true">
         
            <!--begin::Menu item-->
            <div class="menu-item ">
                <a href="javascript:void(0);" class="menu-link px-3" data-candidateid='{{ $candidate_id }}' data-bs-toggle="modal" data-bs-target="#mdl_hire" >
                <svg viewBox="0 0 16 20" class="bi bi-star-fill kt-nav__link-icon" fill="#FFAA00" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                </svg>
                <span class="px-3 color-D6E">Hire<span>
                </a>
            </div>
            
            <div class="menu-item ">
                <a href="javascript:void(0);" class="menu-link px-3 cfrmarchive" data-candidateid='{{ $candidate_id }}'  >
                    <svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-nav__link-icon" fill="#BE0000" height="16" width="16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path>
                    </svg>
                    <span class="px-3 text-danger">Archive<span>
                    </a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu-->       
            @endif
