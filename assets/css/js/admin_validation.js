$('#ads_image,#client_image,#imageonly').change(function(){
	
   var url = $(this).val();    
   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();    
   if ((ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
    {
        $('#img_upload_error').css('display','none');
   }
   else
   {
     $('#img_upload_error').css('display','block');
     $('#ads_image').val('');
     $('#client_image').val('');
     $('#imageonly').val('');
   }
 });
	function  release_payment(payment_id)
	{
		var url = BASE_URL+'admin/release_payments/process_payment';
	$.ajax({
		type:'POST',
		url:url,
		data:{payment_id:payment_id},
		success: function(response)
		{
		if(response==1)
		{
			$('#row_id_'+payment_id).remove();
		}	
		}
		})	
	}
		function  delete_seo_setting(seo_id)
	{
		var url = BASE_URL+'admin/dashboard/delete_seo_setting';
	$.ajax({
		type:'POST',
		url:url,
		data:{seo_id:seo_id},
		success: function(response)
		{
		if(response==1)
		{
			location.reload();
			$('#row_id_'+seo_id).remove();
		}	
		}
		})	
	}
	
 	$(document).ready(function(){     
    $('.switch').on('switchChange.bootstrapSwitch', function (e, data) { 
		var update_status = ''; 
		var sts_str   = '';
		var gig_id = $(this).attr('id');
		if($(this).is(':checked')) { 
		   update_status = '0'; 
		   sts_str   = 'Active';
        } else { 
		   update_status = '1';  
		   sts_str   = 'InActive';
        }  
		if(update_status != '') {  
		    $.ajax({
                type:'POST',
                url: BASE_URL+'admin/dashboard/update_gig_status',
                data : {gig_id:gig_id,update_status:update_status},
                success:function(response)
                                {      
			                      $('#change_staus_'+gig_id).html(sts_str);
                                }                
            });
		} 
    })
           $('#admin_add_profession').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	profession: {
                message: 'The Menu name is not valid',
                validators: {
					notEmpty:              {
					message: 'Please enter your Profession'
								   },
                    remote: {
                        url: BASE_URL+'admin/profession/check_profession',
                        // Send { username: 'its value', email: 'its value' } to the back-end
                        data: function(validator) {
                            return {
                                profession: validator.getFieldElements('profession').val()
                            };
                        },
                        message: 'The Profession is already there !!!',
                        type: 'POST'
                    }
                }
            }                          
            }
        });          
      $('#add_footer_menu').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	menu_name: {
                message: 'The Menu name is not valid',
                validators: {
                    remote: {
                        url: BASE_URL+'admin/dashboard/check_footer_menu',
                        // Send { username: 'its value', email: 'its value' } to the back-end
                        data: function(validator) {
                            return {
                                menu_name: validator.getFieldElements('menu_name').val()
                            };
                        },
                        message: 'The Menu is already there !!!',
                        type: 'POST'
                    }
                }
            }                          
            }
        });         
        
        
          $('#add_submenu').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	menu_name: {
                message: 'The Menu name is not valid',
                validators: {
                    remote: {
                        url: BASE_URL+'admin/dashboard/check_footer_submenu',
                        // Send { username: 'its value', email: 'its value' } to the back-end
                        data: function(validator) {
                            return {
                                menu_name: validator.getFieldElements('menu_name').val()
                            };
                        },
                        message: 'The Menu is already there !!!',
                        type: 'POST'
                    }
                }
            } ,
            sub_menu:           {
                validators:           {
                notEmpty:               {
                        message: 'Please enter the sub_menu.'
                                        }
                                      }
                                    }, 
                page_title:           {
                validators:           {
                notEmpty:               {
                        message: 'Please enter the page_title.'
                                        }
                                      }
                                    }, 
                 seo_title:           {
                validators:           {
                notEmpty:               {
                        message: 'Please enter the seo_title.'
                                        }
                                      }
                                    }, 
                    ck_editor_textarea_id:           {
                validators:           {
                notEmpty:               {
                        message: 'Please enter the Page Description.'
                                        }
                                      }
                                    }, 
                    seo_keyword:           {
                validators:           {
                notEmpty:               {
                        message: 'Please enter the seo_keyword.'
                                        }
                                      }
                                    },	
                  seo_desc:           {
                validators:           {
                notEmpty:               {
                        message: 'Please enter the seo_description.'
                                        }
                                      }
                                    }								
            }
        });    
            
            
            
            
            
            
 

        
        $('#admin_add_cat').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	category_name:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a Category'
                                       },
							 remote: {
			url: BASE_URL+'admin/dashboard/catagorycheck',
			// Send { username: 'its value', email: 'its value' } to the back-end
			data: function(validator) {
			return {
			category_name: validator.getFieldElements('category_name').val(),
			catagory_id: validator.getFieldElements('catagory_id').val()
			};
			},
			message: 'The Category name is already there !!!',
			type: 'POST'
			}
                                     }
		}
		}
        });  
        $('#admin_add_client').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	client_name:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a Client name'
                                       }
                                     }
                                    },
                client_image:   {
                validators:          {
                notEmpty:              {
                        message: 'Please select a Image'
                                       }
                                     }
                                    }
                          
		}
        });  
        
         $('#admin_add_gigs').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	default_gigs:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a Desc'
                                       }
                                     }
                                    }
                          
		}
        });  
        
        $('#admin_add_ip').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	ip_addr: {
                message: 'The IP Address is not valid',
                validators: {
                    remote: {
                        url: BASE_URL+'admin/dashboard/check_existing_ip',
                        // Send { username: 'its value', email: 'its value' } to the back-end
                        data: function(validator) {
                            return {
                                ip_addr: validator.getFieldElements('ip_addr').val()
                            };
                        },
                        message: 'The ip_addr is already banned',
                        type: 'POST'
                    }
                }
            }                          
            }
        });        
        
        $('#admin_edit_ip').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	ip_addr:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a IP Address'
                                       }
                                     }
                                    }
                          
		}
        });  
        $('#form_emailsetting').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
       fields: {        
        	email_address:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a Email'
                                       },
				emailAddress: {
                        message: 'Please enter valid email address'
                    }
                                     }
                                    },
                email_tittle:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter a Title'
                                       }
                                     }
                                    }
                          
		}
        });
        
         $('#pass-val').bootstrapValidator({ 
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later       
        fields: {        
        	old_password: {                
                validators: {
					notEmpty: {
						//field: 'new_password',
						message: 'Please enter the old password'
						},
                    remote: {
                        url: BASE_URL+'admin/dashboard/check_old_password',
                        // Send { username: 'its value', email: 'its value' } to the back-end
                        data: function(validator) {
                            return {
                                old_password: validator.getFieldElements('old_password').val()
                            };
                        },
                        message: 'The Password is incorrect',
                        type: 'POST'
                    }
                }
            },
            	new_password: {
                validators: { 
                 notEmpty: {
						field: 'new_password',
						message: 'Please enter the new password'
						}	,					
					identical: {
						field: 'confirm_password',
						message: 'The confirm password and its new password are not the same'
						}			
                }
            },
            confirm_password: {
                validators: {
                           notEmpty: {
						field: 'new_password',
						message: 'Please enter the confirm_password'
						}	,					
					identical: {
						field: 'new_password',
						message: 'The new password and its confirm are not the same'
						}
                    }
                }
            }
        });    
        
    });  // document.ready function  admin_edit_ip  
    
        
         function delete_footer_menu(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/footer_menu/delete_footer_menu';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/footer_menu';
                        }else{
							 window.location = BASE_URL+'admin/footer_menu';
						}
			  }
		});  
		}
            });            
        }   
        
        
        function delete_policy_setting(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/policy_settings/delete';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/policy_settings';
                        }else{
							 window.location = BASE_URL+'admin/policy_settings';
						}
			  }
		});  
		}
            });            
        }
        
         function delete_footer_submenu(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/footer_submenu/delete_footer_submenu';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/footer_submenu';
                        }else{
							 window.location = BASE_URL+'admin/footer_submenu';
						}
			  }
		});  
		}
            });            
        } 
    
    
        function delete_category(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/category/delete_category';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/category';
                        }
			  }
		});  
		}
            });            
        } 
        
		
		 function delete_profession(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
              if(result ==true)                {
              var url        = BASE_URL+'admin/profession/delete';
	          var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/profession';
                        }else{
							 window.location = BASE_URL+'admin/profession';
						}
			  }
		});  
		}
            });            
        } 
		
		
		
         function delete_gigs(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/gigs/delete_gigs';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/gigs';
                        }
			  }
		});  
		}
            });            
        }
        
         function delete_page(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/static_page/delete_page';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/static_page';
                        }
			  }
		});  
		}
            });            
        }
        function delete_ip(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/ban_ip/delete_ip';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/ban_ip';
                        }
			  }
		});  
		}
            });            
        }   
        function delete_request(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/request/delete_request';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/request';
                        }
			  }
		});  
		}
            });            
        }     
        function delete_user(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/user/delete_user';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/user';
                        }
			  }
		});  
		}
            });            
        }   
        
        function delete_ads(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/ads/delete';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/ads';
                        }
			  }
		});  
		}
            });            
        } 
        
        function delete_review(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/review/delete';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/review';
                        }
			  }
		});  
		}
            });            
        }
        
         function delete_client(val)
        {
              	 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
               //alert(result)
               if(result ==true)                {
                var url        = BASE_URL+'admin/client/delete';
		var tbl_id = val;                               
              $.ajax({
			  url:url,
			  data:{tbl_id:tbl_id}, 
			  type:"POST",
			  success:function(res){ 
		        if(res==1)
                        {
                            window.location = BASE_URL+'admin/client';
                        }else{
							 window.location = BASE_URL+'admin/client';
						}
			  }
		});  
		}
            });            
        } 
		
		$(document).ready(function()
		{
		 setInterval(function(){ get_notification_count() }, 20000); 
		 get_notification_count();
		});
		function get_notification_count()
		{
			var url = BASE_URL+'admin/dashboard/get_all_notification';
			$.ajax({
				type:'post',
				dataType: 'json',
				url : url,
				success:function(data)
				{
					if(data.payment_total>0)
					{ 
				     $("#payment_count").html(data.payment_total);
					
					
						var td='<li class="notifi-title">Notification</li>';
						 td+='<li class="list-group nicescroll notification-list">';
						 td+= data.payment_html;
						 td+='</li>';
						  $("#payment_alldata").html(td);
					}else{
						 $("#payment_alldata").hide();
						
					}
					if(data.other_total>0)
					{
						 $("#notification_count").html(data.other_total);
						
						 var td='<li class="notifi-title">Notification</li>';
						 td+='<li class="list-group nicescroll notification-list">';
						 td+= data.other_html;
						 td+='</li>';
						  $("#notification_alldata").html(td);
					}else{
						 $("#notification_alldata").hide();
					}
				}
			});
		}
		function change_notification_alert(id,sts,ele)
		{
			 
			 var url = BASE_URL+'admin/dashboard/change_notification_alert';
			$.ajax({
				type:'post',
				url:url,
				data:{sts:sts,id:id},
				success:function(data)
				{
				 if(data==1)
				 { 
				   if(sts=='new_gig') 
				   {           
				   		window.location.href = BASE_URL+'admin/gigs';
				   }
				   else
				   {
					   window.location.href = BASE_URL+'admin/release_payments';
				   }
				 }
				}        
			});
		}