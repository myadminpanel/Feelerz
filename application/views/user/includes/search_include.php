<div class="search-area location-search" id="mobile_only_nav">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<div class="search-box">

					<form class="search_form" action="<?php echo base_url()."search"; ?>" method="post">

						 	<span class="search-input">

						 	<input type="hidden" name="selected_category" id="selected_category" value="">

						<?php 			 									 

						if((!isset($searched_value)))

						{							

							 $searched_value = ''; 							 

						}

						if(isset($searched_value)&&$searched_value==0)

						{							

							 $searched_value = ''; 							 

						}

						if(!isset($selected_category_value)){ $selected_category_value = ''; } 					
						$common_search = (!empty($_POST['common_search']))?$_POST['common_search']:''; 
						 ?>

						 	<input class="text" name="common_search" id="common_search" type="text" value="<?php echo (!empty($searched_value))?$searched_value:$common_search; ?>" placeholder="Search"/>



						 	</span>

						 	<span class="search-category">

						 		<select class="select" id="changecatetext" name="search_category">

								<option value="">All Categories</option>

								<?php 

																                                                                                   

								foreach($categories_subcategories as $cat)

								{ 

									if($cat['parent']==0)

									{

										$query  = $this->db->query("SELECT `CATID` , `name` FROM `categories` WHERE `parent` = ". $cat['CATID']." and status=0 and delete_sts = 0");

										$result = $query->result_array(); 

										$result_count = $query->num_rows();

									?>

									<option class="category_main_menu" value="<?php echo $cat['CATID']; ?>" 

									<?php if($cat['CATID']==$selected_category_value){ echo "selected";} ?> > <?php echo $cat['name']; ?> </option>    

									<?php 

										if($result_count>0)

										{

											foreach($result as $sub_category_list)

											{ ?>

												<option class="sub_category_menu" value="<?php echo $sub_category_list['CATID']; ?>"

                                       <?php if($sub_category_list['CATID']==$selected_category_value){ echo "selected";} ?>> <?php echo $sub_category_list['name']; ?> </option>    

									<?php   }

										}

									}

								}

								?>

							</select>

						 	</span>

						 	

						 	<div class="search-country">

								<select class="country select form-control" id="country" onchange="country_id_chnage(this)" name="change_country">

									<option value="">--Country--</option>

					<?php 

					if(!empty($gigs_country)){

						foreach($gigs_country as $country){
							$selected = '';
							if(!empty($gigs_country_id)){
								$selected  = ($gigs_country_id==$country['id'])?'selected':'';
							}
							echo '<option value="'.$country['id'].'" '.$selected.'>'.$country['country'].'</option>';
						}
					}
					?>
		</select>

						 	</div>

						 	<div class="search-state">

								<select class="state select form-control" id="search_state" name="state">

									<option value="">--State--</option>

									<?php 

									if(!empty($gigs_state)){

										foreach($gigs_state as $state){

											$selected  = ($gigs_state_id==$state['id'])?'selected':'';

											echo '<option value="'.$state['id'].'" '.$selected.' >'.$state['state'].'</option>';		

										}

									}

									?>

								</select>				 		

						 	</div>

						 	<span class="search-btn">

						 		<button type="submit" name="search_submit" value="search" class="btn btn-primary btn-block search_btn" >Search</button>	

						 	</span>

						

						

					</form>

				</div>

			</div>

		</div>

	</div>

</div>