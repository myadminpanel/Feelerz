<?php 
class Category extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'category';
        $this->load->model('admin_panel_model');
    }
    public function index()
    {    
        $this->data['page'] = 'index';      
        $this->data['list'] = $this->admin_panel_model->all_category();        
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
    $temp_height = $height;
    $temp_width = ( int ) ($height * $source_aspect_ratio);
} else {
    $temp_width = $width;
    $temp_height = ( int ) ($width / $source_aspect_ratio);
}
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
$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
   $image_url =  "uploads/category_images/mini_images/".$filename_without_extension."_".$width."_".$height.".jpg";    
imagejpeg($desired_gdim,$image_url);

return $image_url;
}
    
    public function add_category()
    {
        $this->data['page'] = 'add_category'; 
        $this->data['parent_category'] = $this->admin_panel_model->parent_category();		
        if($this->input->post('form_submit'))
        {

            $data['parent'] = $this->input->post('parent_category');
            $data['name'] = $this->input->post('category_name');
            $data['status'] = 0;     
            


           $cour["file"]=@$this->input->post("image");
      
      $config['upload_path']   = FCPATH.'assets/cat_image'; 
         $config['allowed_types'] = '*'; 
         
         //$config['max_width']     = 1024; 
        // $config['max_height']    = 768;  
         $this->load->library('upload', $config);
    // var_dump($config);
      if ( ! $this->upload->do_upload('image')) {
            // var_dump($this->upload->display_errors());
        $this->session->set_flashdata("alert", strip_tags($this->upload->display_errors()." ".$config['upload_path'])); 
            $this->load->library("user_agent");
           redirect($this->agent->referrer());
      }
      else
      {
        $cour["file"] = @$this->upload->data("file_name");
        $data["category_image"]=$cour["file"];
        if($this->db->insert('categories',$data))
            {
              $data=$this->db->query("SELECT * FROM `categories` ORDER BY `categories`.`CATID` DESC LIMIT 1");
              $data2=$data->row_array();
              $this->db->query("INSERT INTO crasol(item_name, type ,  date ,  item_id ,  status ) VALUES ('".$data2["name"]."','categories','".date("d-m-Y")."','".$data2["CATID"]."','0')");
                $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully Added</div>";
            } 
        $this->session->set_flashdata('message',$message);
        redirect(base_url().'admin/category');      
        }

      }





            
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');      
    }
    
    public function edit_category($category_id)
    {
        $this->data['page'] = 'edit_category';
         $this->data['parent_category'] = $this->admin_panel_model->parent_category();
        $this->data['list'] = $this->admin_panel_model->edit_category($category_id);
        if($this->input->post('form_submit'))
        {
            $data['parent'] = $this->input->post('parent_category');
            $data['name'] = $this->input->post('category_name');
            $data['seo'] = $this->input->post('cat_seo_name');
            $data['details'] = $this->input->post('category_description');
            $data['mtitle'] = $this->input->post('page_title');
            $data['mdesc'] = $this->input->post('category_meta_desc');
            $data['mtags'] = $this->input->post('category_meta_keywords');           
            $this->load->library('common');
			 $data['status'] = $this->input->post('status');   
			 $this->db->where('CATID',$category_id);

       $cour["file"]=@$this->input->post("old_image");
      
      $config['upload_path']   = FCPATH.'assets/cat_image'; 
         $config['allowed_types'] = '*'; 
         
         //$config['max_width']     = 1024; 
        // $config['max_height']    = 768;  
         $this->load->library('upload', $config);
    // var_dump($config);
      if ( ! $this->upload->do_upload('image')) {
            // var_dump($this->upload->display_errors());
        // $this->session->set_flashdata("alert", strip_tags($this->upload->display_errors()." ".$config['upload_path'])); 
        //     $this->load->library("user_agent");
        //    redirect($this->agent->referrer());
      }
      else
      {
        $cour["file"] = @$this->upload->data("file_name");
           } 

            $data["category_image"]=$cour["file"];


           $this->db->where('CATID',$category_id);

            if($this->db->update('categories',$data))
            {

              $this->db->query("UPDATE crasol SET status='".$data['status']."' WHERE type='categories' and item_id='".$category_id."'");
        $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Catagory Successfully updated.</div>";
            }   
      $this->session->set_flashdata('message', $message);
      redirect(base_url().'admin/category');
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }
    
    public function delete_category()
		{
		$id = $this->input->post('tbl_id');
		$this->db->where('CATID',$id);
		if($this->db->delete('categories'))
		{
      $this->db->query("DELETE FROM `crasol` WHERE type='categories' and item_id='".$id."'");
			$message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Catagory Successfully Deleted.</div>";
		echo 1;
		}
		$this->session->set_flashdata('message', $message);
		}
		}
?>