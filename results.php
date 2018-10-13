<?php
	require 'head.php';

	$type = $_GET["type"];
	$vendor = $_GET['vendor'];

	$select1 = "SELECT t1.categoryID,t1.display FROM ".
		"category AS t1, line AS t2, vendor AS t3 ".
		"WHERE t1.lineID = t2.lineID ".
		"AND t3.vendorID = t2.vendorID ".
		"AND t3.vendor = '".$vendor."' ".
		"AND t1.category='".$type."' ".
		"ORDER BY t1.categoryID ASC";

	$id = 0;
	$collection = "";
	$result = $db->prepare($select1);
	$result->execute();
	while ($row = $result->fetch())  {
		$id = $row['categoryID'];
		$collection = $row['display'];
	}

	date_default_timezone_set('America/Chicago');
	$dt = date("Y-m-d",strtotime('-18 months'));
	if ($vendor == "riverwoods" || $vendor == "house" || $vendor == "sale")  {
		$dt = "0000-00-00 00:00:00";
	}
		
	$select2 = "SELECT t1.sku,t1.description,t1.price,t1.type FROM ".
		"item AS t1, itemcategory AS t2 ".
		"WHERE t1.sku = t2.sku AND ".
		"t2.categoryID = ".$id." ".
		"AND t1.active = 1 ".
		"AND t1.dt >= '".$dt."' ".
		"ORDER BY t1.sku ASC";

	$count = 0;
	$divCount = 1;
	$resultsPerLine = 6;
	$result = $db->prepare($select2);
	$result->execute();
	$fabricPurchase = "Fabric is priced by yard and sold In bolts of 15 yard increments ";
	if ($vendor == "riverwoods")  {
		$fabricPurchase .= "half bolts (7&#189; yards) are also available for purchase.<br />";
	}
	$fabricPurchase .= "<br />All Fabric is 100% cotton, 45'' wide unless, noted.<br />";
?>
	<div class="container" id="centerFrame">
	&nbsp;Return to 
	<b><a href="/vendorLine.php?vendor=<?php echo $vendor ?>" style="text-decoration:none">
		<?php echo ucfirst($vendorsDisplay[$vendor]) ?> Collection
	</a></b><br /><br />
	<center><b><?php echo $collection ?> Collection</b><br />
	<?php echo $fabricPurchase ?></center>

<?php
	while ($row = $result->fetch())  {
		if (file_exists("img/".$vendor."/fabric/".$row['sku']."_100x150.jpg"))  {
			if ($count%$resultsPerLine == 0)  {
				print "<div class=\"row\">";
				$divCount = 1;
			}
			$desc = "";
			$reg = '/.?'.strtoupper($collection).'\s?(\D+\s?\D?)\s?\d+/';
			if (preg_match($reg,$row['description'],$match))  {
				$desc = $match[1];
			}
			$type = $row['type'];
			$typereg = '/Cotton/';
			if (preg_match($typereg,$type,$typematch))  {
				$type = "";
			}
?>
			<div class="col custFabricDisplay custFabricDisplayContainer">
				<img id="<?php echo $row['sku'] ?>" class="resultsImgNav" src="img/<?php echo $vendor ?>/fabric/<?php echo $row['sku'] ?>_100x150.jpg" onclick="showColorbox(this);" onMouseOver="changeCursor(this);" />
				<div class="row centerTxt">
				<b><?php echo $row['sku']; ?></b><br />
				<?php echo $desc ?><br />
				<?php echo $type ?><br />
<?php
				setlocale(LC_MONETARY,'en_US');
				if (!empty($_SESSION['user']))  {
?>
					Quantity:<br />
					<div class="row" style="width:100%">
						<div class="col" style="width:30%">
							bolt
						</div>
						<div class="col" style="width:43%">
							<b>$<?php echo number_format($row['price'],2); ?>:</b>
						</div>
						<div class="col" style="width:27%">
							<input type="text" class="textClass" id="full<?php echo $row['sku'] ?>" value="0" maxlength="2" size="2" />
						</div>
					</div>
<?php					if ($vendor == "riverwoods" || $vendor == "house")  {  ?>
						<div class="row" style="width:100%">
							<div class="col" style="width:30%">
								&#189; bt
							</div>
							<div class="col" style="width:43%">
								<b>$<?php echo number_format($row['price']+0.25,2); ?>:</b>
							</div>
							<div class="col" style="width:27%">
								<input type="text" class="textClass" id="half<?php echo $row['sku'] ?>" value="0" />
							</div>
						</div>
<?php					}  ?>
					<a href="#" class="buy" name="<?php echo $row['sku'] ?>">Add to Cart</a>
<?php				}  ?>
					</div>
					<br />
				</div>
<?php
			if ($divCount == $resultsPerLine)  {
				print "</div>";
			}
			$count++;
			$divCount++;
		}  else  {
			$filename = "missingSKU.txt";
			$txt = "Missing IMAGE for sku: ".$row['sku']." from collection ".$collection." Vendor: ".$vendor."\n";
			file_put_contents($filename,$txt,FILE_APPEND | LOCK_EX);
		}
	}
	if ($count%$resultsPerLine != 0)  {
		print "</div>";
	}
?>
		</div>
	<script>
		var target = document.getElementById('loader');

		function showColorbox(obj)  {
			sku = "sku="+obj.id+"&vendor=<?php echo $vendor ?>";
			http = "/pages/detail.php?"+sku;
			$('.resultsImgNav').colorbox({rel:'overlay',href:''+http,width:'300px',height:'510px'});
		} 
		$('.buy').click(function (data)  {
			var vendor = "<?php echo $vendor ?>";
			var sku = $(this).attr("name");
			var full = $('#full'+sku).val();
			var half = 0;
			var qtyTxt = "";
			if (vendor == "riverwoods" || vendor == "house")  {
				half = $('#half'+sku).val();
				qtyTxt = "either half or ";
			}

			if (half != 0 || full != 0)  {
				var spinner = new Spinner(opts).spin(target);
				var alt = "Your bolt(s) is in your cart. To edit your cart\'s contents or complete your purchase, please click the cart icon in the upper right hand corner.";
				$.ajax({
                			type:"POST",
                			url:"pages/purchase.php",
                			data: { sku: ""+sku,full: ""+full,half: ""+half },
                			success:function (data)  {
						spinner.stop();
						var cart = parseInt($('#cartcount').text());
						var h = parseInt(half,10);
						var f = parseInt(full,10);
						cart = cart+h+f;
						$('#cartcount').html(cart);
						$('#hiddenCartCount').val(cart);
						alert(alt);
                			}
        			});
			}  else  {
				alert("You have to fill in a quantity for "+qtyTxt+"full bolt orders");
			}
        	});
		function changeCursor(obj)  {
			$('#'+obj.id).css('cursor','pointer');
		};
	</script>

<?php
	require 'foot.php';
?>
</html>
