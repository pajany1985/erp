@can('update employer')
<!-- Edit Start -->
<a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 employeredit" title="Edit details" data-employerid='{{ $employer_id }}' >
    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
    <span class="svg-icon svg-icon-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
        </svg>
    </span>
    <!--end::Svg Icon-->
</a>
<!-- Edit End -->

<!-- Edit Start -->
<a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 employernote" title="Notes" data-employerid='{{ $employer_id }}' data-empid="{{$employerid}}" data-adminid="{{$auth_userid}}" >
    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
    <span class="svg-icon svg-icon-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"/>
        </svg>
    </span>
    <!--end::Svg Icon-->
</a>
<!-- Edit End -->
@endcan
@can('delete employer')
<!-- Delete Start -->
<a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm cfrmdelete " title="Delete" data-employerid='{{ $employer_id }}'>
    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
    <span class="svg-icon svg-icon-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
        </svg>
    </span>
    <!--end::Svg Icon-->
</a>
<!-- Delete End -->
@endcan

@can('autologin employer')
<!-- Autologin Start -->
<a href="javascript:;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm autologin" title="Autologin" data-employerid='{{ $employer_id }}'>
    <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
    <span class="svg-icon svg-icon-3">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
<g id="surface1">
<path style=" stroke:none;fill-rule:nonzero;fill:currentColor;fill-opacity:1;" d="M 14.164062 18.265625 C 13.839844 18.21875 13.566406 18.46875 13.566406 18.78125 L 13.566406 22.433594 L 1.042969 22.433594 L 1.042969 1.566406 L 13.566406 1.566406 L 13.566406 5.203125 C 13.566406 5.464844 13.753906 5.699219 14.007812 5.734375 C 14.332031 5.78125 14.609375 5.53125 14.609375 5.21875 L 14.609375 1.042969 C 14.609375 0.757812 14.375 0.523438 14.085938 0.523438 L 0.523438 0.523438 C 0.234375 0.523438 0 0.757812 0 1.042969 L 0 22.957031 C 0 23.242188 0.234375 23.476562 0.523438 23.476562 L 14.085938 23.476562 C 14.375 23.476562 14.609375 23.242188 14.609375 22.957031 L 14.609375 18.796875 C 14.609375 18.535156 14.421875 18.300781 14.164062 18.265625 Z M 14.164062 18.265625 "/>
<path style=" stroke:none;fill-rule:nonzero;fill:currentColor;fill-opacity:1;" d="M 23.847656 11.636719 L 18.628906 6.417969 C 18.421875 6.21875 18.09375 6.226562 17.894531 6.429688 C 17.703125 6.632812 17.703125 6.949219 17.894531 7.152344 L 22.21875 11.476562 L 6.277344 11.476562 C 6.019531 11.476562 5.789062 11.65625 5.75 11.910156 C 5.691406 12.238281 5.949219 12.523438 6.265625 12.523438 L 22.226562 12.523438 L 17.894531 16.847656 C 17.6875 17.046875 17.679688 17.378906 17.882812 17.582031 C 18.082031 17.792969 18.417969 17.796875 18.621094 17.59375 C 18.625 17.585938 18.628906 17.582031 18.628906 17.582031 L 23.847656 12.363281 C 24.050781 12.171875 24.050781 11.839844 23.847656 11.636719 Z M 23.847656 11.636719 "/>
</g>
</svg>

 </span>
    <!--end::Svg Icon-->
</a>
<!-- Autologin End -->
@endcan


<!-- <a href="javascript:;"  class="btn btn-sm btn-clean btn-icon btn-icon-sm cfrmdelete " title="Delete" data-employerid='{{ $employer_id }}'><i class="flaticon2-delete "></i></a> -->