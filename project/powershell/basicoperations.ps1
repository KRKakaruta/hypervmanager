# parameterblock (callblock)
param(
$call
)

# set script and image location
$location = Get-Content "./path.txt" | select -First 1
$imagelocation = ls $location\..\HyperV\images


# show all the vm's
Function Get-VMs{
# make an empty array for the vm's
$vms = @()
# add for every vm a line to the vm-array (name,state,Uptime)
ForEach ($v in get-vm){
	$vmdetail = $v | Select -ExpandProperty Name
	$vmdetail += ","
	$vmdetail += $v | Select -ExpandProperty State
	$vmdetail += ","
	$vmdetail += $v | Select -ExpandProperty UpTime
	$vms += $vmdetail
	}
return $vms
}

# show all the images on the server
Function Get-Images{
# make an empty array for the images
$images = ""
# add for every image a line to the images-array (name,size)
ForEach($i in $imagelocation){
	$imagedetail = $i | Select -ExpandProperty Name
	$imagedetail += " "
	#$imagedetail += [math]::round(($i | Select -ExpandProperty Length)/1GB,2)
	#$imagedetail += "GB"
	$images += $imagedetail
	}
return $images
}


if($call -eq "getvms"){
	Get-VMs
}
elseif($call -eq "getimages"){
	Get-Images
}
