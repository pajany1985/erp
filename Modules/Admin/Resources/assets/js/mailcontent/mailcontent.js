"use strict";
// Class definition
var MailcontentDataTable = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;
    
    // Shared variables

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_table_mailcontent").DataTable({
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
               url: "/admin/loadmailcontents",
    
              } ,
            columns: [
                { data: 'mail_title' },
                { data: 'updated_at' },
                { data: 'actions' },
               
               
                
            ],
            columnDefs: [
                {
                    targets: 0,
                    data: 'creator',
                    className: 'd-flex align-items-center',
                    render: function ( data, type, row ) {
    
                             return row.mail_title;
                     
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
        const filterSearch = document.querySelector('[data-kt-mailcontent-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

 
   

    var getcontentId = function(e) 
    {
     return e.attr('data-contentid');
    };

    


    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();            
            
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
    MailcontentDataTable.init();
    

});



  

