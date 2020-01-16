<?php 
class Search_model extends CI_Model{
public function category_wise_search($id)
{
	 $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , categories.name as category_name , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs`
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
					LEFT JOIN categories ON categories.`CATID` = sell_gigs.category_id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
					WHERE sell_gigs.status = 0 AND members.status = 0 
					AND sell_gigs.category_id = $id
                    ORDER BY sell_gigs.id DESC ");
	$result = $query->result_array();
	return $result ;			
}


public function get_subcategory_list($id)
{
	$query = $this->db->query("SELECT GROUP_CONCAT(`CATID`) AS category_id FROM `categories` WHERE `parent` = $id AND status = 0");
	$result = $query->row_array();
	return $result;
}

public function get_category_name($id)
{
	$query = $this->db->query("SELECT name FROM `categories` WHERE `CATID` =  $id ");
	$result = $query->row_array();
	return $result;
}

public function get_category_id($name)
{
	$query = $this->db->query("SELECT `CATID` FROM `categories` WHERE name = '$name' ");
	$result = $query->row_array();
	return $result;
}

public function get_parent_details($id)
{
	$query = $this->db->query(" SELECT `parent` FROM `categories` WHERE `CATID` =  $id ");
	$result = $query->row_array();
	return $result;	
}

public function search_subcategory_total($id)
{ 
	$query = $this->db->query("SELECT GROUP_CONCAT(`CATID`) AS category_id FROM `categories` WHERE `parent` = $id AND status = 0");
	$result = $query->row_array();
	$subcategory_total_rows  = $this->db->query("SELECT * FROM `sell_gigs` WHERE `status` = 0 AND `category_id` = $id ");
	if($result['category_id']!='')
	{
	$subcategory_total_rows  = $this->db->query("SELECT * FROM `sell_gigs` WHERE `status` = 0 AND `category_id` IN (".$result['category_id']." , ".$id.")");  	
	}	 
	$total_rows = $subcategory_total_rows->num_rows();
	return $total_rows;
}

public function search_subcategory_details($id,$start,$end)
{
	
	$query = $this->db->query("SELECT GROUP_CONCAT(`CATID`) AS category_id FROM `categories` WHERE `parent` = $id AND status = 0");
	$result = $query->row_array();	 
	$append_sql = " = $id ";
	if($result['category_id']!='')
	{
		$append_sql = "IN (".$result['category_id'].",".$id.")";
	}
	$subcategory_list  = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , categories.name as category_name , ( SELECT gigs_image.`image_path` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs`
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
					LEFT JOIN categories ON categories.`CATID` = sell_gigs.category_id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
					WHERE sell_gigs.status = 0 AND members.status = 0 
					AND sell_gigs.category_id  ".$append_sql."
                    ORDER BY sell_gigs.id DESC LIMIT $start , $end ");  	
	$total_rows = $subcategory_list->result_array();
	return $total_rows;
}


public function search_subcategory_details_list($value,$id,$start,$end)
{
	$append_sql = '';
	if(!empty($value))
	{
		$append_sql = "AND sell_gigs.title LIKE '%".str_replace("-"," ",$value)."%' ";
	}
	
	$query = $this->db->query("SELECT GROUP_CONCAT(`CATID`) AS category_id FROM `categories` WHERE `parent` = $id AND status = 0");
	$result = $query->row_array();
	$subcategory_list  = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , categories.name as category_name , ( SELECT gigs_image.`image_path` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs`
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
					LEFT JOIN categories ON categories.`CATID` = sell_gigs.category_id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
					WHERE sell_gigs.status = 0 AND members.status = 0 
					".$append_sql."
					AND sell_gigs.category_id IN (".$result['category_id']." , ".$id.")
                    ORDER BY sell_gigs.id DESC LIMIT $start , $end ");  	
	$total_rows = $subcategory_list->result_array();
	return $total_rows;
}


public function category_search($value,$start,$end)
{
	$append_sql = '';
	if(!empty($value))
	{
		$append_sql = "AND sell_gigs.category_id = $value ";
	}
	 
	
	
		 $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , categories.name as category_name , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs`
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
					LEFT JOIN categories ON categories.`CATID` = sell_gigs.category_id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
					WHERE sell_gigs.status = 0 AND members.status = 0 
					".$append_sql." 
                    ORDER BY sell_gigs.id DESC LIMIT $start , $end ");
	$result = $query->result_array();
	return $result ;			
	
}



public function tags_search($value,$start,$end)
{
	$append_sql = '';
	if(!empty($value))
	{
		$append_sql = "AND sell_gigs.gig_tags LIKE '%".$value."%' ";
	}
	 
	
	
		 $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , categories.name as category_name , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs`
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
					LEFT JOIN categories ON categories.`CATID` = sell_gigs.category_id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
					WHERE sell_gigs.status = 0 AND members.status = 0 
					".$append_sql." 
                    ORDER BY sell_gigs.id DESC LIMIT $start , $end ");
	$result = $query->result_array();
	return $result ;			
	
}








public function search($value,$category_id,$start,$end,$country_id,$state_id)
{
	$append_sql = '';
	if(!empty($value))
	{
		$append_sql = "AND sell_gigs.title LIKE '%".str_replace(" ","-",$value)."%' ";		
	}
	if($category_id!=0)
	{
		$append_sql .= " AND sell_gigs.category_id =". $category_id ;
	}
	if($country_id!=0)
	{
		$append_sql .= " AND members.country =". $country_id ;
	}
	if($state_id!=0)
	{
		$append_sql .= " AND members.state =". $state_id ;
	}
	
	
		 $query = $this->db->query("  SELECT sell_gigs.*,members.`fullname`,members.`username`,`members`.`user_thumb_image`,`members`.`user_profile_image` , `states`.`state_name` , categories.name as category_name , ( SELECT gigs_image.`gig_image_medium` FROM `gigs_image` 
                    WHERE gigs_image.gig_id = sell_gigs.id
                    LIMIT 0 , 1  ) AS gig_image , country.country , members.`state`,
					(SELECT count(id) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_usercount,
					(SELECT AVG(rating) FROM `feedback` WHERE `gig_id` = sell_gigs.id and to_user_id = sell_gigs.user_id) AS gig_rating FROM `sell_gigs` 
                    LEFT JOIN members ON members.`USERID` = sell_gigs.user_id
                    LEFT JOIN country ON members.`country` = country.id
					LEFT JOIN categories ON categories.`CATID` = sell_gigs.category_id
                    LEFT JOIN states ON `states`.`state_id` = `members`.`state`
					WHERE sell_gigs.status = 0 AND members.status = 0 
					".$append_sql." 
                    ORDER BY sell_gigs.id DESC LIMIT $start , $end ");
	$result = $query->result_array();
	return $result ;			
	
}

 public function location_base_gigs($full_country_name,$start,$end)
    {        
         $full_country_name = str_replace("_"," ",$full_country_name);
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
                    WHERE sell_gigs.country_name = '$full_country_name'
					AND sell_gigs.status = 0 AND members.status = 0 
                    ORDER BY sell_gigs.id ASC" .$append_sql. " ;");
        
        $result = $query->result_array();
		return $result;
                                
    }
	
	 public function recent_gigs($start,$end)
    {
        $append_sql = '';
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
					WHERE sell_gigs.status = 0                
                    ORDER BY sell_gigs.id DESC ".$append_sql."" );

        $result = $query->result_array();
        
        return $result;
        
    }
	
	

} 
?>