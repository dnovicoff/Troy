<?php
	require("common.php");

	$sku = $_POST['sku'];
	$full = $_POST['full'];
	$half = $_POST['half'];

	$filename = "testing.txt";
	if (isset($_SESSION['user']))  {
		if (isset($_SESSION['list']))  {
			$orders = $_SESSION['list'];
			$items = explode(" ",$orders);
			$buildList = "";
			foreach($items as $item)  {
				$parts = explode(":",$item);
				$newItem = $item." ";
				if ($sku == $parts[0])  {
					$parts[1] = $full;
					$parts[2] = $half;
					if ($full == 0 && $half == 0)  {
						$newItem = "";
					}
				}
				$buildList .= $newItem;
			}
			$_SESSION['list'] = $buildList;
		}
	}
?>
