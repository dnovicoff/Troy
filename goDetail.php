<?php
	require 'head.php';
	$dt = $_GET['dt'];
	date_default_timezone_set("America/Chicago");
	$tmp = date('F d, Y', strtotime($dt. ' + 21 days'));
?>

<div class="container" id="centerFrame">
	<center>
		<br /><br />
		<span style="font-weight:bold;font-size:1.3em;">
			General Order Program
		</span>
		<div class="goRow" style="text-align:justify;">
			Troy's General Order Program, our semi monthly automatic shipment of first quality,
			low-priced remnant bundles, gives you the opportunity to select from a wide variety of
			fabrics from all the top mills. Below is a sample of what we will be shipping in the 
			current cycle. If there are any you are scheduled to receive, but wish not to, please
			<a href="mailto:general.order.program@troy-corp.com">email</a>, fax, or call us.
			You may also choose to add any bundles you  were not scheduled to receive.
			<a href="/go.php">Learn more.</a><br />	
		</div>
		Shipping Date <b><?php echo $tmp ?></b>&nbsp;&nbsp;
	</center>
<?php
	$select = "SELECT t1.shipdate,t2.godate,t2.sku,t2.heading,t2.length,t2.description,t2.price ".
		"FROM go AS t1,goinfo AS t2 ".
		"WHERE t1.godate = t2.godate ".
		"AND t2.godate = '".$dt."' ".
		"ORDER BY godate DESC LIMIT 9";
	$shipdate = "";

	$query = $db->prepare($select);
	$query->execute();
	$count = 0;
        while ($row = $query->fetch())  {
		$shipdate = $row['shipdate'];
?>
		<div class="goRow">
			<div class="background">
<?php				if ($count%2 == 0)  {  ?>
					<div class="goColImg">
						<!--
						<img src="/img/go/<?php echo $row['godate'] ?>/<?php echo $row['sku'] ?>_300x450.jpg" />
						-->
						<img src="/img/go/fabric/<?php echo $row['sku'] ?>_300x450.jpg" />
					</div>
					<div class="goColText">
						<div style="text-align:justify;">
							<span style="font-weight:bold;font-size:1.25em;">
								<?php echo $row['heading'] ?>
							</span>
							<br />
							<?php echo $row['sku'] ?>
							<br />
							<?php echo $row['length'] ?>
							<br /><br />
							<?php echo $row['description'] ?>
							<br /><br />
							If you aren't already enrolled in Troy's General Order Program
							you can buy individual bundles. For discounted prices,
							<a href="/go.php">become a member of Troy's General Order Program</a>
							<br /><br />
						</div>
						<div style="text-align:right;">
<?php
							if (isset($_SESSION['user']))  {
                                				$submitted_username = $_SESSION['user'];
?>
								General Order Program Members 
								<b>$<?php echo number_format($row['price'],2) ?></b>/Yard
								<br />
								Non-Members: <b>$<?php echo number_format($row['price']+0.50,2) ?></b>/Yard
								<br />
<?php							}  ?>
						</div>
					</div>
<?php				}  else  {  ?>
					<div class="goColText">
						<div style="text-align:justify;">
							<span style="font-weight:bold;font-size:1.25em;">
								<?php echo $row['heading'] ?>
							</span>
							<br />
							<?php echo $row['sku'] ?>
							<br />
							<?php echo $row['length'] ?>
							<br /><br />
							<?php echo $row['description'] ?>
							<br /><br />
							If you aren't already enrolled in Troy's General Order Program
							you can buy individual bundles. For discounted prices,
							<a href="/go.php">become a member of Troy's General Order Program</a>
							<br /><br />
						</div>
						<div style="text-align:right;">
<?php
							if (isset($_SESSION['user']))  {
                                				$submitted_username = $_SESSION['user'];
?>
								General Order Program Members 
								<b>$<?php echo number_format($row['price'],2) ?></b>/Yard
								<br />
								Non-Members: <b>$<?php echo number_format($row['price']+0.50,2) ?></b>/Yard
								<br />
<?php							}  ?>
						</div>
					</div>
					<div class="goColImg">
						<img src="/img/go/<?php echo $row['godate'] ?>/<?php echo $row['sku'] ?>_300x450.jpg" />
					</div>
<?php				}  ?>
				
			</div>
		</div>
<?php	
		$count++;
	}  
?>
</div>

<?
	require 'foot.php';
?>
</html>


