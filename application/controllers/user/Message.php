<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Message extends CI_Controller {
    public $data;
    public function __construct() {
        parent::__construct();
        $this->data['title'] = 'Gigs';
        $this->data['page_title'] = 'Message'; 
        $this->data['theme'] = 'user';
        $this->data['module'] = 'message';
		$this->load->model('user_panel_model');
		$this->load->model('message_model');
		$this->data['client_list'] = $this->user_panel_model->get_client_list();
        $this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();  
        $this->data['logo'] = $this->user_panel_model->get_logo();  
        $this->data['slogan'] = $this->user_panel_model->get_slogan(); 
        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();
        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();
        $this->data['system_setting'] = $this->user_panel_model->system_setting();    
        $this->data['policy_setting'] = $this->user_panel_model->policy_setting(); 
		//$this->data['seo_module_name'] 			= $this->user_panel_model->seo_details('default');			   
        $this->load->model('gigs_model');
        $this->data['recent_gigs'] = $this->gigs_model->recent_gigs(1);
        $this->data['gigs_country']             =  $this->gigs_model->gigs_country();

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

		if($this->session->userdata('SESSION_USER_ID')==''){ 
			redirect(base_url(''));
		}
    }
    public function index($offset=0) {
		$from_timezone =  $this->session->userdata('timezone');
		 $this->data['userid'] = $this->session->userdata('SESSION_USER_ID');
		 $this->data['set_id'] = $offset; 
		 $frnds_list       = $this->message_model->students_friends_with_details($this->data['userid']);
		 
		 $this->data['chat_list'] = $frnds_list;
		 $this->data['page'] = 'messages';
  		 $this->load->vars($this->data);  
		 $this->load->view($this->data['theme'].'/template');
    }
	public function new_message()
    {
		if($this->input->post('send_message')){
			$users=$this->input->post('slt_user_id');
			$msg=$this->input->post('text_message');
			$chat_image    = $this->input->post('user_message_imgpath');
			
			$this->db->select('user_id,user_timezone');
			$this->db->where_in('user_id',$users);
			$query = $this->db->get('users');
	 		$data['date_time'] = date('Y-m-d H:i:s');
			$from_timezone =  $this->session->userdata('timezone');
	   		date_default_timezone_set($from_timezone); 
			$data['chat_from_time'] = date('Y-m-d H:i:s'); 
			
			foreach($query->result() as $row){
				date_default_timezone_set($row->user_timezone); 
      			$data['chat_to_time'] = date('Y-m-d H:i:s');
	  
			if(count($chat_image)>0){
				if(!empty($msg)) {
					$data['content'] = $msg;
					$data['chat_from'] = $this->USERS_SESSION['id'];
					$data['chat_type']= 1;
					$data['file_path']= '';
					$data['chat_to'] = $row->user_id; 
					
					$data['status'] =0;
					$this->db->insert('chats',$data);
				}
				foreach($chat_image as $path)
				{
					$data['content'] = '';
					$data['chat_from'] = $this->session->userdata('SESSION_USER_ID');
					$data['chat_type']= 1;
					$data['file_path']= $path;
					$data['chat_to'] = $row->user_id; 
					$data['status'] =0;
					$this->db->insert('chats',$data);
				}
				
			}
			else{
				$data['content'] = $msg;
				$data['file_path'] = ''; 
				$data['chat_from'] = $this->session->userdata('SESSION_USER_ID');
				$data['chat_type']= 1;
				$data['chat_to'] = $row->user_id; 
				$data['status'] =0;
				$this->db->insert('chats',$data);
			}
			}
			redirect(base_url('users/message'));
		}		
    }
	public function new_message_image()
	{
		if(isset($_FILES)){
 			$no_of_files = sizeof($_FILES['new_message_image']['tmp_name']);
 			$files       = $_FILES['new_message_image'];
			$errors      = $data = array();
			$err2        = 0;
			$html        = '';
 			for($i=0;$i<$no_of_files;$i++) {
			  if($_FILES['new_message_image']['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES['new_message_image']['name'][$i];
			}
 			if(sizeof($errors) == 0)
			{
				  $this->load->library('upload');
 				  $config['upload_path']   = FCPATH . '/uploads/message/';
 				  $config['allowed_types'] = '*';
				  $allowed =  array('image/gif','image/png' ,'image/jpg','image/jpeg');
			      for ($i = 0; $i < $no_of_files; $i++) {
						$_FILES['new_message_image']['name']     = $files['name'][$i];
						$_FILES['new_message_image']['type']     = $files['type'][$i];
						$_FILES['new_message_image']['tmp_name'] = $files['tmp_name'][$i];
						$_FILES['new_message_image']['error']    = $files['error'][$i];
						$_FILES['new_message_image']['size']     = $files['size'][$i];
						$size_val= $this->formatSizeUnits($_FILES['new_message_image']['size']);
 						$this->upload->initialize($config);
 						if ($this->upload->do_upload('new_message_image'))
						{
							$this->outputData['photos']  = $this->upload->data();			
							$prof_img                    = $this->outputData['photos']['file_name']; 
 							$html  .= '<div class="msg-upload">
										<div class="file-det">
							             <input type="hidden" id="user_message_imgpath" name="user_message_imgpath[]" value="uploads/message/'.$prof_img.'">
										 <strong>'.$prof_img.'</strong>
										 <span class="text-muted">'.$size_val.'</span>
										 </div>
										 <a href="javascript:;" class="pull-right" onclick="$(this).parent().remove();">
										  <i class="fa fa-times"> </i></a>';
										 if(in_array($_FILES['new_message_image']['type'],$allowed) ) {
                                        	$html  .= '<div class="msg-upload-img"> <img width="100" height="100" src="'.base_url().'uploads/message/'.$prof_img.'"></div>';
										 }
										
                                      $html  .= '</div>';  
									  
						}else{
							$err2++;
						}
 				  }
			} 
 			echo json_encode(array('sts'=>$err2,'content'=>$html));
		} 
    
	}
	public function new_message_attachment()
	{
		if(isset($_FILES)){
 			$no_of_files = sizeof($_FILES['new_message_imageattach']['tmp_name']);
 			$files       = $_FILES['new_message_imageattach'];
			$errors      = $data = array();
			$err2        = 0;
			$html        = '';
 			for($i=0;$i<$no_of_files;$i++) {
			  if($_FILES['new_message_imageattach']['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES['new_message_imageattach']['name'][$i];
			}
 			if(sizeof($errors) == 0)
			{
				  $this->load->library('upload');
 				  $config['upload_path']   = FCPATH . '/uploads/message/';
 				  $config['allowed_types'] = '*';
				  $allowed =  array('image/gif','image/png' ,'image/jpg','image/jpeg');
			      for ($i = 0; $i < $no_of_files; $i++) {
						$_FILES['new_message_imageattach']['name']     = $files['name'][$i];
						$_FILES['new_message_imageattach']['type']     = $files['type'][$i];
						$_FILES['new_message_imageattach']['tmp_name'] = $files['tmp_name'][$i];
						$_FILES['new_message_imageattach']['error']    = $files['error'][$i];
						$_FILES['new_message_imageattach']['size']     = $files['size'][$i];
						$size_val= $this->formatSizeUnits($_FILES['new_message_imageattach']['size']);
 						$this->upload->initialize($config);
 						if ($this->upload->do_upload('new_message_imageattach'))
						{
							$this->outputData['photos']  = $this->upload->data();			
							$prof_img                    = $this->outputData['photos']['file_name']; 
 							$html  .= '<div class="msg-upload">
										<div class="file-det">
							             <input type="hidden" id="user_message_imgpath" name="user_message_imgpath[]" value="uploads/message/'.$prof_img.'">
										 <strong>'.$prof_img.'</strong>
										 <span class="text-muted">'.$size_val.'</span>
										 </div>
										 <a href="javascript:;" class="pull-right" onclick="$(this).parent().remove();">
										  <i class="fa fa-times"> </i></a>';
										 if(in_array($_FILES['new_message_imageattach']['type'],$allowed) ) {
                                        	$html  .= '<div class="msg-upload-img"> <img width="100" height="100" src="'.base_url().'uploads/message/'.$prof_img.'"></div>';
										 }
										
                                      $html  .= '</div>';  
									  
						}else{
							$err2++;
						}
 				  }
			} 
 			echo json_encode(array('sts'=>$err2,'content'=>$html));
		} 
    
	}
	function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
	
}
?>