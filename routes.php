<?php
global $app;
$app->get('/', function () use ($app)
{
    $app->render('home.php', array('sprint' => sprint(), 'version' => version()));
})->name('home');

$app->get('/list', function () use ($app)
{
    $app->render('list.php', array('sprint' => sprint(), 'version' => version()));
})->name('list');

$app->get('/login', function () use ($app)
{
    $app->render('login.php', array('sprint' => sprint(), 'version' => version()));
})->name('login');

// TODO
$app->get('/create-account', function () use ($app)
{
    $app->render('createAccount.php', array('sprint' => sprint(), 'version' => version()));
})->name('create-account');

// TODO
$app->get('/forgot-password', function () use ($app)
{
    $app->render('forgotPassword.php', array('sprint' => sprint(), 'version' => version()));
})->name('forgot-password');
