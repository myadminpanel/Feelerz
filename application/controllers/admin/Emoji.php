<?php 
class Emoji extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'emoji';
        $this->load->model('admin_panel_model');
     ob_start();
    }
    
    public function index()
    {

        $this->data['page']='emoji';
        //$this->data['list'] = $this->admin_panel_model->get_emoji();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
        
        // redirect("admin/emoji/getemodetails");
 }




public function getemodetails()
{
    
     $this->data['page']='emoji';
     $this->load->model('admin_panel_model');
     $this->data['list']=$this->admin_panel_model->get_subfeeling();
    
     $this->load->vars($this->data);
     $this->load->view($this->data['theme'].'/template');
        
    
}

// public function get_data_for_insert()
// {
//     //var_dump($this->input->post());
// $this->input->post('emojiicon');

// $imagename=$_FILES['emojiicon']['name'];
//   $data= array(

//         'emoji_name' => $this->input->post('emojiname'),
//          'emoji_category' => $this->input->post('select2'),
//          'emoji_icon' =>$imagename 

// );
// move_uploaded_file($_FILES['emojiicon']['tmp_name'], 'uploads/'.$imagename);
    
//     $this->admin_panel_model->add_emoji($data);
//      if($img_upload){
//       $data['message'] = 'Emoji Inserted Successfully';  
//   }else{
//      $data['message'] = 'Not Inserted UnSuccessfully';
//   }
    

//      redirect("admin/emoji");

//  }
 
 
 public function add_subfeeling()
{
    // var_dump('hii');
$data = array(
// 'id' => $this->input->post('id'),
'name' => $this->input->post('subfeel'),
'parrent' => $this->input->post('cat'),
'color_code' => $this->input->post('cc'),
'emojie' => $this->input->post('emo'),
'status' => "0",
'reating' => "0"

// 'Status' => $this->input->post('status'),
// 'Student_Address' => $this->input->post('daddress')
);
// var_dump($data);
//Transfering data to Model
$smile=$this->admin_panel_model->subfeeling_insert($data);
if($smile)
{
    $message="Sub-Feeling inserted successfully";
$this->session->set_flashdata("success",$message);
    
}
else
{
    $message='sub-Feeling already exist.';
    $this->session->set_flashdata("warning",$message);
}

redirect("admin/emoji/getemodetails");
}
 
 
   public function editsubfeel()
{
    // var_dump('hii');
    // echo 'true';

     $ffid = $this->input->post('subfeelId');
    // var_dump($ffid);

    $subfeelname = $this->input->post('subfeel');
    
// var_dump($subfeelname);
      $parent = $this->input->post('patcat');
      
       $emoji = $this->input->post('emo');
     $color_code = $this->input->post('cc');
     
    //  var_dump($parent);

    $update_userdata=array('name'=>$subfeelname,'parrent' => $parent,'emojie'=>$emoji, 'color_code'=>$color_code); 
    // $status = $this->input->get("status");
    // print_r($update_countrydata);
    // // die;
    $update=$this->admin_panel_model->updatesubFeel($update_userdata,$ffid);
    if($update){
      $update="Feeling Edited Successfully";
      $this->session->set_flashdata("succe",$update);
    }else{
        $update='Feeling Already Exist.';
    $this->session->set_flashdata("warni",$update);
    }
    redirect(base_url()."admin/emoji/getemodetails");
  
 }

 
 public function delete_subfeel(){
 
     
      $ids=$this->input->post("yourArray");
    $this->admin_panel_model->delete_sfeel($ids);
    
    //  redirect(base_url()."admin/emoji/getemodetails");
 }

 public function updatestatu()
 {
    
 
     echo $status=$this->input->post("status");
     
     if($status==0){
        $statusn=1; 
     }else{
         $statusn=0;  
     }
      $idArr=$this->input->post("ckval1");
      

 for($i=0;$i<count($idArr); $i++)
     {
      $userid=$idArr[$i];
   
 
      $update=$this->db->query(" UPDATE feeling SET status ='".$statusn."' WHERE id ='".$userid."' ");
 
    }
      redirect("admin/emoji/getemodetails");
    
}

}

?>