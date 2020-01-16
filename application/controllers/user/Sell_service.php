<?php 

class Sell_service extends CI_Controller{

    public function __construct() 

    {			

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

		if($this->session->userdata('SESSION_USER_ID'))

		{

			$this->load->helper('ckeditor'); 

			$this->data['ckeditor_editor'] = array

			(

			//id of the textarea being replaced by CKEditor

			'id' => 'gig_details',

			// CKEditor path from the folder on the root folder of CodeIgniter

			'path' => 'assets/js/ckeditor',

			// optional settings

			'config' => array

			(

			'toolbar' => "Full"

			)

			);

			$this->data['ckeditor_editor_one'] = array

			(

			//id of the textarea being replaced by CKEditor

			'id' => 'requirements',

			// CKEditor path from the folder on the root folder of CodeIgniter

			'path' => 'assets/js/ckeditor',

			// optional settings

			'config' => array

			(

			'toolbar' => "Full"

			

			)

			);

			

			$LAST_ACTIVITY = $this->session->userdata('LAST_ACTIVITY');

			if (isset($LAST_ACTIVITY) && (time() - $LAST_ACTIVITY > 86400 )) 

			{        

				session_unset();     // unset $_SESSION variable for the run-time

				session_destroy();   // destroy session data in storage

				redirect(base_url());

			 }

			$this->load->model('user_panel_model');

			$this->load->model('gigs_model');

			$this->data['title'] 			= 'Gigs';

			$this->data['theme']			= 'user';

			$this->data['module']			= 'sell_service';       

			$this->data['client_list']		= $this->user_panel_model->get_client_list();        

			$this->data['categories']  		= $this->user_panel_model->categories(); 

			$this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();

			$this->data['footer_sub_menu'] 	= $this->user_panel_model->footer_sub_menu();   

			$this->data['system_setting']	= $this->user_panel_model->system_setting();

			//$this->data['rupee_dollar_rate']         = $this->user_panel_model->get_rupee_dollar_rate();

			//$rupee_dollar_rate 						 = $this->data['rupee_dollar_rate'];

			$user_ip 						= getenv('REMOTE_ADDR');		 

			if(($this->session->userdata('time_zone'))){

			       

				$this->data['time_zone']		 = $this->session->userdata('time_zone');        

				$this->data['full_country_name'] ='';         

				$this->data['country_name'] 	 = $this->session->userdata('country_name');                

				$this->data['dollar_rate'] 		 = $this->session->userdata('dollar_rate');  

				$this->data['rupee_rate'] 		 = $this->session->userdata('rupee_rate'); 

			}        

			else             

			{

				if($this->session->userdata('LAST_ACTIVITY')=='')

				{

					$this->session->set_userdata('LAST_ACTIVITY',time());	

				}

					$user_ip 	= getenv('REMOTE_ADDR');     					 

					 $this->data['time_zone'] 			= $this->session->userdata('timezone');                       

					$this->data['dollar_rate'] 			=  $rupee_dollar_rate['dollar_rate'] ;  

					$this->data['rupee_rate']  			=  $rupee_dollar_rate['indian_rate']; 

					$this->session->set_userdata('dollar_rate',$this->data['dollar_rate']); 

					$this->session->set_userdata('rupee_rate',$this->data['rupee_rate']);            

					if($this->session->userdata('SESSION_USER_ID'))

					{

						$data['user_timezone'] = $this->data['time_zone'] ;

						$this->db->where('USERID',$this->session->userdata('SESSION_USER_ID'));

						$this->db->update('members',$data);         

					}

      		 }

			if($this->session->userdata('SESSION_USER_ID'))

			{

			$this->data['user_favorites'] = $this->gigs_model->add_favourites();

			}

			

		

		

			$this->data['gig_price'] = $this->gigs_model->gig_price();

			$this->data['extra_gig_price'] = $this->gigs_model->extra_gig_price();

			$this->data['price_option'] = $this->gigs_model->get_setting_price_option();

			$this->data['gigs_country']             =  $this->gigs_model->gigs_country();
			
			$this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();


	 }

	 else

	 {

		 redirect(base_url());

	 }

	 $this->data['currency_option'] = 'USD';

	 if(!empty($this->data['system_setting'])){

	 	$system_setting = $this->data['system_setting'];

	 	if(!empty($system_setting)){

	 		foreach ($system_setting as  $settings) {

	 			if($settings['key']=='currency_option'){

	 				$this->data['currency_option'] =$settings['value'];

	 			}

	 		}

	 	}

	 }

 

    }    

    function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude,$t)

	 {

		$json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");     

		$data = json_decode($json,true);  

		$tzone=$data['timeZoneId'];      

		return $tzone;

	}

    public function index()

    {   

	 	$query = $this->db->query("select * from system_settings WHERE status = 1");

		$result = $query->result_array();

		$this->email_tittle='Gigs';

		if(!empty($result))

		{

		foreach($result as $data){



		if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){

		$this->site_name = $data['value'];

		$this->data['site_name'] =$this->site_name;

		}

		}

		}

		if($this->session->userdata('SESSION_USER_ID'))

		{

			$this->data['page_title'] = 'Sell Service';

			$this->data['page'] = 'index';

			$this->load->vars($this->data);

			$this->load->view($this->data['theme'].'/template');

		}

		else

		{

			redirect(base_url());

		}

    }

    

    public function add_gigs()

    {     

    	

       if($this->input->post('form_submit'))

       {		

		$gig_tags = ucfirst($this->input->post('gig_tags'));	   

		if(!empty($gig_tags))

		{

			$data['gig_tags'] = $gig_tags;

		}				   

       $data['user_id'] = $this->session->userdata('SESSION_USER_ID');

       $title =  strtolower($this->input->post('gig_title'));

       $data['title'] = url_title($title,'-');

       $data['gig_price'] = $this->input->post('gig_price');   

       $data['time_zone'] = $time_zone = $this->session->userdata('time_zone');

       $data['delivering_time'] = $this->input->post('delivering_time');

       $data['category_id'] = $this->input->post('gig_category_id');

      

       $data['gig_details'] = ucfirst($this->input->post('gig_details'));  

        

       $super_fast_charges = $this->input->post('super_fast_charges');

       $super_fast_delivery = $this->input->post('super_fast_delivery'); 

       $super_fast_delivery_date = $this->input->post('super_fast_delivery_date');

       if(!empty($super_fast_delivery))

       {

       $data['super_fast_charges'] = $this->input->post('super_fast_charges');

       $data['super_fast_delivery'] = $this->input->post('super_fast_delivery'); 

	   $data['super_fast_delivery_desc'] = ucfirst($this->input->post('super_fast_delivery_desc')); 

       $data['super_fast_delivery_date'] = $this->input->post('super_fast_delivery_date');

       }    

       

       $data['work_option'] = $this->input->post('work_option');

       $data['requirements'] = ucfirst($this->input->post('requirements'));    

       $data['country_name'] = $this->input->post('full_country_name');    

       $country_name = $this->session->userdata('country_name');      	                             

       if($country_name=='IN')

       {

       $data['currency_type'] = 1;    

       }

       else 

       {

       $data['currency_type'] = 2;    

       } 

	   date_default_timezone_set($time_zone);

	   $current_time= date('Y-m-d H:i:s');

	   

	   $data['created_date']      = $current_time;   

	   $data['youtube_url']  	  = $this->input->post('youtube_url');

	   $data['vimeo_url']   	  = $this->input->post('vimeo_url');

   	   $data['vimeo_video_id']    = $this->input->post('vimeo_video_id');

   	   $data['status']   = 1; // 0 - Active , 1 - Inactive 

   	   $data['currency_type'] = $this->data['currency_option'];

   	   $this->db->select('value');
   	   $this->db->where('key', 'price_option');
   	   $price_by = $this->db->get('system_settings')->row_array();
   	   $cost_type = ($price_by['value'] == 'dynamic')?1:0;	
   	   $data['cost_type'] = $cost_type;

       if($this->db->insert('sell_gigs',$data))

       { 

       

	   

	   $gigs_id = $this->db->insert_id();  

	   $this->session->set_flashdata('message','Gig added successfully, once get admin approval gigs will be shown in buy service page.');
       /*$this->session->set_userdata('message','Gig added successfully, once get admin approval gigs will be shown in buy service page.');*/
 

              

       $images = $this->input->post('image_array');    

       $videos = $this->input->post('video_array'); 

	                    

       $images =  explode(',',$images);                                       

       $videos =  explode(',',$videos);                                       

       for($i=0;$i<sizeof($images);$i++)

       {

       $data1['gig_id'] = $gigs_id;

       $data1['image_path'] = 'uploads/gig_images/680_460_'.$images[$i];

	   $data1['gig_image_thumb'] = 'uploads/gig_images/50_34_'.$images[$i];

	   $data1['gig_image_tile'] = 'uploads/gig_images/100_68_'.$images[$i];

	   $data1['gig_image_medium'] = 'uploads/gig_images/240_162_'.$images[$i];

       $this->db->insert('gigs_image',$data1);

	    

       }

	   $videos   = array_filter($videos);

	   if(!empty($videos)){

       for($i=0;$i<sizeof($videos);$i++)

       {

       $data2['gig_id'] = $gigs_id;

       $data2['video_path'] = 'uploads/gigs_videos/'.$videos[$i];

       $this->db->insert('gigs_video',$data2);

	    

       }                                

	   }

       $extra_gigs = $this->input->post('extra_gigs');

       if(!empty($extra_gigs)){

       $extra_gigs = array_filter($extra_gigs);

	   }

    

       if(!empty($extra_gigs))

       {

       $data3['extra_gigs'] 		 = $this->input->post('extra_gigs');

       $data3['extra_gigs_delivery'] = $this->input->post('extra_gigs_delivery');  

       $data3['extra_gigs_amount']   = $this->input->post('extra_gigs_amount');  

    

       for($i=0;$i<sizeof($data3['extra_gigs']);$i++)

       {

		   if($data3['extra_gigs'][$i]!='')

		   {

       $data4['gigs_id'] = $gigs_id;

       $data4['extra_gigs'] = $data3['extra_gigs'][$i];

	   $data4['currency_type'] = $data['currency_type'];

       $data4['extra_gigs_amount'] = $data3['extra_gigs_amount'][$i];

       $data4['extra_gigs_delivery'] = $data3['extra_gigs_delivery'][$i];               

       $this->db->insert('extra_gigs',$data4);  

  		$this->session->set_flashdata('message','The gigs have been added to getting the admin approval. After admin approval, the gigs have been listed.');

		   }

       }

       }

		redirect(base_url()); 


	   

       // redirect(base_url().'gig-preview/'.$data['title']);

       }

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

		

		/*

		 * Copy cropped region from temporary image into the desired GD image

		 */

		

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

		

		/*

		 * Render the image

		 * Alternatively, you can save the image in file-system or database

		 */

		//$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

		 

		   $image_url =  "uploads/gig_images/".$width."_".$height."_".$filename."";    

		imagepng($desired_gdim,$image_url);

		

		return $image_url;

		

		/*

		 * Add clean-up code here

		 */

	}

	public function file_upload()

	{

		$file_type = $this->input->post('file_type');                                

		$form_data = $_FILES['gig_files']['name'];

		$row_id = $this->input->post('row_id');                                

		if (isset($_FILES['gig_files']['name']) && !empty($_FILES['gig_files']['name'])) {              

				$html ='';

				$uploaded_file_name = $_FILES['gig_files']['name'];               

				$uploaded_file_name_arr = explode('.', $uploaded_file_name);

				$filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

				$filename = time().$filename;

				$this->load->library('common');

				if($file_type=='image')

				{

				$upload_sts = $this->common->global_file_upload('uploads/gig_images/', 'gig_files', $filename);              

				}

				else if($file_type=='video')

				{

				 $upload_sts = $this->common->global_file_upload('uploads/gigs_videos/', 'gig_files', $filename);                  

				}

				$uploaded_files = array();

				if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {                

				//	print_r($upload_sts);

				$uploaded_file_name = $upload_sts['data']['file_name'];                                    

				if(isset($upload_sts['data']['file_ext'])&&trim($upload_sts['data']['file_ext'])==".mp4")

				{

					// print_r($upload_sts);

					// $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

					//print_r($_SERVER);

					$file = FCPATH.'uploads/gigs_videos/'.$upload_sts['data']['file_name'];

					$newfile = FCPATH.'uploads/gigs_videos/'.$upload_sts['data']['raw_name'].".ogg";

					copy($file, $newfile);



				}

				$file_name = $uploaded_file_name;              

				$uploaded_files[] = $file_name;

				if($file_type=='image')

				{

				//$file_path =   base_url().'uploads/gig_images/'.$file_name;

				//$this->image_resize(50,34,$file_path,$file_name);

				//$this->image_resize(100,68,$file_path,$file_name);

				//$this->image_resize(680,460,$file_path,$file_name);

				}

				else if($file_type=='video')

				{

				$file_path =   base_url().'uploads/gigs_videos/'.$file_name;

				}

				

				$row_id = $row_id+1; 

				

				if($file_type=='image')

				{   

				$html = "<div id=\"remove_image_div_$row_id\" class=\"uploaded-img\"> "

				. "<img  height='100px' width='100px' class=\"imageThumb\" src=\"" .$file_path. "\" title=\"".$file_name. "\"/>" .

				"<a onclick=\"remove_files('$file_name','$row_id','image')\"  href=\"javascript:;\" class=\"uploaded-remove pull-right\">

				<i class=\"fa fa-times\"></i>

				</a></div>";           

				}

				else if($file_type=='video')

				{

				$html = " <div id=\"remove_video_div_$row_id\" class=\"uploaded-img\"> "

						. "<video  class=\"img-responsive\"  style=\"height:100px !important; \">"

						. "<source  src=\"" .$file_path. "\"; type=\"video/mp4\" codecs=\"avc1.4D401E, mp4a.40.2\">"

						. "<source  src=\"" .$file_path. "\"; type=\'video/webm; codecs=\"vp8.0, vorbis\"'>"

						. "<source  src=\"" .$file_path. "\";type='video/ogg; codecs=\"theora, vorbis\"'>"

						. "<source  src=\"" .$file_path. "\";type='video/mp4; codecs=\"avc1.4D401E, mp4a.40.2\"'>    </video>  "                   

						."<a href=\"javascript:;\"  onclick=\"remove_files('$file_name','$row_id','video')\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";           

				}           

				}            

				echo json_encode(array('html'=>$html,'sub_html'=>$uploaded_files,'row_id'=>$row_id));           

				}                     

	} 



	public function delete_uploaded_file()

	{

		$file_name = $this->input->post('filename');

		$file_type = $this->input->post('file_type');

		

		 if($file_type=='image')

				{

				$file_path =  FCPATH.'uploads/gig_images/'.$file_name;

				}

				else if($file_type=='video')

				{

				 $file_path = FCPATH.'uploads/gigs_videos/'.$file_name;

				}            

				$html = '';

		if(unlink ($file_path))

		{

		$html = 1;

		}

		echo json_encode(array('html'=>$html,'sub_html'=>$file_name));

	}

	public function update_gig_detail()

	{

			$id = $this->input->post('id');

			$file_name = $this->input->post('filename');

			$file_type = $this->input->post('file_type');

			$new_file_name = explode("/",$file_name);	

			 if($file_type=='image')

					{

					$file_path =  FCPATH.'uploads/gig_images/'.$new_file_name[2];

					$this->db->where('id',$id);

					$this->db->delete('gigs_image');

					$html = 1;

					}

					else if($file_type=='video')

					{

					$file_path = FCPATH.'uploads/gigs_videos/'.$new_file_name[2];

					$this->db->where('id',$id);

					$this->db->delete('gigs_video');

					$html = 1;

					}            

					$html = '';

			if(unlink ($file_path))

			{

			$html = 1;			

			}

			echo json_encode(array('html'=>$html,'sub_html'=>$new_file_name[2]));

    }



	public function prf_crop() 

	{ 

 			ini_set('max_execution_time', 3000); 

  			ini_set('memory_limit', '-1');

			$html=$error_msg= $shop_ad_id='';

			$error_sts=0;

			$row_id = $this->input->post('select_row_id');					

			$image_data = $this->input->post('img_data');

 

				$base64string = str_replace('data:image/png;base64,', '', $image_data);

				$base64string = str_replace(' ', '+', $base64string);

				$data = base64_decode($base64string);

				$img_name = time();

				$file_name_final='gig_'.$img_name.".png";

				$img_name2 = "680_460_".$file_name_final; 

				file_put_contents('uploads/gig_images/'.$img_name2, $data); 

				

				//$imageFileType= 'png';

				//$rawname='gig_'.$img_name;

				$source_image= 'uploads/gig_images/'.$img_name2; 

				$blog_themb = $this->image_resize(100,68,$source_image,$file_name_final);

				$blog_themb_one = $this->image_resize(50,34,$source_image,$file_name_final);

				$gigs_medium = $this->image_resize(240,162,$source_image,$file_name_final);

			 

			  $html = "<div id=\"remove_image_div_$row_id\" class=\"uploaded-img\"> "

					. "<img  height='68' width='100' class=\"imageThumb\" src=\"" .base_url().$blog_themb . "\" title=\"".$blog_themb. "\"/>" .

					"<a onclick=\"remove_files('$img_name2','$row_id','image')\"  href=\"javascript:;\" class=\"uploaded-remove pull-right\">

					<i class=\"fa fa-times\"></i>

					</a></div>"; 

					

		    $row_id = $row_id+1;

		    $response = array(

								'state'  => 200,

								'message' => $error_msg,

								'result' => $html,

								'row_id' => $row_id,

								'sub_html' => $file_name_final,

								'sts' => $error_sts

		    );

  		    echo json_encode($response); 

	}

	public function prf_crop_call($image_name,$av_data,$new_name,$t_width,$t_height) { 

  			$path              = 'uploads/gig_images/'; 

   			$w                 = $av_data['width'];

			$h                 = $av_data['height'];

			$x1                = $av_data['x'];

			$y1                = $av_data['y'];

 			list($imagewidth, $imageheight, $imageType) = getimagesize('uploads/gig_images/'.$image_name);

			$imageType                                  = image_type_to_mime_type($imageType);

 			$ratio             = ($t_width/$w); 

			$ratio_one         = ($t_height/$h);

			$nw                = ceil($w * $ratio);

			$nh                = ceil($h * $ratio_one);  

			$newImage          = imagecreatetruecolor($nw,$nh);

			switch($imageType) {

				case "image/gif"  : $source = imagecreatefromgif('uploads/gig_images/'.$image_name); 

									break;

				case "image/pjpeg":

				case "image/jpeg" :

				case "image/jpg"  : $source = imagecreatefromjpeg('uploads/gig_images/'.$image_name); 

									break;

				case "image/png"  :

				case "image/x-png": $source = imagecreatefrompng('uploads/gig_images/'.$image_name); 

									break;

			} 

			imagecopyresampled($newImage,$source,0,0,$x1,$y1,$nw,$nh,$w,$h);

			switch($imageType) {

				case "image/gif"  : imagegif($newImage,$path.$new_name); 

									break;

				case "image/pjpeg":

				case "image/jpeg" :

				case "image/jpg"  : imagejpeg($newImage,$path.$new_name,100); 

									break;

				case "image/png"  :

				case "image/x-png": imagepng($newImage,$path.$new_name);  

									break;

			} 

 	} 

	

	public function you_tube_links()

	{

			$youtube_url = $this->input->post('youtube_url');

		    $result 	 = preg_match_all('~https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'"][^<>]*>|</a>))[?=&+%\w.-]*~ix', $youtube_url, $matchs);

               

             if($result>0)

               {              

               foreach($matchs as $key => $vals)

                        {                                   

                   if (filter_var($vals[0], FILTER_VALIDATE_URL) === false) {

                       $url = $vals[0] ;

                       break;

                   }                      

                        } 

$width = '200px';

$height = '100px';

 $html = " <div id=\"remove_youtube_div\" class=\"uploaded-img\"> "

		.'<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$url.'" frameborder="0" allowfullscreen></iframe>'		                   

						."<a  onclick=\"remove_third_party_link('remove_youtube_div')\" href=\"javascript:;\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";   

  						

						

 echo $html;

			   }

	}

	

		public function vimeo_links()

	{

			$vimeo_url = $this->input->post('vimeo_video_id');		    

			$width	   = '200px';

			$height    = '100px';



	$html = " <div id=\"remove_vimeo_div\" class=\"uploaded-img\"> "

. "<iframe src=\"//player.vimeo.com/video/$vimeo_url?portrait=0&color=333\" width=\"$width\" height=\"$height\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>"

						."<a  onclick=\"remove_third_party_link('remove_vimeo_div')\" href=\"javascript:;\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";  						

						

 echo $html;

			  

	}



}

?>