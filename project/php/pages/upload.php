<!DOCTYPE html>
	<head>
		<link href="../../css/style.css" rel="stylesheet">
	</head>

	<body>
		<!--Include the PHP script that will handle this form and the creation of the virtual machine-->		
		<h3>Upload image</h3>
		<div class="formdiv tile">
			<p>Select an installation image to upload to the server (.iso only).</p>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
 				<label for="file">Filename:</label>
 				<input type="file" name="file" id="file"><br>
 				<br><input type="submit" name="uploadImage" value="Upload">
 				<?php include '../handlers/uploadHandler.php';?>
 			</form>			
		</div>

		<h3>Download image from URL</h3>
		<div class="formdiv tile">
			<p>Specify the URL of an installation image. The image will then be downloaded directly to the server.
			   <br>You will be notified when the download is complete.
			   <br>Feel free to close this page and do something else. The image will keep downloading.

			</p>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td><label for="imageURL">Image URL:</label></td>
						<td><input type="text" name="imageURL" id="imageURL" value="<?php echo $_POST['imageURL']; ?>"></td>
					</tr>

					<tr>
						<td><label for="localName">Local name (with extension):</label></td>
						<td><input type="text" name="localName" id="localName" value="<?php echo $_POST['localName']; ?>"></td>
					</tr>

				
				
				
					<tr>
						<td></td>
						<td><input type="submit" name="downloadImageToServer" value="Download"></td>
					<tr>
 				
 				</table>
 				<br>
 				<?php include '../handlers/imageDownloadHandler.php';?>
 			</form>			
		</div>		

	</body>

</html>