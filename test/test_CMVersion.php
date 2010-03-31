<?php

include_once("../lib/CMVersion.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=atLeast()',
		'test2=makeVersion()',
		'test3=over()'
	)));
}

function test1() {
	pass(CMVersion::atLeast("1.2.1", "1.2.0"));
}

function test2() {
	pass(CMVersion::makeVersion("1.2.3") === 1002003);
}

function test3() {
	pass(CMVersion::over("1.2.3", "1.2.1"));
}

include_once('tester.php');

?>
