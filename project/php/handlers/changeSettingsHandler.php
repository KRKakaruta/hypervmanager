<?php
	//This script will handle VM settings changes
	$user = 'Administrator';

	function showHTML($VMName){
			//Return html on page load
			
			echo '<table class="tableSummary">';

			//Change amount of RAM
			echo '<tr>';
			echo '<td>';
			echo 'Amount of RAM';
			echo '</td>';
			echo '<td>';
			echo '<input type="text" name="AmountRAM" id="AmountRAM" value="">';
			echo '</td>';
			echo '<tr>';


			//Change amount of CPU cores	
			echo '<tr>';
			echo '<td>';
			echo 'Number of CPU Cores';
			echo '</td>';
			echo '<td>';
			echo '<input type="text" name="AmountCPUCores" id="AmountCPUCores" value="">';
			echo '</td>';
			echo '</tr>';

			//Submit button
			echo '<tr>';
			echo '<td>';
			echo '<button type="submit" name="save" value="'.$VMName.'" id="save">Save</button>';

			echo '</td>';
			echo '</tr>';	

			echo '</table>';

	}

	//Action handlers
	if(isset($_POST['save'])){
		//changeSettings();
		$MachineName = $_POST['save'];
		$AmountRAM = $_POST['AmountRAM'];
		$AmountCPUCores = $_POST['AmountCPUCores'];

		shell_exec("powershell -command ..\\..\\powershell\\vmchangeoperations.ps1 $MachineName changememory $AmountRAM -username $user<NUL");
		shell_exec("powershell -command ..\\..\\powershell\\vmchangeoperations.ps1 $MachineName changeprocessors $AmountCPUCores -username $user<NUL");	

		header( 'Location: vmdetail.php?vmname='.$MachineName );
	}



?>