<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Add Policy</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<form id="admin_add_ip" action="<?php echo base_url().'admin/policy_settings/create'; ?>" method="post" >
							<div class="form-group">
								<label for="policy_name">Policy Name</label>
								<input type="text" name="policy_name" class="form-control" id="policy_name" required>
							</div>  
							<div class="form-group">
								<label for="policy_description">Policy Description</label>
								<input type="text" name="policy_description" class="form-control" id="policy_description" maxlength="30" required>
							</div>
							<div class="form-group m-b-0 m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/policy_settings' ?>"  class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div>