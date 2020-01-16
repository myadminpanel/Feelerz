<?php 
class Client extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'client';
        $this->load->model('admin_panel_model');
    }
    public function index()
    {
        $this->data['page'] = 'index';
        $this->data['list'] = $this->admin_panel_model->get_client_list();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
        
    }
    
      public function image_resize($width=0,$height=0,$image_url,$filename)
{          
        

$source_path = base_url().$image_url;


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
$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
   $image_url =  "uploads/client_image/".$filename_without_extension."_".$width."_".$height.".jpg";    
imagejpeg($desired_gdim,$image_url);

return $image_url;

/*
 * Add clean-up code here
 */
    
}

    
    public function create()
    {   
       
        if($this->input->post('form_submit'))
        {
             if (isset($_FILES['client_image']['name']) && !empty($_FILES['client_image']['name'])) {                  
            $uploaded_file_name = $_FILES['client_image']['name'];               
            $uploaded_file_name_arr = explode('.', $uploaded_file_name);
            $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
            if(!empty($filename))
            {
                $filename = time().$filename;
            }
            $this->load->library('common');
            $upload_sts = $this->common->global_file_upload('uploads/client_image/', 'client_image',$filename);        
            if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {    
            $uploaded_file_name = $upload_sts['data']['file_name'];    
            }
            if (!empty($uploaded_file_name)) {             
            $image_url='uploads/client_image/'.$uploaded_file_name;    
            $data['client_raw_image'] = $image_url;
            $data['client_cropped_image'] = $this->image_resize(170,90,$image_url,$filename);     
            }
            }
        $data['client_name'] = $this->input->post('client_name');
        $data['status'] = $this->input->post('status'); 
    
        if($this->db->insert('client',$data))
        {
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Client added successfully.</div>';
			
        }
		   $this->session->set_flashdata('message',$message);
            redirect(base_url().'admin/client');
        }
        $this->data['page']='create';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }
    
    public function edit($id) 
    {
         if($this->input->post('form_submit'))
        {
             if (isset($_FILES['client_image']['name']) && !empty($_FILES['client_image']['name'])) {                  
            $uploaded_file_name = $_FILES['client_image']['name'];               
            $uploaded_file_name_arr = explode('.', $uploaded_file_name);
            $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
            if(!empty($filename))
            {
                $filename = time().$filename;
            }
            $this->load->library('common');
            $upload_sts = $this->common->global_file_upload('uploads/client_image/', 'client_image',$filename);        
            if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {    
            $uploaded_file_name = $upload_sts['data']['file_name'];    
            }
            if (!empty($uploaded_file_name)) {             
            $image_url='uploads/client_image/'.$uploaded_file_name;    
            $data['client_raw_image'] = $image_url;
            $data['client_cropped_image'] = $this->image_resize(170,90,$image_url,$filename);     
            }
            }
        $data['client_name'] = $this->input->post('client_name');
        $data['status'] = $this->input->post('status'); 
        $this->db->where('id',$id);
        if($this->db->update('client',$data))
        {
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Edited successfully.</div>';
			
        }
		   $this->session->set_flashdata('message',$message);
            redirect(base_url().'admin/client');
        }
        $this->data['page']='edit';
        $this->data['list'] = $this->admin_panel_model->edit_client_list($id);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
        
    }
    public function delete()
    {
        $id = $this->input->post('tbl_id');
        $this->db->where('id',$id);
        if($this->db->delete('client'))
        {
			$message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Delete successfully.</div>";
			
            echo 1;
        }
            $this->session->set_flashdata('message',$message);    
    }
}
?>