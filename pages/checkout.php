
<?php
	require("common.php");
	require_once "Mail.php";

	$host = "ssl://mail.troy-corp.com";
	$port = 465;
	$pass = "troycorp1";
	$curT = round(microtime(1) * 1000);

	$home = $_SERVER['HTTP_REFERER'];
	$addr = $_POST['addr'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$user = $_POST['user'];
	$cc = $_POST['cc'];
	$ccSec = $_POST['ccSec'];
	$ccExp = $_POST['ccExp'];
	$ccName = $_POST['ccName'];
	$ccBill = $_POST['ccBill'];
	$ccCity = $_POST['ccCity'];
	$ccState = $_POST['ccState'];
	$ccZip = $_POST['ccZip'];
	$terms = $_POST['terms'];
	$onfile = $_POST['onfile'];

	$from = "sales@troy-corp.com";
	$subject = "Troy-Corp Sales Receipt";
	$body = "";

	if (!empty($_SESSION['user']))  {
		$id = $_SESSION['user']['customerid'];
		$user = $_SESSION['user']['first']." ".$_SESSION['user']['last'];
		if (isset($_SESSION['list']))  {
			$order = $_SESSION['list'];
			$items = explode(" ",$order);

			$body = "Thank you ".$user." for your recent purchase\n".
				"Account: ".$_SESSION['user']['customerid']."\n".
				"Email: ".$email."\n".
				"Address: ".$addr."\n".
				"City: ".$city."\n".
				"State: ".$state."\n".
				"Zip: ".$zip."\n".
				"Phone: ".$phone."\n".
				"\n".
				"Order:\n";

			foreach ($items as $item)  {
				$parts = explode(":",$item);
				if (preg_match('/\w{3}/',$item))  {
					$price = 0.0;
					$subtotal = 0;
					$full = $parts[1];
					$select = "SELECT price FROM item WHERE ".
						"sku = '".$parts[0]."'";
					$query = $db->prepare($select);
					$query->execute();
					while ($row = $query->fetch())  {
						$price = $row['price'];
					}
					$half = (int) $parts[2];
					$subtotal = $price * $full * 15;
					if ($half > 0)  {
						$price = $price+0.25;
						$subtotal = $price * $half * 7.5;
					}

					$halfTxt = "";
					if ($parts[2] > 0)  {
						$halfTxt = " Half order quantity ".$parts[2]." ";
					}
					$fullTxt = "";
					if ($parts[1] > 0)  {
						$fullTxt = " Full order quantity ".$parts[1]." ";
					}
					$body = $body."SKU: ".$parts[0]."".$halfTxt."".$fullTxt."".$subtotal."\n";

					$insert = "INSERT INTO customerorder VALUES ('".
						$id."','".$parts[0]."',now(),".$full.",".$subtotal.",".$half.")";
					$query = $db->prepare($insert);
					$query->execute();
				}
			}

			$_SESSION['list'] = "";
			$smtp = Mail::factory('smtp',
				array ('host' => $host,
					'port' => $port,
					'auth' => true,
					'username' => $from,
					'password' => $pass));

			$headers =  array ('From' => $from,
					'To' => $email,
					'Subject' => $subject);
			$mail = $smtp->send($email, $headers, $body);
			if (PEAR::isError($mail))  {
				echo $mail->getMessage();
			}


			$pubkey = file_get_contents("./ia.crt");
			$headers =  array ('From' => $from,
					'To' => $from,
					'Subject' => $subject);
			$eol = "\r\n";
			$enc_header = "From: ".$headers['From'].$eol;
			$enc_header .= "To: ".$headers['To'].$eol;
			$enc_header .= "Subject: ".$headers['Subject'].$eol;
			$enc_header .= "Content-Type: text/plain; format=flowed; ".
				"charset=\"iso-8859-1\"; reply-type=original".$eol;
			$enc_header .= "Content-Transfer-Encoding: 7bit".$eol;
			$enc_header .= "\n";

			$headers_msg = $headers;
			unset($headers_msg['To'], $headers_msg['Subject']);
			$body .= "\nCredit Card:     ".$cc."\n".
				"CC Expiration    ".$ccExp."\n".
				"CC Security Code ".$ccSec."\n".
				"Name:            ".$ccName."\n".
				"Billing Address: ".$ccBill."\n".
				"Billing City:    ".$ccCity."\n".
				"Billing State:   ".$ccState."\n".
				"Billing Zip:     ".$ccZip."\n".
				"Terms:           ".$terms."\n".
				"On File:	  ".$onfile."\n";

			## $body = $enc_header.$body;
			## $fp = fopen("msg".$curT.".txt", "w");
			## fwrite($fp, $body);
			## fclose($fp);

			## openssl_pkcs7_encrypt("msg".$curT.".txt","enc".$curT.".txt",$pubkey,$headers_msg,PKCS7_TEXT,1);
			## $data = file_get_contents("enc".$curT.".txt");
			## $parts = explode("\n\n", $data, 2);

			ini_set('display_errors',1);
			## $mail=mail($headers['To'], $headers['Subject'], $parts[1], $parts[0],'From: '.$from);
			$mail = $smtp->send($from, $headers, $body);
			if (PEAR::isError($mail))  {
				echo $mail->getMessage();
			}

			## unlink("msg".$curT.".txt");
			## unlink("enc".$curT.".txt");
		}
	}  else  {
	}
?>

