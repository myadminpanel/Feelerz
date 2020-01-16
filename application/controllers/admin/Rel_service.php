<?php 
class Rel_service extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'rel_service'; 
		$this->load->model('admin_panel_model');       
        }

	
			public function can_payment()
	{

		   if($this->input->post('submit')){ 		   
		   $current_time= date('Y-m-d H:i:s');
	   	   $rate=$this->input->post('gigs_rate');
		   $email   = $this->input->post('buyer_email');
		   $item_id   = $this->input->post('extra_gig_row_id');
		   $users_tbl_id=1;
		  $this->cancel_buy($item_id,$rate,$users_tbl_id,$email);
		   }
	}
	
				public function declined_paymrent()
	{
		if($this->input->post('submit')){ 		
	   	  $rate=$this->input->post('gigs_rate');
		   $email   = $this->input->post('buyer_email');
		   $item_id   = $this->input->post('extra_gig_row_id');
		   $users_tbl_id=1;
				$this->declined_buy($item_id,$rate,$users_tbl_id,$email);
		}
	}
	
	
	
	
	
	function declined_buy($id,$amount,$user_id,$email){
		 $this->config->load('paypallib_config');
		 $this->config->set_item('business', $email);
		 $this->load->library('paypal_lib');
		
		//Set variables for paypal form
		$returnURL =base_url('/admin/rel_service/decline_success/'.$id); //payment success url
		$cancelURL = base_url('/admin/orders/paypal_decline'); //payment cancel url
		$notifyURL = base_url().'admin/rel_service/ipn'; //ipn url
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
		//$this->paypal_lib->image($logo);

		
		$this->paypal_lib->paypal_auto_form();
	}
	
		
	function cancel_buy($id,$amount,$user_id,$email){
		 $this->config->load('paypallib_config');
		 $this->config->set_item('business', $email);
		 $this->load->library('paypal_lib');
		
		//Set variables for paypal form
		$returnURL =base_url('/admin/rel_service/cancel_success/'.$id); //payment success url
		$cancelURL = base_url('/admin/rel_service/paypal_cancel'); //payment cancel url
		$notifyURL = base_url().'admin/rel_service/ipn'; //ipn url
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
		//$this->paypal_lib->image($logo);

		
		$this->paypal_lib->paypal_auto_form();
	}
	 function cancel_success(){
	  
		$paypalInfo =  $this->input->get();
		//$paypalInfo =  $this->input->get();
        $user_pay_id = $this->input->get('Ad');
        $message='';       
		
	     $uid = $this->uri->segment(4);	
		 
		 $data['pay_status'] = 'Payment Processed';
		$this->db->where('id',$uid);
		$this->db->update('payments',$data);
	   
		redirect(base_url().'admin/cancel_orders');
		
	 }
	 
	 	 function decline_success(){
	  
		$paypalInfo =  $this->input->get();
		//$paypalInfo =  $this->input->get();
        $user_pay_id = $this->input->get('Ad');
        $message='';       
		
	     $uid = $this->uri->segment(4);	
	    $data['pay_status'] = 'Payment Processed';
		$this->db->where('id',$uid);
		$this->db->update('payments',$data);
	    redirect(base_url().'admin/decline_orders');
	 }
	 
	 function paypal_cancel(){
        redirect(base_url().'admin/cancel_orders');
	 }
	 
	 
	 function paypal_decline(){
        redirect(base_url().'admin/decline_orders');
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
		    $table_data['transaction_id'] = $TRANSACTIONID;
			$table_data['transaction_status'] = 1;
			$table_data['transaction_date'] = date('Y-m-d H:i:s');
			$this->db->update('payments', $table_data, "id = " . $user_pay_id);
		}
    }
    
}
?>