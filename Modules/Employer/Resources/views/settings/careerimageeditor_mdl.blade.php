<div class="modal " id="imageEditor" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true"  style="color:#4B6C8B;">
	<div class="modal-dialog modal-lg maxWidth">
	<div id="mdlcontent" class="modal-content modalContent w-100">

		<div class="modal-header borderRite">
		<h4 class="modal-title" id="modalLabelSmall">Image Editor </h4>
		
		</div>
		<div class="modal-body pt-0 px-0 pb-0" style="height:500px; overflow-y:auto">
			<div class="container-fluid popup_padding">
				<div class="row pt-3">
					<div class="col-md-12">					
						<div class="img-container">
							
						@if(isset($career_setting->banner_image) && $career_setting->banner_image !='')
						
							@if(file_exists(public_path(Config::get('constants.BUSINESS_BANNER_PATH')).''.$career_setting->banner_image))
								<img id="image" src="{{asset(Config::get('constants.BUSINESS_BANNER_PATH')).'/'.$career_setting->banner_image}}" style="max-width:100%;" height="400px" />
							@else
								<img id="image" src="https://s3.amazonaws.com/IdealTraits/Image+Library/Corporate+Banners/img_22.png" style="max-width:100%;" height="400px" />
							@endif
						@else 
							<img id="image" src="https://s3.amazonaws.com/IdealTraits/Image+Library/Corporate+Banners/img_22.png" style="max-width:100%;" height="400px" />
						@endif
						
					
						</div>
					</div>					
				</div> <!-- row ends -->				
				<div class="row pt-3">
					<div class="col-md-12 text-center">
						<button type="button" class="btn btn-primary cropimage"  id="crop">
							<span class="docs-tooltip">
								<span class="fa fa-crop-alt"></span>
							</span>
						</button>
						<div class="btn-group">
							<button type="button" class="btn btn-primary" id="ZoomInBtn">
								<span class="docs-tooltip">
									<span class="fa fa-search-plus"></span>
								</span>
							</button>
							<button type="button" class="btn btn-primary" id="ZoomOutBtn">
								<span class="docs-tooltip">
									<span class="fa fa-search-minus "></span>
								</span>
							</button>						  
						</div>
						
						<button type="button" class="btn btn-primary" id="Zoomreset">
							<span class="docs-tooltip">
								<span class="fa fa-sync-alt"></span>
							</span>
						</button>
						
					</div> 
				</div> <!-- row ends -->
				
				
			</div> <!-- container ends -->
		</div>  <!-- modal body ends -->
		<div class='modal-footer'>
					<button type="button" class="btn btn-light btn-active-light-primary cancelmodal" data-dismiss="modal" onclick="">Cancel</button>
					<button type="button" class="btn btn-primary cropimage" id="applyimage" >Save</button>
					
				</div>  
		</div> <!-- modal-content ends -->
	</div> <!-- modal dialog ends -->
</div>


<!--begin:: Add Modal-->
<div class="modal fade " id="postJobImg" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div id="post_mdlcontent" class="modal-content">
            <div class="modal-header">
				<span>
					<h5 class="modal-title" id="exampleModalLabel">Image Library</h5>
					<span class="form-text text-muted">Select an image from the library to display on your career page.</span>
				</span>
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
					<span class="svg-icon svg-icon-1">
						<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
					</span>
					<!--end::Svg Icon-->
				</div>
            </div>
				
				<div class="modal-body " >
					<!-- container portlet start-->
						<!--begin::Portlet-->
						<div class="row">

							<div class="col-md-3">
								<!--begin::Portlet-->

								<ul class="nav nav-tabs nav-pills border-0 flex-row flex-md-column me-5 mb-3 mb-md-0 fs-6">
									@php 
										$active_cat = 0;
									@endphp
									@if($image_cat->count()>0)
										@foreach($image_cat as $img_cat)
											<li class="nav-item w-md-150px me-0 imgcategory_nav" data-catid="imgcategory_{{$img_cat->category_id}}" id="imgcategory_{{$img_cat->category_id}}_tab">
												<a class="nav-link @if($active_cat==0)active @endif" data-bs-toggle="tab" href="javascript:void(0);">@if($img_cat->category == 'Corporate_banners') Corporate @elseif($img_cat->category == 'Generic_banners') Generic @endif</a>
											</li>
											@if($active_cat==0)
													<input type="hidden" id="cat_id" name="cat_id" value="{{$img_cat->category_id}}">
											@endif
											
											@php 
												$active_cat++;
											@endphp
										@endforeach
									@endif
								
								</ul>
								<!--end::Portlet-->
							</div>

							<div class="col-md-9 border">
								<!--begin::Portlet-->

								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active scroll-y me-n7 pe-7"  id="kt_vtab_pane_1" role="tabpanel" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"  data-kt-scroll-offset="300px">
										@php 
											$active_tabpane = 0;
										@endphp
										@if($image_cat->count()>0)
											@foreach($image_cat as $img_cat)
												<div class="imgcategory_tab " style="@if($active_tabpane==0) display:block; @else display:none; @endif" id="imgcategory_{{$img_cat->category_id}}" >
													<!-- Hello {{$img_cat->category_id}} -->
												</div>
												@php 
													$active_tabpane++;
												@endphp
											@endforeach
										@endif
									</div>
								</div>
								<!--end::Portlet-->
							</div>

						</div>
					
					<!-- container portlet end-->
				</div>
				<div class='modal-footer'>
					<button type="button" class="btn btn-light btn-active-light-primary imgcancel-btn" data-dismiss="modal" >Cancel</button>
					<button  class="btn btn-primary submitinsertform " id="insert_image"  >Insert</button>
					
				</div>   
                
            
        </div>
    </div>
</div>
<!--end::Modal-->


<!--begin:: Add Modal-->
<div class="modal fade " id="mdlusetemplate" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header row" >
				<div class="col-8">
					<h5 class="modal-title" id="exampleModalLabel">Company Description Templates</h5>
					<span class="form-text text-muted">Choose a pre-formatted company description and click insert button</span>
				</div>
				<div class="col-4 text-end">
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
						<span class="svg-icon svg-icon-1">
							<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
						</span>
						<!--end::Svg Icon-->
					</div>
				</div>
            </div>
            
            <form  method='post' action="" enctype="multipart/form-data" id='frmusetemplate' name="frmusetemplate">  
                <div class="modal-body">
                    <!-- container portlet start-->
                        <!--begin::Portlet-->
                        <div class="row">
                            <div class="col-md-12">
                                <!--begin::Portlet-->
                                    <div class="">
										<div style="border: 1px solid #e1e1ef;">
											<div class="form-group p-3">
												
												<div class="kt-checkbox-list" id="usetmpapend">
													
												</div>
											</div>
										</div>
                                    </div>
                                <!--end::Portlet-->
                            </div>
                        </div>
                    
                    <!-- container portlet end-->
                </div>
                <div class='modal-footer'>
                    <button type="button" class="btn btn-light btn-active-light-primary tempcancel-btn" data-dismiss="modal" onclick="this.form.reset();">Cancel</button>
                    <button type="button" class="btn btn-primary insertDescTemplate" id="insertTemp" >Insert</button>
                    
                </div>   
            </form>
            
        </div>
    </div>
</div>
<!--end::Modal-->