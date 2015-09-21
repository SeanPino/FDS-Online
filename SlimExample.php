<?php

require("Slim/Slim/Slim.php");
define('PATH', $_SERVER['SERVER_NAME']);	// This is for the POST example near the bottom.
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// Generic response, for an index page.
$app->get('/', function() use($app){
	// Write database and response stuff in here.
	echo "Welcome to Slim!";
});

// A different kind of page.
$app->get('/pyro/', function() use($app){
	echo "The Pyro project is really on fire!";
});

// You can pass in variables. Specify them in the function().
$app->get('/name/:name', function($name) use($app){
	echo "Your name is $name";
});

// You can pass in more than one variable, as many as needed.
$app->get('/add/:a/:b', function($a, $b) use($app){
	$ans = (int)$a + (int)$b;
	echo "The answer is $ans";
});

// You can also submit POST data, which is good for when you don't want the parameters to be visible. For this example, let's have a page that take in your favorite color.
$app->get('/color/', function() use($app){
	?>
	<form name="color-form" action="http://<?php echo PATH; ?>/SlimExample.php/favorite/" method="post">
		Tell me your favorite color: 
		<input type="text" name="fav-color" />
		<input type="submit" name="submit" value="submit" />
	</form>
	<?php
});

$app->post('/favorite/', function() use($app){
	// Use this to access POST data (also works with GET, PUT, and DELETE, but whether that's necessary is questionable.
	$color = $app->request->post("fav-color");
	echo "Your favorite color is: $color";
});

// An example for file uploading.
$app->get('/upload/', function() use($app){
	?>
		<form name="upload-form" action="http://<?php echo PATH; ?>/SlimExample.php/upload/" method="post" enctype="multipart/form-data">
			Enter a file to upload:
			<input type="file" name="upload-file" />
			<input type="submit" name="submit" value="submit" />
		</form>
	<?php
});

$app->post('/upload/', function() use($app){
	$ext = pathinfo($_FILES["upload-file"]["name"], PATHINFO_EXTENSION);
	if($_FILES["upload-file"]["type"] != "application/octet-stream" ||
	   $ext != "fds"){
		echo "You have uploaded an invalid file.";
	}else{
		echo "Your file is now being uploaded to the server.";
		$target = "uploads/" . basename( $_FILES["upload-file"]["name"]);
		if(move_uploaded_file($_FILES["upload-file"]["tmp_name"], $target)){
			echo "The file " . basename($_FILES["upload-file"]["name"]) . " has been uploaded.";
		}
		// Upload to the database here.
	}
});

// This makes the code work.
$app->run();
