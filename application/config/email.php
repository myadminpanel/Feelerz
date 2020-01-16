<?php

 

/*
$config = array();
$config['useragent']  = "CodeIgniter";
$config['mailpath']    = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
$config['protocol']    = "smtp";
$config['smtp_host']   = "172.17.11.101";
$config['smtp_port']    = "25";
$config['mailtype'] = 'html';
$config['charset']  = 'utf-8';
$config['newline']  = "\r\n";
$config['wordwrap'] = TRUE;

//extra added
$config['validate']         = true;
$config['priority']         = 3;                        // 1, 2, 3, 4, 5
$config['crlf']             = "\r\n";                     // "\r\n" or "\n" or "\r"
$config['bcc_batch_mode']   = false;
$config['bcc_batch_size']   = 200;
$config['encoding']         = '8bit';
 */
 
    $config = array();

    $config['useragent']  = "CodeIgniter";

	$config['mailpath']    = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	
	$config['protocol']    = "smtp";
	
	$config['smtp_host']   = "localhost";
	
	$config['smtp_port']    = "25";
	
	$config['mailtype'] = 'html';
	
	$config['charset']  = 'utf-8';
	
	$config['newline']  = "\r\n";
	
	$config['wordwrap'] = TRUE;  