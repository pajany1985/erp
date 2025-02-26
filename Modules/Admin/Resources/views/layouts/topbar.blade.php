   <!--begin::Toolbar wrapper-->
   <div class="d-flex align-items-stretch flex-shrink-0">
               
                <!--begin::Theme mode-->
                <div class="d-flex align-items-center ms-1 ms-lg-3">
                    <!--begin::Theme mode docs-->
                    <!-- <a class="btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" href="../../demo1/dist/documentation/getting-started/dark-mode.html">
                        <i class="fonticon-sun fs-2"></i>
                    </a> -->
                    <!--end::Theme mode docs-->
                </div>
                <!--end::Theme mode-->
                <!-- <div class="rounded-pill bg-light-primary d-flex align-items-center position-relative h-40px w-100 p-2 overflow-hidden">
                    <div class="position-absolute rounded-pill d-block bg-primary start-0 top-0 h-100 z-index-1" style="width:60%;"></div>
        
                    <div class="d-flex align-items-center position-relative z-index-2">
                        <div class="symbol-group symbol-hover flex-nowrap me-3">
                            <div class="symbol symbol-circle symbol-25px"><img alt="" src="assets/media/avatars/300-6.jpg"></div><div class="symbol symbol-circle symbol-25px"><img alt="" src="assets/media/avatars/300-1.jpg"></div>
                        </div>
        
                        <a href="#" class="fw-bold text-white text-hover-dark">Meeting</a>
                    </div>
        
                    <div class="d-flex flex-center bg-body rounded-pill fs-7 fw-bolder ms-auto h-100 px-3 position-relative z-index-2">
                        60%
                    </div>
                </div> -->
                <span class="badge py-3 px-4 fs-7 badge-light-primary">Welcome {{ auth()->user()->name }} </span>
                <!--begin::Header menu toggle-->
                <div class="d-flex align-items-center d-lg-none ms-2 me-n3" title="Show header menu">
                    <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/text/txt001.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13 11H3C2.4 11 2 10.6 2 10V9C2 8.4 2.4 8 3 8H13C13.6 8 14 8.4 14 9V10C14 10.6 13.6 11 13 11ZM22 5V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4V5C2 5.6 2.4 6 3 6H21C21.6 6 22 5.6 22 5Z" fill="currentColor" />
                                <path opacity="0.3" d="M21 16H3C2.4 16 2 15.6 2 15V14C2 13.4 2.4 13 3 13H21C21.6 13 22 13.4 22 14V15C22 15.6 21.6 16 21 16ZM14 20V19C14 18.4 13.6 18 13 18H3C2.4 18 2 18.4 2 19V20C2 20.6 2.4 21 3 21H13C13.6 21 14 20.6 14 20Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                </div>
                <!--end::Header menu toggle-->
            </div>
            <!--end::Toolbar wrapper-->