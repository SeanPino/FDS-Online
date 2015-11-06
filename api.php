<?php


require("vendor/slim/slim/Slim/Slim.php");
require("Database.php");
\Slim\Slim::registerAutoloader();
define('PATH', $_SERVER['SERVER_NAME']);

function Zip($source, $destination)
{
	if(!extension_loaded('zip') || !file_exists($source))
	{
		return false;
	}

	$zip = new ZipArchive();
	if(!$zip->open($destination, ZIPARCHIVE::CREATE))
	{
		return false;
	}

	$source = str_replace('\\', '/', realpath($source));

	if(is_dir($source) === true)
	{
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

		foreach($files as $file)
		{
			$file = str_replace('\\', '/', $file);

			if(in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
			{
				continue;
			}

			$file = realpath($file);

			if(is_dir($file) === true)
			{
				$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
			}
			elseif(is_file($file) === true)
			{
				$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
			}
		}
	}
	elseif(is_file($source) === true)
	{
		$zip->addFromString(basename($source), file_get_contents($source));
	}

	return $zip->close();
}

$app = new \Slim\Slim();
/**
 * @api {get} /api/v1/jobs/:id Get Job Status
 * @apiParam {Number} id Unique job ID.
 * @apiDescription Returns the status of the current job.
 * @apiGroup Jobs
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
$app->get('/api/v1/jobs/:id', function($id) use($app){
	DB::FindJob($id, $app);
});

/**
 * @api {get} /api/v1/list/ Get All Jobs
 * @apiDescription Returns a list of running and completed jobs.
 * @apiGroup Jobs
 * @apiName GetJobs
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *     curl -X GET 'http://pyro.demo/api/v1/list/'
 * @apiError (400 Bad Request) {Number} response 400
 */
// Show a list of running and completed tasks.
$app->get('/api/v1/list/', function() use($app){
	// Grab the list of files.
	//$db->ListJobs();
	DB::ListJobs($app);
	// Display the list.
});

/**
 * @api {delete} /api/v1/delete/:id Delete a Job
 * @apiDescription Deletes the specified job.
 * @apiGroup Jobs
 * @apiName DeleteJob
 * @apiVersion 1.0.0
 * @apiExample {curl}  Example usage:
 *      curl 'http://pyro.demo/api/v1/delete/1'
 */
$app->delete('/api/v1/delete/:id', function($id) use($app){
	DB::DeleteJob($id, $app);
});

/**
 * @api {download} /api/v1/download/:id Download a finished job.
 * @apiDescription Downloads a finished job.
 * @apiGroup Jobs
 * @apiName DownloadJob
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *      curl 'http://pyro.demo/api/v1/download/1'
 */
$app->get('/api/v1/download/:id', function($id)
{
	set_time_limit(0);
	$job = DB::GetJob($id);
	$timestamp = $job["timestamp"];
	$name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $job["name"]);

	if(!is_writeable("uploads/" . $timestamp)){
		die("Cannot write in the uploads directory.");
	}
	if(!file_exists('archives'))
	{
		mkdir('archives', 0777, true);
	}
	if(!file_exists('archives/' . $timestamp))
	{
		mkdir('archives/' . $timestamp, 0777, true);
	}

	Zip('uploads/' . $timestamp, 'archives/' . $timestamp . '/' . $name . '.zip');

	$filename = $name . '.zip';
	$filepath = 'archives/' . $timestamp . '/';

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " . filesize($filepath . $filename));
	ob_end_flush();
	ob_end_clean();
	@readfile($filepath . $filename);
});

/**
 * @api {jobs} /api/v1/download/jobs Upload job.
 * @apiDescription Uploads a new job.
 * @apiGroup Jobs
 * @apiName UploadJob
 * @apiVersion 1.0.0
 * @apiExample {curl} Example usage:
 *      curl -X -POST 'file=@C:/FDS/sim/example.fds' 'http://pyro.demo/api/v1/download/1'
 */
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
                
                // Make sure the completed file exists.
                if (!file_exists('completed')) {
                    mkdir('completed', 0777, true);
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

/**
 * @api {wipe} /api/v1/wipe/ Erases all jobs.
 * @apiDescription Erases all jobs (Testing purposes only).
 * @apiGroup Jobs
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