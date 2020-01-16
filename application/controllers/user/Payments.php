<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Payments extends CI_Controller {

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

        $this->data['module'] = 'payments';

		$this->load->model('user_panel_model');

		$this->load->model('payment_model');

		$this->load->model('gigs_model');

		$this->data['title'] = 'Gigs';

        $this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();  

        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();

        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();

		$this->data['system_setting'] = $this->user_panel_model->system_setting(); 		

		$this->data['gig_price'] = $this->gigs_model->gig_price(); 

		$this->data['gigs_country']             =  $this->gigs_model->gigs_country();

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

		$this->email_tittle =!empty($data['value']) ? $data['value'] : 'Gigs' ;

		}

		   if($data['key'] == 'logo_front'){

		$this->logo_front = base_url().$data['value'];

		}

		

		$this->data['currency_option'] = 'USD';

	  		if($data['key']=='currency_option'){

	 		$this->data['currency_option'] =$data['value'];

	 	}



		if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){

		$this->site_name = $data['value'];

		}



		}

		}

		if($this->session->userdata('SESSION_USER_ID')==''){ 

			redirect(base_url(''));

		}



    }

    public function index($offset=0) {

		 $this->load->library('pagination');

		 $config['base_url'] = base_url().'payments';

         $config['per_page'] = 20;                

         $config['total_rows'] =  $this->payment_model->getuser_wallets_details($this->session->userdata('SESSION_USER_ID'),0,0,0);   

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

		 $this->data['page_title'] = 'Payments';

		 $this->data['userid'] = $this->session->userdata('SESSION_USER_ID');

		 $this->data['order_count'] = $this->payment_model->get_user_orders_count($this->session->userdata('SESSION_USER_ID'));  

		 $this->data['sell_order_count'] = $this->payment_model->get_selluser_orders_count($this->session->userdata('SESSION_USER_ID')); 

		 $this->data['wallet_order_count'] = $this->payment_model->get_wallets_orders_count($this->session->userdata('SESSION_USER_ID'));

		 $this->data['order_details'] = $this->payment_model->getuser_wallets_details($this->session->userdata('SESSION_USER_ID'),1,$offset,$config['per_page']);  
		 
		 $this->data['page'] = 'index';

  		 $this->load->vars($this->data);  

		 $this->load->view($this->data['theme'].'/template');

    }

	public function get_user_feedback()

	{

		$f_id=$this->input->post('f_id');

		$t_id=$this->input->post('t_id');

		$g_id=$this->input->post('g_id');

		$user_data = $this->user_panel_model->get_user_data($t_id); 

		$html ='';

		$prof_img    = base_url().'assets/images/avatar2.jpg';

		if($user_data['user_thumb_image'] != '') $prof_img = base_url().$user_data['user_thumb_image']; 

		$name=$user_data['fullname']; 

		$country=$user_data['country']; 

		$html .='<div class="media">

					<div class="media-left">

						<img src="'.$prof_img.'" alt="" class="img-circle" width="50" height="50">

					</div>

					<div class="media-body">

						<div class="user-details">

						<div class="user-name-block">

							<a href="#" class="user-name">'.$name.'</a>

						</div>

						<div class="user-contact">

							<ul class="list-inline">

								<li class="user-rating"><span class="feed-stars five-star">(5)</span></li>

								<li class="user-country2">FROM '.$country.' </li>

								<li class="contact-list"><a href="javascript:;" class="btn btn-primary btn-sm btn-border" onclick="message_contact();">Contact</a></li>

							</ul>

						</div>

					</div>

					</div>

				</div>';

		$temp='';

		$user_feed='';		

		if($t_id)

		{

			$query = $this->db->query("SELECT a.*,cu.fullname,cu.user_thumb_image,cu.username FROM `feedback` as a 

			left join members cu on cu.USERID = a.from_user_id

			WHERE a.`from_user_id` = $t_id and a.`to_user_id` = $f_id and a.`gig_id` = $g_id;");

        	$result = $query->row_array();

			$query_two = $this->db->query("SELECT a.*,cu.fullname,cu.user_thumb_image,cu.username FROM `feedback` as a 

			left join members cu on cu.USERID = a.from_user_id

			WHERE a.`from_user_id` =$f_id and a.`to_user_id` = $t_id and a.`gig_id` = $g_id;");

        	$result_array = $query_two->row_array();

			if($result)

			{

				$temp =1;

				$user_img='assets/images/avatar2.jpg';

				if($result['user_thumb_image']!=''){ $user_img =base_url().$result['user_thumb_image'];}

				$name= $result['fullname'];

				$comment= $result['comment'];

				$rating= $result['rating'];

				$user_feed.='<div class="feedback-area">

									<ul class="feedback-list">

										<li class="media">

											<a href="#" class="pull-left"><img width="26" height="26" alt="" src="'.$user_img.'"></a>

											<div class="media-body">

												<div class="feedback-info">

													<div class="feedback-author">

														<a href="javascript:;">'.$name.'</a>

													</div>

													<span class="feedback-time">1 week ago</span>

												</div>

												<p>'.$comment.'  <span class="feed-stars five-star"></span></p>';

									if($result_array){

										$user_img1='assets/images/avatar2.jpg';

										if($result_array['user_thumb_image']!=''){ $user_img1 =base_url().$result_array['user_thumb_image'];}

										$name1= $result_array['fullname'];

										$comment1= $result_array['comment'];

										$rating1= $result_array['rating'];

									$user_feed.='<div class="media">

													<a href="javascript:;" class="pull-left"><img width="26" height="26" alt="" src="'.$user_img1.'"></a>

													<div class="media-body">

														<div class="feedback-info">

															<div class="feedback-author">

																<a href="javascript:;">'.$name1.'</a>

															</div>

															<span class="feedback-time">6 days ago</span>

														</div>

														<p>'.$comment1.'</p>

													</div>

												</div>';

									}else{

											

                                           $user_feed.=' <form action="" type="post" id="feedback_rating_form">

                                                <input type="hidden" id="rating_frmuser" value="'.$t_id.'" name="rating_frmuser" />

                                                <input type="hidden" id="rating_touser" value="'.$f_id.'" name="rating_touser" />

                                                <input type="hidden" id="rating_gig" value="'.$g_id.'" name="rating_gig" />

                                                <div class="row">

                                                    <div class="form-group clearfix">

                                                        <div class="col-md-12">

                                                            <textarea rows="4" class="form-control" name="comment" id="comment" placeholder="Comment"></textarea>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <span id="stars-existing" class="starrr" data-rating="1"></span> 

                                                        <input type="hidden" id="rating_input" value="" name="rating_input" />

                                                    </div>

                                                    <div class="col-md-6 text-right">

                                                        <input type="button" value="Send Feedback" onclick="submit_comment();" class="btn btn-primary btn-border" data-loading-text="Loading...">

                                                    </div>

                                                </div>

                                            </form>';

											

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

		echo json_encode( array('user_content'=>$html,'status'=>$temp,'user_feed'=>$user_feed,'f_id'=>$f_id,'t_id'=>$t_id,'g_id'=>$g_id));

	}

	public function save_feedback()

	{

		$f_id=$this->input->post('rating_frmuser');

		$t_id=$this->input->post('rating_touser');

		$g_id=$this->input->post('rating_gig');

		$comment=$this->input->post('comment');

		$rating_input=$this->input->post('rating_input');

			$data['from_user_id'] = $f_id;

			$data['to_user_id'] = $t_id; 

			$data['gig_id'] = $g_id;

			$data['rating']= $rating_input;

			$data['comment'] =$comment; 

			$data['created_date'] =date('Y-m-d H:i:s');

			$data['	status'] =1;

			if($this->db->insert('feedback',$data))

			{

				echo 1;

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

							<p class="text-muted m-0">'.$country.'</p>

                        </div>';

					

		echo json_encode( array('user_content'=>$html,'status'=>$temp));

	}

	public function change_gigs_status()

	{

		$p_id = $this->input->post('p_id');

		$sts  = $this->input->post('sts');

		$data_up['seller_status'] = $sts;

		if($this->db->update('payments',$data_up,array('id'=>$p_id)))

		{

			echo 1;

		}

		else

		{

			echo 2;

		}

	}

	public function get_sales_details()

	{

		

		$id=$this->input->post('id');

		$pay_data = $this->payment_model->get_salespayment_details($id); 

		if(!empty($pay_data['gigs_id'])){



			$result_details = $this->db->get_where('sell_gigs',array('id' => $pay_data['gigs_id']))->row_array();	

			$gig_item_amount = $result_details['gig_price']; // Payment Price 

		}

		

		$extra_gigs_ref = json_decode($pay_data['extra_gig_ref']);		

		if(!empty($extra_gigs_ref))

		{

		$extra_gig_query = $this->db->query(" SELECT options, currency_type  FROM user_required_extra_gigs WHERE id in ($extra_gigs_ref)");		 

		$extra_gig_result = $extra_gig_query->result_array();		 

		}

		$country_name = $this->session->userdata('country_name');

		$this->data['gig_price'] = $this->gigs_model->gig_price();

		$_sprice = $this->gigs_model->extra_gig_price();

		$this->data['extra_gig_price'] ='';	

		if (!empty($_sprice)) {

		$this->data['extra_gig_price'] = implode("",$_sprice);

		}

		$gig_rate = $gig_item_amount;  // Dynamic Price 		

		 

		$currency_option = (!empty($pay_data['currency_type']))?$pay_data['currency_type']:'USD';
		$rate_symbol = currency_sign($currency_option);



		$_uid=$pay_data['USERID'];

		$query_feed = $this->db->query("SELECT AVG(feedback.rating) FROM `feedback`

			     left join sell_gigs on sell_gigs.id = feedback.`gig_id`

			     WHERE sell_gigs.user_id = $_uid AND feedback.`to_user_id` = $_uid;");

		$fe_count = $query_feed->row_array();

		$rat=0;

		if($fe_count['AVG(feedback.rating)']!='')

		{

			$rat=round($fe_count['AVG(feedback.rating)']);

		} 

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

			} elseif($status ==1) {

				$sts='New';

				$class='label-success';

			}elseif($status ==2){

				$sts='Pending';

				$class='label-warning';

			}elseif($status ==3){

				$sts='Process';

				$class='label-primary';

			}elseif($status ==4){

				$sts='Refunded';

				$class='label-danger';

			}elseif($status ==5){

				$sts='Cancelled';

				$class='label-danger';

			}elseif($status ==6){

				$sts='Completed';

				$class='label-success';

			}else{

				$sts='Pending';

				$class='label-warning';

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

		

		

		

		$html_table_header = '<button type="button" class="close" data-dismiss="modal">&times;</button>

					<div class="modal-header text-center">

						<h5>Sales Details</h5>

					</div>

					<div class="modal-body">

						<div class="row">

							<div class="col-md-6">

								<h5 class="order-number">#'.$pay_data['paypal_uid'].'</h5>

								<h5 class="order-date">'.$created_on.'</h5>

							</div>

							<div class="col-md-6">

								<div class="text-right summary">

									<span class="order-status status-new">'.$sts.'</span>

								</div>

							</div>

						</div>

					<div class="table-responsive">

						<table class="table table-bordered">

							<thead>

								<tr>

									<th>Item</th>

									<th>Product Name</th>

									<th>Quantity</th>

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

									if(!empty($extra_gig_result))

									{		

									$rupee_rate  = $this->session->userdata('rupee_rate');

									$dollar_rate = $this->session->userdata('dollar_rate');														

									foreach($extra_gig_result as $extras)

									{				

										$decoded_extras = 	json_decode($extras['options']);

									$gig_values =  explode('___',$decoded_extras);	

									$currency_type = $gig_values[3];	
									$currency_option = (!empty($extras['currency_type']))?$extras['currency_type']:'USD';
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

										   

									$currency_option = $pay_data['currency_type'];
									$currency_option = (!empty($pay_data['currency_type']))?$pay_data['currency_type']:'USD';
									$rate_symbol = currency_sign($currency_option);
 

									$total = $pay_data['item_amount'];

 

											

									}

									if($pay_data['payment_super_fast_delivery']==0)

									{

										$super_fast_delivery_desc = $pay_data['super_fast_delivery_desc'] ;

										if(empty($super_fast_delivery_desc))

										{

											$super_fast_delivery_desc = 'Super fast delivery';

										}

										 

										//$super_fast_delivery_charge = $pay_data['extra_gig_indian_rupee'];

										//$super_fast_delivery_charge= number_format((float)$pay_data['extra_gig_indian_rupee']);

										$super_fast_delivery_charge=$pay_data['extra_gig_dollar'];

										 

									

										$html_table_contents .= '<tr>

																<td> <span class="super-fast">Super Fast</span> </td>

																<td><span class="text-ellipsis">'.$super_fast_delivery_desc.'</span></td>	

																<td class="text-center">1</td>

																<td class="total text-right">'.$rate_symbol.$super_fast_delivery_charge.'</td>

															</tr>' ;

									}				

															

								

				$html_table_footer =	'</tbody>

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

						<h3 class="order-title">Buyer details</h3>

						<div class="media secure-money">

							<div class="media-left">

								<a href="'.$user_link_one.'"><img width="50" height="50" src="'.$user_image_url.'" class="img-circle" alt="'.$pay_data['fullname'].'"></a>

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

											<span id="stars-existing" class="starrr" data-rating="'.$rat.'"></span>

										</li>

										<li class="user-country2"><b>From:</b> '.$pay_data['country'].' <span class="ppcn country '.$pay_data['sortname'].'"></li>

										<li class="contact-list"><a href="javascript:;" class="btn btn-primary btn-sm btn-border" onclick="message_contact_user();">Contact</a></li>

										<input type="hidden" name="sb_user_id" id="sb_user_id" value="'.$pay_data['USERID'].'">

									</ul>

								</div>

							</div>

							</div>

						</div>

					</div>';

					 $html = $html_table_header.$html_table_contents.$html_table_footer;

					echo json_encode( array('content'=>$html,'status'=>1));

	}

	public function withdram_details()

	{

		$id=$this->input->post('id');

		$pay_data = $this->payment_model->get_salespayment_details($id); 

		 $created_on = '-';

		if (isset($pay_data['created_at'])) {

			if (!empty($pay_data['created_at']) && $pay_data['created_at'] != "0000-00-00 00:00:00") {

				$created_on = date('M j, Y g:i A', strtotime($pay_data['created_at']));

			}

		}

			$image_url='assets/images/gig-small.jpg';

			if($pay_data['image_path']!='')

			{

				$image_url=base_url().$pay_data['image_path'];

			}

			$title=$pay_data['title'];

			//$amt=$pay_data['item_amount']; 

			$country_name = $this->session->userdata('country_name');

			

			$currency_option = $pay_data['currency_type'];

			$rate_symbol = '$';

			if(!empty($currency_option)=='USD'){ $rate_symbol = '$'; }

			if(!empty($currency_option)=='EUR'){ $rate_symbol = '€'; }

			if(!empty($currency_option)=='GBP'){ $rate_symbol = '£'; }	

			$amt = $pay_data['item_amount'];

			





			$gig_link= base_url().'gig-preview/'.$pay_data['title'];

		$html='';

		$html.='<table class="table table-bordered">

					<thead>

						<tr>

							<th>Item</th>

							<th>Product Name</th>

							<th class="text-right">Total</th>

						</tr>

					</thead>

					<tbody>

						<tr>

							<td><img width="50" height="34" src="'.$image_url.'" alt="'.$pay_data['title'].'"></td>

							<td>

								<a href="'.$gig_link.'" class="product_name text-ellipsis">'.ucfirst(str_replace("-"," ",$title)).'</a>

							</td>

							<td class="total text-right">'.$rate_symbol.$amt.'</td>

						</tr>

					</tbody>

				</table>';

					

					echo json_encode( array('content'=>$html,'status'=>1,'amount'=>$amt,'id'=>$id));

	}

	public function payment_request()

	{

		$p_id = $this->input->post('id');

		$data_up['payment_status'] = 1;

		if($this->db->update('payments',$data_up,array('id'=>$p_id)))

		{

			$message ='';

			$query = $this->db->query("SELECT py.item_amount,py.payment_super_fast_delivery,py.paypal_uid,sg.title,sg.super_fast_delivery_desc,sg.currency_type,sg.user_id,gi.gig_image_thumb,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,sg.gig_price,py.extra_gig_ref,py.extra_gig_dollar FROM `payments` as py

				LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	

				LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  

				LEFT JOIN members as m ON m.USERID = py.USERID

				LEFT JOIN members as sm ON sm.USERID = py.seller_id

				WHERE py.`id` = $p_id");

			    

				$data_one = $query->row_array();  

 

			  $gig_price = '$'.$data_one['gig_price']; // Dynamic price 

			  $extra_gig_price = $data_one['extra_gig_dollar'];

			   

			  $extra_gig_ref = json_decode($data_one['extra_gig_ref']);

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

			

			if($data_one['payment_super_fast_delivery']==0)

			{

				$sup_dec='Super fast delivery'; 

				if(!empty($data_one['super_fast_delivery_desc']))

				{

					$sup_dec=$data_one['super_fast_delivery_desc'];

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

				

				$this->load->model('templates_model');

				

				$bodyid = 20;

				$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

				$body=$tempbody_details['template_content'];

				$title = $data_one['title'];

				$img_path =base_url().$data_one['gig_image_thumb'];

				$gig_preview_link  = base_url().'gig-preview/'.$title ;

				//$user_profile_link = base_url().'user_profile/'.$username;

				$body = str_replace('{PAYPAL_ID}', $data_one['paypal_uid'], $body);

				$body = str_replace('{buyer_name}', $data_one['buyername'], $body);

				$body = str_replace('{seller_name}', $data_one['sellername'], $body);

				$body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);

			    $body = str_replace('{site_name}',$this->site_name, $body);			

				//$body = str_replace('{PRICE}', $data_one['item_amount'], $body);

				 $body = str_replace('{PRICE}', $gig_price, $body); 

				

				$body = str_replace('{TEABLE_ROW}', $h_all, $body);

				$body = str_replace('{IMG_SRC}',$img_path , $body);

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

				$this->email->subject('Payment Request from '.$data_one['sellername']);

				$this->email->message($message);

				$url_parts = parse_url(current_url());

				

				if($url_parts['host'] !='localhost'){

					$this->email->send();

				}

				echo 1;		

			

		}

		else

		{

			echo 2;

		}

	}

	public function overall_payment_request()

	{

		$p_id = $this->input->post('sts');

		$data_up['payment_status'] = 1;

		$s_sts=6;

		$p_id= $this->session->userdata('SESSION_USER_ID');

			$query = $this->db->query("SELECT py.item_amount,py.paypal_uid,sg.title,sg.currency_type,sg.user_id,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,

			(SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb

			 FROM `payments` as py

				LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	

				LEFT JOIN members as m ON m.USERID = py.USERID

				LEFT JOIN members as sm ON sm.USERID = py.seller_id

				WHERE py.`seller_id` = $p_id AND py.`seller_status` =6 AND py.`payment_status` =0" );

		$data_one = $query->result_array();

		if($this->db->update('payments',$data_up,array('seller_id'=>$this->session->userdata('SESSION_USER_ID'),'seller_status'=>$s_sts,'payment_status'=>0)))

		{

			$message ='';

			

			$h_all='';

			foreach ($data_one as $data_res)

			{

				$h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$data_res['paypal_uid'].'</td>

																	<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

																		<a style="color:#bbadfc;" href="javascript:;" >'.str_replace("-"," ",$data_res['title']).'</a>

																	</td>

																	<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$data_res['buyername'].'</td>

                                                                    <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$data_res['item_amount'].'</td></tr>';

			}

				$this->load->model('templates_model');

				

				$bodyid = 21;

				$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

				$body=$tempbody_details['template_content'];

				$img_path =base_url().$data_one[0]['gig_image_thumb'];

				$body = str_replace('{seller_name}', $data_one[0]['sellername'], $body);

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

				$this->email->subject('Payment Request from '.$data_one[0]['sellername']);

				$this->email->message($message);

				$this->email->send();

			echo 1;

		}

		else

		{

			echo 2;

		}

	}

	

	public function check_user_account()

	{

			$source = $this->input->post('source');
			$source = explode('-', $source);
     	    if(count($source) == 1){
     	    	$source = current($source);
     	    }else{

     	    }

			if($source == 'stripe'){

				$user_id    = $this->session->userdata('SESSION_USER_ID');  
				$bank_query = $this->db->query("SELECT * FROM stripe_bank_details WHERE `user_id` = $user_id ");
				$total_rows = $bank_query->num_rows();
				echo $total_rows;	
				die();

			}else if($source == 'paypal'){

				$user_id    = $this->session->userdata('SESSION_USER_ID');  
				$bank_query = $this->db->query("SELECT * FROM `bank_account` WHERE `user_id` = $user_id ");
				$total_rows = $bank_query->num_rows();
				echo $total_rows;	
				die();

			}else{
				
				$user_id    = $this->session->userdata('SESSION_USER_ID');  
				$bank_query = $this->db->query("SELECT * FROM stripe_bank_details WHERE `user_id` = $user_id ");
				$total_rows1 = $bank_query->num_rows();

				$bank_query = $this->db->query("SELECT * FROM `bank_account` WHERE `user_id` = $user_id ");
				$total_rows2 = $bank_query->num_rows();

				$total_rows = $total_rows1 + $total_rows2;
				echo $total_rows;	
				die();

			}
	}

	public function checkandfillaccount()
	{
		$user_id    = $this->session->userdata('SESSION_USER_ID');  
		if(!empty($user_id)){
		$bank_query = $this->db->query("SELECT * FROM stripe_bank_details WHERE `user_id` = $user_id ");
		$total_rows1 = $bank_query->num_rows();
		$bank_details = array();
		$bank_details['stripe_details'] = array();
		if($total_rows1 > 0){
			$bank_details['stripe_details'] = $bank_query->row_array();
		}
		
		$bank_query = $this->db->query("SELECT paypal_email_id FROM `bank_account` WHERE `user_id` = $user_id ");
		$total_rows2 = $bank_query->num_rows();
		if($total_rows2 > 0){
		 $result =  $bank_query->row_array();
		 $bank_details['paypal_details'] = $result['paypal_email_id'];
		}
		echo json_encode($bank_details);
		die();
	 }
	}

	function add_paypal_details()

	{

		

		if($this->input->post()){

			

			$inputs = $this->input->post();

			if($inputs['source'] =='paypal'){

				$p_id = $this->input->post('p_id');

				$data_up['paypal_email_id'] = $p_id;

				$data_up['user_id'] = $this->session->userdata('SESSION_USER_ID');

				if($this->db->insert('bank_account',$data_up))

				{

					echo 1;

				}else{

					echo 2;

				}

			}elseif($inputs['source'] =='stripe'){

				unset($inputs['source']);
				$inputs['user_id'] = $this->session->userdata('SESSION_USER_ID');
				if($this->db->insert('stripe_bank_details',$inputs))
				{
					echo 1;
				}else{
					echo 2;
				}
			}elseif($inputs['source'] =='paypal-stripe' || $inputs['source'] =='stripe-paypal'){

				unset($inputs['source']);
				
				$paypal_id = $inputs['user_paypal_id'];
				
				$user_id   = $this->session->userdata('SESSION_USER_ID');

				$this->db->where('user_id', $user_id);
				$count  = $this->db->count_all_results('bank_account');
				$p = 0;

					$data_up = array();
					$data_up['paypal_email_id']  = $paypal_id;
					$data_up['user_id']          = $user_id;
					
				if($count == 0){
					
					$p = $this->db->insert('bank_account',$data_up);
				}else{
					$this->db->where('user_id', $user_id);
					$p = $this->db->update('bank_account',$data_up);
				}
				
				$s = 0;

				$this->db->where('user_id', $user_id);
				$count1  = $this->db->count_all_results('stripe_bank_details');
				if($count1 == 0 ){
					unset($inputs['user_paypal_id']);
					$inputs['user_id'] = $user_id;
				    $s = $this->db->insert('stripe_bank_details',$inputs);
				}else{
					
					unset($inputs['user_paypal_id']);
					$inputs['user_id'] = $user_id;

					$this->db->where('user_id', $user_id);
					$s = $this->db->update('stripe_bank_details',$inputs);
				}
				

				if($s && $p){
					echo 1;
				}else{
					echo 2;
				}
			}

		}

		die();

	}

	function add_stripe_details()

	{

		if(($this->session->userdata('SESSION_USER_ID')))

		{

		    $user_id = $this->session->userdata('SESSION_USER_ID');

		    $bank_query = $this->db->query("SELECT * FROM `stripe_bank_details` WHERE `user_id` = $user_id ");

    		$rows = $bank_query->num_rows();

		if($this->input->post()){

			$inputs = array();

			$inputs['user_id'] = $this->session->userdata('SESSION_USER_ID');

			$inputs['account_holder_name'] = $this->input->post('account_holder_name');

			$inputs['account_number'] = $this->input->post('account_number');

			$inputs['account_iban'] = $this->input->post('account_iban');

			$inputs['bank_name'] = $this->input->post('bank_name');

			$inputs['bank_address'] = $this->input->post('bank_address');

			$inputs['sort_code'] = $this->input->post('sort_code');

			$inputs['routing_number'] = $this->input->post('routing_number');

			$inputs['account_ifsc'] = $this->input->post('account_ifsc');

			if($rows>0)

     		{		

			$this->db->where('user_id',$user_id);

				if($this->db->update('stripe_bank_details',$inputs))

				{
					$message='Your Stripe Account successfully updated.';

			        $this->session->set_flashdata('message',$message);

			        redirect(base_url().'payment-settings');
			    }
			}else{

				if($this->db->insert('stripe_bank_details',$inputs))

				{
					$message='Your Stripe Account updated successfully .';

			        $this->session->set_flashdata('message',$message);

			        redirect(base_url().'payment-settings');
			    }

			}

		}
	}
}

	

}

?>