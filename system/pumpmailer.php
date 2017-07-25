<?php

require_once PUMPCMS_ROOT_PATH . '/external/phpmailer/PHPMailerAutoload.php';
require_once PUMPCMS_SYSTEM_PATH . '/util.php';

class PumpMailer {
    public function __construct() {
    }

    public function send($to, $subject, $message) {
        $mail = new PHPMailer();
		
		$subject = PC_Util::mail_convert_subject($subject);
		$message = PC_Util::mail_convert_body($message);

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->CharSet = 'iso-2022-jp';
        $mail->Encoding = '7bit';

        $mail->Host = PC_Config::get('phpmailer_host');       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = PC_Config::get('phpmailer_user');   // SMTP username
        $mail->Password = PC_Config::get('phpmailer_pass');   // SMTP password
        $mail->SMTPSecure = PC_Config::get('phpmailer_secure'); // Enable TLS encryption, ssl also accepted
        $mail->Port = PC_Config::get('phpmailer_port');       // TCP port to connect to

        $mail->setFrom(PC_Config::get('from_email'));
        $mail->addAddress($to);                               // Add a recipient
        //$mail->addAddress('ellen@example.com');             // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        //$mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $message;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        return $mail->send();
    }
}
