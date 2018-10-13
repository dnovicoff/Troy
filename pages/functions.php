<?php
	require_once "Mail.php";

	## Function to generate 10 digit length user ID
	function generateID()  {
		$generated = "";
		$count = 0;
		$needed = 10;
		while ($count < $needed)  {
			$random = mt_rand(1,9);
			$generated .= $random;
			$count++;
		}
		return $generated;
	}

	## function to send email
	function sendEmail($from,$to,$subject,$host,$user,$pass,$body)  {
		$headers =  array ('From' => $from,
                	'To' => $to,
                	'Subject' => $subject);

		$smtp = Mail::factory('smtp',
                	array ('host' => $host,
                        	'auth' => true,
                        	'username' => $user,
                        	'password' => $pass));

		$mail = $smtp->send($to, $headers, $body);
		if (PEAR::isError($mail))  {
			echo $mail->getMessage();
		}
	}
?>
