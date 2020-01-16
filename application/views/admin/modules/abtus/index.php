<?php 


$query = $this->db->query("SELECT * FROM about_us")->row_array();
				   	// 	var_dump($query);
				   ?>












<div class="main-content small-gutter">       <!-- START PAGE COVER -->      <div class="row bg-title clearfix page-title">      <!--<div class="col-12 col-lg-3">         <h4 class="page-title">About Us</h4>      </div>-->      <div class="col-12 col-lg-9">                   <!-- START breadcrumb -->                  <ol class="breadcrumb pl-0 pr-0 float-lg-left">            <li><a href="<?php echo base_url().'admin'; ?>">User Dashboard</a></li>            <li class="active">About Us</li>         </ol>                  <!-- END breadcrum -->                </div>   </div>      <!-- END PAGE COVER -->      <div class="container-fluid">      <div class="row">         <div class="col-lg-12 col-xl-12 mb-2">            <div class="bg-white padding-25 h-100">               <h4 class="mt-0 box-title">About Us</h4>               <div class="data-table-wrapper">                  <div class="row">                      <div class="col-sm-12 col-lg-4 col-xl-4"> </div>                     <div class="col-sm-12">&nbsp;</div>                     <div class="col-sm-12">                        <!--<h4>Why do we use Lorem Ipsum?</h4>                        <p//php echo $policydata['privacy_policy_content']; ?></p>-->


<form action="<?php echo base_url(); ?>admin/about/update_about" method="post">
    <input type="hidden" name="aboutId" value="<?php echo $query['id']; ?>" >

<textarea name="aboutName" id="ckeditor" ><?php echo $query['about_us_content'];?></textarea>


<button class="btn btn-info btn-raised ripple">							<span>Update</span>						</button>      </form>  </div>                  </div>               </div>            </div>         </div>             </div>   </div></div>

 









