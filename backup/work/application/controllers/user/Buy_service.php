<?php 
class Buy_service extends CI_Controller{

	public function __construct() {

		parent::__construct();  
		$this->load->helper('currency');
		$this->load->library('paypal_lib');

		$this->load->model('gigs_model');

		$this->load->model('user_panel_model');

		

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



		$this->data['theme'] = 'user';              
        $this->data['logo']                     = $this->user_panel_model->get_logo();
		$this->data['slogan']                    = $this->user_panel_model->get_slogan();

		$this->data['footer_main_menu']			 = $this->user_panel_model->footer_main_menu();

		$this->data['footer_sub_menu'] 			 = $this->user_panel_model->footer_sub_menu();

		$this->data['system_setting'] 			 = $this->user_panel_model->system_setting();    

		$this->data['policy_setting'] 			 = $this->user_panel_model->policy_setting();  	

		$this->data['categories_subcategories']  = $this->user_panel_model->categories_subcategories();

        //$this->data['rupee_dollar_rate']         = $this->user_panel_model->get_rupee_dollar_rate();

		

		$this->data['country_list']       = $this->user_panel_model->country_list(); 

		

		$this->email_address='mail@example.com';

		$this->email_tittle='Gigs';

		$this->logo_front=base_url().'assets/images/logo.png';

		$this->site_name ='gigs';

		

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



				$this->data['currency_option'] = 'USD';

	  			if($data['key']=='currency_option'){

	 				$this->data['currency_option'] =$data['value'];

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

		//$rupee_dollar_rate 						 = $this->data['rupee_dollar_rate'];

		if(($this->session->userdata('time_zone')))

		{       

			$this->data['time_zone'] = $this->session->userdata('time_zone');        

			$this->data['full_country_name'] = $this->session->userdata('full_country_name');

			$this->data['country_name'] = $this->session->userdata('country_name');       

			// Start Here always get DB Currency Rate And Set into Session

			//	$this->session->set_userdata('dollar_rate',$rupee_dollar_rate['dollar_rate']); 

			//	$this->session->set_userdata('rupee_rate',$rupee_dollar_rate['indian_rate']);

			// End 	

			$this->data['dollar_rate'] = $this->session->userdata('dollar_rate');  

			$this->data['rupee_rate'] = $this->session->userdata('rupee_rate'); 

		}        

		else             

		{

			$user_ip = getenv('REMOTE_ADDR');     

        /*$this->data['dollar_rate'] 			=  $rupee_dollar_rate['dollar_rate'] ;  

        $this->data['rupee_rate']  			=  $rupee_dollar_rate['indian_rate']; */

        if(isset($this->data['dollar_rate'])){

        	$this->session->set_userdata('dollar_rate',$this->data['dollar_rate']); 	

        }

        if(isset($this->data['rupee_rate'])){

        	$this->session->set_userdata('rupee_rate',$this->data['rupee_rate']);               

        }

    }





    $gig_price = $this->gigs_model->gig_price();
    $this->data['gigs_country']             =  $this->gigs_model->gigs_country();

    $this->data['gig_price'] = $gig_price['value'];

    $extra_gig_price = $this->gigs_model->gig_price();

    $this->data['extra_gig_price'] = $extra_gig_price['value'];
    $this->data['gigs_country']             =  $this->gigs_model->gigs_country();

}

public function index($offset=0)

{  

	

	$uid = '';

	if(isset($this->session->userdata)){

		$userid = $this->session->userdata;	

		if(isset($userid['SESSION_USER_ID'])){

			$uid = $userid['SESSION_USER_ID'];	

		}



	}





	$this->data['page_title'] = 'Buy Service';

	$this->load->library('pagination');

	$config['base_url'] = base_url().'buy-service';

	$config['per_page'] = 16;                

	$config['total_rows'] =  $this->gigs_model->buy_service(0,0,0,$uid);   

	$this->data['total_records'] = $config['total_rows']; 



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

	$this->data['total_results'] =count($this->data['list']);

	$this->load->vars($this->data);    

	$this->load->view($this->data['theme'] . '/template'); 



}  

public function payment()

{

	
	if($this->input->post('submit'))

	{ 

		$from_timezone = "Asia/Calcutta";	
		// var_dump($from_timezone);	   
		date_default_timezone_set($from_timezone); 
		$current_time= date('Y-m-d H:i:s');
		$package_finesh_day_set =(int) $this->input->post('package_finesh_day_set');
		$data['package_id']     = $this->input->post('package_id_set');
		$data['seller_name']   = $this->site_name;
		$item_amount     = $this->input->post('package_rate_set');
		$data['USERID']          = $this->session->userdata('SESSION_USER_ID');
		// $extra_gig_ref   = json_encode($this->input->post('extra_gig_row_id'));
		$currency_symbol   =  $this->input->post('currency_type_set');
		$dollar_rate       = $this->session->userdata('dollar_rate');
		$data['time_zone'] = $from_timezone;
	   // $rate = ( $item_amount * $dollar_rate );
		$data['item_amount']    	  =  $item_amount;
		$data['dollar_amount']     = $item_amount ;		
	 

		$amount              =   $data['dollar_amount'];

		// $data['extra_gig_ref'] = '';

		if($currency_symbol=="$"){ $currency_type = 'USD';}

		if($currency_symbol=="€"){ $currency_type = 'EUR';}

		if($currency_symbol=="£"){ $currency_type = 'GBP';}

		$data['currency_type']  =  $currency_type; 

		$data['currency']  =  $currency_type; 


           	$query = $this->db->query("SELECT * FROM `membership` WHERE `id` = '". $this->input->post('package_id_set')."'" );
		$dataname = $query->row_array();
		// if(!empty($extra_gig_ref))

		// {

		// 	$data['extra_gig_ref'] = $extra_gig_ref;

		// }

		// $super_fast_delivery = $this->input->post('hidden_super_fast_delivery');

		// $hidden_super_fast_delivery_charges = $this->input->post('hidden_super_fast_delivery_charges');

		// $data['payment_super_fast_delivery'] = 1 ;
       if($dataname["types"]=="Addon")
       {

        
        $get_duration_for_adone=$dataname['duration'];
          
          $days_set=(int)$get_duration_for_adone*7;
                   
          $count_user=$this->db->query("select count(id) from user_addon where package_id='".$dataname["id"]."' and (status='Running' or status='Pending')")->row_array();
   
          if($dataname['values']<=$count_user["count(id)"])
          {
             
                $count_user_last_date=$this->db->query("select * from user_addon where package_id='".$dataname["id"]."' and (status='Running') ORDER BY `user_addon`.`id` DESC limit 1")->row_array();

                $data['package_fininish_date'] 	= "";	 
		    $data['package_fininish_date_in_string'] 	 =  "";
          } 
          else
          {
          	$data['package_fininish_date'] 				 =  "";	 
		    $data['package_fininish_date_in_string'] 	 =  "";
          }

        
		
       }
      else
      {
      	 $days_set=$package_finesh_day_set;
		$data['package_fininish_date'] 				 =  Date('d-M-Y', strtotime("+".$days_set." month"));	 
		$data['package_fininish_date_in_string'] 	 =  strtotime(Date('d-M-Y', strtotime("+".$days_set." month")));
      }
    	 



		

		$_sprice = $this->gigs_model->gig_price();

		if (!empty($_sprice)) {

			$s_price =  implode("",$_sprice);

		}



		   //$data['gig_price_dollar_rate']     = ($s_price / $this->data['dollar_rate']);

		$data['created_at']  = $current_time;
		$data['created_at_date']  = date("d-M-Y H:m:sa");
		$data['created_at_date_in_string']  = strtotime(date("d-M-Y"));

		$data['status']      = 1;

		$data['commision']   = 0;		   

		$data['source']      = 'paypal';	

		$_id=$this->input->post('package_id_set');

	

		

		$package_name= str_replace("-"," ",$dataname['name']);

 
$res=$this->db->insert('payments',$data);
// var_dump($this->db->last_query());
		if($res){

			$users_tbl_id  = 	$this->db->insert_id(); 

			$type =1; 

			$amount_1	=intval(($amount*100))/100;

			$this->buy($users_tbl_id,$amount_1,$type,$package_name,$currency_type);

		}

	}
}

function buy($id,$amount,$user_id,$g_name,$currency_type){

		//Set variables for paypal form

		$returnURL =base_url($this->data['theme'] .'/buy_service/paypal_success/'); //payment success url

		$cancelURL = base_url($this->data['theme'] .'/buy_service/paypal_cancel'); //payment cancel url

		$notifyURL = base_url().'user/buy_service/ipn'; //ipn url

		$userID = $user_id; //current user id

		$name =$g_name;

		$this->paypal_lib->add_field('return', $returnURL);

		$this->paypal_lib->add_field('cancel_return', $cancelURL);

		$this->paypal_lib->add_field('notify_url', $notifyURL);

		$this->paypal_lib->add_field('item_name', $name);

		$this->paypal_lib->add_field('custom', $userID);

		$this->paypal_lib->add_field('item_number',  $id);

		$this->paypal_lib->add_field('amount',  $amount);		

		$this->paypal_lib->add_field('currency_code', $currency_type);		

		//$this->paypal_lib->image($logo);



		

		$this->paypal_lib->paypal_auto_form();

	}

	function paypal_success(){



	    //get the transaction data

		$paypalInfo =  $this->input->get();

		//$paypalInfo =  $this->input->get();

		$user_pay_id = $this->input->get('Ad');

		$message='';       

		$order_id= $paypalInfo['tx'];         

		$table_data['paypal_uid'] = $paypalInfo['tx'];

		// $table_data['seller_status'] = 1;

		$uid = $paypalInfo['item_number'];               

		$this->db->where('id',$uid);

		$this->db->update('payments', $table_data);

		// $query = $this->db->query("SELECT py.item_amount,py.currency_type as paymentcurrency,sg.name,gi.gig_image_thumb,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,sg.gig_price,py.extra_gig_ref,py.extra_gig_dollar FROM `payments` as py

		// 	LEFT JOIN membership as sg ON sg.id = py.gigs_id	

		// 	LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  

		// 	LEFT JOIN members as m ON m.USERID = py.USERID

		// 	LEFT JOIN members as sm ON sm.USERID = py.seller_id

		// 	WHERE py.`id` = $uid");

		// $data_one = $query->row_array();

		$data_one=$this->db->query("SELECT a.*,b.*,c.*,c.types as package_types from payments as a,user_login as b,membership as c where c.id=a.package_id and b.USERID=a.USERID and a.id='".$uid."'")->row_array();

		$title = $data_one['name'];
$user_package_link  = base_url()."".strtolower($data_one['types']).'-profile/'.$data_one['USERID']."/".implode("-",explode(" ", $data_one['fullname']));

if($data_one['package_types']='Addon')
{

$package_preview_link=base_url().'addon/';

}
else
{
	$package_preview_link=base_url().'price-table-for/'.$data_one['types'];

}
		if(!empty($logo['value']))
		{
			$img_path =  base_url().$logo['value']; 
		}
		else { 

			$img_path =  base_url()."assets/images/logo.png";
     }
		//$url=base_url().'user_profile/'.$username;                                         

		$this->load->model('templates_model');

		

		//seller mail function

		// $email_details  = $this->gigs_model->package_purchase_requirements($uid);

		$seller_message = '';

		$welcomemessage = ''; 

		$toemail= $data_one['email']; 

		$gig_price = $this->gigs_model->gig_price();

			//$gig_price = '$'.$gig_price['value']; // fixed price 
			$paymentcurrency = (!empty($data_one['paymentcurrency']))?$data_one['paymentcurrency']:'USD';
			$sign = currency_sign($paymentcurrency);

			$gig_price = $sign.$data_one['item_amount']; // Dynamic price 

			// $extra_gig_price = $this->gigs_model->extra_gig_price();

        	//$extra_gig_price = $extra_gig_price['value'];

			$extra_gig_price = 0;

			// $extra_gig_ref = json_decode($email_details['extra_gig_ref']);

			$user_profile_link =  $user_package_link;

			

			$h_all='';	 

			

			

			$h_all.='<tr>

			<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>

			<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$sign.' '.$data_one['item_amount'].'</td>

			</tr>';



			$request_link =base_url().'price-table-for/Agency';		

			$bodyid = 8;

			$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

			$body = $tempbody_details['template_content'];

			// $body = str_replace('{base_url}', $this->base_domain, $body);

			$body = str_replace('{sell_name}', $data_one['fullname'], $body);

			$body = str_replace('{package_owner}',$this->site_name, $body);

			$body = str_replace('{title}',str_replace("-"," ",$title), $body);	


			$body = str_replace('{package_preview_link}',$package_preview_link, $body);

			$body = str_replace('{user_profile_link}',$user_profile_link, $body);	

			// $body = str_replace('{title_url}',$title, $body);

			// $body = str_replace('{PAYPAL_ID}',$order_id, $body);

			// $body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);	

			// $body = str_replace('{PRICE}',$gig_price , $body);										 

			// $body = str_replace('{BUYER_LINK}', $user_profile_link, $body);	

			

			// $body = str_replace('{TEABLE_ROW}', $h_all, $body);

			

			// $body = str_replace('{IMG_SRC}',$img_path , $body);

			// $body = str_replace('{gig_preview_link}',$user_package_link, $body);	

			// $body = str_replace('{request_link}',$request_link, $body);

			// $body = str_replace('{site_name}',$this->site_name, $body);



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

			// $this->load->helper('file');  

			// $this->load->library('email');
			// $this->email->initialize($this->smtp_config);
			// $this->email->set_newline("\r\n");

			// $this->email->from($this->email_address,$this->email_tittle); 

			// $this->email->to($toemail); 

			// $this->email->subject('New order from '.$email_details['buyer_name']);

			// $this->email->message($seller_message);	 

			// $this->email->send();	
$email_id=$toemail;
                                 $this->load->view("email/send",array("email"=>@$email_id,"subject"=>'Buy Package '.$this->site_name,"mess"=>$seller_message));
		//admin mail function

			$from_timezone = 'Asia/Calcutta';

			date_default_timezone_set($from_timezone); 

			$current_time= date('d-M-Y H:i:s');

			$bodyid = 19;


 $user_thumb_image=base_url()."assets/images/avatar2.jpg";
    if(@$data_one['user_thumb_image'])
    {
    	 $user_thumb_image=base_url()."assets/uploads/".$data_one['user_thumb_image'];
    }

       

			$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

			$body=$tempbody_details['template_content'];	

			$body = str_replace('{base_url}', $this->base_domain, $body);

			$body = str_replace('{PAYPAL_ID}', $order_id, $body);

			$body = str_replace('{CREATED_ON}', $current_time, $body);		 

			$body = str_replace('{buyer_name}', $data_one['fullname'], $body);

			$body = str_replace('{seller_name}', $this->site_name, $body);

			$body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);

			$body = str_replace('{PRICE}',''.$gig_price, $body);

			$body = str_replace('{IMG_SRC}',$user_thumb_image , $body);

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

			// $this->load->helper('file');  

			// $this->load->library('email');
			// $this->email->initialize($this->smtp_config);
			// $this->email->set_newline("\r\n");

			// $this->email->from($this->email_address,$this->email_tittle); 

			// $this->email->to($this->email_address); 

			// $this->email->subject('Create New Order');

			// $this->email->message($message);
			// var_dump($this->email_address);
$email_id=$this->email_address;

                                 $this->load->view("email/send",array("email"=>@$email_id,"subject"=>'Create New Order '.$this->site_name,"mess"=>$message));

redirect(base_url().'purchase-success/'.$uid);
			// if($this->email->send())

			// { 

			// 	redirect(base_url().'purchase-success/'.$uid);

			// }else{

			// 	redirect(base_url().'purchase-success/'.$uid);

			// }

		}



		function paypal_cancel(){

			redirect(base_url().'purchases');

		}



		public function rejected_orders()
	{


		if($this->input->post('submit'))

		{ 
			
	       $id = $this->session->userdata('SESSION_USER_ID');

		   $from_timezone = $this->session->userdata('time_zone');

		   $input = array();

		   $current_time = date('Y-m-d H:i:s');
		   
		   $gig_id = $input['gig_id'] = $this->input->post('hidd_gig_id');

		   $gig_request_details = $this->gigs_model->gig_rejected($gig_id);
		   
		   $order_id = $input['order_id'] = $this->input->post('hide_order_id');

		   //$gig_request_details = $this->gigs_model->gig_rejected_details($order_id);

		   
		   

		   $input['seller_id'] = $this->input->post('hide_seller_id');

		   $input['buyer_id'] = $this->input->post('buyer_id');

		   $input['message'] = $this->input->post('reject_message_content');

		   $input['created_time'] = $current_time;

		   $title = $gig_request_details['title'];

		   $result = $this->gigs_model->rejected_request($input);

		   $insert_id = $this->db->insert_id();

		   $admin_cancel = $this->gigs_model->request_rejected($insert_id,$gig_id);

       

       $bodyid = 32;

				 

				$admin_name = $admin_cancel['admin_name']; 

				$buyer_email = $admin_cancel['buyer_email']; 

				$admin_email = $admin_cancel['admin_email']; 

				$seller_name = $admin_cancel['seller_name']; 

				$buyer_name = $admin_cancel['buyer_name'];

				$this->email_address = $buyer_email;

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

				$link=base_url().'admin/rejected_orders';

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

				$this->email->subject('New Rejected order');

				$this->email->message($message);

				$this->email->from($buyer_email,$this->email_tittle);

				$this->email->to($admin_email);

				$url_parts = parse_url(current_url());
				$result = $this->email->send();
				   redirect(base_url('purchases'));


		}
	}



		public function purchase_success($payment_id)

		{ 

			$this->data['purchase_details'] = $purchase_details = $this->gigs_model->purchase_completed($payment_id);
 

       $get_packeg_data_ditales=$this->db->query("select * from membership where id='".$purchase_details['package_id_set']."'")->row_array();

			$update_user_package_info["payment_id"]=$payment_id;
			$update_user_package_info["package_id"]=$purchase_details['package_id_set'];
            $set_duration=$purchase_details['duration'];
            if($get_packeg_data_ditales['types']=='Addon')
            {
            	$set_duration=(int)$set_duration*6;
              // $duration_count=(int)$get_duration_for_adone*7;
          
         
        $count_user=$this->db->query("select count(id) from user_addon where package_id='".$purchase_details['package_id_set']."' and (status='Running' or status='Pending')")->row_array();
  
		    if($get_packeg_data_ditales['values']<=$count_user['count(id)'])
		    {
    
                $start_date_set_5=date("d-M-Y");
                $end_date_set_5=date('d-M-Y', strtotime("+".$set_duration." days"));
               $start_date_get_by_system=strtotime(date("d-M-Y"));
               $end_date_get_by_system=strtotime(date('d-M-Y', strtotime("+".$set_duration." days")));

           $set_loop_status=false;
                for($l=0; $l<$count_user["count(id)"]; $l++)

               {

               $get_data=$this->db->query("select * from user_addon where start_date_in_string<=".$start_date_get_by_system." and end_date_in_string>=".$start_date_get_by_system." and (status='Running' or status='Pending')")->result_array();
                      
                      // var_dump($start_date_set_5);
                      // var_dump($end_date_set_5);
                     //  var_dump($this->db->last_query());
                     // var_dump("======");
                     //  var_dump(count($get_data));
                      if(count($get_data)>=3)
                      {
                      	foreach($get_data as $get_date_info)
					   {
                          $set_duration_2=$set_duration-1;
					     $start_date_set_5=date('d-M-Y', strtotime($get_date_info["end_date"]."+1 days"));
                         $end_date_set_5=date('d-M-Y', strtotime($get_date_info["end_date"]."+".$set_duration_2." days"));
					   	// var_dump(date('d-M-Y', strtotime($get_date_info["end_date"]."+1 days")));
					   	// var_dump(date('d-M-Y', strtotime($get_date_info["end_date"]."+".$set_duration." days")));
					     $start_date_get_by_system=strtotime(date('d-M-Y', strtotime($get_date_info["end_date"]."+1 days")));
					     $end_date_get_by_system=strtotime(date('d-M-Y', strtotime($get_date_info["end_date"]."+".$set_duration_2." days")));
                       
                          // var_dump($start_date_set_5);
					      
                           $set_loop_status=true;

                          break;
					   }
                      }
                      else
                      {
                      	$l=6;
                      	// var_dump($start_date_set_5);
                      	// var_dump($end_date_set_5);
                      	var_dump("dsp patel");
                      	break;
                      }

                    var_dump($l); 
					   
               }


             
              $update_user_package_info["start_date"]=$start_date_set_5;	
			$update_user_package_info["end_date"]=$end_date_set_5;
            $update_user_package_info["start_date_in_string"]=strtotime($start_date_set_5);
            $update_user_package_info["end_date_in_string"]=strtotime($end_date_set_5);
            $update_user_package_info["status"]='Pending';
                     

		    }
		    else
		    {
            var_dump("dsp 3");
            $update_user_package_info["start_date"]=date("d-M-Y H:m:sa");	
			$update_user_package_info["end_date"]=date('d-M-Y', strtotime("+".$set_duration." days"));
            $update_user_package_info["start_date_in_string"]=strtotime(date("d-M-Y"));
            $update_user_package_info["end_date_in_string"]=strtotime(date('d-M-Y', strtotime("+".$set_duration." days")));
            $update_user_package_info["status"]='Running';
		    }

            $update_user_package_info["user_id"]=$this->session->userdata('SESSION_USER_ID');		
            $update_user_package_info["buy_date"]=date("d-M-Y H:m:sa");		
            $update_user_package_info["buy_date_in_string"]=strtotime(date("d-M-Y"));	
           // var_dump($update_user_package_info);
            $this->db->insert("user_addon",$update_user_package_info);
            }
            else
            {
              $update_user_package_info["start_date"]=date("d-M-Y");		
			$update_user_package_info["end_date"]=date('d-M-Y', strtotime("+".$set_duration." month"));
            $update_user_package_info["start_date_in_string"]=strtotime(date("d-M-Y"));
            $update_user_package_info["end_date_in_string"]=strtotime(date('d-M-Y', strtotime("+".$set_duration." month")));
            $update_user_package_info["package_status"]='1';
             $this->db->where(array("USERID"=>$this->session->userdata('SESSION_USER_ID')));
            $this->db->update("user_login",$update_user_package_info);
            }	
			
			
                  
        
           
            $get_types_data=$this->db->query("select types from user_login where USERID='".$this->session->userdata('SESSION_USER_ID')."'");
           
             if($get_packeg_data_ditales['types']!='Addon')
            {
            if($get_types_data!='Escort')
            {
            	$escort_info=$this->db->query("select escort_id from escort_info where agency_id='".$this->session->userdata('SESSION_USER_ID')."' and escort_id !='".$this->session->userdata('SESSION_USER_ID')."'")->result_array();
			       foreach($escort_info as $esc)
			       {
			         $this->db->where(array("USERID"=>$esc["escort_id"]));
			     $this->db->update("user_login",array("package_status"=>'1'));
			       }
            }
        }
			$seller_id = $this->site_name;
			$title = $purchase_details['name'];
			$title = str_replace('-',' ', $title);
			
			$this->load->model('api_gigs_model','gigs');
			// $this->gigs->order_status_notification($seller_id,$title,'Your gig has been purchased');

			$this->data['page_title'] 				   =    'Thanks for purchasing';
			$this->data['user_image'] 				   =    $purchase_details["user_thumb_image"];
			$this->data['module']	  				   =    'purchase_success';
			$this->data['page']	   				       =    'index';
			$this->load->vars($this->data);
			$this->load->view($this->data['theme'].'/template');		 
			
		}



		function ipn(){

			$this->load->library('paypal_lib');

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

			if(isset($TRANSACTIONID) && isset($user_pay_id)){

				if(preg_match("/VERIFIED/i",$result)){

					$table_data['transaction_id'] = $TRANSACTIONID;

					$table_data['transaction_status'] = 1;

					$table_data['transaction_date'] = date('Y-m-d H:i:s');

					$this->db->update('payments', $table_data, "id = " . $user_pay_id);

				}

			}

		}

		/*************Stripe Payment Gateway Start Here  ****************/



		 Public function stripe_payment(){

			$secret_key = $this->secret_key;

    	try {



		\Stripe\Stripe::setApiKey($secret_key);

		  // Store the Payment details 

		$chargeArr = array(

			"amount" => $this->input->post('amount').'00',

			"currency" => "USD",

			"card" => $this->input->post('access_token'),

			"description" => "Stripe Payment"

		);

		$charge = \Stripe\Charge::create($chargeArr);		



            $data = $this->stripe_payment_data($charge);  



		if ($data) {

			echo json_encode(array('status' => 200, 'success' => 'Payment successfully completed.','id'=>$data));



			exit();

		} else {

			echo json_encode(array('status' => 500, 'error' => 'Something went wrong. Try after some time.'));

			exit();

		}



	} catch (Stripe_CardError $e) {

		echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));

		exit();

	} catch (Stripe_InvalidRequestError $e) {

            // Invalid parameters were supplied to Stripe's API

		echo json_encode(array('status' => 500, 'error' => $e->getMessage()));

		exit();

	} catch (Stripe_AuthenticationError $e) {

            // Authentication with Stripe's API failed

		echo json_encode(array('status' => 500, 'error' => AUTHENTICATION_STRIPE_FAILED));

		exit();

	} catch (Stripe_ApiConnectionError $e) {

            // Network communication with Stripe failed

		echo json_encode(array('status' => 500, 'error' => NETWORK_STRIPE_FAILED));

		exit();

	} catch (Stripe_Error $e) {

            // Display a very generic error to the user, and maybe send

		echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));

		exit();

	} catch (Exception $e) {

            // Something else happened, completely unrelated to Stripe

		echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));

		exit();

	}





    }





    public function stripe_payment_data($charge){





    	$from_timezone = $this->session->userdata('time_zone');		   

    	date_default_timezone_set($from_timezone); 

    	$current_time= date('Y-m-d H:i:s');

    	$currency_type = 1 ;

    	$data['USERID']          = $this->session->userdata('SESSION_USER_ID');

    	$dollar_rate  = $this->session->userdata('dollar_rate');

    	$data['time_zone'] = $this->session->userdata('time_zone');

    	$extra_gig_required_days =(int) $this->input->post('total_delivery_days');

    	$data['gigs_id']     = $this->input->post('gigs_id');

    	$data['seller_id']   = $this->input->post('gig_user_id');

    	$item_amount     = $this->input->post('gigs_rate');

    	$extra_gig_ref   = json_encode($this->input->post('extra_gig_row_id'));

    	$currency_symbol   =  $this->input->post('currency_type');



    	if($currency_symbol=="$") {		   		

    		$currency_type = 2 ;			   

    		$data['item_amount']    	  =  $item_amount;

    		$data['dollar_amount']     = $item_amount ;				   

    	}else{ 

    		$d_rate = (int)$this->data['dollar_rate'];

    		$d_rate = ($d_rate>0)?$d_rate:1;				

    		$data['item_amount']     =  $item_amount;

    		$data['dollar_amount']   = ($item_amount / $d_rate);

    	}

    	$amount              =   $data['dollar_amount'];

		   // $data['extra_gig_ref'] = '';

    	$data['currency_type']  =  $currency_type ; 







    	if(!empty($extra_gig_ref)){

    		$data['extra_gig_ref'] = $extra_gig_ref;

    	}

    	$super_fast_delivery = $this->input->post('hidden_super_fast_delivery');

    	$hidden_super_fast_delivery_charges = $this->input->post('hidden_super_fast_delivery_charges');

    	$data['payment_super_fast_delivery'] = 1 ;

    	$data['delivery_date'] 				 =  Date('Y-m-d H:i:s', strtotime("+".$extra_gig_required_days." days"));	 



    	if(!empty($super_fast_delivery)){

    		$this->data['extra_gig_price']  = $this->gigs_model->extra_gig_price();

    		$super_fast_extra_gig_price       = 1;

    		if (!empty($this->data['extra_gig_price'])) {

    			$super_fast_extra_gig_price       =  implode("",$this->data['extra_gig_price']);    

    		}

    		$super_fast_dollar_rate          =  $this->data['dollar_rate'];                          

    		$data['extra_gig_indian_rupee'] = 1;

    		if (!empty($this->data['extra_gig_price'])) {

    			$data['extra_gig_indian_rupee'] = implode("",$this->data['extra_gig_price']);

    		}

    		if($super_fast_dollar_rate>0 &&  $super_fast_extra_gig_price>0){

    			$data['extra_gig_dollar'] = ( $super_fast_extra_gig_price / $super_fast_dollar_rate ); 

    		}	else{

    			$data['extra_gig_dollar'] = ( $super_fast_extra_gig_price / 1); 

    		}	



    		if($currency_symbol=="$")

    		{    				        

    			$data['extra_gig_indian_rupee'] =  $super_fast_extra_gig_price;

    			$data['extra_gig_dollar'] = $hidden_super_fast_delivery_charges ; 							

    		}



    		$data['payment_super_fast_delivery'] = 0 ;  

    		$query = $this->db->query("SELECT `super_fast_delivery_date` FROM `sell_gigs` WHERE `id` = ".$data['gigs_id']." ");

    		$days  = $query->row_array();

    		$total_days = $extra_gig_required_days + $days['super_fast_delivery_date'];

    		$data['delivery_date'] 				 =  Date('Y-m-d H:i:s', strtotime("+".$total_days." days"));	 

    	}

    	$_sprice = $this->gigs_model->gig_price();

    	if (!empty($_sprice)) {

    		$s_price =  implode("",$_sprice);

    	}







		   //$data['gig_price_dollar_rate']     = ($s_price / $this->data['dollar_rate']);

    	$data['created_at']      = $current_time;

    	$data['status']      = 1;

    	$data['commision']     = $this->admin_commision;	

           //$data['txn_id']     = $charge->id;	

    	$data['paypal_uid']     = $charge->id;	

    	$data['seller_status']     = 1;	



    	$data['source'] = 'stripe';	   

    	$_id=$this->input->post('gigs_id');

    	$query = $this->db->query("SELECT title FROM `sell_gigs` WHERE `id` = $_id" );

    	$dataname = $query->row_array();

    	$g_name= str_replace("-"," ",$dataname['title']);			 

    	$this->db->insert('payments',$data);	

    	return $this->db->insert_id();	

    }



    public function send_stripe_mail($uid){

    	$query = $this->db->query("SELECT py.item_amount,py.paypal_uid,py.currency_type,sg.title,sg.currency_type,sg.user_id,gi.gig_image_thumb,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,sg.gig_price,py.extra_gig_ref,py.extra_gig_dollar FROM `payments` as py

	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	

			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  

            LEFT JOIN members as m ON m.USERID = py.USERID

			LEFT JOIN members as sm ON sm.USERID = py.seller_id

			WHERE py.`id` = $uid");

		$data_one = $query->row_array();
	 

		$title 			   = $data_one['title'];
		$order_id 		   = $data_one['paypal_uid'];
		$currency_type 	   = $data_one['currency_type'];
		$currency_option   = (!empty($currency_type))?$currency_type:'USD';
        $sign       	   = currency_sign($currency_option);
        $amount 		   = 0 ;
				 
		$gig_preview_link  = base_url().'package-preview/'.$title."/".$data_one['id'] ;

		$img_path =base_url().$data_one['gig_image_thumb'];

		//$url=base_url().'user_profile/'.$username;                                         

        $this->load->model('templates_model');

		

		//seller mail function

			$email_details  = $this->gigs_model->gig_purchase_requirements($uid);
 

			$seller_message = '';

			$welcomemessage = ''; 

			$toemail= $email_details['email']; 

			$gig_price = $this->gigs_model->gig_price();

			//$gig_price = '$'.$gig_price['value']; // fixed price 
			$amount    = $data_one['gig_price'];   
			$gig_price = $sign.' '.$data_one['gig_price']; // Dynamic price 

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
						$amount += $gig_values[2];

						$h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

								'.str_replace('"','',$gig_values[0]).'

							</td>

							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$gig_values[1].'</td>

							<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$sign.' '.$gig_values[2].'</td>

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

				<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$sign.' '.$extra_gig_price.'</td>

				</tr>';
				$amount += $extra_gig_price;

			}

			 $h_all.='<tr>

						<td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>

						<td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$sign.' '.$data_one['item_amount'].'</td>

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



    	$secret_key = $this->secret_key;

    	$charge_id  = $this->input->post('pid');

    	$amount     = $this->input->post('amount');

    	$amount		= ($amount * 100);

    	try {



    		\Stripe\Stripe::setApiKey($secret_key);



    		$RefundArr = array(

    			"charge" => "$charge_id",

    			"amount" => $amount

    		);

    		$refund = \Stripe\Refund::create($RefundArr);  		

	   		$refund = json_encode($refund); // Response converstions 

    		//$refund = json_decode($refund); // If you need Enable this 



    		$where['paypal_uid'] = $charge_id;

    		$my_data['stripe_refund'] = $refund; // Stripe Refund Response 

    		$my_data['seller_status'] = 4; // Refunded 

    		$my_data['payment_status'] = 2;

			$my_data['notification_paycomplete'] = 1;

			$my_data['notification_status'] = 1;

    		$this->db->where($where);

    		//$this->db->or_where('txn_id',$charge_id);

    		$this->db->update('payments', $my_data);



   		echo 1;

   		exit;



    	}



    catch (Stripe_AuthenticationError $e) {

            // Authentication with Stripe's API failed

		echo json_encode(array('status' => 500, 'error' => AUTHENTICATION_STRIPE_FAILED));

		exit();

	} catch (Stripe_ApiConnectionError $e) {

            // Network communication with Stripe failed

		echo json_encode(array('status' => 500, 'error' => NETWORK_STRIPE_FAILED));

		exit();

	} catch (Stripe_Error $e) {

            // Display a very generic error to the user, and maybe send

		echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));

		exit();

	} catch (Exception $e) {

            // Something else happened, completely unrelated to Stripe

		echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));

		exit();

	}



    }



		/*************Stripe Payment Gateway End Here  ****************/



		 Public function amplify_payment_data(){

    	

		   $from_timezone 		= $this->session->userdata('time_zone');		   

		   date_default_timezone_set($from_timezone); 

		   $current_time  		= date('Y-m-d H:i:s');

		   $currency_type 		= 1 ;

		   $data['USERID']      = $this->session->userdata('SESSION_USER_ID');

		   $dollar_rate  		= $this->session->userdata('dollar_rate');

		   $data['time_zone'] 	= $this->session->userdata('time_zone');

		   $extra_gig_required_days = (int) $this->input->post('total_delivery_days');

		   $data['gigs_id']     	= $this->input->post('gigs_id');

		   $data['seller_id']  		= $this->input->post('gig_user_id');

		   $item_amount    			= $this->input->post('gigs_rate');

		   $extra_gig_ref   		= json_encode($this->input->post('extra_gig_row_id'));

		   $currency_symbol 		= $this->input->post('currency_type');



		   if($currency_symbol=="$") {		   		

			   $currency_type 		  = 2;			   

			   $data['item_amount']   = $item_amount;

			   $data['dollar_amount'] = $item_amount ;				   

		   }else{ 

				$d_rate = (int)$this->data['dollar_rate'];

				$d_rate = ($d_rate>0)?$d_rate:1;				

   			   $data['item_amount']     =  $item_amount;

			   $data['dollar_amount']   = ($item_amount / $d_rate);

		   }

		   $amount              =   $data['dollar_amount'];

		   // $data['extra_gig_ref'] = '';

		   $data['currency_type']  =  $currency_type ; 





		    

		   if(!empty($extra_gig_ref)){

		   $data['extra_gig_ref'] = $extra_gig_ref;

		   }

		   $super_fast_delivery = $this->input->post('hidden_super_fast_delivery');

		   $hidden_super_fast_delivery_charges = $this->input->post('hidden_super_fast_delivery_charges');

		   $data['payment_super_fast_delivery'] = 1 ;

		   $data['delivery_date'] 				 =  Date('Y-m-d H:i:s', strtotime("+".$extra_gig_required_days." days"));	 



		   if(!empty($super_fast_delivery)){

				          $this->data['extra_gig_price']  = $this->gigs_model->extra_gig_price();

                          $super_fast_extra_gig_price       = 1;

                          if (!empty($this->data['extra_gig_price'])) {

                              $super_fast_extra_gig_price       =  implode("",$this->data['extra_gig_price']);    

                          }

                          $super_fast_dollar_rate          =  $this->data['dollar_rate'];                          

                          $data['extra_gig_indian_rupee'] = 1;

                          if (!empty($this->data['extra_gig_price'])) {

                                  $data['extra_gig_indian_rupee'] = implode("",$this->data['extra_gig_price']);

                              }

						if($super_fast_dollar_rate>0 &&  $super_fast_extra_gig_price>0){

							$data['extra_gig_dollar'] = ( $super_fast_extra_gig_price / $super_fast_dollar_rate ); 

						}	else{

							$data['extra_gig_dollar'] = ( $super_fast_extra_gig_price / 1); 

						}	

						  

					   if($currency_symbol=="$")

		   				{    				        

						  $data['extra_gig_indian_rupee'] =  $super_fast_extra_gig_price;

						  $data['extra_gig_dollar'] = $hidden_super_fast_delivery_charges ; 							

						}

					  

					  $data['payment_super_fast_delivery'] = 0 ;  

					  $query = $this->db->query("SELECT `super_fast_delivery_date` FROM `sell_gigs` WHERE `id` = ".$data['gigs_id']." ");

					  $days  = $query->row_array();

					  $total_days = $extra_gig_required_days + $days['super_fast_delivery_date'];

					  $data['delivery_date'] 				 =  Date('Y-m-d H:i:s', strtotime("+".$total_days." days"));	 

				  }

		   $_sprice = $this->gigs_model->gig_price();

			if (!empty($_sprice)) {

				$s_price =  implode("",$_sprice);

			}





		  

		   //$data['gig_price_dollar_rate']     = ($s_price / $this->data['dollar_rate']);

		   $data['created_at']    = $current_time;

		   $data['status']        = 1;

           $data['commision']     = $this->admin_commision;	

           $data['paypal_uid']    = $paypal_uid = $_POST['transaction_id'];	

           $data['seller_status'] = 1;	

           $data['source'] 		  = 'amplify';	   

		   $_id					  = $this->input->post('gigs_id');



		   $query 	 = $this->db->query("SELECT title FROM `sell_gigs` WHERE `id` = $_id" );

		   $dataname = $query->row_array();

		   $g_name	 = str_replace("-"," ",$dataname['title']);			 

		   $this->db->insert('payments',$data);		

		   $url = 'https://api.amplifypay.com/merchant/verify';

		   $array = array(

    			"merchantId" 	 => "8DVBOXJ4YKIFM1KXANIRG",

    			"apiKey"		 => "08bc1fee-cf56-4f28-add6-39369995f81d",

    			"transactionRef" => $paypal_uid);

		   //$response = $this->amplifyCurl($url,$array);

		   echo json_encode(array('status' => 200, 'success' => 'Payment successfully completed.','id'=>$this->db->insert_id()));

		   die();

    }



  //   public function amplify_payment_details_update(){

    	

  //   	$amplify_verify = $this->input->post('amplify_verify');

  //   	$paypal_uid	    = $this->input->post('paypal_uid');



  //   	$this->db->where('paypal_uid', $paypal_uid);

		// $this->db->update('payments', array('amplify_verify'=>$amplify_verify));

		// echo 1;

		// die();



  //   }



    public function amplify_refund(){



    	if($this->input->post()){



    		$transaction_id = $this->input->post('pid');

    		$transaction_amount =$this->input->post('amount');

    		

    		$url = 'https://api.amplifypay.com/merchant/returning/charge';



    		$array = array(

    			"merchantId" => "8DVBOXJ4YKIFM1KXANIRG",

    			"apiKey" => "08bc1fee-cf56-4f28-add6-39369995f81d",

    			"transactionRef" => "108729427",

    			"authCode" => "",

    			"Amount"=>"150", 

    			"paymentDescription"=>"cancel purchase", 

    			"customerEmail"=>"c.soosairaj@gmail.com", 

    			 );

    		$this->amplifyCurl($url,$array);



   	}



    }





	    public function amplifyCurl($url,$array){



		

			$data_string = json_encode($array);

	    	$ch=curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json','Content-Length: ' . strlen($data_string)));

            $result = curl_exec($ch);

            curl_close($ch);

		    return $result;

	    }



	     public function stripe_token_payment(){

			

			$stripe_config['publishable_key'] = "pk_test_Js15CigEZPZH69hjS2hgXjBx";

			$stripe_config['secret_key'] = "sk_test_OVXvseuWuLVp2w0XOWvGKDQJ";

			$stripe_config['stripe_name'] = "Dreams Gigs";

			$stripe_config['stripe_logo'] = "https://www.dreamguys.co.in/gigs/assets/images/logo.png";

			$stripe_config['stripe_description'] = "This Gigs Payments";

			$stripe_config['server_side_coding'] = base_url()."gigs/user/buy_service/stripe_token_payment";

			$this->load->library('stripe',$stripe_config);



	     	

    	if(!empty($_POST)){

    		$stripe_response = $_POST;

    		$stripe_token = $stripe_response['stripeToken'];

    		$stripe_token_type = $stripe_response['stripeTokenType'];

    		$stripe_email = $stripe_response['stripeEmail'];



   		    $charges_array              = array();

		    $charges_array['amount']    = "50";

		    $charges_array['currency']  = "usd";

		    $charges_array['description']  = "Example";

		    $charges_array['source']       = $stripe_token;

		    $response = $this->stripe->stripe_charges($charges_array);

		    echo '<pre>';

		    print_r($response);

		    exit;





    	}



    }



	}

	?>