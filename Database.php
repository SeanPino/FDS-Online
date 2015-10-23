<?php

require("rb.php");
require("papercut.php");
R::setup("sqlite:db/database.db");
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
		print_r(json_encode($beans));
	}

	public static function FindJob($id, $app)
	{
		$job = R::load('job', $id);
		if(is_numeric($id))
		{
			if($job->id === 0)
			{
				$app->response->setStatus(400);
				$error = array(
					"response" => 400,
					"message"  => "Invalid ID supplied."
				);
				print_r(json_encode($error));
			}
			else
			{
				$app->response->setStatus(200);
				print $job;
			}
		}
		else
		{
			$app->response->setStatus(400);
			$error = array(
				"response" => 400,
				"message"  => "Invalid ID supplied."
			);
			print_r(json_encode($error));
		}
	}

	public static function DeleteJob($id, $app)
	{
		$job = R::load('job',$id);
		$filename = $job['name'];
		$timestamp = $job['timestamp'];
		// $bool = DB::deleteDir("uploads\\" . $timestamp);
		// if(!$bool)
		// {
		// 	$app->response()->setStatus(400);
		// 	$error = "File {$filename} could not be deleted or was open.";
		// 	print_r(json_encode($error));
		// }
		if(is_numeric($job->id))
		{
			if($job->id === 0)
			{
				$result = 0;
			}
			else
			{
				$result = 1;
			}
		}
		else
		{
			$result = 0;
		}
		R::trash('job', $id);
		if($result)
		{
			$app->response()->setStatus(200);
			$response = "Job {$id} has been deleted.";
			print_r(json_encode($response));
		}
		else
		{
			$app->response()->setStatus(400);
			$error = "Job {$id} could not be deleted or doesn't exist.";
			print_r(json_encode($error));
		}	
	}

	public static function Nuke($key, $env)
	{
		if($key === $env['key'])
		{
			R::nuke();
			print '(JSON)We did it!';
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