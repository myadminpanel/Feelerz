<?php 

class Dashboard extends CI_Controller{

    public function __construct() {

        parent::__construct();   

        $this->load->library('encrypt');
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

        $this->data['module'] = 'dashboard';

        $this->load->model('user_login_model');

        $this->load->model('user_panel_model');

        $this->data['client_list'] = $this->user_panel_model->get_client_list();        

        $this->data['categories_subcategories'] = $this->user_panel_model->categories(); 

        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();

        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();   

        $this->data['system_setting'] = $this->user_panel_model->system_setting();

		$this->data['policy_setting'] = $this->user_panel_model->policy_setting();			

        $this->load->model('gigs_model');

       $query = $this->db->query("select * from system_settings WHERE status = 1");

		$result = $query->result_array();

		$this->email_address='mail@example.com';

		$this->email_tittle='Gigs';

		$this->logo_front=base_url().'assets/images/logo.png';

		$this->site_name ='gigs';

	    $this->base_domain = base_url();

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

		if($data['key'] == 'site_name' || $data['key'] == 'website_name'){

		$this->site_name = $data['value'];

		}



    $this->data['currency_option'] = 'USD';

		if($data['key']=='currency_option'){

          $this->data['currency_option'] =$data['value'];

        }



    }

		}

        $this->data['recent_gigs'] = $this->gigs_model->recent_gigs();

       // $this->data['latest_gigs'] = $this->gigs_model->latest_gigs();

        $this->data['gig_price'] = $this->gigs_model->gig_price();

        $this->data['extra_gig_price'] = $this->gigs_model->gig_price();

		 $this->data['logo'] = $this->user_panel_model->get_logo();  

        $this->data['slogan'] = $this->user_panel_model->get_slogan();

    }

	

    public function index()

    {

        $this->data['page'] = 'index';

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'');        

    }    

    public function is_valid_login()

    {

        $username = $this->input->post('username');

        $password = $this->input->post('password');

        $result = $this->user_login_model->check_login($username,$password);

        if(!empty($result))

        {        

         if($result['verified']==0&&$result['status']==0)

         {

        $this->session->set_userdata('SESSION_USER_ID',$result['USERID']);   
        $this->session->set_userdata('user_role',2);   
        $this->session->set_userdata('old_timezone',$result['user_timezone']);
        $this->session->set_userdata('unique_code',$result['unique_code']);

        echo 1;

        } else {
          if ($result['status']==1 && $result['verified']==0) {
            echo 3;            
          }else{
            echo 2;            
          }

        }

        }

        else 

        {

        echo 0 ;

        }       

    }    

    public function check_username_availability()

    {

        $username = $this->input->get('username');       

    $result = $this->user_panel_model->check_username($username);     

    if ($result > 0) {

               $isAvailable = FALSE;

       } else {

               $isAvailable = TRUE;

       }

       

       echo json_encode(

               array(

                       'valid' => $isAvailable

               ));        

    }  

    

    public function check_registered_email()

    {

        $email = $this->input->post('forget_email');   

       

    $result = $this->user_panel_model->check_email($email);       

    if ($result > 0) {

               $isAvailable = TRUE;

       } else {

               $isAvailable = FALSE;

       }

       

       echo json_encode(

               array(

                       'valid' => $isAvailable

               ));        

    }

	

	public function extra_gig_calculations()

	{

		$extra_gigs_details  = $this->input->post('extra_gigs_details');

		$gig_id				 = $this->input->post('gig_id');

		$user_id 			 = $this->session->userdata('SESSION_USER_ID');			 

		$currency_type 		 = $this->input->post('currency_type');	    	 

		$gig_details 		 = $this->gigs_model->extra_gig_calculations($gig_id);

		$rupee_rate 		 = $this->session->userdata('rupee_rate');

		$country_name 		 = $this->session->userdata('country_name');

		$dollar_rate 		 = $this->session->userdata('dollar_rate');

		

		$super_fast_delivery 		 = $this->input->post('super_fast_delivery');	

		$super_fast_delivery_charges = $this->input->post('super_fast_delivery_charges');	

		$super_fast_desc			 = $this->input->post('super_fast_desc');	

		$extra_gig_rate_symbol				 = $this->input->post('rate_symbol');	

		$super_fast_delivery_date    = $this->input->post('super_fast_delivery_date');			 

		

		 $gig_price = $this->gigs_model->gig_price();

  		 $gig_price1 = $gig_price['value']; 

       $gig_price1 = $gig_details['gig_price']; // Dynmic Price 

		//	 echo $super_fast_delivery  . $super_fast_delivery_charges . $super_fast_desc . $rate_symbol . $super_fast_delivery_date  ;

				  
          $currency_option = (!empty($gig_details['currency_type']))?$gig_details['currency_type']:'USD';
          $rate_symbol = currency_sign($currency_option);
          $rate = $gig_details['gig_price'];
				  if($super_fast_delivery=='yes') 	
					{
									$super_fast_delivery_charges	=  ($super_fast_delivery_charges  ); 
								}	

		$html = '';

		$html_table_header = '<div class="table-responsive">

						<table class="table table-bordered">

							<thead>

								<tr>

									<th>Item</th>

									<th>Product Name</th>

									<th>Quantity</th>

									<th>Total</th>

								</tr>

							</thead>

							<tbody>

								<tr>

									<td><img src="'.base_url().$gig_details['gig_image'].'" width="50" height="34"></td>

									<td>

										<a class="product_name text-ellipsis" href="javascript:;">'.ucfirst(str_replace("-"," ",$gig_details['title'])).'</a>

									</td>

									<td> 1 </td>

									<td class="total">'. $rate_symbol.$gig_price1 .'</td>

								</tr>';

		$html_table_contents = '';

		$html_table_footer   = '

		</tbody>

								</table>

								</div>';										

		//$exisiting_rows = $this->gigs_model->check_existing_extra_gig($user_id,$gig_id);						

		$extra_gig_inserted_id = array();

		$calculation_table = '';	

		 

		if(!empty($extra_gigs_details))

		{ 

		foreach($extra_gigs_details as $extras)

		{

		$gig_values = explode('___',$extras);

		if($gig_values[1]!=0 || $gig_values[1]!= "undefined" )

		{	

		$data['gig_id']  = 	$gig_id ;

		$data['user_id'] = 	$user_id ;

		$data['options'] =  json_encode($extras);

		$data['status']  =  1;	

		$data['currency_type'] = $currency_type;
		$html_table_contents .= '<tr>

									<td> &nbsp; </td>

									<td><span class="text-ellipsis">'.$gig_values[0].'</span></td>	

									<td>'.$gig_values[1].'</td>

									<td class="total">'.$rate_symbol.$gig_values[2].'</td>

								</tr>' ;			

    	$this->db->insert('user_required_extra_gigs',$data);

		$extra_gig_inserted_id[] = $this->db->insert_id();

		}	

		}

		}

		if(($super_fast_delivery=='yes'))	{
			if(empty($super_fast_desc))
			{ 
			  $super_fast_desc = "super fast delivery" ; 
			}				
  		$html_table_contents .= '<tr><td> <span class="super-fast">Super Fast</span> </td>
									<td>'.$super_fast_desc.'</td><td>1</td><td class="total">'.$rate_symbol.$super_fast_delivery_charges.'</td>
                  </tr>';			 	 
				}	 

		$calculation_table = $html_table_header.$html_table_contents.$html_table_footer; 		

		echo json_encode(array('html'=>$calculation_table ,'sub_html'=>$extra_gig_inserted_id,'rate_symbol'=>$rate_symbol,'super_fast_delivery'=>$super_fast_delivery,

		'super_fast_delivery_charges'=>$super_fast_delivery_charges));	

	}

    

	

	

	 public function check_gig_title()

    {

    

    $title = str_replace(" ","-",trim($this->input->post('gig_title')));    

	$append_sql = '';

	$gig_id = $this->input->post('gig_id');    

	if(!empty($gig_id))

	{

		$append_sql =  "AND id != ".$gig_id."";

	}  

    

    

    $query = $this->db->query("SELECT * FROM `sell_gigs` WHERE `title` = '$title' ".$append_sql.";");

    

    $result = $query->num_rows();

    

    if ($result > 0) {

               $isAvailable = FALSE;

       } else {

               $isAvailable = TRUE;

       }

       

       echo json_encode(

               array(

                       'valid' => $isAvailable

               ));        

    }  

	    public function check_username()

    {

        $username = $this->input->post('username');   

       

    $result = $this->user_panel_model->check_username($username);  

     

    if ($result > 0) {

               $isAvailable = FALSE;

       } else {

               

               

               $isAvailable = TRUE;

       }

       

       echo json_encode(

               array(

                       'valid' => $isAvailable

               ));        

    }

	

    public function check_available_email()

    {

        $email = $this->input->post('forget_email');   

       

    $result = $this->user_panel_model->check_email($email);  

     

    if ($result > 0) {

               $isAvailable = FALSE;

       } else {

               

               

               $isAvailable = TRUE;

       }

       

       echo json_encode(

               array(

                       'valid' => $isAvailable

               ));        

    }

    

    

    public function activate_account()

	{

                if ($this->uri->segment(2))  $user_name = $this->uri->segment(2);                

                $username = $this->encryptor('decrypt', $user_name);                                             

		if(!empty($username))

                {                    

                $data['verified'] = 0; 

                $data['status'] = 0; 

                $this->db->update('members',$data,array('username'=>$username));

                $this->session->set_userdata('users_account_activate', "success"); 

                redirect (base_url());

		}

 		redirect (base_url());

	}

        

    public function change_password()

    {

		        

                if ($this->uri->segment(2)) 

				$user_name = trim($this->uri->segment(2));

			    $query=$this->db->query("select forget from `members` where forget='$user_name'");

				$num = $query->num_rows();

				if($num != 0)

				{

					

				//$query=$this->db->query("update members set forget='' where forget='$user_name'");

                $username = $this->encryptor('decrypt', $user_name); 

				if($this->input->post('form_submit'))

				{

					 $data['password'] = md5($this->input->post('new_password'));

					 $data['forget'] = '';

					 $username = $this->input->post('user_name');

					 $this->db->where('username',$username);

					 $this->db->update('members',$data);

					 $message='The password updated  successfully please login again.';

					 $this->session->set_flashdata('message',$message);

					 redirect(base_url());

				}

				}else{

					$message='The email has been expired';

					$this->session->set_flashdata('message',$message);

					 redirect(base_url());

				}


				if(!empty($username))

                {   

			        $this->data['title'] = $this->email_tittle;         

			        $this->data['page_title'] = 'Change Password';

					$this->data['username'] = $username;

					$this->data['page'] = 'forget_password';

					$this->data['module'] = 'forget_password';

					$this->load->vars($this->data);

					$this->load->view($this->data['theme'].'/template');

				} 		

    }

        

     

    function encryptor($action, $string) {

    $output = false;



    $encrypt_method = "AES-256-CBC";

    //pls set your unique hashing key

    $secret_key = 'muni';

    $secret_iv = 'muni123';



    // hash

    $key = hash('sha256', $secret_key);

    

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning

    $iv = substr(hash('sha256', $secret_iv), 0, 16);



    //do the encyption given text/string/number

    if( $action == 'encrypt' ) {

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

        $output = base64_encode($output);

    }

    else if( $action == 'decrypt' ){

    	//decrypt the given text/string/number

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

    }



    return $output;

}       

   

    

    public function users_registeration()

    {

        if(($this->session->userdata('time_zone')))

        {       

        $this->data['time_zone'] = $this->session->userdata('time_zone');        

        $this->data['full_country_name'] = $this->session->userdata('full_country_name');        ;    

        $this->data['country_name'] = $this->session->userdata('country_name');        ;                

        }        

        else             

        {

        $user_ip = getenv('REMOTE_ADDR');    

        //$user_ip = '59.97.116.168';

        $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));              

		$geoplugin_latitude = $geo["geoplugin_latitude"];	

        $geoplugin_longitude = $geo["geoplugin_longitude"];

        $t=time();

        $result = $this->getTimezoneGeo($geoplugin_latitude,$geoplugin_longitude,$t);

        $this->data['time_zone'] = $result;        

        $this->data['full_country_name'] = $geo['geoplugin_countryName'];    

        $this->data['country_name'] = $geo['geoplugin_countryCode'];        

        $this->data['dollar_rate'] = 67.08;   

        $this->data['rupee_rate'] = ( 1 / $this->data['dollar_rate']);  

        $newdata = array(

        'country_name'  => $geo['geoplugin_countryCode'],

        'time_zone'     => $result,

        'full_country_name' => $geo['geoplugin_countryName']

        );

        $this->session->set_userdata($newdata);                             

        }

        

        

        

       $data['username'] 		= $this->input->post('username');

       $data['password'] 		= md5($this->input->post('password'));

       $data['email'] 	 		= $this->input->post('email');

       $data['fullname'] 		= ucfirst($this->input->post('name'));

       $data['country'] 		= $this->input->post('country_id');

       $data['state'] 		= $this->input->post('state_id');

       $data['user_timezone'] 	= $this->data['time_zone'] ;
       
	   date_default_timezone_set($data['user_timezone']);

       $data['created_date'] 	= date('Y-m-d H:i:s') ;
	   
	   $data['lname'] 	= ucfirst($this->input->post('lname'));
	   
	   $data['phone'] 	= $this->input->post('phone');
	   
	   $data['are_you'] 	= $this->input->post('are_you');
	   
       $data['verified'] = 1;

       $data['status'] = 1;

       if($this->db->insert('members',$data))

       {      

       $username = $data['username'];                                                          

       $url_encypted = urlencode($this->encryptor('encrypt',$username));

        $url=base_url().'activate_account/'.$url_encypted;                                         

        $this->load->model('templates_model');

        $message='';

        $welcomemessage='';

        $bodyid=13;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);		 

        $body=$tempbody_details['template_content'];

		$body = str_replace('{base_url}', $this->base_domain, $body);

		$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{USER_NAME}', $username, $body);

        $body = str_replace('{sitetitle}',$this->site_name, $body);

        $body = str_replace('{SUBMIT_LINK}', $url, $body);

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

        $this->email->to($data['email']); 

        $this->email->subject('Welcome and thank you for joining '.$this->site_name);

        $this->email->message($message);

        if ($this->input->server('HTTP_HOST')!='localhost') {

          

             if($this->email->send()){            

                $this->session->set_userdata("user_registeration","Success");

                 echo 1;

              }

          }else{
                $error = $this->email->print_debugger();
                var_dump($error);
                
                echo 1;

          }

        }

        else 

        {

           echo 2;           

        }

    }

    

      function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude,$t) {

    $json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");     

    $data = json_decode($json,true);  

    $tzone=$data['timeZoneId'];      

    return $tzone;

    }

    

   

    public function forgot_password()

    {

        

				$email_id = $this->input->post('forget_email');        

				$query = $this->db->query("SELECT username FROM  `members` WHERE  `email` =  '$email_id'");

				$username = $query->row_array();

				$username = trim($username['username']);        

				$url_encypted = urlencode($this->encryptor('encrypt',$username));

				$query = $this->db->query("Update  `members` SET forget='$url_encypted' WHERE  `email` =  '$email_id'");

        	    $url=base_url().'change_password/'.$url_encypted;      			   

                    $this->load->model('templates_model');

                    $message='';                    

                    $bodyid=14;

                    $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

                    $body=$tempbody_details['template_content'];

					$body = str_replace('{sitetitle}',$this->site_name, $body);

					$body = str_replace('{base_url}', $this->base_domain, $body);

					$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

                    $body = str_replace('{USER_NAME}', $username, $body);

                    $body = str_replace('{SUBMIT_LINK}', $url, $body);

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

                    $this->email->to($email_id); 

                    $this->email->subject('Forgot Password on '.$this->site_name);

                    $this->email->message($message);
                   
                    if($this->email->send()){
                     // print_r($this->email->print_debugger());
                        echo 1; 
                    }else{
                      echo 2;           
                    } 

    }





    

    public function random_number_generator()

    {

        $random_number = rand(0,999);

        return $random_number;        

    }

    

    

    public function checking_suggestion($username_substring,$second_substring) 

    {

        $counter = 0;

        $username_suggestions = array();

            for($i=0;$i<20;$i++)

            {               

                if($counter==3)

                {

                    $html = '';

                    foreach($username_suggestions as $usr_sugg)

                    {

                        $html .= '<a href="#" onclick="select_username(\''.$usr_sugg.'\')">'.$usr_sugg.'</a><br>';

                    }

                    return $html;

                    break;

                }

                $username = $username_substring.$second_substring."_".$this->random_number_generator();                

                $result = $this->user_panel_model->check_username($username);

            if($result!=1)

            {

                $counter = $counter+1;

                $username_suggestions[] = $username;

            }            

            }        

    }

    

    public function create_suggestions()

    {

        $username = $this->input->post('username');

        $mail_id = $this->input->post('email');

        $result = $this->user_panel_model->check_username($username);

        if($result==1)

        {

        $email_substring = substr($mail_id, 0, 3);   

        $username_substring = substr($username, 0, 3);   

        if($email_substring==$username_substring)

        {

        $pos = strpos($mail_id,'@');      

        $subtracted = $pos-3;

        $second_substring = substr($mail_id,3,$subtracted);          

        $return_result = $this->checking_suggestion($username_substring,$second_substring);       

        }        

        else 

        {         

        $return_result = $this->checking_suggestion($username_substring,$email_substring);         

        }

         echo json_encode(array('html'=>$return_result,'sub_html'=> 1));

        }

        else

        {

        $html = '<p> The username : '.$username.' is available </p>';    

        echo json_encode(array('html'=>$html,'sub_html'=> 2));    

        }

        } 

    public function sell_gig()

    {

        $this->data['page'] = 'add_gigs';

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'/pages/template');

    }

        

        }

?>