<?php

require("Slim/Slim/Slim.php");
\Slim\Slim::registerAutoloader();
define('PATH', $_SERVER['SERVER_NAME']);

$app = \Slim\Slim();

// Returns the status of the current job.
$app->get('/jobs/:id', function($id) use($app){

});

// Posts a new job to the work queue, and return work ID.
$app->post('/jobs/', function() use($app){
	// Grab the FDS file.
	$fds = $app->request->post("fds-file");
	
	// Add it into the queue.
	
	// Generate the work ID.
	
	// Return the ID to the user.
});

// Show a list of running and completed tasks.
$app->get('/list/', function() use($app){
	// Grab the list of files.
	
	// Display the list.
});

// Download the finished project.
$app->get('/download/:id', function($id) use($app){
	// Retrieve the file and start the download.
});

// Run the code.
$app->run();