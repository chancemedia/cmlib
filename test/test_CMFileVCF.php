<?php

include_once("../lib/CMError.php");
include_once("../lib/CMFileVCF.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=isBinary()',
		'test2=readFile() for version 2.1',
		'test3=readFile() for version 3.0',
	)));
}

function test1() {
	$vcf = new CMFileVCF();
	pass(!$vcf->isBinary());
}

function test2() {
	$vcf = new CMFileVCF();
	$vcf->readFile("tmp/vcard1.vcf");
	$person = $vcf->readNext();
	$name = $person->get("N");
	pass($name[0]['value'] == "Martin;Stephen");
}

function test3() {
	$vcf = new CMFileVCF();
	$vcf->readFile("tmp/vcard2.vcf");
	$person = $vcf->readNext();
	pass($person->getDisplayName() == "Forrest Gump");
}

include_once('tester.php');

?>
