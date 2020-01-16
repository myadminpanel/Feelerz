<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banner extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'banner';
          $this->load->model('admin_panel_model');   
	 
            $this->load->helper('ckeditor'); 
 		// Array with the settings for this instance of CKEditor (you can have more than one)
		$this->data['ckeditor_editor1'] = array
		(
			//id of the textarea being replaced by CKEditor
			'id'   => 'ck_editor_textarea_id',
 			// CKEditor path from the folder on the root folder of CodeIgniter
			'path' => 'assets/js/ckeditor',
 			// optional settings
			'config' => array
			(
				'toolbar' => "Full",
				'filebrowserBrowseUrl'      => base_url().'assets/js/ckfinder/ckfinder.html',
				'filebrowserImageBrowseUrl' => base_url().'assets/js/ckfinder/ckfinder.html?Type=Images',
				'filebrowserFlashBrowseUrl' => base_url().'assets/js/ckfinder/ckfinder.html?Type=Flash',
				'filebrowserUploadUrl'      => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				'filebrowserImageUploadUrl' => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				'filebrowserFlashUploadUrl' => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			)
		);  
    }
public function index()
{
	$this->data['list'] = $this->admin_panel_model->get_banner_image(); 


    	$this->data['page'] = 'index'; 
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');  
}

public function remove_user_for_banner()
{
	$id=$this->input->post("id");
	
	$data["remove_date"]=date("d-M-Y H:i:sa");
	$data["remove_date_in_string"]=strtotime(date("d-M-Y"));
	$data["status"]="1";
	$this->db->where(array("id"=>$id));
	$this->db->update("baners",$data);
	var_dump($this->db->last_query());
}

public function search_user()
{
	$data=$this->input->post("search");
	if($data)
	{
		$result=$this->admin_panel_model->search_user($data);
		$count=count($result);
	}
	else
	{
		$result="";
		$count=0;
	}
	echo json_encode(array("result"=>$result,"count_res"=>$count));
}

public function set_as_banner_image()
{
	$user_id=$this->input->post("user_id");
	$data["user_id"]=$user_id;
	$data["add_date"]=date("d-M-Y H:i:sa");
	$data["add_date_in_string"]=strtotime(date("d-M-Y"));
	$data["status"]="0";

	 $check_data=$this->admin_panel_model->check_baners_info($user_id);
	 if($check_data)
	 {
       $this->db->insert("baners",$data);
         echo "0";
	 }
    else
    {
          echo "1";
    }
// var_dump($this->db->last_query());
}

}

?>