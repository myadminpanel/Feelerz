 <div class="main-content small-gutter">
                <!-- START PAGE COVER -->
                <div class="row bg-title clearfix page-title">
                    <!--<div class="col-12 col-lg-3">
                        <h4 class="page-title">Manage Settings</h4>
                    </div>-->
                    <div class="col-12 col-lg-9">
                        <!-- START breadcrumb -->
                        <ol class="breadcrumb pl-0 pr-0 float-lg-left">
                            <li><a href="<?php echo base_url().'admin'; ?>">User Dashboard</a></li>
                            <li class="active">Manage Settings</li>
                        </ol>
                        <!-- END breadcrum -->
                    </div>
                    <!--<div class="col-12">
                        <h3>Form Layouts</h3>
                    </div>-->
                </div>
                <!-- END PAGE COVER -->
                <div class="container">
  <?php  if(@$this->session->flashdata("warning")) { ?>
<div class="alert alert-success" >
<?php echo $this->session->flashdata("warning"); ?>
</div>
<?php } ?>
<?php  if(@$this->session->flashdata("warni")) { ?>
<div class="alert alert-warning" >
<?php echo $this->session->flashdata("warni"); ?>
<?php } ?>

 <?php  if(@$this->session->flashdata("message")) { ?>
<div class="alert alert-success" >
<?php echo $this->session->flashdata("message"); ?>
</div>
<?php } ?>
<?php  if(@$this->session->flashdata("warn")) { ?>
<div class="alert alert-warning" >
<?php echo $this->session->flashdata("warn"); ?>
<?php } ?>
<?php  if(@$this->session->flashdata("wa")) { ?>
<div class="alert alert-warning" >
<?php echo $this->session->flashdata("wa"); ?>
<?php } ?>
<?php  if(@$this->session->flashdata("su")) { ?>
<div class="alert alert-success" >
<?php echo $this->session->flashdata("su"); ?>
<?php } ?>
</div>
                
                
                <div class="container-fluid">
                    <div class="row">
                        
						
					<div class="col-lg-12 col-xl-12 mb-2">
                            <div class="bg-white padding-25 h-100">
                                <h4 class="mt-0 box-title">Manage Settings</h4>
                                <div class="data-table-wrapper">
                                    <div class="row">
  <div class="col-lg-3"></div>
 <div class="col-md-12">
 	<h3 class="text-center">Update Account Settings</h3>
	<br>
	<div class="row sp-input">
	
	<!--<div class="col-md-4">	<div class="bg-light padding-25 h-100">		<h4 class="panel-title">Update Username</h4>		<div class="col-md-12">			<form action="" class="form-horizontal" method="POST">							  <div class="form-group">								<div class="row">								<div class="col-sm-12">									<label class="">Your User Name</label>									<input type="text" placeholder="Enter User Name" id="inputPassword2" class="form-control" value="" name="uname">								</div>								</div>							  </div>							<button type="submit" name="update_username" class="btn btn-primary btn-info">Update </button>						</form>						<form action="" class="form-horizontal" method="POST">							  <div class="form-group">							  <div class="row">								<div class="col-sm-12">									<label class="">Your Email id</label>&nbsp;&nbsp;&nbsp;&nbsp;									<input type="text" placeholder="Enter User Name" id="inputPassword2" class="form-control" value="" name="email">								</div>								</div>							  </div>							<button type="submit" name="update_email" class="btn btn-primary btn-info">Update </button>						</form>		</div>	</div>	</div>-->
	
	<div class="col-md-6">
	<div class="bg-light padding-25 h-100">
		<h4 class="panel-title">Update Password</h4>
		<div class="col-md-12">
			<form action="<?php echo base_url(); ?>admin/setting/change" class="form-horizontal" method="POST">
			    
						<div class="form-group">
							  <div class="row">
								<div class="col-sm-12">
									<label style="width:100%;">Old Password</label>
									<input type="password" style="width:100%;" placeholder="Enter Old Password" id="oldp" class="form-control" name="oldp">
								</div>
							  </div>
							  </div>
							  <div class="form-group">
							  <div class="row">
								<div class="col-sm-12">
									<label style="width:100%;">New Password</label>
									<input type="password" style="width:100%;" placeholder="Enter New Password" id="newp" class="form-control" name="newp">
								</div>
							  </div>
							  </div>
							  
							   <div class="form-group">
							  <div class="row">
								<div class="col-sm-12">
									<label style="width:100%;">New Password</label>
									<input type="password" style="width:100%;" placeholder="Confirm Password" id="conp" class="form-control" name="conp">
								</div>
							  </div>
							  </div>
							  <button type="submit" name="update_pass" class="btn btn-primary btn-info btn_sub">Update </button>
						</form>
		</div>
	</div>
	</div>
	
	
	<div class="col-md-6">
	<div class="bg-light padding-25 h-100">
		<h4 class="panel-title">Update Picture</h4>
		<div class="col-md-12">
		  <?php

        	$query1 = $this->db->query("select * from setting WHERE id = 1");
        	$result1 = $query1->row_array();
        	$this->profilepic = '';
        	 $fav1=base_url().'uploads';
        	if(!empty($result1))
        	{
        
        	if($result1['profilepic']){
            	$this->profilepic = $result1['profilepic'];
        	}
        		if($result1['profilepic']){
        			 $favicon1 = $result1['profilepic'];
        	
        	}
        	}
        	
        	if(!empty($favicon1))
        	{
             	$fav1 = base_url().'uploads/'.$favicon1;
              $fav1; 
             	
        	}
   ?>
			<form action="<?php echo base_url(); ?>admin/setting/upload" class="form-horizontal" method="POST" enctype="multipart/form-data">
					 
					    <div class="col-md-12"> 
						 <div class="form-control" style="width:100%; height:110px; margin-top:10px;">
					       <img id="img1" src="<?php echo $fav1; ?>" alt="" style="width:100%;height:100px;object-fit: cover;">
						</div>
					<label for="field1" class="form-control btn btn-default btn btn-primary btn-info" style="text-align:center; margin-top:5px;width:100%" id="image1">Upload picture</label>
					<input type="file" id="field1" class="form-control" name="img" style="visibility:hidden;" required  onchange="readURL(this);">
					<!--<?php echo $error; ?>-->
							<script>
								function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();

											reader.onload = function (e) {
												$('#img1')
													.attr('src', e.target.result)
													.width(351)
													.height(97);
											};

											reader.readAsDataURL(input.files[0]);
										}
									}
								</script>
								 <center> <button type="submit" name="update_pic" class="btn btn-primary btn-info">Update </button></center>
					  </div>
							  
							
						</form>
		</div>
	</div>
	</div>
			</div>
			
			
			<div class="row">&nbsp;</div>
			<!--<div class="row sp-input">-->
			            				             
			<!--       <div class="col-md-12">-->
			<!--		<form class="form-horizontal" action="seo-content.php" method="POST" enctype="multipart/form-data"> -->
			<!--               <div class="row">-->
			<!--			   <div class="col-md-6">	-->
			<!--			   <div class="form-group">-->
			<!--                  <label class="col-sm-12 control-label">Social Media Links</label>-->
			<!--                  <div class="col-sm-12">-->
			<!--					<button class="btn btn-facebook ripple" type="button" style="float: left;"> <i class="fa fa-facebook" aria-hidden="true"></i> </button>-->
			<!--                     <input type="text" class="form-control" id="mete_title" name="meta_title" value="" style="width: 92% !important;">-->
			<!--                  </div>-->
			<!--				  <div class="col-sm-12">-->
			<!--					<button class="btn btn-twitter ripple" type="button" style="float: left;"> <i class="fa fa-twitter" aria-hidden="true"></i> </button>-->
			<!--                     <input type="text" class="form-control" id="mete_title" name="meta_title" value="" style="width: 90% !important;">-->
			<!--                  </div>-->
			<!--               </div>-->
			<!--			   </div>-->
			<!--			   <div class="col-md-6">-->
			<!--			   <div class="form-group">-->
			<!--                  <label class="col-sm-12 control-label">&nbsp;</label>-->
			<!--                  <div class="col-sm-12">-->
			<!--					<button class="btn btn-googleplus ripple" type="button" style="float: left;"> <i class="fa fa-google-plus" aria-hidden="true"></i> </button>-->
			<!--                     <input type="text" class="form-control" id="mete_title" name="meta_title" value="" style="width: 90% !important;">-->
			<!--                  </div>-->
			<!--				  <div class="col-sm-12">-->
			<!--					<button class="btn btn-linkedin ripple" type="button" style="float: left;"> <i class="fa fa-linkedin" aria-hidden="true"></i> </button>-->
			<!--                     <input type="text" class="form-control" id="mete_title" name="meta_title" value="" style="width: 90% !important;">-->
			<!--                  </div>-->
			<!--               </div>-->
			<!--               <button name="form_submit" type="submit" class="btn btn-primary center-block btn-info" value="true">Save Changes</button>-->
			<!--			   </div>-->
							
			               
			<!--			   </div>-->
			<!--            </form>-->
			<!--	   </div>-->
			           
			<!--</div>-->
			</div>
		</div>
                                </div>
                            </div>
                        </div>
						
						
						
						
                      
						
                    </div>
                </div>
            </div>