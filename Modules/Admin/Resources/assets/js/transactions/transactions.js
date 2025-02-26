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
        dt = $("#kt_table_trans").DataTable({
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
               url: "/admin/loadtransactions",
               data: function ( d ) {
                   d.package_search = $('#package').val(),
                   d.status =$('#status').val()
               }
              } ,
            columns: [
                { data: 'employer.first_name' },
                { data: 'package.name' },
                { data: 'amount' },
                { data: 'transaction_id' },
                { data: 'status' },
                { data: 'paid_date' },
               
                
            ],
            columnDefs: [
                {
                    targets: 0,
                    data: 'creator',
                    className: 'd-flex align-items-center',
                    render: function ( data, type, row ) {
                        if (row.employer && row.employer.first_name) {
                                return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><a href="/admin/employers/'+row.encrypt_id+'"> <div class="symbol-label fs-3 bg-light-danger text-danger">'+(row.employer.first_name).charAt(0)+(row.employer.last_name).charAt(0)+'</div> </a></div><div class="d-flex flex-column"><a href="/admin/employers/'+row.encrypt_id+'" class="text-gray-800 text-hover-primary mb-1">'+row.employer.first_name+' '+row.employer.last_name+'</a><span>'+row.employer.email+'</span></div>';
                            }
                            return "<span>N/A</span>" ;
                       /*if(row.employer.company_logo != null && row.employer.company_logo != ''){
                         return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><a href="/admin/employers/'+row.encrypt_id+'"><div class="symbol-label"><img src="/uploads/employers/company_logo/'+ row.employer.company_logo+'" alt="'+row.employer.first_name+'" class="w-100" /></div> </a> </div><div class="d-flex flex-column"><a href="/admin/employers/'+row.encrypt_id+'" class="text-gray-800 text-hover-primary mb-1">'+row.employer.first_name+' '+row.employer.last_name+'</a><span>'+row.employer.email+'</span></div>';
                     }else{
                        return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3"><a href="/admin/employers/'+row.encrypt_id+'"> <div class="symbol-label fs-3 bg-light-danger text-danger">'+(row.employer.first_name).charAt(0)+(row.employer.last_name).charAt(0)+'</div> </a></div><div class="d-flex flex-column"><a href="/admin/employers/'+row.encrypt_id+'" class="text-gray-800 text-hover-primary mb-1">'+row.employer.first_name+' '+row.employer.last_name+'</a><span>'+row.employer.email+'</span></div>';
                    }*/
    
                }
                },
                {
                    targets: 4,
                    orderable: false,
                    render: function (data, type, row) {
                        var status = {
        
                            1: {'title': 'Success', 'class': ' badge-light-success'},
                            0: {'title': 'Failure', 'class': ' badge-light-danger'},
        
                        };
                        return '<div class="badge ' + status[row.status].class +  ' fw-bolder">' + status[row.status].title +'</div>';
                    }
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
            
           
            // handleDeleteRows();
            KTMenu.createInstances();
        });

        //dt.search('').draw();
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-tran-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterForm = document.querySelector('[data-kt-tran-table-filter="form"]');
        const filterButton = filterForm.querySelector('[data-kt-tran-table-filter="filter"]');
        const selectOptions = filterForm.querySelectorAll('select');
        // Filter datatable on submit
        filterButton.addEventListener('click', function () { 
          // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
          dt.draw();
        });
    }

    // Delete tran

   


    // Reset Filter
    var handleResetForm = () => {
        // Select reset button
        const resetButton = document.querySelector('[data-kt-tran-table-filter="reset"]');

       // Reset datatable
       resetButton.addEventListener('click', function () {
            // Select filter options
            const filterForm = document.querySelector('[data-kt-tran-table-filter="form"]');
            const selectOptions = filterForm.querySelectorAll('select');

            // Reset select2 values -- more info: https://select2.org/programmatic-control/add-select-clear-items
            selectOptions.forEach(select => {
                $(select).val('').trigger('change');
            });

            // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
            dt.search('').draw();
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
      
                    url:"trans/tranmassdelete",
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
                            window.location.replace('trans');
                        });
                      }
                      else
                      {
                          Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Permission Denied',
                            }).then(function(result) {
                                window.location.replace('trans');
                            });
                      }
      
                    //   dt.draw(); // delete row data from server and re-draw datatable
                    // window.location.replace('trans');
      
                    }
                  });
      
                }
              });
        }
           
        });		
    };

    
    

   

   

    var gettranId = function(e) 
    {
     return e.attr('data-tranid');
    };

    

    

    //  Export  functions
        var exportclick = function(){
            const submitButton = document.querySelector('[data-kt-trans-modal-action="export_submit"]');
            $(document).on("click", ".export_submit", function(e) {

                $('.export_submit').submit();

                $('#kt_modal_export_trans').modal('hide');

            });
        }
    // Export function end

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
           
            handleFilterDatatable();
            handleResetForm();
            
            exportclick();
            
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
    

});



  

