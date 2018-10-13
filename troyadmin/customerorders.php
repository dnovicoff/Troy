<?php
	require("../pages/common.php");
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
	<title>Troy Customer Orders</title>
	</head>
	<body>

<?php	function printRow($sku,$created,$qty,$half)  {  ?>
		<div class="col" style="width:20%">
			<?php echo $sku ?>
		</div>
		<div class="col" style="width:20%">
			<?php echo $created ?>
		</div>
		<div class="col" style="width:20%">
			<?php echo $qty ?>
		</div>
		<div class="col" style="width:20%">
			<?php echo $half ?>
		</div>
<?php	}  ?>

<?php
	$select = "SELECT * FROM customerorder ".
		"ORDER BY created DESC";
	$result = $db->prepare($select);
	$result->execute();

	$tmpID = "";
	$count = 1;
	while ($row = $result->fetch())  {
		$id = $row['customerID'];
		if ($tmpID == "" || $tmpID != $id)  {
			print "<br />";

			$select = "SELECT * FROM customer ".	
				"WHERE customerID = '".$id."'";
			$customer = $db->prepare($select);
			$customer->execute();
			while ($x = $customer->fetch())  {
				print "Customer Name: ".$x['name']."<br />";
				print "Customer User: ".$x['user']."<br />";
				print "Customer Pass: ".$x['pass']."<br />";
			}
		
			$select = "SELECT * FROM customeraddress ".
				"WHERE customerID = '".$id."'";
			$address = $db->prepare($select);
			$address->execute();
			while ($x = $address->fetch())  {
				print "Customer Addr: ".$x['address']."<br />";
			}

			$select = "SELECT * FROM customeremail ".
				"WHERE customerID = '".$id."'";
			$email = $db->prepare($select);
			$email->execute();
			while ($x = $email->fetch())  {
				print "Customer Emil: ".$x['email']."<br />";
			}

			$select = "SELECT * FROM phone ".
				"WHERE customerID = '".$id."'";
			$phone = $db->prepare($select);
			$phone->execute();
			while ($x = $phone->fetch())  {
				print "Customer Phne: ".$x['number']."<br />";
			}
		}
?>
		<div class="row">
			<div class="col" style="width:20%">
				<?php echo $row['customerID'] ?>
			</div>
<?php			printRow($row['sku'],$row['created'],$row['qty'],$row['half']);  ?>
		</div>
<?php
		$tmpID = $id;
	}  
?>
	</body>
</html>
	
