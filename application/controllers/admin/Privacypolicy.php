<?php 
class Privacypolicy extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'privacy';
        $this->load->model('admin_panel_model');
     
    }
    public function index()
    {

        $this->data['page']='policy';
        $this->data['list'] = $this->admin_panel_model->get_policy();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');


    }
    
    
//     public function add_policy()
// {
    
// $data = array(
// // 'id' => $this->input->post('id'),
// 'privacy_policy_content' => $this->input->post('policy'),
// // 'Status' => $this->input->post('status'),
// // 'Student_Address' => $this->input->post('daddress')
// );
// // var_dump($data);
// //Transfering data to Model
// $this->admin_panel_model->policy_insert($data);
// $data['message'] = 'Data Inserted Successfully';
// //Loading View
// // $this->load->view('county', $data);
// redirect("admin/privacypolicy");
// }
    
   public function update_policy()
{

    $id = $this->input->post('policyId');
     $countryname = $this->input->post('policyName');
    

    $data=array('privacy_policy_content'=>$countryname ); 
    // $status = $this->input->get("status");
    // print_r($update_countrydata);
    // die;
    $update=$this->admin_panel_model->updatePolicy($data,$id);
    if($update==1){
echo "true";
    }else{
        echo"false";
    }
    redirect("admin/privacypolicy");
  


} 
    
    
    
    
}
    ?>