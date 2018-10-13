<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<html>
<?php
	$http = "http";
	$addr = "www.troy-corp.com";
	if (preg_match("/cart\.php#?$/",$_SERVER['SCRIPT_NAME']))  {
		$http = "https";
	}
	$addr = "http://".$addr;
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Troy Corporation : Home Page</title>
<link href="https://plus.google.com/109043500998768765878/" rel="publisher" />
<link rel="SHORTCUT ICON" href="http://www.troy-corp.com/favicon.ico"/>
<meta name="TITLE" content="Troy Corporation : Home Page" />
<meta name="OWNER" content="webmaster@troy-corp.com" />
<meta name="SUBJECT" content="Troy Corporation" />
<meta name="RATING" content="GENERAL" />
<meta name="COPYRIGHT" content="1995 - 2014 by Troy Corporation" />
<meta name="LANGUAGE" content="EN" />
<meta name="DESCRIPTION" content="Troy Corporation" />
<meta name="ABSTRACT" content="Troy Corporation" />
<meta name="Expires" content="2014/07/11">
<meta name="Revisit-After" content="1 Days">
<meta name="robots" content="all, index, follow">
<meta name="revised" content="2014/07/10">

<link rel="stylesheet" href="<?php echo $http; ?>://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/hot-sneaks/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/colorbox.css" />
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" charset="utf-8" />


<script src="<?php echo $http; ?>://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $http; ?>://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $http; ?>://www.troy-corp.com/javascript/jquery.tools.min.1.2.7.js"></script>
<script src="javascript/taconite.js" type="text/javascript"></script>
<script src="javascript/jquery.colorbox.js" type="text/javascript"></script>
<script src="javascript/cookie.js" type="text/javascript"></script>
<script src="javascript/dw_con_scroller.js" type="text/javascript"></script>
<script src="javascript/jquery.formatCurrency-1.4.0.pack-1.js" type="text/javascript"></script>
<script src="javascript/spin.min.js" type="text/javascript"></script>

<script src="javascript/main.js" type="text/javascript"></script>


</head>

<body>
<?php
	require("pages/common.php"); 
	$select = "SELECT godate FROM go ".
		"ORDER BY godate DESC LIMIT 1";
	$query = $db->prepare($select);
	$query->execute();
	$godate = "";
	while ($row = $query->fetch())  {
		$godate = $row['godate'];
	}

	$linkWidth = "265";
	$cartWidth = "0";
	$username = "";
?>

<div class="containerTop grad">
        <div class="contact">
                <div class="col" style="padding:1%;width:36%;">
			<b>
                        (800) 888-2400<br />
			<font size="2"> 
			Monday - Friday 8:30 am - 5:00 pm Central
			</font>
			</b>
                </div>
<?php
		$links = "";
		$submitted_username = "";
		$cartval = 0;
		if (isset($_SESSION['user']))  {
			$links = "Home.php";
			if (isset($_SESSION['list']))  {
				$purchase = $_SESSION['list'];
				$items = explode(" ",$purchase);
				foreach ($items as $item)  {
					if (strlen($item) > 4)  {
						$parts = explode(":",$item);
						$a = (int) $parts[1];
						$b = (int) $parts[2];
						$cartval = $cartval + $a + $b;
					}
				}
			}
			$linkWidth = "235";
			$cartWidth = "40";
			$username = $_SESSION['user']['first']." ".$_SESSION['user']['last'];
		}
?>
        </div>
	<div class="login">
		<div class="col" style="width:<?php echo $linkWidth ?>px;padding-left:10px;">
<?php
		$signin = "signin";
		$cart = "xxx";
		$browse = "browse";
                $submitted_username = "";
                if (!empty($_SESSION['user']))  {
                	$submitted_username = $_SESSION['user'];
			$signin = "logout";
			$cart = "viewcart";
			$browse = "logout";
?>
                        <div class="row">
				<div class="col" style="width:155px;">
                                	<b>Welcome: <br />
					<?php echo $username; ?>
                                	</b>
				</div>
				<div class="col" style="width:70px;">
					<a href="#">Logout</a>
				</div>
                        </div>
<?php		}  else  {  ?>
			<div class="row">
				<a href="#">Register</a>
				&nbsp;&nbsp; / &nbsp;&nbsp;
				<a href="#">Sign In</a>
			</div>
			<div class="row" style="font-size:12px;">
				<b>to see our wholesale pricing!</b>
			</div>
<?php 		}  ?>
		</div>
		<div class="col" style="width:<?php echo $cartWidth ?>px;">
			<input type="hidden" id="hiddenCartCount" value="<?php echo $cartval ?>" />
<?php			if (!empty($_SESSION['user']))  {  ?>
				(<span id="cartcount"><?php echo $cartval ?></span>)
<?php			}  ?>
		</div>
		<div class="col" style="width:35px;">
			<img src="/img/tinycart.gif" />
		</div>
	</div>

	<ul class="navigation">
		<li class="riverwoods">
			<a href="<?php echo $addr ?>/vendorLine.php?vendor=riverwoods"></a>
		</li>
		<li class="northfield">
			<a href="<?php echo $addr ?>/vendorLine.php?vendor=northfield"></a>
		</li>
		<li class="fabric">
			<a href="<?php echo $addr ?>/vendors.php"></a>
		</li>
		<li class="home">
			<a href="<?php echo $addr ?>/<?php echo $links ?>"></a>
		</li>
		<li class="embroidery">
			<a href="<?php echo $addr ?>/vendorLine.php?vendor=house"></a>
		</li>
		<li class="sale">
			<a href="<?php echo $addr ?>/vendorLine.php?vendor=sale"></a>
		</li>
		<li class="events">
			<a href="<?php echo $addr ?>/events.php"></a>
		</li>
		<li class="special">
			<a href="<?php echo $addr ?>/goDetail.php?dt=<?php echo $godate ?>"></a>
		</li>
		<li class="about">
			<a href="<?php echo $addr ?>/about.php"></a>
		</li>
		<!--
		<li class="contact">
			<a href="<?php echo $addr ?>/contact.php"></a>
		</li>
		-->
		<li class="cart" id="<?php echo $cart ?>">
			<a href="https://www.troy-corp.com/cart.php"></a>
		</li>
<?php		if (empty($_SESSION['user']))  {  ?>
			<li class="reg" id="<?php echo $browse ?>">
				<a href="<?php echo $addr ?>/register.php"></a>
			</li>
			<li class="enter" id="<?php echo $signin ?>">
				<a href="#"></a>
			</li>
<?php		}  else  {  ?>
			<li class="leave" id="<?php echo $signin ?>">
				<a href="#"></a>
			</li>
<?php		}  ?>
	</ul>
</div>

<div class="overlay" id="overlay" style="width:70%">
        <div class="overlayPageTitle" style="width:80%"></div>
        <div class="overlayPage" style=""></div>
</div>
<div id="loader"></div>
<div id="dialog">
	<h1>Login</h1>
 	<form action="pages/login.php" method="post" onsubmit="checkLogin();">
 		Account Number or Email address: <br />
 		<input type="text" name="id" id="loginID" value="" />
 		<br /><br />
 		Password:<br />
 		<input type="password" name="pass" id="loginPass" value="" />
		<br />
 		<input type="submit" value="Login" />
 	</form> 
</div>

