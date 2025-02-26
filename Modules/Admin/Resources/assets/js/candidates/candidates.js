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
        dt = $("#kt_table_candidates").DataTable({
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
                url: "/admin/loadcandidates",
                data: function ( d ) {
                    d.employer_search = $('#employer').val(),
                    d.status =$('#status').val()
                }
            },
            columns: [
                { data: 'id' },
                { data: 'first_name' },
                { data: 'email' },
                { data: 'employer.first_name' },
                { data: 'position.name' },
                { data: 'candidate_storage' },
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
                    // data: 'creator',
                    orderable: false,
                    render: function ( data, type, row ) {
                        var lname='';
                        if(row.first_name!=null){
                            if(row.last_name!=null){
                                lname = row.last_name;
                            }
                            return row.first_name +' '+ lname;
                        }
                        return "<span>N/A</span>" ;
                  }
                },
                {
                    targets: 3,
                    // data: 'creator',
                    orderable: false,
                    render: function ( data, type, row ) {
                        if(row.employer!=null){
                            return row.employer.first_name +' '+ row.employer.last_name;  
                        }else
                        {
                            return ' ';
                        }
                  }
                },
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (data, type, row) {
                      
                        return row.candidate_storage;
                    }
                },
                {
                    targets: 6,
                    orderable: false,
                    render: function (data, type, row) {
                        var status = {
                    
                            1: {'title': 'New', 'class': ' badge-light-primary'},
                            2: {'title': 'In Progress', 'class': ' badge-light-warning'},
                            3: {'title': 'Completed', 'class': ' badge-light-success'},
                            4: {'title': 'Hired', 'class': ' badge-light-warning'},
                            
                        };
                        return '<div class="badge ' + status[row.status].class +  ' fw-bolder">' + status[row.status].title +'</div>';
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
        const filterSearch = document.querySelector('[data-kt-candidate-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterForm = document.querySelector('[data-kt-candidate-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-kt-candidate-table-filter="filter"]');
        const selectOptions = filterForm.querySelectorAll('select');
        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            
          // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
          dt.draw();
        });
    }

    // Delete candidate

    var singleDelete = function() {     
        $(document).on("click", ".cfrmdelete", function(e) {
        var candidateId = getcandidateId($(this));
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
        
                      url:"candidates/" + candidateId,
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
                        })
        
                        dt.draw(); // delete row data from server and re-draw datatable
                        // window.location.replace('candidates');
        
                      }
                    });
        
               } 
             });
        });
    };


    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-candidate-table-filter="reset"]');

       // Reset datatable
       resetButton.addEventListener('click', function () {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-candidate-table-filter="form"]');
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
        const container = document.querySelector('#kt_table_candidates');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-candidate-table-select="delete_selected"]');

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
      
                    url:"candidates/candidatemassdelete",
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
                            window.location.replace('candidates');
                        });
                      }
                      else
                      {
                          Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Permission Denied',
                            }).then(function(result) {
                                window.location.replace('candidates');
                            });
                      }
      
                    //   dt.draw(); // delete row data from server and re-draw datatable
                    // window.location.replace('candidates');
      
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

                                url:"candidates/candidateupdate",
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
                                            window.location.replace('candidates');
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
                                            window.location.replace('candidates');
                                        });
                                }
                        
                                //   dt.draw(); // delete row data from server and re-draw datatable
                                // window.location.replace('candidates');
                                }
                            });
                        }else{
                            // window.location.replace('candidates');
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

                                url:"candidates/candidateupdatepayment",
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
                                            window.location.replace('candidates');
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
                                            window.location.replace('candidates');
                                        });
                                }
                        
                                //   dt.draw(); // delete row data from server and re-draw datatable
                                // window.location.replace('candidates');
                                }
                            });
                        }else{
                            // window.location.replace('candidates');
                        }
                    }); 
                }

        });  

    };

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#kt_table_candidates');
        const toolbarBase = document.querySelector('[data-kt-candidate-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-candidate-table-toolbar="selected"]');
        // const selectedCount = document.querySelector('[data-kt-candidate-table-select="selected_count"]');

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
        $("#kt_modal_add_candidate_form").validate({
            errorClass: 'invalid-feedback',
          // define validation rules
          rules: {
            email: {
              required: true,
              email: true,
              remote: {
                url: "candidates/emailvalidate",
               type: "post",
               data: { 'id': function() { return $('#candidate_id').val(); },'position_id': function() { return $('#position_id').val(); } }
               
              },
               normalizer: function(value) {
                  return $.trim( value );
             }
            },
            employer_id: {
              required: true,
            },
            first_name: {
                required: true,
              },
            last_name: {
            required: true,
            },
            position_id: {   
              required: true,
               remote: {
                 url: "candidates/positionvalidate",
                type: "post",
                data: { 'id': function() { return $('#candidate_id').val(); },'email': function() { return $('#email').val(); } }
                
               },
              normalizer: function(value) {
                  return $.trim( value );
             }
            },
            
          },
          messages:{
            position_id: {
              remote: "Position already exists in the Same Email"
          },
          email: {
            remote: "Email already exists in the Same Position"
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
            var which_button = $('#saveandsendlink').val();
            if(which_button=='1')
            {
                $('#send_link').attr('data-kt-indicator', 'on');
                $('#send_link').attr('disabled', 'true');
                $('#send').attr('disabled', 'true');
            }
            else
            {
                $('#send').attr('data-kt-indicator', 'on');
                $('#send').attr('disabled', 'true');
                $('#send_link').attr('disabled', 'true');
            }
            form.submit();
            setTimeout(function() {
                if(which_button=='1')
                {
                    $('#send_link').removeAttr('data-kt-indicator');
                    $('#send_link').removeAttr('disabled');
                    $('#send').removeAttr('disabled');
                }
                else
                {
                    $('#send').removeAttr('data-kt-indicator');
                    $('#send').removeAttr('disabled');
                    $('#send_link').removeAttr('disabled');
                }
                
            }, 2000);
          }
        });
      };

    var getcandidateId = function(e) 
    {
     return e.attr('data-candidateid');
    };

    // Add data
    var showAddform = function() {

        $("#btnadd_candidate").on("click", function(e) {
          $('#mdlcandidate_add .modal-body').load('candidates/create',function(){
            $('#mdlcandidate_add').modal({backdrop:'static', keyboard:false});
            $('#mdlcandidate_add').modal('show');
            $('#send_link').show();
                $('#employer_id').select2(
                    {
                        dropdownParent: $('#mdlcandidate_add')
                    }
                ).on("change", function (e) {
                    $.ajax({

                        url:"candidates/employerposition",
                        method:"post",
                        data: { "employer_id": this.value},
                        success:function(data)
                        {
                            if(data.success == '1'){
                                $('#position_id').html(data.position_options);
                            }
                        }
                    });
                    $(this).valid()
                });

                $('#position_id').select2(
                    {
                        dropdownParent: $('#mdlcandidate_add')
                    }
                ).on("change", function (e) {
                    $(this).valid()
                });
                
                selectDisableEnableOptions();
          });
          
          
        });
       
        
      };

    var showEditform = function() {

        $(document).on("click", ".candidateedit", function(e) {

            var candidate_id = getcandidateId($(this));
           
            $('#kt_modal_add_candidate_form').attr('action','candidates/' + candidate_id);
            $('#mdlcandidate_add .modal-body').load('candidates/' + candidate_id + '/edit',function() {
                $('#candidate_id').val(candidate_id);          		
                $('#mdlcandidate_add').modal('show');
                $('#send_link').hide();

                var empid =$('#editempid').val();
                var positionid =$('#editposition_id').val();
                $("#employer_id").select2().val(empid).trigger("change");
                $("#position_id").select2().val(positionid).trigger("change");

                $('#employer_id').select2(
                    {
                        dropdownParent: $('#mdlcandidate_add')
                    }
                ).on("change", function (e) {
                    $.ajax({

                        url:"candidates/employerposition",
                        method:"post",
                        data: { "employer_id": this.value},
                        success:function(data)
                        {
                            if(data.success == '1'){
                                $('#position_id').html(data.position_options);
                            }
                        }
                    });
                    $(this).valid()
                });

                $('#position_id').select2(
                    {
                        dropdownParent: $('#mdlcandidate_add')
                    }
                ).on("change", function (e) {
                    $(this).valid()
                });

                $("#position_id").prop("disabled", false);
                selectDisableEnableOptions();

            });
            

        });
    
    };
    
    var sendinvite = function(){

        $(document).on("click", ".sendinvite", function(e) {

           var candidate_id = getcandidateId($(this));
           var assessment =  $(this).attr('data-assessment');
           var text_message = "You want to sent the Invite Mail";
           if(assessment==1){
            text_message = "You want to sent again the Invite Mail";
           }
           swal
           .fire({
             title: "Are you sure?",
             text: text_message,
             type: "warning",
             icon: "info",
             showCancelButton: true,
             confirmButtonText: "Yes, Send it!",
             customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-secondary"
            }
           }).then(function(result) {
               if (result.value) {
                $.ajax({
                     url:"candidates/sendinvite",
                     type:"post",
                     data: { "candidate_id": candidate_id },
                     dataType:"json",
                     success:function(data)
                     {
                        if(data.code==1)
                        {
                            swal.fire({
                                title: 'Mail Sended!',
                                text: 'Invite Mail Sended to the your selected Candidate!',
                                type: 'success',
                                icon: "success",
                                confirmButtonText: "OK",
                                confirmButtonClass: "btn btn-primary",
                                
                              })
                        }
                        else
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Mail Not send Please check the credentails',
                                customClass: {
                                    confirmButton: "btn btn-danger",
                                }
                              })
                        }
       
                       dt.draw(); 
       
                     }
                   });
       
              } 
            });

        });
    }
    //  Export  functions
        var exportclick = function(){
            const submitButton = document.querySelector('[data-kt-candidates-modal-action="export_submit"]');
            $(document).on("click", ".export_submit", function(e) {

                $('.export_submit').submit();

                $('#kt_modal_export_candidates').modal('hide');

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
            updatepaymentStatus();
            sendinvite();
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
        $('#kt_modal_add_candidate_form').trigger("reset");
       //$('#mdlcandidate_add').modal({show:false});
       $('#mdlcandidate_add').modal('hide');
 
   });

   $('#kt_modal_export_candidates').on('show.bs.modal', function () { 
        const filterForm = document.querySelector('[data-kt-candidates-modal-filter="form"]');
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

