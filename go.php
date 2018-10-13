<?php
	require 'head.php';
	require 'pages/functions.php';
?>

<div class="container" id="centerFrame">
<?php
	$dt = "";
	$select = "SELECT godate FROM go ".
		"ORDER BY godate DESC LIMIT 1";
	$query = $db->prepare($select);
        $query->execute();
        while ($row = $query->fetch())  {
		$dt = $row['godate'];
	}
?>
	<center>
		<br />
		<span style="font-weight:bold;font-size:1.4em;">
			General Order Program Information and Sign Up
		</span>
	</center>

	<div class="goRow">
		<div style="border:2px solid black;">
			<div clsss="row" style="background-color:white;padding:20px;">
				For many years, Troy's General Order Program has been helping customers to receive
				top quality remnant bundles at prices well below full bolt price
				<br /><br />
				Here is how it works
			</div>
			<div class="row" style="background-color:white;">
				<div class="col">
					<img src="img/transgeneral.gif" style="padding-left:10px;" />
				</div>
				<div class="col">
					<ul style="text-align:justify;">
						<li style="margin-bottom:10px;">
						You may sign up for any number of categories shown below, from one to all</li>
						<li style="margin-bottom:10px;">
						Every two weeks, you will receive a notification of which bundles will be
						shipping. <a href="goDetail.php?dt=<?php echo $dt ?>">
							A sample of our latest offerings will be viewable here.
							</a>
						</li>
						<li style="margin-bottom:10px;">
						You will be automatically scheduled to receive any bundles for the 
						categories in which you have enrolled.
						</li>
						<li style="margin-bottom:10px;">
						You first quality bundle will arrive approximately two weeks after
						you receive the notice.
						</li>
						<li style="margin-bottom:10px;">
						If there are bundles you decide against receiving just contact us before 
						the ship date to have them removed from your shipment. There is absolutely 
						no obligation to receive any bundle you do not want.
						</li>
						<li style="margin-bottom:10px;">
						Your membership in the General Order (GO) Program will entitle you
						to receive special pricing below any other resource, and also below the price
						at which we will sell the same bundles to non-GO members.
						</li>
					</ul>
				</div>
			</div>
<?php
			$name = "";
			$pass = "";
			$first = "";
			$last = "";
			$addr = "";
			$zipc = "";
			$emal = "";
			$city = "";
			$cityID = "";
			$stateID = 129;
			$phone = "###-###-####";
			$id = "";
			$types = Array();
			if (isset($_SESSION['user']))  {
				$id = $_SESSION['user']['customerid'];
				$select1 = "SELECT * FROM customer AS t1 ".
					"WHERE t1.customerID = '".$id."'";
				$query1 = $db->prepare($select1);
				$query1->execute();
				while ($row = $query1->fetch())  {
					$name = $row['name'];
					$pass = $row['pass'];
					$first = $row['first'];
					$last = $row['last'];
				}
				$select1 = "SELECT * FROM customeraddress ".
					"WHERE customerID = '".$id."'";
				$query1 = $db->prepare($select1);
				$query1->execute();
				$zipID = "";
				while ($row = $query1->fetch())  {
					$addr = $row['address'];
					$zipID = $row['zipID'];
				}
				$select1 = "SELECT * FROM zip AS t1, ".
					"customeraddress AS t2 ".
					"WHERE t2.zipID = t1.zipID ".
					"AND t1.zipID = ".$zipID;
				$query1 = $db->prepare($select1);
				$query1->execute();
				while ($row = $query1->fetch())  {
					$cityID = $row['cityID'];
					$zipc = $row['zip'];
				}
				$select1 = "SELECT * FROM customeremail ".
					"WHERE customerID = '".$id."'";
				$query1 = $db->prepare($select1);
				$query1->execute();
				while ($row = $query1->fetch())  {
					$emal = $row['email'];
				}
				if ($cityID != "")  {
					$select1 = "SELECT * FROM city ".
						"WHERE cityID = ".$cityID;
					$query1 = $db->prepare($select1);
					$query1->execute();
					while ($row = $query1->fetch())  {
						$stateID = $row['stateID'];
						$city = $row['city'];
					}
				}
				$select1 = "SELECT * FROM phone ".
					"WHERE customerID = '".$_SESSION['user']['customerid']."'";
				$query1 = $db->prepare($select1);
				$query1->execute();
				while ($row = $query1->fetch())  {
					$phone = $row['number'];
				}
				$select1 = "SELECT * FROM customergosubcategory ".
					"WHERE customerID = '".$_SESSION['user']['customerid']."'";
				$query1 = $db->prepare($select1);
				$query1->execute();
				while ($row = $query1->fetch())  {
					$types[$row['gosubcategoryID']] = $row['gosubcategoryID'];
				}
			}

			$select = "SELECT * FROM state";
			$query = $db->prepare($select);
			$query->execute();
?>
			<form method="post" name="goForm" action="pages/goSignUp.php" onsubmit="return validateGoForm();">
			<div class="row" style="background-color:white;">
				<center>
				If you are an <b>existing</b> Troy customer just log in, navigate back here and fill in any 
				missing information.<br />
				If you are <b>new</b> to Troy, please register, navigate back to this page and fill in any
				missing information.
				</center>
				<div class="col" style="background-color:white;width:860px;padding:20px;">
					<div class="col" style="width:52%;">
						<input type="hidden" id="id" name="custID" value="<?php echo $id ?>" />
						<div class="row">
							<div class="col" style="width:35%;">
								Company: 
							</div>
							<div class="col" style="width:57%;">
								<input type="text" id="company" name="company" value="<?php echo $name ?>" /><br />
							</div>
						</div>
						<div class="row">
							<div class="col" style="width:9%;">
								First: 
							</div>
							<div class="col" style="width:37%;">
								<input type="text" id="firstName" class="textCl" name="first" value="<?php echo $first ?>" />
							</div>
							<div class="col" style="width:9%;">
								last: 
							</div>
							<div class="col" style="width:37%;">
								<input type="text" id="lastName" class="textCl" name="last" value="<?php echo $last ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col" style="width:35%;">
								Password:
							</div>
							<div class="col" style="width:57%;">
								<input type="text" id="pass" name="pass" value="<?php echo $pass ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col" style="width:35%;">
								Street Address:
							</div>
							<div class="col" style="width:57%;">
								<input type="text" id="address" name="address" value="<?php echo $addr ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col" style="width:35%;">
								Zip Code: 
							</div>
							<div class="col" style="width:57%;">
								<input type="text" id="zCode" name="zip" value="<?php echo $zipc ?>" />
							</div>
						</div>
					</div>
					<div class="col" style="width:40%;">
						<div class="row">
							<div class="col" style="width:20%;">
								Email
							</div>
							<div class="col" style="width:72%;">
								<input type="text" name="email" id="email" value="<?php echo $emal ?>" /><br />
							</div>
						</div>
						<div class="row">
							<div class="col" style="width:20%;">
								City 
							</div>
							<div class="col" style="width:72%;">
								<input type="text" id="city" name="city" value="<?php echo $city ?>" /><br />
							</div>
						</div>
						<div class="row">
							<div class="col" style="width:20%;">
								State
							</div>
							<div class="col" style="width:72%;">
								<select name="state" class="state">
<?php								while ($row = $query->fetch())  {
								if ($row['stateID'] == $stateID)  {
?>
									<option value"<?php echo $row['stateID'] ?>" selected="selected"><?php echo $row['state'] ?></option>
<?php								}  else  {  ?>
									<option value="<?php echo $row['stateID'] ?>"><?php echo $row['state'] ?></option>
<?php								}
							}
?>
							</select><br />
						</div>
						<div class="row">
							<div class="col" style="width:20%;">
								Phone 
							</div>
							<div class="col" style="width:72%;">
								<input type="text" id="phone" name="phone" value="<?php echo $phone ?>" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="background-color:white;">
<?php
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
					$checked = "checked";
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
?>
				<?php echo $category ?>
				<input type="checkbox" class="goCheck" id="<?php echo $row['gosubcategoryID'] ?>" value="<?php echo $row['gosubcategoryID'] ?>" name="<?php echo $row['gosubcategoryID'] ?>" <?php echo $checked ?> />
				<?php echo $row['gosubcategory'] ?>
				<br />
<?php				if ($colCount == $colStop-1)  {  ?>
					</div>
<?php		
					$colCount = -1;
				}
				$lastColID = $curColID;
				$colCount++;
			}
?>
					<br /><br /><br />
					<span style="float:right;">
						<a href="#" id="goSelectAll">
							Select all Categories
						</a>
					</span>
					<br /><br /><br />
					<span style="float:right;">
						<input type="submit" id="submit" name="submit" value="Submit Form" />
					</span>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<?
	require 'foot.php';
?>
</html>


