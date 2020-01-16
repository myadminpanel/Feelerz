<?php 
class Relelse_payment_service extends CI_Controller{
	
	  public function __construct() {
        parent::__construct();
        $this->data['theme']  = 'admin';
        $this->data['module'] = 'release_payments';
        $this->load->model('admin_panel_model');  
		$this->data['admin_commision']       = $this->admin_panel_model->admin_commision();

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
	
	    public function index($offset=0)
    {          

        $uid = '';
		if(isset($this->session->userdata)){
			$userid = $this->session->userdata;	
			if(isset($userid['id'])){
				$uid = $userid['id'];	
			}
			
		}
		
        $this->data['page_title'] = 'Buy Service';
        $this->load->library('pagination');
        $config['base_url'] = base_url().'buy-service';
        $config['per_page'] = 16;                
        $config['total_rows'] =  $this->gigs_model->buy_service(0,0,0,'');   
		$config['uri_segment'] = 2;		
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        //$config['reuse_query_string'] = TRUE;
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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['list'] =   $this->gigs_model->buy_service(1,$offset,$config['per_page'],$uid);       
        $this->data['user_favorites'] = $this->gigs_model->add_favourites();
        $this->data['module'] = 'buy_service';
        $this->data['page'] = 'index';
        $this->data['search_value'] = 'Buy Service';    
        $this->data['search_type'] = 'Location';
        $this->data['total_results'] = $config['total_rows'];
        $this->load->vars($this->data);    
        $this->load->view($this->data['theme'] . '/template'); 
        
    }
    

    
	public function payment()
	{
		print_r($this->session); 
		exit;
		if($this->input->post('submit')){ 			
		   $from_timezone = $this->session->userdata('time_zone');
		   date_default_timezone_set($from_timezone); 
		   $current_time= date('Y-m-d H:i:s');
	   	  $rate=$this->input->post('gigs_rate');
		   $email   = $this->input->post('buyer_email');
		   $item_id   = $this->input->post('extra_gig_row_id');
		   $users_tbl_id=1;
		  

				$this->buy($item_id,$rate,$users_tbl_id,$email);
		}
	}
	function buy($id,$amount,$user_id,$email){
		 $this->config->load('paypallib_config');
		 $this->config->set_item('business', $email);
		 $this->load->library('paypal_lib');
		
		//Set variables for paypal form
		$returnURL =base_url('/admin/relelse_paymenyt_service/paypal_success/'); //payment success url
		$cancelURL = base_url('/admin/relelse_paymenyt_service/paypal_cancel'); //payment cancel url
		$notifyURL = base_url().'admin/relelse_paymenyt_service/ipn'; //ipn url
		//get particular product data
		//$product = $this->product->getRows($id);
		$userID = $user_id; //current user id
		$name =$g_name;
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
	 function paypal_success(){
	    //get the transaction data
		//$paypalInfouser = $this->input->get();
		$paypalInfo =  $this->input->get();
		//$paypalInfo =  $this->input->get();
        $user_pay_id = $this->input->get('Ad');
        $message='';       
		/*$data['item_number'] = $paypalInfo['item_number']; 
		$data['txn_id'] = $paypalInfo["tx"];
		$data['payment_amt'] = $paypalInfo["amt"];
		$data['currency_code'] = $paypalInfo["cc"];
		$data['status'] = $paypalInfo["st"];*/

		//print_r($user_pay_id); 		
		//exit;
        $order_id= $paypalInfo['tx'];         
	    $table_data['paypal_uid'] = $paypalInfo['tx'];
	    $table_data['seller_status'] = 1;
	    $uid = $paypalInfo['item_number'];               
		$this->email->initialize($this->smtp_config);
		if($this->email->send())
        { 
			redirect(base_url().'purchase-success/'.$uid);
		}else{
			redirect(base_url().'purchase-success/'.$uid);
		}
		//pass the transaction data to view
        //$this->load->view('paypal/success', $data);
	 }
	 
	 function paypal_cancel(){
        redirect(base_url().'purchases');
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