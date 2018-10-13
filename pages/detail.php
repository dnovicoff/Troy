

<taconite>
	<replace select=".overlayPage">
<?php
	require("common.php");

	$sku = $_GET['sku'];
	$vendor = $_GET['vendor'];
	$description = "";

	$select = "SELECT t1.sku,t1.price,t1.description FROM item as t1 ".
		"WHERE t1.sku = '".$sku."'";

	$result = $db->prepare($select);
	$result->execute();
	while ($row = $result->fetch())  {
		$description = $row['description'];
	}
?>
	<div class="row">
		<img src="img/<?php echo $vendor ?>/fabric/<?php echo $sku ?>_300x450.jpg" style="float:none;" width="300" height="450" />
	</div>
	</replace>

	<replace select=".overlayPageTitle">
		<?php echo $description ?>
	</replace>

	<eval><![CDATA[
	]]></eval>
</taconite>
