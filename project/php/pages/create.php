<!DOCTYPE html>
	<head>
		<link href="../../css/style.css" rel="stylesheet">
	</head>

	<body>
		<!--Include the PHP script that will handle this form and the creation of the virtual machine-->
		<?php include '../handlers/createHandler.php';?>
		<h3>Create a new VM</h3>
		<div class="formdiv">			
			<p>Please fill in the following parameters to create a new virtual machine.</p>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<table>
					<tr>						
						<td>Virtual machine name:</td>
						<td><input type="text" name="vmName" id="vmName" value="<?php echo $_POST['vmName']; ?>"></td>
					<tr>

					<tr>						
						<td>Amount of RAM:</td>
						<td><input type="text" name="vmRam" id="vmRam" value="<?php echo $_POST['vmRam']; ?>"></td>
						<td>
							<select name="ramSizeUnit">
								<option value="MB">MB</option>
								<option value="GB">GB</option>
							</select>
						</td>
					<tr>

					<tr>						
						<td>Hard drive size:</td>
						<td><input type="text" name="hardDriveSize" id="hardDriveSize" value="<?php echo $_POST['hardDriveSize']; ?>"></td>
						<td>
							<select name="hddSizeUnit">
								<option value="MB">MB</option>
								<option value="GB">GB</option>
							</select>
						</td>						
					<tr>

					<tr>						
						<td>Processor count:</td>
						<td><input type="text" name="processorCount" id="processorCount" value="<?php echo $_POST['processorCount']; ?>"></td>
					<tr>

					<tr>
						<td>Choose installation image:</td>
						<td>
							<!--Get values through PHP-->
							<?php getImages(); ?>
						</td>
					<tr>

					<tr>
						<td>Start VM after creation?</td>
						<td><input type="checkbox" name="startVM" value="checked"></td>
					</tr>	

					<tr>
						<td><input type="submit" name="submit" value="Create" /></td>
					</tr>															
				</table>
			</form>

			
		</div>

	</body>

</html>