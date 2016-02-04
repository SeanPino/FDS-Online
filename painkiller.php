<?php

//require('papercut.php');
class Pain
{
	public static function ConfigJob($filename)
	{
		//number of processes that are available
		$numCpus = Pain::GetProcesses();
		//check number of meshes
		$numMeshes = pc::CountMeshes($filename);
		if($numMeshes != 0)
		{
			if($numMeshes < $numCpus)
			{
				$numCpus = $numMeshes;
			}
		}
		else
		{
			$numCpus = 1;
		}

		return $numCpus;

	}
	public static function GetProcesses()
	{
		if ('WIN' == strtoupper(substr(PHP_OS, 0, 3)))
	 	{
	    	$process = @popen('wmic cpu get NumberOfLogicalProcessors', 'rb');
	    	if (false !== $process)
	    	{
	      		fgets($process);
	      		$numCpus = intval(fgets($process));
	      		pclose($process);
	      	}
	    }
	    return $numCpus;
	}
}
?>