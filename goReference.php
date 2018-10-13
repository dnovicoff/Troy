<?php
	require 'head.php';
?>

<div class="container" id="centerFrame">
<?php
	$vendors = array(
		"WIN"=>"Windham Remnant",
		"GLA"=>"Henry Glass Remnant",
		"BEN"=>"Benartex Remnant",
		"RED"=>"Red Rooster Remnant",
		"RJR"=>"RJR Remnant",
		"SPX"=>"Springs Creative Remnant",
		"STU"=>"Studio E Remnant",
		"TIM"=>"Timeless Treasures Remnant",
		"TRO"=>"Riverwoods by Troy Remnant",
		"BLU"=>"Blue Hill Remnant",
		"EST"=>"Elizabeth Studio Remnant",
		"TVL"=>"Troy Value Line Remnant"
	);

	$select = "SELECT t2.sku,t2.heading, ".
		"t1.createdate,t1.godate,t1.shipdate ".
		"FROM go AS t1,goinfo AS t2 ".
		"WHERE t1.godate = t2.godate ".
		"GROUP BY t2.sku";
	$query = $db->prepare($select);
	$query->execute();
	$oldSKU = "";
	$count = 0;
        while ($row = $query->fetch())  {
		if ($oldSKU == "" || $oldSKU != substr($row['sku'],4,3))  {
			if ($count%2 == 0)  {
?>
				<div class="row">
<?php			}  ?>
				<div class="col">
					<a href="./goDetail.php?dt=<?php echo $row['godate'] ?>">
						<img src="/img/go/<?php echo $row['godate'] ?>/<?php echo $row['sku'] ?>_300x450.jpg" />
					</a><br />
					<?php echo $vendors[''.substr($row['sku'],4,3)] ?><br />
				</div>
<?php			if ($count%2 != 0 && $count != 0)  {  ?>
				</div>
<?php
			}
			$count++;
		}
		$oldSKU = substr($row['sku'],4,3);
	}
?>

</div>

<?
	require 'foot.php';
?>
</html>


