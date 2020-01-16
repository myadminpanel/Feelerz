<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');

class Twocheckout_payment extends CI_Controller {
    
    public function __construct() {

        parent::__construct();
	    $config = array();
	    $config['twocheckout_account']  = "901367160";
	    $config['twocheckout_username'] = "sivamanisandbox";
	    $config['twocheckout_password'] = "Siva@20174";
	    $this->load->library('twocheckout',$config);
    }
    public function index() { 


    	   $input_data = $_POST;
    	   echo "<pre>";
    	   print_r($input_data);
    	   exit;
    	   $from_timezone = $this->session->userdata('time_zone');
		   date_default_timezone_set($from_timezone); 
		   $current_time 	= date('Y-m-d H:i:s');
		   $currency_type 	= 1 ;
		   $data['USERID']    = $this->session->userdata('SESSION_USER_ID');
		   $data['time_zone'] = $this->session->userdata('time_zone');
		   $extra_gig_required_days=(int) $input_data['total_delivery_days'];
		   $gigs_id 			   = $input_data['gigs_id'];

		   $query = $this->db->query("SELECT id,user_id as seller_id,title,gig_price,delivering_time as total_days,super_fast_charges,super_fast_delivery,super_fast_delivery_date as super_fast_days FROM sell_gigs WHERE id = $gigs_id ");
		   $gigs_details  = $query->row_array();

		   $data['gigs_id']        = $gigs_id;
		   $data['seller_id']      = $gigs_details['seller_id'];
		   $item_amount    		   = $gigs_details['gig_price'];
		   $extra_gig_row_id	   = ($input_data['extra_gig_row_id'] !='""')?$input_data['extra_gig_row_id']:'';

		   $extr_days 			   = 0; 
		   $extr_price 			   = 0; 

		   if(!empty($extra_gig_row_id)){
		   		
		   		$request_extra = trim($extra_gig_row_id);
		   		$request_extra = explode(',', $request_extra);
		   		if(!empty($request_extra)){
		   			$query 			  = $this->db->query("SELECT options FROM user_required_extra_gigs where gig_id = $gigs_id and id in (".implode(',',$request_extra).")");
		   			$options_details  = $query->result_array();
		   			if(!empty($options_details)){
		   				foreach ($options_details as $value) {
		   					$days = explode('___', $value['options']);
		   					$extr_days += end($days);
		   					$extr_price += $days[2];
		   				}
		   			}
		   		}
		   }

		   $data['extra_gig_dollar'] = $extr_price;
		   if(!empty($extra_gig_row_id)){
		   	$extra_gig_ref   	   = json_encode($extra_gig_row_id);	
		   	$data['extra_gig_ref'] = $extra_gig_ref;
		   }
		   
		   $data['currency_type']    = $currency_type; 
		   
		   

		   $super_fast_delivery   = $input_data['hidden_super_fast_delivery'];
		   $data['payment_super_fast_delivery'] = 0;	// Super Fast No 		

		   if(!empty($super_fast_delivery)){

			  $data['payment_super_fast_delivery'] = 1; // Yes, it is super fast 
			  $extr_days  += $gigs_details['super_fast_days'];
			  $item_amount = $gigs_details['super_fast_charges'];   
			  }else{
				$extr_days  += $gigs_details['total_days'];
			  }
			
			$data['item_amount']    = $item_amount;
		    $data['dollar_amount']  = $item_amount;	  

			$total_price  = $extr_price + $item_amount; // Extra item price and (gigs price OR super fast price )
			$stripe_token = $input_data['access_token'];

			$amount   = ($total_price * 100); // Dollar in cents 
			$currency = 'usd'; 

   		    $charges_array                 = array();
		    $charges_array['amount']       = $amount;
		    $charges_array['currency']     = $currency;
		    $charges_array['description']  = $gigs_details['title'];
		    $charges_array['source']       = $stripe_token;
		    $response = $this->stripe->stripe_charges($charges_array);
		    $charge_id = "issue";
			if(!empty($response)){
				$data['stripe_charge'] = $response; 
				$response  = json_decode($response,true);
				$charge_id = $response['id'];
				$charge_id = (!empty($charge_id))?$charge_id:'issue';
			}  
			

		   $data['delivery_date']   =  Date('Y-m-d H:i:s', strtotime("+".$extr_days." days"));	 
		   $data['created_at']    = $current_time;
		   $data['status']        = ($charge_id!='issue')?1:0;
           $data['commision']     = $this->admin_commision;	
           $data['paypal_uid']    = $charge_id;	
           $data['seller_status'] = 1;	
           $data['source'] 		  = 'stripe';	   
		   $this->db->insert('payments',$data);	
		   $uid = $this->db->insert_id();

	    	$query = $this->db->query("SELECT py.item_amount,sg.title,sg.currency_type,sg.user_id,gi.gig_image_thumb,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,sg.gig_price,py.extra_gig_ref,py.extra_gig_dollar FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.USERID
			LEFT JOIN members as sm ON sm.USERID = py.seller_id
			WHERE py.id = $uid");

		$data_one = $query->row_array();

		$title             = $data_one['title'];
		$gig_preview_link  = base_url().'gig-preview/'.$title ;
		$img_path          = base_url().$data_one['gig_image_thumb'];
        $this->load->model('templates_model');
        $this->load->model('gigs_model');

			$email_details  = $this->gigs_model->gig_purchase_requirements($uid);
			$seller_message = '';
			$welcomemessage = ''; 
			$toemail= $email_details['email']; 
			$gig_price = $this->gigs_model->gig_price();
			//$gig_price = '$'.$gig_price['value']; // fixed price 
			$gig_price = '$'.$data_one['gig_price']; // Dynamic price 
			$extra_gig_price = $this->gigs_model->extra_gig_price();
        	//$extra_gig_price = $extra_gig_price['value'];
        	 $extra_gig_price = $data_one['extra_gig_dollar'];
			
			$extra_gig_ref = json_decode($email_details['extra_gig_ref']);
			$user_profile_link =  base_url().'user-profile/'.$email_details['buyer_username'];
			
			$h_all='';	 
			if(!empty($extra_gig_ref))
			{
				$query_extra = $this->db->query("SELECT * FROM `user_required_extra_gigs` WHERE id IN ($extra_gig_ref)");	
				$result_extra = $query_extra->result_array();	
				foreach ($result_extra as $data_extra)
				{
					$dataoptions = json_decode($data_extra['options']);
					$gig_values = explode('___',$data_extra['options']);
					if($gig_values[1]!=0 || $gig_values[1]!= "undefined" )
					{
						$h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>
							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">
								'.str_replace('"','',$gig_values[0]).'
							</td>
							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$gig_values[1].'</td>
							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$gig_values[2].'</td>
							</tr>';
					}
				}
			}
			if($email_details['payment_super_fast_delivery']==0)
			{
				$sup_dec='Super fast delivery'; 
				if(!empty($email_details['super_fast_delivery_desc']))
				{
					$sup_dec=$email_details['super_fast_delivery_desc'];
				}
				$h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>
				<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">
					'.$sup_dec.'
				</td>
				<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">1</td>
				<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$extra_gig_price.'</td>
				</tr>';
			}
			 $h_all.='<tr>
						<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>
						<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$data_one['item_amount'].'</td>
					</tr>';
			 
			$request_link =base_url().'sales';		
			$bodyid = 22;
			$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
			$body = $tempbody_details['template_content'];
			$body = str_replace('{base_url}', $this->base_domain, $body);
			$body = str_replace('{gig_owner}', $email_details['seller_name'], $body);
			$body = str_replace('{buyer_name}',$email_details['buyer_name'], $body);
			$body = str_replace('{title}',str_replace("-"," ",$title), $body);	
			$body = str_replace('{title_url}',$title, $body);
			$body = str_replace('{PAYPAL_ID}',$order_id, $body);
			$body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);	
			$body = str_replace('{PRICE}',$gig_price , $body);										 
			$body = str_replace('{BUYER_LINK}', $user_profile_link, $body);	
			
			 $body = str_replace('{TEABLE_ROW}', $h_all, $body);
			
			$body = str_replace('{IMG_SRC}',$img_path , $body);
			$body = str_replace('{gig_preview_link}',$gig_preview_link, $body);	
			$body = str_replace('{request_link}',$request_link, $body);
		 	$body = str_replace('{site_name}',$this->site_name, $body);
			 
$seller_message	=                    $message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
<tr>
<td></td>
<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
	<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
		<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
			<tr>
				<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align:center;">
								<a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>
							</td>
						</tr>
						<tr>
							<td>'.$body.'</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
			<table width="100%">
				<tr>
					<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
						&copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.
					</td>
				</tr>
			</table>
		</div>
	</div>
</td>
</tr>
</table>';  	
			$this->load->helper('file');  
			$this->load->library('email');
			$this->email->set_newline("\r\n");
			$this->email->from($this->email_address,$this->email_tittle); 
			$this->email->to($toemail); 
			$this->email->subject('New order from '.$email_details['buyer_name']);
			$this->email->message($seller_message);	 
			$this->email->send();	
		//admin mail function
        $from_timezone = $this->session->userdata('time_zone');
		date_default_timezone_set($from_timezone); 
		$current_time= date('Y-m-d H:i:s');
        $bodyid = 19;
        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
        $body=$tempbody_details['template_content'];	
		$body = str_replace('{base_url}', $this->base_domain, $body);
		$body = str_replace('{PAYPAL_ID}', $order_id, $body);
		$body = str_replace('{CREATED_ON}', $current_time, $body);		 
        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);
        $body = str_replace('{seller_name}', $data_one['sellername'], $body);
        $body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);
        $body = str_replace('{PRICE}',''.$gig_price, $body);
        $body = str_replace('{IMG_SRC}',$img_path , $body);
		$body = str_replace('{site_name}',$this->site_name, $body);
		$body = str_replace('{TEABLE_ROW}', $h_all, $body);
      $message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
								<tr>
									<td></td>
									<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
										<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
											<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
												<tr>
													<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td style="text-align:center;">
																	<a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>
																</td>
															</tr>
															<tr>
																<td>'.$body.'</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">
												<table width="100%">
													<tr>
														<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">
															&copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.
														</td>
													</tr>
												</table>
											</div>
										</div>
									</td>
								</tr>
							</table>';  
        $this->load->helper('file');  
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->from($this->email_address,$this->email_tittle); 
        $this->email->to($this->email_address); 
        $this->email->subject('Create New Order');
        $this->email->message($message);
		 
		if($this->email->send())
        { 
			redirect(base_url().'purchase-success/'.$uid);
		}else{
			redirect(base_url().'purchase-success/'.$uid);
		}

    }


    public function stripe_refund(){

    	$sale_id     = $this->input->post('sale_id');
    	$invoice_id  = $this->input->post('invoice_id');
    	$amount      = $this->input->post('amount');
    	$currency    = (empty($this->input->post('currency'))?$this->input->post('currency'):'usd');
    	$category    = $this->input->post('category');
    	$comment     = $this->input->post('comment');
    	

    	$refund_array               = array();
		$refund_array['sale_id']    = "$sale_id";
    	$refund_array['invoice_id'] = "$invoice_id";
    	$refund_array['amount']     = "$amount";
    	$refund_array['currency']   = "$currency";
    	$refund_array['category']   = "$category";
    	$refund_array['comment']    = "$comment";

    	$refund = $this->twocheckout->twocheckout_refund($refund_array);

		$where['paypal_uid'] = $charge_id;
		$my_data['stripe_refund'] = $refund; // 2Checkout Refund Response 
		$my_data['seller_status'] = 4; // Refunded 
		$my_data['payment_status'] = 2;
		$my_data['notification_paycomplete'] = 1;
		$my_data['notification_status'] = 1;
		$this->db->where($where);
		$this->db->update('payments', $my_data);
   		echo 1;
   		exit;

    }

}
?>