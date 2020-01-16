<?php 
class Gigs_model extends CI_Model{
	
	public function all_profession()
	{
		$query = $this->db->query(" SELECT * FROM  `profession` WHERE status = 0 ");
		$result = $query->result_array();
		return $result;		
	}
	
   
	public function purchase_completed($id)
	{
		$query = $this->db->query(" SELECT payments.*,sell_gigs.title,members.fullname,members.username,
									(SELECT `gig_image_thumb` FROM `gigs_image` WHERE `gig_id` = payments.`gigs_id` LIMIT 0 , 1 )as gig_image FROM `payments` 
									INNER JOIN sell_gigs ON sell_gigs.id = payments.`gigs_id`
									INNER JOIN members ON members.USERID = payments.seller_id
									WHERE payments.`id` = $id ");
		$result = $query->row_array();
		return $result;		
	}
	
	public function gig_purchase_requirements($id)
	{
		$query = $this->db->query("SELECT members.email , (members.fullname) as seller_name , (members.username) as seller_username , sell_gigs.`title`, payments.extra_gig_ref, payments.payment_super_fast_delivery, sell_gigs.super_fast_delivery_desc,
								   (SELECT (members.fullname)  
									FROM members WHERE USERID =  payments.`USERID` ) as buyer_name,(SELECT (members.username)  
									FROM members WHERE USERID =  payments.`USERID` ) as buyer_username  FROM `payments` 
									INNER JOIN sell_gigs ON sell_gigs.id = payments.`gigs_id`
									INNER JOIN members ON members.USERID = payments.`seller_id` 
									WHERE payments.`id` = $id ");
		$result = $query->row_array();								
		return $result ;
	}
    
	public function latest_gigs()
    {    
        $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`image_path` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
					WHERE sell_gigs.status = 0
                    ORDER BY sell_gigs.id DESC LIMIT 0 , 10 ");
        $result = $query->result_array();        
        return $result;
    }
	
    // public function recent_gigs($param='')
    // {       
         	
    //     $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
    //                 WHERE gigs_image.gig_id = sell_gigs.id
    //                 LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
				// 	(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
				// 	(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
    //                 LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
    //                 LEFT JOIN country ON members.`country` = country.id
    //                 LEFT JOIN states ON `states`.`state_id` = `members`.`state`
				// 	WHERE sell_gigs.status = 0 AND members.status = 0 GROUP BY id
    //                 ORDER BY sell_gigs.id DESC LIMIT 0, 10");

		
    //     if($param==1)
    //     {
    //     $result = $query->result_array();
    //     }
    //     else {
    //     $result = $query->num_rows();    
    //     } 
    //     return $result;
    // }
    
	public function super_fast_delivery($gig_id,$user_id)
	{
		$query = $this->db->query("SELECT * FROM `super_fast_delivery_option` WHERE `gig_id` = $gig_id AND `user_id` = $user_id ");
		$result = $query->row_array();
		return $result ;
	}
	
// 	public function popular_gigs($param='')
//     {       
         
//         $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
//                     WHERE gigs_image.gig_id = sell_gigs.id
//                     LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
// 					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
// 					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
//                     LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
//                     LEFT JOIN country ON members.`country` = country.id
//                     LEFT JOIN states ON `states`.`state_id` = `members`.`state`
// 					WHERE sell_gigs.status = 0 AND members.status = 0
//                     ORDER BY sell_gigs.total_views DESC LIMIT 0 , 10  ");
//         if($param==1)
//         {
//         $result = $query->result_array();
//         }
//         else {
//         $result = $query->num_rows();    
//         } 
       
//         return $result;
//     }
	
	public function extra_gig_calculations($gig_id)
	{
		$query = $this->db->query("SELECT `title`,`gig_price`,currency_type,( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) as gig_image  FROM `sell_gigs` WHERE `id` = $gig_id ");
		$result = $query->row_array();
		return $result;														
		
	}
	
    public function get_setting_price_option(){
     
     $query = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'price_option' ");
     $result = $query->row_array();
     return $result;   
    }

    public function gig_price()
    {
        $query = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'gig_price' ");
        $result = $query->row_array();
        return $result;
    }

    public function rejected_request($input)
    {
        $result = $this->db->insert('buyer_rejected_list',$input);

        //$insert_id = $this->db->insert_id(); //print_r($insert_id);exit;

        //echo$this->db->last_query();exit;
        return $result;
    }

    public function request_rejected($list_id,$gig_id)
    {

       $request = $this->db->query("SELECT b.*,m1.username as buyer_name,m1.email as buyer_email, a.name as admin_name,a.email as admin_email,m.username as seller_name from buyer_rejected_list b
                                LEFT JOIN members m on m.USERID = b.seller_id 
                                LEFT JOIN members m1 on m1.USERID = b.buyer_id 
                                LEFT JOIN sell_gigs s on s.id = b.order_id 
                                LEFT JOIN administrators a on a.ADMINID = 1
                                WHERE b.id = $list_id");
        $result = $request->row_array();
        return $result;
    }
    
    public function extra_gig_price()
    {
        $query = $this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'extra_gig_price' ");
        $result = $query->row_array();
        return $result;
    }
    
    
    
    public function get_user_visited_gigs($user_id)
    {
        $query = $this->db->query("SELECT `gig_id` FROM `last_visited` WHERE `user_id` =  $user_id ");
        $result = $query->result_array();
        return $result;
    }
    
    public function last_visited($user_id,$return_type,$start,$end)
    {
        $append_sql = "";
         if($start>0||$end>0)
         { $append_sql = " LIMIT $start , $end"; }
        $query= $this->db->query(" SELECT sell_gigs.*,members.`fullname`,members.`username`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE sell_gigs.status = 0  AND members.status = 0 AND sell_gigs.id IN ( SELECT `gig_id` FROM `last_visited` WHERE `user_id` = $user_id ORDER BY  `last_visited`.`created_date` DESC  )".$append_sql." ");        
        if($return_type==0)
        { $result = $query->num_rows(); }
        else { $result = $query->result_array(); }        
        return $result;
        
    }
    
    public function reminder($user_id,$return_type,$start,$end)
    {
         $append_sql = "";
         if($start>0||$end>0)
         { $append_sql = " LIMIT $start , $end"; }
        $query= $this->db->query("SELECT sell_gigs.*,members.`fullname`,members.`username`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE sell_gigs.status = 0  AND members.status = 0 AND sell_gigs.id IN ( SELECT `gig_id` FROM `favourites` WHERE `user_id` = $user_id )".$append_sql." ");
        
        if($return_type==0)
        { $result = $query->num_rows(); }
        else { $result = $query->result_array(); }        
        return $result;
    }
    
     public function location_base_gigs($full_country_name,$param,$start,$end)
    {        
         $full_country_name = str_replace("_"," ",$full_country_name);
         $append_sql = "";
         if($start>0||$end>0)
         { $append_sql = " LIMIT $start , $end"; }
        $query = $this->db->query("SELECT sell_gigs.*,members.`fullname`,members.`username`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`image_path` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE sell_gigs.country_name = '$full_country_name'
					AND sell_gigs.status = 0
                    ORDER BY sell_gigs.id ASC" .$append_sql. " ;");
        if($param==1)
        {
        $result = $query->result_array();
        }
        else {
        $result = $query->num_rows();    
        }     
        return $result;                          
    }
    
    public function username_base_gigs($username,$param,$start,$end)
    {             
         $append_sql = "";
         if($start>0||$end>0)
         { $append_sql = " LIMIT $start , $end"; }
        $query = $this->db->query("SELECT sell_gigs.*,members.`fullname`,members.`username`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE members.`username` = '$username'
					AND sell_gigs.status = 0
                    ORDER BY sell_gigs.id ASC" .$append_sql. " ;");
		 //echo 	$this->db->last_query().'<br>';
			 
        if($param==1)
        {
        $result = $query->result_array();
        }
        else {
        $result = $query->num_rows();    
        }     
        return $result;                          
    }
    
    public function profile($username)
    {
        $query = $this->db->query("SELECT * FROM `members` WHERE `username` = '".$username."' AND `verified` = 0 AND `status` = 0 ;");
        $result = $query->row_array();
        return $result;          
    }
    
    
    
//     public function add_favourites()
//     {
//         $user_id = $this->session->userdata('SESSION_USER_ID');
// 		$result='';
// 		if(!empty($user_id))
// 		{
//         $query = $this->db->query("SELECT * FROM `favourites` WHERE `user_id` = $user_id LIMIT 0, 10");
//         $result = $query->result_array();
// 		}
    //     return $result;
    // }
    
    public function buy_service($param,$start,$end,$userid)
    {
        $append_sql = '';
		$new='';
		
		if($userid !='')
		{
			$new ="and user_id!=$userid";  	
		}
        if($start||$end != 0)
        {
        $append_sql = " LIMIT $start , $end ";    
        }
        $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`    
					WHERE sell_gigs.status = 0 ".$new."   AND sell_gigs.user_id not in (select USERID from members where  status=1)            
                    ORDER BY sell_gigs.id DESC ".$append_sql."" );
	 
        if($param==1)
        {
        $result = $query->result_array();
		 
        }
        else {
        $result = $query->num_rows(); 
		 
        } 
		
        return $result;
        
    }
    
     public function category_base_gigs($category_name,$param,$start,$end)
    {        
         $category_name = str_replace("_"," ",$category_name);
         $append_sql = "";
         if($start>0||$end>0)
         { $append_sql = " LIMIT $start , $end"; }
            $query = $this->db->query("SELECT sell_gigs.*,members.`fullname`,members.`username`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                        WHERE gigs_image.gig_id = sell_gigs.id
                        LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
						(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
						(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                        LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                        LEFT JOIN country ON members.`country` = country.id
                        LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                        WHERE sell_gigs.status = 0 AND 
						sell_gigs.category_id = (SELECT `CATID` FROM `categories` WHERE `name` = '$category_name' AND `status` = 0) AND sell_gigs.user_id not in (select USERID from members where  status=1)  
                        ORDER BY sell_gigs.id DESC" .$append_sql. " ;");
        if($param==1)
        {
        $result = $query->result_array();
        }
        else {
        $result = $query->num_rows();    
        }     
        return $result;                          
    }
     public function get_gig_details($title)
    {
        $title = str_replace(" ","_",$title);
        $query = $this->db->query("SELECT  sell_gigs.*,members.`fullname`, members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , country.country ,   `states`.`state_name` , members.`state`,
                    categories.name,categories.parent , GROUP_CONCAT(gigs_image.image_path SEPARATOR '#') as image_path ,
                    GROUP_CONCAT(gigs_video.video_path SEPARATOR '#') as video_path 
                    FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN categories ON categories.CATID = sell_gigs.category_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    LEFT JOIN gigs_image ON gigs_image.gig_id = sell_gigs.id
                    LEFT JOIN gigs_video ON gigs_video.gig_id = sell_gigs.id
					WHERE sell_gigs.status = 0 AND sell_gigs.user_id not in (select USERID from members where  status=1)  
                    AND sell_gigs.title =  '$title';");
        $result = $query->row_array(); 
        return $result;       
    }
    
    public function search_gig_details($title)
    {
        //$title = str_replace(" ","_",$title);
        $query = $this->db->query("SELECT  sell_gigs.*,members.`fullname`, `members`.`user_thumb_image`,`members`.`user_profile_image` , country.country ,   `states`.`state_name` , members.`state`,
                    categories.name,categories.parent , GROUP_CONCAT(gigs_image.image_path SEPARATOR '#') as image_path 
                    FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN categories ON categories.CATID = sell_gigs.category_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    LEFT JOIN gigs_image ON gigs_image.gig_id = sell_gigs.id
					WHERE sell_gigs.status = 0 AND sell_gigs.user_id not in (select USERID from members where  status=1)  
                    AND sell_gigs.title LIKE '%$title%';");
        $result = $query->row_array();
        return $result;       
    }
    
    public function user_all_gigs($gig_id,$user_id)
    {
        $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`, `members`.username, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` ,( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , ( SELECT gigs_image.`gig_image_tile` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image_tile , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE sell_gigs.user_id = $user_id AND sell_gigs.id != $gig_id AND sell_gigs.user_id not in (select USERID from members where  status=1)  
					AND sell_gigs.status = 0
                    ORDER BY sell_gigs.id DESC ");
        $result =  $query->result_array();    
        return $result;
    }
    
    public function category_based_gigs($cat_id,$title='')
    {
        $append_sql = "";
        if(!empty($title))
        {
        $append_sql = " AND `title` != '$title'";    
        }
        $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , ( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image_thumb , ( SELECT gigs_image.`gig_image_tile` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image_tile , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE sell_gigs.category_id = $cat_id AND sell_gigs.status = 0 " .$append_sql. "
					
                    ORDER BY sell_gigs.id DESC ");
        $result =  $query->result_array();
        return $result;
    }
	
	
	
	public function similar_gigs($cat_id,$title='')
    {
        $append_sql = "";
        if(!empty($title))
        {
        $append_sql = " AND `title` != '$title'";    
        }
        $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`image_path` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , ( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image_thumb , ( SELECT gigs_image.`gig_image_tile` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image_tile , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE sell_gigs.category_id = $cat_id AND sell_gigs.status = 0 " .$append_sql. "					
                    ORDER BY sell_gigs.id DESC LIMIT 0 , 3 ");
        $result =  $query->result_array();
        return $result;
    }
	
	public function gig_basic_details($title)
	{
		$query  = $this->db->query("SELECT * FROM `sell_gigs` WHERE `title` = '$title' ");
		$result = $query->row_array();
		return $result;
	}

     public function gig_rejected($gig_id)

    {

        $query  = $this->db->query("SELECT * FROM `sell_gigs` WHERE `id` = '".$gig_id."' ");

        $result = $query->row_array();

        return $result;

    }

    public function gig_rejected_details($order_id)

    {

        $query  = $this->db->query("SELECT * FROM `sell_gigs` WHERE `id` = '".$order_id."' ");

        $result = $query->row_array();

        return $result;

    }
	
	public function extra_gig_details($id)
	{
		$user_id = $this->session->userdata('SESSION_USER_ID');
		$query  = $this->db->query(" SELECT * FROM `extra_gigs`  WHERE  `gigs_id` = $id ");
		$result = $query->result_array();
		return $result;		
	}
	
	public function gig_image_details($id)
	{
            
		$user_id = $this->session->userdata('SESSION_USER_ID');
		$query  = $this->db->query("SELECT * FROM `gigs_image` WHERE `gig_id` = $id ");
		$result = $query->result_array();
		return $result;		
	}
	
	public function gig_video_details($id)
	{
		$query  = $this->db->query("SELECT * FROM `gigs_video` WHERE `gig_id`  = $id ");
		$result = $query->result_array();
		return $result;		
	}
	
    
    public function common_search($cat_id,$title,$start,$end,$return_type)
    {
        $append_sql = '';
        if($cat_id!='')
        {
        $append_sql = " AND sell_gigs.category_id = $cat_id ";
        }
        $last_append = '';
        if($start||$end!=0)
        {
        $last_append = " LIMIT $start , $end";   
        }
        $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`image_path` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE sell_gigs.`title` LIKE '%$title%' AND sell_gigs.status = 0 ".$append_sql."
                    ORDER BY sell_gigs.id DESC ".$last_append." ");
        if($return_type==0)
        {
        $result =  $query->num_rows();    
        } else {
        $result =  $query->result_array();
        }
        return $result;       
    }
    
    public function common_search_category($cat_id,$start,$end,$return_type)
    {        
        $last_append = '';
        if($start||$end!=0)
        {
        $last_append = " LIMIT $start , $end";   
        }
        $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE sell_gigs.category_id = $cat_id
					AND sell_gigs.status = 0
                    ORDER BY sell_gigs.id DESC ".$last_append." ");
        if($return_type==0)
        {
        $result =  $query->num_rows();    
        } else {
        $result =  $query->result_array();
        }
        return $result;       
    }
    
    
    public function my_gigs($return_type,$user_id,$start,$end)
    {        
        $last_append = '';
        if($start||$end!=0)
        {
        $last_append = " LIMIT $start , $end";   
        }
        $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`, `members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
                    WHERE members.USERID =  $user_id
					AND sell_gigs.status = 0
                    ORDER BY sell_gigs.id DESC ".$last_append." ");
        if($return_type==0)
        {
        $result =  $query->num_rows();    
        } else {
        $result =  $query->result_array();
        }
        return $result;       
    }
    
    public function gigs_feedbacks($gig_id,$user_id)
    {
        $query = $this->db->query("SELECT feedback.*,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`
                    left join members on members.USERID = feedback.`from_user_id`
                    WHERE feedback.`gig_id` = $gig_id AND from_user_id != $user_id AND feedback.`status` = 1 ");
        $result =  $query->result_array();
        return $result;         
    }
	public function more_gigs_feedbacks($gig_id,$user_id,$start,$limit)
    {
		$limit_cond = " LIMIT " . (int) $start . ", " . (int) $limit;
        $query = $this->db->query("SELECT feedback.*,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`
                    left join members on members.USERID = feedback.`from_user_id`
                    WHERE feedback.`gig_id` = $gig_id AND from_user_id != $user_id AND feedback.`status` = 1 ".$limit_cond);
        $result =  $query->result_array();
        return $result;         
    }
    
	public function getRows($id = ''){
        $this->db->select('*');
        $this->db->from('payments');
        if($id){
            $this->db->where('id',$id);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            $this->db->order_by('name','asc');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return !empty($result)?$result:false;
    }
    // public function gigs_country(){
    //     $query = $this->db->query("SELECT id,country FROM country WHERE id in (SELECT DISTINCT(country) as country_id  FROM members)");
    //     return $query->result_array();
    // }
    public function gigs_state($country_id){
        if(!empty($country_id) && ($country_id!=0)){
            $query = $this->db->query("SELECT state_id as id ,state_name as state FROM states WHERE country_id = $country_id");
            $records =  $query->result_array();    
            return $records;
        }else{
            return array();
        }
    }

      public function settings(){
       
        $this->db->select('key, value');
        $this->db->from('system_settings');
        $records = $this->db->get()->result_array();
        $array = array();
         foreach ($records as $value) {
            if($value['key']=='one_signal_subdomain'){
                $array['one_signal_subdomain'] = $value['value'];
            }
            if($value['key']=='one_signal_app_id'){
                $array['one_signal_app_id']  = $value['value'];
            }
            if($value['key']=='one_signal_reset_key'){
              $array['one_signal_reset_key'] = $value['value'];
            }
          }
        return $array;  
    }

    public function save_device_id($data){
      
    $user_id = $data['user_id'];
     $device_id = $data['device_id'];
    $this->db->select('id');
    $this->db->from('one_signal_device_ids');
    $this->db->where('user_id',$user_id);
     $this->db->or_where('device_id',$device_id);
    $records = $this->db->count_all_results();
    if($records == 0){
      $result = $this->db->insert('one_signal_device_ids', $data);
      if($result){
        return 1;
      }
    }else{
        $this->db->where('user_id', $user_id);
      $result = $this->db->update('one_signal_device_ids', $data);
      if($result){
        return 1;
      }
    }
    return 0;
   }
    
}   
?>