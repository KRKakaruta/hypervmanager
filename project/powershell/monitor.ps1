$vms = Get-VM | Select -ExpandProperty Name
$machines = Get-VM
$processor = Get-WMIObject Win32_Processor

# make the log file
$date = Get-Date
$day = $date | Select -ExpandProperty Day
$month = $date | Select -ExpandProperty Month
$year = $date | Select -ExpandProperty Year
$logname = "log_" + "$day" + "-" + "$month" + "-" + "$year"

if (-not(Test-Path  (".\$logname.txt"))){
	New-Item ".\$logname.txt" -Type File
}
	"========================" + "$date" + "========================" | Out-File .\$logname.txt -Append
	
ForEach ($vm in $vms){
	$measure = Measure-VM $vm
	$state = Get-VM $vm | Select -ExpandProperty State
	if (-not($state -like "*Running*")){
		
		"$vm" + ": " + "$state" | Out-File .\$logname.txt -Append
	}
	Else{
		$measure | Out-File .\$logname.txt -Append
	}

# check if extra cores need to be added to the vm - restart required
	if(($measure | Select -ExpandProperty AvgCPU)/($processor | Select -ExpandProperty MaxClockSpeed) -ge 90){
	}


# check if extra ram is needed  - restart required
	$avg = $measure | Select -ExpandProperty AvgRAM
	$maxvm = Get-VMMemory $vm | Select -ExpandProperty Maximum
	$maxhost = ((Get-WmiObject Win32_PhysicalMemory | Select -ExpandProperty Capacity | Measure-Object -Sum).Sum)/1MB
	
	if($avg/$maxvm -ge 0.95){
		if($maxvm/3 + $maxvm -ge ($maxhost - 2000)){
		}
	}
$vmStore = Get-Content .\path.txt | Select -Index 0
#$storage = Get-Content .\path.txt | Select -Index 3
$tempStore = "$storage\$vmVirtual Hard Disks"
$hds = Get-VMHardDiskDrive -VMName $vm
	ForEach($hd in $hds){
# check if the disk with the operating system needs expanding - restart required
		If($hd | Where-Object {$_.Path -like "*operatingsystem*"}){
			 
		}
# check if other hard drives need to be expanded - no restart required
		If($hd | Where-Object {$_.ControllerType -like "*SCSI*"}){
			$path = "$vmStore\$vm\Virtual Hard Disks"	
			$vhd = get-vhd $path\$vm.vhdx
			If(($vhd.Size/1mb - $vhd.FileSize/1mb) -le 3000){
				$newSize = $vhd.Size + 10000mb
				Resize-VHD $path\$vm.vhdx $newSize
				#New-VHD -Path $tempStore$vm.vhdx -Sizebytes $newSize
				#Move-VMStorage $vm -VHDs @(@{SourceFilePath = $path$vm.vhdx; DestinationFilePath = $tempStore$vm.vhdx})
				#Move-VMStorage $vm -VHDs @(@{SourceFilePath = $tempStore$vm.vhdx; DestinationFilePath = $path$vm.vhdx})	
				#Remove-Item $storage -R -Force	
			}	
		}
	}

# re-enable resource metering
Disable-VMResourceMetering $vm
Enable-VMResourceMetering $vm

}