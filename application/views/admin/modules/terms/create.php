<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h4 class="page-title m-b-20 m-t-0">Create Terms</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card-box">
                        <form class="form-horizontal" id="add_submenu" action="<?php echo base_url('admin/dashboard/termcreate/'); ?>" method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label class="col-sm-3 control-label">Terms Title</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="sub_menu" id="sub_menu" value="">                             
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Terms Content</label>
								<div class="col-sm-9">
									<textarea class="form-control" name="page_desc" id="ck_editor_textarea_id"></textarea>
										<?php echo display_ckeditor($ckeditor_editor1);  ?>
								</div>
							</div>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>
							</div>
						</form>
                    </div>
                </div>
			</div>
        </div>        
    </div>
</div>