<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'blog';
          $this->load->model('admin_blog_model');   
	 
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



    	$this->data['list'] = $this->admin_blog_model->get_blog_category(); 


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
        if($this->db->insert('blog_categories',$data))
            {
              
                $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully Added</div>";
            } 
        $this->session->set_flashdata('message',$message);
        redirect(base_url().'admin/blog/category');      
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
        $this->data['list'] = $this->admin_blog_model->edit_category_blog_cat($category_id);
        if($this->input->post('form_submit'))
        {
     
            $data['name'] = $this->input->post('category_name');
            // $data['seo'] = $this->input->post('cat_seo_name');
            // $data['details'] = $this->input->post('category_description');
            // $data['mtitle'] = $this->input->post('page_title');
            // $data['mdesc'] = $this->input->post('category_meta_desc');
            // $data['mtags'] = $this->input->post('category_meta_keywords');           
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

          $res=$this->db->query(" UPDATE blog_categories SET status='".$data['status']."',name='".$data['name']."',category_image='".$data["category_image"]."' WHERE  id='".$category_id."'");
// var_dump($this->db->last_query());
            if($res);
            {

              // $this->db->query("UPDATE crasol SET status='".$data['status']."' WHERE type='categories' and item_id='".$category_id."'");
        $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Catagory Successfully updated.</div>";
            }   
      $this->session->set_flashdata('message', $message);
      redirect(base_url().'admin/blog/category');
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
  }  

 public function delete_cat()
 {
 	$id=$this->input->post("id");
 	$this->db->query("delete from blog_categories where id='".$id."'");
 } 


public function our_blog()
{


   $this->data['list'] =$this->admin_blog_model->get_content_for_Blog();
   // var_dump($this->db->last_query());
   $this->data['page'] = 'blog';
   $this->load->vars($this->data);
   $this->load->view($this->data['theme'].'/template');

}

public function add_new_blog()
{
  if($this->input->post('form_submit'))
        {
          // var_dump($this->input->post());
          if(!$this->input->post('categorys'))
          {
                $this->session->set_flashdata("alert","Select atlest one categorys.");
                redirect(base_url().'admin/blog/add_new_blog');
          }
          else
          {
            if(!$this->input->post('page_desc'))
            {
                $this->session->set_flashdata("alert","Enter diceription.");
                redirect(base_url().'admin/blog/add_new_blog');
            }
            else
            {
                   
                       $cour["file"]=@$this->input->post("blogfetured");
                  
                  $config['upload_path']   = FCPATH.'assets/cat_image'; 
                     $config['allowed_types'] = '*'; 
                     
                     //$config['max_width']     = 1024; 
                    // $config['max_height']    = 768;  
                     $this->load->library('upload', $config);
                // var_dump($config);
                  if ( ! $this->upload->do_upload('blogfetured')) {
                        // var_dump($this->upload->display_errors());
                    $this->session->set_flashdata("alert", strip_tags($this->upload->display_errors()." ".$config['upload_path'])); 
                        $this->load->library("user_agent");
                       redirect($this->agent->referrer());
                  }
                  else
                  {
                    $cour["file"] = @$this->upload->data("file_name");

                    $data["image"]=$cour["file"];
                    $data["categorys"]=implode("*#*",$this->input->post('categorys'));
                    $data['title'] = $this->input->post('name');
                    $data['content'] = $this->input->post('page_desc');
                    $data['status'] = 0;     
                    $data['date'] = date("d-m-Y");     
            
          
                    if($this->db->insert('our_blog',$data))
                        {
                          
                            $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully Added</div>";
                        } 
                    $this->session->set_flashdata('message',$message);
                    redirect(base_url().'admin/blog/our_blog'); 

                 }




               
            }
               
        
          }
           

      }

      $this->data['category'] = $this->admin_blog_model->get_cat_for_blog(); 
       $this->data['page'] = 'add_new_blog'; 
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
}



public function edit_content($id)
{
   $this->data['page'] = 'edti_content';
         // $this->data['parent_category'] = $this->admin_panel_model->parent_category();
        $this->data['list'] = $this->admin_blog_model->edit_content_blog_cat($id);
        $this->data['category'] = $this->admin_blog_model->get_cat_for_content(); 
          if($this->input->post('form_submit'))
        {
          if(!$this->input->post('categorys'))
          {
                $this->session->set_flashdata("alert","Select atlest one categorys.");
                redirect(base_url().'admin/blog/edit_content/'.$id);
          }
          else
          {
            if(!$this->input->post('page_desc'))
            {
                $this->session->set_flashdata("alert","Enter diceription.");
                redirect(base_url().'admin/blog/edit_content/'.$id);
            }
            else
            {






                    
              $cour["file"]=@$this->input->post("blogfetured_old");
                  
                  $config['upload_path']   = FCPATH.'assets/cat_image'; 
                     $config['allowed_types'] = '*'; 
                     
                     //$config['max_width']     = 1024; 
                    // $config['max_height']    = 768;  
                     $this->load->library('upload', $config);
                // var_dump($config);
                  if ( ! $this->upload->do_upload('blogfetured')) {
                        // var_dump($this->upload->display_errors());
                    // $this->session->set_flashdata("alert", strip_tags($this->upload->display_errors()." ".$config['upload_path'])); 
                    //     $this->load->library("user_agent");
                    //    redirect($this->agent->referrer());
                  }
                  else
                  {
                    $cour["file"] = @$this->upload->data("file_name");

                 }




                    $data["image"]=$cour["file"];
                    $data["categorys"]=implode("*#*",$this->input->post('categorys'));
                    $data['title'] = $this->input->post('name');
                    $data['content'] = $this->input->post('page_desc');
                    $data['status'] = $this->input->post('status');     
                    $data['date'] = date("d-m-Y");
          
        if($this->db->query("UPDATE our_blog SET title='".$data['title']."',categorys='".$data["categorys"]."',image='".$data["image"]."' ,content='".$data['content']."',date='".$data['date']."',status='".$data['status']."' WHERE id='".$id."'"))
            {
              
                $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Category Successfully Added</div>";
            } 
        $this->session->set_flashdata('message',$message);
        redirect(base_url().'admin/blog/our_blog');  
            }
               
        
          }
           

      }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
}
public function delete_blog()
{
  $id=$this->input->post("id");
  $this->db->query("delete from our_blog where id='".$id."'");
}

} ?>    