<taconite>
	<replaceContent select="#centerFrame">
<?php
	require("common.php");

	$pos = $_POST['pos'];
	$id = $_POST['id'];
	$checkid = "";
	if ($id != "")  {
		$checkid = "WHERE customerID = '".$id."' ";
	}

       	$select = "SELECT * FROM customer ".
		$checkid.
		"ORDER BY customerID ".
		"LIMIT ".$pos.", 1";
       	$result = $db->prepare($select);
       	$result->execute();

	$id = "";
	$name = "";
	$user = "";
	$pass = "";
	$emil = "";
	$phne = "";
	$addr = "";
	$zip = "";
       	while ($row = $result->fetch())  {
               	$id = $row['customerID'];

                $name = $row['name'];
		$name = preg_replace("/&/","&amp;",$name);
                $user = $row['user'];
                $pass = $row['pass'];

               	$select = "SELECT * FROM customeremail WHERE customerID = '".$id."'";
               	$sth = $db->prepare($select);
               	$sth->execute();
               	while ($selectRow = $sth->fetch())  {
                       	$emil = $selectRow['email'];
               	}
               	$select = "SELECT * FROM phone WHERE customerID = '".$id."'";
               	$sth = $db->prepare($select);
               	$sth->execute();
               	while ($selectRow = $sth->fetch())  {
                       	$phne = $selectRow['number'];
               	}
               	$select = "SELECT * FROM customeraddress WHERE customerID = '".$id."'";
               	$sth = $db->prepare($select);
               	$sth->execute();
		$zipID = 0;
               	while ($selectdRow = $sth->fetch())  {
                       	$addr = $selectRow['address'];
                       	$zipID = $selectRow['zipID'];
               	}
               	if ($zipID != 0)  {
                       	$select = "SELECT * FROM zip WHERE zipID = ".$zipID;
                       	$sth = $db->prepare($select);
                       	$sth->execute();
                       	while ($selectRow = $sth->fetch())  {
                               	$zip = $selectRow['zip'];
                       	}
               	}
?>
               	<br />
		Company Name:
               	<input type="text" value="<?php echo $name ?>" placeholder="name" /><br />
		User Name:
               	<input type="text" value="<?php echo $user ?>" placeholder="user" /><br />
		Password:
               	<input type="text" value="<?php echo $pass ?>" placeholder="pass" /><br />
		Email:
               	<input type="text" value="<?php echo $emil ?>" placeholder="email" /><br />
		Phone Number:
               	<input type="text" value="<?php echo $phne ?>" placeholder="phone" /><br />
		Address:
               	<input type="text" value="<?php echo $addr ?>" placeholder="address" /><br />
		Zip: 
               	<input type="text" value="<?php echo $zip ?>" placeholder="zip" /><br />
<?php	}  ?>
	<div class="row" style="background-color:white;">
<?php
	$select = "SELECT * FROM customergosubcategory ".
		"WHERE customerID = '".$id."'";
	$sth = $db->prepare($select);
	$sth->execute();
	$types = Array();
	while ($row = $sth->fetch())  {
		$types[$row['gosubcategoryID']] = $row['gosubcategoryID'];
	}

	$select = "SELECT t1.gocategory,t2.gocategoryID,t2.gosubcategoryID,t2.gosubcategory ".
 		"FROM gocategory AS t1, gosubcategory AS t2 ".
 		"WHERE t1.gocategoryID = t2.gocategoryID";
 	$query = $db->prepare($select);
 	$query->execute();

	$colCount = 0;
 	$colStop = 22;
 	$curColID = 0;
 	$lastColID = 0;
 	$category = "";
 	while ($row = $query->fetch())  {
 		$curColID = $row['gocategoryID'];
 		$subID = $row['gosubcategoryID'];
 		$checked = "";
 		if (isset($types[$subID]))  {
 			$checked = "checked=\"checked\"";
 		}

		if ($colCount == 0)  {
?>
 			<div class="col" style="width:275px;padding-left:10px;padding-right:10px;">
<?php
 		}
 		if ($curColID != $lastColID)  {
 			$category = "<b>".$row['gocategory']."</b><br />";
 		}  else  {
 			$category = "";
 		}
		$gosubcategory = preg_replace("/&/","&amp;",$row['gosubcategory']);
?>
 		<?php echo $category ?>
 		<input type="checkbox" class="goCheck" id="<?php echo $row['gosubcategoryID'] ?>" value="<?php echo $row['gosubcategoryID'] ?>" name="<?php echo $row['gosubcategoryID'] ?>" <?php echo $checked ?> />
 		<?php echo $gosubcategory ?>
 		<br />
<?php 		if ($colCount == $colStop-1)  {  ?>
 			</div>
<?php
 			$colCount = -1;
 		}
 		$lastColID = $curColID;
 		$colCount++;
	}
?>
		<span style="float:right;">
			<input type="submit" id="submit" name="submit" value="Submit Form" />
		</span>
	</div>
	</div>
	</replaceContent>
</taconite>
