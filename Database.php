<?php

require("rb.php");
require("papercut.php");
R::setup('mysql:host=localhost;dbname=test');
class DB
{
	public static function AddJob($filename)
	{
		$w = R::dispense( 'job' );
		//var_dump($filename);
		$w->name = $filename;
		$t = time();
		//$timestamp = date(DATE_RSS,$t);
		$w->timestamp = $t;
		$w->status = R::enum('status:Queued');
		$id = R::store( $w );
		$bean = R::load('job', $id);
		$bean->filename = substr($filename, 0, strrpos($filename, '_')) . '.fds';
		http_response_code(200);
		print $bean;
	}
	
	//obselete method, but if we would rather send the file in first then use this
	/*
	public function AddJob($file)
	{
		$w = R::dispense( 'job' );
		$w->name = $file->getClientOriginalName();
		$t = time();
		$timestamp = date(DATE_RSS,$t);
		$w->timestamp = $t;
		$w->status = R::enum('status:Queued');
		$id = R::store( $w );
		return "Job #{$id} successfully added at {$timestamp}.\n";
	}
	*/
	
	
	public static function ListJobs()
	{
		$jobs = R::find( 'job' );
		if ( !count( $jobs ) )
		{			
			print ( "The job table is empty!\n" );
		}

		$beans = R::exportAll( $jobs );
		foreach ($beans as $bean) {
			pc::getTime(substr($bean['filename'], 0, strrpos($bean['filename'], '_')) . ".out", $bean['id']);
		}
		http_response_code(200);
		return json_encode($beans);

  
	}


	public static function FindJob($id)
	{
		$job = R::load('job',$id);
		print_r(json_decode($job));
	}

	//look at this maybe return a json false
	public static function DeleteJob($id)
	{
		R::trash( 'job', $id );
		//print_r(json_decode($result));
		print "Job {$id} has been deleted!\n" ;
	}
	

	//not worked on yet
	public static function UpdateStatus($id,$percentage)
	{
		$job = R::findOne('job','id = ?',[$id]);
		//$job = R::load('job', $id);
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
	public static function MakeJob($percentage)
	{
		$w = R::dispense( 'job' );
		$w->name = $filename;
		$t = time();
		$w->timestamp = $t;
		$w->percentage = $percentage;
		$w->status = R::enum('status:Queued');
		$id = R::store( $w );
	}

}
?>