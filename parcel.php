<?php
$ini = parse_ini_file('config.ini');
define('threadCount', $ini['threadCount']);
require('Database.php');

class P
{
	public static function run()
	{
		$files = DB::queryFiles();
		//var_dump($files);
		/*
		foreach ($files as $file) 
		{
			$timestamp = substr($file, 0, strpos($file, '/'));
			$filename = substr($file, strpos($file, '/') + 1);
			shell_exec('test.bat ' . $timestamp . ' ' . $filename);
		}
*/
		//var_dump($timestamp);
		//print 'cd ' . 'uploads\\' . $timestamp . '\\; fds ' . $filename;
		//shell_exec('cd ' . 'uploads\\' . $timestamp . '\\; fds ' . $filename);

		//shell_exec('fds ' . $filename);
		
		
		// Create a array
		$stack = array();

		//Iniciate Miltiple Thread
		foreach ( $files as $file ) 
		{
		    $stack[] = new AsyncOperation($file);
		}

		// Start The Threads
		foreach ( $stack as $t ) 
		{
		    $t->start();
		}
		
	}
}


class AsyncOperation extends Thread 
{
    public function __construct($arg) 
    {
        $this->arg = $arg;
    }

    public function run() 
    {
        if ($this->arg) 
        {
        //	print $arg . 'is now running';
        	$timestamp = substr($file, 0, strpos($file, '/'));
			$filename = substr($file, strpos($file, '/') + 1);
			shell_exec('test.bat ' . $timestamp . ' ' . $filename);
          // 	print $arg . 'is done running';
        }
    }
}




?>