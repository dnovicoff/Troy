<?php
	require 'head.php';

        $vendor = $_GET['vendor'];
	date_default_timezone_set("America/Chicago");
	$dt = date("Y-m-d",strtotime('-18 months'));
	$cssFont = "quicksandfont";
	$sort = "ORDER BY t3.category ASC";
	if ($vendor == "riverwoods" || $vendor == "house")  {
		$dt = "0000-00-00 00:00:00";
		$sort = "ORDER BY t3.category ASC";
	}

        $select = "SELECT t1.vendorID, t3.category, t3.display ".
                "FROM vendor AS t1, line AS t2, category AS t3 ".
                "WHERE t1.vendorID = t2.vendorID ".
                "AND t2.lineID = t3.lineID ".
                "AND t1.vendor = '".$vendor."' ".
		"AND t3.active = 1 ".
		"AND t3.created >= STR_TO_DATE('$dt', '%Y-%m-%d %H:%i:%s') ".
		$sort;

	$count = 0;
	$divCount = 1;
	$resultsOnLine = 6;
        $result = $db->prepare($select);
	$result->execute();
?>
	<div class="container" id="centerFrame">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Return to 
		<a href="/vendors.php">
			Fabric Vendors
		</a><br /><br />
		<center>
		<span style="font-family:sans-serif;font-weight:bold;font-size:30px;font-variant:small-caps;text-shadow: 0px 0px 2px #FF0000;">
			<?php echo $vendorsDisplay[$vendor] ?>
		</span>
		</center>
<?php
        while ($row = $result->fetch()) {
		$txt = $row['display'];
		if (file_exists("./img/$vendor/".strtolower($row['category']).".jpg"))  {
			if ($count%$resultsOnLine == 0)  {
				print "<div class=\"row\">";
				$divCount = 1;
			}
?>
                       	<div class="col custRecordDisplay">
                               	<a href="/results.php?type=<?php echo $row['category'] ?>&vendor=<?php echo $vendor ?>">
                                       	<img src='img/<?php echo $vendor ?>/<?php echo strtolower($row['category']) ?>.jpg' width='100' height='150' />
                               	</a>
				<div class="row centerTxt">
                               	<b><?php echo $txt ?></b><br />
				</div>
                       	<br />
                       	<br />
                       	</div>
<?php
			if ($divCount == $resultsOnLine)  {
				print "</div>";
			}
			$count++;
			$divCount++;
		}  else  {  
			$filename = "missingSKU.txt";
			$txt = "Missing vendor ".$vendor." line |".$row['category']."|\n";
			file_put_contents($filename,$txt,FILE_APPEND | LOCK_EX);
		}
	}
	if ($count%$resultsOnLine != 0)  {
		print "</div>";
	}
?>
		</div>


<?php
	require 'foot.php';
?>
