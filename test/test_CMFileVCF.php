<?php

include_once("../lib/CMError.php");
include_once("../lib/CMFileVCF.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=isBinary()',
	)));
}

function test1() {
	$vcf = new CMFileVCF();
	pass(!$vcf->isBinary());
}

include_once('tester.php');

?>
