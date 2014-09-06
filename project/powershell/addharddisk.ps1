# parameterblock
param(
$vmName,	#name of the vm
$diskName,	#name for the new disk
$diskSize,	#size of the new disk
$isDynamic	#fixed or dynamic sized hd
)
# set hard drive location
$location = Get-Content "./path.txt" | select -First 1

# check if the disk is dynamic or static + create disk
if($isDynamic -eq $true){
	NeW-VHD -Path $location\$vmName\$diskName.vhdx -SizeBytes $diskSize
}
else{
	NeW-VHD -Path $location\$vmName\$diskName.vhdx -Fixed -SizeBytes $diskSize
}

# add disk to VM
Add-VMHardDiskDrive -VMName $vmName -Path $location\$vmName\$diskName.vhdx -Controllertype SCSI