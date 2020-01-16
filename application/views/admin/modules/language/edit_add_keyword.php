<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Edit Language</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<?php 
							$edit = $edit_lang_details;

						 ?>
						<form id="admin_edit_keyword" action="<?php echo base_url().'admin/language_management_controller/edit_add_keyword/'.$row['id']; ?>" method="post"  enctype="multipart/form-data"  >
							<div class="form-group">
								<label for="category_name">Language Key</label>
								<input type="hidden" name="edit_id" value="<?php echo $edit['sno']; ?>">
							<input type="text" name="lang_key" id="lang_key" class="form-control" value="<?php echo $edit['lang_key']; ?>" readonly >
							</div>
							<div class="form-group">
								<label for="category_name">Language Value</label>
							<input type="text" name="lang_value" id="lang_value" class="form-control" value="<?php echo $edit['lang_value'];?>">
							</div>							
							<div class="form-group m-b-0 m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/language_management_controller/add_keyword'?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>