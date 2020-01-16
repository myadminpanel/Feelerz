<?php
  ini_set('memory_limit', '-1');
  ini_set('max_execution_time', 0);
if (!defined('BASEPATH')) exit('No direct script access allowed');

//include Rest Controller library..
require APPPATH . '/libraries/REST_Controller.php';

class Gigs extends REST_Controller {

    public function __construct() {
        parent::__construct();
		//load user model
        $this->load->model('api_gigs_model','gigs');
          $this->load->helper('favourites');
        $common_settings = gigs_settings();
        $this->default_currency = 'USD';
        if(!empty($common_settings)){
          foreach($common_settings as $datas){

 			if($datas['key'] == 'live_publishable_key'){

					$live_publishable_key = $datas['value'];

				} 

				if($datas['key'] == 'live_secret_key'){

					$live_secret_key = $datas['value'];

				} 
				if($datas['key'] == 'publishable_key'){
					$publishable_key = $datas['value'];
				}
				if($datas['key'] == 'secret_key'){
					$secret_key = $datas['value'];
				}

				if($datas['key'] == 'stripe_option'){

					$stripe_option = $datas['value'];

				}
 
            if($datas['key']=='currency_option'){
             $default_currency = $datas['value'];
            }
            if($datas['key']=='price_option'){
             $this->price_option = $datas['value'];
            }
            if($datas['key']=='gig_price'){
             $this->gig_price = $datas['value'];
            }
            if($datas['key']=='extra_gig_price'){
             $this->extra_gig_price = $datas['value'];
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

        $this->load->helper('currency');
        $this->default_currency      = $default_currency;
        $this->default_currency_sign = currency_sign($default_currency);

        $this->smtp_config           = smtp_mail_config();


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

		$header =  getallheaders(); // Get Header Data
    	$token = (!empty($header['token']))?$header['token']:'';
    	if(empty($token)){
    		$token = (!empty($header['Token']))?$header['Token']:'';
    	}
    	$this->default_toke = md5('Dreams99');
    	$this->api_token = $token;
    	$this->user_id = $this->gigs->get_user_id_using_token($token);
 
     }

	public function index_get($id = '') {

		if($this->user_id !=0  || ($this->default_toke ==$this->api_token)) {
			
		$favourites_gig_ids = '';
		$device_type =  $this->get('device_type');
		$device_type = strtolower($device_type);
		$id = $this->user_id;
		
		if(!empty($id)){
			$favourites_gig_ids = $this->gigs->favourites_gig_ids($id);
		}
		$data = array();
		$data['base_url'] 			= base_url();
		$data['popular_gigs_image'] = $this->gigs->popular_gigs_image();
		$data['categories'] 		= $this->gigs->categories();
		$popular_gigs_list			= $this->gigs->popular_gigs_list($id);
		$recent_gigs_list			= $this->gigs->recent_gigs_list($id);

		if(!empty($favourites_gig_ids)){
			if(!empty($popular_gigs_list)){
				$popular_gigs_list = favorites_check($popular_gigs_list,$favourites_gig_ids);
			}
			if(!empty($recent_gigs_list)){
				$recent_gigs_list = favorites_check($recent_gigs_list,$favourites_gig_ids);
			}

		}
		$data['popular_gigs_list']	= $popular_gigs_list;
		$data['recent_gigs_list']	= $recent_gigs_list;

		$final_data = ($device_type == 'ios')?$data:[$data];
     	//set the response and exit
		//OK (200) being the HTTP response code

		$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'primary' => $final_data
					], REST_Controller::HTTP_OK);
		}else{
			$this->token_error();
		}
	}



	public function categories_get() {

		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)) {

		$type      = !empty($this->uri->segment(4))?$this->uri->segment(4):'1';	
		$categories = $this->gigs->allcategories($type);

		if(!empty($categories)){
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'primary' => $categories
					], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No category were found.'
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	}
	public function categories_post() {
		
		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)) {

		$id     		 = $this->post('category_id');
		// $userid 		 = $this->post('user_id');
		 $userid 		 = $this->user_id;
		$sub_category_id = $this->post('sub_category_id');
		$services		 = $this->post('services');
   		$device_type = strtolower($this->post('device_type'));
    	$page = $this->post('page');
    
    if(!isset($page) || empty($page) || ($page == ''))
    {
      $page = 1;
    }
		$records 		 = $this->gigs->categoriesandgigs($id,$sub_category_id,$userid,$services,$device_type,$page);

		if(!empty($records)){
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $records
					], REST_Controller::HTTP_OK);

		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No category were found.',
				'data' => []
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function create_gigs_post() {

		ini_set('max_execution_time', 259200);
		ini_set('max_input_time', 259200);
		ini_set('memory_limit', '128M');
		ini_set('post_max_size', '128M');
		ini_set('upload_max_filesize', '128M');


	if($this->user_id !=0) {	
		
		$params  = $this->post();
 		$params['user_id']  = $this->user_id;

        $work_option = (!empty($params['work_option']))?$params['work_option']:0;
        $super_fast_delivery = (!empty($params['super_fast_delivery']))?strtolower($params['super_fast_delivery']):'no';


		if(!empty($params['user_id']) && !empty($params['title']) && !empty($params['gig_price']) && !empty($params['delivering_time']) && !empty($params['category_id']) && ($params['cost_type'] != '') && !empty($_FILES['image']['name']) && !empty($params['gig_details']) && ($work_option==1 || $work_option==0)  && !empty($params['terms_conditions']) && (!empty($super_fast_delivery)=='no' || (!empty($params['super_fast_delivery_desc']) && !empty($params['super_fast_delivery_date']) && !empty($params['super_fast_charges'])) ) ) {
			$params['status'] = 1; // Waiting state

      		$uploaded_file_name = $_FILES['image']['name'];
			$uploaded_file_name_arr = explode('.', $uploaded_file_name);
			$filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
      
      			$pic          = $uploaded_file_name;
				 $pic          = explode(".",$pic);

				 $pic[0]       = time();

				 $profile_name = implode(".",$pic);

				 $config['upload_path'] 	= 'uploads/gig_images/';

				 $config['allowed_types']   = '*';

				 $config['max_size'] 		= '0';

				 $config['encrypt_name'] 	= TRUE;

				 $config['remove_spaces'] 	= TRUE;

				 $config['file_name'] 		= $profile_name;

				 $config['overwrite'] 		= TRUE;



      $upload_sts = $this->load->library('upload', $config);
		  $this->upload->initialize($config);

      $data1 = array();
      if ($this->upload->do_upload('image'))
      {
        $upload_sts = $this->upload->data();
				$uploaded_file_name = $upload_sts['file_name'];
				if (!empty($uploaded_file_name))
				{
				  $image_url = 'uploads/gig_images/' . $uploaded_file_name;


          //$params['image_path'] = $this->image_resize(680, 460, $image_url, $uploaded_file_name);
          $params['image_path'] = $image_url;
          $params['gig_image_thumb'] = $this->image_resize(50, 34, $image_url, $uploaded_file_name);
          $params['gig_image_tile'] = $this->image_resize(100, 68, $image_url, $uploaded_file_name);
          $params['gig_image_medium'] = $this->image_resize(240, 162, $image_url, $uploaded_file_name);

				}
			}

			$result 	      = $this->gigs->create_gigs($params);
    	if($result==1){

    		//set the response and exit
					$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'The Gigs created successfully.'
					], REST_Controller::HTTP_OK);

    	}elseif($result==2){
    		//set the response and exit
					$this->response([
						'code' => 404,
						'status' => FALSE,
						'message' => 'Something is wrong please try again later.'
					], REST_Controller::HTTP_OK);
    	}elseif($result==3){
    		//set the response and exit
					$this->response([
						'code' => 404,
						'status' => FALSE,
						'message' => 'Already gig title  taken by someone'
					], REST_Controller::HTTP_OK);
    	}

    	}else{
            $this->response([
  						'code' => 404,
  						'status' => FALSE,
              'message' => 'Provide complete information to create gigs.'
          ], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}



	public function update_gigs_post() {
	
	if($this->user_id !=0) {
		$params  = $this->post();
		$params['user_id'] = $this->user_id;

		if(!empty($params['gig_id']) && !empty($params['user_id']) && !empty($params['title']) && !empty($params['gig_price']) && !empty($params['delivering_time']) && !empty($params['category_id']) &&  !empty($params['gig_details']) && ($params['work_option'] != '') && !empty($params['terms_conditions']) && (strtolower($params['super_fast_delivery'])=='no' || (!empty($params['super_fast_delivery_desc']) && !empty($params['super_fast_delivery_date']) && !empty($params['super_fast_charges']) ) ) ) {
      if(!empty($_FILES['image']['name']))
      {
        $this->db->select('image_path,gig_image_thumb,gig_image_tile,gig_image_medium');
        $this->db->from('gigs_image');
        $this->db->where('gig_id',$params['gig_id']);
        $records = $this->db->get()->row_array();
        if(!empty($records))
        {
          foreach($records as $key => $value)
          {
            $value = str_replace('\\', '/', $value);
            unlink (FCPATH.$value);
          }
          $this->db->where('gig_id',$params['gig_id']);
          $del_img = $this->db->delete('gigs_image');
          if($del_img)
          {
            $uploaded_file_name = $_FILES['image']['name'];
      			$uploaded_file_name_arr = explode('.', $uploaded_file_name);
      			$filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
      			$this->load->library('common');
      			$upload_sts = $this->common->global_file_upload('uploads/gig_images/', 'image', $filename);
            $data1 = array();
      			if (isset($upload_sts['success']) && $upload_sts['success'] == 'y')
      			{
      				$uploaded_file_name = $upload_sts['data']['file_name'];
      				if (!empty($uploaded_file_name))
      				{
      				  $image_url = 'uploads/gig_images/' . $uploaded_file_name;
      					//$details['profile_image'] = $image_url;

             //$params['image_path'] = $this->image_resize(680, 460, $image_url, $uploaded_file_name);
               $params['image_path'] = $image_url;
         	   $params['gig_image_thumb'] = $this->image_resize(50, 34, $image_url, $uploaded_file_name);
         	   $params['gig_image_tile'] = $this->image_resize(100, 68, $image_url, $uploaded_file_name);
         	   $params['gig_image_medium'] = $this->image_resize(240, 162, $image_url, $uploaded_file_name);
      				}
      			}
          }
        }
      }
			$result 	      = $this->gigs->update_gigs($params);
    	if($result==1){

    		//set the response and exit
					$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'The Gigs update successfully.'
					], REST_Controller::HTTP_OK);

    	}elseif($result==2){
    		//set the response and exit
					$this->response([
						'code' => 404,
						'status' => FALSE,
						'message' => 'Something is wrong please try again later.'
					], REST_Controller::HTTP_OK);
    	}elseif($result==3){
    		//set the response and exit
					$this->response([
						'code' => 404,
						'status' => FALSE,
						'message' => 'Already gig title  taken by someone'
					], REST_Controller::HTTP_OK);
    	}

    	}else{
            $this->response("Provide complete information to update the gig.", REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}




  public function image_resize($width=0,$height=0,$image_url,$filename)

  	{

  		$source_path = $image_url;

  		list($source_width, $source_height, $source_type) = getimagesize($source_path);

  		switch ($source_type) {

  			case IMAGETYPE_GIF:

  				$source_gdim = imagecreatefromgif($source_path);

  				break;

  			case IMAGETYPE_JPEG:

  				$source_gdim = imagecreatefromjpeg($source_path);

  				break;

  			case IMAGETYPE_PNG:

  				$source_gdim = imagecreatefrompng($source_path);

  				break;

  		}

  		$source_aspect_ratio = $source_width / $source_height;



  		 $desired_aspect_ratio = $width / $height;



  		if ($source_aspect_ratio > $desired_aspect_ratio) {

  			/*

  			 * Triggered when source image is wider

  			 */



  			$temp_height = $height;

  			$temp_width = ( int ) ($height * $source_aspect_ratio);

  		} else {

  			/*

  			 * Triggered otherwise (i.e. source image is similar or taller)

  			 */

  			$temp_width = $width;

  			$temp_height = ( int ) ($width / $source_aspect_ratio);

  		}



  		/*

  		 * Resize the image into a temporary GD image

  		 */

  		$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);

  		imagecopyresampled(

  			$temp_gdim,

  			$source_gdim,

  			0, 0,

  			0, 0,

  			$temp_width, $temp_height,

  			$source_width, $source_height

  		);
  		$x0 = ($temp_width - $width) / 2;

  		$y0 = ($temp_height - $height) / 2;

  		$desired_gdim = imagecreatetruecolor($width, $height);

  		imagecopy(

  			$desired_gdim,

  			$temp_gdim,

  			0, 0,

  			$x0, $y0,

  			$width, $height

  		);
  		$image_url =  "uploads/gig_images/".$width."_".$height."_".$filename."";

  		if($source_type ==IMAGETYPE_PNG){
  			imagepng($desired_gdim,$image_url);
  		}
  		if ($source_type ==IMAGETYPE_JPEG) {
  			imagejpeg($desired_gdim,$image_url);
  		}
  		return $image_url;
  	}

	public function edit_gigs_post(){

		if($this->user_id !=0) {
			
		if($this->user_id !="" && $this->post('gig_id')!=""){
			$params  = $this->post();
			$params['user_id'] = $this->user_id;
			$records = array();
			$records = $this->gigs->edit_details($params);
			if(!empty($records)){
					$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => [$records ]
				], REST_Controller::HTTP_OK);
			}else{
					$this->response([
						'code' => 404,
						'status' => TRUE,
						'message' => 'No records were found',
						'data' => []
				], REST_Controller::HTTP_OK);
			}


		}else{
			$this->response([
						'code' => 404,
						'status' => FALSE,
						'message' => 'Input Params Missing'
				], REST_Controller::HTTP_OK);
		}

	}else{
			$this->token_error();
		}
	}

	public function search_gig_post(){
		
	
	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)) {

		if($this->post()){
			$params    = $this->post();
			$gigs_list = $this->gigs->search_data($params);

			if(!empty($gigs_list)){
				$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $gigs_list
					], REST_Controller::HTTP_OK);
		 }else{	
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No gigs were found.'
			], REST_Controller::HTTP_OK);
		 }
		}
	}else{
			$this->token_error();
		}
	}
	public function gigs_list_get($userid=0) {

		if($this->user_id !=0) {
		if(!empty($userid)){
			$favourites_gig_ids = $this->gigs->favourites_gig_ids($userid);
		}

		$gigs_list = $this->gigs->gigs_list($userid);
		if(!empty($favourites_gig_ids)){
			if(!empty($gigs_list)){
				$gigs_list = favorites_check($gigs_list,$favourites_gig_ids);
			}
		}
		if(!empty($gigs_list)){
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $gigs_list
					], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No gigs were found.'
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function my_gigs_get($userid=0) {

		if($this->user_id !=0) { 
			$userid = $this->user_id;

		if(!empty($userid)){
			

			$favourites_gig_ids = $this->gigs->favourites_gig_ids($userid);
		}
		$my_gigs_list = $this->gigs->my_gigs_list($userid);
		if(!empty($favourites_gig_ids)){
			if(!empty($my_gigs_list)){
				$my_gigs_list = favorites_check($my_gigs_list,$favourites_gig_ids);
			}
		}
		if(!empty($my_gigs_list)){
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $my_gigs_list
					], REST_Controller::HTTP_OK);
		}else{
			//set the response and exit
			//NOT_FOUND (404) being the HTTP response code
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No gigs were found.'
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

  public function my_gigs_post() {
	
	if($this->user_id !=0) {

    $userid = $this->user_id;
    $device_type = strtolower($this->post('device_type'));
    $page = $this->post('page');
    if(!isset($page) || empty($page) || ($page == ''))
    {
      $page = 1;
    }
		if(!empty($userid)){
			$favourites_gig_ids = $this->gigs->favourites_gig_ids($userid);
		}
		$my_gigs_list = $this->gigs->my_gigs_list($userid);
		if(!empty($favourites_gig_ids)){
			if(!empty($my_gigs_list)){
				$my_gigs_list = favorites_check($my_gigs_list,$favourites_gig_ids);
			}
		}
    if(isset($device_type) && !empty($device_type) && ($device_type == 'ios' || $device_type == 'android'))
    {
      $total_records = count($my_gigs_list);
      if($page == 1) {
        $start = 0;
      }else {
        $start = ($page-1) * 10;
      }
     $my_gigs_list = array_slice( $my_gigs_list, $start, 10 );
     $my_gigs_list = array('total_pages'=>ceil($total_records/10),'gigs_details'=>$my_gigs_list);
    }
		if(!empty($my_gigs_list)){
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $my_gigs_list
					], REST_Controller::HTTP_OK);
		}else{
			//set the response and exit
			//NOT_FOUND (404) being the HTTP response code
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No gigs were found.'
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function gigs_details_post(){

		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)) {

		 $userid  = $this->user_id;
		 $gig_id  = $this->post('gig_id');

		$gig_details = $this->gigs->gigs_details($userid,$gig_id);

		if(!empty($gig_details)){
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => [$gig_details]
					], REST_Controller::HTTP_OK);
		}else{
			//set the response and exit
			//NOT_FOUND (404) being the HTTP response code
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Something is wrong.',
				'data' => []
			], REST_Controller::HTTP_OK);
		}

	}else{
			$this->token_error();
		}
	}

	  public function gig_stripe_payment_post()
	    {
		
		if($this->user_id !=0) {

	    	$data = array();
	  		$response_code = '-1';
	  		$response_message = 'Something is wrong';
	  		$params =  $this->post();
	  		if(!empty($params['amount']) && !empty($params['tokenid']) && !empty($params['description']) && $params['amount'] > 0){

  
	  				$config['publishable_key'] = $this->publishable_key;
					$config['secret_key'] = $this->secret_key;

	  			  $this->load->library('stripe',$config);
	  			  $charges_array = array();
	  			  $amount = $params['amount'];
	  			  $amount = ($amount *100);
	  			  $currency = (!empty($params['currency']))?$params['currency']:'USD';

	  			  $charges_array['amount']       = $amount;
		  	      $charges_array['currency']     = $currency;
		  	      $charges_array['description']  = $params['description'];
				  $charges_array['source']       = $params['tokenid'];

	  			$result = $this->stripe->stripe_charges($charges_array);

	  			$result = json_decode($result,true);
	  			if(empty($result['error'])){
	  				$data['transaction_id'] = $result['id'];
	  				$data['payment_details'] = json_encode($result);

	  				$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'Success',
						'data' => $data
					], REST_Controller::HTTP_OK);

	  			}else{
	  				
	  				$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => $result['error'],
						'data' => $data
					], REST_Controller::HTTP_OK);
	  			}


	  		}else{

	  			$this->response([
						'code' => 404,
						'status' => TRUE,
						'message' => 'Required input missing',
						'data' => $data
					], REST_Controller::HTTP_OK);

	  		}
	    	
		    }else{
				$this->token_error();
			}
	    }

	    public function stripe_private_key_get()
	    {
	    	if($this->user_id !=0) {

	    		$stripe_payment_key = $this->gigs->stripe_payment_key();


	    		if(!empty($stripe_payment_key)){
	    			
					$this->response([
							'code' => 200,
							'status' => TRUE,
							'message' => 'SUCCESS',
							'data' => $stripe_payment_key
						], REST_Controller::HTTP_OK);
					}else{
						$this->response([
							'code' => 404,
							'status' => FALSE,
							'message' => 'No payment key found.'
						], REST_Controller::HTTP_OK);
					}}else{
						$this->token_error();
				}
			}

	public function stripe_account_details_post(){
		
		if($this->user_id !=0) {

		 $userid  = $this->user_id;
		 $account_holder_name  = $this->post('account_holder_name');
		 $account_number  = $this->post('account_number');
		 $account_iban  = $this->post('account_iban');
		 $bank_name  = $this->post('bank_name');
		 $bank_address  = $this->post('bank_address');
		 $sort_code  = $this->post('sort_code');
		 $routing_number  = $this->post('routing_number');
		 $account_ifsc  = $this->post('account_ifsc');

if(!empty($userid) && !empty($account_holder_name) && !empty($account_number) && !empty($bank_name) && !empty($bank_address)  && (!empty($sort_code) || !empty($routing_numbe) || !empty($account_ifsc))){

		$inputs = $this->post();
		$inputs['user_id'] = $userid;

		 $stripe_account_details = $this->gigs->stripe_account_details($inputs);

		if(!empty($stripe_account_details)){

			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $stripe_account_details
					], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No details were found.',
				'data' => []
			], REST_Controller::HTTP_OK);
		}

     }else{
     		$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Provide complete information to create account details.',
				'data' => []
			], REST_Controller::HTTP_OK);
     }

		}else{
			$this->token_error();
		}
	
	}

	public function seller_buyer_review_post(){
		
		if($this->user_id !=0) {
		 $userid  = ''; //$this->post('userid');
		 $gig_id  = $this->post('gig_id');
		$seller_buyer_review = $this->gigs->seller_buyer_review($userid,$gig_id,0);

		if(!empty($seller_buyer_review)){
			//set the response and exit
			//OK (200) being the HTTP response code
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $seller_buyer_review
					], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No details were found.',
				'data' => []
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	}

	public function add_favourites_post(){
	
	if($this->user_id !=0) {

  if($this->user_id !="" && $this->post('gig_id')!=""){
			$data['gig_id'] = $this->post('gig_id');
  			$data['user_id'] = $this->user_id;
  			$result  = $this->gigs->add_favourites($data);
			if($result){
					$this->response([
							'code' => 200,
							'status' => TRUE,
							'message' => 'Favourites details added successfully.',
						], REST_Controller::HTTP_OK);
				}else{
					$this->response([
						'code' => 404,
						'status' => FALSE,
						'message' => 'Something is wrong.',
					], REST_Controller::HTTP_OK);
				}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Favourites details missing',
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	}

	public function remove_favourites_post(){
		
		if($this->user_id !=0) {

		if($this->post()) {
			$gig_id = $this->post('gig_id');
  			$user_id = $this->user_id;
			$result  = $this->gigs->remove_favourites($gig_id,$user_id);
			if($result){
				$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'Favourites has been removed successfully.',
					], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong.',
				], REST_Controller::HTTP_OK);
			}

		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Favourites details missing',
			], REST_Controller::HTTP_OK);
		}

	}else{
			$this->token_error();
		}
	}
	public function favourites_gigs_post(){

		if($this->user_id !=0) {

		if($this->post()) {
			$user_id = $this->user_id;
      $device_type = strtolower($this->post('device_type'));
      $page = $this->post('page');
      if(!isset($page) || empty($page) || ($page == ''))
      {
        $page = 1;
      }

			if(!empty($user_id)){
					$favourites_gig_ids = $this->gigs->favourites_gig_ids($user_id);
			}

			$records  = $this->gigs->favourites_gigs($user_id);
			if(!empty($favourites_gig_ids)){
				if(!empty($records)){
					$records = favorites_check($records,$favourites_gig_ids);
				}
			}

      if(isset($device_type) && !empty($device_type) && ($device_type == 'ios' || $device_type == 'android'))
      {
        $total_records = count($records);
        if($page == 1) {
          $start = 0;
        }else {
          $start = ($page-1) * 10;
        }
       $records = array_slice( $records, $start, 10 );
       $records = array('total_pages'=>ceil($total_records/10),'favourite_details'=>$records);
      }

			if(!empty($records)){
				$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $records
					], REST_Controller::HTTP_OK);
			}else{
				$this->response([
						'code' => 404,
						'status' => TRUE,
						'message' => 'No gigs were found',
						'data' => []
					], REST_Controller::HTTP_OK);
			}

		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Something is wrong.',
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	
	}
	public function last_visit_post(){
		if($this->user_id !=0) {

		if($this->post()) {
			$params = $this->post();
			$params['user_id'] = $this->user_id;
			if(!empty($params['user_id']) && !empty($params['gig_id']) ){

				$user_id = $params['user_id'];
				$gig_id = $params['gig_id'];
				$records  = $this->gigs->last_visited_update($user_id,$gig_id);
				if($records){
					$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
					], REST_Controller::HTTP_OK);
				}else{
					$this->response([
						'code' => 404,
						'status' => TRUE,
						'message' => 'Something is wrong',
					], REST_Controller::HTTP_OK);
				}


			}else{

            $this->response("Provide complete information to update last visit.", REST_Controller::HTTP_OK);
		 }
		}
		}else{
			$this->token_error();
		}
	}
		public function last_visited_gigs_post(){
		
		if($this->user_id !=0) {

		if($this->post()) {
			
			$user_id = $this->user_id;
      		$device_type = strtolower($this->post('device_type'));
      		$page = $this->post('page');

      if(!isset($page) || empty($page) || ($page == ''))
      {
        $page = 1;
      }
			if(!empty($user_id)){
				$favourites_gig_ids = $this->gigs->favourites_gig_ids($user_id);
			}
			$records  = $this->gigs->last_visited_gigs($user_id);
			if(!empty($favourites_gig_ids)){
				if(!empty($records)){
					$records = favorites_check($records,$favourites_gig_ids);
				}
			}
      if(isset($device_type) && !empty($device_type) && ($device_type == 'ios' || $device_type == 'android'))
      {
        $total_records = count($records);
        if($page == 1) {
          $start = 0;
        }else {
          $start = ($page-1) * 10;
        }
       $records = array_slice( $records, $start, 10 );
       $records = array('total_pages'=>ceil($total_records/10),'visited_details'=>$records);
      }

			if(!empty($records)){
				$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $records
					], REST_Controller::HTTP_OK);
			}else{
				$this->response([
						'code' => 404,
						'status' => TRUE,
						'message' => 'No records were found',
						'data' => []
					], REST_Controller::HTTP_OK);
			}

		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Something is wrong.',
			], REST_Controller::HTTP_OK);
		}

	}else{
			$this->token_error();
		}
	}

	public function my_gig_activity_post(){

		if($this->user_id !=0) { 

		$user_id = $this->user_id;
		if(!empty($user_id)){

			//$records['my_purchases_total'] = $this->gigs->get_user_orders_total($user_id);
			$records['my_purchases'] 	   = $this->gigs->get_user_orders($user_id);
			//$records['my_sale_total']	   = $this->gigs->get_selluser_details_total($user_id);
			$records['my_sale']      	   = $this->gigs->get_selluser_details($user_id);
			//$records['my_payments_total']  = $this->gigs->getuser_wallets_details_total($user_id);
			$records['my_payments']  	   = $this->gigs->getuser_wallets_details($user_id);
			$records['wallet_balance']     = $this->gigs->wallet_balance($user_id);
			$records['paypal_id']   	   = $this->gigs->current_paypal_id($user_id);


			$this->response([
				'code' => 200,
				'status' => TRUE,
				'message' => 'SUCCESS',
				'data' => $records
			], REST_Controller::HTTP_OK);

		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'User info missing.',
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	}
	public function seller_reviews_post(){
		
		if($this->user_id !=0) {
		
		// $user_id = $this->user_id;
		$user_id = $this->post('user_id');
    	$device_type = strtolower($this->post('device_type'));
    	$page = $this->post('page');

    if(!isset($page) || empty($page) || ($page == ''))
    {
      $page = 1;
    }
		if(!empty($user_id)){
			$reviews = array();
			$records  = $this->gigs->seller_reviews($user_id, $device_type, $page);
			if(!empty($records)){
					$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'SUCCESS',
					'data' => $records
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No result were found',
				'data' => $reviews
			], REST_Controller::HTTP_OK);
			}


		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'User info missing.',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function buyer_cancel_post(){

		if($this->user_id !=0) {

		$params = $this->post();
		$params['user_id'] = $this->user_id;

		$cancel_by = (!empty($params['cancel_by']))?$params['cancel_by']:'';

		if(!empty($params['order_id']) && !empty($params['cancel_reason']) && !empty($params['user_id']) && !empty($params['time_zone'])  && (!empty($cancel_by) && ($cancel_by == 'paypal') && !empty($params['paypal_email'])) ||  (!empty($cancel_by) && ($cancel_by == 'stripe') )){
			
			if($params['cancel_by'] == 'paypal'){
				$result = $this->gigs->change_gigs_status($params);
			}
			if($params['cancel_by'] == 'stripe'){
				$result = $this->gigs->change_stripe_status($params);
				
			}

			if($result==1){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Cancelled successfully.',
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later.',
				], REST_Controller::HTTP_OK);
			}

		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Buyer cancel info missing.',
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	}

	


	public function seefeedback_post(){
		if($this->user_id !=0) {

		$params = $this->post();
		$params['user_id']   = $this->user_id;
		$params['to_user_id'] = $this->user_id;

		if(!empty($params['from_user_id']) && !empty($params['to_user_id']) && !empty($params['gig_id']) && !empty($params['order_id']) && !empty($params['user_id'])){

			$result = $this->gigs->seefeedback($params);
			if(!empty($result)){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Feed Back',
					'data' => $result
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'seefeedback info missing.',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function sale_order_status_post(){
		if($this->user_id !=0) {
		$params = $this->post();

		if(!empty($params['order_id']) && !empty($params['order_status']) && !empty($params['time_zone']) ){
			$params['val'] = 1;
			$result = $this->gigs->sale_change_gigs_status($params);
			if($result==1){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Order status has been changed successfully.',
				], REST_Controller::HTTP_OK);
			}elseif($result==2){
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'sale order change info missing.',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function withdram_details_post(){
	
	if($this->user_id !=0) {
		$params = $this->post();
		$params['user_id'] = $this->user_id;


		if(!empty($params['order_id']) && !empty($params['user_id'])){
			$user_id  = $params['user_id'];
			$count = $this->gigs->account_checking($user_id);
			if($count>0){
			$id = $params['order_id'];
			$params['val'] = 1;

			$records = $this->gigs->withdram_details($id);
			if(!empty($records)){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Order status has been changed successfully.',
					'data' =>$records,
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		 }else{
		 	$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'You have not entered your bank account details. Please add your account payment details.',
				], REST_Controller::HTTP_OK);
		 }
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'withdram info missing.',
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	}

	public function withdram_payment_request_post(){
	
	if($this->user_id !=0) {
		$params = $this->post();

		if(!empty($params['order_id'])){
			$params['val'] = 1;
			$id = $params['order_id'];

			$records = $this->gigs->payment_request($id);
			if($records==1){
				$status_array = array('payment_status'=>1,'msg'=>'Payment Request','order_id'=>$id);
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'withdraw request has been send successfully.',
					'data' => $status_array,


				], REST_Controller::HTTP_OK);
			}elseif($records==2){
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
					'data' => [],
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'withdram request info missing.',
				'data' => [],
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	}

	public function leave_feedback_post(){
	
	if($this->user_id !=0) {
		$type = $this->post('type');
		if($type == 1){
			$this->purchases_feedback(); // Buyer Feedback
		}
		if($type == 2){
			$this->seller_feedback(); // Seller Feedback
		}

	}else{
			$this->token_error();
		}
	}

	public function purchases_feedback(){
if($this->user_id !=0) {
			$params = $this->post();

		if(!empty($params['from_user_id']) && !empty($params['to_user_id']) && !empty($params['gig_id']) && !empty($params['order_id']) && !empty($params['comment']) && !empty($params['rating']) && !empty($params['time_zone'])){

			$result = $this->gigs->save_purchase_feedback($params);
			if($result==1){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Feedback saved successfully.',
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Buyer feedback info missing.',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}


	public function seller_feedback(){
if($this->user_id !=0) {
		$params = $this->post();

		if(!empty($params['from_user_id']) && !empty($params['to_user_id']) && !empty($params['gig_id']) && !empty($params['order_id']) && !empty($params['comment']) && !empty($params['rating']) && !empty($params['time_zone'])){

			$records = $this->gigs->save_feedback($params);
			if($records==1){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Seller feedback updated successfully.',
				], REST_Controller::HTTP_OK);
			}elseif($records==2){
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'seller feedback info missing.',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function multiple_withdraw_post(){
		
		if($this->user_id !=0) {
		
		$params = $this->post();
		$params['user_id'] = $this->user_id;

		if(!empty($params['user_id']) && !empty($params['order_ids'])){
			$result = 0;
			$result = $this->gigs->multiple_withdraw($params);
			if($result==1){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Multiple withdraw has been updated',
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}


		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Multiple withdraw info missing',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}
	public function accept_buyer_request_post(){
if($this->user_id !=0) {
		$params = $this->post();

		if(!empty($params['time_zone']) && !empty($params['order_id'])){
			$result = 0;
			$result = $this->gigs->accept_buyer_request($params);
			if($result==1){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Cancel has been accepted',
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Cancel info missing',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function overall_withdraw_post(){
	
	if($this->user_id !=0) {
		$params = $this->post();
		$params['user_id'] = $this->user_id;

		if(!empty($params['user_id'])){
			$result = 0;
			$user_id = $params['user_id'];

			$result = $this->gigs->overall_payment_request($user_id);
			if($result==1){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Withdraw request has been send',
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Withdraw info missing',
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->token_error();
		}
	}
	public function messages_post(){
	
	if($this->user_id !=0) {
		$params = $this->post();
		$params['user_id'] = $this->user_id;

		if(!empty($params['user_id'])){
			$result = 0;
			$user_id = $params['user_id'];
			$page = $params['page'];

			$last_userid = $this->gigs->last_chater($user_id);
			$records = $this->gigs->chart_user_details($user_id, $page);

			if(!empty($records)){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'SUCCESS',
					'last_chat_user_id' =>$last_userid,
					'data' =>$records
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Message user info missing',
			], REST_Controller::HTTP_OK);
		}
		
		}else{
			$this->token_error();
		}
	}

public function buyer_chat_post(){
	
	if($this->user_id !=0) {
		$params = $this->post();
		$params['user_id'] = $this->user_id;

		if(!empty($params['sell_gigs_userid']) && !empty($params['chat_message_content']) && !empty($params['user_id'])){
			$result = 0;
			$result = $this->gigs->save_buyerchat($params);

			if($result==1){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'Contact message has been send',
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Buyer chat info missing',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function chat_details_post(){
		
		if($this->user_id !=0) {
		
		$params = $this->post();
		$params['from_user_id'] = $this->user_id;

		if(!empty($params['from_user_id']) && !empty($params['to_user_id'])){
			$result = 0;
			$f_user = $params['from_user_id'];
			$t_user = $params['to_user_id'];
			$page = $params['page'];
			$result = $this->gigs->get_chat_details($f_user,$t_user,$page);
			if($result){


          $bulk_data = array();
          $final_data = array();
          $final_data['total_pages'] = $result['total_pages'];
          $chat_details = $result['chat_details'];
          foreach($chat_details as $fdata){
          $full_data = array();
          $full_data['content'] = $fdata['content'];
          // $full_data['chat_from'] = $fdata['chat_from'];
          $full_data['chat_from'] = $fdata['unique_code'];
          $full_data['chat_to'] = $fdata['chat_to'];
          $full_data['chat_time'] = $fdata['chat_time'];
          $full_data['date'] = date("Y-m-d", strtotime($fdata['chat_time']));
          $full_data['time'] = date("H:i:s", strtotime($fdata['chat_time']));
          $full_data['from_user_name'] = $fdata['from_user_name'];
          $full_data['to_user_name'] = $fdata['to_user_name'];
          $full_data['profile_image'] = $fdata['profile_image'];
          $bulk_data[] = $full_data;

        }
        $final_data['chat_details'] = $bulk_data;
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'SUCCESS',
					'data' => $final_data
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Chat user info missing',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}



	// Push Notification API

	public function push_notification_post(){
	
	if($this->user_id !=0) {
	
		$params = $this->post();
		$params['user_id'] = $this->user_id;

		$API_details  = $this->gigs->settings();
		$include_player = $this->gigs->player_ids($params['user_id']);
		$include_player_ids = $include_player['device_id'];

        if($include_player['device']!='browser'){ // Stop Browser notiticfications


		if(!empty($API_details['one_signal_app_id']) && !empty($API_details['one_signal_reset_key']) && !empty($params['user_id']) && !empty($params['message'])){

			$data = array();
			$data['user_id'] = $params['user_id'];
			$data['message'] = $params['message'];
			$data['app_id'] = $API_details['one_signal_app_id'];
			$data['reset_key'] = $API_details['one_signal_reset_key'];
			$data['include_player_ids'] = $include_player_ids;
			$data['additional_data'] = array();
		 	$result = send_message($data);
			$result = (array)json_decode($result);

			if(is_array($result)){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'SUCCESS',
					'data' => $result
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Push notification info missing',
			], REST_Controller::HTTP_OK);
		}
	}

	}else{
			$this->token_error();
		}
	}

	public function user_chat_post(){
	
	if($this->user_id !=0) {
	
		$params = $this->post();
		$params['from_user_id'] = $this->user_id;

		if(!empty($params['from_user_id']) && !empty($params['to_user_id']) && !empty($params['message'])){
	
	      $qry = $this->db->query("SELECT status FROM `members` WHERE USERID = " .$params['to_user_id']);
    	  $last_user  = $qry->row_array();
      	
      	if($last_user['status'] == 0){
      		
   	  		$result  = $this->gigs->chat_update($params);
			if(is_array($result)){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'SUCCESS',
					'data' => $result
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Sorry, User is inactive!',
			], REST_Controller::HTTP_OK);
		}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Chat info missing',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function save_device_id_post(){
	if($this->user_id !=0) {

		$params = $this->post();
		$params['user_id'] = $this->user_id;

		if(!empty($params['device_id']) && !empty($params['user_id'])){
			$result  = $this->gigs->save_device_id($params);
			if($result == 1 ){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'SUCCESS'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Device ID or User id missing',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function buy_now_post(){
	
		if($this->user_id !=0) {
		
		$params = $this->post();
		$params['buyer_id'] = $this->user_id;

		if (!empty($params['gig_id']) && !empty($params['seller_id']) && !empty($params['gig_rate']) && !empty($params['buyer_id'])) { // && !empty($params['total_delivery_days'])

      $qry = $this->db->query("SELECT status FROM `members` WHERE USERID = " .$params['seller_id']);
      $last_user  = $qry->row_array();
      if($last_user['status'] == 0)
      {

			$data_array = json_decode($params['options'],true);
			$datas = array();

			$i = 0 ;
			$extra_gig_amount = 0 ;
			if(!empty($data_array)){
			foreach ($data_array as  $value) {

				$extra_gigs_amount = $value['extra_gigs_amount'];
				$extra_gig_amount += $extra_gigs_amount;
				$data_string = $value['extra_gigs'].'___'.$params['gig_id'].'___'.$this->default_currency_sign.'___'.$extra_gigs_amount.'___'.$value['extra_gigs_delivery'];
				$datas[$i]['gig_id'] = $params['gig_id'];
				$datas[$i]['user_id'] = $params['buyer_id'];
				$datas[$i]['currency_type'] = $this->default_currency;
				$datas[$i]['options'] = json_encode($data_string);
				$datas[$i]['status'] = '1';
				++$i;
			}
		}
			$params['extra_gig_row_id'] = '""';
			if(!empty($datas)){
				$extra_gig_row_id  = $this->gigs->user_request_gigs($datas);
				if(is_array($extra_gig_row_id)){
					$params['extra_gig_row_id'] = '"'.implode(',', $extra_gig_row_id).'"';
				}
			}
			unset($params['options']);
			$records = array();

			$records  = $this->gigs->buy_now_gig($params,$extra_gig_amount);
			$records['currency'] = $this->default_currency;
			if(!empty($records)){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'SUCCESS',
					'data' => $records
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			 }

   		}else{
   			$this->response([
   				'code' => 404,
   				'status' => FALSE,
   				'message' => 'Sorry, User is inactive!',
   			], REST_Controller::HTTP_OK);
   		}
			}else{

			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'Buy info missing',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function paypal_success_post(){
if($this->user_id !=0) {
		$params = $this->post();

		if (!empty($params['paypal_uid']) && !empty($params['item_number'])) {

			$records  = $this->gigs->paypal_success($params);

			if(!empty($records)){
				$this->response([
					'code' => 200,
					'status' => TRUE,
					'message' => 'SUCCESS',
					'data' => $records
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'code' => 404,
					'status' => FALSE,
					'message' => 'Something is wrong, please try again later',
				], REST_Controller::HTTP_OK);
			 }
			}else{

			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'PayPal Return info missing',
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

	public function footer_menu_get() {
		
		if($this->user_id !=0 || ($this->default_toke ==$this->api_token)) {

		$footer_menu = $this->gigs->get_all_footer_menu();
		if(!empty($footer_menu)){
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'primary' => $footer_menu
					], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No footer menu were found.'
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}
	public function footer_get() {
	
	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)) {
	
		$footer = $this->gigs->GetAllFooter();
		if(!empty($footer)){
			$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'primary' => $footer
					], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'code' => 404,
				'status' => FALSE,
				'message' => 'No footer menu were found.'
			], REST_Controller::HTTP_OK);
		}
	}else{
			$this->token_error();
		}
	}

    public function payment_gateways_get() {
if($this->user_id !=0) {
        $gateways = $this->gigs->GetAllPaymentGateway();
        if(!empty($gateways)){
            $this->response([
                        'code' => 200,
                        'status' => TRUE,
                        'message' => 'SUCCESS',
                        'primary' => $gateways
                    ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'code' => 404,
                'status' => FALSE,
                'message' => 'No payment gateway were found.'
            ], REST_Controller::HTTP_OK);
        }
    }else{
			$this->token_error();
		}
    }

    public function currencies_get() {
if($this->user_id !=0) {
        $currencies = $this->gigs->get_currencies();
        if(!empty($currencies)){
            $this->response([
                        'code' => 200,
                        'status' => TRUE,
                        'message' => 'SUCCESS',
                        'primary' => $currencies
                    ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'code' => 404,
                'status' => FALSE,
                'message' => 'No currencies were found.'
            ], REST_Controller::HTTP_OK);
        }
    }else{
			$this->token_error();
		}
    }

    public function terms_get() {
	
	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)) {
    
        $terms = $this->gigs->get_terms();
        if(!empty($terms)){
            $this->response([
                        'code' => 200,
                        'status' => TRUE,
                        'message' => 'SUCCESS',
                        'data' => $terms
                    ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'code' => 404,
                'status' => FALSE,
                'message' => 'No content were found.'
            ], REST_Controller::HTTP_OK);
        }
    }else{
			$this->token_error();
		}
    }

    public function change_gigs_status_post(){
    if($this->user_id !=0) {
  		$params = $this->post();
  		if(!empty($params['payment_id']) && !empty($params['status']) && !empty($params['time_zone'])){

    		$p_id = $params['payment_id'];
    		$sts  = $params['status'];
        $from_timezone = $params['time_zone'];
        $data['time_zone'] =$from_timezone;
        date_default_timezone_set($from_timezone);
        $current_time= date('Y-m-d H:i:s');
        $data_up['seller_status'] = $sts;
        $data_up['notification_status'] = 1;
        $data_up['update_date'] = $current_time;
        if($sts==5){
        $data_up['update_date'] = $current_time;
        $data_up['notification_status'] = 1;
        $data_up['cancel_notification_status'] = 1;
        }
        if($this->db->update('payments',$data_up,array('id'=>$p_id)))
        {
          $query = $this->db->query("SELECT sg.title,m.fullname as buyername,m.username as buyerusername, m.email as buyeremail,sm.email as selleremail,py.USERID as gbid,py.seller_id as gsid, sm.fullname as sellername,sm.username as sellerusername FROM `payments` as py
              LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id
              LEFT JOIN members as m ON m.USERID = py.USERID
              LEFT JOIN members as sm ON sm.USERID = py.seller_id
              WHERE py.`id` = $p_id");
          $data_one = $query->row_array();
          $title= ucfirst($data_one['title']);

          $gbid= $data_one['gbid'];
          
          $gsid= $data_one['gsid'];

          
          if($sts ==6)
          {
            $to_email= $data_one['buyeremail'];
            $bodyid = 18;
            $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
            $body=$tempbody_details['template_content'];
            $message='';
            $gig_preview_link  = base_url().'gig-preview/'.$title ;
            $gig_purchase  = base_url().'purchases/';
            $body = str_replace('{base_url}', $this->base_domain, $body);
            $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);
            $body = str_replace('{gig_purchase}', $gig_purchase, $body);
            $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
                    $body = str_replace('{site_name}',$this->site_name, $body);
            $body = str_replace('{buyer_name}', $data_one['buyername'], $body);
            $body = str_replace('{gig_owner}', $data_one['sellername'], $body);
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
            $this->email->subject('Your Order Completed');
            $this->email->message($message);
            $this->email->send();
            $this->gigs->order_status_notification($gsid,$title,'Your Order Completed');

            //order complete request accept_buyer_request
            $title= ucfirst($data_one['title']);
            $to_email= $data_one['selleremail'];
            $bodyid = 30;
            $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
            $body=$tempbody_details['template_content'];
            $message='';
            $gig_preview_link  = base_url().'sales';
            $body = str_replace('{base_url}', $this->base_domain, $body);
            $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);
            $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
                    $body = str_replace('{site_name}',$this->site_name, $body);
            $body = str_replace('{buyer_name}', $data_one['buyername'], $body);
            $body = str_replace('{gig_owner}', $data_one['sellername'], $body);
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
            $this->email->subject('Order Completed, Thanks you for order.');
            $this->email->message($message);
            $this->email->send();
            $this->gigs->order_status_notification($gbid,$title,'Order Completed, Thank you for your order.');

          }
          elseif($sts ==8)
          {
            $query = $this->db->query("SELECT sg.title,m.fullname as buyername,m.username as buyerusername, m.email as buyeremail,sm.email as selleremail,sm.fullname as sellername,py.USERID as gbid,py.seller_id as gsid,sm.username as sellerusername FROM `payments` as py
                LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id
                LEFT JOIN members as m ON m.USERID = py.USERID
                LEFT JOIN members as sm ON sm.USERID = py.seller_id
                WHERE py.`id` = $p_id");

            $data_one = $query->row_array();
            $title= ucfirst($data_one['title']);

            $to_email= $data_one['selleremail'];
            
            $gbid = $data_one['gbid'];
            $gsid = $data_one['gsid'];
			
			

            $bodyid = 30;
            $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
            $body=$tempbody_details['template_content'];
            $message='';
            $gig_preview_link  = base_url().'purchases';
            $body = str_replace('{base_url}', $this->base_domain, $body);
            $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);
            $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
                    $body = str_replace('{site_name}',$this->site_name, $body);
            $body = str_replace('{buyer_name}', $data_one['buyername'], $body);
            $body = str_replace('{gig_owner}', $data_one['sellername'], $body);
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
            $this->email->subject('Order Complete Request');
            $this->email->message($message);
            $this->email->send();
            $this->gigs->order_status_notification($gbid,$title,'Order Complete Request');

          }
          elseif($sts ==7)
          {
            $query = $this->db->query("SELECT sg.title,m.fullname as buyername,m.username as buyerusername, m.email as buyeremail, sm.fullname as sellername,sm.username as sellerusername, py.USERID as gbid,py.seller_id as gsid FROM `payments` as py
                LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id
                LEFT JOIN members as m ON m.USERID = py.USERID
                LEFT JOIN members as sm ON sm.USERID = py.seller_id
                WHERE py.`id` = $p_id");
            $data_one = $query->row_array();
            $title= ucfirst($data_one['title']);
            $gbid= $data_one['gbid'];
            $gsid= $data_one['gsid'];
            $to_email= $data_one['buyeremail'];

            $bodyid = 29;
            $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
            $body=$tempbody_details['template_content'];
            $message='';
            $gig_preview_link  = base_url().'purchases';
            $body = str_replace('{base_url}', $this->base_domain, $body);
            $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);
            $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
                    $body = str_replace('{site_name}',$this->site_name, $body);
            $body = str_replace('{buyer_name}', $data_one['buyername'], $body);
            $body = str_replace('{gig_owner}', $data_one['sellername'], $body);
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
            $this->email->subject('Order Complete Request');
            $this->email->message($message);
            $this->email->send();
            $this->gigs->order_status_notification($gbid,$title,'Order Complete Request');

          }
          else if($sts ==5)
          {
            $to_email= $data_one['buyeremail'];
            $bodyid = 25;
            $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
            $body=$tempbody_details['template_content'];
            $message='';
            $gig_preview_link  = base_url().'gig-preview/'.$title ;
            $purchase_link  = base_url().'purchases/' ;
            $body = str_replace('{base_url}', $this->base_domain, $body);
            $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);
              $body = str_replace('{site_name}',$this->site_name, $body);
            $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
            $body = str_replace('{purchase_link}', $purchase_link, $body);
            $body = str_replace('{buyer_name}', $data_one['buyername'], $body);
            $body = str_replace('{gig_owner}', $data_one['sellername'], $body);
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
            $this->email->subject('Your Order Declined from '.$data_one['sellername']);
            $this->email->message($message);
            $this->email->send();
            $this->gigs->order_status_notification($gbid,$title,'Your Order Declined from '.$data_one['sellername']);

          }

          $result = 1;
        }
        else
        {
          $result = 2;
        }

  			if($result == 1 ){
  				$this->response([
  					'code' => 200,
  					'status' => TRUE,
  					'message' => 'SUCCESS'
  				], REST_Controller::HTTP_OK);
  			}else{
  				$this->response([
  					'code' => 404,
  					'status' => FALSE,
  					'message' => 'Something is wrong, please try again later',
  				], REST_Controller::HTTP_OK);
  			}
  		}else{
  			$this->response([
  				'code' => 404,
  				'status' => FALSE,
  				'message' => 'Required information missing',
  			], REST_Controller::HTTP_OK);
  		}
  	}else{
			$this->token_error();
		}
  	}

  	public function rejected_orders_post()
  	{
	
		if($this->user_id !=0) {
			
			$params = $this->post();
  			$params['buyer_id'] = $this->user_id;
  			if(!empty($params['buyer_id']) &&!empty($params['seller_id']) && !empty($params['gig_id']) && !empty($params['order_id']) && !empty($params['reject_reason'])){

  				$result = $this->gigs->complete_accept_reject($params);

  				if($result){
  				$this->response([
  					'code' => 200,
  					'status' => TRUE,
  					'message' => 'SUCCESS'
  				], REST_Controller::HTTP_OK);
  			}else{
  				$this->response([
  					'code' => 404,
  					'status' => FALSE,
  					'message' => 'Something is wrong, please try again later',
  				], REST_Controller::HTTP_OK);
  			}

  			}else{
  			$this->response([
  				'code' => 404,
  				'status' => FALSE,
  				'message' => 'Required information missing',
  			], REST_Controller::HTTP_OK);
  		}


		}else{
			$this->token_error();
		}  		
  	}

    public function accept_seller_decline_request_post(){

    if($this->user_id !=0) {

  		$params = $this->post();
  		$params['user_id'] = $this->user_id;
  		
  		if(!empty($params['user_id']) &&!empty($params['payment_id']) && !empty($params['time_zone'])){
        $p_id = $params['payment_id'];
        $from_timezone = $params['time_zone'];
        $pay_details = $this->gigs->get_payment_details($p_id);
        
        
        $gig_status = $pay_details->seller_status;
        if($gig_status == 5)
        {
          $type = $pay_details->source;
          if(strtolower($type) == 'paypal' || strtolower($type) == 'stripe')
          {
            if(!empty($params['payment_email']) || strtolower($type) == 'stripe' ){

            $pemail  = (!empty($params['payment_email']))?$params['payment_email']:'';
      		$data_up['decline_accept'] = 1;

      		$data_up['notification_status'] = 1;

      		date_default_timezone_set($from_timezone);

      		$current_time= date('Y-m-d H:i:s');

      		$data_up['update_date'] = $current_time;

      		$user_id = $params['user_id'];
      		if(strtolower($type) == 'paypal'){
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
      		}

      		if($this->db->update('payments',$data_up,array('id'=>$p_id)))

      		{

      			$query = $this->db->query("SELECT sg.title,m.fullname as buyername,m.username as buyerusername, sm.email as selleremail,py.USERID as gbid,py.seller_id as gsid, sm.fullname as sellername,sm.username as sellerusername FROM `payments` as py

      					LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

      					LEFT JOIN members as m ON m.USERID = py.USERID

      					LEFT JOIN members as sm ON sm.USERID = py.seller_id

      					WHERE py.`id` = $p_id");

      			$data_one = $query->row_array();

      			$title= $data_one['title'];
      			$gbid= $data_one['gbid'];
      			$gsid= $data_one['gsid'];

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
      				$message_push = 'Your Decline Request Accepted from '.$data_one['buyername'];
      				$this->gigs->order_status_notification($gsid,$title,$message_push);
      				$result = 1;
      		}else{
      			$result = 2;
      		}

    			if($result == 1 ){
    				$this->response([
    					'code' => 200,
    					'status' => TRUE,
    					'message' => 'SUCCESS'
    				], REST_Controller::HTTP_OK);
    			}else{
    				$this->response([
    					'code' => 404,
    					'status' => FALSE,
    					'message' => 'Something is wrong, please try again later',
    				], REST_Controller::HTTP_OK);
    			}
        }
        else{
          $this->response([
            'code' => 404,
            'status' => FALSE,
            'message' => 'Required information missing',
          ], REST_Controller::HTTP_OK);
        }
      }else{
          $this->response([
            'code' => 404,
            'status' => FALSE,
            'message' => 'Something is wrong, please try again later',
          ], REST_Controller::HTTP_OK);
        }
      }else{
          $this->response([
            'code' => 404,
            'status' => FALSE,
            'message' => 'Invalid Gig',
          ], REST_Controller::HTTP_OK);
        }
  		}else{
  			$this->response([
  				'code' => 404,
  				'status' => FALSE,
  				'message' => 'Required information missing',
  			], REST_Controller::HTTP_OK);
  		}
  	}else{
			$this->token_error();
		}
  	}

    public function payment_request_post(){
    if($this->user_id !=0) {

  		$params = $this->post();
  		if(!empty($params['payment_id'])){
        $p_id = $params['payment_id'];

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
  				$result = 1;
    		}
    		else
    		{
    			$result = 2;
    		}

  			if($result == 1 ){
  				$this->response([
  					'code' => 200,
  					'status' => TRUE,
  					'message' => 'SUCCESS'
  				], REST_Controller::HTTP_OK);
  			}else{
  				$this->response([
  					'code' => 404,
  					'status' => FALSE,
  					'message' => 'Something is wrong, please try again later',
  				], REST_Controller::HTTP_OK);
  			}
  		}else{
  			$this->response([
  				'code' => 404,
  				'status' => FALSE,
  				'message' => 'Required information missing',
  			], REST_Controller::HTTP_OK);
  		}
  	}else{
			$this->token_error();
		}
  	}

    public function price_details_get() {
	
	if($this->user_id !=0 || ($this->default_toke ==$this->api_token)) {

		$data['price_option'] = $this->price_option;
    	$data['extra_gig_price'] = $this->extra_gig_price;
    	$data['gig_price'] = $this->gig_price;
		
		$this->response([
						'code' => 200,
						'status' => TRUE,
						'message' => 'SUCCESS',
						'data' => $data
					], REST_Controller::HTTP_OK);
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
