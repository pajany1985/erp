@if($employercomment->count()>0)
    @foreach($employercomment as $employercomments)
        <div class="timeline-item">
            <div class="timeline-line w-40px"></div>
            <div class="timeline-icon symbol symbol-circle symbol-40px">
                <div class="symbol-label bg-light">
                    <span class="">
                        <i class="text-primary fw-bolder">{{nameFirstLetter($employercomments->adminuser->name)}}</i>
                    </span>
                </div>
            </div>
            <div class="timeline-content mt-n1">
                <div class="pe-3">
                    <div class="fs-5 fw-bold mb-2 color-D6E fw-bolder">
                    {{ucfirst($employercomments->adminuser->name)}}
                    <span class="text-muted   me-1 fs-7">{{converdate($employercomments->created_at)}}</span></div>
                    <div class="overflow-auto pb-5">
                        <div class="d-flex align-items-center mt-1 fs-6">
                            <div class="text-muted me-2 fs-7 color-D6E">
                                <span class="text-muted   me-1 fs-7"> {{$employercomments->notes}}</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif