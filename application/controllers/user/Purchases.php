<?php

if (!defined('BASEPATH'))     exit('No direct script access allowed');

class Purchases extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        
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

        $this->data['theme'] = 'user';
		$query = $this->db->query("select * from system_settings WHERE status = 1");
		$result = $query->result_array();
		$this->email_address='mail@example.com';
		$this->email_tittle='Gigs';
		 $this->base_domain = base_url();
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

			$this->data['currency_option'] = 'USD';

	  			if($data['key']=='currency_option'){

	 		$this->data['currency_option'] =$data['value'];

	    	}

		}

		}

        $this->data['module'] = 'purchases';

		$this->load->model('user_panel_model');

		$this->load->model('payment_model');

		$this->load->model('gigs_model');
		$this->load->model('api_gigs_model','gigs');
		$this->load->model('templates_model');

        $this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();  

        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();

        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();

        $this->data['system_setting'] = $this->user_panel_model->system_setting(); 
        $this->data['gigs_country']             =  $this->gigs_model->gigs_country();		

		if($this->session->userdata('SESSION_USER_ID')==''){ 

			redirect(base_url(''));

		}

    }

    public function index($offset=0) {

		$this->load->library('pagination');

        $config['base_url'] = base_url().'purchases';

        $config['per_page'] = 20;                

        $config['total_rows'] =  $this->payment_model->get_user_orders($this->session->userdata('SESSION_USER_ID'),0,0,0);   

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

		 $this->data['links'] = $this->pagination->create_links();

		 $this->data['page_title'] = 'Purchases';

		 $this->data['userid'] = $this->session->userdata('SESSION_USER_ID'); 

		 $this->data['order_count'] = $this->payment_model->get_selluser_orders_count($this->session->userdata('SESSION_USER_ID'));  

		 $this->data['order_data'] = $this->payment_model->get_user_orders($this->session->userdata('SESSION_USER_ID'),1,$offset,$config['per_page']);
		 
		 $this->data['purchases_order_count'] = $this->payment_model->get_user_orders_count($this->session->userdata('SESSION_USER_ID'));  

		 $this->data['wallet_order_count'] = $this->payment_model->get_wallets_orders_count($this->session->userdata('SESSION_USER_ID'));

		 $user_id=$this->session->userdata('SESSION_USER_ID');

		 $bank_query = $this->db->query("SELECT * FROM `bank_account` WHERE `user_id` = $user_id ");

		 $this->data['list'] = $bank_query->row_array();	

		 $this->data['page'] = 'index';

  		 $this->load->vars($this->data);  

		 $this->load->view($this->data['theme'].'/template');

    }

	public function get_user_feedback()

	{

		$f_id=$this->input->post('f_id');

		$t_id=$this->input->post('t_id');

		$g_id=$this->input->post('g_id');

		$order_id=$this->input->post('order_id');

		

		$user_data = $this->user_panel_model->get_user_data($f_id);

		$s_id = $this->session->userdata('SESSION_USER_ID');

		$s_query = $this->db->query("SELECT user_thumb_image FROM `members` 

			WHERE USERID = $s_id;");

        $s_result = $s_query->row_array();

			

		$s1_prof_img    = base_url().'assets/images/avatar2.jpg';

		if($s_result['user_thumb_image'] != '') $s1_prof_img = base_url().$s_result['user_thumb_image']; 

		$s_prof_img='<img class="img-circle" width="50" height="50" alt="User Image" src="'.$s1_prof_img.'">';	

		$query_res = $this->db->query("SELECT AVG(feedback.rating) FROM `feedback`

			     left join sell_gigs on sell_gigs.id = feedback.`gig_id`

			     WHERE sell_gigs.user_id = $f_id AND feedback.`to_user_id` = $f_id;");

        $result_count = $query_res->row_array();

		$rat=0;

		if($result_count['AVG(feedback.rating)']!='')

		{

			$rat=round($result_count['AVG(feedback.rating)']);

		}

		$html ='';

		

		$prof_img    = base_url().'assets/images/avatar2.jpg';

		if($user_data['user_thumb_image'] != '') $prof_img = base_url().$user_data['user_thumb_image']; 

		$name=$user_data['fullname']; 

		$country=$user_data['country']; 

		$sortname ='IN';

		if($user_data['sortname']!='')

		{

			$sortname=$user_data['sortname']; 

		}

		$html .='<div class="media">

					<div class="media-left">

						<img src="'.$prof_img.'" alt="'.$name.'" class="img-circle" width="50" height="50">

					</div>

					<div class="media-body">

						<div class="user-details">

						<div class="user-name-block">

							<a href="'.base_url().'user-profile/'.$user_data["username"].'" class="user-name">'.$name.'</a>

						</div>

						<div class="user-contact">

							<ul class="list-inline">

								<li class="user-rating"><span id="stars-existing" class="starrr" data-rating="'.$rat.'"></span></li>

								<li class="user-country2"><b>From:</b> '.$country.' <span class="ppcn country '.$sortname.'"></span> </li>

								<li class="contact-list"><a href="javascript:;" class="btn btn-primary btn-sm btn-border" onclick="message_contact();">Contact</a></li>

							</ul>

						</div>

					</div>

					</div>

					<script type="text/javascript" src="'.base_url().'assets/js/rating.js"></script>

				</div>';

		$temp='';

		$user_feed='';		

		if($f_id)

		{

			$query = $this->db->query("SELECT a.*,cu.fullname,cu.user_thumb_image,cu.username FROM `feedback` as a 

			left join members cu on cu.USERID = a.from_user_id

			WHERE a.`from_user_id` =$t_id and a.`to_user_id` = $f_id and a.`gig_id` = $g_id and a.`order_id` = $order_id;");

        	$result = $query->row_array();

			

			$query_two = $this->db->query("SELECT a.*,cu.fullname,cu.user_thumb_image,cu.username FROM `feedback` as a 

			left join members cu on cu.USERID = a.from_user_id

			WHERE a.`from_user_id` =$f_id and a.`to_user_id` = $t_id and a.`gig_id` = $g_id and a.`order_id` = $order_id;");

        	$result_array = $query_two->row_array();

			if($result)

			{

				$date       = new DateTime();

				$match_date = new DateTime($result['created_date']);

				$interval   = $date->diff($match_date);

				if($interval->days == 0) $tme = date(' h:i A',strtotime($result['created_date']));

				else  $tme = $interval->days.' Days ago ';

				$temp =1;

				$user_img='assets/images/avatar2.jpg';

				if($result['user_thumb_image']!=''){ $user_img =base_url().$result['user_thumb_image'];}

				$name= $result['fullname'];

				$comment= $result['comment'];

				$rating= $result['rating'];

				$user_feed.='<div class="feedback-area">

									<ul class="feedback-list">

										<li class="media">

											<a href="'.base_url().'user-profile/'.$result["username"].'" class="pull-left"><img width="26" height="26" alt="" src="'.$user_img.'"></a>

											<div class="media-body">

												<div class="feedback-info">

													<div class="feedback-author">

														<a href="'.base_url().'user-profile/'.$result["username"].'">'.$name.'</a>

													</div>

													<span class="feedback-time">'.$tme.'</span>

												</div>

												<script type="text/javascript" src="'.base_url().'assets/js/rating.js"></script>

												<p>'.$comment.' <span id="stars-existing" class="starrr" data-rating="'.$rating.'"></span></p>';

											  if($result_array){

												   $date       = new DateTime();

													$match_date1 = new DateTime($result_array['created_date']);

													$interval1   = $date->diff($match_date1);

													if($interval1->days == 0) $tme1 = date(' h:i A',strtotime($result_array['created_date']));

													else  $tme1 = $interval1->days.' Days ago ';

													$user_img1='assets/images/avatar2.jpg';

													if($result_array['user_thumb_image']!=''){ $user_img1 =base_url().$result_array['user_thumb_image'];}

													$name1= $result_array['fullname'];

													$comment1= $result_array['comment'];

													$rating1= $result_array['rating'];

												$user_feed.='<div class="media">

																<a href="'.base_url().'user-profile/'.$result_array["username"].'" class="pull-left"><img width="26" height="26" alt="" src="'.$user_img1.'"></a>

																<div class="media-body">

																	<div class="feedback-info">

																		<div class="feedback-author">

																			<a href="'.base_url().'user-profile/'.$result_array["username"].'">'.$name1.'</a>

																		</div>

																		<span class="feedback-time">'.$tme1.'</span>

																	</div>

																	<p>'.$comment1.'</p>

																</div>

															</div>';

												}

								$user_feed.='</div>

										</li>

									</ul>

								</div>';

			}

			else

			{

				$temp =2;

			}

		}

		echo json_encode( array('user_content'=>$html,'status'=>$temp,'user_feed'=>$user_feed,'f_id'=>$f_id,'t_id'=>$t_id,'g_id'=>$g_id,'order_id'=>$order_id,'s_image'=>$s_prof_img));

	}

	public function save_feedback()

	{

		$f_id=$this->input->post('rating_frmuser');

		$t_id=$this->input->post('rating_touser');

		$g_id=$this->input->post('rating_gig');

		$orderid=$this->input->post('rating_orderid');

		$comment=$this->input->post('comment');

		$rating_input=$this->input->post('rating_input');

		if($rating_input =='' || $rating_input==0)

		{

			$rating_input=1;

		}

		$from_timezone = $this->session->userdata('time_zone');

			$data['from_user_id'] = $t_id;

			$data['to_user_id'] = $f_id ; 

			$data['gig_id'] = $g_id;

			$data['order_id'] = $orderid;

			$data['rating']= $rating_input;

			$data['comment'] =$comment; 

			$data['time_zone'] =$from_timezone;

			date_default_timezone_set($from_timezone); 

		    $current_time= date('Y-m-d H:i:s');

			$data['created_date'] =$current_time;

			$data['	status'] =1;

			if($this->db->insert('feedback',$data))

			{

				$query = $this->db->query("SELECT sg.title,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,  sm.email as selleremail FROM `payments` as py

					LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	

					LEFT JOIN members as m ON m.USERID = py.USERID

					LEFT JOIN members as sm ON sm.USERID = py.seller_id

					WHERE py.`id` = $orderid");

				$data_one = $query->row_array();

				$title= $data_one['title'];

				$to_email= $data_one['selleremail'];

				$bodyid = 16;

				$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

				$body=$tempbody_details['template_content'];

				$message='';

				//$gig_preview_link  = base_url().'gig-preview/'.$title ;

				$gig_preview_link  = base_url().'sales/';

				$user_profile_link  = base_url().'user-profile/'.$data_one['buyerusername'];

						

				$body = str_replace('{base_url}', $this->base_domain, $body);

				$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

				$body = str_replace('{user_link}', $user_profile_link, $body);

				$body = str_replace('{gig_preview_link}', $gig_preview_link, $body);		 

				$body = str_replace('{buyer_name}', $data_one['buyername'], $body);

				$body = str_replace('{seller_name}', $data_one['sellername'], $body);

			    $body = str_replace('{site_name}',$this->site_name, $body);	

				$body = str_replace('{title}',str_replace("-"," ",$title), $body);

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

				$this->email->to($to_email); 

				$this->email->subject('Feedback from '.$data_one['buyername']);

				$this->email->message($message);

				if($this->email->send())

				{

					echo 1;

				}else{

					echo 1;

				}

			}

			else

			{

				echo 2;

			}

	}

	public function get_user_content()

	{

		$f_id=$this->input->post('f_id');

		$user_data = $this->user_panel_model->get_user_data($f_id); 

		$html ='';

		$prof_img    = base_url().'assets/images/avatar2.jpg';

		if($user_data['user_thumb_image'] != '') $prof_img = base_url().$user_data['user_thumb_image']; 

		$name=$user_data['fullname']; 

		$country=$user_data['country']; 

		$sortname ='';

		if($user_data['sortname']!='')

		{

			$sortname=$user_data['sortname']; 

		}

		$user_link_one=base_url().'user-profile/'.$user_data['username'];

		$temp='';

		$temp=1;

		$html .='<div class="pull-left user-img" style="margin-right: 10px;">

                            <a href="'.$user_link_one.'"><img src="'.$prof_img.'" alt="" class="w-40 img-circle"></a><span class="online"></span>

                        </div>

                        <div class="user-info pull-left">

                            <div class="dropdown">

                                <a href="'.$user_link_one.'">'.$name.'</a>

                            </div>

							<p class="text-muted m-0">'.$country.' <span class="ppcn country '.$sortname.'"></p>

                        </div>';

					

		echo json_encode( array('user_content'=>$html,'status'=>$temp));

	}

	public function get_purchase_details()

	{

		if($this->input->post()){



		$id=$this->input->post('id');

		$pay_data = $this->payment_model->get_payment_details($id);		 	 

		

		if(!empty($pay_data['gigs_id'])){



			$result_details = $this->db->get_where('sell_gigs',array('id' => $pay_data['gigs_id']))->row_array();	

			$gig_item_amount = $result_details['gig_price']; // Payment Price 

		}

		

		

		$_uid=$pay_data['seller_id'];



		$extra_gigs_ref = json_decode($pay_data['extra_gig_ref']);	

		$query_feed = $this->db->query("SELECT AVG(feedback.rating) FROM `feedback`  left join sell_gigs on sell_gigs.id = feedback.`gig_id` WHERE sell_gigs.user_id = $_uid AND feedback.`to_user_id` = $_uid;");	

		$fe_count = $query_feed->row_array();

		

		if(!empty($extra_gigs_ref))

		{

		$extra_gig_query = $this->db->query(" SELECT options , currency_type FROM user_required_extra_gigs WHERE id in ($extra_gigs_ref)");		 

		$extra_gig_result = $extra_gig_query->result_array();		 

		}

		$rat=0;

		if($fe_count['AVG(feedback.rating)']!='')

		{

			$rat=round($fe_count['AVG(feedback.rating)']);

		} 

		$country_name = $this->session->userdata('country_name');

		$this->data['gig_price'] = $this->gigs_model->gig_price();	

		$this->data['extra_gig_price'] = '';

		$extra_gig_price	=$this->gigs_model->extra_gig_price();

		if(!empty($extra_gig_price)){

			$this->data['extra_gig_price'] = implode("",$extra_gig_price);		

		}

		// $gig_rate = implode($this->data['gig_price']);// Fixed Price 

		$gig_rate = $gig_item_amount;  // Dynamic Price 

		$currency_option = (!empty($pay_data['currency_type']))?$pay_data['currency_type']:'USD';
		$rate_symbol = currency_sign($currency_option);
		$created_on = '-';

		if (isset($pay_data['created_at'])) {

			if (!empty($pay_data['created_at']) && $pay_data['created_at'] != "0000-00-00 00:00:00") {

				$created_on = date('M j, Y g:i A', strtotime($pay_data['created_at']));

			}

		}

			$status = $pay_data['seller_status'];

			

											if($status ==0) {

												$sts='Failed';

												$class='label-danger';

											}elseif($status ==1) {

												$sts='New';

												$class='label-success';

												if($pay_data['buyer_status'] ==1) { if($pay_data['cancel_accept'] ==1){

													$sts='Cancelled';

													$class='label-danger';

													if($pay_data['pay_status']=='Payment Processed'){

														$sts='Refunded';

													$class='label-info';

													}

												}

												}

											}elseif($status ==2){

												$sts='Pending';

												$class='label-warning';

												if($pay_data['buyer_status'] ==1) { if($pay_data['cancel_accept'] ==1){

													$sts='Cancelled';

													$class='label-danger';

													if($pay_data['pay_status']=='Payment Processed'){

														$sts='Refunded';

													$class='label-info';

													}

												}

												}

											}elseif($status ==3){

												$sts='Process';

												$class='label-primary';

												if($pay_data['buyer_status'] ==1) { if($pay_data['cancel_accept'] ==1){

													$sts='Cancelled';

													$class='label-danger';

													if($pay_data['pay_status']=='Payment Processed'){

														$sts='Refunded';

													$class='label-info';

													}

												}

												}

											}elseif($status ==4){

												$sts='Refunded';

												$class='label-danger';

											}elseif($status ==5){

												$sts='Declined';

												$class='label-danger';

											}elseif($status ==6){

												$sts='Completed';

												$class='label-success';

											}elseif($status ==7)

											{

												$sts='Complete request';

												$class='label-success';

											}

											$fead_stautus=0;

											if($status ==6) {

												

												$sts='Completed';

												$class='label-success';

											}

											else

											{

												$b_sts='Pending';

											}











			$image_url='assets/images/gig-small.jpg';

			if($pay_data['gig_image_thumb']!='')

			{

				$image_url=base_url().$pay_data['gig_image_thumb'];

			}

			$user_image_url=base_url().'assets/images/avatar2.jpg';

			if($pay_data['user_thumb_image']!='')

			{

				$user_image_url=base_url().$pay_data['user_thumb_image'];

			}

			$user_link_one=base_url().'user-profile/'.$pay_data['username'];

			$gig_link= base_url().'gig-preview/'.$pay_data['title'];

		$html='';

		

		$html_table_header = 	'<button type="button" class="close" data-dismiss="modal">&times;</button>

					<div class="modal-header text-center">

						<h5>Purchase Details</h5>

					</div>

					<div class="modal-body">

						<div class="row">

							<div class="col-md-6">

								<h5 class="order-number">#'.$pay_data['paypal_uid'].'</h5>

								<h5 class="order-date">'.$created_on.'</h5>

							</div>

							<div class="col-md-6">

								<div class="text-right summary">

									<span class="order-status '.$class.'">'.$sts.'</span>

								</div>

							</div>

						</div>

					<div class="table-responsive">

						<table class="table table-bordered">

							<thead>

								<tr>

									<th>Item</th>

									<th>Product Name</th>

									<th class="text-center">Quantity</th>

									<th class="text-right">Total</th>

								</tr>

							</thead>

							<tbody>

								<tr>

									<td><img src="'.$image_url.'" width="50" height="34" alt="'.$pay_data['title'].'"></td>

									<td>

										<a class="product_name text-ellipsis" href="'.$gig_link.'">'.ucfirst(str_replace("-"," ",$pay_data['title'])).'</a>

									</td>

									<td class="text-center"> 1 </td>									

									<td class="total text-right">'.$rate_symbol.$gig_rate.'</td>

								</tr>';

		$html_table_contents = '';

		$total = 0;

		if(!empty($extra_gig_result))

		{					

		$rupee_rate  = $this->session->userdata('rupee_rate');

		$dollar_rate = $this->session->userdata('dollar_rate');		

		foreach($extra_gig_result as $extras)

		{		

		$decoded_extras = 	json_decode($extras['options']);

		$gig_values =  explode('___',$decoded_extras);

		$currency_type = $gig_values[3];
		$currency_option = (!empty($currency_type))?$currency_type:'USD';
		$rate_symbol = currency_sign($currency_option);
		$rate = $gig_values[2];
		//$rate = $this->data['extra_gig_price'];

	 

			$total = $pay_data['item_amount'];

	 

			

			

		$html_table_contents .= '<tr>

									<td> &nbsp; </td>

									<td><span class="text-ellipsis">'.$gig_values[0].'</span></td>	

									<td class="text-center">'.$gig_values[1].'</td>

									<td class="total text-right">'.$rate_symbol.$rate.'</td>

								</tr>' ;	   	 	

		}

		}

		else

		{

			 

			$total = $pay_data['item_amount'];

			 

		}

		if($pay_data['payment_super_fast_delivery']==0)

		{

			$super_fast_delivery_desc = $pay_data['super_fast_delivery_desc'] ;

			if(empty($super_fast_delivery_desc))

			{

				$super_fast_delivery_desc = 'Super fast delivery';

			}

		//	if( $pay_data['currency_type']==1 || $pay_data['currency_type']==2 )

		//	{

			//$super_fast_delivery_charge = $pay_data['extra_gig_indian_rupee'];

			$super_fast_delivery_charge=$pay_data['extra_gig_dollar'];

		//	}

			

			$html_table_contents .= '<tr>

									<td> <span class="super-fast">Super Fast</span> </td>

									<td><span class="text-ellipsis">'.$super_fast_delivery_desc.'</span></td>	

									<td class="text-center">1</td>

									<td class="total text-right">'.$rate_symbol.$super_fast_delivery_charge.'</td>

								</tr>' ;

		}			

								

			$html_table_footer = '</tbody>

							<tfoot>								 

								<tr>

									<td></td>

									<td class="grand-total" colspan="2">Grand Total</td>

									<td class="grand-total text-right">'.$rate_symbol.$total.'</td>

								</tr>

							</tfoot>

						</table>



					</div>

					</div>

					<div class="modal-footer text-left">

						<h3 class="order-title">Seller details</h3>

						<div class="media secure-money">

							<div class="media-left">

								<a href="'.$user_link_one.'" ><img width="50" height="50" src="'.$user_image_url.'" class="img-circle" alt="'.$pay_data['fullname'].'"></a>

							</div>

							<div class="media-body">

								<div class="user-details">

								<div class="user-name-block">

									<a href="'.$user_link_one.'" class="user-name">'.$pay_data['fullname'].'</a>

								</div>

								<div class="user-contact">

									<ul class="list-inline">

										<li class="user-rating feedback-area">

										<script type="text/javascript" src="'.base_url().'assets/js/rating.js"></script>

										<span id="stars-existing" class="starrr" data-rating="'.$rat.'"></span></li>

										<li class="user-country2">FROM '.$pay_data['country'].' <span class="ppcn country '.$pay_data['sortname'].'"></li>

										<li class="contact-list"><a href="javascript:;" class="btn btn-primary btn-sm btn-border" onclick="message_contact_user();">Contact</a></li>

										<input type="hidden" name="sb_user_id" id="sb_user_id" value="'.$pay_data['seller_id'].'">

									</ul>

								</div>

							</div>

							</div>

						</div>

					</div>';				

			 $html = $html_table_header.$html_table_contents.$html_table_footer;

					echo json_encode( array('content'=>$html,'status'=>1));

	

		}else{

			    exit('No direct script access allowed');

		}

	}

	public function change_gigs_status()

	{



		$payment_soruce  = $this->input->post('payment_soruce');


		$p_id  = $this->input->post('p_id');

		$reason  = $this->input->post('sts');

		$pemail  = $this->input->post('pemail');

		$user_id = $this->session->userdata('SESSION_USER_ID');  

		if(strtolower($payment_soruce)=='paypal'){
		 
		$bank_query = $this->db->query("SELECT * FROM `bank_account` WHERE `user_id` = $user_id ");

		$rows = $bank_query->num_rows();

		if($rows>0){

			$data['paypal_email_id']     = $pemail;	

            $this->db->where('user_id',$user_id);

            $this->db->update('bank_account',$data);

		}else{

			$data['paypal_email_id']     = $pemail;	

 			$data['user_id']     = $user_id ;				 

            $this->db->insert('bank_account',$data);

		 }
		}elseif(strtolower($payment_soruce)=='stripe'){

			$bank_query = $this->db->query("SELECT * FROM `stripe_bank_details` WHERE `user_id` = $user_id ");
			$rows       = $bank_query->num_rows();
			$params     = $this->input->post();

			$data['account_holder_name'] = $params['account_holder_name'];	
			$data['account_number'] 	 = $params['account_number'];	
			$data['bank_name'] 			 = $params['bank_name'];	
			$data['bank_address']		 = $params['bank_address'];	
			$data['sort_code'] 			 = $params['sort_code'];	
			$data['routing_number']		 = $params['routing_number'];	
			$data['account_ifsc'] 		 = $params['account_ifsc'];	

			$data = array_filter($data);	
		
			if($rows>0){
            $this->db->where('user_id',$user_id);
            $this->db->update('stripe_bank_details',$data);
				}else{
 			$data['user_id']     = $user_id ;				 
            $this->db->insert('stripe_bank_details',$data);
 		 }

		}

		$from_timezone = $this->session->userdata('time_zone');

		$data_up['buyer_status'] = 1;

		$data_up['cancel_reason'] = $reason;

		$data_up['cancel_notification_status'] =1;

		date_default_timezone_set($from_timezone); 

		$current_time= date('Y-m-d H:i:s');

		$data_up['canceled_at'] =$current_time;

		if($this->db->update('payments',$data_up,array('id'=>$p_id)))

		{
			//seller mail function

			$query = $this->db->query("SELECT paypal_uid,item_amount,( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = payments.gigs_id LIMIT 0 , 1  ) as gig_image,payments.extra_gig_ref,payments.extra_gig_dollar,sg.gig_price, payments.seller_id   AS gsid, payments.USERID AS gbid  FROM `payments`    LEFT JOIN sell_gigs as sg ON sg.id = payments.gigs_id	 WHERE payments.id = $p_id");
			 
		 
			$data_one = $query->row_array();

			$email_details  = $this->gigs_model->gig_purchase_requirements($p_id);

			$seller_message = '';

			$welcomemessage = ''; 

			$toemail= $email_details['email']; 

			$gig_price = $this->gigs_model->gig_price();

			//$gig_price = '$'.$gig_price['value'];

			$gig_price = $this->default_currency_sign.$data_one['gig_price'];

			$extra_gig_price = $this->gigs_model->extra_gig_price();

        	$extra_gig_price = $extra_gig_price['value'];

			$extra_gig_ref = json_decode($email_details['extra_gig_ref']);

			$user_profile_link =  base_url().'user-profile/'.$email_details['buyer_username'];

			$order_id=$data_one['paypal_uid'];

			$title =$email_details['title'];

			$gig_preview_link  = base_url().'gig-preview/'.$title ;

			$img_path =base_url().$data_one['gig_image'];

			$gig_preview_link  = base_url().'gig-preview/'.$title ;

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

							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$this->default_currency_sign.' '.$extra_gig_price.'</td>

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

							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$this->default_currency_sign.' '.$extra_gig_price.'</td>

							</tr>';

			}

			$h_all.='<tr>

						<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>

						<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$data_one['item_amount'].'</td>

					</tr>';

			$request_link =base_url().'sales';		

			$bodyid = 24;

			$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

			$body = $tempbody_details['template_content'];

					

		$body = str_replace('{base_url}', $this->base_domain, $body);

		$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

			$body = str_replace('{gig_owner}', $email_details['seller_name'], $body);

			$body = str_replace('{buyer_name}',$email_details['buyer_name'], $body);

			$body = str_replace('{title}',str_replace("-"," ",$title), $body);	

			$body = str_replace('{gig_link}',$gig_preview_link, $body);

			$body = str_replace('{PAYPAL_ID}',$order_id, $body);

			$body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);	

			$body = str_replace('{PRICE}',$gig_price , $body);	

             $body = str_replace('{site_name}',$this->site_name, $body);				

			$body = str_replace('{BUYER_LINK}', $user_profile_link, $body);	

			$body = str_replace('{TEABLE_ROW}', $h_all, $body);

			$body = str_replace('{IMG_SRC}',$img_path , $body);

			$body = str_replace('{accept_link}',$request_link, $body);

			                    $seller_message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

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
			$this->email->subject('Order Cancelled From '.$email_details['buyer_name']);
			$this->email->message($seller_message);	 
			$this->email->send();

			  $cancelmessage = 'Order Cancelled From '.$email_details['buyer_name'];
			  $gsid = $data_one['gsid'];
			  $this->gigs->order_status_notification($gsid,$title,$cancelmessage);

			 
			echo 1;
		}else{
			echo 2;
		}
	}

	public function accept_seller_request()

	{

		$from_timezone = $this->session->userdata('time_zone');

		$p_id  = $this->input->post('p_id');

		$data_up['decline_accept'] = 1;

		$data_up['notification_status'] = 1;

		date_default_timezone_set($from_timezone); 

		$current_time= date('Y-m-d H:i:s');

		$data_up['update_date'] = $current_time;

		$pemail  = $this->input->post('pemail');

		$user_id = $this->session->userdata('SESSION_USER_ID');  

		$bank_query = $this->db->query("SELECT * FROM `bank_account` WHERE `user_id` = $user_id ");

		$rows = $bank_query->num_rows();

		if($rows>0){

			$data['paypal_email_id']     = $pemail;	

            $this->db->where('user_id',$user_id);

            $this->db->update('bank_account',$data);

		}else{

			$data['paypal_email_id']     = $pemail;	

 			$data['user_id']     = $user_id ;				 

            $this->db->insert('bank_account',$data);

		}

		if($this->db->update('payments',$data_up,array('id'=>$p_id)))

		{

			$query = $this->db->query("SELECT sg.title,m.fullname as buyername,m.username as buyerusername, sm.email as selleremail, sm.fullname as sellername,sm.username as sellerusername FROM `payments` as py

					LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	

					LEFT JOIN members as m ON m.USERID = py.USERID

					LEFT JOIN members as sm ON sm.USERID = py.seller_id

					WHERE py.`id` = $p_id");

			$data_one = $query->row_array();

			$title= $data_one['title'];

			$to_email= $data_one['selleremail'];

				$bodyid = 26;

				$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

				$body=$tempbody_details['template_content'];

				$message='';

				$gig_preview_link  = base_url().'gig-preview/'.$title ;

				$sales_link  = base_url().'sales/';

				//$body = str_replace('{PAYPAL_ID}', $order_id, $body);

						

					$body = str_replace('{base_url}', $this->base_domain, $body);

					$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

				$body = str_replace('{gig_preview_link}', $gig_preview_link, $body);		 

				$body = str_replace('{sales_link}', $sales_link, $body);		 

				$body = str_replace('{buyer_name}', $data_one['sellername'], $body);

				$body = str_replace('{site_name}', $this->site_name, $body);

				$body = str_replace('{gig_owner}', $data_one['buyername'], $body);

				$body = str_replace('{title}',str_replace("-"," ",$title), $body);

			

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
				$this->email->to($to_email); 
				$this->email->subject('Your Decline Request Accepted from '.$data_one['buyername']);
				$this->email->message($message);
				$this->email->send();
				echo 1;
		}else{
			echo 2;
		}
	}
} ?>