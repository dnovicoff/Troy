
<?php
	require("common.php");
	$sku = $_POST['sku'];
	$full = $_POST['full'];
	$half = $_POST['half'];

	if (!empty($_SESSION['user']))  {
		$_SESSION['list'] .= $sku.":".$full.":".$half." ";
?>
		success
<?php
	}  else  {
?>
		failure
<?php
	}
?>

