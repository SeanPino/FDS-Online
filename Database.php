<?php

require("rb.php");
require("papercut.php");
R::setup("sqlite:db/database.db");
$global_filename = '';
$global_filepath = '';
class DB
{
	public static function Zip($source, $destination)
	{
		if(!extension_loaded('zip') || !file_exists($source))
		{
			return false;
		}

		$zip = new ZipArchive();
		if(!$zip->open($destination, ZIPARCHIVE::CREATE))
		{
			return false;
		}

		$source = str_replace('\\', '/', realpath($source));

		if(is_dir($source) === true)
		{
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

			foreach($files as $file)
			{
				$file = str_replace('\\', '/', $file);

				if(in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
				{
					continue;
				}

				$file = realpath($file);

				if(is_dir($file) === true)
				{
					$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
				}
				elseif(is_file($file) === true)
				{
					$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
				}
			}
		}
		elseif(is_file($source) === true)
		{
			$zip->addFromString(basename($source), file_get_contents($source));
		}

		return $zip->close();
	}

	public static function AddJob($filename)
	{
		$w = R::dispense( 'job' );
		$w->name = $filename;
		$t = time();
		$w->timestamp = $t;
		$w->status = R::enum('status:Queued');
		$w->progress = 0;
		$w->is_zipped = 0;
		$id = R::store( $w );
		$bean = R::load('job', $id);
		$bean->filename =  $filename;
		http_response_code(200);
		print $bean;
	}
	
	public static function ListJobs($app)
	{
		$jobs = R::find( 'job' );
		if ( !count( $jobs ) )
		{			
			//print ( "The job table is empty!\n" );
                        // return FALSE;
			$app->response()->status(400);
			$error = "No jobs in your table";
			print $error;
			return;
		}

		$beans = R::exportAll( $jobs );
		foreach ($beans as $bean) 
		{
			$percentage = pc::getTime($bean["timestamp"] . '/' . substr($bean["name"], 0, strrpos($bean["name"], '.')) . ".out", $bean["id"]);
			if($percentage != null)
			{
				DB::UpdateStatus($bean["id"], round($percentage, 2));
			}
			else
			{
				DB::UpdateStatus($bean["id"], 0);
			}
		}
		$app->response()->status(200);
		print json_encode($beans);
	}

	public static function FindJob($id)
	{
		$job = R::load('job',$id);
		print_r(json_decode($job));
	}

	public static function GetJob($id)
	{
		$job = R::load('job', $id);
		return $job;
	}

	public static function DeleteJob($id)
	{
		$job = R::load('job',$id);
		$filename = $job['name'];
		$timestamp = $job['timestamp'];
		//$bool = DB::deleteDir("uploads\\" . $timestamp);
		if(!$bool)
		{
			$app->response()->status(400);
			$error = "File {$filename} could not be deleted or was open.";
			return json_encode($error);
		}
		$result = R::trash('job', $id);
		if($result)
		{
			$app->response()->status(200);
			$response = "Job {$id} has been deleted.";
			return json_encode($response);
		}
		else
		{
			$app->response()->status(400);
			$error = "Job {$id} could not be deleted or doesn't exist.";
			return json_encode($error);
		}	
	}

	/*
	public static function deleteDir($dirPath) 
	{
	    if (!is_dir($dirPath)) 
	    {
	        //throw new InvalidArgumentException("$dirPath must be a directory");
	        return false;
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') 
	    {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) 
	    {
	        if (is_dir($file)) 
	        {
	            self::deleteDir($file);
	        } 
	        else 
	        {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	    return true;
	}*/
	
	public static function UpdateStatus($id,$percentage)
	{
		$job = R::load('job', $id);
		if($percentage >= 100)
		{
			$percentage = 100;
			$job->status = R::enum('status:Completed');
			DB::zip_file($id);
		}
		else if ($percentage < 100 && $percentage > 0)
		{
			$job->status = R::enum('status:In Progress');
		}
		$job->progress = $percentage;
		R::store($job);
	}

	public static function zip_file($id)
	{
		set_time_limit(0);
		$job = DB::GetJob($id);
		if($job->is_zipped === 0)
		{
			if(!is_writeable("uploads/" . $timestamp)){
				die("Cannot write in the uploads directory.");
			}
			if(!file_exists('archives'))
			{
				mkdir('archives', 0777, true);
			}
			if(!file_exists('archives/' . $timestamp))
			{
				mkdir('archives/' . $timestamp, 0777, true);
			}

			DB::Zip('uploads/' . $timestamp, 'archives/' . $timestamp . '/' . $name . '.zip');
			$job->is_zipped = 1;
		}
	}

	//debug function
	public static function MakeJob($filename)
	{
		$w = R::dispense( 'job' );
		$w->name = $filename;
		$t = time();
		$w->timestamp = $t;
		$w->progress = $percentage;
		$w->status = R::enum('status:Queued');
		$id = R::store( $w );
	}

}
?>