"use strict";

// Class definition
var KTSigninGeneral = function() {
    // Elements
    var table;
    var dt;
    var form;
    var submitButton;
    var validator;
    var url = document.location.toString();
    var originalImageURL ;
    var originalLogoImageURL;
    var logo_image = document.getElementById('logo_image');
    var cropper;


    var edittarget = document.querySelector("#kt_content_container");
    var editblockUI = new KTBlockUI(edittarget, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
    });

    
    var company_logochoose = function(){

     

        $("#business_logo").change(function(){
            // bannerimagecrop
            
            var file;
            file = $(this)[0].files[0];
            var height;
            var width ;			
            var options;			
                    
            var uploadedImageName = file.name;
            var uploadedImageType = file.type;

            var uploadedImageURL = URL.createObjectURL(file);						 
            if(cropper) {
            
            cropper.destroy();
            cropper = null;
            }	

            $('#logo_image').attr('src',uploadedImageURL);
            //cropper = new Cropper(image, options);
            cropper = new Cropper(logo_image, {									  
              // aspectRatio: 1858 / 600, 
               aspectRatio: 269 / 73,
              // aspectRatio: 16 / 9,
              autoCropArea: 1,
             
            });

            // $('#logo_imageEditor').modal({backdrop: 'static', keyboard: false});
             $('#logo_imageEditor').modal("show");
            // console.log(file);
        });

        $('.editimage').click(function(){
            $.ajax({
              url:"settings/getlogoimage",
                type: 'post',
                beforeSend: function(){
                    editblockUI.block();
                },
                success:function(responseData)
                {
                    editblockUI.release();
                  
                  if (responseData.business_logo != '')
                  {
                    if(responseData.logo_image_exist=="yes")
                    {
                        if(cropper)
                        {
                          cropper.destroy();
                          cropper = null;
                        }	
                        $('#logo_image').attr('src',responseData.business_logo);
                        cropper = new Cropper(logo_image, {				 
                          autoCropArea:1,
                          aspectRatio: 269 / 73,
                          // aspectRatio: 1858 / 600,
                          // aspectRatio: 16 / 9,
                          crop: function(e) {
                            
                        }
                      });
                    }
                    else
                    {
                      if(cropper) {
                        cropper.destroy();
                        cropper = null;
                      }
                      $('#logo_image').attr('src',responseData.business_logo);	
                        cropper = new Cropper(logo_image, {	
                          autoCropArea: 1,
                          aspectRatio: 269 / 73,
                          // aspectRatio: 1858 / 600,
                          // aspectRatio: 16 / 9,					  
                        
                      });
                    }
                    originalLogoImageURL =  $('#logo_image').attr('src');
                    $('#logo_imageEditor').modal('show');	
                  }
                }
            });
        });

        $(".logo_cropimage").click(function(){        
            var canvas;
            if (cropper) {
                canvas = cropper.getCroppedCanvas();
                logo_image.src = canvas.toDataURL();
                
                canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function(){
                  var base64data = reader.result;
                  uploadlogoimage(base64data);	
                			
                };
              }, 'image/png', 1);		
            }
        });

        $('#logo_ZoomInBtn').click(function()
            { 
            if (cropper) {
                cropper.zoom(0.1);		  
            }
        });

        $('#logo_ZoomOutBtn').click(function(){ 
          if (cropper) {
            cropper.zoom(-0.1);		  
          }
        });

        $('#logo_Zoomreset').click(function(){ 
            if (cropper) {
              cropper.destroy();
              cropper = null;	  
            }
            $('#logo_image').attr('src',originalLogoImageURL);
            cropper = new Cropper(logo_image, {						 
                autoCropArea:1,
                aspectRatio: 269 / 73,
                // aspectRatio: 1858 / 600,
                // aspectRatio: 16 / 9,				 
                
            });
        });


    }

    function uploadlogoimage(file_data)
    {   
        var target = document.querySelector("#logo_imageEditorContent");
        var blockUI = new KTBlockUI(target, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
        });

        $.ajax({
            url:"settings/savebusinesslogo",
            type: 'post',
            // dataType: "json",
            data: { "business_logo": file_data},
            // data: form_data,
            beforeSend: function(){
                
               // blockUI.block();
                $('.logo_cropimage').attr('disabled', true);
                $('#applyimage').attr('disabled', true);         
            },
            success:function(responseData)
            {
                //blockUI.release();
                $('.logo_cropimage').attr('disabled', false);
                $('#applyimage').attr('disabled', false); 

                var img ='<img src="'+responseData.path+'" height="'+responseData.business_height+'" width="'+responseData.business_width+'"  />';
                /*var link = '<button type="button" class="btn btn-elevate btn-sm btn-icon  imgremovelink" data-toggle="kt-tooltip" title="" data-original-title="Remove Image" onclick="deletelogoimage()"><svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-font-brandideal curpointer" fill="currentColor" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path></svg></button>';*/
                var link ='<a class="imgremovelink editimage" data-toggle="kt-tooltip" title="" data-original-title="Edit Image" ><svg class="kt-font-brandideal curpointer" fill="currentColor" width="18px" viewBox="0 0 24 24" height="18px" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></a><a class="imgremovelink deletelogoimage" data-toggle="kt-tooltip" title="" data-original-title="Remove Image" ><svg viewBox="0 0 16 16" class="bi bi-trash-fill kt-font-brandideal curpointer" fill="currentColor" height="18" width="18" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"></path></svg></a>'
                $('.imgremovelink').remove();
                $('#business_logo_preview1').html(img);
                $('#editorremove').html(link);
                
                $('#logo_imageEditor').modal('hide');	
                $('#logo_imageEditor').data('bs.modal',null);
                deletelogoimage();
                var cropper;

                $('.editimage').click(function(){
                    $.ajax({
                      url:"settings/getlogoimage",
                        type: 'post',
                        beforeSend: function(){
                            editblockUI.block();
                        },
                        success:function(responseData)
                        {
                            editblockUI.release();
                          
                          if (responseData.business_logo != '')
                          {
                              
                            if(responseData.logo_image_exist=="yes")
                            {
                                if(cropper)
                                {
                                  cropper.destroy();
                                  cropper = null;
                                }	
                                $('#logo_image').attr('src',responseData.business_logo);
                                cropper = new Cropper(logo_image, {				 
                                  autoCropArea:1,
                                  aspectRatio: 269 / 73,
                                  // aspectRatio: 1858 / 600,
                                  //  aspectRatio: 16 / 9,
                                  crop: function(e) {
                                    
                                }
                              });
                            }
                            else
                            {
                              if(cropper) {
                                cropper.destroy();
                                cropper = null;
                              }
                              $('#logo_image').attr('src',responseData.business_logo);	
                                cropper = new Cropper(logo_image, {	
                                  autoCropArea: 1,
                                  aspectRatio: 269 / 73,
                                  // aspectRatio: 1858 / 600,	
                                  // aspectRatio: 16 / 9,				  
                                
                              });
                            }
                            originalLogoImageURL =  $('#logo_image').attr('src');
                            $('#logo_imageEditor').modal('show');	
                          }
                        }
                    });
                });
        
                $(".logo_cropimage").click(function(){        
                    var canvas;
                    if (cropper) {
                        canvas = cropper.getCroppedCanvas();
                        logo_image.src = canvas.toDataURL();
                        
                        canvas.toBlob(function(blob){
                        url = URL.createObjectURL(blob);
                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function(){
                          var base64data = reader.result;
                          uploadlogoimage(base64data);	
                                    
                        };
                      }, 'image/png', 1);		
                    }
                });
        
                $('#logo_ZoomInBtn').click(function()
                    { 
                    if (cropper) {
                        cropper.zoom(0.1);		  
                    }
                });
        
                $('#logo_ZoomOutBtn').click(function(){ 
                  if (cropper) {
                    cropper.zoom(-0.1);		  
                  }
                });
        
                $('#logo_Zoomreset').click(function(){ 
                    if (cropper) {
                      cropper.destroy();
                      cropper = null;	  
                    }
                    $('#logo_image').attr('src',originalLogoImageURL);
                    cropper = new Cropper(logo_image, {						 
                        autoCropArea:1,
                        aspectRatio: 269 / 73,
                        // aspectRatio: 1858 / 600,
                        // aspectRatio: 16 / 9,				 
                        
                    });
                });
        
                
            }
        });

    }

    var company_video = function(){
        $("#company_video").change(function(){
            
            var file;
            file = $(this)[0].files[0];
            var height;
            var width ;			
            var options;			
                    
            var uploadedVideoName = file.name;
            var uploadedVideoType = file.type;

            var uploadedVideoURL = URL.createObjectURL(file);	
            document.querySelector("#upload_videotag").src = uploadedVideoURL;					 
            
        });
    }

    var hideshowcompanyvideofield = function(){
       
        var loadwelcome_radio =$('input[name="welcome_radio"]:checked').val();
            if(loadwelcome_radio=='upload'){
                $("#upload_videodiv").css("display", "block");
                $("#videourl_embedurl").css("display", "none");
            }else if(loadwelcome_radio=='url'){
                $("#upload_videodiv").css("display", "none");
                $("#videourl_embedurl").css("display", "block");
            }
            
        $(".welcomeradio").on("change", function(e) {
            if ($('input[name="welcome_radio"]').is(":checked")){
                var welcome_radio =$('input[name="welcome_radio"]:checked').val();
                if(welcome_radio=='upload'){
                    $("#upload_videodiv").css("display", "block");
                    $("#videourl_embedurl").css("display", "none");
                }else if(welcome_radio=='url'){
                    $("#upload_videodiv").css("display", "none");
                    $("#videourl_embedurl").css("display", "block");
                }
            }else{
                $("#upload_videodiv").css("display", "none");
                $("#videourl_embedurl").css("display", "none");
            }
    
        });
    }


    var getuserId = function(e) 
    {
     return e.attr('data-userid');
    };

    var validateCompanySetting = function() {
        $("#kt_company_setting_form").validate({
            errorClass: 'invalid-feedback',
          // define validation rules
          rules: {
                company_name: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim( value );
                    }
                },
                website: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim( value );
                    }
                },
            },

            highlight: function (element, errorClass, validClass) {
                $( element ).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {

                $( element ).removeClass('is-invalid');

            },
            submitHandler: function(form) {
                    form.submit(); // submit the form
                    
                    }
        });

    };

    var imageOpen = function(){
        $(".open_image").click(function(){  
            var dataurl = $(this).attr('data-url');
            open_image(dataurl);
        });
        
    }

    function open_image(url)
    {
        window.open(url, '_blank','toolbar=0,menubar=0,status=0,copyhistory=0,scrollbars=yes,resizable=1,location=1,Width=800,Height=600');
    }
 
    var deletelogoimage = function() {
        $('.deletelogoimage').click(function() {
            $.ajax({
            url:"settings/deletebusinesslogo",
                type: 'post',
                beforeSend: function(){
                    editblockUI.block();      
                },
                success:function(responseData)
                { 
                $('#business_logo').val('');
                editblockUI.release();
                if(responseData.response=="success")
                {
                    $('.imgremovelink').remove();
                    $('#business_logo_preview1').html(responseData.default_img);
                }
                
                }
            });
        });
      }
    // Public functions
    return {
        // Initialization
        init: function() {
            // form = document.querySelector('#kt_sign_in_form');
            // submitButton = document.querySelector('#kt_sign_in_submit');
    
            company_logochoose();
            company_video();
            hideshowcompanyvideofield();
            validateCompanySetting();
            imageOpen();
            deletelogoimage();
        }
        
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTSigninGeneral.init();
    $.validator.messages.required = '';  
    $('#close_button').click(function() {
        $('#kt_modal_new_user_form').trigger("reset");
       //$('#mdluser_add').modal({show:false});
       $('#kt_modal_new_user').modal('hide');

   });

   $('#logo_imageEditor').on('hidden.bs.modal', function () 
    {
      $('#business_logo').val('');
    })

});

function capitalize(str) {
    var strVal = '';
    str = str.split(' ');
    for (var chr = 0; chr < str.length; chr++) {
      strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' '
    }
    return strVal
  }


