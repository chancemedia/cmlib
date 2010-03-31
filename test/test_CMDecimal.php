<?php

include_once("../lib/CMDecimal.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=Create',
		'test2=Create 2',
		'test3=add()',
		'test4=subtract()',
		'test5=multiply()',
		'test6=divide()',
		'test7=zero()',
		'test8=one()'
	)));
}

function test1() {
	$d = new CMDecimal(8, 2);
	pass($d == '0.00');
}

function test2() {
	$d = new CMDecimal(8, 2, "53.78");
	pass($d == '53.78');
}

function test3() {
	$d = new CMDecimal(8, 2, "53.78");
	$d = $d->add("13.73");
	pass($d == '67.51');
}

function test4() {
	$d = new CMDecimal(8, 2, "53.78");
	$d = $d->subtract("13.73");
	pass($d == '40.05');
}

function test5() {
	$d = new CMDecimal(8, 2, "53.78");
	$d = $d->multiply("13.73");
	pass($d == '738.39');
}

function test6() {
	$d = new CMDecimal(8, 2, "53.78");
	$d = $d->divide("13.73");
	pass($d == '3.91');
}

function test7() {
	$d = new CMDecimal(8, 2);
	$d = $d->zero();
	pass($d == '0.00');
}

function test8() {
	$d = new CMDecimal(8, 2);
	$d = $d->one();
	pass($d == '1.00');
}

include_once('tester.php');

?>
