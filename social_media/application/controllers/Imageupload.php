<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Imageupload extends CI_Controller {


   public function __construct(){
   	  parent::__construct();
   }
   

   public function data_submit()
   {
   	  var_dump($this->input->post());

	  $config['upload_path']   = FCPATH.'assets/images'; 
         $config['allowed_types'] = '*'; 


         
		 //$config['max_width']     = 1024; 
        // $config['max_height']    = 768;  
         // $this->load->library("upload",$config);
         // if(!$this->upload->do_upload("image"))
         // {
         // 	var_dump($this->upload->display_errors());
         // }
         // else
         // {
         // 	var_dump("True");
         // }

     $files = $_FILES;
     $this->load->library("upload",$config);
     $cpt = count($_FILES['image']['name']);
     $file_names=[];
    for($i=0; $i<$cpt; $i++)
    {          

    array_push($file_names, $config['upload_path'].$files['image']['name'][$i]); 
        $_FILES['image']['name']= $files['image']['name'][$i];
        $_FILES['image']['type']= $files['image']['type'][$i];
        $_FILES['image']['tmp_name']= $files['image']['tmp_name'][$i];
        $_FILES['image']['error']= $files['image']['error'][$i];
        $_FILES['image']['size']= $files['image']['size'][$i];    
         
             $this->upload->initialize($config);
        // $this->upload->do_upload("image");
        var_dump($this->upload->do_upload("image"));
    }
     $this->load->library("zip");
     $this->zip->read_file($file_names,TRUE);
     $zip_file=$this->zip->get_zip();
     $this->upload->do_upload($zip_file);
   }

    public function index()
  {
    
//var_dump("Hello Deepak");
  	 $this->load->view("form/index");
  }

public function index2()
{
  var_dump("This is function2");
}


}


?>