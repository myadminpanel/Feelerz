<?php 
class Testing extends CI_Controller{ 
  
  public function __construct() {
      parent::__construct();  
      $this->load->library('Stripe');
   }

   public function index(){
/*$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/accounts");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "country=US&type=custom");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, "sk_test_8w0QeeKXNWn3hqKRNXzBtwRd" . ":" . "");

$headers = array();
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
		echo "<pre>";
		print_r($result);
		exit;
*/
    	
    	$result = $this->stripe->direct_charges(500,'usd','acct_1BufHdGUTwCuzzLt','sk_test_OVXvseuWuLVp2w0XOWvGKDQJ');
    	echo "<pre>";
    	print_r($result);
    	exit;


   }
}
?>