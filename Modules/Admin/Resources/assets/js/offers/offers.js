"use strict";
// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;
    
    // Shared variables

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_table_offers").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[6, 'desc']],
            // stateSave: true,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: "/admin/loadoffers",
                 data: function ( d ) {
                    d.status =$('#status').val(),
                    d.package_id = $('#package_id').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'offername' },
                { data: 'package.name' },
                { data: 'extent_expiry_days' },
                { data: 'price' },
                { data: 'status' },
                { data: 'created_at' },
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
                    targets: 5,
                    orderable: false,
                    render: function (data, type, row) {
                        var status = {
                    
                            1: {'title': 'Active', 'class': ' badge-light-success'},
                            0: {'title': 'In Active', 'class': ' badge-light-danger'},
                            
                        };
                        return '<div class="badge ' + status[row.status].class +  ' fw-bolder">' + status[row.status].title +'</div>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        return row.actions;  
                    },
                },
            ],
          
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
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-kt-user-table-filter="filter"]');
        const selectOptions = filterForm.querySelectorAll('select');
        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            var filterString = '';
            // console.log(selectOptions);
            // Get filter values
            selectOptions.forEach((item, index) => {
                if (item.value && item.value !== '') {
                    if (index !== 0) {
                        filterString += ' ';
                    }

                    // Build filter value options
                    filterString += item.value;
                }
            });

          // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
          dt.search(filterString).draw();
        });
    }

    // Delete user

    var singleDelete = function() {     
        $(document).on("click", ".cfrmdelete", function(e) {
        var userId = getofferId($(this));
            swal
            .fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              type: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                 $.ajax({
        
                      url:"offers/" + userId,
                      type:"post",
                      data: { '_method': "delete" },
                      dataType:"json",
                      success:function(data)
                      {
        
                        swal.fire({
                          title: 'Deleted!',
                          text: 'Your selected records have been deleted!',
                          type: 'success',
                          buttonsStyling: false,
                          confirmButtonText: "OK",
                          confirmButtonClass: "btn  btn-bold btn-primary",
                        })
        
                        dt.search('').draw();; // delete row data from server and re-draw datatable
        
                      }
                    });
        
               } 
             });
        });
    };


    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-user-table-filter="reset"]');

       // Reset datatable
       resetButton.addEventListener('click', function () {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-user-table-filter="form"]');
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
        const container = document.querySelector('#kt_table_offers');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-user-table-select="delete_selected"]');

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

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#kt_table_offers');
        const toolbarBase = document.querySelector('[data-kt-offer-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-offer-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-offer-table-select="selected_count"]');

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
            selectedCount.innerHTML = count;
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
        $("#kt_modal_add_user_form").validate({
            errorClass: 'invalid-feedback',
          // define validation rules
          rules: {
            name: {
                required: true,
               normalizer: function(value) {
                  return $.trim( value );
             }
            },
            email: {
              required: true,
              email: true,
              remote: {
                url: "emailvalidate",
               type: "post",
               data: { 'id': function() { return $('#user_id').val(); } }
               
              },
               normalizer: function(value) {
                  return $.trim( value );
             }
            },
            role_id: {
              required: true
            },
            user_name: {   
              required: true,
               remote: {
                 url: "usernamevalidate",
                type: "post",
                data: { 'id': function() { return $('#user_id').val(); } }
                
               },
              normalizer: function(value) {
                  return $.trim( value );
             }
            },
            password: {
              required: true,
               normalizer: function(value) {
                  return $.trim( value );
             }
            },
            phoneno: {
              required: true,
              phoneUS: true,
               normalizer: function(value) {
                  return $.trim( value );
             }
            }
          },
          messages:{
            user_name: {
              remote: "Username already exists"
          },
          email: {
            remote: "Email already exists"
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

    var getofferId = function(e) 
    {
     return e.attr('data-offerid');
    };

    // Add data
    var showAddform = function() {

        $("#btnadd_user").on("click", function(e) {
          $('#mdluser_add .modal-body').load('users/create',function(){
              
            $('#mdluser_add').modal('show');
             $('input[name="password"]').rules('add',  { required: true });
            //  var avatar1 = new KTImageInput('kt_image_1');
            var imageInputElement = document.querySelector("#kt_image_input_control");
            var imageInput = new KTImageInput(imageInputElement);     
            checkValset();     
          });
          
          
        });
       
        
      };

    var showEditform = function() {

        $(document).on("click", ".offeredit", function(e) {

            var offer_id = getofferId($(this));

           document.location.href = 'offers/' + offer_id + '/edit';
            

        });
    
    };

    //  Export  functions
        var exportclick = function(){
            const submitButton = document.querySelector('[data-kt-offers-modal-action="export_submit"]');
            $(document).on("click", ".export_submit", function(e) {

                $('.export_submit').submit();

                $('#kt_modal_export_offers').modal('hide');

            });
        }
    // Export function end


     var selectedDelete = function() {
        $('#kt_datatable_delete_all').on('click', function() {
        const checkboxes = document.querySelectorAll('[type="checkbox"]');
        var ids = [];
        checkboxes.forEach(c => {
            if (c.checked) {
                if(c.closest('tbody')){
                    ids.push(c.value);
                }
               
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
      
                    url:"offers/offermassdelete",
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
                          confirmButtonClass: "btn  btn-bold btn-primary",
                          }).then(function(result) {
                            window.location.replace('offers');
                        });
                      }
                      else
                      {
                          Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Permission Denied',
                            }).then(function(result) {
                                window.location.replace('offers');
                            });
                      }
      
                    //   dt.draw(); // delete row data from server and re-draw datatable
                 
                    }
                  });
      
                }
              });
        }
           
        });     
    };

    var copyurl = function(){


            // Select element
        var clipboard;
        const target = document.getElementById($(this).attr('id'));
    
        // Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/
        clipboard = new ClipboardJS('.kt_clipboard_3');
        
        clipboard.on('success', function(e) {
            
            const button = e.trigger;
            const currentLabel = e.trigger.innerHTML;

            
            var checkIcon = button.querySelector('.bi.bi-check');
            var svgIcon = button.querySelector('.svg-icon');
        
            // Exit check icon when already showing
            if (checkIcon) {
                return;
            }
        
            // Create check icon
            checkIcon = document.createElement('i');
            checkIcon.classList.add('bi');
            checkIcon.classList.add('bi-check');
            checkIcon.classList.add('fs-2x');
        
            // Append check icon
            button.appendChild(checkIcon);
        
            // Highlight target
            const classes = ['text-success', 'fw-boldest'];
            e.trigger.classList.add(...classes);
        
            // Highlight button
            button.classList.add('btn-success');
            // removeprimary_class
            
            button.classList.remove('btn-active-color-primary');
        
            // Hide copy icon
            svgIcon.classList.add('d-none');
        
            // Revert button label after 3 seconds
            setTimeout(function () {
                // Remove check icon
                svgIcon.classList.remove('d-none');
        
                // Revert icon
                button.removeChild(checkIcon);
        
                // Remove target highlight
                e.trigger.classList.remove(...classes);
        
                // Remove button highlight
                button.classList.remove('btn-success');

                button.classList.add('btn-active-color-primary');
            }, 2000)


            e.clearSelection();
        });
    
    }
    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleFilterDatatable();
            handleResetForm();
            singleDelete();
            showAddform();
            showEditform();
            validateForm();
            exportclick();
            selectedDelete();
            copyurl();
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

   $('#kt_modal_export_users').on('show.bs.modal', function () { 
        const filterForm = document.querySelector('[data-kt-users-modal-filter="form"]');
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

