 <section class="search-area">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="search-box">
								<form onsubmit="return form_submit();" action="<?php echo base_url()."search"; ?>" method="post">
                                     <input type="hidden" name="selected_category" id="selected_category" value="">
                                    <span class="search-input"><input class="text" name="common_search" id="common_search" type="text" 
                                    value="<?php if(!empty($searched_value)){ echo $searched_value; } ?>"
                                     placeholder="Search"/></span>
									<span class="search-category">
										<select class="selected_category" id="changecatetext" name="search_category">
                                            <option value="">All Categories</option>
                                            <?php                                                                                     
                                            foreach($categories_subcategories as $cat)
                                            {?>
                                            <option value="<?php echo $cat['CATID']; ?>"> <?php echo $cat['name']; ?> </option>    
                                            <?php }
                                            ?>
										</select>
									</span>
                                    <span class="search-btn">
										<button type="submit" name="search_submit" value="search" class="btn btn-primary" >Search</button>
									</span>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>


			<section class="profile-section">
				<div class="container">
					<div class="row">	
						<div class="col-md-12">
							<ol class="breadcrumb menu-breadcrumb">
								<li><a href="#">Home</a> <i class="fa fa fa-chevron-right"></i></li>
								<li class="active">My Profile</li>        
							</ol>
						</div>
					</div>
					
				</div>
			</section>
			<div class="tab-section">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="tab-list">
								<ul>
									<li class="active"><a href="javascript:;">Change Password</a></li>
									
								</ul>    
							</div>		
						</div>
					</div>
				</div>
			</div>
			<div class="tab-content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
                          <form id="password_form" action="<?php echo base_url().'dashboard/change_password'; ?>" method="POST">
							<div class="row">
								<div class="col-md-9">
												<div class="form-group">
													<div class="row">
														<div class="col-md-12">
															<label>New password</label>
                                                             <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Enter new password">
														</div>

														<div class="col-md-12">
															<label>Repeat password</label>
                                                            <input type="password" name="repeat_password" id="repeat_password" class="form-control" placeholder="Repeat new password">
														</div>
													</div>
												</div>
						                        <div class="text-right">
										<div class="row">
                                            <div class="col-lg-3"><button name="form_submit" class="btn btn-primary btn-block" value="true" type="submit">Save</button></div>
										</div>
									</div>
					                        
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>
		 