# parameterblock
Param(
$vmName, 		#name of the vm
$vmRam,			#memory of the vm
$hardDriveSize,		#size of the vm's hard drive
$processorCount		#number of processors
)

# set install location
$location = Get-Content "./path.txt" | select -Index 0
$imagelocation = Get-Content "./path.txt" | select -Index 1

# create VM
MD $location -erroraction silentlycontinue
New-VM -Name $vmName -Path $location
# create hd
New-Item -ItemType directory -Path "$location\$vmName\Virtual Hard Disks"
New-VHD -Path "$location\$vmName\Virtual Hard Disks\operatingsystem.vhdx" -Sizebytes $hardDriveSize
New-VHD -Path "$location\$vmName\Virtual Hard Disks\$vmName.vhdx" -Sizebytes 10GB
# add hd to vm
Add-VMHardDiskDrive -VMName $vmName -Path "$location\$vmName\Virtual Hard Disks\operatingsystem.vhdx"
Add-VMHardDiskDrive -VMName $vmName -Path "$location\$vmName\Virtual Hard Disks\$vmName.vhdx" -Controllertype SCSI
# set ram
$startupBytes = $vmRam/2
if ($startupBytes -lt 32MB){
$startupBytes = 32MB
}
Set-VMMemory $vmName -DynamicMemoryEnabled $true -MinimumBytes 32MB -StartupBytes $startupBytes -MaximumBytes $vmRam -Buffer 25
# set processors
Set-VMProcessor -VMName $vmName -count $processorCount

# create network 
$network = "Network1"
Add-VMNetworkAdapter -VMName $vmName -Name $network

# enable monitoring
Enable-VMResourceMetering -VMName $vmName
