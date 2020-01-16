<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
					<?php if($this->session->flashdata('message')) { ?>
					<?php echo $this->session->userdata('message'); ?>
					<?php } ?>
                    <h4 class="page-title m-b-20 m-t-0">Seller Transaction Details</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                	<div class="card-box">
                		<?php 

                			$payment_id = (!empty($purchase_details['id']))?$purchase_details['id']:0;
                			$gigs_id = (!empty($purchase_details['gigs_id']))?$purchase_details['gigs_id']:0;
                			$title = '';
                			$sellername = '';
                			$buyername = '';
                			if(!empty($gigs_id)){

                				$query = $this->db->query("SELECT SG.title,M.fullname as sellername,M1.fullname as buyername FROM payments PY
									LEFT JOIN sell_gigs SG ON SG.id = PY.gigs_id
									LEFT JOIN members M ON M.USERID  = PY.seller_id
									LEFT JOIN members M1 ON M1.USERID  = PY.USERID
									WHERE PY.id = $gigs_id");
                				if($query->num_rows() > 0){
                					$records = $query->row_array();
                					$title = $records['title'];
                					$sellername = $records['sellername'];
                					$buyername = $records['buyername'];
                				}	
                			}

                		 ?>
						<form class="form-horizontal" id="bank_complete" action="" method="POST" >
							<div id="" class="tab-pane active">
								<div class="form-group">
									<label class="col-sm-3 control-label">Product Name</label>
									<div class="col-sm-9">
										<p><strong><?php echo $title; ?></strong></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Buyer</label>
									<div class="col-sm-9">
										<p><strong><?php echo $buyername; ?></strong></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Seller</label>
									<div class="col-sm-9">
										<p><strong><?php echo $sellername; ?></strong></p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Transaction ID</label>
									<div class="col-sm-9">
										<input type="hidden" name="id" value="<?php echo $payment_id; ?>" >
										<input type="hidden" name="payment_status" value="2" >
										<input type="text" id="stripe_refund" name="stripe_refund" value="" class="form-control" required >
									</div>
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
		
 