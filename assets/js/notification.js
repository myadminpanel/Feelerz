$("#notification_alldata").hide();
function get_notification_count()
{
    var url = base_url+'user/notification/get_notification_count';
    $.ajax({
        type:'post',
		dataType: 'json',
        url : url,
        success:function(data)
        {
			if(data.new_total>0)
			{
				$("#notification_count").html(data.new_total);
				$("#notification_count").show();
				$("#notification_alldata").show();
				var ts='<div class="topnav-dropdown-header"><span>Notifications</span></div>';
				 ts+='<div class="scroll-pane"><ul class="media-list scroll-content notification_list" id="new_notification_content">'+data.new_data+'</ul></div>';
				 ts+='<div class="topnav-dropdown-footer"><a href="'+base_url+'notification">See all notifications</a></div>';
				$("#notification_notification").html(ts);
			} 
			else{
				$("#notification_count").hide();
				$("#notification_alldata").hide();
				$("#notification_notification").html('');
			}
		}
    });
}

function mail_notification()
{
    var url = base_url+'user/notification/mail_notification';
    $.ajax({
        type:'post',
        url : url,
        success:function(data)
        {
           
    }
    });
    
}
function get_notification()
{
    var url = base_url+'user/notification/get_new_notification';
    $.ajax({
        type:'post',
        url : url,
        success:function(data)
        {
        $('.notification_list').html('');    
        $('.notification_list').append(data);    
        }
    });
    
}

function hide_notification(table_name,id)
{
    var url = base_url+'user/notification/update_notification';
    $.ajax({
        type:'post',
        url:url,
        data:{table_name:table_name,id:id},
        success:function(data)
        {
         if(data==1)
         {             
         $('#remove_'+table_name+'_'+id).remove();    
         }
        }        
    });
 
}


$(document).ready(function()
{
 setInterval(function(){ get_notification_count() }, 20000); 
 //setInterval(function(){ get_notification() }, 10000); 
 // setInterval(function(){ mail_notification() }, 20000); 
 var param = 0;
 get_all_new_chats_count(param);
 get_notification_count();
});


function update_notification()
{ 
    var url = base_url+'user/notification/update_notification';
    $.ajax({
        type:'post',
        url:url,
        success:function(data)
        {
            if(data)
            {
                $('#notification_count').html();
                window.location.href = base_url()+'notification';
            }
            
        }
        
    });
    
}
function save_newchat()
{  
   var chat_id      = $('#sell_gigs_userid').val();
   var chat_content = $('textarea#messageone').val();
   $("#_error_").html('');
	if(chat_id){ 
	 var form=$("#form_messagecontent_id");
		if(chat_content.length > 0 ){ 
		 var url  =  base_url+'user/chat/save_buyerchat';
			 //var dataString="chat_id="+chat_id+"&chat_content="+chat_content+"&chat_type="+chat_type+"&chat_image="+chat_image;
			 $.ajax({
					  url:url,
					  type:"POST",
					  data: form.serialize(),
					  success: function(res){
						   if(res == 1) {
							  $('textarea#messageone').val('');
							  $('textarea#messageone').text(''); 
							 $('#message-popup').modal('toggle'); 
							 $('#form_messagecontent_id')[0].reset();
						   }
						   else
						   {
							   $('textarea#messageone').val('');
							   $('textarea#messageone').text('');  
							 $('#message-popup').modal('toggle');
						   }
					  }
			 });
		}else{
			$("#_error_").html('<div class="account-error">Please enter message content</div>');
		}
	 
		return false;

	}else{
		 $("#_error_").html('Please select Users.....');
		 return false;	
	} 
}
function get_all_new_chats_count(param)
{ 
     var curr_url = $(location).attr('pathname');    
	 var expld = curr_url.split('/');
	 var message_page = $('#message_page').val();
  	 //if(expld[expld.length-1] == 'message'){  
	 if(message_page!='true')
	 { 
 	  var url  =  base_url+'user/chat/get_all_new_chats';
 	  $.ajax({
			  url:url,
			  dataType: 'json',
			  //async: false,
			  cache:false,
			  success: function(res){
				  		if(res.new_total>0)
						{
							$("#new_message_count").html(res.new_total);
							$("#new_message_count").show();
							var ts='<div class="dropdown-menu notifications msg-noti" >';
							 ts+='<div class="topnav-dropdown-header"><span>Messages</span></div>';
							 ts+='<div class="scroll-pane"><ul class="media-list scroll-content" id="new_chat_content">'+res.new_chats_content+'</ul></div>';
							 ts+='<div class="topnav-dropdown-footer"><a href="'+base_url+'message">See all messages</a></div>';
							 ts+='</div>'; 
							$("#message_notification").html(ts);
						}
  			 }
	  });
	 }
 	// }
}
function change_notification_status(id,sts,ele)
{
	 
     var url = base_url+'user/notification/change_notification_status';
    $.ajax({
        type:'post',
        url:url,
        data:{sts:sts,id:id},
        success:function(data)
        {
         if(data==1)
         {             
           window.location.href = base_url+ele;  
         }
        }        
    });
}