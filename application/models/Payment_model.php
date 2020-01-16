<?php
class Payment_model extends CI_Model{
    public function get_user_orders($id,$type,$start,$end)
	{
		//$data =array();
	 	$append_sql = '';
        if($type==1)
        {
        $append_sql = " LIMIT $start , $end ";    
        }
		$query = $this->db->query("
            SELECT py.*,sg.title,sg.delivering_time,sg.user_id,m.fullname,m.username,
			(SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			 FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
            LEFT JOIN members as m ON m.USERID = sg.user_id
			WHERE py.`USERID` = $id ORDER BY py.`created_at` DESC ".$append_sql."");
        /*$num_of_rows = $query->num_rows();
        if($num_of_rows>0)
        {
        $data = $query->result_array();
        }*/
		if($type==0){
        	$result = $query->num_rows();
        }else {
			$result = $query->result_array();
        }
        return $result;
	}
	public function get_user_orders_count($id)
	{
		$data =0;
		$query = $this->db->query("SELECT id FROM `payments` WHERE `USERID` = $id");
        $num_of_rows = $query->num_rows();
        if($num_of_rows>0)
        {
        $data = $query->num_rows();
        }
        return $data;
	}
	public function get_selluser_orders_count($id)
	{
		$data =0;
		$query = $this->db->query("SELECT id FROM `payments` WHERE `seller_id` = $id");
        $num_of_rows = $query->num_rows();
        if($num_of_rows>0)
        {
        $data = $query->num_rows();
        }
        return $data;
	}
	public function get_wallets_orders_count($id)
	{
		$data =0;
		$query = $this->db->query("SELECT id FROM `payments` WHERE `seller_id` = $id AND seller_status=6" );
        $num_of_rows = $query->num_rows();
        if($num_of_rows>0)
        {
        $data = $query->num_rows();
        }
        return $data;
	}
	public function get_selluser_details($id,$type,$start,$end)
	{
		//$data =array();
		$append_sql = '';
        if($type==1)
        {
        $append_sql = " LIMIT $start , $end ";    
        }
		$query = $this->db->query("
            SELECT py.*,sg.title,sg.delivering_time,sg.user_id,m.fullname,m.username,
			(SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			 FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
            LEFT JOIN members as m ON m.USERID = py.USERID
			WHERE py.`seller_id` = $id  ORDER BY py.`created_at` DESC ".$append_sql."");
        if($type==0){
        	$result = $query->num_rows();
        }else {
			$result = $query->result_array();
        }
        return $result;
	}
	public function getuser_wallets_details($id,$type,$start,$end)
	{
		//$data =array();
		$append_sql = '';
        if($type==1)
        {
        $append_sql = " LIMIT $start , $end ";    
        }
		$query = $this->db->query("
            SELECT py.*,sg.title,sg.user_id,m.fullname,m.username, 
			(SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
            LEFT JOIN members as m ON m.USERID = py.USERID
			WHERE py.`seller_id` = $id AND seller_status=6  ORDER BY py.`created_at` DESC ".$append_sql."");
       if($type==0){
        	$result = $query->num_rows();
        }else {
			$result = $query->result_array();
        }
        return $result;
	}
	public function get_payment_details($id)
	{
		$data =array();
		$query = $this->db->query("
            SELECT py.*,sg.title, sg.user_id,sg.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.super_fast_delivery_date, gi.image_path,gi.gig_image_thumb,m.fullname,m.username,m.user_thumb_image,cu.country,cu.sortname FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.seller_id
			LEFT JOIN country as cu ON cu.id = m.country
			WHERE py.`id` = $id");
        $num_of_rows = $query->num_rows();
        if($num_of_rows>0)
        {
        $data = $query->row_array();
        }
        return $data;
	}
	public function get_salespayment_details($id)
	{
		$data =array();
		$query = $this->db->query("
            SELECT py.*,sg.title,sg.user_id,sg.super_fast_charges ,sg.super_fast_delivery ,sg.super_fast_delivery_desc ,sg.super_fast_delivery_date,gi.image_path,gi.gig_image_thumb,m.fullname,m.username,m.user_thumb_image,cu.country,cu.sortname FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.USERID
			LEFT JOIN country as cu ON cu.id = m.country
			WHERE py.`id` = $id");
        $num_of_rows = $query->num_rows();
        if($num_of_rows>0)
        {
        $data = $query->row_array();
        }
        return $data;
	}


    // Digital downloads 
    public function get_files($id){
        
        if(!empty($id)){
         $query_string = "SELECT dd.*,sg.title FROM digital_download dd LEFT JOIN sell_gigs sg on sg.id = dd.gig_id where (seller_id = ".$id." AND seller_show =0) OR (buyer_id =".$id."  AND buyer_show = 0)";
         $query = $this->db->query($query_string);
        return $query->result_array();   
    }else{
        return false;
    }
         
    }
    public function get_upload_files($id,$uid){
    
    if(!empty($uid)){

           $query_string = "SELECT dd.*,sg.title,m.username FROM digital_download dd LEFT JOIN sell_gigs sg on sg.id = dd.gig_id LEFT JOIN members m on m.USERID = dd.upload_user_id  where order_id = ".$id." AND  ((seller_id = ".$uid." AND seller_show =0) OR (buyer_id =".$uid."  AND buyer_show = 0))";
         $query = $this->db->query($query_string);
        return $query->result_array();   
    }else{
        return false;
    }

    }

    public function get_user_orders_count_success($uid)
    {
         $query_string = "SELECT DISTINCT(order_id) FROM digital_download dd   WHERE (seller_id = ".$uid." AND seller_show =0) OR (buyer_id =".$uid."  AND buyer_show = 0)";
         $query = $this->db->query($query_string);
         $order_ids = $query->result_array();   
        if(!empty($order_ids)){
            
            $order_ids = array_map('current', $order_ids);
            
            $data =0;
            $query = $this->db->query("SELECT id FROM `payments` WHERE `USERID` = $uid AND `seller_status` !=0 AND id in (".implode(',', $order_ids).")");

            $num_of_rows = $query->num_rows();
            if($num_of_rows>0)
            {
            $data = $query->num_rows();
            }
            return $data;
        } else{
            return 0;
        }
        
    }

    public function get_selluser_details_success($id,$type,$start,$end){
        

         $query_string = "SELECT DISTINCT(order_id) FROM digital_download dd   WHERE (seller_id = ".$id." AND seller_show =0) OR (buyer_id =".$id."  AND buyer_show = 0)";
         $query = $this->db->query($query_string);
         $order_ids = $query->result_array();   
         
         if(!empty($order_ids)){
             $order_ids = array_map('current', $order_ids);


        $append_sql = '';
        if($type==1)
        {
        $append_sql = " LIMIT $start , $end ";    
        }
        $query = $this->db->query("
            SELECT py.*,sg.title,sg.delivering_time,sg.user_id,m.fullname,m.username,
            (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
             FROM `payments` as py
            LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id 
            LEFT JOIN members as m ON m.USERID = py.USERID
            WHERE (py.`seller_id` = $id OR py.`USERID` = $id) AND seller_status!=0 AND py.id in (".implode(',', $order_ids).")  ORDER BY py.`created_at` DESC ".$append_sql."");

        if($type==0){
            $result = $query->num_rows();
        }else {
            $result = $query->result_array();
        }
        return $result;
    }else{
        return false;
    }
    }
    
    public function remove_file($id){

        $uid = $this->session->userdata('SESSION_USER_ID');
        $data = $this->db->get_where('digital_download', array('seller_id'=>$uid,'id'=>$id))->row_array();
        if(!empty($data)){
                $where['id'] =  $data['id'];
                $where['seller_id'] = $data['seller_id'];
                $this->db->where($where);
                $this->db->update('digital_download', array('seller_show' => 1));
        }else{
            $data1 = $this->db->get_where('digital_download', array('buyer_id'=>$uid,'id'=>$id))->row_array();    
            
                $where['id'] =  $data1['id'];
                $where['seller_id'] = $data1['seller_id'];
                $this->db->where($where);
                $this->db->update('digital_download', array('buyer_show' => 1));
        }
        return TRUE;

    }
	public function check_and_remove(){
		
       $query = $this->db->query("SELECT * FROM `digital_download` WHERE buyer_show = 1 AND seller_show = 1");    
       $data = $query->result_array();
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $filename = $value['filename'];
                unlink(FCPATH.'uploads/digital/'.$filename);
            }
        }
    }
}

?>