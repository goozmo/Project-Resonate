<?php
//goozmo_messanger.php

class goozmo_messanger{
	
	public function __construct($request){
				
		$name=$request->name;
		$email=$request->email;
		if(isset($this->website)&&($this->website!='website')){
			$website=$request->website;
		}
		else{
			$website=get_bloginfo();
		}
		$option=$request->help_for;
		$message=wordwrap($request->message);
		$message_body="";
		$message_body.="<h2 style='font-size:24px;color:rgb(77, 48, 98);margin-bottom:10px;'>Goozmo WP Concierge help ticket</h2><br/>";
		$message_body.="<h3 style='font-size:18px;color:rgb(77, 48, 98);margin-bottom:10px;'>Account:</h3><p style='margin-bottom:20px;'>".$name."</p><br/>";
		$message_body.="<h3 style='font-size:18px;color:rgb(77, 48, 98);margin-bottom:10px;'>Website:</h3><p style='margin-bottom:20px;'>".$website."</p><br/>";
		$message_body.="<h3 style='font-size:18px;color:rgb(77, 48, 98);margin-bottom:10px;'>Regarding:</h3><p style='margin-bottom:20px;'>".$option."</p><br/>";
		$message_body.="<h3 style='font-size:18px;color:rgb(77, 48, 98);margin-bottom:10px;'>Message:</h3><p style='margin-bottom:20px;'>".$message."</p>";
		
		$message=$message_body;
		
		//echo "<pre>";
		//print_r($request);
		//echo "</pre>";
		
		
		//www.faqs.org/rfcs/rfc282
?>
		<div class="inner">
<?php
		try{
			$_email = "support@goozmo.com";
			$_password = "b0ulderg00z";
			$_host = 'smtp.goozmo.com';
						
			$mail = new PHPMailer();
			
			//$mail->SMTPDebug = 3;                              		// Enable verbose debug output

			//$mail->IsSendmail(); 

			$mail->isSMTP();                                   		// Set mailer to use SMTP
			//$mail->Host = $_host;  						// Specify main and backup SMTP servers
			//$mail->SMTPAuth = true;                              		// Enable SMTP authentication
			//$mail->Username = $_email;					// SMTP username
			//$mail->Password = $_password;							// SMTP password
			//$mail->SMTPSecure = 'ssl';                            	// Enable TLS encryption, `ssl` also accepted
			
			$mail->Port = 25;											// TCP port to connect to

			$mail->AddReplyTo($_email,$name);
			$mail->SetFrom($email, $name);
			//$mail->AddReplyTo($_email,"First Last");
			
			$mail->AddAddress('goozmocom@gmail.com', $name);
			
			$mail->Subject = "Goozmo Concierge Support Ticket";
			$mail->AltBody = $message; // optional, comment out and test
			$mail->Body = $message;
			
			
			if(!$mail->Send()) {
				echo "<br/>Mailer Error: <pre>" . $mail->ErrorInfo."</pre></br>";
			} else {
				echo "<br/>Message sent!<br/>";
			}
		}
		catch(Exception $e){
			echo "There has been an error: ".$e->message." Until we get this sorted out, please try one of our many other methods of contact.  Thank you.";
?>
			<h3>Live Chat:</h3>
			<h4>Click the live chat button in the bottom right corner of your screen.</h4>
			<h3>Phone:</h3>
			<h4>1.800.519.7691</h4>
			<i>or</i>
			<h4>303.938.6821</h4>
			<h3>Email:</h3>
			<h4>support@goozmo.com</h4>
		</div><!--end: inner-->
<?php
		}
	}
	
}

?>