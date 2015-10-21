<?php


require("vendor/slim/slim/Slim/Slim.php");
require("Database.php");
\Slim\Slim::registerAutoloader();
define('PATH', $_SERVER['SERVER_NAME']);

$app = new \Slim\Slim();

// Returns the status of the current job.
$app->get('/api/v1/jobs/:id', function($id) use($app){
	DB::FindJob($id);
});

// Show a list of running and completed tasks.
$app->get('/api/v1/list/', function() use($app){
	// Grab the list of files.
	//$db->ListJobs();
	DB::ListJobs();
	// Display the list.
});

// Download the finished project.
$app->get('/api/v1/download/:id', function($id) use($app){
	print $id;
	// Retrieve the file and start the download.
});

// Upload the file to the server and return the job ID.
$app->post('/api/v1/jobs/', function() use($app){
	$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
	if($_FILES["file"]["type"] != "application/octet-stream" ||
	   $ext != "fds"){
		echo "You have uploaded an invalid file.\n";
	}else{
		// Make sure the uploads file exists.
		if (!file_exists('uploads')) {
		    mkdir('uploads', 0777, true);
		}
		
		// Create the folder for the simulation and put it in there.
		$target = "uploads/" . time();
		mkdir($target);
		if( move_uploaded_file($_FILES["file"]["tmp_name"], $target . "/" . basename($_FILES["file"]["name"])) ){
			echo DB::AddJob($_FILES["file"]["name"]);
			//echo json_encode(array("message" => "The file " . $_FILES["file"]["name"] . " has been uploaded."));
		}else{
		   return FALSE;
		}
	}
});

// Run the code.
$app->run();