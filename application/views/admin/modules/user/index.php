
                                        


                                        <div class="main-content small-gutter">
                                            <?php if($this->session->userdata('message')) {  ?>
                 <?php echo $this->session->userdata('message');?>
            <?php } ?>
                <!-- START PAGE COVER -->
                <div class="row bg-title clearfix page-title">
                    <!--<div class="col-12 col-lg-3">
                        <h4 class="page-title">App User</h4>
                    </div>-->
                    <div class="col-12 col-lg-9">
                        <!-- START breadcrumb -->
                        <ol class="breadcrumb pl-0 pr-0 float-lg-left">
                            <li><a href="<?php echo base_url().'admin'; ?>">User Dashboard</a></li>
                            <li class="active">Manage App User</li>
                        </ol>
                        <!-- END breadcrum -->
                    </div>
                    <!--<div class="col-12">
                        <h3>Form Layouts</h3>
                    </div>-->
                </div>
                <!-- END PAGE COVER -->
                <div class="container-fluid">
                    <div class="row">
                        
                        
                    <div class="col-lg-12 col-xl-12 mb-2">
                            <div class="bg-white padding-25 h-100">
                                <h4 class="mt-0 box-title">Members List</h4>
                                <div class="data-table-wrapper">
                                     <div class="container">
                  <?php  if(@$this->session->flashdata("succe")) { ?>
                  <div class="alert alert-success" >
                     <?php echo $this->session->flashdata("succe"); ?>
                  </div>
                  <?php } ?>
                  <?php  if(@$this->session->flashdata("warni")) { ?>
                  <div class="alert alert-warning" >
                     <?php echo $this->session->flashdata("warni"); ?>
                     <?php } ?>
                     </div>
                                    <div class="row">
                                        <!--<div class="col-sm-12 col-lg-4 col-xl-6">
                                            <div class="data-table-filter mb-2 float-sm-left float-lg-none d-lg-inline-block">
                                                <label for="search1">Search:</label>
                                                <input type="search" class="form-control" id="search1">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4 col-xl-4">
                                            <div class="data-table-length">
                                                <label>
                                                    Show
                                                    <select aria-controls="example" class="form-control">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    entries
                                                </label>
                                            </div>
                                        </div>-->
                        
                            <!--<div class="data-table-filter mb-2 float-sm-left float-lg-none d-lg-inline-block">
                                <label for="search1">Search Filter:</label>
                                <input type="search" placeholder="Name / Country / Age" class="form-control sp-opp" id="search1">
                            </div>-->

 <!--<div class="container">-->
 <!--                 <?php  if(@$this->session->flashdata("succe")) { ?>-->
 <!--                 <div class="alert alert-success" >-->
 <!--                    <?php echo $this->session->flashdata("succe"); ?>-->
 <!--                 </div>-->
 <!--                 <?php } ?>-->
 <!--                 <?php  if(@$this->session->flashdata("warni")) { ?>-->
 <!--                 <div class="alert alert-warning" >-->
 <!--                    <?php echo $this->session->flashdata("warni"); ?>-->
 <!--                    <?php } ?>-->
 <!--                    </div>-->
                          <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button sss">
                            <!--   <select class="form-control"> 
                                <option value="please_select"> select option </option>
                                <option value="activate"> Activate </option>
                                <option value="deactivate"> Deactivate </option>
                                <option value="delete"> Delete </option>
                                <option value="message"> Message </option>
                            </select>
                            
                                <button id="get_ids_for_activate" class="btn btn-success ripple">
                                    <span>Apply</span>
                                </button> -->
            <!--                    <button class="btn btn-primary ripple" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">-->
												<!--	<span>Message</span>-->
												<!--</button>-->
                                <!--<button class="btn btn-info btn-raised ripple"  id="get_ids_for_activate">-->
                                <!--    <span>Active</span>-->
                                <!--</button>-->
                                <!--<button id="get_ids_for_deactivate" class="btn btn-warning btn-raised ripple">-->
                                <!--    <span>Deactive</span>-->
                                <!--</button>-->
                                <button onclick="activate()" type="button" class="btn btn-info btn-raised ripple"  id="get_ids_for_acti">
                                    <span>Active</span>
                                </button>
                                <button onclick="deactivate()" type="button" class="btn btn-warning btn-raised ripple" id="get_ids_for_deacti">
                                    <span>Deactive</span>
                                </button>
                                
                                
                                
                                
                                
                                
                                <button id="get_ids_for_delete" name="bulk_delete_submit" class="btn btn-danger btn-raised ripple">
                                    <span>Delete</span>
                                </button>
                            
                            </div>
                        
                    </div>
                                    
    <div class="row">
        <div class="col-md-12">

            <div class="table-responsive sanjeev-table">
                <form id="form-id" action="<?php echo base_url(); ?>admin/user/updatestatus" method="post">
                <input type="hidden" name="status" id="status">
        
                <table id="example2" class="table table-striped table-bordered data-table table-checkable mb-0" role="grid">
                    <thead>
                    <tr>
                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1">
                            <div class="form-check">
                                
                                
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="ckval1213[]" class="custom-control-input" id="checkall" value="<?php ?>">
                                    <label class="custom-control-label" for="checkall"></label>
                                </div>
                            </div>
                        </th>
                        <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending">-->
                        <!--    ID-->
                        <!--</th>-->
                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending">
                             Name
                        </th>
                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Email
                            
                        </th>
                        <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">Gender-->
                        <!--</th>-->
                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Contact
                            
                        </th>
                    <!-- <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending"> D.O.B-->
                    <!--</th>-->
                        
                        <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending"> Country
                        </th> 

                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">
                            Status
                        </th>
                  </tr>
                     </thead>
            
               <tbody>
         <?php 
          if(!empty($list)) 
            {
                $k=array();
               $i=1;
            // var_dump($list);
            foreach($list as $item)
               {

                    //  $status = 'Active'; if($item['status']==0){$status = 'Inactive';} 
                    $status = 'Active'; $set_class='badge-primary'; if($item['status']==0){$status = 'Deactive'; $set_class='badge-warning'; } 
                     // $verified = 'Yes' ; if($item['verified']==1){$verified = 'No';} 
                    if(!empty($item['parent_name']))
                        { 
                            $parent_category = $item['parent_name'];
                            
                            var_dump($item['name']);
                        }
                ?>


            <tr>
                <td>
                    <div class="form-check">
                        <div class="custom-control custom-checkbox custom-checkbox-primary">
                            <input type="checkbox" name="ckval[]" class="custom-control-input checkitem" value="<?php echo $item['id']; ?>" id="tableCheckbox2_<?php echo $item['id']; ?>">
                            <label class="custom-control-label" for="tableCheckbox2_<?php echo $item['id']; ?>"></label>
                        </div>
                    </div>
                </td>

                <!--<td><?php echo $item['id']; ?> &nbsp;</td>-->
               
                <td><a data-toggle="modal" data-target="#edituser_<?php echo $item['id']; ?>" title="Edit user name" ><i class="fa fa-pencil-square-o left" aria-hidden="true"></i></a><?php echo json_decode('"'.$item["name"].'"'); ?></a></td>
                 <td><a href="mailto:user@gmail.com"><?php echo $item['email'];?></a></td>
                 <td><?php echo $item['contact'];?></td>
                 <!--<td><?php echo $item['gender'];?></td>-->
                  <!--<td><?php echo $item['dob'];?></td>-->
                
                <td> 

                         <?php echo  $item['country'];?></td>
                <td><span class="badge badge-pill <?php echo $set_class; ?> "><?php echo $status;?></span>
                </td>
            </tr>

            </form>



<div id="edituser_<?php  echo $item['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="border:4px solid black;">
<form action="<?php echo base_url(); ?>admin/user/edituser" method="post">
      <div class="modal-header">
    
        <h4 class="modal-title">Edit User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <input type="hidden" name="userId" id="userId" value="<?php echo $item['id']; ?>">
        
  <div class="form-group">
    <label for="user_name">Name:</label>
    <input type="text" name="userName" class="form-control" id="userName" value="<?php echo $item['name'];?>">
</div>
<div class="form-group">
   
  <label for="user_name">Email:</label>
    <input type="text" name="email" class="form-control" id="email" value="<?php echo $item['email'];?>">
  </div>
   <div class="form-group">
  <label for="user_name">Contact number:</label>
    <input type="tel" name="contact" class="form-control" id="contact" value="<?php echo $item['contact'];?>">
  </div>
  <div class="form-group">
  <label for="user_name">Gender:</label>
  <select id="select2" name="gen" class="form-control material-select" style="width:100%;" >
                                                                 <!--<option value="">Select Parent Category</option>-->
                                                                
                                                                //  $con = $this->db->query(" SELECT * FROM `users` ")->result_array();
                                                                // //  var_dump($con);
                                                                // foreach($con as $item) {
                                                                //  ?>
                                                              <?php 
                                                              
                                                                    if($item['gender']=='Male')
                                                                    { ?>
                                                                     <option value="Male">Male</option>
                                                                     <option value="Female">Female</option>
                                                                     
                                                            <?php }else{ ?>
                                                            <option value="Female">Female</option>
                                                                 <option value="Male">Male</option>
                                                                 
                                                                 
                                                              <?php } ?>
                                                                  
                                                                 
                                                                 
                                                                </select>
  
    <!--<input type="text" name="gender" class="form-control" id="gender" value="<?php echo $item['gender'];?>">-->
  </div>
  <div class="form-group">
  <label for="user_name">D.O.B:</label>
    <input type="date" name="dob" class="form-control" id="dob" value="<?php echo $item['dob'];?>">
    
  </div>
 
  <div class="form-group">
  <label for="user_name">Country:</label>
    <!--<input type="text" name="country" class="form-control" id="country" value="<?php echo $item['country'];?>">-->
    <select id="select2" name="con" class="form-control material-select" style="width:100%;" >
        <option><?php echo $item['country'];?></option>
                                                                 
                                                                 <?php
                                                                 $con = $this->db->query(" SELECT * FROM `country`")->result_array();
                                                                //  var_dump($con);
                                                                foreach($con as $row) {
                                                                 ?>
                                                                 
                                                                 <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                                                                 <?php } ?>
                                                                </select>
  </div>
  </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" >Submit</button>
        
      </div>
    </div>

  </div>
</div>

             <?php    $i = $i+1;

                       }

                     }
                    ?>
          
   
                                        
                                        </tbody>
                                    </table>
                               
                                </div>
                            </div>
                        </div>
                        <div class="row">&nbsp;</div>
                        </form>
                    </div>
                    </div>
                </div>
                        
                        
                        
                        
                      
                        
                    </div>
                </div>
            </div>

            <script>
function activate() {
    var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to activate  "+select_id+" User"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
               window.location=BASE_URL+"admin/user/activate/"+yourArray;  
            }
            else
            {
              return  false;
            }
          }
    // alert('are you sure you want to activate the selected user');
  document.getElementById("status").value = "0";
  
  document.getElementById('form-id').submit();
 
}



function deactivate() {
    var selects_id=$(".checkitem:checked").length;
          if(selects_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to deactivate  "+selects_id+" User"))
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
    // alert('are you sure you want to deactivate the selected user');
  document.getElementById("status").value = "1";
  document.getElementById('form-id').submit();
}
</script>







// <script>
// $(document).ready(function() {
// 	$('#butsave').on('click', function() {
// 		$("#butsave").attr("disabled", "disabled");
// 		var active = $('#get_ids_for_acti').val();
// 		var deactive = $('#get_ids_for_deacti').val();
// // 		var phone = $('#phone').val();
// // 		var city = $('#city').val();
// 		if(active="" && deactive!=""){
// 			$.ajax({
// 				url: "user.php",
// 				type: "POST",
// 				data: {
// 					active: active,
// 					deactive: deactive,
// 				// 	phone: phone,
// 				// 	city: city				
// 				},
// 				cache: false,
// 				success: function(dataResult){
// 					var dataResult = JSON.parse(dataResult);
// 					if(dataResult.statusCode==200){
// 						$("#butsave").removeAttr("disabled");
// 						$('#fupForm').find('input:text').val('');
// 						$("#success").show();
// 						$('#success').html('Data added successfully !'); 						
// 					}
// 					else if(dataResult.statusCode==201){
// 					   alert("Error occured !");
// 					}
					
// 				}
// 			});
// 		}
// 		else{
// 			alert('Please fill all the field !');
// 		}
// 	});
// });
// </script>

















