<!DOCTYPE html>
	<head>
		<link href="../../css/style.css" rel="stylesheet">
	</head>

	<body>
	<!--	<?php
			//$url=$_SERVER['REQUEST_URI'];
			//header("Refresh: 5; URL=$url"); 
		?> -->
		<?php include '../handlers/infoHandler.php';?>

		<h3><?php echo $_GET['vmname'];?> Details</h3>
		<div class="tile">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">				
				<?php getDetails($_GET['vmname']); ?>
			</form>
			<br>
			<br>
			<?php 
				$VMName = $_GET['vmname'];
				echo '<a href="../pages/changeSettings.php?vmname='.$VMName.'">Change '.$VMName.' settings</a>';

			?>

		</div>


		
	</body>

</html>

