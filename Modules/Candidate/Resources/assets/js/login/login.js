"use strict";

// Class definition
var KTSigninGeneral = function() {
    // Elements
    var form;
    var submitButton;
    var validator;

    // Handle form
    var handleForm = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
			form,
			{
				fields: {					
					'email': {
                        validators: {
							notEmpty: {
								message: 'Please fill the email'
							},
                            emailAddress: {
								message: 'The value is not a valid email address'
							},
                           
						}
					},
                    // 'name': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Please fill the Name'
                    //         }
                    //     }
                    // }, 
                    'toc': {
                        validators: {
                            notEmpty: {
                                message: 'Please check the terms and conditions'
                            }
                        }
                    } 
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
				}
			}
		);		

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            // Prevent button default action
            e.preventDefault();

            // Validate form
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click 
                    submitButton.disabled = true;
                    

                    // Simulate ajax request
                    setTimeout(function() {
                      
                        var email = $('#email').val();
                        // var name = $('#name').val();
                        var position_id = $('#position_id').val();
                        var employer_id = $('#employer_id').val();
                        var employer_website = $('#employer_website').val();
                        $('#otpemail_id').val(email);
                            $.ajax({
                                url:"/pid/register",
                                method:"post",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: { "position_id": position_id,'employer_id':employer_id,"email": email,"_token": $('meta[name="csrf-token"]').attr('content')},
                                success:function(data)
                                {
                                    // Hide loading indication
                                    submitButton.removeAttribute('data-kt-indicator');

                                    // Enable button
                                    submitButton.disabled = false;
                                    if(data.success == '1'){
                                        window.location.replace('/pid/thankyouregister/'+data.candid);
                                        // swal.fire({
                                        //     title: 'Mail Sent!',
                                        //     html: "<p class='fs-6'> A link to start your interview has been sent to <span class='text-primary'>"+email+"</span></p> <p> If you don't receive the email be sure to check your spam folder.</p>",
                                        //     type: 'success',
                                        //     icon: "success",
                                        //     showConfirmButton: false,
                                        //     timer: 2500,
                                        //   }).then(function(result) {
                                        //     window.location.replace(employer_website);
                                        // });
                                          
                                    }else if(data.success == '2'){
                                       
                                        swal.fire({
                                            title: 'This Mail Id is Already Registered!',
                                            text: 'We Send the OTP for your Mail, Please verify your otp to login',
                                            type: 'warning',
                                            icon: "warning",
                                            confirmButtonText: "OK",
                                            confirmButtonClass: "btn btn-warning",
                                            
                                          }).then(function(result) {
                                            // location.replace('/otpverify');
                                            $('#sendotp').submit();
                                        });
                                          
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
                            
                        //form.submit(); // submit form

                    }, 2000);   						
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
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

    // Public functions
    return {
        // Initialization
        init: function() {
            form = document.querySelector('#kt_sign_up_form');
            submitButton = document.querySelector('#kt_sign_up_submit');
            
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    KTSigninGeneral.init();
});
