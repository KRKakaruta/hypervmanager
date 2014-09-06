# define global variables
$processor = Get-WmiObject Win32_processor
$computerName = hostname

# returns the Operating System of the server
Function Get-OS{
	$serverOs = (Get-WmiObject Win32_OperatingSystem).Name
	$detail = $serverOs.split("|")
	$detail[0]
}

# return the processortype
Function Get-ProcessorType{
	return $processor.Name
	
}

# return current cpu% usage
Function Get-ProcessorUsage{
	return $processor | Measure-Object -Property LoadPercentage -Average | Select -ExpandProperty Average
	
}

# returns total ram
Function Get-TotalRam{
	return (Get-WmiObject -class win32_physicalmemory | Where-Object {$_.DeviceLocator -notlike "SYSTEM ROM"} | Measure-Object -Property Capacity -Sum | Select -ExpandProperty sum)/1MB
	
}

# return current ram
Function Get-RamInUse{
	$MachineName = $ComputerSystem.CSName
	$ComputerSystem = Get-WmiObject -ComputerName $computerName -Class Win32_operatingsystem -Property CSName, TotalVisibleMemorySize, FreePhysicalMemory
	$FreePhysicalMemory = ($ComputerSystem.FreePhysicalMemory) / (1kb)
	$total = Get-TotalRam
	return $total - ([Decimal]::Round($FreePhysicalMemory))
}


$os = Get-Os
$type = Get-ProcessorType
$usage = Get-ProcessorUsage
$current = Get-RamInUse
$total =Get-TotalRam
return $os + ";" + "$type" + ";" + $usage + ";" + $current + ";" + $total + "MB"


