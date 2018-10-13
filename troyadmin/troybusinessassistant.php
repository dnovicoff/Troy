<?php
	require("../pages/common.php");
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
	<title>Troy Business Assistant</title>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>
	<script src="../javascript/taconite.js" type="text/javascript"></script>
	<script src="../javascript/spin.min.js" type="text/javascript"></script>

	<script type="text/javascript">
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

		function getAJAX(pos,id)  {
			var target = document.getElementById('loader');
			var spinner = new Spinner(opts).spin(target);
			$.ajax({
				type:"POST",
				url:"../pages/troybusinessassistantresults.php",
				data:{ pos:""+pos,id:""+id },
				datatype:"text",
				success:function (data)  {  
					spinner.stop();
				},
				error:function (data)  {  
					spinner.stop();
					alert(data);
				}
			});
			$('#position').val(pos);
		}
		function getData(direction)  {
			var pos = parseInt($('#position').val());
			if (direction == "back")  {
				pos = pos - 1;
			}  else  {
				pos = pos + 1;
			}
			getAJAX(pos,"");
		}
		function findID(e)  {
			var sku = "";
			if (e.keyCode == "13")  {
				sku = $('#customerID').val();
				getAJAX(0,sku);
			}
			return false;
		}

		$(document).ready(function ()  {
			var pos = parseInt($('#position').val());
			getAJAX(pos+1,"");
		});
	</script>
	</head>
	<body>
	TROY BUSINESS ASSISTANT<br />
	Get specific customer ID: 
	<input type="text" id="customerID" placeholder="Customer ID" onkeypress="findID(event);" /><br />
	<input type="hidden" id="position" value="0" />
	<input type="button" id="back" value="-" onclick="getData('back');" />
	<input type="button" id="forward" value="+" onclick="getData('forward');" /><br />
	<div id="loader"></div>
	<div id="centerFrame">
	</div>
	</body>
</html>
	
