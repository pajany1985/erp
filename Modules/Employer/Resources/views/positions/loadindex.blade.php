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

                    <!--begin::Table body-->
                    <tbody>
                        <tr>

                            <td class="text-start d-flex flex-column flex-row-auto w-150px">
                                <div class=" border-none py-3 ">
                                    <a href="{{ route('position.show',encryptId($position->id)) }}" class=" d-flex flex-column-auto h-1% text-dark fw-bolder text-hover-primary mb-1 fs-6 ">{{ucfirst($position->name)}}</a>
                                    <span class="color-D6E fw-bold d-block">{{$position->created_at}}</span>
                                </div>
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
                                                    <a href="/employer/{{encryptId($position->id)}}/candidate"><span class="text-purple fw-bolder mb-1 fs-4 underlinehover px-2" data-kt-countup="true" data-kt-countup-value="{{ get_candidate_allcnt($position->id) }}">{{ get_candidate_allcnt($position->id) }}</span></a>
                                                    <!-- </div> -->
                                            </td>

                                            <td  class="text-start ">
                                                <!-- <div class="border-gray-200 border-dotted px-1 py-3"> -->
                                                    <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                                    <span class="svg-icon svg-icon-1 svg-icon-success px-2">
                                                        <img src="/media/svg/Assessment1.svg" width="16px" height="16px">
                                                    </span>
                                                <!--end::Svg Icon-->
                                                <span class="color-D6E fw-bolder">Completed</span>
                                                <a href="/employer/{{encryptId($position->id)}}/candidate?status=3"><span class="text-success fw-bolder mb-1 fs-4 px-2 underlinehover" data-kt-countup="true" data-kt-countup-value="{{ get_candidate_cmptcnt($position->id) }}">{{ get_candidate_cmptcnt($position->id) }}</span></a>
                                                <!-- </div> -->
                                            </td>

                                            <td class="text-center" >
                                                @if($position->trashed())
                                                <span class="badge badge-light-danger px-4" >
                                                    <span class="px-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                        </svg>
                                                    </span>Archived</span>

                                                    @elseif($position->status == '1')
                                                    <span class="badge badge-light-success px-4" >
                                                    <span class="px-1">

                                                        <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 0 24 24" width="14px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                                    </span>Active</span>
                                                    @elseif($position->status == '0')
                                                    <span class="badge badge-light-warning px-5">
                                                    <span class="px-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 0 24 24" width="14px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11H7v-2h10v2z"/></svg>
                                                    </span>Draft</span>
                                                    @endif
                                            </td>

                                            <!-- <td  class="text-start ">
                                                <span class="badge badge-light-primary">
                                                    New!
                                                </span>
                                            </td> -->

                                            <td class="text-end">
                                                <!--begin::Toolbar-->
                                                <!--begin::Menu-->
                                                <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end @if(session('postPid')==$position->id)shareclick @endif" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
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

                                                @if($position->status == '1' && !$position->trashed())
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3 pt-2">
                                                    <a href="javascript:void(0);" data-href="{{ url('/pid/login') }}/{{ encryptId($position->id) }}" data-pid="{{$position->id}}" @if($storagedetails['allow_recording']=='1') data-bs-toggle="modal" data-bs-target="#mdlshare" @endif class="menu-link px-3 @if(session('postPid')==$position->id)shareurl @endif  @if($storagedetails['allow_recording']=='0') storagefull @endif">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                        <span class="menu-icon">
                                                            <span class="svg-icon svg-icon-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 0 24 24" width="16px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg>
                                                            </span>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                        Share Interview
                                                    </a>
                                                </div>
                                                @endif
                                                <!--end::Menu item-->
                                                @if($position->status == '0' && !$position->trashed())
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3 pt-2">
                                                    <a href="{{ route('position.edit',encryptId($position->id)) }}"  class="menu-link px-3 color-D6E">
                                                       <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                                       <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-3">
                                                         <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 0 24 24" width="16px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                                     </span>
                                                 </span>
                                                 <!--end::Svg Icon-->
                                                 Edit Interview
                                             </a>
                                         </div>
                                         @endif
                                         <!--end::Menu item-->
                                         <!--begin::Menu item-->
                                         @if($position->status == '1' || $position->trashed())
                                         <div class="menu-item px-3 pt-2">
                                            <a href="/employer/{{encryptId($position->id)}}/candidate" class="menu-link px-3">
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
                                    @endif
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 pt-2 mb-2">
                                        <a href="#" data-urldup="{{ route('duplicatep',encryptId($position->id)) }}" class="menu-link px-3 duplicate">
                                          <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                          <span class="menu-icon">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 0 24 24" width="16px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 8h-2v3h-3v2h3v3h2v-3h3v-2h-3zM2 12c0-2.79 1.64-5.2 4.01-6.32V3.52C2.52 4.76 0 8.09 0 12s2.52 7.24 6.01 8.48v-2.16C3.64 17.2 2 14.79 2 12zm13-9c-4.96 0-9 4.04-9 9s4.04 9 9 9 9-4.04 9-9-4.04-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7z"/></svg>
                                            </span>
                                        </span>
                                        <!--end::Svg Icon-->
                                        Duplicate Interview
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                @if(!$position->trashed())
                                <div class="menu-item px-3 mb-2">
                                    <a href="#" class="menu-link px-3 cfrmarchive" data-id='{{ encryptId($position->id) }}'>
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
                            @endif
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