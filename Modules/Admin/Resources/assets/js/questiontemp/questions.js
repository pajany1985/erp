"use strict";
// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;
    var validation;
    var addForm;
    var submitButton;
    var maxminValidators;
    var maxattemptsValidators;
    var  questionValidators;

    // Shared variables

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_table_questionstemp").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            stateSave: true,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: "/admin/loadquestiontemp",
            },
            columns: [
                { data: 'id' },
                { data: 'question' },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data) {
                        return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                    }
                },
              
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        return row.actions;  
                    },
                },
            ],
            // Add data-filter attribute
            createdRow: function (row, data, dataIndex) {
                $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            }
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            initToggleToolbar();
            toggleToolbars();
            // handleDeleteRows();
            KTMenu.createInstances();
        });

        dt.search('').draw();
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-question-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterForm = document.querySelector('[data-kt-question-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-kt-question-table-filter="filter"]');
        const selectOptions = filterForm.querySelectorAll('select');
        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            
          // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
          dt.draw();
        });
    }

    // Delete question

    var singleDelete = function() {     
        $(document).on("click", ".cfrmdelete", function(e) {
        var questionId = getquestionId($(this));
            swal
            .fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              type: "warning",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, delete it!",
              customClass: {
                confirmButton: "btn btn-warning",
                cancelButton: "btn btn-secondary"
            }
            }).then(function(result) {
                if (result.value) {
                 $.ajax({
        
                      url:"questiontemp/" + questionId,
                      type:"post",
                      data: { '_method': "delete" },
                      dataType:"json",
                      success:function(data)
                      {
        
                        swal.fire({
                          title: 'Deleted!',
                          text: 'Your selected records have been deleted!',
                          type: 'success',
                          icon: 'success',
                          buttonsStyling: false,
                          confirmButtonText: "OK",
                          confirmButtonClass: "btn btn-primary",
                        }).then(function(result) { 
                            location.reload();
                        });
        
                        dt.draw(); // delete row data from server and re-draw datatable
                        
                      }
                    });
        
               } 
             });
        });
    };


    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-question-table-filter="reset"]');

       // Reset datatable
       resetButton.addEventListener('click', function () {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-question-table-filter="form"]');
            const selectOptions = filterForm.querySelectorAll('select');

            // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
            selectOptions.forEach(select => {
                $(select).val('').trigger('change');
            });

            // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
            dt.search('').draw();
        });
    }

    // Init toggle toolbar
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector('#kt_table_questionstemp');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-question-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

    }

    var selectedDelete = function() {
        $('#kt_datatable_delete_all').on('click', function() {
        const checkboxes = document.querySelectorAll('[type="checkbox"]');
        var ids = [];
        checkboxes.forEach(c => {
            if (c.checked) {
                if(c.closest('tbody')){
                   
                    ids.push(c.value);
                }
               
                // if(dt.row($(c.closest('tbody tr'))).data()!==undefined){
                //     console.log(dt.row($(c.closest('tbody tr td'))).data().id);
                // }
               
            }
        });
            
        if (ids.length > 0) 
        {
            swal.fire({
                buttonsStyling: false,

                text: "Are you sure to delete " + ids.length + " selected records ?",
                type: "error",

                confirmButtonText: "Yes, delete!",
                confirmButtonClass: "btn btn-sm btn-bold btn-danger",

                showCancelButton: true,
                cancelButtonText: "No, cancel",
                cancelButtonClass: "btn btn-sm btn-bold btn-primary"
            }).then(function(result) {

                if (result.value) {
      
                  $.ajax({
      
                    url:"questiontemp/questionmassdelete",
                    method:"POST",
                    data: { "id": ids },
                    dataType:"json",
                    success:function(data)
                    {
      
                      if(data.success)
                      {
                      swal.fire({
                          title: 'Deleted!',
                          text: 'Your selected records have been deleted!',
                          type: 'success',
                          buttonsStyling: false,
                          confirmButtonText: "OK",
                          confirmButtonClass: "btn btn-bold btn-primary",
                          }).then(function(result) {
                           location.reload();
                        });
                      }
                      else
                      {
                          Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Permission Denied',
                            }).then(function(result) {
                               location.reload();
                            });
                      }
      
                    //   dt.draw(); // delete row data from server and re-draw datatable
                    // window.location.replace('questions');
      
                    }
                  });
      
                }
              });
        }
           
        });		
    };

    var updateStatus = function() {
        $('#kt_datatable_group_action_form .menu-item').on('click', 'a', function(e) {
            var text = $.trim(this.text);
            if(text == 'New')
                var status = '1'; 
            else if(text =='Completed') 
                var status = '3'; 
            else  
                var status = '2'; 
             
            var ids = [];
            const checkboxes = document.querySelectorAll('[type="checkbox"]');
                checkboxes.forEach(c => {
                    if (c.checked) {
                        if(c.closest('tbody')){
                        
                            ids.push(c.value);
                        }
                    
                        // if(dt.row($(c.closest('tbody tr'))).data()!==undefined){
                        //     console.log(dt.row($(c.closest('tbody tr td'))).data().id);
                        // }
                    
                    }
                });

                if (ids.length > 0) 
                {   
                    swal.fire({
                        buttonsStyling: false,
        
                        text: "Are you sure to Update " + ids.length + " selected records ?",
                        type: "error",
        
                        confirmButtonText: "Yes, Update!",
                        confirmButtonClass: "btn btn-sm btn-bold btn-danger",
        
                        showCancelButton: true,
                        cancelButtonText: "No, cancel",
                        cancelButtonClass: "btn btn-sm btn-bold btn-primary"
                    }).then(function(result) {
        
                        if (result.value) { 
                            $.ajax({

                                url:"questions/questionupdate",
                                type: 'post',
                                data: { "id": ids , "status" : status },
                                success:function(data)
                                {
                        
                                if(data.success)
                                {
                                    swal.fire({
                                        title: 'Updated!',
                                        text: 'Your selected records status have been Updated!',
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        confirmButtonClass: "btn btn-sm btn-bold btn-primary",
                                        }).then(function(result) {
                                            window.location.replace('questions');
                                        });
                                        
                                }
                                else
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Permission Denied',
                                        })
                                        .then(function(result) {
                                            window.location.replace('questions');
                                        });
                                }
                        
                                //   dt.draw(); // delete row data from server and re-draw datatable
                                // window.location.replace('questions');
                                }
                            });
                        }else{
                            // window.location.replace('questions');
                        }
                    }); 
                }

        });  

    };

    var updatepaymentStatus = function() {
        $('#kt_datatable_paymentupdatestatus .menu-item').on('click', 'a', function(e) {
            var text = $.trim(this.text);
            if(text == 'Approved')
                var status = '1'; 
            else if(text == 'Pending')  
                var status = '2'; 
            else if(text == 'Expired')  
                var status = '3'; 
            else   
                var status = '4'; 
            var ids = [];
            const checkboxes = document.querySelectorAll('[type="checkbox"]');
                checkboxes.forEach(c => {
                    if (c.checked) {
                        if(c.closest('tbody')){
                        
                            ids.push(c.value);
                        }
                    
                        // if(dt.row($(c.closest('tbody tr'))).data()!==undefined){
                        //     console.log(dt.row($(c.closest('tbody tr td'))).data().id);
                        // }
                    
                    }
                });

                if (ids.length > 0) 
                {   
                    swal.fire({
                        buttonsStyling: false,
        
                        text: "Are you sure to Update the Payment status for" + ids.length + " selected records ?",
                        type: "error",
        
                        confirmButtonText: "Yes, Update!",
                        confirmButtonClass: "btn btn-sm btn-bold btn-danger",
        
                        showCancelButton: true,
                        cancelButtonText: "No, cancel",
                        cancelButtonClass: "btn btn-sm btn-bold btn-primary"
                    }).then(function(result) {
        
                        if (result.value) { 
                            $.ajax({

                                url:"questions/questionupdatepayment",
                                type: 'post',
                                data: { "id": ids , "status" : status },
                                success:function(data)
                                {
                        
                                if(data.success)
                                {
                                    swal.fire({
                                        title: 'Updated!',
                                        text: 'Your selected records Payment status have been Updated!',
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        confirmButtonClass: "btn btn-sm btn-bold btn-primary",
                                        }).then(function(result) {
                                            window.location.replace('questions');
                                        });
                                        
                                }
                                else
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Permission Denied',
                                        })
                                        .then(function(result) {
                                            window.location.replace('questions');
                                        });
                                }
                        
                                //   dt.draw(); // delete row data from server and re-draw datatable
                                // window.location.replace('questions');
                                }
                            });
                        }else{
                            // window.location.replace('questions');
                        }
                    }); 
                }

        });  

    };

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#kt_table_questionstemp');
        const toolbarBase = document.querySelector('[data-kt-question-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-question-table-toolbar="selected"]');
        // const selectedCount = document.querySelector('[data-kt-question-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements
        const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            // selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    jQuery.validator.addMethod("phoneUS", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && phone_number.match(/^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
    }, "Please specify a valid phone number");  

    var validateForm = function() {

        $("#kt_modal_addedit_question_form").validate({
            errorClass: 'invalid-feedback',
          // define validation rules
          rules: {
                question: {
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
            form.submit();
          }
        });

        questionValidators = {
			validators: {
				notEmpty: {
					message: ' ',
				},
			},
		};
		

        validation = FormValidation.formValidation(
            addForm,
            {
                fields: {
					'kt_question_repeater[0][question]': questionValidators,

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
        
      };

    var getquestionId = function(e) 
    {
     return e.attr('data-questionid');
    };

    // Add data
    var showAddform = function() {

        $("#btnadd_questiontemp").on("click", function(e) {

            $('#mdlquestion_add').modal({backdrop:'static', keyboard:false});
            $('#mdlquestion_add').modal('show');
           
                selectDisableEnableOptions();
                var allowed = 5;
                $("#addmore_question").on("click", function(e) {
                    
                    var repeatlength =$('.repeat_items').length;
                    var nextlength = parseInt(repeatlength);
                    if( nextlength >= allowed){
                        $('#addmore_question').hide();
                    }



                    $( ".repeat_items" ).each(function( index ) {
                        //console.log(index);
                        if(index>0){ 
                        validation.addField('kt_question_repeater[' + index + '][question]', questionValidators);
                        }
                      });
                });

                $('#kt_question_repeater').on('click', '[data-repeater-delete]', function(event) {
                    
                        var index_delete =	$(this).closest("[data-repeater-item]").index(); 
                        //validation.removeField('kt_question_repeater[' + index_delete + '][question]', questionValidators);
           
                        var repeatlength =$('.repeat_items').length;
                        var nextlength = parseInt(repeatlength)-1;
                        /*if total length is 5 means 0 to 4 is the index value , 
                         every time we can delete the repeater field it automaticaly reasign the index value oderly, so we can remove only for last index */
                        validation.removeField('kt_question_repeater[' + nextlength + '][question]', questionValidators);

                        if( allowed > nextlength){
                            $('#addmore_question').show();
                        }
                        
                        
                    });
          
        });
       
        
      };

    var showEditform = function() {

        $(document).on("click", ".questionedit", function(e) {

            var question_id = getquestionId($(this));
           
            $('#kt_modal_addedit_question_form').attr('action','questiontemp/' + question_id);
            $('#mdlquestion_addedit .modal-body').load('questiontemp/' + question_id + '/edit',function() {
                $('#question_id').val(question_id);          		
                $('#mdlquestion_addedit').modal('show');
              
                selectDisableEnableOptions();

            });
            

        });
    
    };
    
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

      var handleForm = function() {
		submitButton.addEventListener('click', function (e) {
			// Validate form before change stepper step
			
			
			var validator = validation; // get validator for last form
					validator.validate().then(function (status) {
						console.log('validated!');
		
						if (status == 'Valid') {
							// Prevent default button action
							e.preventDefault();
		
							// Disable button to avoid multiple click 
							submitButton.disabled = true;
		
							// Show loading indication
							submitButton.setAttribute('data-kt-indicator', 'on');
		
							// Simulate form submission
							setTimeout(function() {
								addForm.submit();
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
							}).then(function () {
						        KTUtil.scrollTop();
							});
						}
					});
				
		});

	}
    // Public methods
    return {
        init: function () {
            addForm = document.querySelector('#kt_modal_add_question_form');
            submitButton = addForm.querySelector('[data-kt-questions-modal-action="submit"]');
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleFilterDatatable();
            handleResetForm();
            singleDelete();
            showAddform();
            showEditform();
            repeater();
            validateForm();
            selectedDelete();
            handleForm();
           
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
    KTDatatablesServerSide.init();
    $.validator.messages.required = '';  


    $('#close_button').click(function() {
        $('#kt_modal_addedit_question_form').trigger("reset");
       //$('#mdlquestion_add').modal({show:false});
       $('#mdlquestion_addedit').modal('hide');
 
   });

   $('#add_close_button').click(function() {
    $('#kt_modal_add_question_form').trigger("reset");
   //$('#mdlquestion_add').modal({show:false});
   $('#mdlquestion_add').modal('hide');

});

   $('#kt_modal_export_questions').on('show.bs.modal', function () { 
        const filterForm = document.querySelector('[data-kt-questions-modal-filter="form"]');
        const selectOptions = filterForm.querySelectorAll('select');

        selectOptions.forEach(select => {
            $(select).val('All').trigger('change');
        });
    }); 

});


function checkValset(){
    
    $(".check_status").on("change", function(e) {
        if ($('input[name="status_hidden"]').is(":checked")){
            $('input[name="status"]').val('1');
        }else{
            $('input[name="status"]').val('0');
        }

    });

   }
  
   function selectDisableEnableOptions(){
    $('#employer_id').on('select2:select', function (e) {
        $("#position_id").prop("disabled", false);
      });

      $('#employer_id').on('select2:unselect', function (e) {
        $("#position_id").prop("disabled", true);
      });


      $('.setassessment').click(function() {

        var value =  $(this).attr('data-assessment');
        $('#saveandsendlink').val(value);

      });
   
   }

