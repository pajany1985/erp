<!--begin::Drawer-->
<div id="kt_drawer_example_dismiss" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_drawer_example_dismiss_button" data-kt-drawer-close="#kt_drawer_example_dismiss_close" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'md': '500px'}">
    <!--begin::Card-->
    <div class="card rounded-0 w-100">
        <!--begin::Card header-->
        <div class="card-header pe-5">
            <!--begin::Title-->
            <div class="card-title">
                <!--begin::User-->
                <div class="d-flex justify-content-center flex-column me-3">
                    <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 lh-1">Filter by Candidates</a>
                </div>
                <!--end::User-->
            </div>
            <!--end::Title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-icon-primary" id="kt_drawer_example_dismiss_close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"></path><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body hover-scroll-overlay-y">
        <div class="form-group mb-10">
            <label>Filter by Active Position:</label> <br><br>
            <!-- @foreach ($activeposition as $key=>$position)
                <label class="form-check form-check-custom form-check-solid form-check-sm mb-3">
                    <input class="form-check-input" data-kt-candidate-table-filter="filter" type="checkbox" value="{{$position->id}}"/>
                    <span class="form-check-label">
                        {{ucfirst($position->name)}}
                    </span>
                </label>
            @endforeach -->
                                            
               
            <select name="searchpos" id="searchpos" data-control="select2"  data-placeholder="Search by Interview..." class="form-select" data-allow-clear="true"  multiple="multiple">
                <!-- <option></option> -->
                @foreach ($activeposition as $key=>$position)
                <option data-kt-candidate-table-filter="filter" value="{{$position->id}}" >{{ucfirst($position->name)}}</option>
                @endforeach  
            </select>
                
        </div>

        <div class="form-group mb-10">
            <label>Filter by Rating:</label> <br><br>
            <div  data-kt-candidate-table-filter="form">
                                               
                <!--begin::Input group-->                                                       
                <!--begin::Options-->
                <div class="d-flex flex-column flex-wrap fw-bold" data-kt-candidate-table-filter="filter">
                    <!--begin::Option-->
                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                        <input class="form-check-input starrating_checkbox" type="radio" id="rating_4" name="rating_type" value="4"  />
                        <span class="form-check-label ">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}"> <span class="fs-6 text-gray-700">&amp; Up </span>
                        </span>
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                        <input class="form-check-input starrating_checkbox" type="radio" id="rating_3" name="rating_type" value="3" />
                        <span class="form-check-label ">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}"> <span class="fs-6 text-gray-700">&amp; Up </span>
                        </span>
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                        <input class="form-check-input starrating_checkbox" type="radio" id="rating_2" name="rating_type" value="2" />
                        <span class="form-check-label ">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}"> <span class="fs-6 text-gray-700">&amp; Up </span>
                        </span>
                    </label>
                    <!--end::Option-->
                    <!--begin::Option-->
                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input starrating_checkbox" type="radio" id="rating_1" name="rating_type" value="1" />
                        <span class="form-check-label ">
                            <img src="{{asset('media/raty/small_star/star-on.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}">
                            <img src="{{asset('media/raty/small_star/star-off.svg')}}"> <span class="fs-6 text-gray-700">&amp; Up </span>
                        </span>
                    </label>
                    <!--end::Option-->
                </div>
                <!--end::Options-->
                <!--end::Input group-->

            </div>
        </div>
           
           
        </div>
        <!--end::Card body-->
        
    </div>
    <!--end::Card-->
</div>
<!--end::Drawer-->