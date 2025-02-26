"use strict";
jQuery(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
	Coloris({
			  el: '.coloris',
			  swatches: [
				//'#000000',
				'#264653',
				'#2a9d8f',
				'#e9c46a',
				'#f4a261',
				'#e76f51',
				'#d62828',
				'#023e8a',
				'#0077b6',
				'#0096c7',
				'#00b4d8',
				'#48cae4'
			  ],
			 //  format: 'rgb',
			   format: 'hex',
			   defaultColor: '#000000',
			   //inline: true,
			   // Show an optional clear button
			  clearButton: true,

			  // Set the label of the clear button
			  clearLabel: 'Clear',
			});
			Coloris.setInstance('.instance2', { theme: 'polaroid' });

			$(".showdownloadQR").click(function(){  
				$('#download_QRmdl').modal({backdrop: 'static', keyboard: false});
				$('#download_QRmdl').modal('show'); 
			});

			$(".imgcancel-btn").click(function(){  
				$('#download_QRmdl').modal('hide');
			});

			$(".downloadQR").click(function(){  
				downloadQR();
			});
			
});


function downloadQR(){

	var color = $('#QR_color').val();
	if($('#QR_color').val()==''){
		color = '#000000';
	}
	$.ajax({
	   url:"/employer/careersetting/downloadqr",
	   type: 'post',
	   data: {
			"size": $('input[name="QR_size_radio"]:checked').val(),
			//'carrer_url': $('#landingPageUrl3').val(),
			'QR_color': color,
			'filename': $('#filename').val(),
			},
	   beforeSend: function(){
		$('#insert_image').attr('disabled', true);
		$('.imgcancel-btn').attr('disabled', true);
	   },	 
	  success:function(responseData){
		// KTApp.unblock('#career_portlet');  
		console.log(responseData);
		if(responseData.response == 'success'){		 
			$('#download_id').attr("href", responseData.path);
		

			$("#download_id").on('click',function() {
				//Your function
				this.click();
				$(this).off('click');   //or $(this).unbind()
			}).click();

			swal.fire({
				title: 'Success!',
				text: 'Downloaded Successfully!',
				type: 'success',
				icon: "success",
				confirmButtonText: "OK",
				confirmButtonClass: "btn btn-primary",
			})
  		  	
	   }else{
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'OR Code Does not downloaded, Please try again later',
				customClass: {
					confirmButton: "btn btn-danger",
				}
			})	
	   }

	   $('#insert_image').attr('disabled', false);
		$('.imgcancel-btn').attr('disabled', false);
		$('#download_QRmdl').modal('hide');
	},
	 error: function(blob){
		  console.log(blob);
	 }
	});
}