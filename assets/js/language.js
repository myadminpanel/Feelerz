$(document).ready(function(){     
    $('.switch').on('switchChange.bootstrapSwitch', function (e, data) { 
        var update_language = ''; 
        var sts_str   = '';
        var id = $(this).attr('id');
        if($(this).is(':checked')) { 
           update_language = '1'; 
           sts_str   = 'Active';
        } else { 
           update_language = '2';  
           sts_str   = 'InActive';
        }  
        if(update_language != '') {  
            $.ajax({
                type:'POST',
                url: BASE_URL+'admin/language_management_controller/update_language_status',
                data : {id:id,update_language:update_language},
                success:function(response)
                                {      
                                  $('#change_staus_'+id).html(sts_str);
                                }                
            });
        } 
  })
    });