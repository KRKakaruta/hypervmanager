# parameterblock
param(
$vmName,	#name of the vm
$selectedImage	#image to mount on the drive
)

# set image location
$imagelocation = Get-Content "./path.txt" | select -Index 1

# mount iso image
set-vmdvddrive -VMName $vmName -Path $imagelocation\$selectedImage -ControllerNumber 1 -ControllerLocation 0