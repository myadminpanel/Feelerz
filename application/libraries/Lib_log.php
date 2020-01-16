<?php  
    defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_log
{
    
    private $_ci;
    public $levels = array(
        E_ERROR             => 'Error',
        E_WARNING           => 'Warning',
        E_PARSE             => 'Parsing Error',
        E_NOTICE            => 'Notice',
        E_CORE_ERROR        => 'Core Error',
        E_CORE_WARNING      => 'Core Warning',
        E_COMPILE_ERROR     => 'Compile Error',
        E_COMPILE_WARNING   => 'Compile Warning',
        E_USER_ERROR        => 'User Error',
        E_USER_WARNING      => 'User Warning',
        E_USER_NOTICE       => 'User Notice',
        E_STRICT            => 'Runtime Notice',
        E_RECOVERABLE_ERROR => 'Catchable error',
        E_DEPRECATED        => 'Runtime Notice',
        E_USER_DEPRECATED   => 'User Warning'
    );
    
    public function __construct()
    {
        $this->_ci =& get_instance();
        set_error_handler(array($this, 'error_handler'));
        set_exception_handler(array($this, 'exception_handler'));
        // Load database driver
        
    }
    public function error_handler($severity, $message, $filepath, $line)
    {
        $data = array(
            'errno' => $severity,
            'errtype' => isset($this->levels[$severity]) ? $this->levels[$severity] : $severity,
            'errstr' => $message,
            'errfile' => $filepath,
            'errline' => $line,
            'user_agent' => $this->_ci->input->user_agent(),
            'ip_address' => $this->_ci->input->ip_address(),
            'time' => date('Y-m-d H:i:s')
        );
        
        $msg = '' ; 
        if($data){
            foreach ($data as $key => $value) {
                
                $msg .='<p>'.$key.':'.$value.'</p>';    
            }
        }

        $this->write_log('Error',$msg,FALSE);
    }
    
    public function exception_handler($exception)
    {
        $data = array(
            'errno' => $exception->getCode(),
            'errtype' => isset($this->levels[$exception->getCode()]) ? $this->levels[$exception->getCode()] : $exception->getCode(),
            'errstr' => $exception->getMessage(),
            'errfile' => $exception->getFile(),
            'errline' => $exception->getLine(),
            'user_agent' => $this->_ci->input->user_agent(),
            'ip_address' => $this->_ci->input->ip_address(),
            'time' => date('Y-m-d H:i:s')
        );

        $msg = '' ; 
        if($data){
            foreach ($data as $key => $value) {
                
                $msg .='<p>'.$key.':'.$value.'</p>';    
            }
        }

        $this->write_log('Error',$msg,FALSE);
    }
 
    function write_log($level = 'error', $msg, $php_error = FALSE)
    {
        $result = FALSE;

        if (strtoupper($level) == 'ERROR') {
            $message = "An error occurred: \n\n";
            $message .= $level.' - '.date('Y-m-d'). ' --> '.$msg."\n";

            $to = 'dreamguystechnologies@gmail.com';
            $subject = 'An error has occured - '.$_SERVER['HTTP_HOST'];
			$headers = 'From: '.$_SERVER['HTTP_HOST'].' <no-reply@example.com>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8\r\n';

			if($_SERVER['HTTP_HOST']!='localhost'){
                $result =  mail($to, $subject, $message, $headers);    
           }
        }
        return $result;
    }
}
?>