@if($candidate->status=='1' || $candidate->status=='2')
<a href="javascript:;" class="text-hover-primary sendinvite " title="Resend invite" data-assessment="1" data-candidateid='{{ $candidate_id }}'>
    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
    <span class="svg-icon svg-icon-1">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="currentColor" >
            <path d="M12 13 4 8v10h9v2H4q-.825 0-1.412-.587Q2 18.825 2 18V6q0-.825.588-1.412Q3.175 4 4 4h16q.825 0 1.413.588Q22 5.175 22 6v7h-2V8Zm0-2 8-5H4Zm7 12-1.4-1.4 1.575-1.6H15v-2h4.175l-1.6-1.6L19 15l4 4ZM4 8v11-6 .075V6Z"/>
        </svg>
    </span>
    <!--end::Svg Icon-->
</a> 
@endif