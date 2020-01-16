<div class="main-content small-gutter">
<!-- START PAGE COVER -->
<div class="row bg-title clearfix page-title">
   <!--<div class="col-12 col-lg-3">
      <h4 class="page-title">Manage Emoji</h4>
   </div>-->
   <div class="col-12 col-lg-9">
      <!-- START breadcrumb -->
      <ol class="breadcrumb pl-0 pr-0 float-lg-left">
         <li><a href="<?php echo base_url().'admin'; ?>">User Dashboard</a></li>
         <li class="active">Manage Feelings</li>
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
         <h4 class="mt-0 box-title">Feelings List</h4>
         <div class="data-table-wrapper">
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
               <div class="container">
                  <?php  if(@$this->session->flashdata("success")) { ?>
                  <div class="alert alert-success" >
                     <?php echo $this->session->flashdata("success"); ?>
                  </div>
                  <?php } ?>
                  <?php  if(@$this->session->flashdata("warning")) { ?>
                  <div class="alert alert-warning" >
                     <?php echo $this->session->flashdata("warning"); ?>
                     <?php } ?>
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
                  </div>
                  <div class="col-sm-12 col-lg-4 col-xl-12 text-md-right">
                     <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button sss">
                        <button onclick="tivate()" type="button" class="btn btn-info btn-raised ripple"  id="acti">
                        <span>Active</span>
                        </button>
                        <button onclick="detivate()" type="button" class="btn btn-warning btn-raised ripple" id="deacti">
                        <span>Deactive</span>
                        </button>
                        <!--<button class="btn btn-info btn-raised ripple" data-toggle="modal" data-target="#addfeeling_">-->
                        <!--<span>Add Feeling</span>-->
                        <!--</button>-->
                        <!-- Trigger the modal with a button -->
                        <div id="addfeeling_" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                              <!--Modal content-->
                              <div class="modal-content" style="border:4px solid black;">
                                 <form action="<?php echo base_url(); ?>admin/mainfeeling/add_feeling" method="post">
                                    <div class="modal-header">
                                       <h4 class="modal-title">Add Feeling</h4>
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body" style="text-align:left;">
                                       <!--<div class="form-group">-->
                                       <!--   <label for="country_sortname">Sort Name:</label>-->
                                       <!--  <input type="text" name="sortname" class="form-control" id="" value="">-->
                                       <!--  </div>-->
                                       
                                       <div class="form-group">
                                          <label for="country_name">Feeling:</label>
                                          <input type="text" name="feeling" class="form-control" id="" value="" required>
                                       </div>
                                       <div class="form-group">
                                          <label for="country_name">Emoji:</label>
                                          <input type="text" name="emo" class="form-control" id="" value="" required>
                                       </div>
                                       <div class="form-group">
                                          <label for="country_name">Color Code:</label>
                                          <input type="color" name="cc" class="form-control" id="" value="" required>
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="submit" class="btn btn-default" >Submit</button>
                                 </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="table-responsive sanjeev-table">
                           <form id="formid" action="<?php echo base_url(); ?>admin/mainfeeling/updatestatu" method="post">
                              <input type="hidden" name="status" id="status">
                              <table id="example2" class="table table-striped table-bordered data-table table-checkable mb-0" role="grid">
                                 <thead>
                                    <tr>
                                       <th tabindex="0" aria-controls="example" rowspan="1" colspan="1">
                                          <div class="form-check">
                                             <!--<div class="custom-control custom-checkbox">-->
                                             <!--    <input type="checkbox" class="custom-control-input" id="tableCheckbox1">-->
                                             <!--    <label class="custom-control-label" for="tableCheckbox1"></label>-->
                                             <!--</div>-->
                                             <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="ckval1213[]" class="custom-control-input" id="checkall" value="<?php ?>">
                                                <label class="custom-control-label" for="checkall"></label>
                                             </div>
                                          </div>
                                       </th>
                                       <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending">
                                          Feeling
                                       </th>
                                       <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">Emoji Catagory-->
                                       <!--</th>-->
                                       <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">-->
                                       <!--    Emoji icon  </th>   -->
                                       <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">
                                          Emoji
                                       </th>
                                       <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">
                                          Color Code
                                       </th>
                                       <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">
                                          Feeling Status
                                       </th>
                                       <!-- <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">-->
                                       <!--    Action-->
                                       <!--</th>-->
                                    </tr>
                                 </thead>
                                 <tbody>
              <?php 
                 if(!empty($list)) 
                   {
                       $k=array();
                      $i=1;
                   //  var_dump($list);
                   foreach($list as $feel)
                      {
                 
                     $status = 'Active'; $set_class='badge-primary'; if($feel['status']==0){$status = 'Deactive'; $set_class='badge-warning';
                      } 
                            // $verified = 'Yes' ; if($feel['verified']==1){$verified = 'No';} 
                           if(!empty($feel['parent_name']))
                               { 
                                   $parent_category = $feel['parent_name'];
                               }
                       ?>
                                    <tr>
                                       <td>
                                          <div class="form-check">
                                             <div class="custom-control custom-checkbox custom-checkbox-primary">
                                                <input type="checkbox" name="ckval1[]" class="custom-control-input checkitem" value="<?php echo $feel['id']; ?>" id="tableCheckbox2_<?php echo $feel['id']; ?>">
                                                <label class="custom-control-label" for="tableCheckbox2_<?php echo $feel['id']; ?>"></label>
                                             </div>
                                          </div>
                                       </td>
                                       <!--<td><?php echo $feel["name"]; ?></td>-->
                                       <td> <a data-toggle="modal" data-target="#editfeel_<?php echo $feel['id']; ?>" title="Edit Feeling" ><i class="fa fa-pencil-square-o left" aria-hidden="true"></i></a><?php echo $feel["name"]; ?> </td>
                                       <td><?php echo json_decode('"'.$feel["emojie"].'"'); ?></td>
                                       <td><div style="background-color:<?php echo json_decode('"'.$feel["color_code"].'"') ?>;  width:20px; height:20px;"></div></td>
                               <td><span class="badge badge-pill badge-info <?php echo $set_class; ?>"><?php echo $status;?></span></td>

                           </form>
                           <div id="editfeel_<?php  echo $feel['id']; ?>" class="modal fade" role="dialog">
                           <div class="modal-dialog">
                           }
                           ?>
                           <!--Modal content-->
                           <div class="modal-content" style="border:4px solid black;">
                           <form action="<?php echo base_url(); ?>admin/mainfeeling/editfeel" method="post">
                           <div class="modal-header">
                           <h4 class="modal-title">Edit feeling</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <div class="modal-body">
                           <input type="hidden" name="feelId" id="feelId" value="<?php echo $feel['id']; ?>">
                           <div class="form-group">
                           <label for="user_name">Feeling:</label>
                           <input type="text" name="feel" class="form-control" id="feel" value="<?php echo $feel['name'];?>">
                           </div>
                           <div class="form-group">
                           <label for="user_name">Emoji:</label>
                           <input type="text" name="emo" class="form-control" id="emo" value="<?php echo json_decode('"'.$feel['emojie'].'"');?>">
                            
                           </div>
                           <div class="form-group">
                           <label for="user_name">Color Code:</label>
                           <input type="color" name="cc" class="form-control" id="cc" value="<?php echo $feel['color_code'];?>">
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
   function tivate() {
       var select_id=$(".checkitem:checked").length;
             if(select_id==0)
             {
               alert("Please Select The CheckBox");
             }
             else
             {
               if(confirm("Are you sure you want to activate  "+select_id+" Feeling"))
               {
                 var yourArray=[];
                $(".checkitem:checked").each(function(){
                   yourArray.push($(this).val());
                 });
                
                  window.location=BASE_URL+"admin/mainfeeling/tivate/"+yourArray;  
               }
               else
               {
                 return  false;
               }
             }
       // alert('are you sure you want to activate the selected user');
     document.getElementById("status").value = "0";
     
     document.getElementById('formid').submit();
    
   }
   
   
   
   function detivate() {
       var selects_id=$(".checkitem:checked").length;
             if(selects_id==0)
             {
               alert("Please Select The CheckBox");
             }
             else
             {
               if(confirm("Are you sure you want to deactivate  "+selects_id+" Feeling"))
               {
                 var yourArray=[];
                $(".checkitem:checked").each(function(){
                   yourArray.push($(this).val());
                 });
                
                  window.location=BASE_URL+"admin/mainfeeling/detivate/"+yourArray;  
               }
               else
               {
                 return  false;
               }
             }
       // alert('are you sure you want to deactivate the selected user');
     document.getElementById("status").value = "1";
     document.getElementById('formid').submit();
   }
</script>