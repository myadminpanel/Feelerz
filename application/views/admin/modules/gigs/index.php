<div class="content-page">

	<div class="content">

		<div class="container">

			<div class="row">

				<div class="col-sm-12">
							<?php  if($this->session->flashdata('message')){ ?>
						<p class="bg-success"><?php echo $this->session->flashdata('message'); ?></p>
						<?php } ?>
					<h4 class="page-title m-b-20 m-t-0">Manage Gigs</h4>

				</div>

			</div>

             <div class="row">

				<div class="col-lg-12">

					<div class="card-box">

						<div class="table-responsive">

							<table class="table table-actions-bar datatable table-striped"> 

								<thead>

									<tr>

										<th>#</th>                                                  

										<th>Gigs</th>

										<th>Category</th> 			                                        

										<th>Posted User</th>

										<th>Price</th>                                                 

										<th>Status</th>

										<th>Created Date</th>

										<th class="text-right">Action</th>

									</tr>

								</thead>

								<tbody>

									<?php 

									 if(!empty($list)) 

									{

									$i=1;

									$admin_country_name = $this->session->userdata('admin_country_name');

									$doller_rate 		= $this->session->userdata('dollar_rate');

									$rupee_rate         = $this->session->userdata('rupee_rate');

									if(	$doller_rate !=0)

									{	

									$doller_rate 		= ($gig_price['value'] / $doller_rate );

									}		

									

									foreach($list as $item) { 



										 $status = 'Active'; if($item['status']==1){$status = 'Inactive';}    
                   						 $image = base_url()."assets/images/gig-small.jpg";  
										 if(!empty($item['gig_image']) && $item['gig_image']!='noimage.jpg')
										 {
											$image = base_url().$item['gig_image'];
										}
										//$rate = $gig_price['value']; // Fixed Price 
										$rate = $item['gig_price']; // Dynamic Price 
										$currency = (!empty($item['currency_type']))?$item['currency_type']:'USD';

										$sign = currency_sign($currency);
										
										/*switch ($currency) {
												case 'USD':
													$sign ='';
													break;
												case 'EUR':
													$sign ='€';
													break;
												case 'GBP':
													$sign ='£';
													break;
												default:
													$sign ='$';
													break;
											}*/	


										?>

									<tr>

										<td><?php echo $i; ?></td>                                                    

										<td>

											<span class="gig-img"><img alt="<?php echo $item['title']; ?>" src="<?php echo $image; ?>"></span>
										<?php /*if ($item['status'] == 0) { ?>

											<h2 class="text-ellipsis"><a href="<?php echo base_url()."gig-preview/".$item['title']; ?>" target="_blank" ><?php echo ucfirst(str_replace('-',' ',$item['title'])); ?></a></h2>
										<?php }else{*/ ?>
											<h2 class="text-ellipsis"><a href="<?php echo base_url()."admin/gigs/gig_preview/".md5($item['gig_id']); ?>" target="_blank" ><?php echo ucfirst(str_replace('-',' ',$item['title'])); ?></a></h2>
										<?php // } ?>	

										</td>

										<td><?php echo $item['category_name']; ?></td>

										<td><?php echo $item['fullname']; ?></td>

										<td><?php echo $sign.$rate; ?></td>

										<td id="change_staus_<?php echo $item['gig_id']; ?>"><?php echo $status; ?></td>

										<td><?php echo date('d M Y', strtotime(str_replace('-','/', $item['created_date']))); ?></td>

										<td class="toogle_switch text-right">

										<?php $status = ''; if ($item['status'] == 0) {  $status = 'checked="checked"'; } 

										$new='';										

										if($this->session->userdata('id') != 1)

										{

										 // $new ='disabled'; // Only enable demo users 			   

										}

										?>

											<input type="checkbox" <?php echo  $new; ?> <?php echo $status; ?>  class="alert-status switch" id="<?php echo $item['gig_id']; ?>" data-size="normal" name="my-checkbox" data-on-text="on" data-off-text="off">
											<a href="javascript:void(0)" onclick="admin_delete_gigs(<?php echo $item['gig_id']; ?>)" class="table-action-btn" title="Delete"><i class="mdi mdi-window-close text-danger"></i></a> 

										</td>

									</tr>

									<?php $i = $i+1; } } else { ?>

									<tr>

										<td colspan="10"><p class="text-danger text-center m-b-0">No Records Found</p></td>

									</tr>

									<?php } ?>

								</tbody>

							</table>

							<?php echo $links; ?>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<script type="text/javascript">
		var BASE_URL = "<?php echo base_url(); ?>";
		function admin_delete_gigs(id) {
			if(confirm("Are you sure you want ot delete this Gig?")){
				$.post(BASE_URL+'admin/admin_delete_gigs',{id:id},function(result){
					if(result){
						 location.reload();
					}
				});
			
			}	
		}

</script>