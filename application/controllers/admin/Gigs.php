<?php 

class Gigs extends CI_Controller{

    public function __construct() {

        parent::__construct();

        $this->data['theme'] = 'admin';

        $this->data['module'] = 'gigs';
        $this->load->helper('currency');
        $this->load->model('admin_panel_model');  

		$this->data['gig_price'] = $this->admin_panel_model->gig_price();
        $this->load->helper('favourites');
        $this->load->helper('currency');


    }

    public function index ($start=0)

    {	 

		$this->load->library('pagination');

        $config['base_url'] =  base_url("admin/gigs/");

        $config['total_rows'] = $this->db->count_all('sell_gigs');

		$config['uri_segment'] = 3 ;

        $config['per_page'] = 15;



        $config['full_tag_open'] = '<ul class="pagination">';

        $config['full_tag_close'] = '</ul>';



        $config['first_link'] = 'First';

        $config['first_tag_open'] = '<li>';

        $config['first_tag_close'] = '</li>';



        $config['prev_link'] = '&laquo;';

        $config['prev_tag_open'] = '<li>';

        $config['prev_tag_close'] = '</li>';



        $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';



        $config['next_link'] = '&raquo;';

        $config['next_tag_open'] = '<li>';

        $config['next_tag_close'] = '</li>';



        $config['last_link'] = 'Last';

        $config['last_tag_open'] = '<li>';

        $config['last_tag_close'] = '</li>';



        $this->pagination->initialize($config);

        $this->data['page'] = 'index';

        $this->data['links'] = $this->pagination->create_links();

		$start = (int)$this->uri->segment(3);

        $this->data['list'] = $this->admin_panel_model->all_gigs(1,$start,$config['per_page']);                 

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'] . '/template');		 

    }

    public function add_gigs()

    {

        $this->data['page'] = 'add_gigs';

        $this->data['parent_category'] = $this->admin_panel_model->all_sub_category();

        if($this->input->post('form_submit'))

        {

            $data['category_belongs'] = $this->input->post('parent_category');

            $data['gig_description'] = $this->input->post('default_gigs');

            $data['status'] = $this->input->post('status');

            if($this->db->insert('default_extra_gigs',$data))

            {

                redirect(base_url().'admin/gigs');

            }

        }

        $this->load->vars($this->data);

        $this->load->view( $this->data['theme'].'/template');

    }

    public function edit_gigs($gig_id)

    {

        $this->data['page'] = 'edit_gigs';

        $this->data['list'] = $this->admin_panel_model->edit_gigs($gig_id);

         if($this->input->post('form_submit'))

        {

            $data['category_belongs'] = $this->input->post('parent_category');

            $data['gig_description'] = $this->input->post('default_gigs');

            $data['status'] = $this->input->post('status');

            $this->db->where('default_gig_id',$gig_id);

            if($this->db->update('default_extra_gigs',$data))

            {

                redirect(base_url().'admin/gigs');

            }

        }        

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'/template');        

    }

     public function admin_delete_gigs(){

        

        if($this->input->post('id')){

            $id = $this->input->post('id');

            $result = 1;

            $this->session->set_flashdata('message',"The Gigs remove faild");

            if(!empty($id)){

                $this->db->where('gigs_id', $id);

               $count =  $this->db->count_all_results('payments'); 

               if($count==0){

                  $this->db->where('id', $id);

                  $this->db->delete('sell_gigs');

                  $this->session->set_flashdata('message','The Gigs has been removed...');

                  $result = 1;

               }else{

                  $this->session->set_flashdata('message',"The Gigs has been purchased so we can't remove...");

                  $result = 2;

               }

            }

            echo $result;

            die();

        }

    }

    

    public function delete_gigs()

    {

        $id = $this->input->post('tbl_id');

        $this->db->where('default_gig_id',$id);

        if($this->db->delete('default_extra_gigs'))

        {

            echo 1;

        }

        

    }

	

	public function update_gig_status()

	{

		 $id = $this->input->post('gig_id');

		$status = $this->input->post('update_status');

		$update_data['status'] = $status;

		$this->db->query(" UPDATE `sell_gigs` SET `status` = ".$status." WHERE `id` = ".$id." ");

	}
      public function gig_preview(){

        $id = $this->uri->segment(4);
        $this->data['page']    = 'preview';
        $this->data['details'] = $this->admin_panel_model->gig_preview($id);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');  

    }

    public function gig_activate(){

        if($this->input->post('gig_id')){
            $params = $this->input->post();
            $gig_id = $params['gig_id'];
            $gig_active = $params['gig_active'];
            $this->db->where('id', $gig_id);
            $this->db->update('sell_gigs',array('status'=>$gig_active));
            $this->session->set_flashdata('message', 'The gig has been activated successfully...');
            redirect(base_url().'admin/gigs','refresh');
        }else{
            redirect(base_url().'admin','refresh');
        }

    }

}

?>