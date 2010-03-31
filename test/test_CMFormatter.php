<?php

include_once("../lib/CMFormatter.php");
include_once("../lib/CMMySQL.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=Date formatting',
		'test2=Currency formatting',
		'test3=Percentage formatting',
		'test4=Bytes formatting 1',
		'test5=Bytes formatting 2',
		'test6=Bytes formatting 3',
		'test7=Multicolumn formatter',
		'test8=Database formatter'
	)));
}

function test1() {
	$f = new CMFormatter('timestamp', 'F j, Y, g:i a');
	pass(
		($f->format(1269298400) == 'March 23, 2010, 9:53 am') &&
		($f->format("2010-03-05 12:43:05") == 'March 5, 2010, 12:43 pm')
	);
}

function test2() {
	$f = new CMFormatter('number', array('fixed' => 2, 'thousands' => ',', 'pre' => '$'));
	pass(
		($f->format(5) == '$5.00') &&
		($f->format("12347.237") == '$12,347.24')
	);
}

function test3() {
	$f = new CMFormatter('number', array('prec' => 1, 'mul' => 100, 'post' => '%'));
	pass(
		($f->format(0.05) == '5%') &&
		($f->format(1.2343) == '123.4%')
	);
}

function test4() {
	$f = new CMFormatter('bytes');
	pass(
		($f->format(5000) == '5 KB') &&
		($f->format(512345678) == '512.4 MB')
	);
}

function test5() {
	$f = new CMFormatter('bytes', array('fixed' => 2, 'unit' => 1024,
       'sizes' => ' bytes; KiB; MiB', 'thousands' => ','));
	pass(
		($f->format(5000) == '4.88 KiB') &&
		($f->format(51234567800) == '48,861.09 MiB')
	);
}

function test6() {
	$f = new CMFormatter('number', array('prec' => 0, 'mul' => 0.001, 'post' => ' KB',
       'thousands' => ','));
	pass(
		($f->format(7450) == '7 KB') &&
		($f->format(51234567800) == '51,234,568 KB')
	);
}

function test7() {
	$f = new CMFormatter(array(
       'created' => 'timestamp|F j, Y, g:i a',
       'cost' => 'number|fixed=2|thousands=,|pre=$'
     ));
	$result = $f->format(array('name' => "Bob Smith", 'created' => 1269298400, 'cost' => 450));
	pass(
		$result['name'] == 'Bob Smith' &&
		$result['created'] == 'March 23, 2010, 9:53 am' &&
		$result['cost'] == '$450.00'
	);
}

function test8() {
	$dbh = new CMMySQL("mysql://root:abcd1234@localhost/test");
	if(!$dbh->isConnected())
		skip();
	
	$f = new CMFormatter(array(
	       'created' => 'timestamp|F j, Y, g:i a',
	       'cost' => 'number|fixed=2|thousands=,|pre=$'
	     ));
	     
	$q = $dbh->query("select * from product where cost>? and productname=? order by id",
	                 array(100, 'Magic Carpet'),    // bind values
	                 array('formatter' => $f));     // attach formatter
	
	$r = $q->fetch('assoc', $f);
	pass($r['cost'] == '$450.00');
}

include_once('tester.php');

?>
