<?php

require("vendor/slim/slim/Slim/Slim.php");
require("Database.php");
$db = new DB;
\Slim\Slim::registerAutoloader();
define('PATH', $_SERVER['SERVER_NAME']);

$app = new \Slim\Slim();

// Returns the status of the current job.
$app->get('/api/v1/jobs/:id', function($id) use($app){
	$db->FindJob($id);
});

// Show a list of running and completed tasks.
$app->get('/api/v1/list/', function() use($app){
	// Grab the list of files.
	$db->ListJobs();
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
		echo "You have uploaded an invalid file.";
	}else{
		echo "Your file is now being uploaded to the server.";
		$target = "uploads/" . basename( $_FILES["file"]["name"]);
		if(move_uploaded_file($_FILES["file"]["tmp_name"], $target)){
			echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
		}
		// Upload to the database here.

		$db->AddJob(basename($_FILES["file"]["name"]);
	}
});

// Run the code.
$app->run();