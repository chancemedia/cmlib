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
	pass(trim($vcard->generateVCard()) === trim("
BEGIN:VCARD
VERSION:3.0
FN:Forrest Gump
ORG:Bubba Gump Shrimp Co.
TEL;TYPE=WORK,VOICE:(111) 555-1212
END:VCARD"));
}

include_once('tester.php');

?>
