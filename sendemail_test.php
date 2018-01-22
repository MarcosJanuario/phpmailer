<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    
    require 'vendor/autoload.php';
    
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'marcos*****@gmail.com';
        $mail->Password = '******';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        
        // email&recipients info
        $mail->setFrom('marcos*****@******', 'Mailer');
        $mail->addAddress('marcos****@******', 'Marcos Januario');
        $mail->isHTML(true);                                  
        $mail->Subject = 'Email using PHPMailer from PHP';
        $mail->Body    = 'This is the HTML message body <b>SENT FROM PHPMAILER</b> um 8 Uhr morgens';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        // echo 'Message has been sent';

        if ($mail->send())
        {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
        // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
?>