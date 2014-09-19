#!/usr/bin/env php
<?php 


require 'vendor/autoload.php';
require "vendor/bolstad/csv-writer/src/CsvWriter/Simple.php";

date_default_timezone_set("Europe/Stockholm");

use CsvParser\Simple;

#$csvDumper = new SimpleCsvWrite( 'loggalogga' );

function handler($data) {
  echo "yay, got this!\n";
  print_r($data);
}

Simple::parseRowByRow('data/Sacramentorealestatetransactions.csv','handler');