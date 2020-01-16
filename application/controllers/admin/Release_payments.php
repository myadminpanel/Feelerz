<?php 
class Release_payments extends CI_Controller {
    public $data;
    public function __construct() {
        parent::__construct();
        $this->data['theme']  = 'admin';
        $this->data['module'] = 'release_payments';
        $this->load->model('admin_panel_model');  
        $this->load->model('gigs_model');  
		$this->data['admin_commision']       = $this->admin_panel_model->admin_commision();
		$query = $this->db->query("select * from system_settings WHERE status = 1");
		$result = $query->result_array();
		$this->email_address='mail@example.com';
		$this->email_tittle='Gigs';
		$this->base_domain = base_url();
		$this->site_name='';
		$this->logo_front=base_url().'assets/images/logo.png';
		if(!empty($result))
		{
		foreach($result as $data){
		if($data['key'] == 'email_address'){
		$this->email_address = !empty($data['value']) ?$data['value'] : 'mail@example.com' ;
		}
	   if($data['key'] == 'email_tittle'){
		$this->email_tittle =!empty($data['value']) ? $data['value'] : 'gigs' ;
		}
		   if($data['key'] == 'logo_front'){
		$this->logo_front = base_url().$data['value'];
		}
		if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){
		$this->site_name = $data['value'];
		}
		}
		}
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
    }

    public function index($offset = 0) {     
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/release_payments/");
        $config['per_page'] = 50000000;	 
        $config['total_rows'] = $this->admin_panel_model->release_payments(0,$offset,$config['per_page']);	 
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $this->data['page'] = 'index';
        $this->data['case'] = $this->default_currency;
        $this->data['links'] = $this->pagination->create_links();
		$offset = (int)$this->uri->segment(3);
        $this->data['list'] = $this->admin_panel_model->release_payments(1,$offset,$config['per_page']);
        //$this->data['list'] = $this->admin_panel_model->get_all_list(1,$offset,$config['per_page']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }	
	
	public function process_payment()
	{
	$payment_id = $this->input->post('payment_id');	
	if(!empty($payment_id))
	{
		echo 1;
	}
	}
	
		public function payment()
	{
		if($this->input->post('submit')){ 	
		   $from_timezone = $this->session->userdata('time_zone');
		   date_default_timezone_set($from_timezone); 
		   $current_time= date('Y-m-d H:i:s');
	   	   $rate=$this->input->post('gigs_actual_rate');
	   	   $status=$this->input->post('status');
		   $email   = $this->input->post('paypalseller_email');
		   $paypalbuyer_email   = $this->input->post('buyer_paybalemail');
		   $buyeremail   = $this->input->post('buyeremail');
		   $title   = $this->input->post('title');
		   $buyer_name   = $this->input->post('buyer_name');
		   $sellername   = $this->input->post('sellername');
		   $selleremail   = $this->input->post('selleremail');
		   $item_id   = $this->input->post('extra_gig_row_id');
		   $currency_type   = $this->input->post('currency_type');
		   $users_tbl_id=1;
     	    $this->buy($item_id,$rate,$users_tbl_id,$email,$selleremail,$sellername,$title,$buyeremail,$status,$buyer_name ,$paypalbuyer_email,$currency_type );
		}
	}
	function buy($id,$amount,$user_id,$email,$selleremail,$sellername,$title,$buyeremail,$status,$buyer_name,$paypalbuyer_email,$currency_type){
		
		if($status == 1 || $status == 5)
		{
			$paypal=$email;
			$name=$buyer_name;
			$newmail = $buyeremail;	
		}else{
			$paypal=$paypalbuyer_email;
			$name=$sellername;
			$newmail=$selleremail;
		}
		 $this->config->load('paypallib_config');
		 $this->config->set_item('business', $paypal);
		 $this->load->library('paypal_lib');
		
		//Set variables for paypal form
		$returnURL =base_url('/admin/release_payments/paypal_success/'.$id); //payment success url
		if(!empty($returnURL))
		{
		$this->load->model('templates_model');
				
				$bodyid = 28;
				$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
				$body=$tempbody_details['template_content'];
				$body = str_replace('{seller_name}',$name, $body);
			    $body = str_replace('{site_name}',$this->site_name, $body);			
				$body = str_replace('{PRICE}', $amount, $body);
				$body = str_replace('{TITLE}', str_replace('-',' ',$title), $body);
				$link=base_url().'gig-preview/'.$title;
				$body = str_replace('{gig_link}', $link, $body);
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
				$this->email->to($newmail); 
				$this->email->subject('admin release payments');
				$this->email->message($message);
				$url_parts = parse_url(current_url());
				if($url_parts['host'] !='localhost'){
					$this->email->send();	
				}
				
		}
		$cancelURL = base_url('/admin/release_payments/paypal_cancel'); //payment cancel url
		$notifyURL = base_url().'admin/release_payments/ipn'; //ipn url
		//get particular product data
		//$product = $this->product->getRows($id);
		$userID = $user_id; //current user id
		$name ='Amount Process to Buyer';
		

		 $this->paypal_lib->add_field('return', $returnURL);
		 $this->paypal_lib->add_field('cancel_return', $cancelURL);
		 $this->paypal_lib->add_field('notify_url', $notifyURL);
		 $this->paypal_lib->add_field('item_name', $name);
		 $this->paypal_lib->add_field('custom', $userID);
	       $this->paypal_lib->add_field('item_number',  $id);
		 $this->paypal_lib->add_field('amount',  $amount);		
		 $this->paypal_lib->add_field('currency_code',$currency_type);		
		//$this->paypal_lib->image($logo);

		
		$this->paypal_lib->paypal_auto_form();
	}
	 function paypal_success(){
		$paypalInfo =  $this->input->get();
        $user_pay_id = $this->input->get('Ad');
        $message='';       
	     $uid = $this->uri->segment(4);	
			redirect(base_url().'admin/request/update_payment_status/'.$uid);
	 }
	 
	 function paypal_cancel(){
       if($this->uri->segment(1) == 'admin'){
			redirect(base_url().'admin/release_payments');	
		}else{
			redirect(base_url().'purchases');
		}
	 }
	 
	 public function purchase_success($payment_id)
	 { 
	 	 $this->data['purchase_details'] 		   =	$this->gigs_model->purchase_completed($payment_id);
    	 $this->data['page_title'] 				   =    'Thanks for purchasing';
	 	 $this->data['module']	  				   =    'purchase_success';
		 $this->data['page']	   				   =    'index';
     	 $this->load->vars($this->data);
         $this->load->view($this->data['theme'].'/template');		 
	 }
	 
	 function ipn(){
		  $this->load->library('paypal_lib');
		//paypal return transaction details array
		$paypalInfo	= $this->input->post();

		$data['user_id'] = $paypalInfo['custom'];
		$data['product_id']	= $paypalInfo["item_number"];
		$data['txn_id']	= $paypalInfo["txn_id"];
		$data['payment_gross'] = $paypalInfo["payment_gross"];
		$data['currency_code'] = $paypalInfo["mc_currency"];
		$data['payer_email'] = $paypalInfo["payer_email"];
		$data['payment_status']	= $paypalInfo["payment_status"];

		$paypalURL = $this->paypal_lib->paypal_url;		
		$result	= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
		
		//redirect(base_url());
		//check whether the payment is verified
		if(preg_match("/VERIFIED/i",$result)){
		    //insert the transaction data into the database
			//$this->product->insertTransaction($data);
		if(isset($TRANSACTIONID) && isset($user_pay_id)){
		    $table_data['transaction_id'] = $TRANSACTIONID;
			$table_data['transaction_status'] = 1;
			$table_data['transaction_date'] = date('Y-m-d H:i:s');
			$this->db->update('payments', $table_data, "id = " . $user_pay_id);
		}
		}
    }
  
   public function compete_payment(){

   		 if($this->input->post()){
   		 	$params = $this->input->post();
   		 	$payment_id = $params['id'];
   		 	$stripe_refund = $params['stripe_refund'];
   		 	$payment_status = $params['payment_status'];
   		 	$this->db->where('id', $payment_id);
   		 	$result = $this->db->update('payments', array('stripe_refund'=>$stripe_refund,'payment_status'=>$payment_status));
   		 	if($result){
   		 		$this->session->set_flashdata('message','Success');
   		 		redirect(base_url('admin/release_payments'),'refresh');
   		 	}


   		 }

   		 $payment_id = $this->uri->segment(4);  	
   		 if(!empty($payment_id)){
   		 	$this->data['purchase_details'] = $this->gigs_model->purchase_completed($payment_id);	
   		 }else{
   		 	$this->data['purchase_details'] = '';
   		 }
   		 
   		 $this->data['page_title'] 				   =    'Thanks for purchasing';
	 	 $this->data['module']	  				   =    'release_payments';
		 $this->data['page']	   				   =    'complete_payment';
		 $this->data['case'] = $this->default_currency;
     	 $this->load->vars($this->data);
         $this->load->view($this->data['theme'].'/template');		 

   }

}

?>