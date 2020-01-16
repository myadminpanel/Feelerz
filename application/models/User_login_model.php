<?php 

class User_login_model extends CI_Model{

    public function check_login($username,$password)

    {

        $query = $this->db->query("SELECT * FROM `members` WHERE (`email` = '$username' OR `username` = '$username') AND `password` = md5('$password') ;");

        $result = $query->row_array();     
        if(!empty($result)){
          
        $user_id = $result['USERID'];

        $unique_code = $this->getToken(14,$user_id);

        $result['unique_code'] = $unique_code;

        $this->db->where('USERID', $user_id);

        $this->db->update('members', array('unique_code' => $unique_code));
        }

        return $result;

    }





   public function getToken($length,$user_id)

   {

       $token = $user_id;



       $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

       $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";

       $codeAlphabet.= "0123456789";



       $max = strlen($codeAlphabet); // edited



    for ($i=0; $i < $length; $i++) {

         $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];



    }



    return $token;

   }



   function crypto_rand_secure($min, $max) {

        $range = $max - $min;

        if ($range < 0) return $min; // not so random...

        $log = log($range, 2);

        $bytes = (int) ($log / 8) + 1; // length in bytes

        $bits = (int) $log + 1; // length in bits

        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1

        do {

            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));

            $rnd = $rnd & $filter; // discard irrelevant bits

        } while ($rnd >= $range);

        return $min + $rnd;

}



	public function check_facebook_login($email_id,$id)

	{

	$query = $this->db->query("SELECT * FROM `members` WHERE (`facebook_id` = $id OR email = '$email_id') AND `status` = 0 ");	

	$result = $query->row_array();

	return $result ;

	}

	public function check_google_login($email_id,$id)

	{

	$query = $this->db->query("SELECT * FROM `members` WHERE (`google_id` = $id OR email = '$email_id') AND `status` = 0 ");	

	$result = $query->row_array();

	return $result ;

	}

}

?>