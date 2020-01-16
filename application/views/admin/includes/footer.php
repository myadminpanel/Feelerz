          <footer class="footer">
                <div class="float-right">
                    Admin Template by<a href="javascript:void(0)" class="company-name text-theme">Feelerz</a>
                </div>
                <div class="clearfix"></div>
            </footer>

            </div>
        </div>
    	<script>var resizefunc = []; </script>
		<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
         
        
        <script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/detect.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap-switch.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/vendor.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/main.js"></script> 
        <script src="<?php echo base_url(); ?>assets/js/settings.min.js"></script> 
		<script src="<?php echo base_url(); ?>assets/js/charts.js"></script> 
		
<!-- Ckeditor -->
    <script src="<?php echo base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>

    <!-- TinyMCE -->
   <script src="<?php echo base_url(); ?>assets/plugins/tinymce/tinymce.js"></script>

		<!--<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>-->
		<script>tinymce.init({selector:'#ckeditor'});</script>
		
		<script>
            var BASE_URL = "<?php echo base_url(); ?>";     
			// $("[name='my-checkbox']").bootstrapSwitch();      
        </script>
        <script>setTimeout(function(){ $('#flash_succ_message, #flash_error_message').hide(); }, 5000);</script>

        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#example2').DataTable();
} );
</script>


  <!-- Start Check box -->
<script type="text/javascript">
     $(document).ready(function(){
       $("#get_ids_for_delete").click(function() {
          var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to delete the selected  "+select_id+" User"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
                //window.location=BASE_URL+"admin/user/delete/"+yourArray;  


$.ajax({
method: "POST",
url: BASE_URL+"admin/user/delete",
data: {"ids":yourArray},
dataType:"html",
success: function(data){
alert('deleted successfully');
location.reload();
//console.log(data);
}

});


            }
            else
            {
              return false;
            }
          }
          });
       
     
     });

     $("#checkall").change(function(){
    $(".checkitem").prop("checked",$(this).prop("checked"))
  });
  
  $(".checkitem").change(function(){
    if($(this).prop("checked")==false)
    {
      $("#checkall").prop("checked",false);
    }
    if($(".checkitem:checked").length==$(".checkitem").length)
    {
      $("#checkall").prop("checked",true);
    }
  });
   </script>


   <script type="text/javascript">
     $(document).ready(function(){
       $("#get_ids_for_activate").click(function() {
          var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to activate the selected  "+select_id+" User"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
               window.location=BASE_URL+"admin/user/activate/"+yourArray;  
            }
            
            
            else
            {
              return false;
            }
           }
          });
       
     });
     
     
       $("#checkall").change(function(){
       $(".checkitem").prop("checked",$(this).prop("checked"))
      });
  
  $(".checkitem").change(function(){
    if($(this).prop("checked")==false)
    {
      $("#checkall").prop("checked",false);
    }
    if($(".checkitem:checked").length==$(".checkitem").length)
    {
      $("#checkall").prop("checked",true);
    }
  });

   </script>

<!--// for checking the conpass condition start//-->

    <script type="text/javascript">
    
        $(function(){
            
            $('.btn_sub').click(function(){
                var pass = $('#newp').val();
                var confpass = $('#conp').val();
                
                if(pass!=confpass)
                {
                    alert('Confirm password do not match!!..');
                    return false;
                }
                
                return true;
                
            });    
        })
    </script>
<!--// for checking the conpass condition end//-->





   <script type="text/javascript">
     $(document).ready(function(){
       $("#get_ids_for_deactivate").click(function() {
          var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to deactivate  "+select_id+" User"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
               window.location=BASE_URL+"admin/user/deactivate/"+yourArray;  
            }
            else
            {
              return  false;
            }
          }
          });
       
     
     });
     
     

   </script>

   <script type="text/javascript">
     $(document).ready(function(){
       $("#get_ids_for_deact").click(function() {
          var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to deactivate  "+select_id+" country"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
               window.location=BASE_URL+"admin/country/deact/"+yourArray;  
            }
            else
            {
              return  false;
            }
          }
          });
       
     
     });

     $("#checkall").change(function(){
    $(".checkitem").prop("checked",$(this).prop("checked"))
  });
  
  $(".checkitem").change(function(){
    if($(this).prop("checked")==false)
    {
      $("#checkall").prop("checked",false);
    }
    if($(".checkitem:checked").length==$(".checkitem").length)
    {
      $("#checkall").prop("checked",true);
    }
  });

   </script>

   <script type="text/javascript">
     $(document).ready(function(){
       $("#get_ids_for_act").click(function() {
          var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to activate the selected  "+select_id+" country"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
               window.location=BASE_URL+"admin/country/act/"+yourArray;  
            }
            else
            {
              return false;
            }
          }
          });
       
     
     });

   </script>

   <script type="text/javascript">
     $(document).ready(function(){
       $("#get_ids_for_del").click(function() {
          var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to delete the selected  "+select_id+" Country"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
                //window.location=BASE_URL+"admin/country/del/"+yourArray;  


$.ajax({
method: "GET",
url: BASE_URL+"admin/country/del",
data: {"ids":yourArray},
dataType:"html",
success: function(data){
//alert('delete')
console.log(data);
}

});


            }
            else
            {
              return false;
            }
          }
          });
       
     
     });

     $("#checkall").change(function(){
    $(".checkitem").prop("checked",$(this).prop("checked"))
  });
  
  $(".checkitem").change(function(){
    if($(this).prop("checked")==false)
    {
      $("#checkall").prop("checked",false);
    }
    if($(".checkitem:checked").length==$(".checkitem").length)
    {
      $("#checkall").prop("checked",true);
    }
  });
   </script>






    

<script type="text/javascript">
     $(document).ready(function(){
       $("#ids_for_delete").click(function() {
          var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to delete the selected  "+select_id+" Manageimages"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
                window.location=BASE_URL+"admin/manageimages/delet/"+yourArray;
                // alert(+yourArray);


$.ajax({
method: "GET",
url: BASE_URL+"admin/manageimages/delet",
data: {"id":yourArray},
dataType:"html",
success: function(data){
//alert('delete')
console.log(data);
}

});


            }
            else
            {
              return false;
            }
          }
          });
       
     
     });

     
  
  $(".checkitem").change(function(){
    if($(this).prop("checked")==false)
    {
      $("#checkall").prop("checked",false);
    }
    
  });
   </script>



<script type="text/javascript">
     $(document).ready(function(){
       $("#ids_for_dele").click(function() {
          var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to delete the selected  "+select_id+" Managevideos"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
                window.location=BASE_URL+"admin/managevideos/dele/"+yourArray;  


$.ajax({
method: "GET",
url: BASE_URL+"admin/managevideos/dele",
data: {"ids":yourArray},
dataType:"html",
success: function(data){
//alert('delete')
console.log(data);
}

});


            }
            else
            {
              return false;
            }
          }
          });
       
     
     });

     $("#checkall").change(function(){
    $(".checkitem").prop("checked",$(this).prop("checked"))
  });
  
  $(".checkitem").change(function(){
    if($(this).prop("checked")==false)
    {
      $("#checkall").prop("checked",false);
    }
    if($(".checkitem:checked").length==$(".checkitem").length)
    {
      $("#checkall").prop("checked",true);
    }
  });
   </script>





<!--<script type="text/javascript">-->
<!--     $(document).ready(function(){-->
<!--       $("#for_delete").click(function() {-->
<!--          var select_id=$(".checkitem:checked").length;-->
<!--          if(select_id==0)-->
<!--          {-->
        
<!--          }-->
<!--          else-->
<!--          {-->
<!--            if(confirm("Are you sure you want to delete the selected  "+select_id+" Post"))-->
<!--            {-->
<!--              var yourArray=[];-->
<!--             $(".checkitem:checked").each(function(){-->
<!--                yourArray.push($(this).val());-->
<!--              });-->
             
<!--                window.location=BASE_URL+"admin/post/d/"+yourArray;  -->


<!--$.ajax({-->
<!--method: "GET",-->
<!--url: BASE_URL+"admin/post/d",-->
<!--data: {"ids":yourArray},-->
<!--dataType:"html",-->
<!--success: function(data){-->
<!--//alert('delete')-->
<!--console.log(data);-->
<!--}-->

<!--});-->


<!--            }-->
<!--            else-->
<!--            {-->
<!--              return false;-->
<!--            }-->
<!--          }-->
<!--          });-->
       
     
<!--     });-->

<!--     $("#checkall").change(function(){-->
<!--    $(".checkitem").prop("checked",$(this).prop("checked"))-->
<!--  });-->
  
<!--  $(".checkitem").change(function(){-->
<!--    if($(this).prop("checked")==false)-->
<!--    {-->
<!--      $("#checkall").prop("checked",false);-->
<!--    }-->
<!--    if($(".checkitem:checked").length==$(".checkitem").length)-->
<!--    {-->
<!--      $("#checkall").prop("checked",true);-->
<!--    }-->
<!--  });-->
<!--   </script>-->

   

































        <script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/admin_validation.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
		<!-- REQUIRED FOR FETCHING USER TIME ZONE -->
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jstz-1.0.4.min.js"></script>   
		<script type="text/javascript">
			$(document).ready(function() {
				var tz = jstz.determine();
				var timezone = tz.name();
				$.post('<?php echo base_url(); ?>ajax',{timezone:timezone},function(res){
				// console.log(res);
				})      
			});
		</script>
		<script>
 function subitmorefield()
 {
	var labe=$("#field-1").val();
	var fname= $("#field-2").val();
    var html=''; 
	var html = '<div class="form-group">';
      html = html+' <label class="col-sm-3 control-label">'+labe+'</label>';
	  html = html+' <div class="col-sm-9">'; 
	  html = html+'<input type="text" class="form-control"  name="'+fname+'" placeholder="Type here.." value=""'; 
	  html = html+'</div>';
	  html = html+'</div>';
    $('.hrs_detail_addmore').append(html);
  	$('#con-close-modal').modal('hide');
 }
 </script>
<script>
function fnc(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > 50) 
        return 1; 
    else return value;
}
</script>
 <script>
    // jQuery ".Class" SELECTOR.
    $(document).ready(function() {
		
        $('.numberonly').keypress(function (event) {
            return isNumber(event, this)
        });

        $('#policy_description').keyup(function()
                {
                       var yourInput = $(this).val();
                       re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
                    var isSplChar = re.test(yourInput);
                       if(isSplChar)
                       {
                           var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
                           $(this).val(no_spl_char);
                    }
                 });
    });
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    


</script>

<!--<script>-->
    
<!--    function timeDifference(current, previous) {-->

<!--    var msPerMinute = 60 * 1000;-->
<!--    var msPerHour = msPerMinute * 60;-->
<!--    var msPerDay = msPerHour * 24;-->
<!--    var msPerMonth = msPerDay * 30;-->
<!--    var msPerYear = msPerDay * 365;-->

<!--    var elapsed = current - previous;-->

<!--    if (elapsed < msPerMinute) {-->
<!--         return Math.round(elapsed/1000) + ' seconds ago';   -->
<!--    }-->

<!--    else if (elapsed < msPerHour) {-->
<!--         return Math.round(elapsed/msPerMinute) + ' minutes ago';   -->
<!--    }-->

<!--    else if (elapsed < msPerDay ) {-->
<!--         return Math.round(elapsed/msPerHour ) + ' hours ago';   -->
<!--    }-->

<!--    else if (elapsed < msPerMonth) {-->
<!--        return 'approximately ' + Math.round(elapsed/msPerDay) + ' days ago';   -->
<!--    }-->

<!--    else if (elapsed < msPerYear) {-->
<!--        return 'approximately ' + Math.round(elapsed/msPerMonth) + ' months ago';   -->
<!--    }-->

<!--    else {-->
<!--        return 'approximately ' + Math.round(elapsed/msPerYear ) + ' years ago';   -->
<!--    }-->
<!--}-->
    
<!--</script>-->






<script type="text/javascript">
//      $(document).ready(function(){
//       $("#for_post").click(function() {
//           var select_id=$(".checkitem:checked").length;
//           if(select_id==0)
//           {
//             alert("Please Select The CheckBox");
//           }
//           else
//           {
//             if(confirm("Are you sure you want to delete the selected  "+select_id+" Post"))
//             {
//               var yourArray=[];
//              $(".checkitem:checked").each(function(){
//                 yourArray.push($(this).val());
//               });
             
//                 window.location=BASE_URL+"admin/post/delete_post/"+yourArray;  


// $.ajax({
// method: "POST",
// url: BASE_URL+"admin/post/delete_post",
// data: {"ids":yourArray},
// dataType:"html",
// success: function(data){
// // alert('deleted successfully');
// location.reload();
// //console.log(data);
// }

// });


//             }
//             else
//             {
//               return false;
//             }
//           }
//           });
       
     
//      });

//      $("#checkall").change(function(){
//     $(".checkitem").prop("checked",$(this).prop("checked"))
//   });
  
//   $(".checkitem").change(function(){
//     if($(this).prop("checked")==false)
//     {
//       $("#checkall").prop("checked",false);
//     }
//     if($(".checkitem:checked").length==$(".checkitem").length)
//     {
//       $("#checkall").prop("checked",true);
//     }
//   });
   </script>

</body>
</html>