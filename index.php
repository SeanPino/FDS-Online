<?php
require 'vendor/autoload.php';
define('PATH', $_SERVER['SERVER_NAME']);
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->container->singleton('twig', function ($c)
{
    $twig = new \Slim\Views\Twig();

    $twig->parserOptions = array('debug' => true, 'cache' => dirname(__FILE__) . '/cache');

    $twig->parserExtensions = array(new \Slim\Views\TwigExtension(),);

    $templatesPath = $c['settings']['templates.path'];
    $twig->setTemplatesDirectory($templatesPath);

    return $twig;
});

// Help is on the way
require 'helper.php';

// Include our route definitions
// and the API endpoints
require 'routes.php';
require 'api.php';

// Initialize the API
$api = new API($app);
$api->initEndpoints();

// App hooks
$app->hook('slim.before', function () use ($app)
{
    $app->view()->appendData(array('baseUrl' => baseUrl()));
});

$app->run();
?>
