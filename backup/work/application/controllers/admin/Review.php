<?php 
class Review extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'review';
        $this->load->model('admin_panel_model');  
    }


public function remove_report_data()
{
    $ids=$this->input->post("id");
    for($j=0; $j<count($ids); $j++)
    {
        $this->db->where(array("id"=>$ids[$j]));
        $this->db->delete("admin_report");
    }
}

public function get_one_review()
{
    $id=$this->input->post("id");
    $data=$this->db->query("select message from admin_report where id='".$id."'")->row_array();
    echo @$data["message"];
}

public function report()
{
        $this->data['list'] = $this->admin_panel_model->get_report();
        $this->data['page'] = 'report_view';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
}

public function get_new_enquerys()
{
    $data=$this->db->query("select count(id) from enquerys where notification_status='0'");
    // var_dump($this->db->last_query());
    $data2=$data->row_array();
    if(@$data2["count(id)"])
    {
      echo '<span class="label label-success">'.@$data2["count(id)"].'</span>';
    }
    else
    {
        echo '';
    }
   
}

public function delete_enquerys(){
    $ids=$this->input->post("id");
    for($i=0; $i<count($ids); $i++)
    {
        $this->db->query("delete from enquerys where id='".$ids[$i]."'");
    }

}

public function review_set_operation()
{
    $ids=$this->input->post("id");
    $operation=$this->input->post("operation");
    $this->admin_panel_model->set_operation_for_review($ids,$operation);
}


    public function index($offset=0)
    {
        
        $this->data['list'] = $this->admin_panel_model->get_review();
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }    
    public function edit($review_id)
    {
        $review_id=$this->uri->segment(4);
        $this->data['page'] = 'edit_review';
        $this->data['list'] = $this->admin_panel_model->edit_review($review_id);  
		if($this->input->post('form_submit'))
        {  
	     
            $data['status'] = $this->input->post('status');
            $data['comment'] = $this->input->post('review');
            $this->db->where('id' ,$review_id);
            if($this->db->update('feedback',$data))
            {
                redirect(base_url().'admin/review');
            }
        }        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }
    public function delete()
    {
        $id = $this->input->post('tbl_id');
        $this->db->where('id',$id);
        if($this->db->delete('feedback'))
        {
            echo 1;
        }
        
    }
}
?>