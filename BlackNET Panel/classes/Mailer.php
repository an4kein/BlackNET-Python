<?php
if ( (is_dir("vendor/") && file_exists("vendor/")) ){
    include_once 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    include_once 'vendor/phpmailer/phpmailer/src/SMTP.php';
    include_once 'vendor/phpmailer/phpmailer/src/Exception.php';    
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


/*
    Simple Class that handles emails created using PHPMailer and PHP mail();
*/
class Mailer extends Database{
    // Get SMTP data to use with PHPMailer
	public function getSMTP($id){
        $pdo = $this->Connect();
        $sql = "SELECT * FROM smtp WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data;
	}

    // Update SMTP Data
	public function setSMTP($id,$smtphost,$smtpuser,$smtppassword,$port,$security_type,$status){
        $pdo = $this->Connect();
        $smtpdata = $this->getSMTP($id);
        if ($smtpdata->smtphost == $smtphost) {
                $newHost = $smtpdata->smtphost;
            } else {
                $newHost = $smtphost;
            }

            if ($smtpdata->smtpuser == $smtpuser) {
                $newUser = $smtpdata->smtpuser;
            } else {
                $newUser = $smtpuser;
            }

            if ($smtpdata->smtppassword == base64_encode($smtppassword)) {
                $newPassword = $smtpdata->smtppassword;
            } else {
                $newPassword =  base64_encode($smtppassword);
            }

            if ($smtpdata->port == $port) {
                $newPort = $smtpdata->port;
            } else {
                $newPort = $port;
            }

            if ($smtpdata->security_type == $security_type) {
            	$newType = $smtpdata->security_type;
            } else {
            	$newType = $security_type;
            }

            if ($status == "") {
                $status = "off";
            } else {
                $status = "on";
            }

        $sql = "UPDATE smtp SET 
        smtphost = :host ,
        smtpuser = :user,
        smtppassword = :password,
        port = :port,
        security_type = :type,
        status = :status
        WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['host'=>$newHost,'user'=>$newUser,'password'=>$newPassword,'port'=>$newPort,'type'=>$newType,'status'=>$status,'id'=>$id]);
        return 'SMTP Updated';
	}

    /*
    check if SMTP is enabled then use PHPMailer to send a premade messgae 
    if not this function will use mail() to send messages
    */
	public function sendmail($email,$subject,$body){
		$smtpdata = $this->getSMTP(1);
		$mail = new PHPMailer(true);
		try {
            if ($smtpdata->status == "on") {
                // PHPMailer settings
                $mail->isSMTP();
                $mail->Host = $smtpdata->security_type . "://" . $smtpdata->smtphost . ":" . $smtpdata->port;
                $mail->SMTPAuth = true;
                $mail->Username = $smtpdata->smtpuser;
                $mail->Password = base64_decode($smtpdata->smtppassword);

                $mail->setFrom($smtpdata->smtpuser, 'BlackNET');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $body;

                if ($mail->send()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                // Headers to enable HTML in mail();
                $from = $this->admin_email;
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 
                // Create email headers
                $headers .= 'From: '.$from."\r\n".
                    'Reply-To: '.$from."\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                if(mail($email,$subject,$body,$headers)){
                    return true;
		} else {
                    return false;
		}
            }
            
		} catch (Exception $e) {
		    return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
?>
