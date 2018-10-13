

<taconite>
	<replace select="#centerFrame">
		<div class="container">
<?php
	require("common.php");

	if (!empty($_SESSION['user']))  {
?>
			<center><b>Your Shopping Cart</b></center>
<?php
		if (isset($_SESSION['list']))  {
			$purchase = $_SESSION['list'];
			$items = explode(" ",$purchase);
		}
		$id = $_SESSION['user']['customerid'];
		$address = "";
		$city = "";
		$state = "";
		$zip = "";
		$email = "";
		$phone = "";
		$stateID = 0;

		$select = "SELECT t2.address,t3.zip,t4.city,t4.stateID ".
			"FROM customeraddress AS t2,zip AS t3,city AS t4 ".
			"WHERE t2.zipID = t3.zipID ".
			"AND t3.cityID = t4.cityID ".
			"AND t2.customerID = '".$id."' ".
			"ORDER BY t2.created DESC LIMIT 1";

		$query = $db->prepare($select);
 		$query->execute();
 		while ($row = $query->fetch())  {
			$address = $row['address'];
			$city = $row['city'];
			$zip = $row['zip'];
			$stateID = $row['stateID'];
		}

		$select = "SELECT t2.email FROM ".
			"customer AS t1,customeremail AS t2 ".
			"WHERE t1.customerID = t2.customerID ".
			"AND t1.customerID = '".$id."'";
		$query = $db->prepare($select);
 		$query->execute();
 		while ($row = $query->fetch())  {
			$email = $row['email'];
		}

		$select = "SELECT t2.number FROM ".
			"customer AS t1,phone AS t2 ".
			"WHERE t1.customerID = t2.customerID ".
			"AND t1.customerID = '".$id."'";
		$query = $db->prepare($select);
		$query->execute();
		while ($row = $query->fetch())  {
			$phone = $row['number'];
		}

		$select = "SELECT * FROM state ";
		$query = $db->prepare($select);
		$query->execute();
?>
		<div class="row">
			<div class="custCartDisplay">ID:</div>
			<div class="custCartDisplay">
				<?php echo $id ?>
				<input type="hidden" id="set" value="" />
			</div>
		</div>
		<div class="row">
			<div class="custCartDisplay">Address:</div>
			<div class="custCartDisplay"><input type="text" id="custaddr" value="<?php echo $address ?>" /></div>
		</div>
		<div class="row">
			<div class="custCartDisplay">City:</div>
			<div class="custCartDisplay"><input type="text" id="custcity" value="<?php echo $city ?>" /></div>
		</div>
		<div class="row">
			<div class="custCartDisplay">State:</div>
			<div class="custCartDisplay">
				<select name="state" id="custstate">
					<option value="Choose">Choose</option>
<?php
				while ($row = $query->fetch())  {
					if ($row['stateID'] == $stateID)  {
?>
						<option value="<?php echo $row['stateID'] ?>" selected="selected"><?php echo $row['state'] ?></option>
<?php
					}  else  {
?>
						<option value="<?php echo $row['stateID'] ?>"><?php echo $row['state'] ?></option>
<?php
					}
				}
?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="custCartDisplay">Zip:</div>
			<div class="custCartDisplay"><input type="text" id="custzip" value="<?php echo $zip ?>" /></div>
		</div>
		<div class="row">
			<div class="custCartDisplay">Email:</div>
			<div class="custCartDisplay"><input type="text" id="custemail" value="<?php echo $email ?>" /></div>
		</div>
		<div class="row">
			<div class="custCartDisplay">Phone</div>
			<div class="custCartDisplay"><input type="text" id="custphone" value="<?php echo $phone ?>" /></div>
		</div>
		<center>
			<a href="#" id="updateCustRecords">
				<img src="/img/updaterecords.png" />
			</a>
		</center>

<?php
		$total = 0;
		foreach ($items as $item)  {
			if (strlen($item) > 4)  {
				$subtotal = 0.0;
				$parts = explode(":",$item);
				$ven = substr($parts[0],0,3);
				$select = "SELECT price FROM item ".
					"WHERE sku = '".$parts[0]."'";
				$price = 0.0;
				$full = (int) $parts[1];
				$half = (int) $parts[2];
				$query = $db->prepare($select);
 				$query->execute();
				while ($row = $query->fetch())  {
					$price = $row['price'];
				}
				$length = "15";
				$amount = 15;
				if ($half > 0)  {
					$length = "7 1/2";
					$full = $half;
					$price = $price+0.25;
					$amount = 7.5;
				}
				$subtotal = $price * $full * $amount;
				$total = $total + $subtotal;
?>
				<div class="row" id="row<?php echo $parts[0] ?>">
					<div class="col" style="width:30%">
						<img src="/img/<?php echo $vendorsArray[$ven] ?>/fabric/<?php echo $parts[0] ?>_100x150.jpg" />
					</div>
					<div class="col">
						SKU: <b><?php echo $parts[0] ?></b><br />
						Quantity: 
						<input type="text" class="textClass" id="qty<?php echo $parts[0] ?>" value="<?php echo $full ?>" /> bolts<br />
<?php						if ($half > 0)  {  ?>
							half bolt order<br />
<?php						}  ?>
						Price: <b>$<?php echo number_format($price,2); ?></b><br />
						<input type="hidden" id="hiddenPrice<?php echo $parts[0] ?>" value="<?php echo $price ?>" />
						Total: <b>$<span id="total<?php echo $parts[0] ?>">
						<?php echo number_format($subtotal,2) ?>
						</span>
						<input type="hidden" id="hidden<?php echo $parts[0] ?>" value="<?php echo $subtotal ?>" />
						</b> total in <?php echo $length ?> yrd bolts
						<br />
						<a href="#" id="<?php echo $parts[0] ?>" class="remove">Remove Item</a><br />
					</div>
				</div>
<?php
			}
		}
?>
		<div class="row">
			<div class="col" style="width:30%"></div>
			<div class="col">
				Total this order: <b>$<font color="red">
					<input type="hidden" id="hiddenOrderTotal" value="<?php echo $total ?>" />
<?php 					setlocale(LC_MONETARY,'en_US');  ?>
					<span id="orderTotal">
						<?php echo number_format($total,2); ?>
					</span>
				</font></b><br />
			</div>
		</div>
		<center>
<?php			if (count($items) > 1)  {  ?>
				A receipt will be e-mailed to the adddress<br />
				above. Please make sure our records are correct<br />
				before checkout<br />
				<a href="#" id="customerCheckout">
					<img src="/img/checkout.png" />
				</a>
<?php			}  ?>
		</center>
<?php	}  ?>
		</div>
	</replace>

	<eval><![CDATA[
		var opts = {
 			lines: 13, // The number of lines to draw
 			length: 20, // The length of each line
 			width: 10, // The line thickness
 			radius: 30, // The radius of the inner circle
 			corners: 1, // Corner roundness (0..1)
 			rotate: 0, // The rotation offset
 			direction: 1, // 1: clockwise, -1: counterclockwise
 			color: '#000', // #rgb or #rrggbb or array of colors
 			speed: 1, // Rounds per second
 			trail: 60, // Afterglow percentage
 			shadow: false, // Whether to render a shadow
 			hwaccel: false, // Whether to use hardware acceleration
 			className: 'spinner', // The CSS class to assign to the spinner
 			zIndex: 2e9, // The z-index (defaults to 2000000000)
 			top: '50%', // Top position relative to parent
 			left: '50%' // Left position relative to parent
		};
		var target = document.getElementById('loader');

		function checkPhone(phone)  {
			var newNo = phone.replace(/\D/g,"");
			if (newNo.length == 10)  {
				return newNo;
			}  else  {
				return "";
			}
		}
		function validateEmail(email) { 
			var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    			return re.test(email);
		} 
		$("#updateCustRecords").click(function (event)  {
			var success = 1;
			var errors = {};

			var user = "<?php echo $id ?>";
			var addr = $('#custaddr').val();
			var city = $('#custcity').val();
			var state = $('#custstate').val();
			var zip = $('#custzip').val();
			var email = $('#custemail').val();
			var phone = $('#custphone').val();
			var uname = "";
			var pass = "";
			phone = checkPhone(phone);
			if (phone == "")  {
				errors['phone'] = "Please enter a 10 digit phone number";
			}
			if (!validateEmail(email))  {
				errors['email'] = "Please enter a valid email";
			}
			if (state == "Choose")  {
				errors['state'] = "Please select your state or not listed";
			}
			if (addr == "" || city == "" || zip == "")  {
				errors['blank'] = "Please enter an address, city, and zip";
			}
			if (Object.keys(errors).length == 0)  {
				var spinner = new Spinner(opts).spin(target);
				$.ajax({
                			type:"POST",
                			url:"pages/customerUpdate.php",
                			data: { addr:""+addr,city:""+city,state:""+state,zip:""+zip,email:""+email,phone:""+phone,user:""+user,uname:""+uname,pass:""+pass },
					datatype: 'text',
                			success:function (data)  {
						spinner.stop();
						$('#custaddr').attr('disabled','disabled');
						$('#custcity').attr('disabled','disabled');
						$('#custstate').attr('disabled','disabled');
						$('#custzip').attr('disabled','disabled');
						$('#custemail').attr('disabled','disabled');
						$('#custphone').attr('disabled','disabled');
						$('#set').val("set");
                			},
					error: function(jqXHR, textStatus, errorThrown){
						spinner.stop();
 						alert(textStatus, errorThrown);
					}
        			});
			}  else  {
				var message = "";
				for (var error in errors)  {
					message += errors[error]+"\n";
				}
				alert(message);
			}
		});
		$("#customerCheckout").click(function (event)  {
			var success = 1;

			var user = "<?php echo $id ?>";
			var addr = $('#custaddr').val();
			var city = $('#custcity').val();
			var state = $('#custstate').val();
			var zip = $('#custzip').val();
			var email = $('#custemail').val();
			var phone = $('#custphone').val();
			var uname = "";
			var pass = "";
			if (addr == "" || city == "" || state == "" || zip == "" || email == "" || phone == "")  {
				success = 0;
			}
			if (success == 1)  {
				var spinner = new Spinner(opts).spin(target);
				$.ajax({
					type:"POST",
					url:"pages/checkout.php",
					data:{addr:""+addr,city:""+city,state:""+state,zip:""+zip,email:""+email,phone:""+phone,user:""+user,uname:""+uname,pass:""+pass},
					success:function (data)  {
						spinner.stop();
						alert("Thank you for your purchase\nYou will now be redirected to our home page.");
						window.location.href = "http://troy-corp.com/";
					},
					error:function (jqXHR, textStatus, errorThrown)  {
						spinner.stop();
						alert(textStatus, errorThrown);
					}
				});
			}  else  {
				alert("Please update your records for checkout.");
			}
		});
		$(".textClass").change(function (event)  {
			var patt = /^TRO/;
			var multiple = 15;

			if (multiple == 7)  {
			var qty = $(this).val();
			var sku = $(this).attr("id");
			sku = sku.substr(3,sku.length);
			var price = $("#hiddenPrice"+sku).val();
			var cartCount = $("#cartcount").html();
			isRiverwoods = patt.exec(sku);
			if (isRiverwoods == "TRO")  {
				multiple = 7.5;
			}
			var newTotal = parseInt(qty)*parseFloat(price)*multiple;
			$("#hidden"+sku).val(newTotal);
			$("#total"+sku).html(newTotal);
			$("#total"+sku).formatCurrency();
			
			var orderTotal = $('#hiddenOrderTotal').val();
			}
		});
		$(".remove").click(function (event)  {
			var sku = $(this).attr("id");
			var total = $("#hidden"+sku).val();
			var orderTotal = $('#hiddenOrderTotal').val();
			var qty = $("#qty"+sku).val();
			var cartQty = $("#hiddenCartCount").val();
			var newTotal = parseFloat(orderTotal) - parseFloat(total);
			var newQty = parseInt(cartQty)-parseInt(qty);

			var spinner = new Spinner(opts).spin(target);
			$.ajax({
				type:"POST",
				url:"pages/updateCart.php",
				data:{  sku:""+sku,full:"0",half:"0"  },
				success:function (data)  {
					spinner.stop();
					$('#cartcount').html(newQty);
					$('#hiddenCartCount').val(newQty);
					$('#orderTotal').html(newTotal);
					$('#hiddenOrderTotal').val(newTotal);
					$('#orderTotal').formatCurrency();
					$("#row"+sku).html("");
				},
				error:function (jqXHR, textStatus, errorThrown)  {
					spinner.stop();
					alert(textStatus, errorThrown);
				}
			});
		});
	]]></eval>
</taconite>
