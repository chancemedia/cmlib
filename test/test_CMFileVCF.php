<?php

include_once("../lib/CMError.php");
include_once("../lib/CMFileVCF.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=isBinary()',
		'test2=readFile() for version 2.1',
		'test3=readFile() for version 3.0',
		'test4=Integrity check with version 2.1',
		'test5=Integrity check with version 3.0',
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

function test4() {
	$vcf_in = new CMFileVCF();
	$vcf_out = new CMFileVCF();
	$vcf_in->readFile("tmp/vcard1.vcf");
	$vcf_out->prepareWriteFile("tmp/vcard3.vcf");
	
	while($person = $vcf_in->readNext())
		$vcf_out->writeNext($person);
		
	$f1 = explode("\n", file_get_contents("tmp/vcard1.vcf"));
	$f2 = explode("\n", file_get_contents("tmp/vcard3.vcf"));
		
	pass(count(array_diff($f1, $f2)) == 0);
}

function test5() {
	$vcf_in = new CMFileVCF();
	$vcf_out = new CMFileVCF();
	$vcf_in->readFile("tmp/vcard2.vcf");
	$vcf_out->prepareWriteFile("tmp/vcard3.vcf");
	
	while($person = $vcf_in->readNext())
		$vcf_out->writeNext($person);
		
	$f1 = explode("\n", file_get_contents("tmp/vcard2.vcf"));
	$f2 = explode("\n", file_get_contents("tmp/vcard3.vcf"));
		
	pass(count(array_diff($f1, $f2)) == 0);
}

include_once('tester.php');

?>
