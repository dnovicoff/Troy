<?php
	require 'head.php';
?>
	<div class="container" id="centerFrame">
<?php	
		$dir = "projects/";
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if (preg_match("/\w/",$file))  {
?>
						<a href="projects/<?php echo $file ?>">
						|<?php echo $file ?>|<br />
						</a>
<?php
					}
				}
			}
		}
?>
	</div>
</div>


<?php
	require 'foot.php';
?>
