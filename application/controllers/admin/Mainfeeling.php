<?php 
class Mainfeeling extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'mainfeeling';
        $this->load->model('admin_panel_model');
       ob_start();
    }
    public function index()
    {

        $this->data['page']='parent';
        $this->data['list'] = $this->admin_panel_model->get_feeling();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');


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
   
 
      $update=$this->db->query(" UPDATE feeling SET status ='$statusn' WHERE id ='$userid' ");
 
    }
      redirect("admin/mainfeeling");
    
}
    
    
    
    
    public function editfeel()
{
    // var_dump('hii');

    echo  $fid = $this->input->post('feelId');

     $feelname = $this->input->post('feel');
     $emoji = $this->input->post('emo');
     $color_code = $this->input->post('cc');

    //  $country = $this->input->post('country');
     
    //  var_dump($username);

    $update_userdata=array('name'=>$feelname, 'emojie'=>$emoji, 'color_code'=>$color_code); 
    // $status = $this->input->get("status");
    // print_r($update_countrydata);
    // die;
    $update=$this->admin_panel_model->updateFeel($update_userdata,$fid);
    if($update){
      $messag="Feeling Edited Successfully";
      $this->session->set_flashdata("succe",$messag);
    }else{
        $messag='Feeling Already Exist.';
    $this->session->set_flashdata("warni",$messag);
    }
    redirect("admin/mainfeeling");
  
 }
 
 
 
 
 
  public function add_feeling()
{
    
$data = array(
// 'id' => $this->input->post('id'),
'name' => $this->input->post('feeling'),
'color_code' => $this->input->post('cc'),
'emojie' => $this->input->post('emo'),
// 'Status' => $this->input->post('status'),
// 'Student_Address' => $this->input->post('daddress')
);
// var_dump($data);
//Transfering data to Model
$res=$this->admin_panel_model->feeling_insert($data);
if($res)
{
    $message="Feeling Added successfully";
$this->session->set_flashdata("success",$message);
    
}
else
{
    $message='Feeling already exist.';
    $this->session->set_flashdata("warning",$message);
}

// $data['message'] = 'Data Inserted Successfully';
//Loading View
// $this->load->view('county', $data);
redirect("admin/mainfeeling");
}
 
 

}
?>