<?php 
class User_panel_model extends CI_Model{
    
    //  public function policy_setting()
    // {
    //     $query = $this->db->query("SELECT * FROM `policy_settings` WHERE `status` = 0 ");
    //     $result = $query->result_array();
    //     return $result;                  
    // }
    
    public function profile($user_id)
    {
        $query = $this->db->query("SELECT members.*,(SELECT `profession_name` FROM `profession` WHERE id = members.profession ) as profession_name FROM `members` WHERE `USERID` = $user_id AND `verified` = 0 AND `status` = 0 ");
        $result = $query->row_array();
        return $result;          
    }
   
    //  public function country()
    // {   
    //     $query = $this->db->query("SELECT * FROM `country` WHERE `status` = 1 ");
    //     $result = $query->result_array();
    //     return $result;                  
    // }
    
    public function check_username($username)
    {        
        $query = $this->db->query("SELECT * FROM `members` WHERE `username` = '$username'");
        $result = $query->num_rows();
        return $result;          
    }
    public function check_email($email)
    {        
        $query = $this->db->query("SELECT * FROM `members` WHERE `email` = '$email'");
 
        $result = $query->num_rows();
        return $result;          
    }   
    public function get_client_list()
    {
        $query = $this->db->query("SELECT * FROM `client` WHERE `status` = 0 ;");
        $result = $query->result_array();
        return $result;                  
    }
     public function categories()
    {
        $query = $this->db->query(" SELECT * FROM `categories` WHERE `status` = 0 AND parent = 0 AND delete_sts =0 ");
        $result = $query->result_array();
        return $result;        
    }
    // public function categories_subcategories()
    // {
    //     $query = $this->db->query(" SELECT * FROM `categories` WHERE `status` = 0 AND delete_sts =0 ");
    //     $result = $query->result_array();
    //     return $result;        
    // }
    public function get_logo()
    {
        $query = $this->db->query("SELECT * FROM `system_settings` WHERE `key` = 'logo_front' ");
        $result = $query->row_array();
        return $result;                
    }
    public function get_slogan()
    {
        $query = $this->db->query("SELECT * FROM `system_settings` WHERE `key` = 'website_slogan' ");
        $result = $query->row_array();
        return $result;                
    }
    // public function footer_main_menu()
    // {
    //     $query = $this->db->query(" SELECT * FROM `footer_menu` WHERE `status` =  1 ");
    //     $result = $query->result_array();
    //     return $result;        
    // }
    // public function footer_sub_menu()
    

    // {
    //     $query = $this->db->query(" SELECT * FROM `footer_submenu` WHERE `status` = 1  ");
    //     $result = $query->result_array();
    //     return $result;        
    // }
    public function system_setting()    
    {
        $query = $this->db->query("SELECT * FROM `system_settings`");
        $result = $query->result_array();
        return $result;        
    }


    public function deleteuser($id)
{
    $this->load->database();
    $this->db->where('id' , $id);
    $this->db->delete('user');
    return true;

}

public function addcountry($id)
{
    $this->load->database();
    // $this->db->where('id' , $id);
    $this->db->add('country');
    return true;

}



     public function get_user_data($id) {
		 $st= ("SELECT a.*,cu.country,cu.sortname,st.state_name 
			 FROM `members` a
			 left join country cu on cu.id = a.country
			 left join states st on st.state_id = a.state
			 where a.USERID = ".$id." ");
		
		$query = $this->db->query($st);							 
         if ($query->num_rows()) {
               return $query->row_array();
         }
         return false;
    }
  
   /*public function UpdateCurrentCuuencyRate(){
	   
	   $query  = $this->db->query("SELECT * FROM `currency` ORDER BY `created_date` DESC LIMIT 0 , 1 ;");
	   $result = $query->row_array();		 
	  
	if(!empty($result))
		{
			$last_inserted_date = date('Y-m-d',strtotime($result['created_date']));
			$current_date = date('Y-m-d');
			if($current_date!=$last_inserted_date)
			{
			$from   = 'USD'; 
			$to     = 'INR';
			$url    = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='. $from . $to .'=X';
			
			$handle = fopen($url, 'r');			
			if ($handle) 
			{
				$result = fgets($handle, 4096);
				fclose($handle);
			}			
			$allData 	 			= explode(',',$result); 
			$data['dollar_rate'] 	= $allData[1];
			$data['indian_rate']  	= (1 / $data['dollar_rate']);		
			$this->db->insert('currency',$data);	
			}
		}
		else
			{
				$from   = 'USD'; 
				$to     = 'INR';
				$url    = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s='. $from . $to .'=X';
				$handle = fopen($url, 'r');			
				if ($handle) 
				{
					$result = fgets($handle, 4096);
					fclose($handle);
				}			
				$allData 	 			= explode(',',$result); 
				$data['dollar_rate'] 	= $allData[1];
				$data['indian_rate']  	= (1 / $data['dollar_rate']);		
				$this->db->insert('currency',$data);				
			}
   }  */
   
    
}
?>