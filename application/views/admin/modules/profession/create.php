<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h4 class="page-title m-b-20 m-t-0">Add Profession</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="card-box">
						<form id="admin_add_profession" action="<?php echo base_url().'admin/profession/create'; ?>" method="post" >
							<div class="profession form-group">
								<label for="profession"> Profession </label>
								<input type="text" name="profession"  placeholder="Profession..." class="form-control" id="profession" required>
							</div>
							<div class="text-center m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/profession' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>