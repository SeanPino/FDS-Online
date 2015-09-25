<?php

require("vendor/slim/slim/Slim.php");
require("Database.php");
$db = new DB;

\Slim\Slim::registerAutoloader();
define('PATH', $_SERVER['SERVER_NAME']);

$app = \Slim\Slim();

// Returns the status of the current job.
$app->get('/jobs/:id', function($id) use($app){
	$db->FindJob($id);
});

// Show a list of running and completed tasks.
$app->get('/list/', function() use($app){
	// Grab the list of files.
	 $db->ListJobs();
	// Display the list.
});

// Download the finished project.
$app->get('/download/:id', function($id) use($app){
	// Retrieve the file and start the download.
});

// Upload the file to the server and return the job ID.
$app->post('/jobs/', function() use($app){
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
		$db->AddJob($_FILES["file"]["name"]);
	}
});

// Run the code.
$app->run();