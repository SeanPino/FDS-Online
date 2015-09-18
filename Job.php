<?php

require 'rb.php';
R::setup("mysql:host=localhost;dbname=test" );

$opts = getopt( '', [
  'add:',
  'status:',
  'delete:',
  'attach-to:',
  'note:',
  'notes:',
  'remove-note:',
  'list' ] );
  
if ( isset( $opts [ 'add' ] ) ) {
  $w = R::dispense( 'job' );
  $w->name = $opts['add'];
  $date= new DateTime();
  $w->timestamp = $date->getTimestamp();
  $w->status = 1;
  $id = R::store( $w );
  die( "Job #{$id} successfully added.\n" );
}

if ( isset( $opts['delete'] ) ) {
  R::trash( 'job', $opts['delete'] );
  die( "Job has been deleted!\n" );
}

if ( isset( $opts['note'] ) && isset( $opts['attach-to'] ) ) {
  $w = R::load( 'job', $opts['attach-to'] );
  if (!$w->id) die( "No such job.\n" );
  $n = R::dispense( 'note' );
  $n->note = $opts['note'];
  $w->xownNoteList[] = $n;
  R::store( $w );
  die( "Added note to job.\n" );
}

if ( isset( $opts['notes'] ) ) {
  $w = R::load( 'job', $opts['notes'] );
  foreach( $w->xownNoteList as $note ) {
    echo "* #{$note->id}: {$note->note}\n";
  }
  exit;
}

if ( isset( $opts['remove-note'] ) ) {
  R::trash( 'note', $opts['remove-note'] );
  die( "Removed note.\n" );    
}

if ( isset( $opts['list'] ) ) {
  $jobs = R::find( 'job' );
  if ( !count( $jobs ) ) die( "The job table is empty!\n" );
  foreach( $jobs as $j ) {
    echo "* #{$j->id}: {$j->name} : {$j->timestamp} : {$j->status}\n";
  }
  exit;
}


?>