@csrf
@if(isset($user))
@method('PUT')
@endif
<input type='hidden' id='user_id' name='user_id' value='@if(isset($user)){{$user->id}}@endif' />
<input type="hidden" name="status" @if (@isset ($user->status) && $user->status == "0") value="0" @else value="1" @endif />
<input type="hidden" name="addoredit" @if (@isset ($user)) value="edit" @else value="add" @endif >
<!--begin::Scroll-->
<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="d-block fw-bold fs-6 mb-5">Avatar</label>
        <!--end::Label-->
        <!--begin::Image input-->
            @if(@isset ($user->profile_pic) && $user->profile_pic !="")
        <div class="image-input image-input-outline" id="kt_image_input_control" data-kt-image-input="true" style="background-image: url({{asset('media/svg/avatars/blank.svg')}})">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset('/uploads/users/admin_users/'.$user->profile_pic) }});"></div>
                @else
        <div class="image-input image-input-outline image-input-empty" id="kt_image_input_control" data-kt-image-input="true" style="background-image: url({{asset('media/svg/avatars/blank.svg')}})">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-125px h-125px"></div>
            @endif
            <!--end::Preview existing avatar-->
            <!--begin::Label-->
            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-dismiss="click" data-bs-toggle="tooltip" title="Change avatar">
                <i class="bi bi-pencil-fill fs-7"></i>
                <!--begin::Inputs-->
                <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                <input type="hidden" name="profile_avatar_remove" />
                <!--end::Inputs-->
            </label>
            <!--end::Label-->
            <!--begin::Cancel-->
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel"  data-bs-dismiss="click" data-bs-toggle="tooltip" title="Cancel avatar">
                <i class="bi bi-x fs-2"></i>
            </span>
            <!--end::Cancel-->
            <!--begin::Remove-->
            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-dismiss="click" data-bs-toggle="tooltip" title="Remove avatar">
                <i class="bi bi-x fs-2"></i>
            </span>
            <!--end::Remove-->
        </div>
        <!--end::Image input-->
        <!--begin::Hint-->
        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
        <!--end::Hint-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Full Name</label>
        <!--end::Label-->
        <!--begin::Input-->
        <!--begin::Input group-->
        <div class="input-group ">
            <span class="input-group-text">
                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                <span class="svg-icon ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </span>
            <input type="text" name="name" class="form-control mb-3 mb-lg-0" placeholder="Full name" value="@isset($user->name){{$user->name}}@endisset" />
        </div>
        <!--end::Input group-->
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Email</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="input-group ">
            <span class="input-group-text">
                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                <span class="svg-icon ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </span>
            <input type="email" name="email"  class="form-control mb-3 mb-lg-0" placeholder="example@domain.com" value="@isset($user->email){{$user->email}}@endisset" />
        </div>
        <!--end::Input-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Username</label>
        <!--end::Label-->
        <!--begin::Input-->
            <div class="input-group ">
                <span class="input-group-text">
                    <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                    <span class="svg-icon ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <input type="text" name="user_name" class="form-control mb-3 mb-lg-0" placeholder="Enter Username" value="@isset($user->username){{$user->username}}@endisset" />
            </div>
        <!--end::Input-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Password</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="password" name="password" class="form-control mb-3 mb-lg-0"  @if(!isset($user)) required="required" placeholder="Enter Password" @else placeholder="Please leave password empty retain old password" @endif/>
        <!--end::Input-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-2">Phone Number</label>
        <!--end::Label-->
        <!--begin::Input-->
        <!--begin::Input group-->
        <div class="input-group ">
            <span class="input-group-text">
                <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                <span class="svg-icon ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </span>
            <input type="text" name="phoneno" id="kt_inputmask_phone" class="form-control mb-3 mb-lg-0" placeholder="Enter Phone No" value="@isset($user->phone){{$user->phone}}@endisset" />
        </div>
        <!--end::Input group-->
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="mb-7">
        <!--begin::Label-->
        <label class="required fw-bold fs-6 mb-5">Role</label>
        <!--end::Label-->
        <!--begin::Roles-->
        <select class="form-select" name="role_id" data-control="select2" data-kt-select2="true" data-placeholder="Select an option">
        @foreach ($roles as $key=>$role)
            <option value="{{$role->id}}" @if (@isset ($user->role_id) && $user->role_id == $role->id) checked='checked' @endif >{{ucfirst($role->name)}}</option>
        @endforeach 
        </select>
        <!--end::Roles-->
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="mb-7">
       <!--begin::Input group-->
            <div class="d-flex flex-stack w-lg-50">
                <!--begin::Label-->
                <div class="me-5">
                    <label class="fs-6 fw-bold form-label">Status</label>
                    <!-- <div class="fs-7 fw-bold text-muted">If you need more info, please check budget planning</div> -->
                </div>
                <!--end::Label-->

                <!--begin::Switch-->
                <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input check_status" type="checkbox" @if (@isset ($user->status) && $user->status == '0') value="0" @else checked="checked" value="1" @endif name="status_hidden" >
                    <span class="form-check-label fw-bold text-muted">
                    </span>
                </label>
                <!--end::Switch-->
            </div>
        <!--end::Input group-->
    </div>
    <!--end::Input group-->

</div>
<!--end::Scroll-->
<!--begin::Actions-->

<!--end::Actions-->
