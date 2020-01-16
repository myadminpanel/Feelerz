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



public function update_user_profile()
{
    // var_dump($this->input->post());
    $data['fullname']=$this->input->post("displayname");
    $username=$this->input->post("username");
    $data['gender']=$this->input->post("gender");
    $data['user_thumb_image']=$this->input->post("product_image_one");

     $this->db->where('USERID',$this->input->post("id"));
           $this->db->update('user_login',$data);
            $message='The profile updated  successfully.';

           $this->session->set_flashdata('message',$message);

           redirect(base_url()."user-profile/".$username);
}


public function image_upload()
{
  // var_dump($this->input->pos());


if($this->input->post("image"))
{
  $data = $this->input->post("image");
  $image_array_1 = explode(";", $data);
  $image_array_2 = explode(",", $image_array_1[1]);
  $data = base64_decode($image_array_2[1]);
  $imageName_only = time() . '.png';
// $id=$_SESSION["user"]["id"];
// mysqli_query($conn,"UPDATE `registration` SET `image`='".$imageName_only."' WHERE id='".$id."'");

  $imageName = FCPATH."assets/uploads/".$imageName_only;
  file_put_contents($imageName, $data);

   // echo '<input type="hidden" name="product_image_one" value="'+$imageName_only+'" />';
  echo '<input type="hidden" name="product_image_one" value="'.$imageName_only.'" >';
  echo '<img src="'.base_url()."assets/uploads/".$imageName_only.'" class="" style="width:100%;height: 269px;" />';
}
}

    public function is_valid_login()

    {

        $username = $this->input->post('username');

        $password = $this->input->post('password');

        $result = $this->user_login_model->check_login($username,$password);
// var_dump($result);
        if(!empty($result))

        {        

         if($result['verified']==0&&$result['status']==0)

         {
            
            $this->db->query("UPDATE user_login SET login_status='Login' where USERID='".$result['USERID']."'");
        $this->session->set_userdata('SESSION_USER_ID',$result['USERID']);   
        $this->session->set_userdata('user_role',2);   
        $this->session->set_userdata('old_timezone',$result['user_timezone']);
        $this->session->set_userdata('unique_code',$result['unique_code']);
        
        echo @$result["username"]."*#*".@$result["types"];


        } else {
          if ($result['status']==1 && $result['verified']==0) {
            echo 3;            
          }else{

            echo 4;
            
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

		$package_id				 = $this->input->post('package_id');

		$user_id 			 = $this->session->userdata('SESSION_USER_ID');			 

		$currency_type 		 = $this->input->post('currency_type');	    	 

		$package_details 		 = $this->gigs_model->extra_package_calculations($package_id);
// var_dump($package_id);
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

       $gig_price1 = $package_details['price']; // Dynmic Price 

          
		//	 echo $super_fast_delivery  . $super_fast_delivery_charges . $super_fast_desc . $rate_symbol . $super_fast_delivery_date  ;

				  
          $currency_option = (!empty($package_details['currency_type']))?$package_details['currency_type']:'USD';
          $rate_symbol = currency_sign($currency_option);
          $rate = $package_details['price'];
				  if($super_fast_delivery=='yes') 	
					{
									$super_fast_delivery_charges	=  ($super_fast_delivery_charges  ); 
								}	

		$html = '';


    $admin_commision=$this->gigs_model->get_admin_commision();
    // var_dump($admin_commision);
  $commition_amount=$gig_price1/$admin_commision["value"];


  $product_price=$gig_price1-$commition_amount;
		$html_table_header = '<div class="table-responsive">

						<table class="table table-bordered">

							<thead>

								<tr>

									<th>Item</th>

									<th>'.$package_details['types'].' Name</th>

									<th>Quantity</th>

									<th>Total</th>

								</tr>

							</thead>

							<tbody>

								<tr>

									<td>#</td>

									<td>

										'.ucfirst(str_replace("-"," ",$package_details['name'])).'

									</td>

									<td> 1 </td>

									<td >'. $rate_symbol.$gig_price1 .'</td>

								</tr>';


// <tr>
//     <td>Commision</td>
//     <td>Admin commision</td>
//     <td>'.$admin_commision["value"].'%</td>
//     <td>'. $rate_symbol.$commition_amount.'</td>
//     </tr>
//     <tr>
//    <td></td>
//    <td >Total</td>
//    <td></td>
//    <td>'. $rate_symbol.$total_amount .'</td>
//     </tr>
   
   $total_amount=$commition_amount+$product_price;
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

		$data['package_id']  = 	$package_id ;

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

    	// $this->db->insert('user_required_extra_gigs',$data);

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

     $get_duration_for_adone=$package_details['duration'];
          
          $duration_count=(int)$get_duration_for_adone*7;
          
         
        $count_user=$this->db->query("select count(id) from user_addon where package_id='".$package_id."' and (status='Running' or status='Pending')")->row_array();
  
    if($package_details['values']<=$count_user['count(id)'])
    {
        $set_wation_number=($count_user['count(id)']-$package_details['values'])+1;
          $wating_message='<div class="account-error">Limit of this addon is full You watting number is '.$set_wation_number.'</div>';
    }  
    else
    {
      $wating_message='';
    }
    $get_string=strtotime("11-Jan-2019");
  
		echo json_encode(array('html'=>$calculation_table ,'sub_html'=>$extra_gig_inserted_id,'rate_symbol'=>$rate_symbol,'super_fast_delivery'=>$super_fast_delivery,
		'super_fast_delivery_charges'=>$super_fast_delivery_charges,"package_data"=>$package_details,"watting_data"=>$wating_message));	

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

    

    
$user_id=$this->session->userdata('SESSION_USER_ID');
    $query = $this->db->query("SELECT * FROM `sell_gigs` WHERE user_id='".$user_id."' AND `title` = '$title' ".$append_sql.";");

    

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





 public function check_phone()

    {

        $phone = $this->input->post('phone');   

       

    $result = $this->user_panel_model->check_phone($phone);  

     

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


                if ($this->uri->segment(2)) 
           {

                 $user_name = $this->uri->segment(2);                

                $username = $this->encryptor('decrypt', $user_name);                                             
$username=$user_name;

		if(!empty($username))

                {                    
// var_dump($username);
                $data['verified'] = 0; 

                $data['status'] = 0; 

                $this->db->update('user_login',$data,array('username_code'=>$username));
// var_dump($this->db->last_query());
$data=$this->db->query("select * from user_login where username_code='".$username."'");

 $data2=$data->row_array();

// var_dump($this->db->last_query());
// var_dump($data2);
 // if($data2["are_you"]=="Short")
 // {

 //  $check_name=$this->db->query("select * from crasol where item_name='".$data2["fullname"]."'")->result_array();
 //  if(!$check_name)
 //  {
 //   $this->db->query("INSERT INTO crasol(item_name, type, date, item_id, status) VALUES ('".$username."','user','".date("d-m-Y")."','".$data2["USERID"]."','0')"); 
 //   $this->db->query("INSERT INTO crasol(item_name, type, date, item_id, status) VALUES ('".$data2["fullname"]."','user','".date("d-m-Y")."','".$data2["USERID"]."','0')"); 
 //  }
     
 // }

// var_dump($this->db->update('members',$data,array('username'=>$username)));
                // $this->session->set_userdata('users_account_activate', "success"); 

// var_dump("test");

               //redirect (base_url()."account_activate/2");


		}
  
 $this->load->view("user/account_activation/view.php");
 
 		//redirect (base_url()."account_activate/index/2");
  }

	}

        

    public function change_password()

    {

		        

            

				$user_name = trim($this->uri->segment(2));

			    $query=$this->db->query("select forget,username from `user_login` where forget='$user_name'");


// var_dump($query->num_rows());
        $data=$query->row_array();
				$num = $query->num_rows();

				if($num != 0)

				{



                $username = $this->encryptor('decrypt', $user_name); 

				if($this->input->post('form_submit'))

				{

$query=$this->db->query("update user_login set forget='' where forget='$user_name'");
					 $data['password'] = md5($this->input->post('get_pre_password'));

					 $data['forget'] = '';

					 $username = $this->input->post('user_name');

					 $this->db->where('username',$username);

					 $this->db->update('user_login',$data);

					 $message='The password updated  successfully please login again.';

					 $this->session->set_flashdata('message',$message);

					 redirect(base_url()."login");

				}
           
             
              $this->data['title'] = $this->email_tittle;         

              $this->data['page_title'] = 'Change Password';

         $this->data['username'] = $data["username"];

         $this->data['page'] = 'forget_password';

         $this->data['module'] = 'forget_password';

         $this->load->vars($this->data);

         $this->load->view($this->data['theme'].'/template');


				}
        else{



         // $username = $this->encryptor('decrypt', $user_name); 
				 $username = $user_name; 


        if($this->input->post())

        {

           $data['password'] = md5($this->input->post('new_password'));

           $data['forget'] = '';

           $username = $this->input->post('user_name');

           $this->db->where('username',$username);

           $this->db->update('user_login',$data);

           $message='The password updated  successfully.';

           $this->session->set_flashdata('message',$message);

           redirect(base_url()."user-profile/".$user_name);

        }

					 // redirect(base_url()."user-profile/".$user_name);

				}


				// if(!empty($username))

    //             

			 //        $this->data['title'] = $this->email_tittle;         

			 //        $this->data['page_title'] = 'Change Password';

				// 	$this->data['username'] = $username;

				// 	$this->data['page'] = 'forget_password';

				// 	$this->data['module'] = 'forget_password';

				// 	$this->load->vars($this->data);

				// 	$this->load->view($this->data['theme'].'/template');

				
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


				$query = $this->db->query("SELECT username,fullname FROM  `user_login` WHERE  `email` =  '$email_id'");

				$username1 = $query->row_array();

				$username = trim($username1['username']);        

				$url_encypted = urlencode($this->encryptor('encrypt',$username));

				$query = $this->db->query("Update  `user_login` SET forget='$url_encypted' WHERE  `email` =  '$email_id'");
// var_dump($this->db->last_query());
        	    $url=base_url().'change_password/'.$url_encypted;      			   

                    $this->load->model('templates_model');

                    $message='';                    

                    $bodyid=14;

                    $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

                    $body=$tempbody_details['template_content'];

					$body = str_replace('{sitetitle}',$this->site_name, $body);

					$body = str_replace('{base_url}', $this->base_domain, $body);

					$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

                    $body = str_replace('{USER_NAME}', $username1['fullname'], $body);

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
                   
                   echo 1;

$this->load->view("email/send",array("email"=>@$email_id,"subject"=>'Forgot Password on '.$this->site_name,"mess"=>$message));
                  

                  

                    // if($this->email->send()){
                    //  // print_r($this->email->print_debugger());
                    //     echo 1; 
                    // }else{
                    //   echo 2;           
                    // } 

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


public function send_email_dsp()

{
  $data=explode("*#*", $this->input->post('email'));
  $username=$data["0"];
  $password=$data["1"];
  $result = $this->user_login_model->check_login($username,$password);

   $username = $result['username'];                                                          

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

        $body = str_replace('{USER_NAME}', $result['fullname'], $body);

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
   
$this->db->where(array("username"=>$username));
$this->db->update("user_login",array("username_code"=>$url_encypted));

      
$email_id=$result['email'];
$this->load->view("email/send",array("email"=>@$email_id,"subject"=>'Email Conformation'.$this->site_name,"mess"=>$message));



            echo 2;


}        

        }

?>