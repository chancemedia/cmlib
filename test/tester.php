<?php

function pass($test = true) {
	if($test)
		die("PASS");
	else die("FAIL");
}

function fail() {
	die("FAIL");
}

function skip() {
	die("SKIP");
}

if(!function_exists('init')) {
	function init() {
		pass();
	}
}

if(!function_exists('finish')) {
	function finish() {
		pass();
	}
}

global $TEST_NO_JUMP;
if(!isset($TEST_NO_JUMP) || $argv[1] == 'getTestUnits') {
	if($argc < 2 || !function_exists($argv[1]))
		die("FAIL");
	$argv[1]();
}

?>
