<?php
require 'rb.php';

class DB
{

	R::setup("mysql:host=localhost;dbname=test" );
	
	public function AddJob($filename)
	{
		$w = R::dispense( 'job' );
		$w->name = $filename;
		$t = time();
		$timestamp = date(DATE_RSS,$t);
		$w->timestamp = $t;
		$w->status = R::enum('status:Queued');
		$id = R::store( $w );
		return "Job #{$id} successfully added at {$timestamp}.\n";
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
			return( "The job table is empty!\n" );
		}
		foreach( $jobs as $j ) 
		{
			echo "* #{$j->id}: {$j->name} : {$j->timestamp} : {$j->status} : {$j->filename}\n";
		}
  
	}

	public function DeleteJob($id)
	{
		R::trash( 'job', $id );
		return "Job has been deleted!\n" ;
	}
	
	public function UpdateStatus($id,$newStatus)
	{
		$job = R::findOne('job','id = ?',[$id]);
		$job->status = $newStatus;
		R::store($job);
	}

	public function FindJob($id)
	{
		$j = R::findOne('job','id = ?',[$id]);
		return "* #{$j->id}: {$j->name} : {$j->timestamp} : {$j->status} : {$j->filename}\n";
	}
}
?>