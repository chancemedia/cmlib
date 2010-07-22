<?php

include_once("../lib/CMError.php");
include_once("../lib/CMFileCSV.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=iterateFile() and next()',
		'test2=Field mapping',
		'test3=prepareWriteFile(), add() and finishWriteFile()',
		'test4=iterateString() and next()',
		'test5=readFile()',
	)));
}

function test1() {
	$csv = new CMFileCSV();
	if(!$csv->iterateFile('tmp/csv1.csv'))
		die("Unable to read file!");
	
	$line1 = $csv->next();
	$line2 = $csv->next();
	
	// Array (
	//     [0] => begin_ip
	//     [1] => end_ip
	//     [2] => begin_num
	//     [3] => end_num
	//     [4] => country
	//     [5] => name
	// )
	// Array (
	//     [0] => 61.88.0.0
	//     [1] => 61.91.255.255
	//     [2] => 1029177344
	//     [3] => 1029439487
	//     [4] => AU
	//     [5] => Australia
	// )
	// ...
	
	pass($line1[5] === 'name' && $line2[5] === 'Australia');
}

function test2() {
	$fields = array('begin_ip', 'end_ip', 'begin_num', 'end_num', 'country', 'name');
	$csv = new CMFileCSV($fields);
	if(!$csv->iterateFile('tmp/csv1.csv', array('skip' => 1)))
		die("Unable to read file!");
	
	$line1 = $csv->next();
	
	// Array (
	//     [begin_ip] => 61.88.0.0
	//     [end_ip] => 61.91.255.255
	//     [begin_num] => 1029177344
	//     [end_num] => 1029439487
	//     [country] => AU
	//     [name] => Australia
	// )
	// ...
	
	pass($line1['name'] === 'Australia');
}

function test3() {
	$csv = new CMFileCSV();
	if(!$csv->prepareWriteFile('tmp/csv2.csv'))
		die("Unable to open file!");
	
	$data = array(
		array('first', 'last', 'email'),
		array('Bob', 'Smith', 'bob@smith.com'),
		array('Joe', 'Bloggs', 'joe@bloggs.com')
	);
	
	foreach($data as $d)
		$csv->add($d);
	
	// Example 4: Rewriting a CSV file.
	$csvIn = new CMFileCSV();
	$csvOut = new CMFileCSV();
	if(!$csvIn->iterateFile('tmp/csv1.csv') || !$csvOut->prepareWriteFile('tmp/csv3.csv'))
		die("One of the files could not be opened");
	
	// add an ID field at the beginning
	$csvOut->add(array_merge(array('id'), $csvIn->next()));
	for($i = 1; $line = $csvIn->next(); ++$i) {
	  $csvOut->add(array_merge(array($i), $line));
	}
	$csvOut->finishWriteFile();
	
	pass();
}

function test4() {
	$csv = new CMFileCSV();
	
	$csv_string = implode("\n", array(
		"First name,Last name,Email",
		"Elliot,Chance,elliot@chancemedia.com",
		"Joe,Bloggs,joe@bloggs.com"
	));
	
	if(!$csv->iterateString($csv_string, array('skip' => 1)))
		die("Unable to read file!");
		
	$final = array();
	while($line = $csv->next())
		$final[] = $line;
		
	$pass1 = (count($final) == 2);
	$pass2 = array_diff($final[0], array('Elliot', 'Chance', 'elliot@chancemedia.com'));
	$pass3 = array_diff($final[1], array('Joe', 'Bloggs', 'joe@bloggs.com'));
	pass($pass1 && count($pass2) == 0 && count($pass3) == 0);
}

function test5() {
	$csv = new CMFileCSV();
	
	pass(count($csv->readFile('tmp/csv1.csv')) == 4);
}

include_once('tester.php');

?>
