<?php
/**
 * 
 * @author ccgajardo
 *
 */
class Mailer {
	
	public function send($to, $subject, $body){
		$message = file_get_contents('./views/templates/mail/header.php');
		$message.= $body;
		$message.= file_get_contents('./views/templates/mail/footer.php');
		
		$headers = "From: no-reply@galyleo.net\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		mail($to, $subject, $message, $headers);
	}
}