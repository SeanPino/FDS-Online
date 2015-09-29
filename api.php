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
	
		if (!file_exists('uploads')) {
		    mkdir('uploads', 0777, true);
		}
		// Add unique timestamp to name of file.
		$original = basename($_FILES["file"]["name"]);
		$_FILES["file"]["name"] = basename($_FILES["file"]["name"], ".fds") . "_" . time() . ".fds";
		$target = "uploads/" . basename( $_FILES["file"]["name"]);
		if(move_uploaded_file($_FILES["file"]["tmp_name"], $target)){
			// Upload to the database here.
			echo DB::AddJob(basename($_FILES["file"]["name"]));
			// echo json_encode(array("message" => "The file " . $original . " has been uploaded."));
		}else{
			echo "There was an error trying to upload the file. Please try again.";
		}
	}
});

// Run the code.
$app->run();