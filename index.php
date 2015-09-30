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

function version()
{
    return '1.0.0';
}

function sprint()
{
    $date1 = new DateTime('2015-09-02');
    $date2 = new DateTime();
    $interval = $date1->diff($date2);
    $status = array();
    $status['sprint'] = 1 + floor($interval->days / 14);
    $status['day'] = ($interval->days % 14) + 1;

    return $status;
}

$app->get('/', function () use ($app) {
    $app->render('home.php', array(
        'sprint'    => sprint(),
        'version'   => version()
    ));
})->name('home');

$app->get('/about', function () use ($app) {
    $app->twig->display('about.php');
})->name('about');

$app->run();

?>