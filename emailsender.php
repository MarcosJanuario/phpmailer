<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
header('Cache-Control: no-cache, must-revalidate');
header('Access-Control-Allow-Origin: http://127.0.0.1:4200');

$status = '';

if (isset($_GET['user']) && $_GET['user'] === 'goku')
{
    if (isset($_GET['action']) && $_GET['action'] === 'pr_send_feedback')
    {
        if (isset($_GET['pr_msg_content']))
        {

            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);
            try {

                // Server settings
                $mail->SMTPDebug = 0;
                $mail->isSMTP();

                //the SMTP fixing
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'marcos***@gmail.com';
                $mail->Password = '*******';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $entityBody = file_get_contents('php://input');

                // email&recipients info
                $mail->setFrom('marcosprimetest@gmail.com', 'Mailer');
                $mail->addAddress('******@*******', 'Marcos Januario');
                $mail->isHTML(true); //$_GET['pr_msg_content'] . '. Issue location: ' .  $_GET['issueLocation'] . '<img src="'. $entityBody .'" />'                                  
                $mail->Subject = 'User issue reporting from Lunar using PHP - Marcos';

                if (isset($_GET['pr-include-screenshot']) && $_GET['pr-include-screenshot'] === 'true')
                {
                    // separete the image from the base64 prefix
                    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $entityBody));
                    // than only embedde the image on the body
                    $mail->addStringEmbeddedImage($data, "screenshot", "screenshot", "base64", "image/png");
                    
                    $mail->Body = 'Feedback content: ' . $_GET['pr_msg_content'] . '
                                    <br><br>
                                    Issue location: '  .$_GET['issueLocation'] . '
                                    <br><br>
                                    Screenshot: <br><br>
                                    <img src="cid:screenshot">';
                } else {
                    
                    $mail->Body = 'Feedback content: ' . $_GET['pr_msg_content'] . '
                                    <br><br>
                                    Issue location: '  .$_GET['issueLocation'];
                }

                $mail->AltBody = 'This is only a test of my system ';
            
                if ($mail->send())
                {
                    $status = 'true';
                } else {
                    $status = 'false';
                }
            } catch (Exception $e) {
                $status = 'false';
                // echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            
        } else {

            $arr = array ('error'=> 'no_content');
            $status = 'false';
        }
    } else
    {
        $arr = array ('error'=> 'no_action');
        $status = 'false';
    }
} else
{
    $arr = array ('error'=> 'no_user');
    $status = 'false';
}
// echo json_encode($arr);

echo $status

?>