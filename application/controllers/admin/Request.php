<?php 
class Request extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'request';
        $this->load->model('admin_panel_model');
        //load user model
        $this->load->model('api_gigs_model','gigs');
        $this->load->helper('favourites');
    } 
    public function index()
    {
        $this->data['page'] = 'index';
        $this->data['list'] = $this->admin_panel_model->get_allpayment_list();
		$data['admin_notification_status'] = 0;
		$this->db->where('admin_notification_status',1);
		$this->db->update('payments',$data);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');              
    }
    public function edit_request($id)
    {
        $this->data['page'] = 'edit_request';
        $this->data['list'] = $this->admin_panel_model->edit_request($id);
        $this->data['parent_category'] = $this->admin_panel_model->categories();
        $this->data['child_category'] = $this->admin_panel_model->categories();
        if($this->input->post('form_submit'))
        {         
        $data['req_desc'] = $this->input->post('req_desc');
        $data['main_cat'] = $this->input->post('parent_category');
        $data['sub_cat'] = $this->input->post('child_category');
        $data['delivery_time'] = $this->input->post('delivery_time');
        $data['amount'] = $this->input->post('amount');
        $data['status'] = $this->input->post('status');         
        $this->load->library('common');
        if (isset($_FILES) && isset($_FILES['request_file']['name']) && !empty($_FILES['request_file']['name'])) {                   
        $uploaded_file_name = $_FILES['request_file']['name'];
        $filename = isset($uploaded_file_name) ? $uploaded_file_name : '';              
        $upload_sts = $this->common->global_file_upload('uploads/request_files/','request_file', time().$filename);         
        if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
        $uploaded_file_path = "uploads/request_files/".$upload_sts['data']['file_name'];              
        $image_url=$uploaded_file_path; 
        $data['uploaded_file'] = $image_url;        
            }
            }
        $this->db->where('id',$id);
        if($this->db->update('request',$data))
        {
            redirect(base_url().'admin/request');
        }    
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');                
    }
    public function delete_request()
    {
        $id = $this->input->post('tbl_id');
        $this->db->where('id',$id);
        if($this->db->delete('request'))
        {
            echo 1;
        }        
    }
	public function update_payment_status()
	{
		$id = $this->uri->segment(4);	
        $data['payment_status'] = 2;
		$data['notification_paycomplete'] = 1;
		$data['notification_status'] = 1;

		$this->db->where('id',$id);
		if($this->db->update('payments',$data))
		{

		$query = $this->db->query("SELECT P.seller_id as user_id,P.USERID as buyer_id FROM payments AS P WHERE P.id ='".$id."'");
		$current_data  = $query->row_array();  

        if(!empty($current_data)){
			
			$user_id 			= $current_data['user_id'];
			$buyer_id 			= $current_data['buyer_id'];
			$API_details  		= $this->gigs->settings();
			$include_player 	= $this->gigs->player_ids($user_id);
			$include_player_ids = !empty($include_player['device_id'])?$include_player['device_id']:'';

			$query = $this->db->query("SELECT sum(py.item_amount) as amount FROM payments as py LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id 
                               LEFT JOIN members as m ON m.USERID = py.USERID WHERE py.seller_id = $buyer_id AND seller_status = 6 AND py.payment_status = 1");
        	$amount = 0;
       		if($query->num_rows() > 0){
         		$records  = $query->row_array();  
         		$amount  = (int)$records['amount'];
       		}
      		$extra_data = array('message'=>'Payment Successful','order_id'=>$id,'balance'=>$amount);
      		
		 
		if(!empty($include_player['device'])){ 
			if($include_player['device']!='browser'){

			if(!empty($API_details['one_signal_app_id']) && !empty($API_details['one_signal_reset_key']) && !empty($current_data['user_id'])){
			
					$data = array();	 
					$data['user_id']   = $current_data['user_id'];
					$data['message']   = 'Payment Successful';
					$data['app_id']    = $API_details['one_signal_app_id'];
					$data['reset_key'] = $API_details['one_signal_reset_key'];
					$data['include_player_ids'] = $include_player_ids;
					$data['additional_data'] =$extra_data;
					$result = send_message($data);
				}
			}
		 }

		}
			$site_url = base_url().'admin/release_payments';
			echo '<script>window.location.href="'.$site_url.'";</script>';
			die();
		   
        } 
		else
		{
			 redirect(base_url().'admin/release_payments');
		
		}
	}
	
		function buy($id,$amount,$user_id,$g_name){
		//Set variables for paypal form
		$returnURL =base_url($this->data['theme'] .'/buy_service/paypal_success/'); //payment success url
		$cancelURL = base_url($this->data['theme'] .'/buy_service/paypal_cancel'); //payment cancel url
		$notifyURL = base_url().'user/buy_service/ipn'; //ipn url
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
		 
		}
    }
}
?>