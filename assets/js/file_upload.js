function upload_product(){
    $('#product_upload').click();
}

$(document).on('change','#product_upload',function(e){
	
 var max_size = parseInt(Math.ceil(this.files[0].size/1024/1024));

   if(max_size<=5){
    
   var error = 0
    var filename = $('#product_upload').val();

   var allowedExtensions = /(\.zip)$/i;

   if(!allowedExtensions.exec(filename)){
        alert('Please upload file having extensions .zip only.');
        $('#product_upload').val('')
        return false;
    }else{
        
       if(error==0){
            $('#product_upload_form').submit();
        }else{
            return false;
        }
    }
    }else{

        alert('Maximum upload files size less than or equal to 5 MB');
         $('#product_upload').val('')
         return false;
    }
});

function sales_view_file(id)
{
     var url   =  base_url+'user/sales/get_sales_details_files';
     var dataString="id="+id; 
      $.ajax({
              url:url,
              data:dataString,
              type:"POST",
              dataType: 'json',
              success: function(res){ 
                   if(res.status==1)
                   {
                       $('#purchases_model_deatils').html(res.content);
                       $('#purchase-popup').modal('toggle');
                   }
               }
      });   
     
}
 

function remove_details(e){

    bootbox.confirm({
        title: "Remove",
        message: "Are you sure you want to remove this ?",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if(result==true){
                window.location.href= $(e).data('url'); 
            }
        }
    });
}   