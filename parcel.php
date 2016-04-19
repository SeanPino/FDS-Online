<?php
//$ini = parse_ini_file('config.ini');
//define('threadCount', $ini['threadCount']);
require('Database.php');
require('painkiller.php');

class P
{
	public static function run()
	{
		$files = DB::queryFiles();
		if($files == null)
		{
			print("No jobs to run currently.");
			return null;
		}
		//var_dump($files);
		/*
		foreach ($files as $file) 
		{
			*/
		//var_dump($files);
		//var_dump($timestamp);
		$timestamp = substr($files[0], 0, strpos($files[0], '/'));
		$filename = substr($files[0], strpos($files[0], '/') + 1);
		//$numCpus = Pain::ConfigJob($filename);
                echo $timestamp . '<br>' . $filename;
		shell_exec('singleprocess.bat ' . $timestamp . ' '  . $filename . ' '  );
		//print('multipleprocessors.bat ' . $timestamp . ' ' . $filename . ' ' . $numCpus);
		//shell_exec('multipleprocesses.bat ' . $timestamp . ' ' . $filename . ' ' . $numCpus);
		
		//var_dump($timestamp);
		//var_dump('test.bat ' . $timestamp . ' ' . $filename);
		
		
		/*}
		
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
		*/
	}
}
P::run();
/*
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

*/
?>