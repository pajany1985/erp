"use strict";
// Class definition
var CandidateFunction = function () {

    jQuery.validator.addMethod("phoneUS", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");  

    var toContinue = function(){
       
        if($('#first_name').val()!=''){
            savecandidatelog('cms_content_section');
        }else{
            savecandidatelog('cms_form_section');
        }

        Inputmask({
            "mask" : "(999) 999-9999",
        }).mask("#phone_no");

        $("#cmsname_form").validate({
            errorClass: 'invalid-feedback',
            ignore: ".ignore",
            errorElement: "strong",
          // define validation rules
          rules: {
            first_name: {
              required: true,
            },
            last_name: {
                required: true,
              },
            phone_no: {
            required: true,
            phoneUS: true,
            normalizer: function(value) {
                return $.trim( value );
            }
            },
            
          },
         
	    highlight: function (element, errorClass, validClass) {
            $( element ).addClass('is-invalid');

            var elem = $(element);
            if (elem.hasClass("select2-hidden-accessible")) {
                $("#select2-" + elem.attr("id") + "-container").parent().addClass('is-invalid'); 
            } else {
                elem.addClass('is-invalid');
            }

		},
        unhighlight: function (element, errorClass, validClass) {
            
            $( element ).removeClass('is-invalid');
            var elem = $(element);
            if (elem.hasClass("select2-hidden-accessible")) {
                $("#select2-" + elem.attr("id") + "-container").parent().removeClass('is-invalid');
            } else {
                elem.removeClass('is-invalid');
            }
            
            },
        errorPlacement: function(error, element) {
            var elem = $(element);
            if (elem.hasClass("select2-hidden-accessible")) {
                element = $("#select2-" + elem.attr("id") + "-container").parent(); 
                error.insertAfter(element);
            } else {
                error.insertAfter(element);
            }
            },
            submitHandler: function(form) {
                
                // var encptcandid_id = $(this).attr('data-encptcandid');
                var encptcandid_id = $('#encptcandid').val();
                var first_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var phone_no = $('#phone_no').val();
                // $(this).setAttribute('data-kt-indicator', 'on');
                // $(this).prop("disabled", true);
                $('.tocontinuename').attr('data-kt-indicator', 'on');
                $('.tocontinuename').attr('disabled', 'true');
                
                  $.ajax({
                    url:"/tocontinuename",
                    method:"post",
                    data: { "phone_no": phone_no,"caniddateid": encptcandid_id,"first_name": first_name,"last_name": last_name},
                    success:function(data)
                    {
                        if(data.success == '1'){
                            savecandidatelog('cms_form_completed');
                            $('.tocontinuename').removeAttr('data-kt-indicator');
                            window.location.reload();
                        }else{
    
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went worng, Please try agin',
                                customClass: {
                                    confirmButton: "btn btn-danger",
                                }
                              })
                        }
                    }
                });
            }
         
        });

        $(document).on("click", ".tocontinue", function(e) {

            savecandidatelog('cms_content_completed');
            var encptcandid_id = $(this).attr('data-encptcandid');

            // $(this).setAttribute('data-kt-indicator', 'on');
            // $(this).prop("disabled", true);
            $('.tocontinue').attr('data-kt-indicator', 'on');
            $('.tocontinue').attr('disabled', 'true');

              $.ajax({
                url:"/tocontinue",
                method:"post",
                data: { "caniddateid": encptcandid_id},
                success:function(data)
                {
                    if(data.success == '1'){
                        $('.tocontinue').removeAttr('data-kt-indicator');
                        window.location.replace('overview');
                    }else{

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went worng, Please try agin',
                            customClass: {
                                confirmButton: "btn btn-danger",
                            }
                          })
                    }
                }
            });

        });
    }

    var setQuestionIndex = function(){
        $(document).on("click", ".qstndetail", function(e) {
           
            var qstn_index =  $(this).attr('data-indexid');
            var qstn_url =  $(this).attr('data-url');
            //ajax call 
            $.ajax({
                url: "setqstnsessionindex",
                method:"post",
                data: { qstn_index: qstn_index }
            }).then(function(response3) {
                window.location.replace(qstn_url);
                
            });  
            
        });

        $(document).on("click", ".videodiv", function(e) {
          
            var datakeyval =  $(this).attr('data-keyval');
            $('#upload_videotag'+datakeyval).trigger('play');
            $('#videoplay'+datakeyval).css('display','none');
            $('#custom-opacity'+datakeyval).css('opacity', '');
            $('#videopause'+datakeyval).css('display','block');

            
            
            var videoended = document.getElementById("upload_videotag"+datakeyval);
            videoended.onended = function() {
                $('#videoplay'+datakeyval).css('display','block');
                $('#custom-opacity'+datakeyval).css('opacity', '1');
                $('#videopause'+datakeyval).css('display','none');
            };
            
        });

        $(document).on("click", ".videodivpause", function(e) {
          
            var datakeyval =  $(this).attr('data-keyval');
            $('#upload_videotag'+datakeyval).trigger('pause');
            $('#videopause'+datakeyval).css('display','none');
            $('#custom-opacity'+datakeyval).css('opacity', '1');
            $('#videoplay'+datakeyval).css('display','block');
            
        });

        
        
    }

    var completeAllQuestion = function(){

        $(document).on("click", ".allqstn_submit", function(e) {

            // $(this).setAttribute('data-kt-indicator', 'on');
            // $(this).prop("disabled", true);
            var candidate_id = $('#candid_id').val();

            $('.allqstn_submit').attr('data-kt-indicator', 'on');
            $('.allqstn_submit').attr('disabled', 'true');
            
              $.ajax({
                url:"/updatecompleteqstn",
                method:"post",
                data: { "candidate_id": candidate_id},
                success:function(data)
                {
                    if(data.success == '1'){
                        window.location.replace('thankyou');
                    }else{

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went worng, Please try agin',
                            customClass: {
                                confirmButton: "btn btn-danger",
                            }
                          })
                    }
                }
            });

        });
    }

    // Public methods
    return {
        init: function () {
            toContinue();
            setQuestionIndex();
            completeAllQuestion();
        }
    }
}();


// On document ready
KTUtil.onDOMContentLoaded(function () {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
    CandidateFunction.init();
    $.validator.messages.required = '';  
    $('#close_button').click(function() {
        $('#kt_modal_add_user_form').trigger("reset");
       //$('#mdluser_add').modal({show:false});
       $('#mdluser_add').modal('hide');

   });

   
   $('#kt_modal_completeall').modal({backdrop: 'static', keyboard: false})  
});


    function savecandidatelog(action){
        var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        var screenresolution = width+' x '+height;
        var currentURL = window.location.href;
        var clientIP ='';
        var candidate_id = $('#candidate_id').val();
        fetch('https://api.ipify.org/?format=json')
        .then(response => response.json())
        .then(data => {
          clientIP = data.ip;
          console.log("Client IP Address: " + clientIP);
            $.ajax({
                url:"/savecandidatelog",
                method:"post",
                data: { "screenresolution": screenresolution,action,currentURL,candidate_id,clientIP},
                success:function(data)
                {
                    if(data.success == '1'){
                        console.log('saved');
                    }else{
                        console.log('not saved');
                    }
                }
            });
        });
          
    }


