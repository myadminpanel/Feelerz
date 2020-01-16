<?php 
class User extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'user';
        $this->load->model('admin_panel_model');
        ob_start();
    }
    public function index()
    {
        $this->data['page']='index';
        $this->data['list'] = $this->admin_panel_model->get_user();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }


public function delete()
{
    $ids=$this->input->post("ids");
    $this->admin_panel_model->delete_user($ids);

}

// public function activate()
// {   

//     $ids = $this->uri->segment(4);
    
//     // var_dump($ids);
    
//      for($i=0;$i<count($ids); $i++)
//      {
//       $userid=$ids[$i];
//       var_dump($userid);
 
//       $update=$this->db->query(" UPDATE users SET status ='0' WHERE id ='$userid' ");
 
//     }
  
//   // $this->db_user->activate($user_id);
//     // var_dump($id);
//     // redirect("admin/user");

// }

public function deactivate()
{
     // $id = $this->input->get("ids");
// var_dump($id);
    // $deactive = $this->input->get("1");
    // if($deactive == 1){
    // $this->admin_panel_model->deactivate("$id");
   // $this->db_user->activate($user_id);
    // var_dump($id);
    $id = $this->uri->segment(4);
    $this->admin_panel_model->deactivate("$id");




redirect("admin/user");
  }
  
public function updatestatus()
{
    
 
     echo $status=$this->input->post("status");
     
     if($status==0){
        $statusn=1; 
         $otp='DONE';
     }else{
         $statusn=0;  
          $otp='DONE';
     }
      $idArr=$this->input->post("ckval");
      

 for($i=0;$i<count($idArr); $i++)
     {
      $userid=$idArr[$i];
   
 
      $update=$this->db->query(" UPDATE users SET status ='$statusn' , otp = '$otp' WHERE id ='$userid' ");
 
    }
      redirect("admin/user");
    
}












//      public function edit_user($id)
//      {
//          $this->data['page'] = 'edit_user'; 
//          $this->data['list'] = $this->admin_panel_model->edit_user($id);
//          if($this->input->post('form_submit'))
//          {
//              $data['fullname'] = $this->input->post('user_fullname');
//              $data['verified'] = $this->input->post('user_verified');
//              $data['status'] = $this->input->post('status');
//              $this->db->where('USERID',$id);
//              if($this->db->update('members',$data))
//              {
// 				$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">User edited successfully.</div>';
				
//              }
// 			$this->session->set_flashdata('message',$message);
// 			redirect(base_url().'admin/user');
//          }
//          $this->load->vars($this->data);
//          $this->load->view($this->data['theme'].'/template');
//      }


public function edituser()
{
    // var_dump('hii');

    echo  $id = $this->input->post('userId');

     $username = $this->input->post('userName');

     $country = $this->input->post('con');
     
     $gender = $this->input->post('gen');
     
     $dob = $this->input->post('dob');
     $contact = $this->input->post('contact');
     $email = $this->input->post('email');
     
    //  var_dump($username);

    $update_userdata=array('name'=>$username,'country' => $country, 'gender'=>$gender, 'dob'=>$dob,'contact'=>$contact, 'email'=>$email); 
    // $status = $this->input->get("status");
    // print_r($update_countrydata);
    // die;
    var_dump($update_userdata);
    $update=$this->admin_panel_model->updateUser($update_userdata,$id);
    if($update){
      $messag="user edited successfully";
      $this->session->set_flashdata("succe",$messag);
    }else{
        $messag='user already exist.';
    $this->session->set_flashdata("warni",$messag);
    }
    redirect("admin/user");
  
 

}






// public function edituser($id)
// {

//     // $id = $this->input->post('userId');
//     //  $username = $this->input->post('userName');
//     //  $country  = $this->input->post('country');
//     var_dump($id);

//     // $data=array('name'=>$username,'country' => $country  ); 
//     // $status = $this->input->get("status");
//     // print_r($update_countrydata);
//     // die;
//     // var_dump($data);
//     // $update=$this->admin_panel_model->updateUser($data,$id);
// //     if($update==1){
// // echo "true";
// //     }else{
// //         echo"false";
// //     }
//     // redirect("admin/user");
  


// }



















// public function edituser()
// {

//     $id = $this->input->post('userId');
//      $username = $this->input->post('userName');
//     $country = $this->input->post('country');

//     $update_userdata=array('name'=>$username, 'country' =>$country); 
//     $status = $this->input->get("status");
//     // print_r($update_userdata);
//     // die;
//     $update=$this->admin_panel_model->updateUser($update_userdata,$id);
//     if($update==1){
// echo "true";
//     }else{
//         echo"false";
//     }
//     // redirect("admin/user");
  


// }







 
// public function index(){

//     $data = array();
//     if($this->input->post('bulk_delete_submit')){

//         $id = $this->input->post('same');
//         if(!empty($id)){


//             $delete = $this->users->delete($id);

//             if($delete){


//                 $data['statusMsg'] = 'deleted successfully';
//                 }
//                 else
//                     $data['statusMsg'] = 'please try again';
//         }
//     }

// }






}
?>