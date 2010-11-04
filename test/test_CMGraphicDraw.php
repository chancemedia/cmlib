<?php

include_once("../lib/CMGraphicDraw.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=new CMGraphicDraw()',
	)));
}

function test1() {
	$g = new CMGraphicDraw();
	pass($g);
}

include_once('tester.php');

?>
