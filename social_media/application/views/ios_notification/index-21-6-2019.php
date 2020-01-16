 <?php
 $ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'socialMedia2.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', '');

$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', 
    $err, 
    $errstr, 
    60, 
    STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, 
    $ctx);

//if (!$fp)
//exit("Failed to connect amarnew: $err $errstr" . PHP_EOL);

//echo 'Connected to APNS' . PHP_EOL;
$message=$message_set;
// Create the payload body
$body['aps'] = array(
    'badge' => 0,
    'alert' => $message,
    'sound' => 'default'
);
// $deviceToken = "54D51552F69BB456F91C8872FE241D94997AEDA8606FABFC706E844876977680";
$deviceToken = $deviceToken_set;
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

// if (!$result)
//     echo 'Message not delivered' . PHP_EOL;
// else
    // echo 'Message successfully delivered amar'.$message. PHP_EOL;

// Close the connection to the server
fclose($fp);




  ?>