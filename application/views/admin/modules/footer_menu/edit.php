<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h4 class="page-title m-b-20 m-t-0">Footer Widget Edit</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="card-box">                        
                        <?php 
                        foreach($datalist as $value)
                        {
                        ?>
                        <form action="<?php echo base_url('admin/footer_menu/edit/'.$value['id']); ?>" method="POST" enctype="multipart/form-data" >
							<div class="form-group">
								<label>Widget Name</label>
								<input type="text" class="form-control" name="menu_name" id="menu_name" value="<?php if($value['title'])echo str_replace('_',' ',$value['title']) ?>"> 
							</div>
						<?php 	/* <div class="form-group" >
								<label class="col-sm-3 control-label">Display Status</label>
								<div class="col-sm-9">
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="academy_status1" value="1" name="status" <?php
													if ($value['status'] == 1) {
														echo 'checked=""';
													}
													?>>
										<label for="academy_status1">Active</label>
									</div>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="academy_status2" value="0" name="status" <?php
													if ($value['status'] == 0) {
														echo 'checked=""';
													}
													?>>
										<label for="academy_status2">Inactive</label>
									</div>
								</div>
							</div> */ ?>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary" value="true">Save Changes</button>
							</div>     
						</form>     
                        <?php } ?>  
                    </div>
                </div>
			</div>
        </div>
    </div>
</div>