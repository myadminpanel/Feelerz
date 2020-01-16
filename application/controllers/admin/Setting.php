<?php 
class Setting extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'setting';
        $this->load->model('admin_panel_model');
        $this->load->library('form_validation');
        
    }
    public function index()
    {

        $this->data['page']='index';
        // $this->data['list'] = $this->admin_panel_model->get_password();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
        

    }  
    
    
    
public function change()
{
        
    $this->form_validation->set_rules('oldp','old password','required');
    $this->form_validation->set_rules('newp','new password','required'); 
    $this->form_validation->set_rules('conp','confirm password','required'); 
    if($this->form_validation->run())
    {
    
        $old_pass=$this->input->post('oldp');
        $new_pass=$this->input->post('newp');
        $con_pass=$this->input->post('conp');  
       
       
        
        $userid = '1';
        $pass = $this->admin_panel_model->getcurrentpassword($userid);
        if($new_pass == $con_pass){
            
        }else{
            // echo "confirm password doesn't match!";
              $warning="confirm password doesn't match!";
$this->session->set_flashdata("warning",$warning);
        }
        if($pass->password == md5($old_pass)) {
             if($this->admin_panel_model->updatepassword(md5($new_pass), $userid))
        {
            // $this->session->set_flashdata('message', 'password updated successfully.');
            // $this->session->keep_flashdata('message');
// var_dump($this->session->flashdata('message'));
            //  echo "password updated successfully";
        //   echo '<script>alert("password updated successfully.");</script>';
            //   redirect('admin/setting');
            $message='password updated  successfully.';

					 $this->session->set_flashdata('message',$message);
				// 	 redirect('admin/setting');
            //  ?>
            // <script>
            // window.location.href=<?php echo  base_url(); ?>;
            //     alert("fsdsfsad");
            // </script>
            // <?php
            
        }
        else{
            // echo "failed to update";
            
            //  ?>
            // <script>
            //       window.location.href=<?php echo  base_url(); ?>;
            //     alert("fsdsfsad");
            // </script>
            // <?php
            
        }
    } else{
            // echo "old password is not correct";
             $warni="old password is not correct!";
$this->session->set_flashdata("warni",$warni);
            //  ?>
            // <script>
            //      window.location.href=<?php echo  base_url(); ?>;
            //     alert("fsdsfsad");
            // </script>
            // <?php
            
        }
    }
    else{
        // echo "plz enter the correct values";
         $warn="please enter correct values!";
$this->session->set_flashdata("warn",$warn);
        //  ?>
        //     <script>
        //     alert("fsdsfsad");
        //         // window.location.href=<?php echo  base_url(); ?>;
        //         // window.location=BASE_URL+"admin/setting";
        //         // header("location:../../admin/setting");
        //          redirect ("admin/setting");
                
        //     </script>
        //     <?php
            
    }
  redirect ("admin/setting");
}

//   public function upload(){
      
//       $data['title'] = "fileupload";
//       $config['upload_path'] = './uploads/';
//       $config['allowed_types'] = 'png|jpg|jpeg|gif';
//       $config['max_size'] = '100';
//       $config['max_width'] = 1024;
//       $config['max_height'] = 768; 
      
//       $this->load->library('upload', $config);
      
//       if(! $this->upload->do_upload('upload'))
//       {
//           if(isset($_FILES['upload'])){
//           $data['error'] = $this->upload->display_errors();
          
//           $this->load->view('includes/header', $data);
//         //   $this->load->view('setting/index', $data);
//           $this->load->view('includes/sidebar', $data);
//       }
//       else
//       {
//           $data = array('upload_data'=>$this->upload->data());
//           $this->load->view('upload_success', $data);
//       }
//   }


 
 
 
 
 
 
//   } 
  
  public function upload(){
      
    //   $id->$this->session->userdata(SESSION_USER_ID);
        // $id = $_POST['update_id'];
        $name1=$_FILES['img']['name'];
        $type1=$_FILES['img']['type'];
        $error1=$_FILES['img']['error'];
        $size1=$_FILES['img']['size'];
        $temp=$_FILES['img']['tmp_name'];

        $ImgName1=Null;
        $fileArr1=explode('.',$name1);
        $ImgName1=date('YmdisM')."."."$fileArr1[0]"; 
        // $ImgName1 =round(microtime(true) * 1000).".".$fileArr1["0"];
        // var_dump($ImgName1);
        move_uploaded_file($temp,"uploads/".$ImgName1);
  
     $set_result = $this->db->query("UPDATE setting SET profilepic= '".$ImgName1."' WHERE id = '1'");
if($set_result){
      $me="Profile Picture Updated Successfully";
      $this->session->set_flashdata("su",$me);
    }else{
        $me='Failed to update.';
    $this->session->set_flashdata("wa",$messag);
    }
    
// $this->db->where('setting', $data);
//  $update=$this->admin_panel_model->updateimage($data,$images);
//  $userid = '2';
//         $pic = $this->admin_panel_model->updateimage($userid);
 
redirect ("admin/setting");
       
  }
}
    ?>