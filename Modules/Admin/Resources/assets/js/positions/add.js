"use strict";

// Class definition
var KTCreateAccount = function () {
	// Elements
	var modal;	
	var modalEl;

	var stepper;
	var form;
	var formSubmitButton;
	var formContinueButton;
	var addoredit = $('#addoredit').val();
	// Variables
	var stepperObj;
	var validations = [];

	// Private Functions
	var initStepper = function () {
		// Initialize Stepper
		stepperObj = new KTStepper(stepper);

		
		// Stepper change event
		stepperObj.on('kt.stepper.changed', function (stepper) {
            //console.log(stepperObj.getCurrentStepIndex()); // If edit means we can allow all step to submit
		
			if (stepperObj.getCurrentStepIndex() === 3) {
				formSubmitButton.classList.remove('d-none');
				formSubmitButton.classList.add('d-inline-block');
				formContinueButton.classList.add('d-none');
			} else if (stepperObj.getCurrentStepIndex() === 4) {
				formSubmitButton.classList.add('d-none');
				formContinueButton.classList.add('d-none');
			} else {
				formSubmitButton.classList.remove('d-inline-block');
				formSubmitButton.classList.remove('d-none');
				formContinueButton.classList.remove('d-none');
			}
		
		});

		// Validation before going to next page
		stepperObj.on('kt.stepper.next', function (stepper) {
			console.log('stepper.next');
			console.log(stepper.getCurrentStepIndex());
			console.log(stepper.getCurrentStepIndex() - 1);
			// Validate form before change stepper step
			var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step
			
			console.log(validator);
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						stepper.goNext();
						KTUtil.scrollTop();
					} else {
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn btn-primary"
							}
						}).then(function () {
							KTUtil.scrollTop();
						});
					}
				});
			} else {
				stepper.goNext();
				KTUtil.scrollTop();
			}
		});

		// Prev event
		stepperObj.on('kt.stepper.previous', function (stepper) {
			console.log('stepper.previous');

			stepper.goPrevious();
			KTUtil.scrollTop();
		});
	}

	var handleForm = function() {
		formSubmitButton.addEventListener('click', function (e) {
			// Validate form before change stepper step
			var validator0 = validations[0];
			
			var validator = validations[1]; // get validator for last form
			validator0.validate().then(function (status) {
				if(status != 'Valid')
				{
					Swal.fire({
						text: "Sorry, looks like there are some errors detected in Account Info tab, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn btn-primary"
						}
					}).then(function () {
						stepperObj.goTo(1);
						KTUtil.scrollTop();
					});
				}else{

					validator.validate().then(function (status) {
						console.log('validated!');
		
						if (status == 'Valid') {
							// Prevent default button action
							e.preventDefault();
		
							// Disable button to avoid multiple click 
							formSubmitButton.disabled = true;
		
							// Show loading indication
							formSubmitButton.setAttribute('data-kt-indicator', 'on');
		
							// Simulate form submission
							setTimeout(function() {
								form.submit();
								// Hide loading indication
								formSubmitButton.removeAttribute('data-kt-indicator');
		
								// Enable button
								formSubmitButton.disabled = false;
		
								stepperObj.goNext();
								//KTUtil.scrollTop();
							}, 2000);
						} else {
							Swal.fire({
								text: "Sorry, looks like there are some errors detected in Position Setting tab, please try again.",
								icon: "error",
								buttonsStyling: false,
								confirmButtonText: "Ok, got it!",
								customClass: {
									confirmButton: "btn btn-primary"
								}
							}).then(function () {
								stepperObj.goTo(4);
								KTUtil.scrollTop();
							});
						}
					});
				}
			});
	
		});

	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message:' '
							}
						}
					},
                    position_description: {
						validators: {
							notEmpty: {
								message:' '
							}
						}
					},
					employer_id: {
						validators: {
							notEmpty: {
								message:'Please Select the Employer'
							},
							remote: {
								message: 'You have created Maximum of positon, Please Upgrade your plan',
								method: 'POST',
								// data:{'_token':$('input[name="_token"').val()},
								headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
								url: 'checkempallowed'
							},
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: ''
						// defaultMessageContainer: false,
					}),
				}
			}
		));
	
		const questionValidators = {
			validators: {
				notEmpty: {
					message: ' ',
				},
			},
		};
		const maxattemptsValidators = {
			validators: {
				notEmpty: {
					message:' '
				},
				regexp: {
					regexp: /^[0-9\s]+$/i,
					message: 'Please give the valid no. of Attempts',
				},
				remote: {
					message: 'Not Allowed Max of undefined attempts, Please check the package',
					method: 'POST',
					data: function () {
						return {
							max_qstn_attempts: document.querySelector('[name="max_qtn_attempt"]').value,
						};
					},
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url: 'checkmaxattempts'
				},
			}
		};
		const maxminValidators = {
			validators: {
				notEmpty: {
					message:' '
				},
				regexp: {
					regexp: /^[0-9\s]+$/i,
					message: 'Please give the valid no. of Minutes',
				},
				remote: {
					message: 'Not Allowed Max of undefined Minutes, Please check the package',
					method: 'POST',
					data: function () {
						return {
							max_qstn_min: document.querySelector('[name="max_qtn_min"]').value,
						};
					},
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url: 'checkmaxminutes'
				},
			}
		};

		// Step 2
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					'kt_question_repeater[0][question]': questionValidators,
					'kt_question_repeater[0][max_attempts]': maxattemptsValidators,
					'kt_question_repeater[0][max_minutes]': maxminValidators,

				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.fv-row',
                        eleInvalidClass: 'is-invalid',
                        eleValidClass: '',
						// defaultMessageContainer: false,
					})
				}
			}
		));

		
		$('#employer_id').select2().on("change", function (e) {
			validations[0].revalidateField('employer_id');
			var selected = $(this).find('option:selected');
       		var max_question = selected.data('package_maxquestion'); 
			var max_question_attempts = selected.data('maxqstnattemp'); 
			var max_question_min = selected.data('maxqstnmin'); 
			$('#max_qtn_allowed').val(max_question);
			$('#max_qtn_attempt').val(max_question_attempts);
			$('#max_qtn_min').val(max_question_min);
		});

		$("#addmore_question").on("click", function(e) {
			var maxqstn_allowd = $('#max_qtn_allowed').val();
			var repeatlength =$('.repeat_items').length;
			var nextlength = parseInt(repeatlength);
			if( nextlength >= maxqstn_allowd){
				$('#addmore_question').hide();
			}

			$( ".repeat_items" ).each(function( index ) {
				// console.log(index);
				if(index>0){ 
				validations[1].addField('kt_question_repeater[' + index + '][question]', questionValidators)
				.addField('kt_question_repeater[' + index + '][max_attempts]', maxattemptsValidators)
				.addField('kt_question_repeater[' + index + '][max_minutes]', maxminValidators);
				}
			  });
		});

		
		$('#kt_question_repeater').on('click', '[data-repeater-delete]', function(event) {
			var maxqstn_allowd = $('#max_qtn_allowed').val();
			var index_delete =	$(this).closest("[data-repeater-item]").index();
		
			// validations[1].removeField('kt_question_repeater[' + index_delete + '][question]', questionValidators)
			// 		.removeField('kt_question_repeater[' + index_delete + '][max_attempts]', maxattemptsValidators)
			// 		.removeField('kt_question_repeater[' + index_delete + '][max_minutes]', maxminValidators);
					
				
				var repeatlength =$('.repeat_items').length;
				var nextlength = parseInt(repeatlength)-1;

				validations[1].removeField('kt_question_repeater[' + nextlength + '][question]', questionValidators)
				.removeField('kt_question_repeater[' + nextlength + '][max_attempts]', maxattemptsValidators)
				.removeField('kt_question_repeater[' + nextlength + '][max_minutes]', maxminValidators);
				if( maxqstn_allowd > nextlength){
					$('#addmore_question').show();
				}
				
				
			});
	}

	var repeater = function() {
	
		$('#kt_question_repeater').repeater({
			initEmpty: false,
		
		
			show: function () {
				$(this).slideDown();
		
			},
		
			hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
			},
		
			isFirstItemUndeletable: true
		});
		
	   
	  }

	return {
		// Public Functions
		init: function () {
			// Elements
			modalEl = document.querySelector('#kt_modal_create_account');
			if (modalEl) {
				modal = new bootstrap.Modal(modalEl);	
			}					

			stepper = document.querySelector('#kt_create_account_stepper');
			form = stepper.querySelector('#kt_create_position_form');
			formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
			formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');

			
			initStepper();
			repeater();
			initValidation();
			handleForm();
			
			

		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {

	// $.ajaxSetup({
    //     headers: {
    //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    //   });

    KTCreateAccount.init();
    $(".check_status").on("change", function(e) {
        if ($('input[name="status_hidden"]').is(":checked")){
            $('input[name="status"]').val('1');
        }else{
            $('input[name="status"]').val('0');
        }

    });

	
});