<?php 

  require_once('mail/PHPMailer/PHPMailerAutoload.php');

            $mail = new PHPMailer;
    
            $mail->SMTPDebug = 0;                               // Enable verbose debug output
    
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail.digimonk.net';              // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'info@digimonk.net';                 // SMTP username
            $mail->Password = 'digimonk@123';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to
    
            /* THIS IS CODE ADD BY DEEPAK SINGH PATEL */
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            /* THIS IS CODE ADD BY DEEPAK SINGH PATEL END */
    $email=$email;

    $fullname="Deepak Patel";
            $mail->setFrom('info@digimonk.net', 'App');
            $mail->addAddress($email, $fullname);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('', 'Information');
            // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML
            
            // $temp_email=base64_encode($email);
            
            $mail->Subject = $subject;
            $mail->Body = @$mess;
    
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $data=$mail->send();
            // echo $data;
            
?>