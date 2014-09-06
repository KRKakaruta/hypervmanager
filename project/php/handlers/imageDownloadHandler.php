<?php
	//Functions
	function downloadImageToServer($imageURL, $localName){
		//This function uses cURL to download images to the server.
		$user = 'Administrator';
		$path = '../../uploads/'.$localName;
		
    	$fp = fopen($path, 'w'); 
	    $ch = curl_init($imageURL);
	    curl_setopt($ch, CURLOPT_FILE, $fp);
	    $data = curl_exec($ch);
	    progress($ch);	 
	    curl_close($ch);
	    fclose($fp);	

	    
		
	}

	function progress($ch)
	{
		if(!curl_errno($ch))
		{
			$info = curl_getinfo($ch);

		 	echo '<br>Download complete. It took ' . $info['total_time'] . ' seconds to download the image from ' . $info['url'];
		}	    	
	}	

	//Action handlers
	if(isset($_POST['downloadImageToServer'])){
		$imageURL =  (filter_var($_POST['imageURL'], FILTER_SANITIZE_STRING));
		$localName =  (filter_var($_POST['localName'], FILTER_SANITIZE_STRING));
		downloadImageToServer($imageURL, $localName);
		//Call script to copy image to image directory
		$fileName = $localName;
		shell_exec("powershell -command ..\\..\\powershell\\copyimage.ps1 $fileName -username $user<NUL");	
		
	}




?>