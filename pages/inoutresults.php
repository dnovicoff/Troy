<?php
	require("common.php");
	$status = $_GET['status'];
	$prefix = $_GET['prefix'];
	$stats = "IN";
	if ($status == 0)  {
		$stats = "OUT";
	}
	$dofw = date("w");
        $dofwOffset = $dofw-1;
        $week_start = date('Y-m-d 00:00:00', strtotime('-'.$dofwOffset.' days'));
        $week_end = date('Y-m-d 00:00:00', strtotime('+'.(7-$dofw).' days'));

	$selectIN = "SELECT t1.sku,t2.price,t2.quantity,t1.date FROM ".
 		"itemstatus AS t1, ".
 		"item AS t2 ".
 		"WHERE t1.status = ".$status." ".
		"AND t1.sku LIKE '".$prefix."%' ".
 		"AND t1.sku = t2.sku ".
		"AND t1.date >= '".$week_start."' ".
		"AND t1.date <= '".$week_end."' ".
 		"ORDER BY t1.date DESC, ".
		"t1.sku ASC";

	$query = $db->prepare($selectIN);
	$query->execute();
?>
<taconite>
	<replaceContent select="#centerFrame">
		Items moving <?php echo $stats ?><br />
		<div id="container" style="width:100%">
			<div style="width:100%">
				<div class="salesHeader">
					SKU
				</div>
				<div class="salesHeader">
					Price
				</div>
				<div class="salesHeader">
					Quantity
				</div>
				<div class="salesHeader">
					Date
				</div>
			</div><br />
<?php	
	$count = 0;
	while ($row = $query->fetch())  {
		$sku = preg_replace('/&/','',$row['sku']);
?>
			<div style="width:100%">
				<div class="salesColumn">
					<?php echo $sku ?>
				</div>
				<div class="salesColumn">
					<?php echo $row['price'] ?>
				</div>
				<div class="salesColumn">
					<?php echo $row['quantity'] ?>
				</div>
				<div class="salesColumn">
					<?php echo $row['date'] ?>
				</div>
			</div><br />
<?php	
		$count++;
	}  
?>
		</div>
		Count: <?php echo $count ?><br />
	</replaceContent>
</taconite>
