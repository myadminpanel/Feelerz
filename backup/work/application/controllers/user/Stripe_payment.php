<?php if (!defined('BASEPATH'))    exit('No direct script access allowed');



class Stripe_payment extends CI_Controller {

    

    public function __construct() {

        parent::__construct();

	    $config = array();
 

	    $this->load->helper('favourites');
    	$common_settings = gigs_settings();
 	    $default_currency = 'USD';
        if(!empty($common_settings)){
          foreach($common_settings as $datas){
            if($datas['key']=='currency_option'){
             $default_currency = $datas['value'];
            }
         }
        }

        $this->load->helper('currency');
        $this->default_currency      = $default_currency;
        $this->default_currency_sign = currency_sign($default_currency);
        $this->smtp_config           = smtp_mail_config();

		$result = gigs_settings();

		$this->email_address='mail@example.com';

		$this->email_tittle='Gigs';

		$this->logo_front=base_url().'assets/images/logo.png';

		$this->site_name ='gigs';

		

		$this->secret_key = '';

		$this->publishable_key = '';



		$this->secret_key = '';

		$this->publishable_key = '';



		$publishable_key =  '';

		$secret_key =  '';

		$live_publishable_key =  '';

		$live_secret_key =  '' ;





		if(!empty($result))

		{

			foreach($result as $data){

				if($data['key'] == 'email_address'){

					$this->email_address = !empty($data['value']) ? $data['value'] : 'mail@example.com' ;

				}

				if($data['key'] == 'email_tittle'){

					$this->email_tittle = !empty($data['value']) ? $data['value'] : 'Gigs' ;

				}

				if($data['key'] == 'admin_commision'){

					$this->admin_commision = !empty($data['value']) ? $data['value'] : '0' ;

				}

				if($data['key'] == 'base_domain'){

					$this->base_domain = $data['value'];

				}

				if($data['key'] == 'logo_front'){

					$this->logo_front = base_url().$data['value'];

				}

				if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){

					$this->site_name = $data['value'];

				}

				

				if($data['key'] == 'live_publishable_key'){

					$live_publishable_key = $data['value'];

				}

				if($data['key'] == 'live_secret_key'){

					$live_secret_key = $data['value'];

				}

				if($data['key'] == 'publishable_key'){

					$publishable_key = $data['value'];

				}

				if($data['key'] == 'secret_key'){

					$secret_key = $data['value'];

				}

				if($data['key'] == 'stripe_option'){

					$stripe_option = $data['value'];

				}

			}

			if($stripe_option == 1){

				$this->publishable_key = $publishable_key;

				$this->secret_key      = $secret_key;

 			}

			if($stripe_option == 2){

				$this->publishable_key = $live_publishable_key;

				$this->secret_key      = $live_secret_key; 

			}

		}



	    $config['publishable_key'] = $this->publishable_key;

	    $config['secret_key'] = $this->secret_key;

	    /*$stripe_config['stripe_name'] = "Dreams Gigs";

	    $stripe_config['stripe_logo'] = base_url()."assets/images/logo.png";

	    $stripe_config['stripe_description'] = "This Gigs Payments";

	    $stripe_config['server_side_coding'] = base_url()."user/buy_service/stripe_token_payment";*/

	    $this->load->library('stripe',$config);

	     $this->load->model('templates_model');

        $this->load->model('gigs_model');

    }

    public function index() { 



    	   $input_data = $this->input->post();


    	   $from_timezone = $this->session->userdata('time_zone');

		   date_default_timezone_set($from_timezone); 

		   $current_time 	= date('Y-m-d H:i:s');

		   $currency_type 	= $input_data['currency_type'];

		   $data['USERID']    = $this->session->userdata('SESSION_USER_ID');

		   $data['time_zone'] = $this->session->userdata('time_zone');

		   $extra_gig_required_days=(int) $input_data['total_delivery_days'];

		   $gigs_id 			   = $input_data['gigs_id'];



		   $query = $this->db->query("SELECT id,user_id as seller_id,title,gig_price,currency_type,delivering_time as total_days,super_fast_charges,super_fast_delivery,super_fast_delivery_date as super_fast_days FROM sell_gigs WHERE id = $gigs_id ");

		   $gigs_details  = $query->row_array();



		   $data['gigs_id']        = $gigs_id;

		   $data['seller_id']      = $gigs_details['seller_id'];

		   $item_amount    		   = $gigs_details['gig_price'];
		   $currency_type    		   = $gigs_details['currency_type'];

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


		  $item_amount += $extr_price;

		   $data['extra_gig_dollar'] = $extr_price;

		   if(!empty($extra_gig_row_id)){

		   	$extra_gig_ref   	   = json_encode($extra_gig_row_id);	

		   	$data['extra_gig_ref'] = $extra_gig_ref;

		   }
		   $data['currency_type']    = $currency_type; 
		   $data['currency']   		 = $currency_type; 
		   $super_fast_charges   	 = $input_data['hidden_super_fast_delivery_charges'];
		   $data['payment_super_fast_delivery'] = 1;	// Super Fast No 		
		   if(!empty($super_fast_charges)){

			  $data['payment_super_fast_delivery'] = 0; // Yes, it is super fast 

			  $extr_days  += $gigs_details['super_fast_days'];

			  $super_fast_charges = $gigs_details['super_fast_charges'];   

			  }else{

				$extr_days  += $gigs_details['total_days'];

			  }
			$item_amount += $super_fast_charges;

			$data['extra_gig_dollar']    = $super_fast_charges;
			$data['item_amount']    = $item_amount;
		    $data['dollar_amount']  = $item_amount;	  
			$total_price  = $extr_price + $item_amount; // Extra item price and (gigs price OR super fast price )
			$stripe_token = $input_data['access_token'];
			$amount   = ($total_price * 100); // Dollar in cents 
			$currency = $currency_type; 



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
				if(!empty($response['id'])){
					$charge_id = $response['id'];
				}else{
					$charge_id = 0;
				}
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

		   $insert_id = $this->db->insert_id();

		   $result = array('status'=>'success','payment_id'=>$insert_id);

		   echo json_encode($result);

		   die();

    }

	public function make_payment()
	{
		   	$charges_array                 = array();

			$amount                        = $this->input->post('amount');

			$currency                      = $this->input->post('currency');

			$title                         = $this->input->post('title');

		    $charges_array['amount']       = $amount;

		    $charges_array['currency']     = $currency;

		    $charges_array['description']  = $title;

			$stripe_token 				   = $this->input->post('token_id');

		    $charges_array['source']       = $stripe_token;

		    $response = $this->stripe->stripe_charges($charges_array);
			
			print_r($response);
	}

	public function send_stripe_mail($uid){



    	$query = $this->db->query("SELECT py.item_amount,sg.title,sg.currency_type,sg.user_id,gi.gig_image_thumb,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,sg.gig_price,py.extra_gig_ref,py.extra_gig_dollar FROM `payments` as py

	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	

			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  

            LEFT JOIN members as m ON m.USERID = py.USERID

			LEFT JOIN members as sm ON sm.USERID = py.seller_id

			WHERE py.id = $uid");
 


		$title             = $data_one['title'];
		$currency_type     = $data_one['currency_type'];
		$gig_preview_link  = base_url().'gig-preview/'.$title ;
		$img_path          = base_url().$data_one['gig_image_thumb'];
		$stripe_amount     = 0 ;
		$currency_option   = (!empty($currency_type))?$currency_type:'USD';
        $rate_symbol       = currency_sign($currency_option);
       



			$email_details  = $this->gigs_model->gig_purchase_requirements($uid);

			$seller_message = '';

			$welcomemessage = ''; 

			$toemail= $email_details['email']; 

			$gig_price = $this->gigs_model->gig_price();

			//$gig_price = '$'.$gig_price['value']; // fixed price 
			$stripe_amount += $data_one['gig_price'];
			$gig_price = $rate_symbol.' '.$data_one['gig_price']; // Dynamic price 

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

						$stripe_amount += $gig_values[2];

						$h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

								'.str_replace('"','',$gig_values[0]).'

							</td>

							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$gig_values[1].'</td>

							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$rate_symbol.' '.$gig_values[2].'</td>

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

				$h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top"><span  style="background-color: #f0abac;border-radius: 2px;color: #df5c5e;float: left;font-size: 10px;font-weight: bold;padding: 3px 8px;text-transform: uppercase;">Super Fast</span></td>

				<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

					'.$sup_dec.'

				</td>

				<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">1</td>

				<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$rate_symbol.' '.$extra_gig_price.'</td>

				</tr>';
				$stripe_amount += $extra_gig_price;

			}

			 $h_all.='<tr>

						<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>

						<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$rate_symbol.' '.$stripe_amount.'</td>

					</tr>';

			 

			$request_link = base_url().'sales';		

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
			$this->email->initialize($this->smtp_config);
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
        $this->email->initialize($this->smtp_config);
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



    	$charge_id     = $this->input->post('pid');

    	$amount_dollar = $this->input->post('amount');

    	$amount		   = ($amount_dollar * 100);



    	$refund_array             = array();

		$refund_array['charge']   = "$charge_id";

    	$refund_array['amount']   = "$amount";

    	$refund = $this->stripe->stripe_refund($refund_array);

		$where['paypal_uid'] = $charge_id;

		$my_data['stripe_refund'] = $refund; // Stripe Refund Response 

		

		$my_data['seller_status'] = 4; // Refunded 

		$my_data['payment_status'] = 2;

		$my_data['notification_paycomplete'] = 1;

		$my_data['notification_status'] = 1;

		$query = $this->db->query("SELECT py.*,sg.title,m.fullname as buyername,m.email as buyeremail,sm.fullname as sellername FROM payments as py

			LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	

			LEFT JOIN members as m ON m.USERID = py.USERID

			LEFT JOIN members as sm ON sm.USERID = py.seller_id

			WHERE paypal_uid = '".$charge_id."'");

		if($query->num_rows() > 0){

			$refund_details = $query->row_array();

			$my_data['refund_amount'] = $amount_dollar + $refund_details['refund_amount']; 

		}

		$this->db->where($where);

		$this->db->update('payments', $my_data);

		

		//Buyer Refund Amount

        $from_timezone = $this->session->userdata('time_zone');

		date_default_timezone_set($from_timezone); 

		$current_time= date('Y-m-d H:i:s');

        $bodyid = 34;

        $title    = $refund_details['title'];

        $order_id = $refund_details['paypal_uid'];

        $buyeremail = $refund_details['buyeremail'];

        $refund_amount = $my_data['refund_amount'];

		

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];	



		$body = str_replace('{base_url}', $this->base_domain, $body);

		$body = str_replace('{PAYPAL_ID}', $order_id, $body);

		$body = str_replace('{CREATED_ON}', $current_time, $body);		 

        $body = str_replace('{buyer_name}', $refund_details['buyername'], $body);

        $body = str_replace('{seller_name}', $refund_details['sellername'], $body);

        $body = str_replace('{TITLE}',str_replace("-"," ",$title), $body);

        $body = str_replace('{gig_link}',base_url().'gig-preview/'.$title, $body);

		$body = str_replace('{site_name}',$this->site_name, $body);

		$body = str_replace('{refund_amount}',$refund_amount, $body);

		

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

																	<a href="'.$this->base_domain.'" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>

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
        $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle); 

        $this->email->to($buyeremail); 

        $this->email->subject('Buyer Refund Amount');

        $this->email->message($message);

		$this->email->send();

        echo 1;

   		exit;



    }



    public function details(){

    	if($this->input->post()){

    		$id = $this->input->post('id');

    		$this->db->where('user_id', $id);

    		$result = $this->db->get('stripe_bank_details')->row_array();

    		if(!empty($result)){

    			echo json_encode($result);

    		}

    		die();

    	}

    }



}

?>