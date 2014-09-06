<?php
	class hostMachine{
		public function hostMachine($OS,$CPUType,$CPUUsage,$CurrentRAM,$TotalRAM){
			$this->OS = $OS;
			$this->CPUType = $CPUType;
			$this->CPUUsage = $CPUUsage;
			$this->CurrentRAM = $CurrentRAM;
			$this->TotalRAM = $TotalRAM;
		}
	}


?>