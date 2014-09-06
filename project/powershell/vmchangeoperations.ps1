# parameterblock (callblock)
param(
$vmName,	#name of the vm
$call,		#function to be executed
$value		#new value for the hardware
)


if($call -eq "changememory"){
# set new memory on VM
Set-VMMemory $vmName -DynamicMemoryEnabled $true -MinimumBytes 32MB -MaximumBytes $value -Buffer 25

}

elseif($call -eq "changeprocessors"){
# change number of processors
Set-VMProcessor -VMName $vmName -count $value
}