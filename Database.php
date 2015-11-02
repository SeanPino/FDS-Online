<?php
require ("rb.php");
require ("papercut.php");
R::setup("sqlite:db/database.db");
define('threadCount', '3');

class DB
{
	public static function AddJob($filename) 
	{
		$w = R::dispense('job');
		$w->name = $filename;
		$t = time();
		$w->timestamp = $t;
		$w->status = R::enum('status:Queued');
		$w->progress = 0;
		$id = R::store($w);
		$bean = R::load('job', $id);
		$bean->filename = $filename;
		http_response_code(200);
		print $bean;
	}
	
	public static function ListJobs($app) 
	{
		$bool = DB::refreshJobs();
		if ($bool[0]) 
		{
			$app->response()->status(200);
			print json_encode($bool[1]);
		} 
		else
		{
			$app->response()->status(400);
			$error = "No jobs in your table";
			print $error;
		}
	}
	
	public static function FindJob($id) 
	{
		$job = R::load('job', $id);
		print_r(json_decode($job));
		return $job;
		 // Added by Shawn C.
		
	}
	
	public static function DeleteJob($id, $app) 
	{
		$job = R::load('job', $id);
		$filename = $job['name'];
		$timestamp = $job['timestamp'];
		
		//$bool = DB::deleteDir("uploads\\" . $timestamp);
		// if(!$bool)
		// {
		// 	$app->response()->status(400);
		// 	$error = "File {$filename} could not be deleted or was open.";
		// 	return json_encode($error);
		// }
		$result = R::trash('job', $id);
		if ($result) 
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
	
	public static function UpdateStatus($id, $percentage) 
	{
		$job = R::load('job', $id);
		if ($percentage >= 100) 
		{
			$percentage = 100;
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
		$w = R::dispense('job');
		$w->name = $filename;
		$t = time();
		$w->timestamp = $t;
		$w->progress = $percentage;
		$w->status = R::enum('status:Queued');
		$id = R::store($w);
	}
	
	public static function refreshJobs() 
	{
		$jobs = R::find('job');
		if (!count($jobs)) 
		{
			return array(false);
		}
		
		$beans = R::exportAll($jobs);
		foreach ($beans as $bean) 
		{
			$percentage = pc::getTime($bean["timestamp"] . '/' . substr($bean["name"], 0, strrpos($bean["name"], '.')) . ".out", $bean["id"]);
			if ($percentage != null) 
			{
				DB::UpdateStatus($bean["id"], round($percentage, 2));
			} 
			else
			{
				DB::UpdateStatus($bean["id"], 0);
			}
		}
		return array(true, $beans);
	}
	
	public static function queryFiles() 
	{
		$toRunJobs = array();
		
		//refresh jobs
		$result = DB::refreshJobs();
		
		//check result for true return or false return
		
		//find out how many are running currently
		$inProgress = R::find('job', ' status_id = ? ', [R::enum('status:In Progress')->id]);
		$count = count($inProgress);
		if ($count < threadCount) 
		{
			
			//query for next jobs
			$jobs = R::find('job', ' status_id = ? ', [R::enum('status:Queued')->id]);
			
			//forech for each job queued and add them to an array of jobs and add 1 to count
			foreach ($jobs as $job) 
			{
				if ($count < threadCount) 
				{
					$path = $job["timestamp"] . '/' . $job["name"];
					array_push($toRunJobs, $path);
					$count++;
				} 
				else
				{
					break;
				}
			}
			return $toRunJobs;
		} 
		else
		{
			return null;
		}
	}
}
?>