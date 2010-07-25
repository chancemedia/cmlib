<?php

include_once("../lib/CMError.php");
include_once("../lib/CMFileICAL.php");
include_once("../lib/CMVCalendar.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=readFile() and readNext()',
		'test2=prepareWriteFile(), writeNext() and finishWriteFile()',
		'test3=isBinary()',
		'test4=Integrity check',
	)));
}

function test1() {
	$ical = new CMFileICAL();
	if(!$ical->readFile("tmp/ical1.ical"))
		die("Unable to open input file!");
		
	$item = $ical->readNext();
		
	pass(count($item->items) == 4 && $item->items[0]->type == "VEVENT");
}

function test2() {
	// open a file for writing
	$ical = new CMFileICAL();
	if(!$ical->prepareWriteFile("tmp/ical2.ical"))
		die("Unable to open output file!");
	
	// create the iCal
	$item = new CMVCalendar();
	
	// create an event
	$item->addItem(CMVItem::CreateEvent(
		@mktime(12, 0, 0, 01, 01, 2011), // start time
		@mktime(13, 0, 0, 01, 01, 2011), // end time
		"Lunch",                         // summary
		"Bring the potato salad!"        // description
	));
	
	// write the event
	$ical->writeNext($item);
	$ical->finishWriteFile();
	pass(true);
}

function test3() {
	$ical = new CMFileICAL();
	pass(!$ical->isBinary());
}

function test4() {
	$ical_in = new CMFileICAL();
	$ical_out = new CMFileICAL();
	if(!$ical_in->readFile("tmp/ical1.ical"))
		die("Unable to open input file!");
	if(!$ical_out->prepareWriteFile("tmp/ical2.ical"))
		die("Unable to open output file!");
		
	while($item = $ical_in->readNext())
		$ical_out->writeNext($item);
	
	$ical_out->finishWriteFile();
	
	pass(file_get_contents("tmp/ical1.ical") == file_get_contents("tmp/ical2.ical"));
}

include_once('tester.php');

?>
