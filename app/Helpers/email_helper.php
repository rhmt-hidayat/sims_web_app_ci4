<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_email($to, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = getenv('sandbox.smtp.mailtrap.io');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('94718dcc5a9686');
        $mail->Password = getenv('a1934177759480');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = getenv('2525');

        $mail->setFrom(getenv('daiiat65@gmail.com'), getenv('Codeigniter4'));
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        return $mail->send();
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}
