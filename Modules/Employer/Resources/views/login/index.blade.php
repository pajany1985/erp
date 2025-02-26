@extends('employer::layouts.masterlogin')
@section('pagetitle','Employer Sign In')

@section('content')
<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
	<!--begin::Form-->
	<form method="POST" class="form w-100" novalidate="novalidate" id="kt_sign_in_form"  action="{{ route('employer.validatelogin') }}">
	{{ csrf_field() }}
		<!--begin::Heading-->
		<div class="text-center mb-10">
			<!--begin::Title-->
			<h1 class="text-dark mb-3">Sign In</h1>
			<!--end::Title-->
			<!--begin::Link-->
			<div class="text-gray-400 fw-bold fs-4">New Here?
			<a href="/" class="link-primary fw-bolder">Create an Account</a></div>
			<!--end::Link-->
		</div>
		<!--begin::Heading-->
		<!--begin::Input group-->
		<div class="fv-row mb-10">
			<!--begin::Label-->
			<label class="form-label fs-6 fw-bolder text-dark">Email</label>
			<!--end::Label-->
			<!--begin::Input-->
			<input class="form-control form-control-lg form-control-solid" type="email" name="email"  autocomplete="off" />
			<!--end::Input-->
		</div>
		<!--end::Input group-->
		<!--begin::Input group-->
		<div class="fv-row mb-10">
			<!--begin::Wrapper-->
			<div class="d-flex flex-stack mb-2">
				<!--begin::Label-->
				<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
				<!--end::Label-->
				<!--begin::Link-->
				<a href="/employer/forgotpass" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
				<!--end::Link-->
			</div>
			<!--end::Wrapper-->
			<!--begin::Input-->
			<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />
			<!--end::Input-->
		</div>
		<!--end::Input group-->
		<!--begin::Actions-->
		<div class="text-center">
			<!--begin::Submit button-->
			<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
				<span class="indicator-label">Continue</span>
				<span class="indicator-progress">Please wait...
				<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
			</button>
			<!--end::Submit button-->
		</div>
		<!--end::Actions-->
	</form>
	<!--end::Form-->
</div>
@endsection


@section('scripts')
<script src="{{asset('js/employer/login/login.js')}}"></script>
@endsection
