"use strict";

// Class Definition
var KTPasswordResetGeneral = function() {
    // Elements
    var form;
    var submitButton;
	var validator;

    var handleForm = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
			form,
			{
				fields: {					
					'email': {
                        validators: {
							notEmpty: {
								message: ' '
							},
                            emailAddress: {
								message: ' '
							},
						}
					} 
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
						eleInvalidClass: 'is-invalid',
                        eleValidClass: ''
                    })
				}
			}
		);		

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

                // Validate form
                validator.validate().then(function (status) {
                
                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click 
                        submitButton.disabled = true;

                        // Simulate ajax request
                    
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: "/admin/employers/emailpresent",
                            method: "POST",
                            data: { "email": $('#email').val()},
                            success:function(data)
                            {
                                if(data.valid){
                                    $.ajax({

                                        url:"/employer/forgotmail",
                                        method:"post",
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: { "email": $('#email').val(),'id':data.id},
                                        success:function(data)
                                        {   
                                            submitButton.removeAttribute('data-kt-indicator');
                                            submitButton.disabled = false;

                                            if(data.code=='1'){

                                                Swal.fire({
                                                    text: "Forgot Password link send to your email!",
                                                    icon: "success",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "Ok, got it!",
                                                    customClass: {
                                                        confirmButton: "btn btn-primary"
                                                    }
                                                }).then(function (result) {
                                                    if (result.isConfirmed) { 
                                                        form.querySelector('[name="email"]').value= ""; 
                                                        window.location.replace('/employer/logout') ;                       
                                                       // form.submit();
                                                    }
                                                });
                                            }else{
                                                Swal.fire({
                                                    text: "Password Reset Link unable to send, Please contact admin",
                                                    icon: "error",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "Ok, got it!",
                                                    customClass: {
                                                        confirmButton: "btn btn-primary"
                                                    }
                                                });
                                            }
                                        }
                                    });
 
                                }else{
                                    // Hide loading indication
                                    submitButton.removeAttribute('data-kt-indicator');
            
                                    // Enable button
                                    submitButton.disabled = false;
                                    validator.updateFieldStatus('email', 'Invalid');
                                    Swal.fire({
                                        text: "Not a Registred Email, Please check it",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }

                            }
                        });

                         						
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

    // Public Functions
    return {
        // public functions
        init: function() {
            form = document.querySelector('#kt_password_reset_form');
            submitButton = document.querySelector('#kt_password_reset_submit');

            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTPasswordResetGeneral.init();
});
