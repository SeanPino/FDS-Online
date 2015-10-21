<?php

require("rb.php");
require("papercut.php");
R::setup('mysql:host=localhost;dbname=test');
class DB
{
	public static function AddJob($filename)
	{
		$w = R::dispense( 'job' );
		$w->name = $filename;
		$t = time();
		$w->timestamp = $t;
		$w->status = R::enum('status:Queued');
		$w->progress = 0;
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
			$app->response()->status(400);
			$error = "No jobs in your table";
			return json_encode($error);
		}

		$beans = R::exportAll( $jobs );
		foreach ($beans as $bean) 
		{
			$percentage = pc::getTime(substr($bean["name"], 0, strrpos($bean["name"], '.')) . ".out", $bean["id"]);
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
		return json_encode($beans);
	}

	public static function FindJob($id)
	{
		$job = R::load('job',$id);
		print_r(json_decode($job));
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
		if($percentage == 100)
		{
			$job->status = R::enum('status:Completed');
		}
		else if ($percentage < 100 && $percentage > 0)
		{
			$job->status = R::enum('status:In Progress');
		}
		$job->progress = $percentage;
		R::store($job);
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