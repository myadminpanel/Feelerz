<div class="main-content small-gutter">
                <!-- START PAGE COVER -->
                <div class="row bg-title clearfix page-title">
                    <!--<div class="col-12 col-lg-3">
                        <h4 class="page-title">Manage Country</h4>
                    </div>-->
                    <div class="col-12 col-lg-9">
                        <!-- START breadcrumb -->
                        <ol class="breadcrumb pl-0 pr-0 float-lg-left">
                            <li><a href="<?php echo base_url().'admin'; ?>">User Dashboard</a></li>
                            <li class="active">Manage Country</li>
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
                                <h4 class="mt-0 box-title">Country List</h4>
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
                                       
                                            
                                           <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button sss">

                                                <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block plukit">
                           <!--  <select class="form-control"> 
                                <option value="please_select"> select option </option>
                                <option value="activate"> Activate </option>
                                <option value="deactivate"> Deactivate </option>
                                <option value="delete"> Delete </option>
                                <option value="message"> Message </option>
                            </select>
                            
                                <button id="get_ids_for_activate" class="btn btn-success ripple">
                                    <span>Apply</span>
                                </button>
 -->
                                               <button onclick="activa()" type="button" class="btn btn-info btn-raised ripple"  id="get_ids_for_ac">
                                    <span>Active</span>
                                </button>
                                <button onclick="deactiva()" type="button" class="btn btn-warning btn-raised ripple" id="get_ids_for_deac">
                                    <span>Deactive</span>
                                </button>



												<!-- <button class="btn btn-info btn-raised ripple" data-toggle="modal" data-target="#addcountry_"><span>Add Country</span></button> -->

                                                <!--<button data-toggle="modal" data-target="#addcountry" class="btn btn-info btn-raised ripple">-->
                                                <!--    <span>Add Country</span>-->
                                                <!--</button>-->

                                                    
<!--                                                        <div id="addcountry" class="modal fade" role="dialog">-->
<!--  <div class="modal-dialog">-->

    <!-- Modal content-->
<!--    <div class="modal-content">-->
<!--<form action="<?php echo base_url(); ?>admin/country/add_country" method="post">-->
<!--      <div class="modal-header">-->
        
<!--        <h4 class="modal-title">Add Country</h4>-->
<!--        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
       
        
  <!--<div class="form-group">-->
  <!--   <label for="country_sortname">Sort Name:</label>-->
  <!--  <input type="text" name="sortname" class="form-control" id="" value="">-->
  <!--  </div>-->
<!--    <div class="form-group">-->
<!--    <label for="country_name">Country Name:</label>-->
<!--    <input type="text" name="country" class="form-control" id="" value="">-->
<!--  </div>-->
<!--  </div>-->
<!--      <div class="modal-footer">-->
<!--        <button type="submit" class="btn btn-default" >Submit</button>-->
<!--        </form>-->
<!--      </div>-->
<!--    </div>-->

<!--  </div>-->
</div>
                                                     













												
												
                                            </div>
                                        </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive sanjeev-table">
                                                <form id="form-id" action="<?php echo base_url(); ?>admin/country/updatecountrystatus" method="post">
                <input type="hidden" name="cstatus" id="cstatus">
                
                                                <table id="example2" class="table table-striped table-bordered data-table table-checkable mb-0 kkk" role="grid">
                                                    <thead>
                                                    <tr>
                                                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1">
                                                            <div class="form-check">
                                                                <div class="custom-control custom-checkbox" style="float:left;">
     <input type="checkbox" class="custom-control-input" name="cehck[]" id="checkall">
                                                                    <label class="custom-control-label" for="checkall"></label>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending">-->
                                                        <!--    id-->
                                                        <!--</th>-->
                                                        
                                                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" name="cc">Country Code
                                                        </th>
                                                        
														<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" name="co">country
                                                        </th>
                                                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" name="s">
                                                            Status
                                                        </th>

                                                        <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">-->
                                                        <!--    Action-->
                                                        <!--</th>-->
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php 
                                                       $sno=0;
                                                        foreach($list as $listdata){ ?>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <div class="custom-control custom-checkbox custom-checkbox-primary">
                                                                    <input type="checkbox" name="same1[]" class="custom-control-input checkitem" value="<?php echo $listdata['id']; ?> " id="tableCheckbox2_<?php echo $listdata['id']; ?>">
                                                                    <label class="custom-control-label" for="tableCheckbox2_<?php echo $listdata['id']; ?>"></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <!--<td><?php echo ++$sno; ?></td>-->
                                                        <td><?php echo $listdata['country_code']; ?></td>
														<td><?php echo $listdata['name']; ?></td>

                                                        <td> <?php 
                                                        if($listdata['status']==1){ ?>
                                                            <span class="badge badge-pill badge-info ">Active</span>
                                                     <?php  }else{ ?> 
                       <span class="badge badge-pill btn btn-warning ">Deactive</span>
                        <?php }


                        ?>
                        </td>
                        <!--<td><button data-toggle="modal" data-target="#editcountry_<?php echo $listdata['id']; ?>" class="btn btn-info btn-raised ripple">-->
                        <!--                            <span><i class="fa fa-pencil-square-o left" aria-hidden="true"></i></span>-->
                        <!--                        </button>-->
                        <!--                       <a class="btn btn-danger get_ids_for_delete" href="<?php echo base_url() ?>admin/country/del/<?php echo $listdata['id'] ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>-->
                        <!--                   </td>-->

                                                    </tr> 


<!--<div id="editcountry_<?php  echo $listdata['id']; ?>" class="modal fade" role="dialog">-->
<!--  <div class="modal-dialog">-->

    <!-- Modal content-->
<!--    <div class="modal-content">-->
<!--<form action="<?php echo base_url(); ?>admin/country/edit_country" method="post">-->
<!--      <div class="modal-header">-->
        
<!--        <h4 class="modal-title">Edit Country</h4>-->
<!--        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--       <input type="hidden" name="countryId" value="<?php echo $listdata['id']; ?>">-->
        
<!--  <div class="form-group">-->
<!--    <label for="country_name">Country Name:</label>-->
<!--    <input type="text" name="countryName" class="form-control" id="" value="<?php echo $listdata['name'];?>">-->
<!--  </div>-->
<!--  </div>-->
<!--      <div class="modal-footer">-->
<!--        <button type="submit" class="btn btn-default" >Submit</button>-->
<!--        </form>-->
<!--      </div>-->
<!--    </div>-->

<!--  </div>-->
<!--</div>-->
                                                     <?php } ?>
                                                 
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


<script>
function activa() {
    var select_id=$(".checkitem:checked").length;
          if(select_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to activate  "+select_id+" Country"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
               window.location=BASE_URL+"admin/country/activa/"+yourArray;  
            }
            else
            {
              return  false;
            }
          }
    // alert('are you sure you want to activate the selected countries');
  document.getElementById("cstatus").value = "0";
  
  document.getElementById('form-id').submit();
 
}



function deactiva() {
    
    var selects_id=$(".checkitem:checked").length;
          if(selects_id==0)
          {
            alert("Please Select The CheckBox");
          }
          else
          {
            if(confirm("Are you sure you want to deactivate  "+selects_id+" Country"))
            {
              var yourArray=[];
             $(".checkitem:checked").each(function(){
                yourArray.push($(this).val());
              });
             
               window.location=BASE_URL+"admin/country/deactiva/"+yourArray;  
            }
            else
            {
              return  false;
            }
          }
          
    // alert('are you sure you want to deactivate the selected countries');
  document.getElementById("cstatus").value = "1";
  document.getElementById('form-id').submit();
}
</script>