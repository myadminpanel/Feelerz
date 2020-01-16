<?php 

if(!function_exists('currency_sign')){
  
  function currency_sign($currency_code){ 

        switch ($currency_code) {
                case 'USD':
                  $sign ='$';
                  break;
                case 'EUR':
                  $sign ='€';
                  break;
                case 'GBP':
                  $sign ='£';
                  break;
                default:
                  $sign ='$';
                  break;
              } 
      return $sign;        
  }
}

if(!function_exists('currency_code')){

  function currency_code($currency_sign){ 

        switch ($currency_sign) {
                case '$':
                  $code ='USD';
                  break;
                case '€':
                  $code ='EUR';
                  break;
                case '£':
                  $code ='GBP';
                  break;
                default:
                  $code ='USD';
                  break;
              } 
      return $code;        
  }
 }
?>