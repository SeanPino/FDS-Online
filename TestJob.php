<?php

require 'rb.php';
require'Database.php';
R::setup("mysql:host=localhost;dbname=test" );
$db = new DB;

$opts = getopt( '', [
  'add:',
  'file:',
  'status:',
  'delete:',
  'list',
  'find:'] );
  
if ( isset( $opts [ 'add' ] )  ) {
  $db->AddJob($opts['add']);
}

if ( isset( $opts['list'] ) ) {
  $db->ListJobs();
}

if ( isset( $opts['find'] )) {
  //var_dump($opts['find']);
  $val = intval($opts['find']);
  var_dump($val);
  $db->FindJob($val);
}

//not worked on yet
if ( isset( $opts['delete'] ) ) {
  $db->DeleteJob($opts['delete']);
}







?>