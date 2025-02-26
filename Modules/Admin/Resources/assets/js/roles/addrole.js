"use strict ";

// Class definition
var KTUsersAddRole = function () {


  var validateForm = function() {
    $("#frmroleadd").validate({
        errorClass: 'invalid-feedback',
          // define validation rules
          rules: {
            role_name: {
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
            form.submit(); // submit the form
        }
    });
};


var selectChild = function() {

    $(document).on("click", ".check_status", function(e) {

       if(this.checked) {
        $(this).closest('.accordion-item').find('input:checkbox').prop('checked', true);
    }else{
       $(this).closest('.accordion-item').find('input:checkbox').prop('checked', false);
   }


});
        // $('#kt_accordion_1').accordion({
        //     header: 'h3:not(label)'
        // }); 

        
    }
    var getroleId = function(e) 
    {
       return e.attr('data-roleid');
   }
   

   return {
        // Public functions
        init: function () {
            validateForm();
           // handleSelectAll();
           selectChild();
       }
   };
}();



// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersAddRole.init();
    $.validator.messages.required = ''; 
    $('input.actions').each(function(){
        if ($(this).is(':checked')) {
         var submenu_id  = $(this).attr('data-id');
         var parent_id  = $(this).attr('data-parentid');
         $('#'+submenu_id).find('.submenus').attr('checked', true);
         $('#'+parent_id).find('.accordion-button').find('input[type=checkbox]').attr('checked', true);
     } else {
        //$(this).parent().nextAll('.pkbox:first').css('display', 'block');    
    }
});
    $(".actions").on('change', function() {
        if(this.checked) {
          var submenu_id  = $(this).attr('data-id');
          var parent_id  = $(this).attr('data-parentid');
          $('#'+submenu_id).find('.submenus').attr('checked', true);
          $('#'+parent_id).find('.accordion-button').find('input[type=checkbox]').attr('checked', true);

      }

  }); 
});