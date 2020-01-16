<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Edit Policy</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<form id="admin_add_ip" action="<?php echo base_url().'admin/policy_settings/edit/'.$list['id']; ?>" method="post" >
							<div class="form-group">
								<label for="policy_name">Policy Name</label>
								<input type="text" name="policy_name" class="form-control" value="<?php echo $list['policy_name']; ?>" id="policy_name" required>
							</div>  
							<div class="form-group">
								<label for="policy_description">Policy Description</label>
								<input type="text" name="policy_description" value="<?php echo $list['policy_terms']; ?>" class="form-control" id="policy_description" required>
							</div>
					<?php	/* 	<div class="form-group">
								<label class="control-label">Status</label>
								<div>
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="blog_status1" value="0" name="status" <?php
										if ($list['status'] == 0) {
											echo 'checked=""';
										}
										?>>
										<label for="blog_status1">Active</label>
									</div>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="blog_status2" value="1" name="status" <?php
										if ($list['status'] == 1) {
											echo 'checked=""';
										}
										?>>
										<label for="blog_status2">Inactive</label>
									</div>
								</div>
							</div> */ ?>
							<div class="form-group m-b-0 m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/policy_settings' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>