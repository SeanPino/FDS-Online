<?php
require ("vendor/slim/slim/Slim/Slim.php");
require ("Database.php");
\Slim\Slim::registerAutoloader();
define('PATH', $_SERVER['SERVER_NAME']);
date_default_timezone_set('UTC');
$app = new \Slim\Slim();

/**
 * @api {get} /api/v1/jobs/:id Get Job Status
 * @apiParam {Number} id Unique job ID.
 * @apiDescription Returns the status of the current job.
 * @apiGroup jobs
 * @apiName GetJob
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *     curl -X GET 'http://pyro.demo/api/v1/jobs/1'
 * @apiError (400 Bad Request) {Number} response 400
 * @apiError (400 Bad Request) {String} message The ID supplied is invalid or does not exist.
 * @apiSuccess (200 OK) {Number} id ID of current job.
 * @apiSuccess (200 OK) {String} name Name of the uploaded file.
 * @apiSuccess (200 OK) {Number} timestamp Timestamp of when file was uploaded.
 * @apiSuccess (200 OK) {String} status Status of the current job.
 * @apiSuccess (200 OK) {Number} progress Current progress of the job.
 */
$app->get('/api/v1/jobs/:id', function ($id) use ($app) 
{
	DB::FindJob($id, $app);
});

/**
 * @api {get} /api/v1/stop/:id Stop (Pause) Job
 * @apiParam {Number} id Unique job ID.
 * @apiDescription Stop (Pause) the job specified.
 * @apiGroup jobs
 * @apiName StopJob
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *     curl -X GET 'http://pyro.demo/api/v1/stop/1'
 * @apiError (400 Bad Request) {Number} response 400
 * @apiError (400 Bad Request) {String} message The ID supplied is invalid or does not exist.
 * @apiSuccess (200 OK) {Number} id ID of current job.
 * @apiSuccess (200 OK) {String} status Status of the current job.
 */
$app->get('/api/v1/stop/:id', function ($id) use ($app)
{
	DB::StopJob($id, $app);
});

/**
 * @api {get} /api/v1/start/:id Start (Resume) Job
 * @apiParam {Number} id Unique job ID.
 * @apiDescription Start (Resume) the job specified.
 * @apiGroup jobs
 * @apiName StartJob
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *     curl -X GET 'http://pyro.demo/api/v1/start/1'
 * @apiError (400 Bad Request) {Number} response 400
 * @apiError (400 Bad Request) {String} message Error message.
 * @apiSuccess (200 OK) {Number} id ID of current job.
 * @apiSuccess (200 OK) {String} status Status of the current job.
 */
$app->get('/api/v1/start/:id', function ($id) use ($app)
{
	DB::StartJob($id, $app);
});

/**
 * @api {get} /api/v1/list/ Get All Jobs
 * @apiDescription Returns a list of running and completed jobs.
 * @apiGroup list
 * @apiName GetJobs
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *     curl -X GET 'http://pyro.demo/api/v1/list/'
 * @apiError (400 Bad Request) {Number} response 400
 * @apiSuccess (200 OK) {String} No jobs in your table if there are no jobs.
 * @apiSuccess (200 OK) {Number} id The unique job ID.
 * @apiSuccess (200 OK) {String} name The job's name.
 * @apiSuccess (200 OK) {Number} timestamp The timestamp of when the job was uploaded.
 * @apiSuccess (200 OK) {Number} progress The progress state of the job.
 * @apiSuccess (200 OK) {Number} is_zipped If the job has been completed and zipped for download.
 * @apiSuccess (200 OK) {String} filename The name of the uploaded file.
 */

// Show a list of running and completed tasks.
$app->get('/api/v1/list/', function () use ($app) 
{
	
	// Grab the list of files.
	//$db->ListJobs();
	DB::ListJobs($app);
	
	// Display the list.
	
});

/**
 * @api {delete} /api/v1/delete/:id Delete a Job
 * @apiDescription Deletes the specified job.
 * @apiGroup delete
 * @apiName DeleteJob
 * @apiParam {Number} id The ID of the job to delete.
 * @apiVersion 1.0.0
 * @apiExample {curl}  Example usage:
 *      curl -X DELETE 'http://pyro.demo/api/v1/delete/1'
 * @apiError (400 Bad Request) {Number} response 400
 * @apiSuccess (200 OK) {Number} response 200
 */
$app->delete('/api/v1/delete/:id', function ($id) use ($app) 
{
	return DB::DeleteJob($id, $app);
});

/**
 * @api {get} /api/v1/download/:id Download a finished job
 * @apiDescription Downloads a finished job.
 * @apiGroup download
 * @apiName DownloadJob
 * @apiParam {Number} id The ID of the job to download.
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *      curl -X GET 'http://pyro.demo/api/v1/download/1'
 */
$app->get('/api/v1/download/:id', function($id)
{
	$job = DB::GetJob($id);

	//print $id;
	
	// Get the job to be downloaded.
	//        $job = DB::FindJob($id, $app);
	//        echo $id . "<br />";
	//        $job["timestamp"] = 1446044514;
	//        // Create the zip.
	//        $zip = new ZipArchive();
	//        echo "uploads/" . $job["timestamp"] . "/" . $job["timestamp"] . ".zip<br />";
	//        // Add everything except the original FDS file to the list of stuff to zip.
	//        $zip->open("uploads/" . $job["timestamp"] . "/" . $job["timestamp"] . ".zip", ZipArchive::CREATE);
	//        $files = scandir(".");
	//        foreach($files as $f){
	//            echo $f;
	//            if(substr($f, -4) !== ".fds"){  // Don't include the original FDS file.
	//                $zip->addFile($f);
	//            }
	//        }
	//        $zip->close();
	//
	//        // Now make it available for download.
	//        return $zip;
	chmod(".", 0777);
	$zip = new ZipArchive();
	$files = scandir(".");
	$zip->open("zip.zip", ZipArchive::CREATE);
	// var_dump($zip);
	foreach ($files as $f) 
	{
		$zip->addFile($f);
	}
	$res = $zip->close();
	return $zip;
	// var_dump($res);
});

/**
 * @api {post} /api/v1/jobs Upload job
 * @apiDescription Uploads a new job.
 * @apiGroup jobs
 * @apiName UploadJob
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *      curl -X POST -F 'file=@example.fds' 'http://pyro.demo/api/v1/jobs'
 * @apiSuccess (200 OK) {Number} id The unique job ID.
 * @apiSuccess (200 OK) {String} name The job's name.
 * @apiSuccess (200 OK) {Number} timestamp The timestamp of when the job was uploaded.
 * @apiSuccess (200 OK) {Number} progress The progress state of the job.
 * @apiSuccess (200 OK) {Number} is_zipped If the job has been completed and zipped for download.
 * @apiSuccess (200 OK) {String} filename The name of the uploaded file.
 */
$app->post('/api/v1/jobs/', function () use ($app) 
{
	$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
	if ($_FILES["file"]["type"] != "application/octet-stream" || $ext != "fds") 
	{
		echo "You have uploaded an invalid file.\n";
	} 
	else
	{
		
		// Make sure the uploads file exists.
		if (!file_exists('uploads')) 
		{
			mkdir('uploads', 0777, true);
		}
		
		// Make sure the completed file exists.
		if (!file_exists('completed')) 
		{
			mkdir('completed', 0777, true);
		}
		
		// Create the folder for the simulation and put it in there.
		$target = "uploads/" . time();
		mkdir($target);
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target . "/" . basename($_FILES["file"]["name"]))) 
		{
			echo DB::AddJob($_FILES["file"]["name"]);
			
			//echo json_encode(array("message" => "The file " . $_FILES["file"]["name"] . " has been uploaded."));
			
		} 
		else
		{
			return FALSE;
		}
	}
});

/**
 * @api {get} /api/v1/wipe/ Erases all jobs.
 * @apiDescription Erases all jobs (Testing purposes only).
 * @apiGroup wipe
 * @apiName WipeJobs
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *      curl 'http://pyro.demo/api/v1/wipe'
 */
$app->get('/api/v1/wipe/', function() use($app){
    R::wipe("job");
    echo "The jobs have been wiped.";
});

// Run the code.
$app->run();
?>