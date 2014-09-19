#!/usr/bin/env php
<?php 


require 'vendor/autoload.php';
require "vendor/bolstad/csv-writer/src/CsvWriter/Simple.php";

date_default_timezone_set("Europe/Stockholm");

use CsvParser\Simple;
use Aura\Cli\CliFactory;
use Aura\Cli\Status;

#$csvDumper = new SimpleCsvWrite( 'loggalogga' );

// get the context and stdio objects
$cli_factory = new CliFactory;
$context = $cli_factory->newContext($GLOBALS);
$stdio = $cli_factory->newStdio();

// define options and named arguments through getopt
$options = ['verbose,v,file:,filter'];
$getopt = $context->getopt($options);

print_r($getopt);

function splitArgs($insStr,$key,$value) {
  $data = split('-',$insStr);
  if (count($data) == 2) {
    print_r($data);
    $ret[$key] = $data[0];
    $ret[$value] = $data[1];
    return $ret;
  } else
  return ; 

}

function handler($data) {
#  echo "yay, got this!\n";
  global $getopt;
  global $stdio; 
  $filter = $getopt->get('--filter');
  $filterDat = splitArgs($filter,'column','pattern'); 

  if ($filterDat) {
    print_r($filterDat);
    if (isset($data[$filterDat['column']])) {
      echo "column: " . $data[$filterDat['column']] . "\n";
      echo "pattern: " . $filterDat['pattern'] . "\n";

      if (preg_match($filterDat['pattern'],$data[$filterDat['column']])) {
        echo "Match!\n";
      } else {
        echo "No match!\n";
      }


    } else {

        $stdio->errln("<<red>>Missing data for column <<white>>". $filterDat['column']  . "<<red>>, please verify that spelling is correct<<reset>>.");
        echo "Available columns: " . join(', ',array_keys($data)) . "\n";
        exit(Status::FAIL);
        die;
    }

  }
  
  print_r($data);
#  die;
}

$filename = $getopt->get('--file');
if (! $filename) {
    // print an error
    $stdio->errln("<<red>>Please give a name to say hello to<<reset>>.");
    exit(Status::USAGE);
}

Simple::parseRowByRow($filename,'handler');


// done!
exit(Status::SUCCESS);