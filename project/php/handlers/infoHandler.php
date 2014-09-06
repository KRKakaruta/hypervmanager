<?php
	//This script will handle the requests of virtual machine information
	//Include classes
	include 'php/classes/vm.php';
	include 'php/classes/hostMachine.php';
	//include '../handlers/changeSettingsHandler.php'; //misschien nog fout?
	include 'php/handlers/mailHandler.php';


	$user = 'Administrator';
	$VMArray; //Array with VM objects

	//Functions
	function getSummary(){
		//This function will request basic information about every virtual machine. The different attributes are separated by "," and machines are separated by " ".
		global $user;
		global $VMArray;
		$VMData = preg_split('/\s+/',shell_exec("powershell -command powershell\\basicoperations.ps1 getvms -username $user<NUL")); //First make an array where every entry is a different virtual machine

		foreach($VMData as $VM){			
			//Split the parameters for every virtual machine and create an object.
			$VMCommaSplitted = explode(',',$VM);
			$VMObject = new VM();
			$VMObject->VMName = $VMCommaSplitted[0];
			$VMObject->status = $VMCommaSplitted[1];
			$VMObject->uptime = $VMCommaSplitted[2];
			$VMArray[] = $VMObject;

		}


		//Put data in HTML table
		for ($i = 0; $i < (count($VMArray)-1); $i++) {
			echo '<tr>';
			echo '<td>'.'<a href="php/pages/vmdetail.php?vmname='.$VMArray[$i]->VMName.'">'.$VMArray[$i]->VMName.'</a>'.'</td>';
			echo '<td>'.$VMArray[$i]->status.'</td>';
			echo '<td>'.$VMArray[$i]->uptime.'</td>';
			/*Add action buttons*/
			echo '<td>';
			if(($VMArray[$i]->status === 'Running')){
				echo '<button type="submit" name="suspend" value="'.$VMArray[$i]->VMName.'" />Suspend</button>';
				echo '<button type="submit" name="stop" value="'.$VMArray[$i]->VMName.'" />Stop</button>';		
				echo '<button type="submit" name="save" value="'.$VMArray[$i]->VMName.'" />Save</button>';		
			}

			if(($VMArray[$i]->status === 'Off')){
				echo '<button type="submit" name="start" value="'.$VMArray[$i]->VMName.'" />Start</button>';
				
			}

			if(($VMArray[$i]->status === 'Paused')){ //If suspended
				echo '<button type="submit" name="resume" value="'.$VMArray[$i]->VMName.'" />Resume</button>';
				echo '<button type="submit" name="stop" value="'.$VMArray[$i]->VMName.'" />Stop</button>';
				echo '<button type="submit" name="save" value="'.$VMArray[$i]->VMName.'" />Save</button>';
			}

			if(($VMArray[$i]->status === 'Saved')){
				echo '<button type="submit" name="start" value="'.$VMArray[$i]->VMName.'" />Start</button>';
				
			}			

			echo '<button type="submit" name="delete" value="'.$VMArray[$i]->VMName.'" />Delete</button>';

			echo '</td>';

			echo '</tr>';

		}

		

	}

	function getSystemStats(){
		//This function returns the statistics for the host system.
		$SysInfoSplitted = explode(';',shell_exec("powershell -command powershell\\serverstats.ps1 -username $user<NUL"));
		$hostMachine = new hostMachine();

		$hostMachine->OS = $SysInfoSplitted[0];
		$hostMachine->CPUType = $SysInfoSplitted[1];
		$hostMachine->CPUUsage = $SysInfoSplitted[2];
		$hostMachine->CurrentRAM = $SysInfoSplitted[3];
		$hostMachine->TotalRAM = $SysInfoSplitted[4];

		echo '<table class="tableSummary">';

		//Print OS
		echo '<tr>';
		echo '<td>';
		echo 'Operating System';
		echo '</td>';
		echo '<td>';
		echo $hostMachine->OS;
		echo '</td>';
		echo '</tr>';

		//Print CPU Type
		echo '<tr>';
		echo '<td>';
		echo 'CPU Info';
		echo '</td>';
		echo '<td>';
		echo $hostMachine->CPUType;
		echo '</td>';
		echo '</tr>';

		//Print CPU Usage
		echo '<tr>';
		echo '<td>';
		echo 'CPU Usage';
		echo '</td>';
		echo '<td>';
		echo $hostMachine->CPUUsage.'%';
		echo '</td>';
		echo '</tr>';

		//Print RAM Usage
		echo '<tr>';
		echo '<td>';
		echo 'RAM Usage';
		echo '</td>';
		echo '<td>';
		echo $hostMachine->CurrentRAM.'/'.$hostMachine->TotalRAM;
		echo '</td>';
		echo '</tr>';		


		echo '</table>';



	}

	function getDetails($VMName){
		//This function retrieves the detailed VM information.
		$MaxRam = shell_exec("powershell -command ..\\..\\powershell\\vmdetailoperations.ps1 $VMName getram -username $user<NUL");
		$Disks = shell_exec("powershell -command ..\\..\\powershell\\vmdetailoperations.ps1 $VMName getdisks -username $user<NUL");
		$AmountCPUCores = shell_exec("powershell -command ..\\..\\powershell\\vmdetailoperations.ps1 $VMName getprocessor -username $user<NUL");

		echo '<table class="tableSummary">';

		//Print max available RAM
		echo '<tr>';
		echo '<td>';
		echo 'Max amount of available RAM';
		echo '</td>';
		echo '<td>';
		echo $MaxRam;
		echo '</td>';
		echo '<tr>';

		//Print available disks
		echo '<tr>';
		echo '<td>';
		echo 'Hard drives';
		echo '</td>';
		echo '<td>';
		echo $Disks;
		echo '</td>';
		echo '<tr>';

		//Amount of CPU cores	
		echo '<tr>';
		echo '<td>';
		echo '# CPU Cores';
		echo '</td>';
		echo '<td>';
		echo $AmountCPUCores;
		echo '</td>';
		echo '<tr>';	

		echo '</table>';

	}


	/*Action handlers*/
	if(isset($_POST['start'])){
		$MachineName = $_POST['start'];
		shell_exec("powershell -command powershell\\standardoperations.ps1 $MachineName start -username $user<NUL");

		//Send automated e-mail
		sendMail("hypermanagermailer@gmail.com","Hypermanager","brentdp93@gmail.com","Brent","$MachineName is now running","This message was sent to inform you that your virtual machine: $MachineName has just been started.");
		//sendMail("hypermanagermailer@gmail.com","Hypermanager","brentdp93@gmail.com","Brent"," is now running","This message was sent to inform you that your virtual machine: has just been started.");
	}

	if(isset($_POST['stop'])){
		$MachineName = $_POST['stop'];
		shell_exec("powershell -command powershell\\standardoperations.ps1 $MachineName stop -username $user<NUL");
		sendMail("hypermanagermailer@gmail.com","Hypermanager","brentdp93@gmail.com","Brent","$MachineName is now stopped","This message was sent to inform you that your virtual machine: $MachineName has just been stopped.");

	}	

	if(isset($_POST['suspend'])){
		$MachineName = $_POST['suspend'];
		shell_exec("powershell -command powershell\\standardoperations.ps1 $MachineName suspend -username $user<NUL");		
		sendMail("hypermanagermailer@gmail.com","Hypermanager","brentdp93@gmail.com","Brent","$MachineName is now suspended","This message was sent to inform you that your virtual machine: $MachineName has just been suspended.");

	}	

	if(isset($_POST['resume'])){
		$MachineName = $_POST['resume'];
		shell_exec("powershell -command powershell\\standardoperations.ps1 $MachineName resume -username $user<NUL");
		sendMail("hypermanagermailer@gmail.com","Hypermanager","brentdp93@gmail.com","Brent","$MachineName is now running","This message was sent to inform you that your virtual machine: $MachineName has just been resumed.");
		
	}	

	if(isset($_POST['save'])){
		$MachineName = $_POST['save'];
		shell_exec("powershell -command powershell\\standardoperations.ps1 $MachineName save -username $user<NUL");		
		sendMail("hypermanagermailer@gmail.com","Hypermanager","brentdp93@gmail.com","Brent","$MachineName is now stopped","This message was sent to inform you that your virtual machine: $MachineName has just been saved.");

	}		

	if(isset($_POST['delete'])){
		$MachineName = $_POST['delete'];
		shell_exec("powershell -command powershell\\standardoperations.ps1 $MachineName delete -username $user<NUL");
		sendMail("hypermanagermailer@gmail.com","Hypermanager","brentdp93@gmail.com","Brent","$MachineName is now deleted","This message was sent to inform you that your virtual machine: $MachineName has just been deleted.");

	}


?>