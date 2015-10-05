<?php

class pc
{

	public static function createTempFile($filename)
	{
		$temp = tempnam(sys_get_temp_dir(), 'TMP_');
		file_put_contents($temp, file_get_contents($filename));
		return file($temp);
	}


	public static function getTime($filename)
	{

		//$strings = file_get_contents($filename);
		$file = pc::createTempFile($filename);
		$lineCount = count($file);
		$firstTime = $file[33];
		//var_dump($firstTime);
		//$firstTimeA = explode( " ", $firstTime);
		$cuttingSpaces = preg_split('/[\s]+/', $firstTime);
		$firstTime = $cuttingSpaces[5];
		//var_dump($segments);
		//$replaced = preg_replace('/\D/', '', $firstTime);
		//var_dump($firstTimeA);
		//var_dump($replaced);

		for($i = $lineCount-10; $i < $lineCount-1; $i++)
		{
			if( strpos($file[$i],"Total time:") != false)
			{
				$line = $i; 
				break;
			}
		}
		$lastTime = $file[$line];

		//print $firstTime . "\n";
		$lastTime = preg_split('/[\s]+/', $lastTime);
		$lastTime = $lastTime[7];
		//print $lastTime . "\n";

		$percentage = ($lastTime/$firstTime) * 100 ;
		print round($percentage, 2) . "%";

	}


}









?>