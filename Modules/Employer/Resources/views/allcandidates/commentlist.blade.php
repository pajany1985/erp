@if($candidatecomment->count()>0)
    @foreach($candidatecomment as $candidatecomments)
        <!--begin::Timeline item-->
        <div class="timeline-item">
            <!--begin::Timeline line-->
            <div class="timeline-line w-40px"></div>
            <!--end::Timeline line-->
            <!--begin::Timeline icon-->
            <div class="timeline-icon symbol symbol-circle symbol-40px">
                <div class="symbol-label bg-light">
                @if($candidatecomments->system_msg !='')
                    <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                    <span class="svg-icon svg-icon-2 svg-icon-gray-500">
                        <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"></path></svg>
                    </span>
                    <!--end::Svg Icon-->
                @elseif($candidatecomments->comments !='')
                    <span class="">
                        <i class="text-primary fw-bolder">{{nameFirstLetter($candidatecomments->employer->first_name)}}{{nameFirstLetter($candidatecomments->employer->last_name)}}</i>
                    </span>
                @endif
                </div>
            </div>
            <!--end::Timeline icon-->
            <!--begin::Timeline content-->
            <div class="timeline-content mb-10 mt-n1">
                <!--begin::Timeline heading-->
                <div class="pe-3 mb-5">
                    <!--begin::Title-->
                    <div class="fs-5 fw-bold mb-2 color-D6E fw-bolder">
                    @if($candidatecomments->system_msg !='')
                        System Message 
                    @elseif($candidatecomments->comments !='')
                        Comment
                    @endif
                    <span class="text-muted   me-1 fs-7">{{converdate($candidatecomments->created_at)}}</span></div>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <div class="overflow-auto pb-5">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center mt-1 fs-6">
                            <!--begin::Info-->
                            <div class="text-muted me-2 fs-7 color-D6E">
                            @if($candidatecomments->system_msg !='')
                            {{$candidatecomments->system_msg}}
                            @elseif($candidatecomments->comments !='')
                                {{nameFirstLetter($candidatecomments->employer->first_name)}}{{nameFirstLetter($candidatecomments->employer->last_name)}} added a comment:<span class="text-muted   me-1 fs-7"> {{$candidatecomments->comments}}</span>
                            @endif
                            </div>
                            <!--end::Info-->
                            <!--begin::User-->
                            <!--end::User-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Description-->
                </div>
                <!--end::Timeline heading-->
            </div>
            <!--end::Timeline content-->
        </div>
        <!--end::Timeline item-->
    @endforeach
@endif