<?php

require("../Slim/Slim.php");
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// Just a generic response.
$app->get('/', function() use($app){
	$app->response->setStatus(200);
	echo "Welcome to Slim!!";
});

// To say this works.
$app->get('/works/', function() use($app){
	echo "This stuff works";
});

// Of a given name.
$app->get('/name/:n', function($n) use($app){
	echo "Hello $n";
});

// Math!
$app->get('/math/:a/:b', function($a, $b) use($app){
	$ans = (int)$a + (int)$b;
	echo "The answer is $ans";
});

$app->run(); // forest, run