<?php

include_once("../lib/CMVCard.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=Create vCard'
	)));
}

function test1() {
	$vcard = new CMVCard();
	$vcard->add('FN', 'Forrest Gump');
	$vcard->add('ORG', 'Bubba Gump Shrimp Co.');
	$vcard->add('TEL;TYPE=WORK,VOICE', '(111) 555-1212');
	pass($vcard !== false);
}

include_once('tester.php');

?>
