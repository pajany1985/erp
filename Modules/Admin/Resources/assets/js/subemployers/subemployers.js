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
        dt = $("#kt_table_employers").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[5, 'desc']],
            // stateSave: true,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: "/admin/loadsubemployers",
                data: function ( d ) {
                    d.package_search = $('#package').val(),
                    d.status =$('#status').val(),
                    d.payment_status = $('#payment_status').val(),
                    d.account_holder = $('#account_holder').val();
                }
            },
            columns: [
            { data: 'id' },
            { data: 'first_name' },
            { data: 'account_holder' },
            // { data: 'payment_status' },
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
                targets: 1,
                data: 'creator',
                className: 'd-flex align-items-center',
                render: function ( data, type, row ) {

                   if(row.company_logo != null && row.company_logo != ''){
                     return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><a href="#"><div class="symbol-label"><img src="/uploads/employers/company_logo/'+ row.company_logo+'" alt="'+row.first_name+'" class="w-100" /></div> </a> </div><div class="d-flex flex-column"><a href="employers/'+row.encrypt_id+'" class="text-gray-800 text-hover-primary mb-1">'+row.first_name+' '+row.last_name+'</a><span>'+row.email+'</span></div>';
                 }else{
                    return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><a href="#"> <div class="symbol-label fs-3 bg-light-danger text-danger">'+(row.first_name).charAt(0)+(row.last_name).charAt(0)+'</div> </a></div><div class="d-flex flex-column"><a href="employers/'+row.encrypt_id+'" class="text-gray-800 text-hover-primary mb-1">'+row.first_name+' '+row.last_name+'</a><span>'+row.email+'</span></div>';
                }

            }
        },
    
        // {
        //     targets:3,
        //     data: 'creator',
        //     render: function (data, type, row) {

        //         if(row.last_login != null){
        //         var date1 = new Date(row.last_login);
        //         var date2 = new Date();
        //         var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        //         var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
        //             if(diffDays ==1 ){
        //                 return '<div class="badge badge-light fw-bolder">Today</div>';
        //             }else if(diffDays ==2 ){
        //                 return '<div class="badge badge-light fw-bolder">Yesterday</div>';
        //             }else{
        //                 return '<div class="badge badge-light fw-bolder">'+diffDays+' days ago</div>';
        //             }
        //         }else{
        //             return '<div class=" text-center">--</div>';
        //         } 
        //        }
        //    },
           {
            targets: 2,
            orderable: false,
            render: function (data, type, row) {
               
                return '<div class="d-flex flex-column"><a href="employers/'+row.encryptmaster_empid+'" class="text-gray-800 text-hover-primary mb-1">'+row.account_holder+'</a><i class="text-muted fs-7">'+row.company_name+'</i></div>';
            }
        },
        {
            targets: 3,
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
            // Add data-filter attribute
            // createdRow: function (row, data, dataIndex) {
            //     $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            // }
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
        const filterSearch = document.querySelector('[data-kt-employer-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterForm = document.querySelector('[data-kt-employer-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-kt-employer-table-filter="filter"]');
        const selectOptions = filterForm.querySelectorAll('select');
        // Filter datatable on submit
        filterButton.addEventListener('click', function () {

          // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
          dt.draw();
      });
    }

    //auto login
        var autologin = function() {     
        $(document).on("click", ".autologin", function(e) {
            var employerId = getemployerId($(this));
           window.open('/employer/appautologin/'+employerId);
        });
    };
    // Delete employer

    var singleDelete = function() {     
        $(document).on("click", ".cfrmdelete", function(e) {
            var employerId = getemployerId($(this));
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

              url:"subemployers/" + employerId,
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

                        dt.draw(); // delete row data from server and re-draw datatable
                        // window.location.replace('employers');

                    }
                });

         } 
     });
      });
    };


    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-employer-table-filter="reset"]');

       // Reset datatable
       resetButton.addEventListener('click', function () {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-employer-table-filter="form"]');
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
        const container = document.querySelector('#kt_table_employers');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-employer-table-select="delete_selected"]');

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

                        url:"subemployers/subemployermassdelete",
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
                                window.location.replace('subemployers');
                            });
                          }
                          else
                          {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'Permission Denied',
                              }).then(function(result) {
                                window.location.replace('subemployers');
                            });
                          }

                    //   dt.draw(); // delete row data from server and re-draw datatable
                    // window.location.replace('employers');

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
            if(text == 'Active')
                var status = '1'; 
            else   
                var status = '0'; 

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

                            url:"subemployers/subemployerupdate",
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
                                        window.location.replace('subemployers');
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
                                        window.location.replace('subemployers');
                                    });
                                }

                                //   dt.draw(); // delete row data from server and re-draw datatable
                                // window.location.replace('employers');
                            }
                        });
                    }else{
                            // window.location.replace('employers');
                        }
                    }); 
            }

        });  

    };

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#kt_table_employers');
        const toolbarBase = document.querySelector('[data-kt-employer-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-employer-table-toolbar="selected"]');
        // const selectedCount = document.querySelector('[data-kt-employer-table-select="selected_count"]');

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
        $("#kt_modal_add_employer_form").validate({
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
                data: { 'id': function() { return $('#employer_id').val(); } }

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
             data: { 'id': function() { return $('#employer_id').val(); } }

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

    var getemployerId = function(e) 
    {
     return e.attr('data-employerid');
    };

    // Add data
    var showAddform = function() {

        $("#btnadd_employer").on("click", function(e) {
          $('#mdlemployer_add .modal-body').load('employers/create',function(){

            $('#mdlemployer_add').modal('show');
            $('input[name="password"]').rules('add',  { required: true });
            //  var avatar1 = new KTImageInput('kt_image_1');
            var imageInputElement = document.querySelector("#kt_image_input_control");
            var imageInput = new KTImageInput(imageInputElement);     
            checkValset();     
        });
          
          
      });

        
    };

    var showEditform = function() {

        $(document).on("click", ".employeredit", function(e) {

            var employer_id = getemployerId($(this));

            // $('#kt_modal_add_employer_form').attr('action','employers/' + employer_id);
            // $('#mdlemployer_add .modal-body').load('employers/' + employer_id + '/edit',function() {
            //     $('#employer_id').val(employer_id);          		
            //     $('#mdlemployer_add').modal('show');
            //     $('input[name="password"]').rules('remove',  'required');
            //     var imageInputElement = document.querySelector("#kt_image_input_control");
            //     var imageInput = new KTImageInput(imageInputElement);     
            //     checkValset(); 
            // });
            document.location.href = 'subemployers/' + employer_id + '/edit';

        });

    };

    var showNotesAddList = function() {

        $(document).on("click", ".employernote", function(e) {

            var employer_id = getemployerId($(this));
            var empid =$(this).attr('data-empid');
            var adminid =$(this).attr('data-adminid');
            $('#employer_id').val(employer_id);
            $('#admin_id').val(adminid);
            $('#mdlcomments').modal({backdrop:'static', keyboard:false});
            $('#commentlist').load("/admin/employer/commentlist/" + employer_id);
            $('#mdlcomments').modal('show');
            

        });

        $('#close_button').click(function() {
            // $('#kt_modal_add_question_form').trigger("reset");
        //    $('#mdlquestion_add').modal({show:false});
           $('#mdlcomments').modal('hide');
        
        });

    };

    var validateFormComments = function() {

        $("#frmnotes").validate({
          // define validation rules
          errorClass: 'invalid-feedback',
          rules: {
            cmnt_area: {
              required: true,
              normalizer: function normalizer(value) {
                return $.trim(value);
              }
            }
          },
          highlight: function highlight(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            var elem = $(element);
    
            if (elem.hasClass("select2-hidden-accessible")) {
              $("#select2-" + elem.attr("id") + "-container").parent().addClass('is-invalid');
            } else {
              elem.addClass('is-invalid');
            }
          },
          unhighlight: function unhighlight(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            var elem = $(element);
    
            if (elem.hasClass("select2-hidden-accessible")) {
              $("#select2-" + elem.attr("id") + "-container").parent().removeClass('is-invalid');
            } else {
              elem.removeClass('is-invalid');
            }
          },
          errorPlacement: function errorPlacement(error, element) {
            var elem = $(element);
    
            if (elem.hasClass("select2-hidden-accessible")) {
              element = $("#select2-" + elem.attr("id") + "-container").parent();
              error.insertAfter(element);
            } else {
              error.insertAfter(element);
            }
          },
          submitHandler: function submitHandler(form) {
            var employer_id = $('#employer_id').val();
            var admin_id = $('#admin_id').val();
            var cmnt_area = $('#cmnt_area').val();
            $.ajax({
              url: "/admin/employer/empnotes",
              type: 'post',
              data: {
                "employer_id": employer_id,
                "admin_id": admin_id,
                "cmnt_area": cmnt_area
              },
              beforeSend: function beforeSend() {
                //overlayblockUI.block();
                $('#commentlist').html('<div class="d-flex justify-content-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div></div>');
              },
              success: function success(data) {
                console.log(data);
                $('#cmnt_area').val('');
               // overlayblockUI.release();
    
                if (data.code == 1) {
                  $('#commentlist').load("/admin/employer/commentlist/" + employer_id);
                } //alert("added successfully");
    
              }
            }); // form.submit(); // submit the form
          }
        });
        
    };

    //  Export  functions
    var exportclick = function(){
        const submitButton = document.querySelector('[data-kt-employers-modal-action="export_submit"]');
        $(document).on("click", ".export_submit", function(e) {

            $('.export_submit').submit();

            $('#kt_modal_export_employers').modal('hide');

        });
    }
    // Export function end

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
            updateStatus();
            autologin();
            showNotesAddList();
            validateFormComments();
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
        $('#kt_modal_add_employer_form').trigger("reset");
       //$('#mdlemployer_add').modal({show:false});
       $('#mdlemployer_add').modal('hide');

   });

    $('#kt_modal_export_employers').on('show.bs.modal', function () { 
        const filterForm = document.querySelector('[data-kt-employers-modal-filter="form"]');
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


