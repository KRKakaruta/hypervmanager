<?php
	/*This script will handle the creation of a new VM in terms of the form validation and creation itself.*/
	$user = 'Administrator'; //Change this later => user used for the execution of powershell scripts

	//Fill the dropdown list in the form with the available images.
	$availableImages = preg_split('/\s+/',shell_exec("powershell -command ..\\..\\powershell\\basicoperations.ps1 getimages -username $user<NUL")); //Split result set on space.

	//Virtual machine attributes
	$vmName;
	$vmRam;
	$hardDriveSize;
	$processorCount;
	$selectedImage;

	if(isset($_POST['submit'])){
		$vmName = (filter_var($_POST['vmName'], FILTER_SANITIZE_STRING));
		$vmRam = (filter_var($_POST['vmRam'], FILTER_SANITIZE_STRING));
		$hardDriveSize = (filter_var($_POST['hardDriveSize'], FILTER_SANITIZE_STRING));
		$processorCount = (filter_var($_POST['processorCount'], FILTER_SANITIZE_STRING));
		$ramSizeUnit = (filter_var($_POST['ramSizeUnit'], FILTER_SANITIZE_STRING)); //MB or GB?
		$hddSizeUnit = (filter_var($_POST['hddSizeUnit'], FILTER_SANITIZE_STRING)); //MB or GB?
		$selectedImage = (filter_var($_POST['selectedImage'], FILTER_SANITIZE_STRING)); //Selected installation image

		//Concatenate sizes with unites so that it can be used directly in the execution of the script
		//Minimum is 512MB at the moment (even if the supplied value is lower)
		$vmRam .= $ramSizeUnit;
		$hardDriveSize .= $hddSizeUnit;


		/*Run the Powershell script with the parameters*/
		shell_exec("powershell -command ..\\..\\powershell\\createserver.ps1 $vmName $vmRam $hardDriveSize $processorCount -username $user<NUL");
		shell_exec("powershell -command ..\\..\\powershell\\mount.ps1 $vmName $selectedImage -username $user<NUL");

		/*Check if VM should be started after creation. Start if checkbox is checked.*/
		if(isset($_POST['startVM'])){
			shell_exec("powershell -command ..\\..\\powershell\\standardoperations.ps1 $vmName start -username $user<NUL");
		}		

		//Redirect to overview
		header( 'Location: ../../index.php' );

	}




	//Functions
	function getImages(){
		//This function checks which installation images are available on the server, and loads them into the dropdown list.
		global $availableImages;
		echo '<select name="selectedImage">';

		foreach ($availableImages as $image) {
			if(strlen($image) > 0){
				echo '<option value="'.$image.'">'.$image.'</option>';
			}
			
		}
		echo '</select>';

	}

?>