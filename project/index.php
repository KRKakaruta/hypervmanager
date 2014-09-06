<!DOCTYPE html>
	<head>
		<link href="css/style.css" rel="stylesheet">

	</head>

	<body>
		<?php
			//$url=$_SERVER['REQUEST_URI'];
			//header("Refresh: 5; URL=$url"); 
		?>
		<?php include 'php/handlers/infoHandler.php';?>
		<h3>Overview</h3>
		<div class="tile">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<table class="tableSummary">
					<tr>
						<th>VM Name</th>
						<th>Status</th>
						<th>Uptime</th>
						<th>Actions</th>					
					</tr>

					<!--Get machine data through PHP-->
					<?php getSummary(); ?>
				</table>
			</form>

		</div>

		<h3>Manage VMs</h3>
		<div class="tile">
			<a href="php/pages/create.php">Create VM</a>
			<br><a href="php/pages/upload.php">Upload images</a>

		</div>

		<h3>System info</h3>
		<div class="tile">
			<?php getSystemStats(); ?>			
			
		</div>		
	</body>

</html>