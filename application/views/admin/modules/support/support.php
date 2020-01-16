<div class="main-content small-gutter"> 
   <!-- START PAGE COVER -->
   <div class="row bg-title clearfix page-title">
      <!--<div class="col-12 col-lg-3">
         <h4 class="page-title">Manage Support</h4>
      </div>-->
      <div class="col-12 col-lg-9"> 
         <!-- START breadcrumb -->
         <ol class="breadcrumb pl-0 pr-0 float-lg-left">
            <li><a href="<?php echo base_url().'admin'; ?>">User Dashboard</a></li>
            <li class="active">Manage Support</li>
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
               <h4 class="mt-0 box-title">Support List</h4>
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
                     
                     <!--<div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button sss">-->
                     <!--   <button id="for_post" class="btn btn-danger btn-raised ripple" data-toggle="modal" data-target="#for_post<?php echo $supp['id']; ?>"> <span>Trashed List</span> </button>-->
                     <!--</div>-->
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="table-responsive sanjeev-table">
                           <table id="example2" class="table table-striped table-bordered data-table table-checkable mb-0" role="grid">
                              <thead style="display:none;">
                                 <tr> 
                                    <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1">-->
                                    <!--                        <div class="form-check">-->
                                    <!--                            <div class="custom-control custom-checkbox">-->
                                    <!--                                <input type="checkbox" class="custom-control-input" id="checkall">-->
                                    <!--                                <label class="custom-control-label" for="checkall"></label>-->
                                    <!--                            </div>-->
                                    <!--                        </div>-->
                                    <!--                    </th>-->
                                    <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending">&nbsp;</th>
                                 </tr>
                              </thead>
                              <tbody style="background-color: #fff;">
                                 <?php 
                 
                    foreach($list as $supp) { 
                        
                        
                    //  $query=$this->db->query("SELECT * FROM post WHERE user_id='".$user['id']."'")->row_array();
                     
              
                    ?>
                     <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button sss">
                       
                     </div>
             <tr style="background-color: #fff;">
                <td style="border: 1px solid #ffffff;">
                <div class="box update" style="margin: 0;">
                      <div class="box-header">
                         <!--<div class="form-check" style="float:left;">-->
                         <!--   <div class="custom-control custom-checkbox custom-checkbox-primary">-->
                         <!--      <input type="checkbox" class="custom-control-input checkitem" name="same2[]" value="<?php echo $user['id']; ?>" id="tableCheckbox2_<?php echo $user['id']; ?>">-->
                         <!--      <input type="hidden" class="custom-control-input checkitem" name="same2[]" >-->
                         <!--      <label class="custom-control-label" for="tableCheckbox2_<?php echo $user['id']; ?>"></label>-->
                         <!--   </div>-->
                         <!--</div>-->
                         <h3> <img src="http://feelerzapp.com/social_media/assets/profile_img/<?php echo $supp['profileimage'];?>" alt="" /><?php echo $supp['name'];?> <span style="margin-top: 0px;"><i class="fa fa-globe"></i></span> </h3>
                         <!--<span> <a href="" id="for_resolve" class="btn btn-info btn-raised ripple sssde"> Resolve Now</a>-->
                          <span> <a href="<?php echo base_url() ?>admin/managesupport/resolve/<?php echo $supp['id'] ?>" id="for_resolve" onclick="return confirm('Are you sure you want to resolve this issue?');" class="btn btn-info btn-raised ripple sssde"> Resolve</a></span>
                         <div class="window"><span></span></div>
                      </div>
                      <div class="box-content">
                         <div class="content">
                            
                            <h6 style="text-align:left;margin-left:30px;"> Support Message</h3>
                             
                             <?php if($supp['support_msg']!='') { ?>
                               <p><?php echo json_decode('"'.$supp['support_msg'].'"'); ?></p>
                             <?php }  ?>

                            <h6 style="text-align:left;margin-left:30px;">Description</h3>
                              <?php if($supp['description']!='') { ?>
                            <p><?php echo json_decode('"'.$supp['description'].'"'); ?></p>
                          <?php } ?>
                            
                         </div>
                         </div>
                                          
                       </div>
                       <div class="box-likes"> 
                                          <!--<div class="row">--> 
                                          <!--  <span><a href="#"><img src="https://goo.gl/oM0Y8G" alt=""></a></span>--> 
                                          <!--  <span><a href="#"><img src="https://goo.gl/vswgSn" alt=""></a></span>--> 
                                          <!--  <span><a href="#"><img src="https://goo.gl/4W27eB" alt=""></a></span>--> 
                                          
                                          <!--</div>
                                          <div class="row"> <span><//?php echo $user['comments']; ?></span> </div>-->
                                       </div>
                                       <!--<div class="box-buttons">-->
                                       <!--   <div class="row">-->
                                              
                                       <!--      <button><span class="fa fa-heart"></span><?php echo $user['total_hug']; ?></button>-->
                                       <!--      <button><span class="fa fa-comments-o"></span><?php echo $user['comments']; ?></button>-->
                                       <!--      <button><span class="fa fa-share-alt"><?php echo $user['total_share']; ?></span></button>-->
                                       <!--   </div>-->
                                       <!--</div>-->
                                       
                                       <!--<div class="box-click"><span><i class="fa fa-comments-o"></i> View 140 more comments</span></div>-->
                                       
                                       <!--<div class="box-comments"> -->
                                          <!--<div class="comment"><img src="https://goo.gl/oM0Y8G" alt="">
                  <div class="content">
                    <h3><a href="">Emily Rudd</a><span><time> 1 hr - </time><a href="#">Like</a></span></h3>
                    <p>The nature is wonderfull, :D loll </p>
                  </div>
                </div>
                <div class="comment"><img src="https://goo.gl/vswgSn" alt="">
                  <div class="content">
                    <h3><a href="">barbara Palvin</a><span><time> 1 hr - </time><a href="#">Like</a></span></h3>
                    <p>The Image is awesome, &lt;3 Nice Photo</p>
                  </div>
                </div>--> 
                                       <!--</div>-->
                                       </div>
                                       </td>
                                 </tr>
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







