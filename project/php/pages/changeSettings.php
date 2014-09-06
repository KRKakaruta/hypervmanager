<!DOCTYPE html>
	<head>
		<link href="../../css/style.css" rel="stylesheet">
	</head>

	<body>
	<!--	<?php
			//$url=$_SERVER['REQUEST_URI'];
			//header("Refresh: 5; URL=$url"); 
		?> -->
		<?php include '../handlers/changeSettingsHandler.php';?>

		<h3>Change <?php echo $_GET['vmname'];?> settings</h3>
		<div class="tile">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">				
				<?php showHTML($_GET['vmname']); ?>
			</form>

		</div>


		
	</body>

</html>

