<?php 
class Userprofile extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'prof';
        $this->load->model('admin_panel_model');
     ob_start();
    }
    public function index()
    {
        // echo 'true';
$id=$this->uri->segment(4);
// var_dump($id);
        $this->data['page']='user';
        // $this->data['list']= $this->admin_panel_model->get_user($id);
        // $list1 =$this->data['list'];
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');


    }
}
?>