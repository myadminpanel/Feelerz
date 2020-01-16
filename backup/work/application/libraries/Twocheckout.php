<?php 

Class Twocheckout
{

	public function __construct($config = array())
	{
		$this->config = $config;
		$this->validation();
		$url = "https://www.2checkout.com/checkout/purchase"; // Live 
		$url = "https://sandbox.2checkout.com/checkout/purchase"; // Sandbox
		//$this->pay_with_card_form($url);
	}
	public function twocheckout_refund($input){
		$init = array();
		$init['url']= "https://sandbox.2checkout.com/api/sales/refund_invoice";
		$post_query = http_build_query($input, '', '&');
		$init['post_data'] = $post_query; 
		return $this->curl_init($init);		
	}

	 

	public function curl_init($option){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $init['url']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $init['post_data']);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $this->twocheckout_username.":".$this->twocheckout_password);
		$headers = array();
		$headers[] = "Accept: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
    		
    		$result = json_encode(curl_error($ch));
			}
		curl_close ($ch);
		return $result;


	}

	public function validation(){

		
		$this->twocheckout_account  = (!empty($this->config['twocheckout_account'])?$this->config['twocheckout_account']:'');
		$this->twocheckout_username = (!empty($this->config['twocheckout_username'])?$this->config['twocheckout_username']:'');
		$this->twocheckout_password = (!empty($this->config['twocheckout_password'])?$this->config['twocheckout_password']:'');

		$error_message = array();
		if(empty($this->twocheckout_account)){
			$error_message['2checkout_account'] = "The 2Checkout account number is missing";
		}
		if(empty($this->twocheckout_username)){
			$error_message['username'] =  "The 2Checkout account api username is missing";
		}
		if(empty($this->twocheckout_password)){
			$error_message['password'] =  "The 2Checkout account api password is missing";
		}
		if(count($error_message) > 0){
			return json_encode($error_message);
		}

	}

	public function pay_with_card_form($url){

	$pay_with_card_html = " <form action='".$url."' method='post'  name='coform'>
  	<input type='hidden' name='sid' value='901367160' />
  	<input type='hidden' name='mode' value='2CO' />
  	<input type='hidden' name='li_0_type' value='product' />
  	<input type='hidden' name='li_0_name' value='my_gig_invoice' />
  	<input type='hidden' name='li_0_price' id='my_gig_price' value='' />
  	<input type='hidden' name='card_holder_name' value='' />
  	<input type='hidden' name='street_address' value='' />
  	<input type='hidden' name='street_address2' value='' />
  	<input type='hidden' name='city' value='' />
  	<input type='hidden' name='state' value='' />
  	<input type='hidden' name='zip' value='' />
  	<input type='hidden' name='country' value='' />
  	<input type='hidden' name='email' value='' />
  	<input type='hidden' name='phone' value='' />
  	<input type='hidden' name='x_receipt_link_url' value='".base_url()."user/twocheckout_payment' />
  	<input name='submit' type='submit' value='Checkout' id='myformsubmit' />
	</form>"; 
		echo $pay_with_card_html;	

	}

}

?>