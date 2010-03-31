<?php

include_once("../lib/CMConstant.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=Integrity',
		'test2=Mutability'
	)));
}

function test1() {
	$temp = 'some text';
	$c = new CMConstant($temp);
	pass($c->value === $temp);
}

function test2() {
	$temp = 'some text';
	$c = new CMConstant('abc');
	$c->value = $temp;
	pass($c->value === $temp);
}

include_once('tester.php');

?>
