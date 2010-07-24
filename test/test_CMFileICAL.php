<?php

include_once("../lib/CMError.php");
include_once("../lib/CMFileICAL.php");
include_once("../lib/CMICalendar.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=prepareWriteFile(), writeNext() and finishWriteFile()',
		'test2=isBinary() and isMultiRecord()',
	)));
}

function test1() {
	// open a file for writing
	$ical = new CMFileICAL();
	if(!$ical->prepareWriteFile("tmp/ical1.ical"))
		die("Unable to open output file!");
	
	// create an event
	$item = new CMICalendar();
	
	// write the event
	$ical->writeNext($item);
	$ical->finishWriteFile();
	pass(false);
}

function test2() {
	$ical = new CMFileICAL();
	pass(!$ical->isBinary() && $ical->isMultiRecord());
}

include_once('tester.php');

?>
