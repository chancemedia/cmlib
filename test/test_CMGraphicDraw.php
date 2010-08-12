<?php

include_once("../lib/CMGraphicDraw.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=convertColorToAbsolute()',
	)));
}

function test1() {
	$g = new CMGraphicDraw();
	$answer = array(127.5, 51, 76.5, 101.6);
	$diff = array_diff($g->convertColorToAbsolute(0.5, 0.2, 0.3, 0.8), $answer);
	pass(count($diff) == 0);
}

include_once('tester.php');

?>
