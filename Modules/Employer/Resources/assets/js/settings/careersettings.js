"use strict";
var cropper;
var originalImageURL ;
var cropeditor = document.querySelector("#mdlcontent");
var editblockUI = new KTBlockUI(cropeditor, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

var postimage = document.querySelector("#post_mdlcontent");
var postimageblockUI = new KTBlockUI(postimage, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});
var validation;
var Form = document.querySelector('#kt_company_setting_form');
// Class definition
var CareerSetting = function() {
    // Elements
    var table;
    var dt;
    var form;
    var submitButton;
    var url = document.location.toString();
   
    var originalLogoImageURL;
    var logo_image = document.getElementById('logo_image');
    // var cropper;
    submitButton = document.querySelector('#kt_career_setting_submit');
   
  

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

    var getuserId = function(e) 
    {
     return e.attr('data-userid');
    };


    var imageOpen = function(){
        $(".open_image").click(function(){  
            var dataurl = $(this).attr('data-url');
            open_image(dataurl);
        });

        $(".showlibraryimages").click(function(){  
          var photo_id = $(this).attr('data-val');
          showlibraryimages(photo_id)
        });

        $(".submitinsertform").click(function(){  
          submitinsertform();
        });

        $(".cancelmodal").click(function(){  
            $('#imageEditor').modal('hide');
        });

        $(".imgcancel-btn").click(function(){  
          $('#postJobImg').modal('hide');
      });
        
      $("#kt_career_setting_submit").click(function(){

        var html = $('#business_description').val();
        html = htmlspecialchars(html);

        $('#business_description').val(html);


        var validator = validation; // get validator for last form
					validator.validate().then(function (status) {
						if (status == 'Valid') {
		
              submitButton.setAttribute('data-kt-indicator', 'on');
              submitButton.disabled = true;
		
							// Simulate form submission
							setTimeout(function() {
                $('#kt_company_setting_form').submit();
								// Hide loading indication
								submitButton.removeAttribute('data-kt-indicator');
								// Enable button
								submitButton.disabled = false;
		
							}, 2000);
						} else {
							Swal.fire({
								text: "Sorry, looks like there are some errors detected, please try again.",
								icon: "error",
								buttonsStyling: false,
								confirmButtonText: "Ok, got it!",
								customClass: {
									confirmButton: "btn btn-primary"
								}
							});
						}
					});

      

       


      });
      
        
        
    }

    function open_image(url)
    {
        window.open(url, '_blank','toolbar=0,menubar=0,status=0,copyhistory=0,scrollbars=yes,resizable=1,location=1,Width=800,Height=600');
    }


    var bannerimagecrop = function()
    {
      var url = document.location.toString();
    
      // var originalImageURL ;
      var originalLogoImageURL;
      var image = document.getElementById('image');
      $("#company_photo1").change(function(){
            //if (typeof (FileReader) != "undefined") {		
              // $('#image').attr('src',' ');
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
    
            $('#image').attr('src',uploadedImageURL);
              //cropper = new Cropper(image, options);
              cropper = new Cropper(image, {									  
                aspectRatio: 1858 / 600, 
                autoCropArea: 1,
                
              });
              console.log(cropper);
              
              $('#imageEditor').modal({backdrop: 'static', keyboard: false});
              $('#imageEditor').modal('show');
                  
        });

      
          $('.editimage').click(function(){
            bannerimage();
          });

          $(".cropimage").click(function(){ 

            $('.cropimage').attr('disabled', true);
            $('#applyimage').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true); 
            $('.cancelmodal').attr('disabled', true); 
            editblockUI.block();

            var canvas;
            if (cropper) {
              canvas = cropper.getCroppedCanvas();
              image.src = canvas.toDataURL();
              
              var img_file = canvas.toBlob(function(blob) {

                var today = new Date();
                const year = today.getFullYear();
                const month = (today.getMonth()+1);
                const d = today.getDate();
                const hour = today.getHours();
                const mins = today.getMinutes();
                const sec = today.getSeconds();
                var filname = year+''+month+''+d +''+ hour+''+mins+''+sec;



                var filename = filname + "." + "png"; 
                var file = new File([blob], filename, { type: 'image/png' });
                uploadimage(file);
              
              
              }, 'image/png', 1);	
              
              //    	
            }
            //uploadimage(img_file);
            // $('#kt_company_setting_form').submit();
          });

          $('#ZoomInBtn').click(function()
          { 
            if (cropper) {
              cropper.zoom(0.1);		  
            }
          });

          $('#ZoomOutBtn').click(function(){ 
            if (cropper) {
              cropper.zoom(-0.1);		  
            }
          });

          $('#Zoomreset').click(function(){ 
            if (cropper) {
              cropper.destroy();
              cropper = null;	  
            }
            $('#image').attr('src',originalImageURL);
            cropper = new Cropper(image, {						 
              autoCropArea:1,
                  //aspectRatio: 269 / 73,
                  aspectRatio: 1858 / 600,				 
                  
                });
          });

    }

    var imagelibrary = function(){
        $(document).on("click", ".imgcategory_nav", function(e) {
          $('#insert_image').attr('disabled',true);
            var categoryid = getcategoryid($(this));
          $('.imgcategory_nav').removeClass('active');
          $('#'+categoryid+'_tab').addClass('active');
          $('.imgcategory_tab').hide();

          $('#'+categoryid).show();
          var cat_id = categoryid.split('_');
          $('#cat_id').val(cat_id[1]);
          getImgLib(cat_id[1]);
          e.preventDefault();
          
      });
    }

    var getcategoryid = function(e) 
    {
     return e.attr('data-catid');
    };
      
    var usetemplatemdl = function()
    {
      $(document).on("click", ".template", function(e) {

        $.ajax({
          url:"careersetting/getdescriptiontemplate",
          type: 'get',
          beforeSend: function(){
                  
          },
          success:function(responseData)
          {
            $('#usetmpapend').html(responseData.content);
            $('#insertTemp').attr('disabled', true);
            $('#mdlusetemplate').modal('show');
            checkboxchecked();
          }
        });
      });
    }

    var insertDescTemplate = function(){

      $(".insertDescTemplate").click(function(){  
            var inputTags;
            var li_content;
            
            inputTags = frmusetemplate.getElementsByTagName('input');
          // console.log(inputTags);
          var checkboxCount = 0;
          var insertcontent='';
          for (var i=0, length = inputTags.length; i<length; i++) {
            if (inputTags[i].type == 'checkbox'  && inputTags[i].checked) {
            var checkval = inputTags[i].value;
            li_content =  $('#content_'+checkval).find('li');
            // console.log(li_content);
            if(li_content.length > 0){
              insertcontent += '<li>'+ $('#content_'+checkval).find('li').html()+'</li>';
            } else {
              insertcontent += $('#content_'+checkval).html() ;	
            }
            checkboxCount++;
          }
        }		
            
        $('#business_description').val(insertcontent);
        $('#business_description_area').html(insertcontent);
        $('#mdlusetemplate').modal('hide');
      });
    
    }

    var themeColor = function(){
      
      $(".themecolor").click(function(){
        
        var select_themeid = $(this).attr('data-themeid');
        $('#selected_theme').val('theme'+select_themeid);

        $('.themecolor').removeClass('selectedcolor');
        $('#theme'+select_themeid).addClass('selectedcolor');
        $('#bottom-theme'+select_themeid).addClass('selectedcolor');
        
      });

      $(".linkcolor").click(function(){
        
        var select_linkcolorid = $(this).attr('data-linkcolor');
        var select_linkid = $(this).attr('data-linkid');

        $('#selected_linkcolor').val(select_linkcolorid);

        $('.linkcolor').removeClass('selectedcolor');
        $('#link_theme'+select_linkid).addClass('selectedcolor');
        
      });

      
      
    }

    var validationurl = function(){
     
        validation = FormValidation.formValidation(
          Form,
          {
              fields: {
                company_fb_url: {
                  validators: {
                    uri: {
                      message: 'The facebook address is not valid (e.g:https://yoursite.domain)',
                    },
                  }
                },
                company_linked_url: {
                  validators: {
                    uri: {
                      message: 'The Linked address is not valid (e.g:https://yoursite.domain)',
                    },
                  }
                },
                company_twitter_url: {
                  validators: {
                    uri: {
                      message: 'The Twitter address is not valid (e.g:https://yoursite.domain)',
                    },
                  }
                },
                company_instagram_url: {
                  validators: {
                    uri: {
                      message: 'The Instagram address is not valid (e.g:https://yoursite.domain)',
                    },
                  }
                },
            },
            plugins: {
              trigger: new FormValidation.plugins.Trigger(),
              // Bootstrap Framework Integration
                        submitButton: new FormValidation.plugins.SubmitButton(),
              bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                            eleInvalidClass: 'is-invalid',
                            eleValidClass: '',
                // defaultMessageContainer: false,
              })
            }
                }
            );
    }

    var clipboardcopy = function () {
      // basic example
      new ClipboardJS('[data-clipboard1=true]').on('success', function(e) {
        e.clearSelection();
        seturlTooltip('Copied!');
        // hideurlTooltip();
        
      });
      new ClipboardJS('[data-clipboard2=true]').on('success', function(e) {
        e.clearSelection();
        setembedTooltip('Embed Code Copied!');
        // hideembedTooltip();
        
      });
    }

    // Public functions
    return {
        // Initialization
        init: function() {
    
            bannerimagecrop();
            imageOpen();
            deletelogoimage();
            imagelibrary();
            usetemplatemdl();
            insertDescTemplate();
            themeColor();
            validationurl();
            clipboardcopy();
        }
        
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
  CareerSetting.init();
    $.validator.messages.required = '';  
    $('#close_button').click(function() {
        $('#kt_modal_new_user_form').trigger("reset");
       //$('#mdluser_add').modal({show:false});
       $('#kt_modal_new_user').modal('hide');

   });

   $('#imageEditor').on('hidden.bs.modal', function () 
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

  function checkboxchecked()
  {
    $('.chktemplate').change(function(){
      var countCheckedCheckboxes = $('.chktemplate').filter(':checked').length;
      $('#insertTemp').attr('disabled', true);
      if(countCheckedCheckboxes>0)
      {
        $('#insertTemp').attr('disabled', false);
      }
    });
  }

  function showlibraryimages(photo_id) {
	
    $('#photo_id').val(photo_id);
    getImgLib($('#cat_id').val());
    $('#postJobImg').modal({backdrop: 'static', keyboard: false});
    $('#postJobImg').modal('show');
    $('#insert_image').attr('disabled',true);
    
  }

  function getImgLib(cat_id)
  {
      $.ajax({
      url:"careersetting/getbannerimagefromlibrary",
      type: 'post',
        // dataType: "json",
        data: { "cat_id": cat_id },
        beforeSend: function(){
                
        },
        success:function(responseData)
        {
          
          
          if(responseData.response=="success")
          {
            $('#imgcategory_'+cat_id).html(responseData.img);
            
            $('input:radio[name=lib_radio]').on('change',function() {
              
              $('.imgbanner').removeAttr('style');
              $('.imgbanner').removeClass('imgsel');
              $(this).closest('.libraryimg_category').find('img').addClass('imgsel');
              $(this).closest('.libraryimg_category').find('img').css({"margin": "0 5px", "border": "1px solid #d6e6f7", "padding": "5px"});
              $('#insert_image').attr('disabled',false);
            });

          }
          
        }
      });
  }

function submitinsertform()
{
    var img_src =  $('.imgsel').attr("src");
    console.log(img_src);
    //$('.fileupload_div').css('display','none');
    var img = new Image();
    img.src = img_src;

    var image_holder='';
    if ($('#photo_id').val() == '1') {
    image_holder = $("#company_photo1_preview2");
  } else if ($('#photo_id').val() == '2') {
    image_holder = $("#company_photo2_preview2");
  } else if ($('#photo_id').val() == '3') {
    image_holder = $("#company_photo3_preview2");
  } else if ($('#photo_id').val() == '4') {
    image_holder = $("#company_photo4_preview2");
  }

  // var uploadedImageURL = URL.createObjectURL(img_src);	
  $('#image').attr('src',img_src);

  if ($('#photo_id').val() == '1') {
    $('#company_photo1_preview1').css('display','');    
    $('#library_filename1').val(img_src);
    $('#chooseFromLibrary1').val('1');
    $('#cimage_baseid').val('');
    
    var library_filename1 = $('#library_filename1').val();
    var photo_name ='companyphoto1';

    $.ajax({
          url:"careersetting/savecompanyphotosfromlib",
          type: 'post',
          // dataType: "json",
          data: { "library_filename1": library_filename1,"photo_name":photo_name },
          beforeSend: function(){
            postimageblockUI.block();
            $('#insert_image').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true); 
            $('.imgcancel-btn').attr('disabled', true); 
          },
          success:function(responseData)
          {
            postimageblockUI.release();
            $('#insert_image').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false); 
            $('.imgcancel-btn').attr('disabled', false); 

            if(responseData.response=="success")
            {
              var append_msg ='<img src="'+responseData.path+'" style="max-width:100%;" width="100%" data-url ="'+responseData.path+'"  id="bannerimageurl" />';
              $('.del_link').html('');
              var link = '<button type="button" class="btn  btn-sm btn-icon   editimage btn-iconcustom-dark" data-toggle="kt-tooltip" title="" data-original-title="Edit Image"><svg class="kt-font-brandideal " fill="currentColor" width="18px" viewBox="0 0 24 24" height="18px" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></button>';
              $('.del_link').remove();
              $('#company_photo1_preview2').html(append_msg);
            
              $('#editorremove').html(link);

            
                $('.editimage').click(function(){
                  bannerimage();
                });
              
              $("#postJobImg" ).modal('hide');
              $('#postJobImg').data('bs.modal',null);
             }

          }
        });

  }

}

function bannerimage(){
  // var cropper;
  $.ajax({
    url:"careersetting/getbannerimage",
    type: 'post',
    beforeSend: function(){
      $('.cropimage').attr('disabled', true);
      $('#applyimage').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true); 
      $('.cancelmodal').attr('disabled', true);
    },
    success:function(responseData)
    {
      
      $('.cropimage').attr('disabled', false);
      $('#applyimage').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false); 
      $('.cancelmodal').attr('disabled', false);
      if (responseData.career_setting_banner_image != '')
      {
        if(responseData.career_image_exist=="yes")
        {
          if(cropper)
          {
            cropper.destroy();
            cropper = null;
          } 
          $('#image').attr('src',responseData.career_setting_banner_image);
          cropper = new Cropper(image, {         
            autoCropArea:1,
                  //aspectRatio: 269 / 73,
                  aspectRatio: 1858 / 600,
                /*  crop: function(e) {
                }*/
              });
        }
        else
        {
          if(cropper) {
            cropper.destroy();
            cropper = null;
          }
          $('#image').attr('src',responseData.career_setting_banner_image); 
          cropper = new Cropper(image, {  
            autoCropArea: 1,
                  //aspectRatio: 269 / 73,
                  aspectRatio: 1858 / 600,            
                });
        }
      $('#imageEditor').modal({backdrop: 'static', keyboard: false});
      $('#imageEditor').modal('show');
      }
    }
  });

    $('#ZoomInBtn').click(function()
    { 
      if (cropper) {
        cropper.zoom(0.1);		  
      }
    });

    $('#ZoomOutBtn').click(function(){ 
      if (cropper) {
        cropper.zoom(-0.1);		  
      }
    });

    $('#Zoomreset').click(function(){ 
      if (cropper) {
        cropper.destroy();
        cropper = null;	  
      }
      $('#image').attr('src',originalImageURL);
      cropper = new Cropper(image, {						 
        autoCropArea:1,
            //aspectRatio: 269 / 73,
            aspectRatio: 1858 / 600,				 
            
          });
    });

}

function uploadimage(file_data)
{

  var frm_data = new FormData();
  console.log(file_data);
  frm_data.append('file[]', file_data);
  frm_data.append('photo_name', 'companyphoto1');
  
  $.ajax({
    url:"careersetting/savecompanyphotos",
    type: 'post',
      // dataType: "json",
     contentType: false,
    processData: false,
    
     
      data: frm_data,
      // data: form_data,
      beforeSend: function(){
        $('.cropimage').attr('disabled', true);
        $('#applyimage').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true); 
        $('.cancelmodal').attr('disabled', true);         
      },
      success:function(responseData)
      {
        editblockUI.release();
        $('.cropimage').attr('disabled', false);
        $('#applyimage').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false); 
        $('.cancelmodal').attr('disabled', false);  
        if(responseData.response=="success")
        {
         
          var append_msg ='<img src="'+responseData.path+'" style="max-width:100%;" width="100%" data-url ="'+responseData.path+'"  id="bannerimageurl" />';
          $('.del_link').html('');
          var link = '<button type="button" class="btn  btn-sm btn-icon   editimage btn-iconcustom-dark" data-toggle="kt-tooltip" title="" data-original-title="Edit Image"><svg class="kt-font-brandideal " fill="currentColor" width="18px" viewBox="0 0 24 24" height="18px" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></button>';
          $('.del_link').remove();
          $('#company_photo1_preview2').html(append_msg);
        
          $('#editorremove').html(link);

            $('.editimage').click(function(){
              bannerimage();
            });

            $("#imageEditor").modal('hide');
            $('#imageEditor').data('bs.modal',null);

          }
          
        }
      });

}

function htmlspecialchars(html)
{
  html = html.replace(/&lt;font.*?&gt;/g, '');
  html = html.replace(/&lt;\/font&gt;/g, '');
  html = html.replace(/&lt;span.*?&gt;/g, '');
  html = html.replace(/&lt;\/span&gt;/g, '');
  html = html.replace(/<font.*?>/g, '');
  html = html.replace(/<\/font>/g, '');
  html = html.replace(/<span.*?>/g, '');
  html = html.replace(/<\/span>/g, '');
  return html;
}
document.getElementById("business_description_area").addEventListener("input", function() {
	$('#business_description').val(this.innerHTML); 
}, false);

function seturlTooltip(message) {
  var options ={
  title:message,
  }
  var exampleEl = document.getElementById('tooltip_url')
  var tooltip = new bootstrap.Tooltip(exampleEl, options)
  tooltip.show();

  setTimeout(function() {
    tooltip.dispose();
},1000);

}
function hideurlTooltip() {
  setTimeout(function() {
      tooltip.hide();
  },1000);
}