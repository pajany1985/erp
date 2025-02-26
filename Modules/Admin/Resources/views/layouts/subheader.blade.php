	<!--begin::Sub-Header-->
    <div class="toolbar" id="kt_toolbar">
		<!--begin::Container-->
		<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
			<!--begin::Page title-->
			<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
				<!--begin::Title-->
				<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">@yield('pagetitle')
				<!--begin::Separator-->
				@hasSection('pagedescription')
				<span class="h-20px border-1 border-gray-200 border-start ms-3 mx-2 me-3"></span>  @yield('pagedescription')
				@endif
				<!--end::Separator-->
				<!--begin::Description-->
			<!-- 	<span class="text-muted fs-7 fw-bold mt-2">#XRS-45670</span> -->
				<!--end::Description--></h1>
				<!--end::Title-->
			</div>
			<!--end::Page title-->
	
		</div>
		<!--end::Container-->
	</div>
	<!--end::Sub-Header-->