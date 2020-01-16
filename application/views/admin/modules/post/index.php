<div class="main-content small-gutter"> 
   <!-- START PAGE COVER -->
   <div class="row bg-title clearfix page-title">
      <!--<div class="col-12 col-lg-3">
         <h4 class="page-title">Manage Post</h4>
      </div>-->
      <div class="col-12 col-lg-9"> 
         <!-- START breadcrumb -->
         <ol class="breadcrumb pl-0 pr-0 float-lg-left">
            <li><a href="<?php echo base_url().'admin'; ?>">User Dashboard</a></li>
            <li class="active">Manage Post</li>
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
               <h4 class="mt-0 box-title">Post List</h4>
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
                        <!--<button id="for_post" class="btn btn-danger btn-raised ripple"> <span>Delete Post</span> </button>-->
                     <!--</div>-->
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="table-responsive sanjeev-table">
                           <table id="" class="table table-striped table-bordered data-table table-checkable mb-0" role="grid">
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
                               <?php 
                //  var_dump($list);
                
                    foreach($list as $user) { 
                        
                        
                // $query=$this->db->query("SELECT * FROM users WHERE id='".$user['user_id']."' ORDER BY id DESC ")->row_array();
                // var_dump($user['post_id']);
                     
                   
                    
                    ?>
  <tbody style="background-color: #fff;">
 
    
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
                 
                 <h3> <img src="http://feelerzapp.com/social_media/assets/profile_img/<?php echo $user['profileimage'];?>" alt="" /><?php echo json_decode('"'.$user['name'].'"'); ?>
                  <span style="margin-top: 0px;"><?php echo $user['date_time']; ?><i class="fa fa-globe"></i></span> </h3>
                 <span> <a href="<?php echo base_url() ?>admin/post/d/<?php echo $user['post_id'] ?>" id="for_post" onclick="return confirm('Are you sure you want to delete this post?');" class="btn btn-danger btn-raised ripple sssde"> Delete Post</a></span>
                 <div class="window"><span></span></div>
              </div>
      
       <!--
          <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button sss">-->
          <!--<button id="for_post" class="btn btn-danger btn-raised ripple"> <span>Delete Post</span> </button>-->
          <!--<span> <a href="<?php echo base_url() ?>admin/post/d/<?php echo $user['id'] ?>" id="for_post" onclick="return confirm('Are you sure you want to delete this post?');" class="btn btn-danger btn-raised ripple sssde"> Delete Post</a>-->
       <!--   </span>-->
       <!--</div>-->
                                          
       <div class="box-content">
         <div class="content">
             <?php if($user['feeling']!=''){  ?>
            <p><?php echo json_decode('"'.$user["feeling"].'"');?></p>
          <?php } ?>
           <?php if($user['post_text']!=''){  ?>
            <p><?php echo json_decode ('"'.$user["post_text"].'"');?></p>
           <?php } ?>
           <?php if($user['image']!=''){  ?>
              <div class="img sam2"><img src="http://feelerzapp.com/social_media/assets/post/<?php echo $user['image']; ?>" ></div>
           <!--<img src="http://digimonk.net/social_media/assets/profile_img/<?php echo $query['profileimage'];?>" alt="" /><?php echo $user['name'];?>--> 
                                             
             <?php } ?>
                                              
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
               <div class="box-buttons">
                  <div class="row">
                      
                     <button><span style="color:red;" class="fa fa-heart" ></span> &nbsp; <span style="color:red;"> <?php echo $user['total_hug']; ?> </span></button>
                     <button><span style="font-size:24px;color:gray;" class="fa fa-comments-o" ></span> &nbsp; <span style="color:red;"> <?php echo $user['comments']; ?> </span> </button>
                     <button><span class="fa fa-refresh"> &nbsp; <?php echo $user['total_share']; ?></span></button>
                  </div>
               </div>
                                       
                 <!--<div class="box-click"><span><i class="fa fa-comments-o"></i> View 140 more comments</span></div>-->
                                       
             <div class="box-comments"> 
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
                                       </div>
                                       </div>
                                       </td>
                                 </tr>
                                
                              </tbody>
                              <?php } ?>
                               
                           </table>
                           
                        </div>
                     </div>
                  </div>
                  <div class="row">&nbsp;</div>
               </div>
            </div>
         </div>
      </div>
   
   <div id="pagination">


<!-- Show pagination links -->
<?php  
echo  $links;
 ?>
</div>
   
</div