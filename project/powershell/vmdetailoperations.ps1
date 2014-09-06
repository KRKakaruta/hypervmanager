# parameterblock (callblock)
param(
$vmName,
$call
)

$location = Get-Content "./path.txt" | select -First 1

# show the maximum amount of ram the vm can use
Function Get-Ram($vmName){
$ram = (Get-VMMemory $vmName | Select -ExpandProperty Maximum)/1MB
return $ram
}

# show the number of processors
Function Get-Processor($vmName){
$processor = Get-VMProcessor $vmName | Select -ExpandProperty Count
return $processor
}

Function Get-HardDisks($vmName){
# get the paths of the hard drives
$path = get-vmharddiskdrive $vmName | Select -Expandproperty Path
# make an empty array for the disks
$disks = @()
# add for every disk a line to the disks-array (name.format,size,type)
ForEach ($p in $path){
	$diskdetail = $p.Replace("$location\$vMname\", "")
	$diskdetail += ","
	$diskdetail += (get-vhd $p | Select -ExpandProperty Size)/1GB
	$diskdetail += ","
	$diskdetail += get-vhd $p | Select -ExpandProperty vhdtype
	$disks += $diskdetail
}
return $disks	
}

#check which detail is needed
if($call -eq "getname"){
	$vmName
}

if($call -eq "getram"){
	Get-Ram($vmName)
}

elseif($call -eq "getprocessor"){
	Get-Processor($vmName)
}

elseif($call -eq "getdisks"){
	Get-Harddisks($vmName)
}





