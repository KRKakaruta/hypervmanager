# parameter block
param(
$fileName	#name of the file to copy
)

# set folder to copy from and destination folder
$copyFrom = Get-Content ".\path.txt" | Select -Index 2
$destination = Get-Content ".\path.txt" | Select -Index 1

# copy the image to the correct folder
Copy-Item $copyFrom\$fileName $destination
Remove-Item $copyFrom\$fileName -Force