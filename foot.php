

<?php	
	if ($_SERVER['PHP_SELF'] == "/index.php" || $_SERVER['PHP_SELF'] == "/Home.php")  {  
		$select = "SELECT * FROM go ".
			"ORDER BY godate DESC LIMIT 1";
		$query = $db->prepare($select);
		$query->execute();
		$godate = "";
		$http = "";
		while ($row = $query->fetch())  {
			$update = $row['shipdate'];
			$http = $row['godate'];
		}
?>
	<div class="container setWidth" style="border:4px solid red;background-image:none;">
		<div class="row" style="border:0px solid">
			<div class="col footBorderStyleLeft">
				<div id="slideshow2">
					<div>
						<img srC="/img/veteransdayopenhouse.jpg" />
					</div>
					<div>
						<img src="/img/Fabriganza.jpg" />
					</div>
				</div>
			</div>
			<div class="col footBorderStyleRight">
				<div style="background-image:url('/img/GOProgram.gif')">
					<div class="content">
						<div class="general" style="padding-bottom:4px;">
							<center>
							Fall in line with Troy's<br />
							General Order Program!<br />
							</center>
						</div>
						<span class="data">
							<center>
							<font color="blue">
							Check Out the Offerings<br />
							<a href="/goDetail.php?dt=<?php echo $http ?>">
							<?php echo $update ?>
							</a>
							</font>
							<center>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php	}  ?>

<div class="container setWidth" style="border:none;background-image:none;">
	<div class="row">
		<div class="col" style="width:33%">
			<a href="https://www.facebook.com/TroyCorporation" target="_blank">
				<img src="/img/facebooklogo.gif" />
			</a>
			<a href="https://twitter.com/TroyCorporation" target="_blank">
				<img src="/img/twitterlogo.gif" />
			</a>
			<a href="http://instagram.com/troycorporation" target="_blank">
				<img src="/img/instagramlogo.gif" />
			</a>
		</div>
		<div class="col" style="width:33%">
			<center>
				<b>Troy Corporation</b><br />
				2701 N. Normandy Ave. Chicago Il. 60707
			</center>
		</div>
		<div class="col" style="width:33%;text-align:right;">
			Email: troycorp@troy-corp.com<br />
			Fax: (773) 804-0906
		</div>
	</div>
</div>

</body>
