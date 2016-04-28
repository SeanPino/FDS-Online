<?php

class pc
{

	public static function createTempFile($filename)
	{
		$temp = tempnam(sys_get_temp_dir(), 'TMP_');
		file_put_contents($temp, file_get_contents($filename));
		return file($temp);
	}

	public static function getTime($filename, $id)
	{
		if (file_exists("uploads/" . $filename))
		{
			$file = pc::createTempFile("uploads/" . $filename);
			$lineCount = count($file);
			$firstTime = pc::searchLine($file, $lineCount, 'F');
			$lastTime = pc::searchLine($file, $lineCount, 'B');

			if ($firstTime <= 0 || $firstTime == null || $lastTime == null)
			{
				$error = "Divided by zero";
				return json_encode($error);
			}
			$percentage = ($lastTime / $firstTime) * 100;
			return round($percentage, 2);
		}
		else
		{
			return null;
		}
	}

	public static function searchLine($file, $lineCount, $direction)
	{
		$lineNumber = null;
		if (($direction == 'F'))
		{
			$lineNumber = pc::getLineNumber($file, "SIMULATION END TIME (S)", 0, 50, $lineCount, $direction);
		}
		else if ($direction == 'B')
		{
			$lineNumber = pc::getLineNumber($file, "TOTAL TIME:", $lineCount - 10, $lineCount - 1, $lineCount, $direction);
		}

		if ($lineNumber != -1)
		{
			if ($direction == 'F')
			{
				$time = pc::getNumber($file[$lineNumber], 1);
			}
			else if ($direction == 'B')
			{
				$time = pc::getNumber($file[$lineNumber], 2);
			}
		}
		else
		{
			$time = null;
		}
		return $time;
	}

	public static function getLineNumber($file, $searchString, $startpos, $endpos, $lineCount, $direction)
	{
		$line = - 1;
		$newStartPos = $startpos;
		$newEndPos = $endpos;

		while ($line == - 1)
		{
			for ($i = $newStartPos; $i < $newEndPos; $i++)
			{
				if (strpos(strtoupper($file[$i]), $searchString) != false)
				{
					$line = $i;
					return $line;
				}
			}

			//set new positions for next iteration if needed
			if ($direction == 'F')
			{
				$newStartPos = $newStartPos + 50;
				$newEndPos = $newStartPos + 50;
			}
			else if ($direction == 'B')
			{
				$newStartPos = $newStartPos - 10;
				$newEndPos = $newStartPos + 10;
			}

			if ($newStartPos <= 0 || $newStartPos > $lineCount)
			{
				break;
			}
		}
		return $line;
	}

	public static function getNumber($line, $which)
	{
		$number = null;
		$line = preg_split('/[\s]+/', $line);
		$lineNum = 0;
		foreach ($line as $index)
		{
			if (strpos($index, '.') != false)
			{
				if ($which == 2)
				{
					$which = $which - 1;
				}
				else
				{
					break;
				}
			}
			$lineNum++;
		}

		$number = $line[$lineNum];
		return $number;
	}

	public static function CountMeshes($filename)
	{
		$meshCount = 0;
		$result = file_exists("uploads/" . $filename);
		if (file_exists("uploads/" . $filename))
		{
			$file = pc::createTempFile("uploads/" . $filename);
			$lineCount = count($file);
			for($i = 0; $i < $lineCount; $i++)
			{
				if (strpos($file[$i], "MESH") != false)
				{
					$meshCount++;
				}
			}
		}
		return $meshCount;
	}
}
?>
