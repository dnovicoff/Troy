

<taconite>
	<replace select="#centerFrame">
		<script type="text/javascript">
		</script>

<?php
	$type = $_POST["type"];
	$vendor = $_POST['vendor'];
	$server = "127.0.0.1";
	$user = "troy";
	$pass = "troy4troy";
	$database = "inventory";
	$select = "SELECT t1.sku,t1.price FROM item as t1,category as t2 WHERE ".
		"t1.category = t2.categoryID AND t2.category='".$type."'".
		" AND t1.active = 1 AND t2.active = 1 ORDER BY t1.sku ASC";
	$conn = mysql_connect($server,$user,$pass);

	$db_found = mysql_select_db($database,$conn);
	if ($db_found)  {
		$result = mysql_query($select);
		$count = 0;
		$divCount = 1;
?>
		<img src="img/<?php echo $vendor ?>/banner.gif" />
<?php
		while ($row = mysql_fetch_assoc($result) ) {
			if ($count%4 == 0)  {
				print "<div class=\"row\">";
				$divCount = 1;
			}
?>
					<div class="col" style="width:21%">
						<a href="#" class="links" id="detail<?php echo $vendor ?><?php echo $row['sku']; ?>">
						<img class="resultsImgNav" src="img/<?php echo $vendor ?>/fabric/<?php echo $row['sku'] ?>_100x150.jpg" />
						</a><br />
						<b><?php echo $row['sku']; ?></b><br />
						<?php echo $row['price']; ?><br />
					</div>
<?php
			if ($divCount == 4)  {
				print "</div>";
			}
			$count++;
			$divCount++;
		}
		if ($count%4 != 0)  {
			print "</div>";
		}
	}  else  {
		print "$database NOT Found ";
	}
?>
	</replace>

	<eval><![CDATA[
	]]></eval>
</taconite>
