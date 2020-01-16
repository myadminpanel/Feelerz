<!-- page content -->

<div class="main-content small-gutter"> 
   <!-- START PAGE COVER -->
   <div class="row bg-title clearfix page-title">
      <!--<div class="col-12 col-lg-3">
         <h4 class="page-title">Manage Reported Post</h4>
      </div>-->
      <div class="col-12 col-lg-9"> 
         <!-- START breadcrumb -->
         <ol class="breadcrumb pl-0 pr-0 float-lg-left">
            <li><a href="<?php echo base_url().'admin'; ?>">User Dashboard</a></li>
            <li class="active">Manage Reported Post</li>
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
               <h4 class="mt-0 box-title">Reported Post List</h4>
               <div class="data-table-wrapper">
                  <div class="row"> 
                     
                     <div class="col-sm-12 col-lg-4 col-xl-12 text-md-right">
                        <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button"> </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="table-responsive sanjeev-table">
                           <table id="example2" class="table table-striped table-bordered data-table table-checkable mb-0" role="grid">
                              <thead style="display:none;">
                                 <tr> 
                                    
                                    <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending">&nbsp;</th>
                                 </tr>
                              </thead>
                              <tbody style="background-color: #fff;">
                                 
                   
                              <?php 
                           
                              foreach($list as $repo) {  
                               
                              
                              ?>
             <tr style="background-color: #fff;"> 
               
          <td style="border: 1px solid #ffffff;"><div class="box update" style="margin: 0;">
                <div class="box-header">
                   <div class="text-left">
                      <h3> Reason for Report</h3>
                      <p><?php echo json_decode('"'.@$repo['reason'].'"'); ?></p>
                   </div>

                   <h3> <img src="http://feelerzapp.com/social_media/assets/profile_img/<?php echo $repo['profileimage'];?>" alt="" /><?php echo $repo['name'];?> 
                   <span style="margin-top: 0px;"><?php echo $repo['date']; ?>
                   <i class="fa fa-globe"></i></span> 
                 </h3>
                 <span> <a href="<?php echo base_url() ?>admin/managereported/de/<?php echo $repo['id'] ?>/<?php echo $repo['post_id'] ?>" id="for_deleted" onclick="return confirm('Are you sure you want to delete this post?');" class="btn btn-danger btn-raised ripple sssde"> Delete Post</a>
							<button class="btn btn-info btn-raised ripple" data-toggle="modal" data-target="#viewpost_<?php echo $repo['id']; ?>" data-whatever="@getbootstrap"><span>View Post</span></button>
                           </span>
                         <div class="window"> <span></span> </div>
                      </div>
                      
                   </div></td>
                                 
                   <div class="modal fade bd-example-modal-lg" id="viewpost_<?php echo $repo['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content" style="border:4px solid black;">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">View Post</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
											<div class="box-content">
                                             <div class="content">
                                                  <?php if($repo['post_text']!=''){
                                                      ?>
                                                <p> <?php echo json_decode('"'.$repo['post_text'].'"'); ?></p>
                                                <?php } ?>
                                                <!--<div class="img">-->
                                                <!--   <video controls="" width="100%">-->
                                                      <!--<source src="<?php base_url()?>../assets/videos/<?php echo $reportdata['video']; ?>" type="video/webm">-->
                                                <!--   </video>-->
                                                <!--</div>-->
                                                <!--<div class="img sam"><img src="http://digimonk.net/social_media/assets/post/<?php echo $repo['image'];?>>" ></div>-->
                                               <?php if($repo['image']!=''){
                                                      ?>
                                                <div class="img sam"><img src="http://feelerzapp.com/social_media/assets/post/<?php echo $repo['image']; ?>" style="width: 100%; height: 350px; margin-bottom: 50px;" ></div>                                            
                                             </div>
                                             <?php } ?>
                                          </div>
											</div>
                                        </div>
                                    </div>
                                </div>
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
<!-- /page content -->



<!-- /page content -->
<!--<div class="modal fade bd-example-modal-lg" id="viewpost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--                                    <div class="modal-dialog modal-lg" role="document">-->
<!--                                        <div class="modal-content">-->
<!--                                            <div class="modal-header">-->
<!--                                                <h5 class="modal-title" id="exampleModalLabel">View Post</h5>-->
<!--                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                                                    <span aria-hidden="true">&times;</span>-->
<!--                                                </button>-->
<!--                                            </div>-->
<!--                                            <div class="modal-body">-->
<!--                                                <input type="hidden" name="reportId" value="<?php echo $reportdata['id']; ?>">-->
<!--											<div class="box-content">-->
<!--                                             <div class="content">-->
<!--                                                <p> <?php echo $reportdata['description']; ?></p>-->
                                                <!--<div class="img">-->
                                                <!--   <video controls="" width="100%">-->
                                                <!--      <source src="<?php base_url()?>../assets/videos/<?php echo $reportdata['video']; ?>" type="video/webm">-->
                                                <!--   </video>-->
                                                <!--</div>-->
<!--                                                <div class="img sam"><img src="<?php base_url()?>../assets/images/<?php echo $reportdata['image']; ?>" ></div>-->
<!--                                             </div>-->
<!--                                          </div>-->
<!--											</div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->