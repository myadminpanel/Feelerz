<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paypal_settings extends CI_Controller {
    public $data;
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'paypal_settings';       
        $this->load->model('admin_panel_model');
    }
    
  
    public function index()
    {
		 $id=1;
        if($this->input->post('form_submit'))
        {
           $data['sandbox_email'] = $this->input->post('sandbox_email');
           $data['sandbox_password'] = $this->input->post('sandbox_password');
           $data['email'] = $this->input->post('email');
           $data['password'] = $this->input->post('password');
           $data['developement'] = $this->input->post('developement');
           $query = $this->db->query("SELECT * FROM paypal_details");
            $result = $query->row_array();
            if (!empty($result)) {

            $this->db->where('id',$id);
            $this->db->update('paypal_details',$data);
            }else{
             $this->db->insert('paypal_details',$data);
            }
		   $message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Paypal content successfully edited.</div>';
       
		$this->session->set_flashdata('message',$message);
		redirect(base_url().'admin/paypal_settings/');
		}
        $this->data['list'] =  $this->admin_panel_model->edit_paypal_settings($id);
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }
}
    ?>