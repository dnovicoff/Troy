

<?php
	require("common.php");

	$addr = $db->quote($_POST['addr']);
	$city = $db->quote(ucfirst($_POST['city']));
	$state = $db->quote($_POST['state']);
	$zip = $db->quote($_POST['zip']);
	$email = $db->quote($_POST['email']);
	$phone = $db->quote($_POST['phone']);
	$id = $_POST['user'];
	$id = preg_replace('/[;\']/','',$id);
	$uname = "";
	$pass = "";
	if (strlen($id) == 10)  {
		$uname = $_POST['uname'];
		$pass = $_POST['pass'];
		$select = "SELECT * FROM customer WHERE customerID = ".$id;
		$stmt = $db->prepare($select);
		$stmt->execute();

		$row = $stmt->fetch();
		if (!$row)  {
			$insert = "INSERT INTO customer (customerID,name,createDate,user,pass) ".
				"VALUES ('".$id."','TEMPORARY',now(),'".$uname."','".$pass."')";
			$stmt = $db->prepare($insert);
			$stmt->execute();
		}
	}

	if ($addr != "" && $city != "" && $state != "" && $zip != "" && $phone != "")  {
		$stateID = $state;

		$select = "SELECT * FROM city WHERE city = ".$city." ".
			"AND stateID = ".$stateID;
		$cityID = 0;
		$stmt = $db->prepare($select);
		$stmt->execute();

		$row = $stmt->fetch();
		if ($row)  {
			$cityID = $row['cityID'];
		}  else  {
			$insert = "INSERT INTO city (city,stateID) ".
				"VALUES (".$city.",".$stateID.")";
			$stmt = $db->prepare($insert);
			$stmt->execute();
			$cityID = $db->lastInsertId();
		}

		$select = "SELECT * FROM zip WHERE zip = ".$zip." ".
			"AND cityID = ".$cityID;
		$zipID = 0;
		$stmt = $db->prepare($select);
		$stmt->execute();

		$row = $stmt->fetch();
		if ($row)  {
			$zipID = $row['zipID'];
		}  else  {
			$insert = "INSERT INTO zip (zip,cityID) ".
				"VALUES (".$zip.",".$cityID.")";
			$stmt = $db->prepare($insert);
			$stmt->execute();
			$zipID = $db->lastInsertId();
		}

		$select = "SELECT * FROM customeraddress WHERE ".
			"customerID = '".$id."'";
		$stmt = $db->prepare($select);
		$stmt->execute();

		$row = $stmt->fetch();
		if ($row)  {
			$update = "UPDATE customeraddress ".
				"SET address = ".$addr.", ".
				"zipID = ".$zipID." ".
				"WHERE customerID = ".$id;
			$stmt = $db->prepare($update);
			$stmt->execute();
		}  else  {
			$insert = "INSERT INTO customeraddress ".
				"VALUES (".$id.",".$addr.",".$zipID.",Now())";
			$stmt = $db->prepare($insert);
			$stmt->execute();
		}

		$select = "SELECT * FROM phone ".
			"WHERE customerID = '".$id."'";
		$stmt = $db->prepare($select);
		$stmt->execute();

		$row = $stmt->fetch();
		if ($row)  {
			$update = "UPDATE phone SET number = ".$phone." WHERE customerID = '".$id."'";
			$stmt = $db->prepare($update);
			$stmt->execute();
		}  else  {
			$insert = "INSERT INTO phone VALUES ".
				"('".$id."',".$phone.")";
			$stmt = $db->prepare($insert);
			$stmt->execute();
		}
	}

	$select = "SELECT * FROM customeremail ".
		"WHERE customerID = '".$id."'";
	$stmt = $db->prepare($select);
	$stmt->execute();

	$row = $stmt->fetch();
	if ($row)  {
		$update = "UPDATE customeremail SET email = ".$email." ".
			"WHERE customerID = '".$id."'";
		$stmt = $db->prepare($update);
		$stmt->execute();
	}  else  {
		$insert = "INSERT INTO customeremail VALUES ".
			"('".$id."',".$email.",1)";
		$stmt = $db->prepare($insert);
		$stmt->execute();
	}
?>

