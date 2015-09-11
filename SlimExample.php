<?php

require("Slim/Slim/Slim.php");
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
}

// You can pass in variables. Specify them in the function().
$app->get('/name/:name', function($name) use($app){
	echo "Your name is $name";
}

// You can pass in more than one variable, as many as needed.
$app->get('/add/:a/:b', function($a, $b) use($app){
	$ans = (int)$a + (int)$b;
	echo "The answer is $ans";
}

// This makes the code work.
$app->run();
