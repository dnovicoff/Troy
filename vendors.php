<?php
	require 'head.php';
	$sorts = array('0' => "A-E",'6' => "F-Q",'13' => "R-Z");

        $select = "SELECT t1.vendor,t1.display ".
		"FROM vendor AS t1 ".
		"ORDER BY t1.vendor ASC";

	$newList = 0;
        $results = $db->prepare($select);
	$results->execute();
?>
	<div class="container" id="centerFrame">
		<div class="fabricSlideshow">
			<div class="inner">
				<img src="img/vendors/Tidal-Lace.jpg" />
				<img src="img/vendors/enchanted.jpg" />
				<img src="img/vendors/Follie.jpg" />
				<img src="img/vendors/ohclementine.jpg" />
				<img src="img/vendors/petitefleur.jpg" />
				<img src="img/vendors/wildfield.jpg" />
				<img src="img/vendors/Tidal-Lace.jpg" />
			</div>
		</div>

		<center><b>Fabric Vendors</b></center><br />
		<div class="row" style="padding-bottom:10px;padding-left:10px;">
		Troy carries fabric from many of the top vendors. Choose from the list below
		to view and purchase from our vast inventory.
		</div>
		<div class="row" style="padding-left:10px">
		<a href="./vendorLine.php?vendor=riverwoods">
			Riverwoods Collection
		</a>
		by Troy, our own line of designer fabrics. Available only from Troy.<br />
		</div>
		<div class="row" style="padding-left:10px">
		<a href="/vendorLine.php?vendor=go">
			Excelsior Flatfold / Remnant Bundles
		</a>
		short cuts of fabric at bargain prices.
		</div>
		<div class="row" style="padding-left:10px">
		<a href="/vendorLine.php?vendor=tnt">
			TNT Promotional Fabrics
		</a>
		15 yard bolts of first quality fabric from top mills at low low prices.
		</div>
<?php
       while ($row = $results->fetch()) {
		if ($newList == 0 || $newList == 6 || $newList == 13)  {
			echo "<div class=\"col custVendorDisplay\">";
			echo "<div class\"row\" style=\"padding-left:70px;padding-top:20px\">";
			echo "<b>".$sorts[$newList]."</b><br />";
			echo "</div>";
			echo "<ul>";
		}
		if ($row['vendor'] != "house" && $row['vendor'] != "sale")  {
			$href = "./vendorLine.php?vendor=".$row['vendor'];
?>
			<li>
                     		<a href="./vendorLine.php?vendor=<?php echo $row['vendor'] ?>">
					<?php echo $row['display'] ?>
                      		</a>
			</li>
<?php
		}
		if ($newList == 5 || $newList == 12 || $newList == 23)  {
			echo "</ul>";
			echo "</div>";
		}
		if ($row['vendor'] != "house")  {
			$newList++;
		}
	}
?>
		<br />
		<br />
		<br />
	</div>
</div>


<?php
	require 'foot.php';
?>
