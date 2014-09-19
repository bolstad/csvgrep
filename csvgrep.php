#!/usr/bin/env php
<?php 


require 'vendor/autoload.php';
require "vendor/bolstad/csv-writer/src/CsvWriter/Simple.php";

date_default_timezone_set("Europe/Stockholm");

use CsvParser\Simple;
use Aura\Cli\CliFactory;
use Aura\Cli\Status;

#$csvDumper = new SimpleCsvWrite( 'loggalogga' );

function handler($data) {
  echo "yay, got this!\n";
  print_r($data);
}


// get the context and stdio objects
$cli_factory = new CliFactory;
$context = $cli_factory->newContext($GLOBALS);
$stdio = $cli_factory->newStdio();

// define options and named arguments through getopt
$options = ['verbose,v,file'];
$getopt = $context->getopt($options);

print_r($getopt);

$filename = $getopt->get('--file');
if (! $filename) {
    // print an error
    $stdio->errln("<<red>>Please give a name to say hello to<<reset>>.");
    exit(Status::USAGE);
}

Simple::parseRowByRow($filename,'handler');


// done!
exit(Status::SUCCESS);