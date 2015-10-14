<?php

require("rb.php");
R::setup("sqlite:db/database.db");
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
		//foreach( $jobs as $j ) 
		//{;
                
			//echo "* #{$j->id}: {$j->name} : {$j->timestamp} : {$j->status} : {$j->filename}\n";
		//}
		http_response_code(200);
		//return json_encode($beans);
                echo json_encode($beans);
  
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
	public static function UpdateStatus($id,$newStatus)
	{
		$job = R::findOne('job','id = ?',[$id]);
		$job->status = $newStatus;
		R::store($job);
	}


}
?>