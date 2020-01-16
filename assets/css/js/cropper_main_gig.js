 $(function() {
        $('.image-editor').cropit({
          exportZoom: 1.25,
          imageBackground: true,
          imageBackgroundBorderWidth: 20,
         
        });

        $('.rotate-cw').click(function() {
          $('.image-editor').cropit('rotateCW');
        });
        $('.rotate-ccw').click(function() {
          $('.image-editor').cropit('rotateCCW');
        });
		$('#fileopen').on("change", function(){ 
			var u = URL.createObjectURL(this.files[0]);		 
			var ext = $('#fileopen').val().split('.').pop().toLowerCase();
			$("#error_msg_model").html('');
			if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
			$('.error_msg').html('invalid extension!');
			$("#fileopen").val('');
			
			}
			else
        	{
				 var img = new Image;   
				img.src = u;	 
				img.onload = function() {								
					if(img.width >= 680 && img.height >=460) 
					{
						 //$(".cropit-preview-image").show();
						  //$(".cropit-preview-background").show();
					         	
					}
					else
					{
						$("#error_msg_model").html("Please upload size more than 680*460 "); 		 
		    			$('#fileopen').val('');
					}
				}
			}
		 
		});
        $('.export').click(function() {
           var imageData = $('.image-editor').cropit('export');
		   var url=base_url+'user/sell_service/prf_crop';
		   var r_id= $('#select_row_id').val();
		   var dataString="img_data="+imageData+"&select_row_id="+r_id; 
		   var file1 = $('#fileopen').val(); 
		   $("#error_msg_model").html('');
		   if(file1.length>1){
		   $.ajax( {
			   		url:url,
					type       : 'post',
					data       : dataString,
					enctype    : 'multipart/form-data',
					dataType   : 'json',
					beforeSend: function () {
						$("#gigimg_loader").show();
						//$(".export").html('<img width="16" height="16" src="'+base_url+'assets/images/loader.gif" alt="loading">');
				
					},
					success: function (data) {
						if (data.result) {
	    				  $('.sell_service_submit').removeAttr('disabled');	
						  $('#image_video_error_msg').html(''); 
						  $('.uploaded-section').css('display','block');
						  $(".uploaded-section").append(data.result);
						  $('#select_row_id').val(data.row_id);
						  $('#error_msg_model').html('');
						  $(".cropit-preview-image").attr('src','');
						  $(".cropit-preview-background").attr('src','');
						  $("#fileopen").val("");
						   var v1= $( "#image_array" ).val();
							if(v1.length >0)
							{
							var v2 = [];
							v2.push(v1);
							v2.push(data.sub_html);
							$( "#image_array" ).val(v2);
							}
							else{
							var array = [];
							array.push(data.sub_html);
							$( "#image_array" ).val(array);
							}
						}
					$("#avatar-gig-modal").modal('hide');
				},
				complete: function () {
					   	$("#gigimg_loader").hide();
						$(".export").html('Done');
					}
      		});
		   }
		   else
			{
				$("#error_msg_model").html("Please select size more than 680*460 "); 		 
			}
        });
      });
	  
	  