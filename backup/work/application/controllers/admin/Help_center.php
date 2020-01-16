<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Help_center extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'help_center';
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

    public function category()
    {



    	$this->data['list'] = $this->admin_panel_model->get_faqs_category(); 


    	$this->data['page'] = 'view_cat/view'; 
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');  
    }

    public function add_category()
    {


    	    if($this->input->post('form_submit'))
        {
            $data['name'] = $this->input->post('category_name');
            $data['status'] = 0;     
            
           $table_name='faqs_categories';
         $check_name=$this->admin_panel_model->check_category_name_dsp($data['name'],$table_name);
          // $check_name=false;
     if($check_name)
     {
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
        if($this->db->insert('faqs_categories',$data))
            {
              
                $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully Added</div>";
            } 
           $this->session->set_flashdata('message',$message);
           redirect(base_url().'FAQ/category');      
        }
     }
        else
        { 
               $this->session->set_flashdata("alert", "Name Is already exit.");
               $this->load->library("user_agent");
               redirect($this->agent->referrer());
 
        }    

      }
       $this->data['page'] = 'view_cat/add_category'; 
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');	
    }

  public function edit_category($category_id)
  {
  	 $this->data['page'] = 'view_cat/edit_category';
         // $this->data['parent_category'] = $this->admin_panel_model->parent_category();
        $this->data['list'] = $this->admin_panel_model->edit_category_faqs_cat($category_id);
        if($this->input->post('form_submit'))
        {
     
            $data['name'] = $this->input->post('category_name');
            // $data['seo'] = $this->input->post('cat_seo_name');
            // $data['details'] = $this->input->post('category_description');
            // $data['mtitle'] = $this->input->post('page_title');
            // $data['mdesc'] = $this->input->post('category_meta_desc');
            // $data['mtags'] = $this->input->post('category_meta_keywords');  
$table_name='faqs_categories';
   $check_name=$this->admin_panel_model->check_category_name_for_update_dsp($data['name'],$table_name,$category_id); 
    if($check_name)
    {
         $this->load->library('common');
       $data['status'] = $this->input->post('status');   
       $this->db->where('CATID',$category_id);

       $cour["file"]=@$this->input->post("old_image");
      
      $config['upload_path']   = FCPATH.'assets/cat_image'; 
         $config['allowed_types'] = '*'; 
         
        
         $this->load->library('upload', $config);

      if ( ! $this->upload->do_upload('image')) {
      
      }
      else
      {
        $cour["file"] = @$this->upload->data("file_name");
           } 

            $data["category_image"]=$cour["file"];


           $this->db->where('id',$category_id);

          $res=$this->db->query(" UPDATE faqs_categories SET status='".$data['status']."',name='".$data['name']."',category_image='".$data["category_image"]."' WHERE  id='".$category_id."'");
// var_dump($this->db->last_query());
            if($res);
            {

              // $this->db->query("UPDATE crasol SET status='".$data['status']."' WHERE type='categories' and item_id='".$category_id."'");
        $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Catagory Successfully updated.</div>";
            }   
      $this->session->set_flashdata('message', $message);
      redirect(base_url().'FAQ/category');
    }
    else
    {
       $this->session->set_flashdata("alert", "Name Is already exit.");
               $this->load->library("user_agent");
               redirect($this->agent->referrer());
    }
           
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
  }  

 public function delete_cat()
 {
 	$id=$this->input->post("id");
 	$this->db->query("delete from faqs_categories where id='".$id."'");
 } 


public function content()
{


   $this->data['list'] =$this->admin_panel_model->get_content_for_help_center();
   // var_dump($this->db->last_query());
   $this->data['page'] = 'content';
   $this->load->vars($this->data);
   $this->load->view($this->data['theme'].'/template');

}

public function add_new_content()
{
  if($this->input->post('form_submit'))
        {
          if(!$this->input->post('categorys'))
          {
                $this->session->set_flashdata("alert","Select atlest one categorys.");
                redirect(base_url().'admin/Help_center/add_new_content');
          }
          else
          {
            if(!$this->input->post('page_desc'))
            {
                $this->session->set_flashdata("alert","Enter diceription.");
                redirect(base_url().'admin/Help_center/add_new_content');
            }
            else
            {
               $data["categorys"]=implode("*#*",$this->input->post('categorys'));
             $data['name'] = $this->input->post('name');
             $data['page_content'] = $this->input->post('page_desc');
            $data['status'] = 0;     
            
          
        if($this->db->insert('help_center_content',$data))
            {
              
                $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully Added</div>";
            } 
        $this->session->set_flashdata('message',$message);
        redirect(base_url().'FAQ/content');  
            }
               
        
          }
           

      }

      $this->data['category'] = $this->admin_panel_model->get_cat_for_content(); 
       $this->data['page'] = 'add_new_content'; 
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
}

public function edit_content($id)
{
   $this->data['page'] = 'edti_content';
         // $this->data['parent_category'] = $this->admin_panel_model->parent_category();
        $this->data['list'] = $this->admin_panel_model->edit_content_faqs_cat($id);
        $this->data['category'] = $this->admin_panel_model->get_cat_for_content(); 
          if($this->input->post('form_submit'))
        {
          if(!$this->input->post('categorys'))
          {
                $this->session->set_flashdata("alert","Select atlest one categorys.");
                redirect(base_url().'admin/Help_center/edit_content/'.$id);
          }
          else
          {
            if(!$this->input->post('page_desc'))
            {
                $this->session->set_flashdata("alert","Enter diceription.");
                redirect(base_url().'admin/Help_center/edit_content/'.$id);
            }
            else
            {
               $data["categorys"]=implode("*#*",$this->input->post('categorys'));
             $data['name'] = $this->input->post('name');
             $data['page_content'] = $this->input->post('page_desc');
            $data['status'] = $this->input->post('status');     
            
          
        if($this->db->query("UPDATE help_center_content SET name='".$data['name']."',categorys='".$data["categorys"]."',page_content='".$data['page_content']."',status='".$data['status']."' WHERE id='".$id."'"))
            {
              
                $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully Added</div>";
            } 
        $this->session->set_flashdata('message',$message);
        redirect(base_url().'admin/Help_center/content');  
            }
               
        
          }
           

      }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
}
public function delete_help_content()
{
  $id=$this->input->post("id");
  $this->db->query("delete from help_center_content where id='".$id."'");
}

public function faq_set_operation()
{
  $ids=$this->input->post("id");
   
     $operation=$this->input->post("operation");
       $this->admin_panel_model->help_center_status_update($ids,$operation);
}

} ?>    