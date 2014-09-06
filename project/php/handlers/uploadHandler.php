<?php
	//Functions
	function uploadImage(){
		//Change PHP settings
		
		ini_set('upload_max_filesize', '6000M');
		ini_set('post_max_size', '6000M');
		ini_set('max_input_time', 3000);
		ini_set('max_execution_time', 3000);
		

		$allowedExts = array("iso"); //jpg for debugging purposes :)
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		
	 	if (in_array($extension, $allowedExts)){ //Check if used extension is in the list of allowed extensions.
	 		$target_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . basename( $_FILES['file']['name']); 
			if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
	    		echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
			} 
			else{
	    		echo "There was an error uploading the file, please try again!";
			}
		}		
		
	}

	//Action handlers
	if(isset($_POST['uploadImage'])){
		uploadImage();
		$fileName = $_FILES['file']['name'];
		shell_exec("powershell -command ..\\..\\powershell\\copyimage.ps1 $fileName -username $user<NUL");	
	
	}


?>