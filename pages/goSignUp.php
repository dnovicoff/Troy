<?php
	require("common.php");
	require("functions.php");

	$id = generateID();
	$types = Array();
	$name = "";
	$addr = "";
	$zip = "";
	$email = "";
	$company = "";
	$city = "";
	$state = "";
	$phone = "";
	$first = "";
	$last = "";
	$pass = "";
	foreach ($_REQUEST as $key => $value)  {
		if ($key == "first")  {  $first = $value;  }
		if ($key == "last")  {  $last = $value;  }
		if ($key == "pass")  {  $pass = $value;  }
		if ($key == "custID")  {  $id = $value;  }
		if ($key == "company") {  $name = $value;  }
		if ($key == "address")  {  $addr = $value;  }
		if ($key == "zip")  {  $zip = $value;  }
		if ($key == "email")  {  $email = $value;  }
		if ($key == "company")  {  $company = $value;  }
		if ($key == "city")  {  $city = $value;  }
		if ($key == "state")  {  $state = $value;  }
		if ($key == "phone")  {  $phone = $value;  }
		if (preg_match("/^\d{1,2}$/",$value))  {
			$types[$value] = $value;
		}
	}

	$insertupdate = "INSERT INTO customer ".
			"VALUES ('".$id."','".$name."',now(),".
			"'NULL','".$pass."','".$first."','".$last."') ".
			"ON DUPLICATE KEY UPDATE ".
			"name='".$name."',pass='".$pass."',first='".$first."',last='".$last."'";
	$query = $db->prepare($insertupdate);
	$query->execute();
	
	$insertupdate = "INSERT INTO customeremail ".
			"(customerID,email) VALUES ".
			"('".$id."','".$email."') ".
			"ON DUPLICATE KEY UPDATE ".
			"email='".$email."'";
	$query = $db->prepare($insertupdate);
	$query->execute();

	$insertupdate = "INSERT INTO phone VALUES ".
			"('".$id."','".$phone."') ".
			"ON DUPLICATE KEY UPDATE ".
			"number='".$phone."'";
	$query = $db->prepare($insertupdate);
	$query->execute();

	$select = "SELECT * FROM state ".
		"WHERE state='".$state."'";
	$query = $db->prepare($select);
	$query->execute();
	$stateID = 123;
	$row = $query->fetch();
	if (isset($row))  {
		while ($row = $query->fetch())  {
			$stateID = $row['stateID'];
		}
	}

	$select = "SELECT * FROM city ".
		"WHERE stateID=".$stateID." ".
		"AND city='".$city."'";
	$query = $db->prepare($select);
	$query->execute();
	$cityID = 0;
	$row = $query->fetch();
	if (!isset($row))  {
		$insert = "INSERT INTO city (city,stateID) ".
			"VALUES ('".$city."',".$stateID.")";
		$query = $db->prepare($select);
		$query->execute();
		$cityID = mysql_insert_id();
	}  else  {
		while ($row = $query->fetch())  {
			$cityID = $row['cityID'];
		}
	}

	$select = "SELECT * FROM zip ".
		"WHERE cityID=".$cityID." ".
		"AND zip='".$zip."'";
	$query = $db->prepare($select);
	$query->execute();
	$zipID = 0;
	$row = $query->fetch();
	if (!isset($row))  {
		$insert = "INSERT INTO zip (zip,cityID) ".
			"VALUES ('".$zip."',".$cityID.")";
		$query = $db->prepare($insert);
		$query->execute();
		$zipID = mysql_insert_id();
	}  else  {
		while ($row = $query->fetch())  {
			$zipID = $row['zipID'];
		}
	}

	$insert = "INSERT INTO customeraddress ".
		"VALUES ('".$id."','".$addr."',".$zipID.",now()) ".
		"ON DUPLICATE KEY UPDATE ".
		"address='".$addr."',zipID=".$zipID;
	$query = $db->prepare($select);
	$query->execute();

	$where = "";
	foreach ($types as $x)  {
		$insertupdate = "INSERT INTO customergosubcategory ".
				"VALUES (".$x.",'".$id."') ".
				"ON DUPLICATE KEY UPDATE ".
				"customerID='".$id."'" ;
		$query = $db->prepare($insertupdate);
		$query->execute();
		$where .= "'".$x."',";
	}
	$file = "../text.txt";
	$where = rtrim($where,",");
	$delete = "DELETE FROM customergosubcategory ".
		"WHERE gosubcategoryID NOT IN (".$where.")";
	file_put_contents($file,$delete."\n",FILE_APPEND | LOCK_EX);
	$query = $db->prepare($delete);
	$query->execute();

	$host = "troy-corp.com";
	$from = "general.order.program@troy-corp.com";
	$to = $email;
	$subject = "Welcome to the General Order Program";
	$user = "general.order.program@troy-corp.com";
	$pass = "troycorp1";
	$body = "Congratulations and welcome to Troys General Order Program";
	sendEmail($from,$to,$subject,$host,$user,$pass,$body);
	$body = "Customer ID for General Order Program: ".$id;
	sendEmail($from,$from,$subject,$host,$user,$pass,$body);

	header("Location: http://troy-corp.com/");
?>

