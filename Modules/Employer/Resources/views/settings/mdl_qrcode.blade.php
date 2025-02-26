<!--begin:: Add Modal-->
<style>
.clr-field button {
	width: 25px;
    height: 25px;
    right: 10px;
}
</style>
<div class="modal fade " id="download_QRmdl" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
				<span>
					<h5 class="modal-title" id="exampleModalLabel">Download Career Page QR Code</h5>
					<!--<span class="form-text text-muted">Select an image from the library to display on your career page.</span>-->
				</span>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
					<span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
					</span>
					<!--end::Svg Icon-->
				</div>
            </div>		
			
		

			<div class="modal-body">				
					<!--begin::Portlet-->
					<div class="row">
						<div class="col-md-12">
							<!--begin::Portlet-->
								<div class="card">	
									<div class="row">
										<input type="hidden" id="filename" name="filename" value="<?php echo strtotime("now"). Auth::user()->id.rand(10,1000);?>">
										<div class="col-lg-4">
											<label class="form-label pt-0">Select QR Code image size:</label>
										</div>
										<div class="col-lg-8">
											<div class="row mb-3">
												<div class="col-lg-12">
								
													<div class="d-flex align-items-center me-2">
														<!--begin::Radio-->
														<div class="form-check form-check-custom form-check-solid form-check-primary me-4">
															<input class="form-check-input" type="radio" name="QR_size_radio" id="QR_size_radio1" value="100">
														</div>
														<!--end::Radio-->
														<!--begin::Info-->
														<span class="d-flex flex-column">
															<span class="fw-bolder fs-6 color-D6E">100 px</span>
															<span class="fs-7 text-muted">(Promotional Items, Business Cards, etc)</span>
														</span>
														<!--end::Info-->
													</div>

												</div>
											</div>
											<div class="row mb-3">
												<div class="col-lg-12">
													<div class="d-flex align-items-center me-2">
														<!--begin::Radio-->
														<div class="form-check form-check-custom form-check-solid form-check-primary me-4">
															<input class="form-check-input" type="radio" name="QR_size_radio" id="QR_size_radio1" value="500" checked="checked">
														</div>
														<!--end::Radio-->
														<!--begin::Info-->
														<span class="d-flex flex-column">
															<span class="fw-bolder fs-6 color-D6E">500 px</span>
															<span class="fs-7 text-muted">(Flyers, Magazines, Catalogs, etc)</span>
														</span>
														<!--end::Info-->
													</div>
												</div>
											</div>
											<div class="row mb-3">
												<div class="col-lg-12">
													<div class="d-flex align-items-center me-2">
														<!--begin::Radio-->
														<div class="form-check form-check-custom form-check-solid form-check-primary me-4">
															<input class="form-check-input" type="radio" name="QR_size_radio" id="QR_size_radio1" value="1000">
														</div>
														<!--end::Radio-->
														<!--begin::Info-->
														<span class="d-flex flex-column">
															<span class="fw-bolder fs-6 color-D6E">1000 px</span>
															<span class="fs-7 text-muted">(Wall posters, Signages, Product Stands, etc)</span>
														</span>
														<!--end::Info-->
													</div>
												</div>
											</div>
											
											<!--<div class="minicolors minicolors-theme-bootstrap minicolors-position-bottom minicolors-position-left minicolors-focus"><input type="text" id="wheel-demo" class="form-control demo minicolors-input" data-control="wheel" value="#ff99ee" size="7"><span class="minicolors-swatch minicolors-sprite"><span class="minicolors-swatch-color" style="background-color: rgb(217, 208, 205);"></span></span><div class="minicolors-panel minicolors-slider-wheel" style="display: block;"><div class="minicolors-slider minicolors-sprite" style="background-color: rgb(255, 244, 241);"><div class="minicolors-picker" style="top: 23px;"></div></div><div class="minicolors-opacity-slider minicolors-sprite"><div class="minicolors-picker"></div></div><div class="minicolors-grid minicolors-sprite"><div class="minicolors-grid-inner"></div><div class="minicolors-picker" style="top: 73px; left: 70px;"><div></div></div></div></div></div>-->
										</div> <!-- col ends -->
									</div> <!-- row ends -->
									<div class="row pt-5">
										<div class="col-lg-4">
											<label class="form-label">Select QR Code Color:</label>
										</div>
										<div class="col-lg-8">
											<input readonly type="text" id="QR_color" class="coloris instance2 form-control" value="#000000">
											<!-- <input type="text" value="green" data-coloris>-->
										</div>
									</div>
								</div> <!--kt-portlet__body end -->
						
							<!--end::Portlet-->
						</div>
						
					</div> <!-- row ends -->				
				
			</div> <!-- modal-body end-->
			<div class='modal-footer'>
				<button type="button" class="btn btn-light btn-active-light-primary imgcancel-btn" data-dismiss="modal" >Cancel</button>
				
				<button  class="btn btn-primary downloadQR " id="insert_image" >Download</button>
				<a id="download_id"  style="display:none;" href="#" download class=" btn btn-primary btn-icon-sm btn-sm btn_file img_100" > <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><g><rect fill="none" height="24" width="24"/></g><g><path d="M5,20h14v-2H5V20z M19,9h-4V3H9v6H5l7,7L19,9z"/></g></svg>&nbsp;Download</a>
				
			</div>   <!-- modal-footer end-->
        </div> <!-- modal-content end-->
    </div> <!-- modal-dialog end-->
</div> <!--end::Modal-->