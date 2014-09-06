# parameterblock
param(
$vmName,	#name of the vm
$diskName	#name of the hard disk to remove
)

#set location for removal
$location = Get-Content "./path.txt" | select -First 1
$drive = "$location\$vmName\$diskName.vhdx"

#get the hard drive
$disk = Get-VMHardDiskDrive -VMName $vmName | where {$_.Path -eq $drive}

# remove hard drive from vm
Remove-VMHardDiskDrive -VMhardDiskDrive $disk

# remove hard drive from hd
Remove-Item $drive -Force
