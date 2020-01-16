
			$(document).on('click', '#chat_btn', function() {
				$('#main-wrapper').removeClass('slide-nav-toggle close-chat open-search').toggleClass('chat-open');
				return false;
			});
			$(document).on('click', '#close_btn', function() {
				$('#main-wrapper').toggleClass('close-chat').removeClass('chat-open');
				return false;
			});
$(document).ready(function() {
	var param = 0; //this is for ie problem just 1 parametter
    setInterval(function(){
	   var param = 0; //this is for ie problem just 1 parametter	
      //get_all_new_chats(param); // this will run after every 5 seconds
	  get_oposit_new_chats();
	}, 10000);
	
	 get_all_new_chats(param); //for page load first time
	 get_last_chat_user(param);
	 //get_new_chat_alert(param);
	// $("#totol_msgforuser").val('');
	
});
function show_usermessage(id,frmuser)
{
	window.location = base_url+'message/'+frmuser;
	
}

function get_last_chat_user(param){
	 var url  = base_url+'user/chat/get_last_chat_user';
	 var uid  = $("#default_userid").val();
	 if(typeof(uid) != "undefined" && uid != null && uid !=0) {
		chat_details(uid);
	}
	 else
	 {
 	  $.ajax({
			  url:url,
			  dataType: 'json',
			  //async: false,
			  cache:false,
			   success: function(res){ 
			   if(res.chat_id > 0){
				   $("#active_user_"+res.chat_id).addClass('active');
				   $("#active_chat_id").val(res.chat_id);
				   var chat_zone = $("#active_user_"+res.chat_id).attr('tz');
				   $("#temp_chat_tz").val(chat_zone);
				   $("#new_panel-footer").show();
				   $("#delete_conversations_id").attr('onclick','delete_conversation('+res.chat_id+')'); 
				   chat_details(res.chat_id);
			   }
			   }
	  });
	 }
}
function get_all_new_chats(param)
{ 
     var curr_url = $(location).attr('pathname');    
	 var expld = curr_url.split('/');
  	 //if(expld[expld.length-1] == 'message'){ 
 	  var url  =  base_url+'user/chat/get_all_new_chats';
 	  $.ajax({
			  url:url,
			  dataType: 'json',
			  //async: false,
			  cache:false,
			  success: function(res){
				  		if(res.new_total>0)
						{
							//$("#new_message_count").html(res.new_total);
							//$("#new_message_count").show();
							var ts='<div class="dropdown-menu notifications msg-noti" >';
							 ts+='<div class="topnav-dropdown-header"><span>Messages</span></div>';
							 ts+='<div class="scroll-pane"><ul class="media-list scroll-content" id="new_chat_content">'+res.new_chats_content+'</ul></div>';
							 ts+='<div class="topnav-dropdown-footer"><a href="'+base_url+'message">See all messages</a></div>';
							 ts+='</div>'; 
							//$("#message_notification").html(ts);
						}
						
				         var chat_id   = $('.student_chat_list').find('.active').attr('chat_id');
  						 if(chat_id){} else var chat_id = 0; 
 						 var cnt = 0;
  				         $.each(res.new_chats, function(key,value){
   							 var id_cnt = $( "#chat_list_id"+key ).length;
    						 //if(id_cnt > 0 && chat_id != key){ 
 								 $("#chat_list_id"+key).html(value);
								 $("#unread_msg_"+key).addClass('unread-msg');
							//} 
							 if(chat_id == key){  chat_details_selctuser(key);
							  }
							 cnt++;
 						 });   
						 if(cnt > 0) {
							 $('.new_chat_count_cls').html( cnt+' New messages').show();
							 $('#new_message_alertid').html(cnt);
							 
 						 }else{ 
							 $('.new_chat_count_cls,.top_new_msg_count').html('').hide(); 
							  $('#new_message_alertid').html('');
						 }
						 
 					     if(cnt > 0 && expld[expld.length-1] != 'message') { 
 							// $('.new_chat_count_cls').html( ' new messages count append ');
							 $('#new_chat_alert').addClass('rd'); 
						 }else{ 
						 	//$('#new_chat_alert').removeClass('rd'); $('.new_chat_count_cls').html('').css('display','none');
						 } 
  			 }
	  });
 	// }
}
function chat_details_selctuser(user_id)
{ 
	 if(user_id != "" || user_id != 0){ 
		 var url  =  base_url+'user/chat/chat_details_selctuser';
		 var dataString="user_id="+user_id; 
		 $.ajax({
				  url:url,
				  data:dataString,
				  type:"POST",
				  dataType: 'json',
				  success: function(res){
					   if(res != '') {
						   if(res.content !=''){
						   $('#chat_details_appnd').append(res.content); 
						    var scrollTo_val = $('#chat-box').prop('scrollHeight') + 'px';
							$('#chat-box').slimScroll({ scrollTo : scrollTo_val });
							var topbuttom = parseInt($('#chat-box').height()-41);    
							$('.slimScrollBar').css('top',topbuttom+'px');
						   }
					   }
				  }
		 });
	 }									
}
function get_oposit_new_chats()
{  
  var last_chat = $("#chat_details_appnd").children(":first").attr('last_chat'); 
  //alert(last_chat);
  var chat_id   = $('.student_chat_list').find('.active').attr('chat_id');
  if(last_chat){} else var last_chat = 0;
  if(chat_id){
 	     var url  =  base_url+'user/chat/oposit_new_chat';
		 var dataString="chat_id="+chat_id+"&last_chat="+last_chat;
		 $.ajax({
				  url:url,
				  data:dataString,
				  type:"POST",
				  dataType: 'json',
				  success: function(res){ 
 					    $.each(res.new_chat, function(key,value){
							 if($("#chat_details_appnd").html() == '<p class="text-red"> &nbsp; &nbsp; No Chats Availabe </p>') {
								$("#chat_details_appnd").html('');
							 }  
							 var clscnt = $( ".last_chat_"+key ).length;
   							 if(clscnt == 0){ 
								 $("#chat_details_appnd").append(value);
							 } 
						}); 
						if(res.left_content){
							$("#chat_list_id"+chat_id).html(res.left_content);
						}
				  }
		 }); 
  } 		
} 

function email_list_active(ele,data,val1)
{ 
    $(ele).parent().children().each(function(index, element) {  $(this).removeClass('active');  });
	$(ele).addClass('active');
	$("#active_chat_id").val(data);
	$("#temp_chat_tz").val(val1);
	//$("#new-chat-window").hide();
	//$("#default-chat-window").show();
	//$("#new_panel-footer").show();
	$("#delete_conversations_id").attr('onclick','delete_conversation('+data+')');
	
}  
function delete_conversation(user_id)
{
	 var url  =  base_url+'user/chat/delete_conversation';
	 var dataString="user_id="+user_id;
	 //var r = confirm("Are you sure want Delete All Conversation ?");
				//if (r == true) {
	  $.ajax({
		  url:url,
		  data:dataString,
		  type:"POST",
		  success: function(res){
			  if(res==1)
			  {
				  $("#chat_details_appnd").html('');
				  $("#chat_list_id"+user_id).html('');
				  $("#chat_list_id"+user_id).html('<span class="time-text pull-right"> </span><span class="clear text-ellipsis text-xs msg-text">No message</span>');
				 // location.reload();
			  }
		  }
	  });
	//}
}
var chat_track_load = 0; //total loaded record group(s)
var chat_loading  = false; //to prevents multipal ajax loads
		
function chat_details(user_id)
{ 
	$("#totol_msgforuser").val('');
	chat_track_load = 0;
	chat_loading  = false;
	 if(user_id != "" || user_id != 0){ 
		 var url  =  base_url+'user/chat/chat_details';
		 var dataString="user_id="+user_id+"&group_no="+chat_track_load; 
 		 var lodr_html = $("#loading-bg").clone(); 
 		 $("#chat_details_appnd").html(lodr_html);
		 $("#chat_details_appnd").find('#load_text').hide();
		 $("#chat_details_appnd").find('#loading-bg').css('position','absolute').show();
		 //exit();
		 
		 $.ajax({
				  url:url,
				  data:dataString,
				  type:"POST",
				  dataType: 'json',
				  success: function(res){
					   if(res != '') {
						   if($("#chat_details_appnd").html() == '<p class="text-red"> &nbsp; &nbsp; No Chats Availabe </p>'){
							    $("#chat_details_appnd").html('');
						   }
						   $("#unread_msg_"+user_id).removeClass('unread-msg');
						   $("#new_chat_icon"+user_id).remove();
						   $('#chat_details_appnd').html(res.bottom_content); 
						   $("#headuser_details_set").html(res.top_content); 
						    var scrollTo_val = $('#chat-box').prop('scrollHeight') + 'px';
							$('#chat-box').slimScroll({ scrollTo : scrollTo_val });
							var topbuttom = parseInt($('#chat-box').height()-41);    
							$('.slimScrollBar').css('top',topbuttom+'px');
							$("#totol_msgforuser").val(res.chat_count);
							
							if(res.user_status == 1){
								$('.panel-footer').hide();
							}else{
								$('.panel-footer').show();
							}
					   }
					   chat_track_load++;
				  }
		 });
	 }									
}
function save_chat()
{
   var chat_id   = $('.student_chat_list').find('.active').attr('chat_id');
   var chat_type = $('.student_chat_list').find('.active').attr('chat_type');
   // var chat_zone = $('.student_chat_list').find('.active').attr('tz');
    if(chat_id){ 
   	 var chat_content = $.trim($('#chat_message_content').val());
	 var chat_image = $.trim($('#user_message_imgpath').val());
	 var temp_chat = $.trim($('#temp_chat_data').val());
	 //var formData = new FormData(document.getElementById('form_content_id'));
	 var form=$("#form_content_id");
	 if(temp_chat ==0){
	 	if(chat_content.length > 0 || chat_image.length>0){ $('#temp_chat_data').val(1);
		 var url  =  base_url+'user/chat/save_chat';
			 //var dataString="chat_id="+chat_id+"&chat_content="+chat_content+"&chat_type="+chat_type+"&chat_image="+chat_image;
			 $.ajax({
					  url:url,
					  type:"POST",
					  data: form.serialize(),
					  dataType:"json",
					  success: function(res){$('#temp_chat_data').val(0);
						   if(res != '') {
							   $('#chat_message_content').val(''); 
 							   if($("#chat_details_appnd").html() == '<p class="text-red"> &nbsp; &nbsp; No Chats Availabe </p>'){
								    $("#chat_details_appnd").html('');
							   }
							   $("#chat_list_id"+chat_id).html(res.left_content);
							   $('#chat_details_appnd').append(res.right_content);
							   document.getElementById("form_content_id").reset();
							   $("#new_status_attaches").html('');
							    var scrollTo_val = $('#chat-box').prop('scrollHeight') + 'px';
								
								$('#chat-box').slimScroll({ scrollTo : scrollTo_val });
								var topbuttom = parseInt($('#chat-box').height()-41);    
							$('.slimScrollBar').css('top',topbuttom+'px');

						   }
					  }
			 });
	 	}else{
		 	$("#_error_").html('<div class="account-error">Please Enter Some Content</div>');
		 	$("#messageerror_id").modal('show');
	 	}
	 }
		return false;

    }else{
		 $("#_error_").html('Please select Users.....');
		 $("#messageerror_id").modal('show');   
		 return false;	
    } 
}
function newmessageopen()
{ 
	$("#new-chat-window").show();
	$("#default-chat-window").hide();
}
function cancel_newmessage()
{
	$("#text_message").val('');
	$("#new_status_attachesfile").html('');
	//$("#has-items").html('');
	//location.reload();
}

$(document).on('change', 'input[name="new_message_image[]"]', function(){
	   var url = $(this).val();    
   $('.msg-progress').hide();
   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();    
   if ((ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" || ext =="pdf" || ext =="txt" || ext =="xls" || ext =="xlsx" )) 
    {
        $('#img_upload_error').css('display','none'); 
		var url      = base_url+'user/message/new_message_image';
 	var formData = new FormData(document.getElementById('form_content_id'));
	 $(".msg-progress").show();
	$.ajax({
			url: url,  
			type: 'POST',
			enctype: 'multipart/form-data',
			data: formData,
			cache: false,						
			contentType: false,
			dataType: 'json',
			processData: false,
			xhr: function() {
				myXhr = $.ajaxSettings.xhr();
				if(myXhr.upload){
					myXhr.upload.addEventListener('progress',showProgress, false);
				} else {
					console.log("Upload progress is not supported.");
				}
				return myXhr;
				},
			success: function(res) { 
			    if(res.sts == 0){
					$(".msg-progress").hide();
				    $('#new_status_attaches').append(res.content);
 				}else{
					 $(".msg-progress").hide();
					 $("#upload_error_image").html('Error Occured,Please upload image file only');
				}
  			}
		});
   }
   else
   {
     $('#img_upload_error').css('display','block');
     $('.msg-progress').hide();
     $('#new_message_image').val('');
   }
	
});	
$(document).on('change', 'input[name="new_message_imageattach[]"]', function(){
	var url      = base_url+'user/message/new_message_attachment';
 	var formData = new FormData(document.getElementById('new_message_form_id'));
	$(".msg-progressone").show();
	$.ajax({
			url: url,  
			type: 'POST',
			enctype: 'multipart/form-data',
			data: formData,
			cache: false,						
			contentType: false,
			dataType: 'json',
			processData: false,
			xhr: function() {
				myXhr = $.ajaxSettings.xhr();
				if(myXhr.upload){
					myXhr.upload.addEventListener('progress',showProgress, false);
				} else {
					console.log("Upload progress is not supported.");
				}
				return myXhr;
				},
			success: function(res) { 
			    if(res.sts == 0){
					$(".msg-progressone").hide();
				    $('#new_status_attachesfile').append(res.content);
 				}else{
					 $(".msg-progressone").hide();
					 $("#upload_error_image").html('Error Occured,Please upload image file only');
					 
					
				}
  			}
		});
});
function showProgress(evt) {
    if (evt.lengthComputable) {
        var percentComplete = (evt.loaded / evt.total) * 100;
			$('.progress-bar').css('width',percentComplete+'%');
			 
    }  
}
	
var eventHandler = function(name) {
					return function() {
						console.log(name, arguments);
						//$('#log').append('<div><span class="name">' + name + '</span></div>');
					};
				};

	$(function(){
    $('#chat-box').slimScroll({
        height: '363px',
		size: "5px",
		color: '#7A868F',
		wheelStep: 10,
		start :'bottom'
		
    });
});
	$(function(){
    $('#msg-list').slimScroll({
        height: '440px',
		size: "5px",
		color: '#7A868F',
		wheelStep: 5
    });
});
	$(function(){
    $('#head-notifications').slimScroll({
        height: '290px',
        width: '400px',
		size: "5px",
		color: '#7A868F',
		wheelStep: 1
    });
});
function newmessagevaliadate()
{ 
	$(".error_two,.error_one").hide();
	var user=$("#slt_user_id").val();  
	var msg=$("#text_message").val(); 
	if(user ==null)
	{
		$(".error_two").show();
		return false;
	}
	if($.trim(msg).length ==0)
	{
		$(".error_one").show();
		return false;
	}
	
}

$('#chat-box').slimScroll().bind('slimscroll', function(e, pos){
			var autoload_total = $('#totol_msgforuser').val(); //total record group(s)
			 if (pos=='top' && autoload_total !='') {
				 var user_id   = $('.student_chat_list').find('.active').attr('chat_id');
				 var last_id   = $('.chat:first').attr('last_chat');
				 var last_date = $('.chat-date:first').attr('last-date');
				 var url  =  base_url+'user/chat/load_morechats';
				 
				 var dataString="user_id="+user_id+"&group_no="+chat_track_load+"&last_id="+last_id+"&last_date="+last_date; 
				if(chat_track_load < autoload_total && chat_loading==false) //there's more data to load
				{
					
				 $.ajax({
						  url:url,
						  data:dataString,
						  type:"POST",
						  dataType: 'json',
						  beforeSend: function(){
							  chat_loading = true;
							  $('#chat_details_appnd').prepend('<div class="text-center chat-date clm-lc-span"><span>Loading conversation..!</span></div>'); 
						  },
						  success: function(res){
							  $('.clm-lc-span').remove();
							  if(Array.isArray(res.bottom_content))
                              { 
							  $.each(res.bottom_content, function(key,value){ 
								  if(last_date==value.user_date)
								  {
									   $('.setchat-date_'+last_date).after(value.content);
								  }
								  else
								  {
									   var date_content = '<div class="text-center chat-date setchat-date_'+value.user_date+'" last-date="'+value.user_date+'"><span>'+value.date_str+'</span></div>'; 
									   $('#chat_details_appnd').prepend(date_content);
									   last_date = value.user_date;
									   $('.setchat-date_'+value.user_date).after(value.content);
								  }
								  
								  }); 
								  $("#new_chat_icon"+user_id).remove();
								  chat_track_load++; 
								  chat_loading = false;
							  }
							  
						  }
				 }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
						 $('.clm-lc-span').remove();
						alert(thrownError); //alert with HTTP error
						chat_loading = false;
					});
				}

			}
		});
		
		