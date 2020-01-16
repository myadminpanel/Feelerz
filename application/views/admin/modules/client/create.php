<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Add Client</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<form id="admin_add_client" action="<?php echo base_url().'admin/client/create'; ?>" method="post" enctype= "multipart/form-data" >
							<div class="form-group">
								<label for="ip_addr">Client Name</label>
								<input type="text" name="client_name" placeholder="Dreamguys Technologies" class="form-control" id="client_name" required>
							</div>
							<div class="form-group">
								<label for="client_image">Client Image</label>
								<input type="file" name="client_image" class="form-control" id="client_image" required>
								<span class="help-block"><small>Recommended image size is <b>170px x 90px</b></small></span>
							</div>
							<div class="form-group">
								<label class="control-label">Status</label>
								<div>
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="blog_status1" value="0" name="status" checked>
										<label for="blog_status1">Active</label>
									</div>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="blog_status2" value="1" name="status">
										<label for="blog_status2">Inactive</label>
									</div>
								</div>
							</div>
							<div class="form-group m-b-0 m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/client' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>