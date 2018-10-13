<?php
	require("../pages/common.php");
	$dt = date('Y-m-d h:i:s');
	$count = 0;
	$dofw = date("w");
	$dofwOffset = $dofw-1;
	$week_start = date('Y-m-d 00:00:00', strtotime('-'.$dofwOffset.' days'));
	$week_end = date('Y-m-d 00:00:00', strtotime('+'.(7-$dofw).' days'));

	$promo = array(
                "CTN" => "CTN",
                "FLN" => "FLN",
                "INT" => "INT",
                "PLY" => "PLY",
                "CFS" => "CFS",
                "AU1" => "AU1",
                "AU2" => "AU2",
                "AU3" => "AU3",
                "AU4" => "AU4",
                "AU5" => "AU5",
                "AU6" => "AU6",
                "AU7" => "AU7",
                "AU8" => "AU8",
                "AU9" => "AU9",
                "RAY" => "RAY",
                "MSC" => "MSC",
                "DEN" => "DEN",
                "RMG" => "RMG",
                "RMC" => "RMC",
                "RMS" => "RMS"
        );
?>
<htmL>
	<head>
		<title>In Out list</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
		<script src="../javascript/taconite.js" type="text/javascript"></script>

		<link rel="stylesheet" href="../css/sales.css" type="text/css" charset="utf-8" />
		<script>
			function results()  {
				var prefix = $('#prefix').val();
				var status = $('#status').val();
				$.ajax({
                        		type:"GET",
                        		url:"../pages/inoutresults.php",
                        		data: { prefix:prefix+"",status:status+"" },
                        		// datatype: 'text',
                        		success:function(data)  {
                        		},
                        		error: function(jqXHR, textStatus, errorThrown){
                                		alert(textStatus, errorThrown);
                        		}
                		});
			}
		</script>
	</head>
	<body>
	This page will look for values between <?php echo $week_start ?><br />
	and <?php echo $week_end ?><br />
	Choose which SKU prefix you want: 
	<select id="prefix">
<?php 	while ($element = each($promo))  {  ?>
		<option value="<?php echo $element['key'] ?>">
		<?php echo $element['value'] ?></option>

<?php	}  ?>
	</select><br />
	Choose in = 1 or out = 0:
	<select id="status">
		<option value="1">1</option>
		<option value="0">0</option>
	</select><br />
	<button type="button" onclick="return results();">Results</button>
	<div id="centerFrame">

	</div>
	</body>
</html>



