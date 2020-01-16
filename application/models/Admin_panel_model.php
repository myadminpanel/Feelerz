<?php
class admin_panel_model extends CI_Model
{
	Public function get_updates()
    {

       $ch = curl_init();
        $options = array(
            CURLOPT_URL => 'https://www.dreamguys.co.in/gigs_updates/',
            CURLOPT_RETURNTRANSFER => true
            );

       if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            $options[CURLOPT_FOLLOWLOCATION] = true;
        }
        curl_setopt_array($ch, $options);            
       $output = curl_exec($ch);
        curl_close($ch);

       $updates = json_decode($output, TRUE);          
        
       $where = array('build' => $updates['build'] );
        $check_updates =  $this->db->get_where('version_updates',$where)->num_rows();
        if($check_updates!=0){
           $this->session->set_userdata(array('updates'=>1));
        }


   }
	public function edit_profession($id)
	{
		$query = $this->db->query(" SELECT * FROM `profession` WHERE `id` = $id ");
		$result = $query->row_array();
		return $result;
	}
		public function terms()
	{
		$query = $this->db->query(" SELECT * FROM `terms` WHERE `status` = 1");
		$result = $query->row_array();
		return $result;
	}
			public function get_terms()
	{
		$query = $this->db->query("SELECT * FROM `term` WHERE 1");
		$result = $query->result_array(); 
        return $result;   
	}
	public function footercount()
	{
		$query = $this->db->query("SELECT id
FROM  `footer_menu` 
WHERE STATUS =1");
		$result = $query->num_rows();
		return $result;
	}
		     public function catagorycheck($category_name,$catagory_id)
    {
		$join='';
		if($catagory_id!=''){
			$join="AND CATID != '".$catagory_id."'";
		}
        $query = $this->db->query("SELECT * FROM `categories` WHERE `name` ='".$category_name."' ".$join);
		
        $result = $query->num_rows();
        return $result;                      
    }
		public function admin_commision()
	{
		$query = $this->db->query(" SELECT `value` FROM `system_settings` WHERE `key` = 'admin_commision' ");
		$result = $query->row_array();
		return $result;
	}
		public function delete_seo_setting($seo_id)
	{
		$query = $this->db->query("DELETE FROM seo_details WHERE id	='".$seo_id."'");
		$result = 1;
		return $result;		
	}
	public function gig_price()
	{
		$query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'gig_price' ");
		$result = $query->row_array();
		return $result;		
	}
	
// 	public function get_rupee_dollar_rate()
// 	{
// 		$query = $this->db->query(" SELECT * FROM `currency` ORDER BY `created_date` DESC LIMIT 0 , 1  ;");
//         $result = $query->row_array();
//         return $result; 		
// 	}

    public function delete_user($id)
    {
        // var_dump($id);
        for($i=0;$i<count($id);$i++){
// var_dump($i);
        $query = $this->db->query("DELETE FROM users WHERE id  ='".$id[$i]."'");
        // var_dump($this->db->last_query());
        $result = 1;
        
        }        
        return $result; 
    }

 public function delete_sfeel($id)
    {
        // var_dump($id);
      
        $query = $this->db->query("DELETE FROM feeling WHERE id  IN ('".implode("','",$id)."')");
        // var_dump($this->db->last_query());
      
        return $query; 
               
    }

     public function delete_image($id)
    {
        // var_dump($id);
      
        $query = $this->db->query("DELETE FROM user_manage_images WHERE id  ='".$id."'");
        // var_dump($this->db->last_query());
      
        return $query; 
               
    }
    
    // public function delete_video($ids)
    // {
      
    //     $query = $this->db->query("DELETE FROM user_manage_videos WHERE id  ='".$ids."'");
    //     // var_dump($this->db->last_query());
      
    //     return $query; 
               
    // }
    
    //  public function delete_po($ids)
    // {
      
    //     $query = $this->db->query("DELETE FROM post WHERE id  ='".$ids."'");
    //     // var_dump($this->db->last_query());
      
    //     return $query; 
               
    // }
    
    
    public function delete_po($ids)
    {
        // var_dump($ids);
      
        $query = $this->db->query("DELETE FROM post WHERE id  ='$ids'");
        // var_dump($this->db->last_query());
     
     
     
        return $query; 
               
    }
    
    public function delete_report($id,$post_id)
    {
      
        $query1 = $this->db->query("DELETE FROM user_manage_report WHERE id='".$id."'");
        $query2 = $this->db->query("DELETE FROM post WHERE id='".$post_id."'");
       
         return $query1; 
               
    }
    public function delete_post($id)
    {
      
       $query = $this->db->query("DELETE FROM post WHERE id ='".$id."'");
        return $query; 
               
    }
    
    
//     public function insert_into($id) {
//     $q = $this->db->get('support')->result(); // get first table
//     foreach($q as $r) { // loop over results
//         $this->db->insert('trash_support', $r); // insert each row to another table
//         $query = $this->db->query("DELETE FROM support where user_id = '$id'");
      
//         return $query;
//     }
      
// }





 public function delete_country($id)
    {
      
        $query = $this->db->query("DELETE FROM country WHERE user_id  ='$id' ");
      
        return $query; 
               
    }


public function insert_into($id) {
    // Which member do we want to get from the free_members Table?
    $this->db->where('user_id', $id);
    $query = $this->db->get('support');
    // Did we get a result? i.e was a valid member id passed in?
    if($query !== false) {
        $row = $query->row();
        $this->db->insert('trash_support', $row);
    } else {
       // Do nothing or handle the case where an illegal number was used...
    }
     $query = $this->db->query("DELETE FROM support where user_id = '$id'");
      
        return $query;
}





    public function activate($id){
$this->db->query("UPDATE users SET status = 0
                  WHERE id ='".$id."'");
    }



public function deactivate($id){
$this->db->query("UPDATE users SET status = 1 
                  WHERE id ='".$id."'");
                
}

public function deact($id){
$this->db->query("UPDATE country SET status = 0 
                  WHERE id ='".$id."'");
// $this->load->view('admin/country/county');
}

public function act($id){
$this->db->query("UPDATE country SET status = 1 
                  WHERE id ='".$id."'");
// var_dump($this->db->last_query());
// $this->load->view('admin/country/county');
}

public function updateCountry($data,$id){
    var_dump($id);
// $this->db->where('id', $id);
$this->db->where('id', $id);
$result = $this->db->update('country', $data);



// $result=$this->db->update('country', $data);

return $result;
}

public function updatePolicy($data,$id){
    var_dump($id);
// $this->db->where('id', $id);
$this->db->where('id', $id);
$result = $this->db->update('privacy_policy', $data);



// $result=$this->db->update('country', $data);

return $result;
}


public function updateDisclaimer($data,$id){
    var_dump($id);
// $this->db->where('id', $id);
$this->db->where('id', $id);
$result = $this->db->update('disclaimer', $data);



// $result=$this->db->update('country', $data);

return $result;
}


public function updateAbout($data,$id){
    var_dump($id);
// $this->db->where('id', $id);
$this->db->where('id', $id);
$result = $this->db->update('about_us', $data);



// $result=$this->db->update('country', $data);

return $result;
}




public function updateUser($update_userdata,$id){
    
    
    
    
$this->db->where('id', $id);
 
$result=$this->db->update('users', $update_userdata);
return $result;

}

public function updatePass($update_userdata,$id){
$this->db->where('id', $id);
 
$result=$this->db->update('administrators', $update_userdata);

var_dump($this->db->last_query());
return $result;
}





public function updateFeel($update_userdata,$fid){
    
    $check_data=$this->db->query("SELECT * FROM feeling WHERE name='".$update_userdata["name"]."' AND id !='".$fid["id"]."'")->result_array();
if(@$check_data)
{
    return false;
}
   else{ 
    
    

  
$this->db->where('id', $fid);
 
$result=$this->db->update('feeling', $update_userdata);
return $result;
}
}

public function updatesubFeel($update_userdata,$ffid){
    
    $check_data=$this->db->query("SELECT * FROM feeling WHERE name='".$update_userdata["name"]."' AND id !='".$ffid."'")->result_array();
if(@$check_data)
{
    return false;
}else{
    
    
$this->db->where('id', $ffid);
 
$result=$this->db->update('feeling', $update_userdata);

return $result;
// $this->db->last_query();
}
}
























public function country_insert($data){ 


// Inserting in Table(country) of Database(country)
 $this->db->insert('country', $data);
//  $result=$this->db->update('country', $data);
 return $result;
}


public function feeling_insert($data){ 

$check_data=$this->db->query("SELECT * FROM feeling WHERE name='".$data["name"]."'")->result_array();
if(@$check_data)
{
    return false;
}
else
{
  // Inserting in Table(country) of Database(country)
$result=$this->db->insert('feeling', $data);
//  $result=$this->db->update('country', $data);
 return $result;    
}


}

public function subfeeling_insert($data){ 
$check_data=$this->db->query("SELECT * FROM feeling WHERE name='".$data["name"]."'")->result_array();
if(@$check_data)
{
    return false;
}else{

// Inserting in Table(country) of Database(country)
$result= $this->db->insert('feeling', $data);
//  $result=$this->db->update('feeling', $data);
 return $result;
}
}
public function policy_insert($data){ 


// Inserting in Table(country) of Database(country)
 $this->db->insert('privacy_policy', $data);
//  $result=$this->db->update('country', $data);
 return $result;
}


	
	public function all_profession($start,$end)
	{
		$query = $this->db->query(" SELECT * FROM  `profession` LIMIT $start , $end ");
		$result = $query->result_array();
		return $result;		
	}
	
	 public function all_gigs($return_type,$start,$end)
    {
        $append_sql = "";
         if($start>0||$end>0)
         {
     	 $append_sql = " LIMIT $start , $end"; }
        $query= $this->db->query("SELECT sell_gigs.id as gig_id , ( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image`   
		 WHERE gigs_image.gig_id = sell_gigs.id   LIMIT 0 , 1  ) AS gig_image ,  sell_gigs.`title`,  sell_gigs.`currency_type` , members.fullname , members.username , categories.name as         category_name , sell_gigs.`gig_price` , sell_gigs.`status`, sell_gigs.`created_date`  FROM `sell_gigs` 
    	INNER JOIN members ON members.USERID = sell_gigs.user_id 
		INNER JOIN categories ON categories.CATID = sell_gigs.category_id ORDER BY sell_gigs.`created_date` DESC ".$append_sql." ");        
        if($return_type==0)
        { $result = $query->num_rows(); }
        else { $result = $query->result_array(); 
		 
		
		}        
        return $result;
        
    }
	
	public function release_payments($return_type,$start,$end)
	{
        $append_sql = "";
	if($return_type==1)
        { 
         if($start>0||$end>0)
         { $append_sql = " LIMIT $start , $end"; }
		}
		$query =$this->db->query("SELECT a.*, s.fullname as buyer_name,va.paypal_email_id as buyer_paybalemail,s.email as buyer_email,sg.title,sm.email as selleremail, sm.fullname as seller_name ,ba.paypal_email_id FROM  `payments`as a
                            LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
                            LEFT JOIN sell_gigs as sg ON sg.id = a.gigs_id
                            LEFT JOIN members as s ON s.USERID = a.USERID   
                            LEFT JOIN members as sm ON sm.USERID = a.seller_id 
							 LEFT JOIN bank_account as va ON va.user_id = a.seller_id
							WHERE  (a.payment_status = 1 OR a.cancel_accept = 1 OR a.decline_accept = 1) AND a.payment_status != 2 ".$append_sql."");
	/* 	 $query = $this->db->query(" SELECT a . * , s.fullname AS buyer_name,ba.paypal_email_id, sm.fullname AS seller_name, s.email AS buyeremil
										FROM  `payments` AS a
										LEFT JOIN members AS s ON s.USERID = a.USERID
										LEFT JOIN members AS sm ON sm.USERID = a.seller_id
										LEFT JOIN bank_account AS ba ON ba.user_id = a.seller_id
										WHERE a.payment_status = 1 ORDER BY a.`created_at` DESC ".$append_sql." "); 
	  */
		 if($return_type==0)
        { 			
		$result = $query->num_rows(); }
        else { 	
		$result = $query->result_array();
		}        
		return $result;
	}
		public function Completed_payments($return_type,$start,$end)
	{
        $append_sql = "";
		if($return_type==1)
        {         
			if($start>0||$end>0)
			 { $append_sql = " LIMIT $start , $end"; }
		}
		 $query = $this->db->query(" SELECT a . * , s.fullname AS buyer_name, sm.fullname AS seller_name, s.email AS buyeremil
										FROM  `payments` AS a
										LEFT JOIN members AS s ON s.USERID = a.USERID
										LEFT JOIN members AS sm ON sm.USERID = a.seller_id
										WHERE a.payment_status = 2 ORDER BY a.`created_at` DESC ".$append_sql." ");
										
		 if($return_type==0)
        { 		 
		$result = $query->num_rows(); }
        else { 	
		$result = $query->result_array(); }        
        return $result;
	}
	public function copy_right_year()
	{				
		$query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'copy_rit_year';");
		$result = $query->row_array();		
		return $result;
		
	}
	
// 	public function dashboard_details()
// 	{ 
// 	    $query = $this->db->query("SELECT * FROM ((SELECT COUNT( * ) AS total_gigs FROM  `sell_gigs`) AS total_gigs, 
// 		(SELECT COUNT( * ) AS total_user FROM  `members`) AS total_user, 
// 		(SELECT COUNT( * ) AS total_orders FROM  `payments`) AS total_orders , 
// 		(SELECT COUNT( * ) AS completed_orders FROM  `payments` WHERE  `seller_status` =6) AS completed_orders)");
//         $result = $query->row_array();
//         return $result;                				
// 	}
	
	
	public function total_user_count()
	{
	 //  $this->db->select('id','name','email');
	  //   $this->db->from('users');
	    $query = $this->db->query('SELECT * FROM users');
	     $result = $query->result_array();
        return $result; 
	}
	
	
 	public function my_join()
 	{
	   // $this->db->query();
	    $query = $this->db->query('SELECT * FROM users ORDER BY `users`.`id` DESC limit 10');
	     $result = $query->result_array();
        return $result;
 	}
	
	public function total_country_count()
	{
	 //  $this->db->select('id','name','email');
	  //   $this->db->from('users');
	    $query = $this->db->query('SELECT * FROM country');
	     $result = $query->result_array();
        return $result; 
	}
	public function total_feeling_count()
	{
	 //  $this->db->select('id','name','email');
	  //   $this->db->from('users');
	    $query = $this->db->query('SELECT * FROM feeling');
	     $result = $query->result_array();
        return $result; 
	}
	public function total_reported_count()
	{
	 //  $this->db->select('id','name','email');
	  //   $this->db->from('users');
	    $query = $this->db->query('SELECT * FROM user_manage_report');
	     $result = $query->result_array();
        return $result; 
	}
		public function total_post_count()
	{
	 //  $this->db->select('id','name','email');
	  //   $this->db->from('users');
	    $query = $this->db->query('SELECT * FROM post');
	     $result = $query->result_array();
        return $result; 
	}
	
// 	public function dashboard_recent_gigs()
// 	{
//         $query = $this->db->query("	SELECT gigs_image.`gig_image_thumb` , payments.paypal_uid, payments.item_amount,payments.currency_type, payments.created_at
// 									FROM  `gigs_image` 
// 									INNER JOIN payments ON payments.gigs_id = gigs_image.`gig_id`
//                                     GROUP BY  payments.id
// 									ORDER BY payments.created_at DESC 
// 									LIMIT 0 , 6 ");
//         $result = $query->result_array();
//         return $result;                		
// 	}
	
// 	public function dashboard_popular_gigs()
// 	{
//         $query = $this->db->query(" SELECT sell_gigs.`title`,sell_gigs.`gig_price`,sell_gigs.currency_type,sell_gigs.`created_date`,sell_gigs.`total_views`,(SELECT gig_image_thumb FROM `gigs_image` WHERE `gig_id` = sell_gigs.id LIMIT 0 , 1 ) AS gig_image FROM `sell_gigs` ORDER BY `total_views` DESC  LIMIT 0 , 6  ");
//         $result = $query->result_array();
//         return $result;                		
// 	}
	
	
    public function get_policy_settings($start,$end)
    {
        $query = $this->db->query("SELECT * FROM  `policy_settings` LIMIT $start , $end  ");
        $result = $query->result_array();
        return $result;                
    }
    
    public function get_seo_settings($start,$end)
    {
        $query = $this->db->query("SELECT * FROM `seo_details` LIMIT $start , $end  ");
        $result = $query->result_array();
        return $result;                
    }
    
    public function edit_seo_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `seo_details` WHERE id = $id");
        $result = $query->row_array();
        return $result;                
    }
	    public function edit_paypal_settings($id)
    {
        $query = $this->db->query("SELECT * FROM `paypal_details` WHERE id = $id");
        $result = $query->row_array();
        return $result;                
    }
    
    
    
    public function edit_policy_settings($id)
    {
        $query = $this->db->query("SELECT * FROM  `policy_settings` WHERE `id` = $id ");
        $result = $query->row_array();
        return $result;                
    }
    
    public function edit_client_list($client_id)
    {
        $query = $this->db->query("SELECT * FROM `client` WHERE `id` = '".$client_id."' ; ");
        $result = $query->row_array();
        return $result;
    }
    public function all_category()
    {
        $query = $this->db->query("SELECT c.*,(c2.`CATID`) as parent_id,(c2.name) as parent_name FROM categories c  
LEFT join `categories` as c2 ON c2.CATID = c.parent where c.delete_sts =0 ");
        $result = $query->result_array();
        return $result;        
    }
    public function categories()
    {
        $query = $this->db->query(" SELECT * FROM `categories` WHERE `status` = 0 ");
        $result = $query->result_array();
        return $result;        
    }
    public function edit_category($category_id)
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `CATID` = '".$category_id."' ; ");
        $result = $query->row_array();
        return $result;
    }
    public function parent_category()
    {
        $query = $this->db->query("SELECT * FROM `categories` WHERE `parent` = 0 AND `status` = 0 ");
        $result = $query->result_array();
        return $result;
    }
    public function default_extra_gigs()
    {        
        $query = $this->db->query("SELECT * FROM `default_extra_gigs` ");
        $result = $query->result_array();
        return $result;        
    }
    public function all_sub_category()
    {        
        $query = $this->db->query("SELECT * FROM `categories` WHERE `status` = 0");
        $result = $query->result_array();
        return $result;        
    }
    public function edit_gigs($gig_id)
    {
        $query = $this->db->query("SELECT * FROM `default_extra_gigs` WHERE `default_gig_id` = '".$gig_id."' ");
        $result = $query->row_array();
        return $result;
    }
    public function get_meta_settings()
    {
        $query = $this->db->query("SELECT * FROM `meta_settings`");
        $result = $query->row_array();
        return $result;        
    }
    public function get_setting_list() {
        $data = array();
        $stmt = "SELECT a.*"
                . " FROM system_settings AS a"
                . " ORDER BY a.`id` ASC";
        $query = $this->db->query($stmt);
        if ($query->num_rows()) {
            $data = $query->result_array();
        }
        return $data;
    }
    public function get_static_page($end,$start)
    {        
        $query = $this->db->query("SELECT * FROM  `page` LIMIT $start , $end");
        $result = $query->result_array();
        return $result;           
    }
    public function edit_static_page($id)
    {
        $query = $this->db->query("SELECT * FROM  `page` WHERE page_id = $id ");
        $result = $query->result_array();
        return $result;                   
    }
    public function site_name()
    {
        $query = $this->db->query("SELECT `value` FROM `system_settings` WHERE `key` = 'website_name';");
        $result = $query->row_array();
        return $result;              
    }
    public function get_ban_ip()
    {
        $query = $this->db->query("SELECT * FROM `bans_ips`;");
        $result = $query->result_array();
        return $result;                      
    } 
    public function check_ip($ip_address)
    {
        $query = $this->db->query("SELECT * FROM `bans_ips` WHERE `ip_addr` = '$ip_address';");
        $result = $query->num_rows();
        return $result;                      
    }    
     public function is_valid_menu_name($menu_name)
    {
        $query = $this->db->query("SELECT * FROM `footer_menu` WHERE `title` =  '$menu_name';");
        $result = $query->num_rows();
        return $result;                      
    }
	     public function check_profession($Profession)
    {
        $query = $this->db->query("SELECT * FROM `profession` WHERE `profession_name` =  '$Profession';");
        $result = $query->num_rows();
        return $result;                      
    }
    public function is_valid_submenu($menu_name)
    {
        $query = $this->db->query("SELECT * FROM `footer_submenu` WHERE `title` =  '$menu_name';");
        $result = $query->num_rows();
        return $result;                      
    }      
    public function edit_footer_menu($id)
    {
        $query = $this->db->query("SELECT * FROM `footer_menu` WHERE `id` =  $id;");
        $result = $query->result_array();
        return $result;                      
    }
    public function edit_ip($ip_address)
    {
        $query = $this->db->query("SELECT * FROM `bans_ips` WHERE `id` = '$ip_address';");
        $result = $query->row_array();
        return $result;                      
    }
    public function get_all_request()
    {
        $query = $this->db->query("
            SELECT req.*,members.fullname,(categories.name) AS main_category,sub_cat.name as sub_category FROM `request` as req
	    LEFT JOIN members ON members.USERID = req.posted_by	  
            LEFT JOIN categories ON categories.CATID = req.`main_cat`
            LEFT JOIN categories as sub_cat ON sub_cat.CATID = req.`sub_cat`;");
        $result = $query->result_array();
        return $result;   
    }
    public function edit_request($id)
    {
        $query = $this->db->query("SELECT * FROM `request` WHERE `id` = $id ;");
        $result = $query->row_array();
        return $result;          
    }   
    
    // public function get_post()
    // {        
    //     $query = $this->db->query("SELECT a.*,b.*,b.user_id,b.post_text,b.image,b.comments,b.total_hug,b.total_share,b.date_time FROM users as a, post as b
    //     WHERE b.user_id=a.id ORDER BY `a`.`id` DESC");
    //     var_dump($this->db->last_query());
    //     $result = $query->result_array();
    //     return $result;                  
    // }
    
    public function record_count() {
return $this->db->count_all("post");
// $query = $this->db->query("SELECT p.*,u.name,u.profileimage,u.id FROM `post` as p INNER JOIN users as u on p.user_id = u.id ORDER by p.id DESC");
//         $result = $query->result_array();
        // return $this->db->count_all("post");
}

public function fetch_data($limit,$page) {

$limit_data=$page*10;
$query = $this->db->query("SELECT * FROM post ORDER BY id DESC LIMIT ".$limit_data." ,10");
// var_dump($this->db->last_query());
return $query->result_array();
}
    // public function get_count() {
    //     $query = $this->db->query("SELECT p.*,u.name,u.profileimage,u.id FROM `post` as p INNER JOIN users as u on p.user_id = u.id ORDER by p.id DESC");
    //     $result = $query->result_array();
    //     return $this->db->count_all($query);
    // }
    // public function get_post($limit, $start)
    public function get_post($limit)
    {
        
        $limit=$limit*10;
        $query = $this->db->query("SELECT p.*,p.id as post_id,u.name,u.profileimage,u.id FROM `post` as p INNER JOIN users as u on p.user_id = u.id ORDER by p.id DESC limit ".$limit." ,10");
  // var_dump($this->db->last_query());
    // $this->db->order_by("date_time", "desc");
   $result = $query->result_array();
        return $result;
        
    }
        // if ($query->num_rows() > 0) 
        // {
        //     foreach ($query->result() as $row) 
        //     {
        //         $data[] = $row;
        //     }
             
        //     return $data;
        // }
 
        // return false;
        
        
        
        // $query = $this->db->query("SELECT p.*,u.name,u.profileimage,u.id FROM `post` as p INNER JOIN users as u on p.user_id = u.id ORDER by p.date_time DESC");
        // $result = $query->result_array();
        // return $result;
    
    // public function num_rows(){
    //     $query = $this->db->query("SELECT p.*,u.name,u.profileimage,u.id FROM `post` as p INNER JOIN users as u on p.user_id = u.id ORDER by p.id DESC");
    //     $result = $query->result_array();
    //     return $num_rows;
    // }
    
    
    // public function get_total() 
    // {
    //     // $query = $this->db->get("SELECT p.*,u.name,u.profileimage,u.id FROM `post` as p INNER JOIN users as u on p.user_id = u.id ORDER by p.date_time DESC");
    //     // $result = $query->result_array();
    //   return $this->db->count_all("post");
    // }
    
    
   public function get_reported()
    {        
        $query = $this->db->query("SELECT a.*,b.name,b.profileimage,c.post_text,c.image from user_manage_report as a,users as b,post as c where a.user_id=b.id and c.id=a.post_id ORDER BY `a`.`id` DESC ");
    //   $this->db->limit($limit, $start);
        $result = $query->result_array();
        return $result;                  
    }
    
    

     public function get_images()
    {        
        $query = $this->db->query("SELECT * FROM `user_manage_images` ");
        $result = $query->result_array();
        return $result;                  
    }
    
     public function get_policy()
    {        
        $query = $this->db->query("SELECT * FROM `privacy_policy` ");
        $result = $query->result_array();
        return $result;                  
    }
    
     public function get_password()
    {        
        $query = $this->db->query("SELECT * FROM `administrators` ");
        $result = $query->result_array();
        return $result;                  
    }
    public function getcurrentpassword($userid)
    {
        $query = $this->db->where(['ADMINID' => $userid])->get('administrators');
              if($query->num_rows() > 0){
                  return $query->row();
             }
    }
    
    public function updatepassword($new_pass, $userid){
        
        $data = array(
            'password' => $new_pass
            
            );
            return $this->db->where('ADMINID',$userid)->update('administrators', $data);
        
    }
    
      public function get_setting()
    {        
        $query = $this->db->query("SELECT * FROM `setting` ");
        $result = $query->result_array();
        return $result;                  
    }
    
    
     public function get_about()
    {        
        $query = $this->db->query("SELECT * FROM `about_us` ");
        $result = $query->result_array();
        return $result;                  
    }
    
    
     public function get_disclaimer()
    {        
        $query = $this->db->query("SELECT * FROM `about_us` ");
        $result = $query->result_array();
        return $result;                  
    }
    
    
    public function get_user()
    {        
        $query = $this->db->query("SELECT * FROM `users` ORDER BY id DESC");
        // var_dump($this->db->last_query());
        $result = $query->result_array();
        return $result;                  
    }
    
    //  public function get_profile()
    // {        
    //     $query = $this->db->query("SELECT * FROM `users` ");
    //     $result = $query->result_array();
    //     return $result;                  
    // }
    
    
    //  public function get_report()
    // {        
    //     $query = $this->db->query("SELECT * FROM `user_manage_report` ");
    //     $result = $query->result_array();
    //     return $result;                  
    // }
    
    
    public function get_support()
    {        
          $query = $this->db->query("SELECT a.*,b.support_msg,b.description FROM users as a, support as b WHERE b.user_id=a.id ORDER BY `a`.`id` DESC");
          $result = $query->result_array();
          return $result;                
    }



public function get_country()
    {        
        $query = $this->db->query(" SELECT * FROM `country`");
        $result = $query->result_array();
        return $result;                  
    }
    
    public function get_feeling()
    {        
        $query = $this->db->query(" SELECT * FROM `feeling` WHERE parrent = '' ");
        $result = $query->result_array();
        return $result;                  
    }

    // public function get_emoji()

    // {        
    //     $query = $this->db->query(" SELECT `emoji name`,`emoji category`,`emoji icon`,`emoji status` FROM `manage_emoji` ");
    //     $result = $query->result_array();
    //     return $result;                  
    // }
    
    
    public function updateEmoji($update_emojiydata,$id){
$this->db->where('id', $id);
$result=$this->db->update('manage_emoji', $update_emojidata);
return $result;
}

public function add_emoji($data)
{
    $this-> db->insert('manage_emoji',$data);
}

    public function edit_user($id)
    {
        $query = $this->db->query("SELECT `id`,`name`,`email`,`dob`,`gender`,`country`,`verified`,`status` FROM `users`  WHERE `id` = $id");
        $result = $query->row_array(); 
        return $result;           
    }
    public function get_ads($start,$end)
    {
        if(empty($start)&&empty($end))
        {
        $query = $this->db->query("SELECT * FROM `ads` ;");
        $result = $query->result_array(); 
        return $result;         
        }
        else 
        {
        $query = $this->db->query("SELECT * FROM `ads` LIMIT $start , $end ;");
        $result = $query->result_array(); 
        return $result;    
        }
    } 
    public function edit_ads($id)
    {
        $query = $this->db->query("SELECT * FROM `ads` WHERE `ads_id` = $id ");
        $result = $query->row_array(); 
        return $result;            
    }
    public function get_review($start,$end)
    {
		$last_append = '';
        if($start||$end!=0)
        {
        $last_append = " LIMIT $start , $end";   
        }
        /*$query = $this->db->query("SELECT gigs_reviews.review_id,gigs_reviews.`review`,members.fullname,gigs.gig_title,gigs_reviews.`created_date`,gigs_reviews.`status` FROM `gigs_reviews`
                                    INNER JOIN members ON members.USERID = gigs_reviews.`user_id`
                                    INNER JOIN gigs ON gigs.id = gigs_reviews.`gig_id`");*/
		$query = $this->db->query("SELECT  feedback.*,members.fullname,sell_gigs.title FROM `feedback`
                                    INNER JOIN members ON members.USERID = feedback.`from_user_id`
                                    INNER JOIN sell_gigs ON sell_gigs.id = feedback.`gig_id`
									ORDER BY feedback.id DESC ".$last_append." ");
        $result = $query->result_array(); 
        return $result;                    
    }
    public function edit_review($id)
    {
        $query = $this->db->query("SELECT gigs_reviews.review_id,gigs_reviews.`review`,members.fullname,gigs.gig_title,gigs_reviews.`created_date`,gigs_reviews.`status` FROM `gigs_reviews`
                                    INNER JOIN members ON members.USERID = gigs_reviews.`user_id`
                                    INNER JOIN gigs ON gigs.id = gigs_reviews.`gig_id`
                                    WHERE gigs_reviews.`review_id` = $id ");
        $result = $query->row_array(); 
        return $result;                    
    }
    public function get_admin_profile($id)
    {
        $query = $this->db->query("SELECT * FROM `administrators` WHERE `ADMINID` = $id");
        $result = $query->row_array(); 
        return $result;                            
    }
    public function get_client_list()
    {
        $query = $this->db->query("SELECT * FROM  `client` ");
        $result = $query->result_array(); 
        return $result;          
    }
    public function get_footer_menu($end , $start)
    {        
        $query = $this->db->query("SELECT * FROM  `footer_menu` LIMIT $start , $end ");
        $result = $query->result_array(); 
        return $result;                  
    }
    public function get_footer_submenu($end , $start)
    {        
        $query = $this->db->query("SELECT footer_submenu.*,footer_menu.title FROM `footer_submenu`
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu`
                                    LIMIT $start , $end ");
        $result = $query->result_array(); 
        return $result;                  
    }
     public function get_all_footer_menu()
    {        
        $query = $this->db->query("SELECT * FROM  `footer_menu` ");
        $result = $query->result_array(); 
        return $result;                  
    }
    public function get_all_footer_submenu()
    {        
        $query = $this->db->query("SELECT footer_submenu.*,footer_menu.title FROM `footer_submenu`
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu` ");
        $result = $query->num_rows(); 
        return $result;                  
    }
	    public function edit_terms($id)
    {
        $query = $this->db->query("SELECT *
                                    FROM  term
                                    WHERE id= $id ");
            $result = $query->result_array(); 
        return $result;                          
    }
    public function edit_submenu($id)
    {
        $query = $this->db->query("SELECT footer_submenu . * , footer_menu.title
                                    FROM  `footer_submenu` 
                                    INNER JOIN footer_menu ON footer_menu.id = footer_submenu.`footer_menu` 
                                    WHERE footer_submenu.id = $id ");
            $result = $query->result_array(); 
        return $result;                          
    }
   
	 public function new_notification()
	{
		$query = $this->db->query("SELECT * FROM 
			(SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.admin_notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.admin_notification_status =1
			UNION
			SELECT sell_gigs.id, `members`.`fullname` AS buyer_name, sell_gigs.created_date AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'new_gig' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = sell_gigs.id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `sell_gigs` 
			INNER JOIN members ON sell_gigs.`user_id` =  `members`.`USERID` 
			WHERE sell_gigs.notification_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_request' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.payment_status =1
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_decline' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 5 AND payments.decline_accept =1 AND payment_status!=2
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name, payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'payment_cancel' as status
			, (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  payments.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1 AND payment_status!=2
			
			) a ORDER BY a.created_date DESC ");    
		$result = $query->result_array();
		return $result; 
				
				
	}
	 public function get_allpayment_list($start,$end)
    {
		$last_append = '';
        if($start||$end!=0)
        {
        $last_append = " LIMIT $start , $end";   
        }
        $query = $this->db->query("SELECT a.*,a.id as newid,g.*,gi.*, s.fullname as buyer_name,s.user_thumb_image as buyerimage, s.description ,s.user_profile_image as sellerimage, sm.fullname as seller_name ,sm.user_thumb_image,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
									LEFT JOIN members as s ON s.USERID = a.USERID	
									LEFT JOIN sell_gigs as g ON g.user_id =a.seller_id
									LEFT JOIN gigs_image as gi ON gi.gig_id =g.id
									LEFT JOIN members as sm ON sm.USERID = a.seller_id group by a.id ".$last_append." ");
            $result = $query->result_array(); 
        return $result;                          
    }
	public function get_completepayment_list($type, $start, $end)
    {
		$last_append = '';
        if($type==1)
        {
        $last_append = "LIMIT $start , $end";   
        }
        $query = $this->db->query("SELECT a.*, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
                                    LEFT JOIN members as s ON s.USERID = a.USERID   
                                    LEFT JOIN members as sm ON sm.USERID = a.seller_id 
                                    WHERE a.seller_status = 6 ".$last_append."" );
									 

              // SELECT a.*, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
              //                       FROM  `payments`as a
              //                       LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
              //                       LEFT JOIN members as s ON s.USERID = a.USERID   
              //                       LEFT JOIN members as sm ON sm.USERID = a.seller_id 
              //                       WHERE a.seller_status=6 ".$last_append."
									
            if($type==0){
			 $result = $query->num_rows(); 
			}else { 
			  
				$result = $query->result_array(); 
			}
			 
			 
        return $result;                          
    }  
	public function get_declinepayment_list($type, $start, $end)
    {
		$last_append = '';
        if($type==1)
        {
        $last_append = " LIMIT $start , $end";   
        }
        $query = $this->db->query("SELECT a.*, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
									LEFT JOIN members as s ON s.USERID = a.USERID	
									LEFT JOIN members as sm ON sm.USERID = a.seller_id 
									WHERE a.seller_status=5 ".$last_append." ");
									
            if($type==0){
			 $result = $query->num_rows(); 
			}else { 
				$result = $query->result_array(); 
			}
        return $result;                          
    }  
	public function get_Pendingpayment_list($type, $start, $end)
    {
		$last_append = '';
        if($type==1)
        {
        $last_append = " LIMIT $start , $end";   
        }
        $query = $this->db->query("SELECT a.*, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.seller_id
									LEFT JOIN members as s ON s.USERID = a.USERID	
									LEFT JOIN members as sm ON sm.USERID = a.seller_id 
									WHERE (a.seller_status=2 OR a.seller_status=3) ".$last_append." ");
			
			if($type==0){
			 $result = $query->num_rows(); 
			}else { 
				$result = $query->result_array(); 
			}
        return $result;                          
    } 


    public function get_rejected_list()

    {

        /*$query = $this->db->query("SELECT br.*,m.username as seller_name,m1.username as buyer_name,p.seller_status,p.payment_status,sg.title FROM buyer_rejected_list br LEFT JOIN members m on m.USERID = br.seller_id LEFT JOIN members m1 on m1.USERID = br.buyer_id LEFT JOIN payments p on p.seller_status = m.USERID LEFT JOIN sell_gigs sg on sg.user_id = br.seller_id");*/


        $query = $this->db->query("SELECT BRL.*,M.fullname as buyername ,M1.fullname as sellername,SG.title as gig_name,p.id as                        seller_order FROM buyer_rejected_list BRL 
                                    LEFT JOIN sell_gigs SG ON SG.id= BRL.gig_id 
                                    LEFT JOIN members M ON M.USERID= BRL.buyer_id 
                                    LEFT JOIN payments p on p.id = BRL.order_id
                                    LEFT JOIN members M1 ON M1.USERID= BRL.seller_id ORDER by id desc");
        //echo$this->db->last_query();exit;

        $result = $query->result_array(); 

        return $result;   

    }

    public function reject_accept($change_reject_status,$id,$order_id)
    {
        $query = $this->db->query("UPDATE buyer_rejected_list SET status = '".$change_reject_status."',rejected_request = 1 WHERE id = '".$id."'");

        $query = $this->db->query("UPDATE payments SET seller_status = 3 WHERE id = '".$order_id."'");

      //echo$this->db->last_query();exit;
        
        return $query;
    }


    public function cancel_request($list_id)
    {

        //$id = $this->session->userdata('SESSION_USER_ID');

            $request = $this->db->query("SELECT b.*,m.username as seller_name,m.email as seller_email, a.name as admin_name,a.email as                                  admin_email,m1.username as buyer_name,s.title from buyer_rejected_list b
                                LEFT JOIN members m on m.USERID = b.seller_id
                                LEFT JOIN members m1 on m1.USERID = b.buyer_id
                                LEFT JOIN sell_gigs s on s.user_id = b.seller_id
                                LEFT JOIN administrators a on a.ADMINID = 2
                                WHERE b.id = $list_id");

       //echo $this->db->last_query();exit;



        $result = $request->row_array();


        return $result;
    }


	public function get_cancelpayment_list($type, $start, $end)
    {
		$last_append = '';
        if($type==1)
        {
        $last_append = " LIMIT $start , $end";   
        }
        $query = $this->db->query("SELECT a.*,s.email as buyer_email, s.fullname as buyer_name, sm.fullname as seller_name ,ba.paypal_email_id
                                    FROM  `payments`as a
                                    LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
									LEFT JOIN members as s ON s.USERID = a.USERID	
									LEFT JOIN members as sm ON sm.USERID = a.seller_id 
									WHERE a.buyer_status=1 ".$last_append." ");
									
		if($type==0){
			 $result = $query->num_rows(); 
		}else { 
			$result = $query->result_array(); 
		} 
        return $result;                          
    }  
      // All Payment Details (Incoming withdrawl , cancel , decline )
     public function get_all_list($type, $start, $end)
    {
        $last_append = '';
        if($type==1)
        {
       // $last_append = " LIMIT $start , $end";   
        }
				$query_string ="SELECT a.*, s.fullname as buyer_name,va.paypal_email_id as buyer_paybalemail,s.email as buyer_email,sg.title,sm.email as selleremail, sm.fullname as seller_name ,ba.paypal_email_id FROM  `payments`as a
                            LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
                            LEFT JOIN sell_gigs as sg ON sg.id = a.gigs_id
                            LEFT JOIN members as s ON s.USERID = a.USERID   
                            LEFT JOIN members as sm ON sm.USERID = a.seller_id 
							 LEFT JOIN bank_account as va ON va.user_id = a.seller_id
							WHERE  (a.payment_status = 1 OR a.cancel_accept = 1 OR a.decline_accept = 1) AND a.payment_status != 2 ".$last_append."";
			$query = $this->db->query($query_string);			
			// Where condition apply need request payment and cancel or decline 	
				//WHERE  (a.buyer_status=1 OR a.seller_status=5) AND a.payment_status != 2					
				//WHERE  a.payment_status = 2 OR a.buyer_status=1 OR a.seller_status=5					
				//WHERE (a.payment_status != 2 AND a.buyer_status=1) OR (a.payment_status != 2 AND a.seller_status=5) ".$last_append."	
				//WHERE (a.payment_status != 2 AND a.buyer_status=1) OR (a.payment_status != 2 AND (a.seller_status=5 OR a.seller_status=6)) 
									
        if($type==0){
             $result = $query->num_rows(); 
        }else { 
            $result = $query->result_array(); 
        } 
		
        return $result;                          
    }    
   /*   public function get_all_list($type, $start, $end)
    {
        $last_append = '';
        if($type==1)
        {
       // $last_append = " LIMIT $start , $end";   
        }
				$query_string ="SELECT a.*, s.fullname as buyer_name,s.email as buyer_email,sg.title,sm.email as selleremail, sm.fullname as seller_name,va.paypal_email_id as buyer_paybalemail,ba.paypal_email_id FROM  `payments`as a
                            LEFT JOIN bank_account as ba ON ba.user_id = a.USERID
                           
                            LEFT JOIN sell_gigs as sg ON sg.id = a.gigs_id
                            LEFT JOIN members as s ON s.USERID = a.USERID   
						    LEFT JOIN bank_account as va ON ba.user_id = s.USERID
                            LEFT JOIN members as sm ON sm.USERID = a.seller_id 
							WHERE  (a.payment_status = 1 OR a.cancel_accept = 1 OR a.decline_accept = 1) AND a.payment_status != 2 ".$last_append."";
			$query = $this->db->query($query_string);				
			// Where condition apply need request payment and cancel or decline 	
				//WHERE  (a.buyer_status=1 OR a.seller_status=5) AND a.payment_status != 2					
				//WHERE  a.payment_status = 2 OR a.buyer_status=1 OR a.seller_status=5					
				//WHERE (a.payment_status != 2 AND a.buyer_status=1) OR (a.payment_status != 2 AND a.seller_status=5) ".$last_append."	
				//WHERE (a.payment_status != 2 AND a.buyer_status=1) OR (a.payment_status != 2 AND (a.seller_status=5 OR a.seller_status=6)) 
									
        if($type==0){
             $result = $query->num_rows(); 
        }else { 
            $result = $query->result_array(); 
        } 
		
        return $result;                          
    }           */

     public function edit_payment_gateway($id)
    {
        $query = $this->db->query(" SELECT * FROM `payment_gateways` WHERE `id` = $id ");
        $result = $query->row_array();
        return $result;
    }

     public function all_payment_gateway()
    {
      $this->db->select('*');
        $this->db->from('payment_gateways');
        //$this->db->where('Id',$id);
        $query = $this->db->get();
        return $query->result_array();         
    } 

    public function gig_preview($id){

        $query = $this->db->query("SELECT * FROM  sell_gigs WHERE  md5(id) = '".$id."'");
        
        if($query->num_rows() > 0){
            $data = $query->row_array();
            $gig_id = $data['id'];
            $data['extra_gigs'] = array();
            $data['gig_images'] = array();

            $query1 = $this->db->query("SELECT * FROM  extra_gigs WHERE   gigs_id = $gig_id");
            if($query1->num_rows() > 0){
               $extra_gig = $query1->result_array(); 
               $data['extra_gigs'] = $extra_gig;
            }
            $query2 = $this->db->query("SELECT * FROM gigs_image WHERE   gig_id = $gig_id");
            if($query2->num_rows() > 0){
               $gig_images = $query2->result_array(); 
               $data['gig_images'] = $gig_images;
            }
            return $data;
        }else{
            return FALSE;
        }

    }
    public function smtp_setting() {
       $data = array();
       $stmt = "SELECT * FROM system_settings ORDER BY id ASC";
       $query = $this->db->query($stmt);
       if ($query->num_rows()) {
           $data = $query->result_array();
       }
       return $data;
   }
   
   
   public function get_subfeeling()
   {

     $query = $this->db->query("SELECT *, count(id) as total FROM feeling WHERE parrent!='' GROUP BY name");

      // var_dump($this->db->last_query());
      $result = $query->result_array();
      return $result; 


    }
    
}
?>