<?php
	require 'head.php';

	$address = "";
	$city = "";
	$state = "";
	$zip = "";
	$email = "";
	$phone = "";
	$stateID = 0;

	$generated = "";
 	$count = 0;
 	$needed = 10;
 	while ($count < $needed)  {
 		$random = mt_rand(1,9);
 		$generated .= $random;
 		$count++;
	}
?>
	<div class="container setWidth">
		<div class="account">
			<div class="pad">
				<div class="row" style="font-size:30px;"><b>Create Account</b></div>
				<div class="row" style="visibility: hidden;">
					<input type="text" readonly="readonly" id="id" value="<?php echo $generated ?>">
				</div>
			</div>
			<div class="pad">
				<div class="row"><b>Your Name:</b></div>
				<div class="row"><input type="text" id="uname" value="" /></div>
			</div>
			<div class="pad">
				<div class="row"><b>Password</b></div>
				<div class="row"><input type="password" id="password" placeholder="At least 8 characters" /></div>
			</div>
			<div class="pad">
				<div class="row"><b>Password again</b></div>
				<div class="row"><input type="password" id="againpassword" value="" /></div>
			</div>
			<div class="pad">
				<div class="row"><b>Email</b></div>
				<div class="row"><input type="text" id="custemail" value="<?php echo $email ?>" /></div>
			</div>
			<div class="pad">
				<div class="row"><b>Email again</b></div>
				<div class="row"><input type="text" id="againcustemail" value="<?php echo $email ?>" /></div>
			</div>
			<div class="pad">
				<div class="row" style="width:100%;">
					<a href="#">
						<img id="register" src="/img/updaterecords.png" />
					</a>
				</div>
			</div>
		</div>
	</div>
<?php
	require "foot.php";
?>

</html>
