<div class="modal " id="logo_imageEditor" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true"  style="color:#4B6C8B;">
  <div class="modal-dialog modal-lg maxWidth modal-dialog-centered">
    <div class="modal-content modalContent w-100" id="logo_imageEditorContent">

		<div class="modal-header borderRite">
        <h4 class="modal-title" id="modalLabelSmall">Image Editor </h4>
			
			<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
				<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
				<span class="svg-icon svg-icon-1">
					<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
				</span>
				<!--end::Svg Icon-->
			</div>
       <!--  <span> 
			<button type="button" class="addAnother buttonDefault cropimage" id="applyimage" >SAVE</button>
			<button type="button" class="mx-3 positonInput addLocat default_hover res_mar px-3 cancelmodal" data-dismiss="modal" aria-label="Close">CANCEL</button> 
		</span> -->
		</div>
		<div class="modal-body pt-0 px-0 pb-0" style=" overflow-y:auto">
			<div class="container-fluid popup_padding">
				<div class="row pt-3">
					<div class="col-md-12">					
						<div class="img-container">
							<img id="logo_image" src="" height="300" width="500" />
						</div>
					</div>					
				</div> <!-- row ends -->				
				<div class="row pt-3">
					<div class="col-md-12 text-center">
						<button type="button" class="btn btn-primary logo_cropimage"  id="crop">
							<span class="docs-tooltip">
							  <span class="fa fa-crop-alt"></span>
							</span>
						</button>
						<div class="btn-group">
							<button type="button" class="btn btn-primary" id="logo_ZoomInBtn">
								<span class="docs-tooltip">
								  <span class="fa fa-search-plus"></span>
								</span>
							</button>
							<button type="button" class="btn btn-primary" id="logo_ZoomOutBtn">
								<span class="docs-tooltip">
								  <span class="fa fa-search-minus "></span>
								</span>
							</button>						  
						</div>
						
						<button type="button" class="btn btn-primary" id="logo_Zoomreset">
							<span class="docs-tooltip">
							  <span class="fa fa-sync-alt"></span>
							</span>
						</button>
						
					</div> 
				</div> <!-- row ends -->
				
				
			</div> <!-- container ends -->
        </div>  <!-- modal body ends -->
        <div class='modal-footer'>
					<button type="button" class="btn btn-primary logo_cropimage" id="applyimage" >Save</button>
					<!-- <button type="button" class="btn btn-secondary cancelmodal" data-dismiss="modal" onclick="">CANCEL</button> -->
				</div>  
      </div> <!-- modal-content ends -->
    </div> <!-- modal dialog ends -->
  </div> <!-- modal ends -->



