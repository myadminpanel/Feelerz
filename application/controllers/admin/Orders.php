<?php 
class Orders extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'orders'; 
		$this->load->model('admin_panel_model');       
        
        $this->email_address='mail@example.com';
        $this->email_tittle='Gigs';
        $this->logo_front=base_url().'assets/images/logo.png';
        $this->site_name ='gigs';

        $this->load->helper('favourites');
        $result = gigs_settings();

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
             }
        }

        }
    public function index($start=0)
    {
		$this->load->library('pagination');
        $config['base_url'] = base_url("admin/orders/");
        $config['total_rows'] = $this->db->count_all('payments');
        $config['per_page'] = 15;

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
        $this->data['list'] = $this->admin_panel_model->get_allpayment_list($start,$config['per_page']);
		$this->data['links'] = $this->pagination->create_links();
		$data['admin_notification_status'] = 0;
		$this->db->where('admin_notification_status',1);
		$this->db->update('payments',$data);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }
	 public function completed_orders($st=0)
    {
		$this->load->library('pagination');
        $config['base_url'] = base_url("admin/completed_orders/");
        $config['per_page'] = 15;
        $config['total_rows'] = $this->admin_panel_model->get_completepayment_list(0,$st,$config['per_page']);
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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'complete';
        $this->data['list'] = $this->admin_panel_model->get_completepayment_list(1,$st,$config['per_page']);
		$data['admin_notification_status'] = 0;
		$this->db->where('admin_notification_status',1);
		$this->db->update('payments',$data);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }
	 public function pending_orders($st=0)
    {
		$this->load->library('pagination');
        $config['base_url'] = base_url("admin/pending_orders/");
        $config['per_page'] = 15;
		$config['total_rows'] = $this->admin_panel_model->get_Pendingpayment_list(0,$st,$config['per_page']); 
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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'pending';
        $this->data['list'] = $this->admin_panel_model->get_Pendingpayment_list(1,$st,$config['per_page']);
		$data['admin_notification_status'] = 0;
		$this->db->where('admin_notification_status',1);
		$this->db->update('payments',$data);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }

    public function rejected_orders($st=0)
    {
		$this->load->library('pagination');
        $config['base_url'] = base_url("admin/rejected_orders/");
        $config['per_page'] = 15;
		$config['total_rows'] = $this->admin_panel_model->get_Pendingpayment_list(0,$st,$config['per_page']); 
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

        $this->data['links'] = $this->pagination->create_links();

        $this->data['page'] = 'rejected';

        $this->data['id'] = $this->session->userdata('SESSION_USER_ID'); 

		 $user_id=$this->session->userdata('SESSION_USER_ID');

        $this->data['list'] = $this->admin_panel_model->get_Pendingpayment_list(1,$st,$config['per_page']);

		$data['admin_notification_status'] = 0;

		$this->db->where('admin_notification_status',1);

		$this->db->update('payments',$data);

        $this->data['result'] = $this->admin_panel_model->get_rejected_list();

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'/template');        
    }


    public function accept_rejected_orders($id)
    {


        $change_reject_status = $this->uri->segment(3);

        $id = $this->uri->segment(4);   

        $result = $this->admin_panel_model->get_rejected_list();

        $order_id = $result[0]['order_id'];

        $this->data['accept_reject'] = $this->admin_panel_model->reject_accept($change_reject_status,$id,$order_id);

        /*$result = $this->admin_panel_model->rejected_request_list();

        $insert_id = $result['id'] = $this->db->insert_id();*/

        $admin_cancel = $this->admin_panel_model->cancel_request($id);

        //echo $this->db->last_query();

       $bodyid = 31;

                $title = $admin_cancel['title'];//print_r($title);echo "</br>";

                $admin_name = $admin_cancel['admin_name'];//print_r($admin_name);echo "</br>";

                $seller_email = $admin_cancel['seller_email'];//print_r($seller_email);echo "</br>";

                $admin_email = $admin_cancel['admin_email'];//print_r($admin_email);

                $seller_name = $admin_cancel['seller_name'];//print_r($seller_name);exit;

                $buyer_name = $admin_cancel['buyer_name'];

                $this->email_address = $seller_email;

                $this->admin_email_address = $admin_email; 

                $this->load->model('templates_model');

                $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

                $body=$tempbody_details['template_content'];

                $body = str_replace('{admin_name}',$admin_name, $body);

                $body = str_replace('{seller_name}',$seller_name, $body);

                $body = str_replace('{buyer_name}',$buyer_name, $body);

                $body = str_replace('{title}',$title, $body);

                $body = str_replace('{site_name}',$this->site_name, $body);         

                //$body = str_replace('{PRICE}', $amount, $body);

                $body = str_replace('{TITLE}', str_replace('-',' ',$title), $body);

                $link=base_url().'request';

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

                            </table>';          //print_r($message);exit;

                $this->load->helper('file');  

                $this->load->library('email');
                 $config = array(
                 'protocol'  => 'mail',
                 'smtp_host' => 'ssl://oaxacamelate.com',
                 'smtp_port' => 465,
                 'smtp_user' => 'admin@oaxacamelate.com',
                 'smtp_pass' => 'If]fvIw%W.=Q',
                 'mailtype'  => 'html',
                 'charset'   => 'utf-8'
                 );
                 $this->email->initialize($config);

                $this->email->set_newline("\r\n");

                $this->email->subject('Cancel Completed Request');

                $this->email->message($message);

                $this->email->from($admin_email,$this->email_tittle);

                $this->email->to($seller_email);

                $url_parts = parse_url(current_url());

                if($url_parts['host'] !='localhost'){

                    $result = $this->email->send();//echo $this->email->print_debugger();exit;
                        

                }



        $this->data['page'] = 'index';

        $this->load->vars($this->data);  

        $this->load->view($this->data['theme'].'/template');

        redirect(base_url('admin/rejected_orders'));


    }

	 public function cancel_orders($st=0)
    {
		$this->load->library('pagination');
        $config['base_url'] = base_url("admin/cancel_orders/");
        $config['per_page'] = 15;
        $config['total_rows'] = $this->admin_panel_model->get_cancelpayment_list(0,$st,$config['per_page']);

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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'cancel';
        $this->data['list'] = $this->admin_panel_model->get_cancelpayment_list(1,$st,$config['per_page']);
		$data['admin_notification_status'] = 0;
		$this->db->where('admin_notification_status',1);
		$this->db->update('payments',$data);
        $this->load->vars($this->data);
		 
        $this->load->view($this->data['theme'].'/template');        
    }
	 public function decline_orders($st=0)
    {
		$this->load->library('pagination');
        $config['base_url'] = base_url("admin/decline_orders/");
        $config['per_page'] = 15;
        $config['total_rows'] = $this->admin_panel_model->get_declinepayment_list(0,$st,$config['per_page']);
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
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'decline';
        $this->data['list'] = $this->admin_panel_model->get_declinepayment_list(1,$st,$config['per_page']);
		$data['admin_notification_status'] = 0;
		$this->db->where('admin_notification_status',1);
		$this->db->update('payments',$data);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }
	public function edit_order($id)
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
    public function delete_order()
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
		$id = $this->input->post('id'); 
        $data['payment_status'] = 2;
		$data['notification_paycomplete'] = 1;
		$this->db->where('id',$id);
		if($this->db->update('payments',$data))
		{
            echo 1;
        } 
		else
		{
			echo 2;
		}
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
		   $from_timezone = $this->session->userdata('time_zone');
		   date_default_timezone_set($from_timezone); 
		   $current_time= date('Y-m-d H:i:s');
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
		$returnURL =base_url('/admin/orders/decline_success/'.$id); //payment success url
		$cancelURL = base_url('/admin/orders/paypal_decline'); //payment cancel url
		$notifyURL = base_url().'admin/orders/ipn'; //ipn url
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
		$returnURL =base_url('/admin/release_payments/cancel_success/'.$id); //payment success url
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
	    redirect(base_url().'admin/decline_orders');
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