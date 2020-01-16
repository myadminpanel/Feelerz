<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class User extends REST_Controller {



    public function __construct() {
        parent::__construct();
		//load user model
        $this->load->model('api_user_model','user');

        $header =  getallheaders(); // Get Header Data
    	$token = (!empty($header['token']))?$header['token']:'';
    	if(empty($token)){
    		$token = (!empty($header['Token']))?$header['Token']:'';
    	}
    	$this->default_toke = md5('Dreams99');
    	$this->api_token    = $token;

    	$this->user_id = $this->user->get_user_id_using_token($token);
    	 
    }



    public function check_email_post() {


	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){

		$email = $this->post('email');
		$result = $this->user->check_email($email);

		if ($result > 0) {

            $isAvailable = FALSE;



       } else {

            $isAvailable = TRUE;

       }

			$email_data = array('valid' => $isAvailable );
			$this->response($email_data, REST_Controller::HTTP_OK);
		}else{
			$this->token_error();
		}
	}



	public function check_username_post() {

		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){

		$username = $this->post('username');

		$result = $this->user->check_username($username);



		if ($result > 0) {

            $isAvailable = FALSE;



       } else {

            $isAvailable = TRUE;

       }

		$email_data = array('valid' => $isAvailable );

     		//set the response and exit

			//OK (200) being the HTTP response code

		$this->response($email_data, REST_Controller::HTTP_OK);
		}else{
			$this->token_error();
		}
	}

	public function logout_get() {

		if($this->user_id !=0){

		$result = $this->user->logout($this->user_id);
 		if($result){
     		$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS' 
						 
					], REST_Controller::HTTP_OK);
 		}else{
 			$this->response([

				'status' => FALSE,

				'code' => 404,

				'message' => 'Something is wrong please try again later',

				], REST_Controller::HTTP_OK);
 		}

		}else{
			$this->token_error();
		}
	}





public function country_get() {

		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){


		//returns all rows if the id parameter doesn't exist,

		//otherwise single row will be returned

	    $device_type = $this->get('device_type');

		$country = $this->user->getCountry();



		//check if the user data exists

		if(!empty($country)){

			//set the response and exit

			//OK (200) being the HTTP response code

			if($device_type == 'iOS'){

			$this->response([

						'code' => 200,

						'status' => TRUE,

						'message' => 'Country list successfully',

						'data' => $country

					], REST_Controller::HTTP_OK);

		}else{

			$this->response($country, REST_Controller::HTTP_OK);

		}





		}else{

			//set the response and exit

			//NOT_FOUND (404) being the HTTP response code

			$this->response([

				'status' => FALSE,

				'code' => 404,

				'message' => 'No country were found.'

			], REST_Controller::HTTP_OK);

		}
		}else{
			$this->token_error();
		}
	}







	public function profession_get() {

		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){

	 	$device_type = $this->uri->segment(4);
	 	$type        = (!empty($this->get('type')))?$this->get('type'):1;
	 	$profession  = $this->user->getprofession($type);

		if(!empty($profession)){

			//set the response and exit

			//OK (200) being the HTTP response code
			if(strtolower($device_type) =='ios'){
				$this->response([
				'status' => TRUE,
				'code' => 200,
				'message' => 'Success.',
				'data'  => $profession
			], REST_Controller::HTTP_OK);
			}else{
				$this->response($profession, REST_Controller::HTTP_OK);
			}

		}else{

			//set the response and exit

			//NOT_FOUND (404) being the HTTP response code

			$this->response([

				'status' => FALSE,

				'code' => 404,

				'message' => 'No profession were found.'

			], REST_Controller::HTTP_OK);

		}
		}else{
			$this->token_error();
		}
	}



	public function change_password_post() {

	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){

		$params  = $this->post();


	if(!empty($params['current_password']) && !empty($params['new_password'])) {
		//if(!empty($params['current_password']) && !empty($params['new_password']) && !empty($params['id'])) {

		$current_password = $params['current_password'];

		$new_password     = $params['new_password'];

		// $id 		      = $params['id'];
		 $id 		      = $this->user_id;

		if (trim($current_password)  != trim($new_password)) {
		$result 	      = $this->user->chnage_pssword($current_password,$new_password,$id);
    	if($result==1){
    		//set the response and exit
					$this->response([

						'code' => 200,

						'status' => TRUE,

						'message' => 'The password has been changed successfully.'

					], REST_Controller::HTTP_OK);



    	}elseif($result==2){

    		//set the response and exit

					$this->response([

						'code' => 404,

						'status' => FALSE,

						'message' => 'The Current password mismatch.'

					], REST_Controller::HTTP_OK);

    	}



		}else{

				$this->response([

						'code' => 404,

						'status' => FALSE,

						'message' => 'The old password and new password are same.'

					], REST_Controller::HTTP_OK);

		}





    	}else{

			//set the response and exit

			//BAD_REQUEST (400) being the HTTP response code

            $this->response("Provide complete change password information to update the password.", REST_Controller::HTTP_OK);

		}

		}else{
			$this->token_error();
		}
	}



	public function speaking_language_get(){
if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){


		$languages = 	array("Dutch", "English", "Papiamento", "Spanish", "Balochi", "Dari", "Pashto", "Turkmenian", "Uzbek", "Ambo", "Chokwe", "Kongo", "Luchazi", "Luimbe-nganguela", "Luvale", "Mbundu", "Nyaneka-nkhumbi", "Ovimbundu", "Albaniana", "Greek", "Macedonian", "Catalan", "French", "Portuguese", "Arabic", "Hindi", "Indian-Languages", "Italian", "Armenian", "Azerbaijani", "Samoan", "Tongan", "Creole-English", "Canton-Chinese", "German", "Serbo-Croatian", "Vietnamese", "Czech", "Hungarian", "Polish", "Romanian", "Slovene", "Turkish", "Lezgian", "Russian", "Kirundi", "Swahili", "Adja", "Aizo", "Bariba", "Fon", "Ful", "Joruba", "Somba", "Busansi", "Dagara", "Dyula", "Gurma", "Mossi", "Bengali", "Chakma", "Garo", "Khasi", "Marma", "Santhali", "Tripuri", "Bulgariana", "Romani", "Creole-French", "Belorussian", "Ukrainian", "Garifuna", "Maya-Languages", "Aimar\u00e1", "Guaran\u00ed", "Ket\u0161ua", "Japanese", "Bajan", "Chinese", "Malay", "Malay-English", "Asami", "Dzongkha", "Nepali", "Khoekhoe", "Ndebele", "San", "Shona", "Tswana", "Banda", "Gbaya", "Mandjia", "Mbum", "Ngbaka", "Sara", "Eskimo-Languages", "Punjabi", "Romansh", "Araucan", "Rapa-nui", "Dong", "Hui", "Mant\u0161u", "Miao", "Mongolian", "Puyi", "Tibetan", "Tujia", "Uighur", "Yi", "Zhuang", "Akan", "Gur", "Kru", "Malinke", "[South]Mande", "Bamileke-bamum", "Duala", "Fang", "Maka", "Mandara", "Masana", "Tikar", "Boa", "Luba", "Mongo", "Ngala-and-Bangi", "Rundi", "Rwanda", "Teke", "Zande", "Mbete", "Mboshi", "Punu", "Sango", "Maori", "Arawakan", "Caribbean", "Chibcha", "Comorian", "Comorian-Arabic", "Comorian-French", "Comorian-madagassi", "Comorian-Swahili", "Crioulo", "Moravian", "Silesiana", "Slovak", "Southern-Slavic-Languages", "Afar", "Somali", "Danish", "Norwegian", "Swedish", "Berberi", "Sinaberberi", "Bilin", "Hadareb", "Saho", "Tigre", "Tigrinja", "Basque", "Galecian", "Estonian", "Finnish", "Amhara", "Gurage", "Oromo", "Sidamo", "Walaita", "Saame", "Fijian", "Faroese", "Kosrean", "Mortlock", "Pohnpei", "Trukese", "Wolea", "Yap", "Mpongwe", "Punu-sira-nzebi", "Gaeli", "Kymri", "Abhyasi", "Georgiana", "Osseetti", "Ewe", "Ga-adangme", "Kissi", "Kpelle", "Loma", "Susu", "Yalunka", "Diola", "Soninke", "Wolof", "Balante", "Mandyako", "Bubi", "Greenlandic", "Cakchiquel", "Kekch\u00ed", "Mam", "Quich\u00e9", "Chamorro", "Korean", "Philippene-Languages", "Chiu-chau", "Fukien", "Hakka", "Miskito", "Haiti-Creole", "Bali", "Banja", "Batakki", "Bugi", "Javanese", "Madura", "Minangkabau", "Sunda", "Gujarati", "Kannada", "Malayalam", "Marathi", "Orija", "Tamil", "Telugu", "Urdu", "Irish", "Bakhtyari", "Gilaki", "Kurdish", "Luri", "Mazandarani", "Persian", "Assyrian", "Icelandic", "Hebrew", "Friuli", "Sardinian", "Circassian", "Ainu", "Kazakh", "Tatar", "Gusii", "Kalenjin", "Kamba", "Kikuyu", "Luhya", "Luo", "Masai", "Meru", "Nyika", "Turkana", "Kirgiz", "Tadzhik", "Khmer", "T\u0161am", "Kiribati", "Tuvalu", "Lao", "Lao-Soung", "Mon-khmer", "Thai", "Bassa", "Gio", "Grebo", "Mano", "Mixed-Languages", "Singali", "Sotho", "Zulu", "Lithuanian", "Luxembourgish", "Latvian", "Mandarin-Chinese", "Monegasque", "Gagauzi", "Malagasy", "Dhivehi", "Mixtec", "N\u00e1huatl", "Otom\u00ed", "Yucatec", "Zapotec", "Marshallese", "Bambara", "Senufo-and-Minianka", "Songhai", "Tamashek", "Maltese", "Burmese", "Chin", "Kachin", "Karen", "Kayah", "Mon", "Rakhine", "Shan", "Bajad", "Buryat", "Dariganga", "Dorbet", "Carolinian", "Chuabo", "Lomwe", "Makua", "Marendje", "Nyanja", "Ronga", "Sena", "Tsonga", "Tswa", "Hassaniya", "Tukulor", "Zenaga", "Bhojpuri", "Chichewa", "Ngoni", "Yao", "Dusun", "Iban", "Mahor\u00e9", "Afrikaans", "Caprivi", "Herero", "Kavango", "Nama", "Ovambo", "Malenasian-Languages", "Polynesian-Languages", "Hausa", "Kanuri", "Songhai-zerma", "Bura", "Edo", "Ibibio", "Ibo", "Ijo", "Tiv", "Sumo", "Niue", "Fries", "Maithili", "Newari", "Tamang", "Tharu", "Nauru", "Brahui", "Hindko", "Saraiki", "Sindhi", "Cuna", "Embera", "Guaym\u00ed", "Pitcairnese", "Bicol", "Cebuano", "Hiligaynon", "Ilocano", "Maguindanao", "Maranao", "Pampango", "Pangasinan", "Pilipino", "Waray-waray", "Palau", "Papuan-Languages", "Tahitian", "Avarian", "Bashkir", "Chechen", "Chuvash", "Mari", "Mordva", "Udmur", "Bari", "Beja", "Chilluk", "Dinka", "Fur", "Lotuko", "Nubian-Languages", "Nuer", "Serer", "Bullom-sherbro", "Kono-vai", "Kuranko", "Limba", "Mende", "Temne", "Nahua", "Sranantonga", "Czech-and-Moravian", "Ukrainian-and-Russian", "Swazi", "Seselwa", "Gorane", "Hadjarai", "Kanem-bornu", "Mayo-kebbi", "Ouaddai", "Tandjile", "Ane", "Kaby\u00e9", "Kotokoli", "Moba", "Naudemba", "Watyi", "Kuy", "Tokelau", "Arabic-French", "Arabic-French-English", "Ami", "Atayal", "Min", "Paiwan", "Chaga-and-Pare", "Gogo", "Ha", "Haya", "Hehet", "Luguru", "Makonde", "Nyakusa", "Nyamwesi", "Shambala", "Acholi", "Ganda", "Gisu", "Kiga", "Lango", "Lugbara", "Nkole", "Soga", "Teso", "Tagalog", "Karakalpak", "Goajiro", "Warrau", "Man", "Muong", "Nung", "Tho", "Bislama", "Futuna", "Wallis", "Samoan-English", "Soqutri", "Northsotho", "Southsotho", "Venda", "Xhosa", "Bemba", "Chewa", "Lozi", "Nsenga");

		$device_type = $this->uri->segment(4);

	 	if(strtolower($device_type) =='ios'){

	 		if(!empty($languages)){
	 			$this->response([

						'code' => 200,

						'status' => TRUE,

						'data' => $languages,

						'message' => 'Success'

					], REST_Controller::HTTP_OK);
	 		}else{
				$this->response([

						'code' => 404,

						'status' => FALSE,

						'message' => 'No details found'

					], REST_Controller::HTTP_OK);
	 		}

		}else{

			$this->response($languages, REST_Controller::HTTP_OK);
		}

		}else{
			$this->token_error();
		}
	}









public function state_get($id = 0) {

	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){

		//returns all rows if the id parameter doesn't exist,
		//otherwise single row will be returned
		$states = $this->user->getCountryState($id);
		$device_type = $this->get('device_type');

		//check if the user data exists

		if(!empty($states)){

			//set the response and exit

			//OK (200) being the HTTP response code

			if($device_type == 'iOS'){

			$this->response([

						'code' => 200,

						'status' => TRUE,

						'message' => 'State list successfully',

						'data' => $states

					], REST_Controller::HTTP_OK);

			}else{

				$this->response($states, REST_Controller::HTTP_OK);

			}


		}else{

			//set the response and exit

			//NOT_FOUND (404) being the HTTP response code

			$this->response([

				'code' => 404,

				'status' => FALSE,

				'message' => 'No states were found.'

			], REST_Controller::HTTP_OK);

			}
		}else{
			$this->token_error();
		}
	}



	public function forgot_password_post()

    {
		
		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){


    	$email_id = $this->post('forget_email');

    	$valid_email = $this->user->forgot_password($email_id);

    	if($valid_email==1){



    		//set the response and exit

					$this->response([

						'code' => 200,

						'status' => TRUE,

						'message' => 'We have sent you mail with password reset link'

					], REST_Controller::HTTP_OK);



    	}elseif($valid_email==2){

    		//set the response and exit

					$this->response([

						'code' => 404,

						'status' => FALSE,

						'message' => 'Email ID not registered, Please register'

					], REST_Controller::HTTP_OK);

    	}elseif($valid_email==3){

    		//set the response and exit

					$this->response([

						'code' => 404,

						'status' => FALSE,

						'message' => 'Your account is not activated, please  check your mail and activate your account',

					], REST_Controller::HTTP_OK);

    	}

    	}else{
			$this->token_error();
		}
    }



	public function registration_post() {
	
	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){

    	ini_set('max_execution_time', 259200);
		ini_set('max_input_time', 259200);
		ini_set('memory_limit', '128M');
		ini_set('post_max_size', '128M');
		ini_set('upload_max_filesize', '128M');

/*
      $test = '';
      foreach ($_FILES['profile_img'] as $key => $value) {
        $test .= $key.'----------------'.$value.'<br>';
      }



    $myFile = "uploads/data.txt";

    $fh = fopen($myFile, 'a');



    fwrite($fh, $test . "\n");
    fwrite($fh, 'error' . "\n");

    fclose($fh);exit;
*/
/*
$profile_img = 'uploads/profile_images/'.$_FILES['profile_img']['name'];

move_uploaded_file($_FILES['profile_img']['tmp_name'], $profile_img);exit;
*/


		$userData = array();

		$params = array();

		$params =  $this->post();

		$userData['fullname'] = $params['fullname'];

		$userData['username'] = $params['username'];

		$userData['email'] 	  = $params['email'];

		$userData['password'] = md5($params['password']);

		$userData['state'] 	  = $params['state'];

		$userData['country']  = $params['country'];

		$userData['verified'] = 1;

        $userData['status']    = 1;

		$userData['user_timezone'] 	= ($params['user_timezone']!='')?$params['user_timezone']:'Asia/Kolkata' ;

	     date_default_timezone_set($userData['user_timezone']);

        $userData['created_date'] 	= date('Y-m-d H:i:s') ;





        	if(!empty($_FILES['profile_img']['name'])){



				 $pic          = $_FILES['profile_img']['name'];

				 $pic          = explode(".",$pic);

				 $pic[0]       = time();

				 $profile_name = implode(".",$pic);

				 $config['upload_path'] 	= 'uploads/profile_images/';

				 $config['allowed_types']   = '*';

				 $config['max_size'] 		= '0';//$this->config->item('max_upload_size');

				 $config['encrypt_name'] 	= TRUE;

				 $config['remove_spaces'] 	= TRUE;

				 $config['file_name'] 		= $profile_name;

				 $config['overwrite'] 		= TRUE;

         /*
        $profile_img = 'uploads/profile_images/'.$_FILES['profile_img']['name'];

         move_uploaded_file($_FILES['profile_img']['tmp_name'], $profile_img);exit;
         */

				 $this->load->library('upload', $config);

				 if ($this->upload->do_upload('profile_img'))

				 {

					$this->outputData['photo'] = $this->upload->data();

					$profile_img = $this->outputData['photo']['file_name'];

					$userData['user_thumb_image']   = 'uploads/profile_images/'.$profile_img;

					$userData['user_profile_image'] = 'uploads/profile_images/'.$profile_img;

				 }else{
				echo $this->upload->display_errors(); exit;
			}

         	}





		if(!empty($userData['fullname']) && !empty($userData['username']) && !empty($userData['email']) && !empty($userData['password']) && !empty($userData['state']) && !empty($userData['country'])){



			$email = trim($userData['email']);

			$username = trim($userData['username']);



			   $valid_email = $this->user->check_email($email);



			   $valid_username = $this->user->check_username($username);



			if ($valid_email == 0 &&  $valid_username == 0) {

				//insert user data

				$insert = $this->user->insert($userData);



				//check if the user data inserted

				if($insert){

					//set the response and exit

					$this->response([

						'code' => 200,

						'status' => TRUE,

						'message' => 'Thanks ! Activation mail has been sent to registered Mail Id'

					], REST_Controller::HTTP_OK);

				}else{

					//set the response and exit

					$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_OK);

				}

			}else{



				if($valid_email > 0 && $valid_username > 0){



					$username_email_error = array();

					$username_email_error['code'] = 404;

					$username_email_error['status'] = FALSE;

					$username_email_error['message'] = 'Email ID and Username already exists';

					$this->response($username_email_error, REST_Controller::HTTP_OK);



				} elseif($valid_email > 0){

					$email_error = array();

					$email_error['code'] = 404;

					$email_error['status'] = FALSE;

					$email_error['message'] = 'Email ID already exists';

					$this->response($email_error, REST_Controller::HTTP_OK);



				} elseif ($valid_username > 0) {

					$username_error = array();

					$username_error['code'] = 404;

					$username_error['status'] = FALSE;

					$username_error['message'] = 'Username already exists';

					$this->response($username_error, REST_Controller::HTTP_OK);

				}



			}



        }else{

			//set the response and exit

			//BAD_REQUEST (400) being the HTTP response code
      $data_error = array();

			$data_error['code'] = 404;

			$data_error['status'] = FALSE;

		  $data_error['message'] = 'Provide complete user information to create.';

		  $this->response($data_error, REST_Controller::HTTP_OK);

			}
		}else{
			$this->token_error();
		}
	}



	 public function login_post()

     {
	
		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){


     	  $username = $this->post('username');

     	  if(empty($username)){

     	  	$username = $this->post('email');

     	  }
          $password = $this->post('password');

        $result = $this->user->check_login($username,$password);

        if(!empty($result))

        {

         if($result['verified']==0&&$result['status']==0)

         {

			$this->response([

				'status' => TRUE,

				'code' => 200,

				'message' => 'Login successfully',

				'data' =>[$result]

				], REST_Controller::HTTP_OK);



         }elseif($result['verified']==1&&$result['status']==1){



         		$this->response([

				'status' => FALSE,

				'code' => 404,

				'message' => 'Your account is not activated, please  check your mail and activate your account',

				'data' => []

				], REST_Controller::HTTP_OK);

      }elseif($result['verified']==0&&$result['status']==1){



         		$this->response([

				'status' => FALSE,

				'code' => 201,

				'message' => 'Your account is inactivated',

				'data' => []

				], REST_Controller::HTTP_OK);

         }



       }else{

       	$this->response([

				'status' => FALSE,

				'code' => 404,

				'message' => 'Invalid Login credentials',

				'data' => []

				], REST_Controller::HTTP_OK);

       }

       }else{
			$this->token_error();
		}

     }

     public function paypal_setting_post(){

	
	if($this->user_id !=0){ // || ($this->default_toke ==$this->api_token)

     	$paypalemail = $this->post('paypal_email');

     	$user_id     = $this->user_id; // $this->post('user_id');

     	if(!empty($paypalemail) && !empty($user_id)){

     		$result = $this->user->paypal_setting($paypalemail,$user_id);

     		if ($result==1) {

     			$this->response([

				'status' => TRUE,

				'code' => 200,

				'message' => 'PayPal email has been saved successfully.',

				], REST_Controller::HTTP_OK);

     		} if ($result==2) {

     			$this->response([

				'status' => TRUE,

				'code' => 200,

				'message' => 'PayPal email has been update successfully.',

				], REST_Controller::HTTP_OK);

     		} else {

     			$this->response([

				'status' => FALSE,

				'code' => 404,

				'message' => 'Something is wrong please try again later',

				], REST_Controller::HTTP_OK);

     		}







     	}else{

     		//set the response and exit

			//BAD_REQUEST (400) being the HTTP response code

            $this->response("Provide complete paypal setting information to update paypal setting.", REST_Controller::HTTP_OK);

     	}

     	}else{
			$this->token_error();
		}

     }



     public function profile_post(){

     	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){

	  $data = array();



      $data['contact']     = $this->post('user_contact');

      $data['zipcode']     = $this->post('user_zip');

      $data['city']        = $this->post('user_city');

      $data['address']     = $this->post('user_addr');

      $data['description'] = $this->post('user_desc');

      $data['country']     = $this->post('country_id');

      $data['state'] 	   = $this->post('state_id');

      $data['profession']  = $this->post('profession');

      $data['fullname']    = $this->post('user_name');

      $data['lang_speaks'] = $this->post('language_tags');

	  // $user_id = $this->post('user_id');
	  	 $user_id = $this->user_id;





	    if(!empty($_FILES['profile_img']['name'])){



				 $pic          = $_FILES['profile_img']['name'];

				 $pic          = explode(".",$pic);

				 $pic[0]       = time();

				 $profile_name = implode(".",$pic);

				 $config['upload_path'] 	= 'uploads/profile_images/';

				 $config['allowed_types']   = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';

				 $config['max_size'] 		= $this->config->item('max_upload_size');

				 $config['encrypt_name'] 	= TRUE;

				 $config['remove_spaces'] 	= TRUE;

				 $config['file_name'] 		= $profile_name;

				 $config['overwrite'] 		= TRUE;



				 $this->load->library('upload', $config);

				 if ($this->upload->do_upload('profile_img'))

				 {

					$this->outputData['photo'] = $this->upload->data();

					$profile_img = $this->outputData['photo']['file_name'];

					$data['user_thumb_image']   = 'uploads/profile_images/'.$profile_img;

					$data['user_profile_image'] = 'uploads/profile_images/'.$profile_img;

					$result_data = $this->db->select('user_thumb_image,user_profile_image')->where('USERID',$user_id)->get('members')->row_array();

					if(!empty($result_data['user_profile_image'])){

						if(file_exists(FCPATH.$result_data['user_profile_image'])){

							unlink(FCPATH.$result_data['user_profile_image']);

						}

					}

				 }



       	}



      if(!empty($user_id) && !empty($data['fullname'])){



      	$result = $this->user->setting_profile_update($data,$user_id);



      	if($result){

      		$this->response([

				'status' => TRUE,
				'code' => 200,
				'message' => 'Profile update successfully.',
				'data' => $result

			], REST_Controller::HTTP_OK);

      	}else{

      		$this->response([

				'status' => FALSE,

				'code' => 404,

				'message' => 'Something is wrong please try again later',

			], REST_Controller::HTTP_OK);

      	}



      }else{

      	//set the response and exit

    		//BAD_REQUEST (400) being the HTTP response code
        $this->response([
          'code' => 404,
          'status' => FALSE,
          'message' => 'Required information is missing..',
          'data' => []
        ], REST_Controller::HTTP_OK);
      }


      }else{
			$this->token_error();
		}


     }



    public function profile_details_post(){
	
	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)){
	   	// $user_id = $this->post('user_id');
	   	
	   	 $user_id = $this->user_id;

      if(!empty($user_id)){
      	$result = $this->user->edit_profile($user_id);
      	if($result){

      		$this->response([

				'status' => TRUE,

				'code' => 200,

				'message' => 'SUCCESS',

				'data' => [$result]

			], REST_Controller::HTTP_OK);

      	}else{

      		$this->response([

				'status' => FALSE,

				'code' => 404,

				'message' => 'Something is wrong please try again later',

			], REST_Controller::HTTP_OK);

      	}

      }else{
       $this->response("Required information is missing.", REST_Controller::HTTP_OK);
      }

      }else{
			$this->token_error();
		}
     }

     public function token_error(){
	
		$this->response([
				'code' => 498,
				'status' => FALSE,
				'message' => 'Invalid token or Token missing'
			], REST_Controller::HTTP_OK);
	}

}
?>