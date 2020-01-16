<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Edit User</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<form id="admin_add_cat" action="<?php echo base_url().'admin/user/edit_user/'.$list['USERID']; ?>" method="post"  enctype="multipart/form-data"  >
							<div class="form-group">
								<label for="user_fullname">Name</label>
								<input type="text" name="user_fullname" readonly placeholder="Enter Full name" value="<?php if(!empty($list['fullname'])){echo $list['fullname']; } ?>"  class="form-control" id="user_fullname">        
							</div>                        
							<div class="form-group">
								<label for="user_email">Email</label>
								<input type="text" name="user_email" placeholder="Enter Email" value="<?php if(!empty($list['email'])){echo $list['email']; } ?>"  class="form-control" id="user_email" readonly>
							</div>
							<div class="form-group">
								<label for="amount">Username</label>
								<input type="text" name="user_username" placeholder="Enter Username" value="<?php if(!empty($list['username'])){echo $list['username']; } ?>" class="form-control" id="user_username" readonly>
							</div>   
							<div class="form-group">
								<label for="blog_status1" class="control-label">Verified</label>
								<div>
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="blog_status1" value="0" name="user_verified" <?php
										if ($list['verified'] == 0) {
											echo 'checked=""';
										}
										?>>
										<label for="blog_status2">Active</label>
									</div>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="blog_status2" value="1" name="user_verified" <?php
										if ($list['verified'] == 1) {
											echo 'checked=""';
										}
										?>>
									<?php if ($list['verified'] == 1) { ?>
										<label for="user_verified">Inactive</label>
									<?php } ?>
										
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="blog_status3" class="control-label">Status</label>
								<div class="">
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="blog_status3" value="0" name="status" <?php
										if ($list['status'] == 0) {
											echo 'checked=""';
										}
										?>>
										<label for="blog_status4">Active</label>
									</div>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="blog_status4" value="1" name="status" <?php
										if ($list['status'] == 1) {
											echo 'checked=""';
										}
										?>>
										<label for="status">Inactive</label>
									</div>
								</div>
							</div>
							<div class="form-group m-b-0 m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/user' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>