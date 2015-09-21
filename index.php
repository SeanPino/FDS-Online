<?php

require 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->container->singleton('twig', function ($c) {
    $twig = new \Slim\Views\Twig();

    $twig->parserOptions = array(
        'debug' => true,
        'cache' => dirname(__FILE__) . '/cache'
    );

    $twig->parserExtensions = array(
        new \Slim\Views\TwigExtension(),
    );

    $templatesPath = $c['settings']['templates.path'];
    $twig->setTemplatesDirectory($templatesPath);

    return $twig;
});

$app->get('/', function () use ($app) {
    $app->render('home.php');
})->name('home');

$app->get('/about', function () use ($app) {
    $app->twig->display('about.php');
})->name('about');

$app->run();

?>