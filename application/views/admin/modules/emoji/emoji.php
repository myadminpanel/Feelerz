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
                            <li class="active">Manage Sub Feelings</li>
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
                        
                        
              <!--<div class="col-lg-12 col-xl-12 mb-2">-->
              <!--     <div class="bg-white padding-25 h-100">-->
              <!--      <h4 class="mt-0 box-title">Feeling List</h4>-->
              <!--     <div class="data-table-wrapper">-->
              <!--    <div class="row">-->
              <!--  <div class="col-sm-12 col-lg-4 col-xl-6">-->
              <!--  <div class="data-table-filter mb-2 float-sm-left float-lg-none d-lg-inline-block">-->
              <!--  <label for="search1">Search:</label>-->
              <!--   <input type="search" class="form-control" id="search1">-->
              <!--  </div>-->
                </div>
                <!--<div class="col-sm-12 col-lg-4 col-xl-4">-->
                <!--    <div class="data-table-length">-->
                <!--        <label>-->
                <!--            Show-->
                <!--            <select aria-controls="example" class="form-control">-->
                <!--                <option value="10">10</option>-->
                <!--                <option value="25">25</option>-->
                <!--                <option value="50">50</option>-->
                <!--                <option value="100">100</option>-->
                <!--            </select>-->
                <!--            entries-->
                <!--        </label>-->
                <!--    </div>-->
                <!--</div>-->
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
                                        
                                        
                 <div class="col-sm-12 col-lg-4 col-xl-12 text-md-right">
                  <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button sss">
                     <button onclick="deleteAllFeel()" type="button" class="btn btn-danger btn-raised ripple" id="acti">  <span>Delete</span>
                     </button>
                      <button class="btn btn-info btn-raised ripple" data-toggle="modal" data-target="#addemoji"> <span>Add Sub-Feeling</span>
                      </button>
                      <button onclick="status_active()" type="button" class="btn btn-info btn-raised ripple"  id="acti">
                        <span>Active</span>
                        </button>
                        <button onclick="detivate()" type="button" class="btn btn-warning btn-raised ripple" id="deacti">
                        <span>Deactive</span>
                        </button>

                     <!-- Trigger the modal with a button -->
                    </div>
                  </div>
              </div>





   <div class="row">
    <div class="col-md-12">
        <div class="table-responsive sanjeev-table">
          <form id="formid" action="<?php echo base_url(); ?>admin/emoji/updatestatu" method="post">
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
          <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending">  Sub Feeling  </th>
          <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">Parent Catagory </th>
          <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">-->
          <!--    Emoji icon-->
          <!--</th>                                                      -->
          <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">-->
          <!--    Emoji Status-->
          <!--</th>-->
          <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">  Color Code </th>
          <!-- <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">  Emoji  </th> -->

          <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">  Rating  </th>

          <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">  Status  </th>
                    
          <!-- <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">-->
          <!--    Count-->
          <!--</th>-->
                    
         <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">  Action </th>
                                    
                                   

                </tr>
             
              </thead>
              <tbody>
         <?php 
          if(!empty($list)) 
            {
                $k=array();
               $i=1;
            //  var_dump($list);
            foreach($list as $sub)
               {

                     // $status = 'Active'; if($sub['status']==0){$status = 'Inactive';} 

                     $status = 'Active'; $set_class='badge-primary'; if($sub['status']==0){$status = 'Deactive'; $set_class='badge-warning';
                      }

                     // $verified = 'Yes' ; if($sub['verified']==1){$verified = 'No';} 
                    if(!empty($feel['parent_name']))
                        { 
                            $parent_category = $sub['parent_name'];
                        }
                ?>
 
                                                    <tr>
                                        
                <td>
                  <div class="form-check">
                     <div class="custom-control custom-checkbox custom-checkbox-primary">
                        <input type="checkbox" name="ckval1[]" class="custom-control-input checkitem" value="<?php echo $sub['id']; ?>" id="tableCheckbox2_<?php echo $sub['id']; ?>">
                        <label class="custom-control-label" for="tableCheckbox2_<?php echo $sub['id']; ?>"></label>
                     </div>
                  </div>
               </td>
                                                        
                                                        
                            
                    <td><?php echo json_decode('"'.$sub["name"].'"'); ?></td>
                    <td><?php echo $sub["parrent"]; ?>
                    <!--<select id="select2" name="select2" class="form-control material-select" style="width:100%;">-->
                    <!--    <option value="">&nbsp;</option>-->
                    <!--    <option value="Smileys & People">Smileys & People</option>-->
                    <!--    <option value="Animals & Nature">Animals & Nature</option>-->
                    <!--    <option value="Food & Drink">Food & Drink</option>-->
                    <!--    <option value="Activity">Activity</option>-->
                    <!--    <option value="Travel & Places">Travel & Places</option>-->
                    <!--    <option value="Objects">Objects</option>-->
                    <!--    <option value="Symbols">Symbols</option>-->
                    <!--    <option value="Flags">Flags</option>-->
                       <!--</select>-->
                </td>
                <!--<td><span style="font-size: 24px;">☺</span></td>-->
                <!--<td><span class="badge badge-pill badge-info text-uppercase"><?php echo $status;?></span></td>-->
                <td><div style="background-color:<?php echo json_decode('"'.$sub["color_code"].'"') ?>;  width:20px; height:20px;"></div></td>
                <td><?php echo $sub["reating"]; ?></td>
                <!-- <td><?php echo json_decode('"'.$sub["emojie"].'"'); ?></td> -->

               <td><span class="badge badge-pill badge-info <?php echo $set_class; ?>"><?php echo $status;?></span></td> 

             </form>

              <!-- <td><?php // echo $sub["total"]; ?></td> -->

              <td><button data-toggle="modal" data-target="#editsubfeel_<?php echo $sub['id']; ?>" class="btn btn-info btn-raised ripple">
                  <span><i class="fa fa-pencil-square-o left" aria-hidden="true"></i></span>
                </button>
                                                
          <!--<button id="delete_sub" onclick="return confirm('Are you sure you want to delete this sub-feeling?');" class="btn btn-danger btn-raised ripple">-->
            <!--    <?php// $id=$sub['id']; ?>-->
          <!--  <a href="<?php echo base_url(); ?>admin/emoji/delete_subfeel/<?php echo $id;?>" >  <span style="color:#fff;"><i class="fa fa-trash" aria-hidden="true"></i></span></a>-->
                    <!--</button>-->
                                                
            <!--<button id="" class="btn btn-danger btn-raised ripple">-->
              <!--    <span><i class="fa fa-trash" aria-hidden="true"></i></span>-->
                      <!--</button>-->
    </td>
        </tr>
  <div id="editsubfeel_<?php  echo $sub['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog"> Modal content
    <div class="modal-content" style="border:4px solid black;">
     <form action="<?php echo base_url(); ?>admin/emoji/editsubfeel" method="post">
      <div class="modal-header">
          <h4 class="modal-title">Edit Sub-feeling</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <input type="hidden" name="subfeelId" id="subfeelId" value="<?php echo $sub['id']; ?>">
        
        <div class="form-group">
          <label for="user_name">Sub-Feeling:</label>
          <input type="text" name="subfeel" class="form-control" id="subfeel" value="<?php echo json_decode('"'.$sub["name"].'"'); ?>">
      </div>
        <div class="form-group">
            <label for="user_name">Parent category:</label>
            <!--<input type="text" name="patcat" class="form-control" id="patcat" value="<?php echo $sub['parrent'];?>">-->
           <select id="select2" name="patcat" class="form-control material-select" style="width:100%;" >
                <option><?php echo $sub['parrent'];?></option>
                                                                         
               <?php
               $con = $this->db->query(" SELECT * FROM `feeling` WHERE parrent=''")->result_array();
              //  var_dump($con);
              foreach($con as $row) {
               ?>
               
               <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
               <?php } ?>
              </select>
        </div>
          <div class="form-group">
              <label for="emoji">Emoji:</label>
              <input type="text" name="emo" class="form-control" id="emo" value="<?php echo json_decode('"'.$sub["emojie"].'"'); ?>" >
          </div>
          <div class="form-group">
              <label for="color_code">Color Code:</label>
              <input type="color" name="cc" class="form-control" id="cc" value="<?php echo $sub['color_code'];?>">
          </div>
         </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-default">Submit</button>
              
            </div>
    </form>
  </div>
  </div>
</div>

 



  <?php } } ?>
                                                    
                                                    </tbody>
                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                      
                        
                    </div>
                </div>
            </div>



<!-- Modal -->
<div id="addemoji" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="border:4px solid black;">
      <div class="modal-header">
          <h4 class="modal-title">Add Sub-Feeling</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
       

        <form action="<?php echo base_url(); ?>admin/emoji/add_subfeeling" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="">Sub Feeling</label>
    <input type="text" class="form-control" name="subfeel" id="" aria-describedby="emailHelp" placeholder="Sub Feeling" required>
     </div>
 
  <div class="form-group">
    <label for="exampleInputPassword1">Parent Catagory</label>
    <!--<input type="text" class="form-control" name="cat" id="" aria-describedby="emailHelp" placeholder="Parent category" required>-->
    <select id="select2" name="cat" class="form-control material-select" style="width:100%;"  required > 
    <option value="">Select Parent Category</option>
   <?php
     $con = $this->db->query(" SELECT * FROM `feeling` WHERE parrent = '' ")->result_array();
    //  var_dump($con);
    foreach($con as $row) {
     ?>
        <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
        <!--<option value="">Sad</option>-->
        <!--<option value="Animals & Nature">Mad</option>-->
        <!--<option value="Food & Drink">Happy</option>-->
        <!--<option value="Activity">Excited</option>-->
        <!--<option value="Travel & Places">Bored</option>-->
        <!--<option value="Objects">Objects</option>-->
        <!--<option value="Symbols">Symbols</option>-->
        <!--<option value="Flags">Flags</option>-->
        
        <?php } ?>
  </select>
                                                        
                                                        

    
  </div>
  
  <div class="form-group">
    <label for="emoji">Emoji</label>
    <input type="text" class="form-control" name="emo" id="" aria-describedby="emailHelp" placeholder="Emoji" required >
     </div>
     
     <div class="form-group">
    <label for="colorcode">Color Code</label>
    <input type="color" class="form-control" name="cc" id="" aria-describedby="emailHelp" placeholder="Color Code" required >

     </div>

<!--<div class="form-group">-->
<!--    <label for="">Emoji Icon</label>-->

    
    
<!--    <input type="file" name="emojiicon" id="fileToUpload">-->
    

    
<!--     </div>-->

  <!--<button type="submit" class="btn btn-primary">Submit</button>-->

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>


<script>
   function deleteAllFeel() {
       var select_id=$(".checkitem:checked").length;
             if(select_id==0)
             {
               alert("Please Select The CheckBox");
             }
             else
             {
               if(confirm("Are you sure you want to delete selected  "+select_id+" Feeling"))
               {
                 var yourArray=[];
                $(".checkitem:checked").each(function(){
                   yourArray.push($(this).val());
                 });
                 //alert(yourArray);
                 $.ajax({
                     method:"POST",
                     url:BASE_URL+"admin/emoji/delete_subfeel",
                     data:{"yourArray":yourArray},
                     dataType:"html",
                     success:function(data){
                      console.log(data);     
                      location.reload();
                     }
                 });
                
  
               }
               else
               {
                 return  false;
               }
             }
     document.getElementById("status").value = "0";
     
     document.getElementById('formid').submit();
    
   }

</script>

<script>
   function status_active() {
       var select_id=$(".checkitem:checked").length;
             if(select_id==0)
             {
               alert("Please Select The CheckBox");
             }
             else
             {
               if(confirm("Are you sure you want to activate  "+select_id+" Sub Feeling"))
               {
                 var yourArray=[];
                $(".checkitem:checked").each(function(){
                   yourArray.push($(this).val());
                 });
                
                  window.location=BASE_URL+"admin/emoji/tivate/"+yourArray;  
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
               if(confirm("Are you sure you want to deactivate  "+selects_id+" Sub Feeling"))
               {
                 var yourArray=[];
                $(".checkitem:checked").each(function(){
                   yourArray.push($(this).val());
                 });
                
                  window.location=BASE_URL+"admin/emoji/detivate/"+yourArray;  
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
 


