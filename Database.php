<?php

require("rb.php");
R::setup("mysql:host=localhost;dbname=test" );
class DB
{
	public function AddJob($filename)
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
		print_r(json_decode($bean));
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
	
	
	public function ListJobs()
	{
		$jobs = R::find( 'job' );
		if ( !count( $jobs ) )
		{			
			print ( "The job table is empty!\n" );
		}
		$beans = R::exportAll( $jobs );
		//foreach( $jobs as $j ) 
		//{
		print_r(json_encode($beans));
			//echo "* #{$j->id}: {$j->name} : {$j->timestamp} : {$j->status} : {$j->filename}\n";
		//}
  
	}


	public function FindJob($id)
	{
		$job = R::load('job',$id);
		print_r(json_decode($job));
	}

	//look at this maybe return a json false
	public function DeleteJob($id)
	{
		R::trash( 'job', $id );
		//print_r(json_decode($result));
		print "Job {$id} has been deleted!\n" ;
	}
	

	//not worked on yet
	public function UpdateStatus($id,$newStatus)
	{
		$job = R::findOne('job','id = ?',[$id]);
		$job->status = $newStatus;
		R::store($job);
	}


}
?>