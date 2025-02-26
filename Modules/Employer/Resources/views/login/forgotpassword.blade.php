@extends('employer::layouts.masterlogin')
@section('pagetitle','Employer Sign In')

@section('content')
<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
	<!--begin::Form-->
	<form method="POST" class="form w-100" novalidate="novalidate" id="kt_password_reset_form"  action="{{ route('employer.forgotmail') }}">
	{{ csrf_field() }}
		<!--begin::Heading-->
		<div class="text-center mb-10">
			<!--begin::Title-->
			<h1 class="text-dark mb-3">Forgot Password ?</h1>
			<!--end::Title-->
			<!--begin::Link-->
			<div class="text-gray-400 fw-bold fs-4">Enter your email to reset your password.</div>
			<!--end::Link-->
		</div>
		<!--begin::Heading-->
		<!--begin::Input group-->
		<div class="fv-row mb-10">
			<label class="form-label fw-bolder text-gray-900 fs-6">Email</label>
			<input class="form-control " type="email" placeholder="" name="email" id="email" autocomplete="off" />
		</div>
		<!--end::Input group-->
		<!--begin::Actions-->
		<div class="d-flex flex-wrap justify-content-center pb-lg-0">
			<button type="submit" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
				<span class="indicator-label">Submit</span>
				<span class="indicator-progress">Please wait...
				<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
			</button>
			<a href="/employer/login" class="btn btn-lg btn-light-primary fw-bolder">Cancel</a>
		</div>
		<!--end::Actions-->
	</form>
	<!--end::Form-->
</div>
@endsection


@section('scripts')
<script src="{{asset('js/employer/login/password-reset.js')}}"></script>
@endsection
