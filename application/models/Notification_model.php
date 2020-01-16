<?php 
Class Notification_model extends CI_Model{
    
    public function new_notification_count()
	{
		
		$user_id = (int)$this->session->userdata('SESSION_USER_ID');
		if($user_id > 0){
			
			$query_string = "SELECT * FROM 
		(SELECT payments.id, `members`.`fullname` AS buyer_name, `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date ,  `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.notification_status =1
			AND payments.buyer_status =0
			AND payments.`seller_id` = $user_id
			
			
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.notification_status =1
			AND payments.`USERID` = $user_id
            
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'complete-request-accept' as status
			, payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.notification_status =1
			AND payments.`seller_id` = $user_id
            
			
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completedrequest' as status
			, payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 7
			AND payments.notification_status =1
			AND payments.`USERID` = $user_id
			
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.created_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'own_buying' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =1
			AND payments.notification_status =1
			AND payments.`USERID` = $user_id
			
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.created_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'payment_release' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =6
			AND payments.notification_paycomplete =1
			AND payments.payment_status =2
			AND payments.`seller_id` = $user_id
			
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.created_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_cancel_payment' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.cancel_accept =1
			AND payments.payment_status =2
			AND payments.notification_status =1
			AND payments.`USERID` = $user_id
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.created_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_decline_payment' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.decline_accept =1
			AND payments.payment_status =2
			AND payments.notification_status =1
			AND payments.`USERID` = $user_id
			
			UNION
			SELECT payments.id,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.canceled_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_cancel' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.buyer_status =1
			AND payments.cancel_accept =0
			AND payments.cancel_notification_status =1
			AND payments.`seller_id` = $user_id
			
			
			UNION
			SELECT payments.id,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'seller_cancel' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =5
			AND payments.decline_accept =0
			AND payments.cancel_notification_status =1
			AND payments.`USERID` = $user_id
			
			
			
			UNION	
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'seller_cancelled' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =1
			AND payments.cancel_accept = 1
			AND payments.notification_status =1
			AND payments.USERID = $user_id  
			
			
			UNION
			SELECT payments.id,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_cancelled' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =5
			AND payments.decline_accept =1
			AND payments.cancel_notification_status =1
			AND payments.`USERID` = $user_id
			
			
			UNION	
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_accept_seller_declined' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =5
			AND payments.decline_accept	 = 1
			AND payments.notification_status =1
			AND payments.seller_id = $user_id  	
			
			UNION	
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_cancel_payment' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =1
			AND payments.cancel_accept = 1
			AND payments.notification_status !=2
			AND payments.pay_status='Payment Processed'
			AND payments.USERID = $user_id  	
			
			UNION	
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_decline_payment' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =5
			AND payments.decline_accept	 = 1
			AND payments.notification_status !=2
			AND payments.pay_status='Payment Processed'
			AND payments.USERID = $user_id  	
			
			 
			UNION 
			SELECT feedback.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, feedback.created_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'from_user' AS 
			STATUS , feedback.notification_status
			FROM  `feedback` 
			INNER JOIN members ON members.`USERID` =  `feedback`.`from_user_id` 
			INNER JOIN sell_gigs ON feedback.`gig_id` = sell_gigs.id
			WHERE feedback.notification_status =1
			AND feedback.`to_user_id` = $user_id	

			) a ORDER BY a.created_date DESC ";
			 
			$query = $this->db->query($query_string); 
			$result = $query->result_array();
			//echo $this->db->last_query();
	 		return $result;  
		}else{
			return '';
		}
		
				
				
	}
	
	/*
	
		
		UNION 
			SELECT feedback.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, feedback.created_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'from_user' AS 
			STATUS , feedback.notification_status
			FROM  `feedback` 
			INNER JOIN members ON members.`USERID` =  `feedback`.`from_user_id` 
			INNER JOIN sell_gigs ON feedback.`gig_id` = sell_gigs.id
			WHERE feedback.notification_status =1
			AND feedback.`to_user_id` = $user_id	

		
		
	





	*/
	
	
	
    public function new_notification()
	{
	
		$user_id = $this->session->userdata('SESSION_USER_ID');   
		$query = $this->db->query("SELECT * FROM (SELECT  `members`.`fullname` AS buyer_name, `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date ,  `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.notification_status = 1
			AND payments.`seller_id` = $user_id
			UNION
			SELECT  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.notification_status = 1
			AND payments.`seller_id` = $user_id
			UNION
			SELECT  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'admin_payment' as status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.payment_status = 2
			AND payments.notification_status = 1
			AND payments.`seller_id` = $user_id
			UNION
			SELECT  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , feedback.created_date as created_date,  `members`.`username` AS buyer_username, sell_gigs.title , 'to_user' as status
			FROM  `feedback` 
			INNER JOIN members ON members.`USERID` =  `feedback`.`from_user_id` 
			INNER JOIN sell_gigs ON feedback.`gig_id` = sell_gigs.id
			WHERE feedback.status = 1
			AND feedback.notification_status = 1
			AND feedback.`to_user_id` = $user_id
			

			
		
			UNION	
			SELECT `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'seller_cancelled' AS 
			STATUS 
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =1
			AND payments.cancel_accept = 1
			AND payments.notification_status !=2
			AND payments.USERID = $user_id  
			


			) a ORDER BY a.created_date DESC  ");
		$result = $query->result_array();
		return $result;    
	}
	
	public function extra_gig_mail($title)	
	{
		$query = $this->Db->query(" SELECT py.*,sg.title,sg.user_id,gi.gig_image_thumb,m.fullname,m.username FROM `payments` as py
	        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id	
			LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id	  
            LEFT JOIN members as m ON m.USERID = py.USERID
			WHERE sg.title = '$title' AND seller_status=6 GROUP BY sg.id");
		$result = $query->row_array();
		return $result;	
	}
	
	
    public function notification_all_gigs()
	{
	
		$user_id = $this->session->userdata('SESSION_USER_ID');
		$query = $this->db->query("SELECT * FROM (SELECT payments.id, `members`.`fullname` AS buyer_name, `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date ,  `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
			, payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 1
			AND payments.notification_status !=2
			AND payments.`seller_id` = $user_id
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
			, payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status = 6
			AND payments.notification_status !=2
			AND payments.`seller_id` = $user_id
			UNION
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.created_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'own_buying' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =1
			AND payments.notification_status !=2
			AND payments.`USERID` = $user_id
			
			UNION 
			SELECT feedback.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, feedback.created_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'from_user' AS 
			STATUS , feedback.notification_status
			FROM  `feedback` 
			INNER JOIN members ON members.`USERID` =  `feedback`.`from_user_id` 
			INNER JOIN sell_gigs ON feedback.`gig_id` = sell_gigs.id
			WHERE feedback.notification_status !=2
			AND feedback.`to_user_id` = $user_id
			
			UNION 
				SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'seller_cancel' AS 
				STATUS , payments.notification_status
				FROM  `payments` 
				INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
				INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
				WHERE payments.seller_status =7
				AND payments.decline_accept =0
				AND payments.notification_status !=2
				AND payments.`USERID` = $user_id
		
			UNION	
			SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'seller_cancelled' AS 
			STATUS , payments.notification_status
			FROM  `payments` 
			INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
			INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
			WHERE payments.seller_status =1
			AND payments.cancel_accept = 1
			AND payments.notification_status !=2
			AND payments.USERID = $user_id  
			
			
			
			) a ORDER BY a.created_date DESC LIMIT 0 , 15 ");    
		$result = $query->result_array();
		return $result; 
				
				
	}
    public function all_gigs()
    {  
    $user_id = $this->session->userdata('SESSION_USER_ID');
	
    $query = $this->db->query("SELECT * FROM (SELECT payments.id, payments.time_zone, `members`.`fullname` AS buyer_name, `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date ,  `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
		, payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status = 1
		AND payments.notification_status !=2
		AND payments.buyer_status =0
		AND payments.`seller_id` = $user_id
		UNION
		SELECT payments.id, payments.time_zone, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
		, payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status = 6
		AND payments.notification_status !=2
		AND payments.`USERID` = $user_id
		UNION
		SELECT payments.id, payments.time_zone, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'complete-request-accept' as status
		, payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status = 6
		AND payments.notification_status !=2
		AND payments.`seller_id` = $user_id
		UNION
		SELECT payments.id, payments.time_zone, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completedrequest' as status
		, payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status = 7
		AND payments.notification_status !=2
		AND payments.`USERID` = $user_id
		UNION
		SELECT payments.id, payments.time_zone, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.created_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'own_buying' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status =1
		AND payments.notification_status !=2
		AND payments.`USERID` = $user_id
		UNION
		SELECT payments.id, payments.time_zone, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.created_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'payment_release' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status =6
		AND payments.payment_status =2
		AND payments.notification_status !=2
		AND payments.`seller_id` = $user_id
		UNION
		SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.canceled_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_cancel' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.buyer_status =1
		AND payments.cancel_accept =0
		AND payments.notification_status !=2
		AND payments.`seller_id` = $user_id
		UNION
		SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'seller_cancel' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status =5
		AND payments.decline_accept =0
		AND payments.notification_status !=2
		AND payments.`USERID` = $user_id
		UNION
		SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_accept_seller_declined' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status =5
		AND payments.decline_accept =1
		AND payments.notification_status !=2
		AND payments.`seller_id` = $user_id
		
		UNION
		SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_cancel_payment' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status =1
		AND payments.cancel_accept =1
		AND payments.pay_status ='Payment Processed'
		AND payments.`USERID` = $user_id
		
		UNION
		SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'buyer_decline_payment' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status =5
		AND payments.decline_accept =1
		AND payments.pay_status ='Payment Processed'
		AND payments.`USERID` = $user_id
		
		UNION 
		SELECT feedback.id, feedback.time_zone, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, feedback.created_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'from_user' AS 
		STATUS , feedback.notification_status
		FROM  `feedback` 
		INNER JOIN members ON members.`USERID` =  `feedback`.`from_user_id` 
		INNER JOIN sell_gigs ON feedback.`gig_id` = sell_gigs.id
		WHERE feedback.notification_status !=2
		AND feedback.`to_user_id` = $user_id
		
		UNION
		SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'cancel_payment_received' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		AND payments.cancel_accept =1
		AND payments.payment_status =2
		AND payments.`USERID` = $user_id
		
		UNION
		SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'decline_payment_received' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		AND payments.decline_accept =1
		AND payments.payment_status =2
		AND payments.`USERID` = $user_id
		
		UNION 
		SELECT payments.id, payments.time_zone,  `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, payments.update_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'seller_cancelled' AS 
		STATUS , payments.notification_status
		FROM  `payments` 
		INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
		INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
		WHERE payments.seller_status =1
		AND payments.cancel_accept = 1
		AND payments.notification_status !=2
		AND payments.USERID = $user_id
		
		) a ORDER BY a.created_date DESC ");    
		$result = $query->result_array();
	    /*$result1 = $this->new_notification_count();
		if(is_array($result1)){
			$result = array_merge($result,$result1);	
			$result = array_unique($result);
		}*/
    return $result; 
    }
   public function mylastupdate($db_time,$db_timezone,$user_timezone){
			  
			if ($user_timezone!="")
			{
				$user_timezone = 'Asia/Kolkata';
			} 		
			  
			date_default_timezone_set($db_timezone);  //Change default timezone to old timezone within this function only.
			$originalTime = new DateTime($db_time);
			$originalTime->setTimeZone(new DateTimeZone($user_timezone)); //Convert to desired TimeZone.
			date_default_timezone_set($user_timezone) ; //Reset default TimeZone according to your global settings.
			$LATime = $originalTime->format('Y-m-d h:i:s A'); //Return converted TimeZone.
			
			$datetime1 = new DateTime();
			$datetime2 = new DateTime($LATime); 
			$interval = $datetime1->diff($datetime2);
			
			$year = $interval->format('%y years');
			$month = $interval->format('%m months');
			$day = $interval->format('%a days'); 
			$hour = $interval->format('%h hours'); 
			$minute = $interval->format('%i minutes'); 
			$seconds = $interval->format('%s seconds');
			
			if($year > 0){
				return $year. '  ago';
			}else if($month > 0){
				return $month. '  ago';
			}else if($day > 0){
				return $day. '  ago';
			}else if($hour > 0){
				return $hour. '  ago';
			}else if($minute > 0){
				return $minute. '  ago';
			}else{
				return $seconds. ' ago';
			}
		}	  
} 
?>