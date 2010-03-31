<?php

$TEST_NO_JUMP = true;

function getRequireFiles() {
	$r = array();
	if($handle = opendir('../lib')) {
    	while(false !== ($file = readdir($handle))) {
    		if(substr($file, 0, 1) == '.')
    			continue;
	        array_push($r, $file);
	    }
	}
	return $r;
}

function getTestUnits() {
	// use a single test for each included file
	$files = getRequireFiles();
	for($i = 0; $i < count($files); ++$i)
		$files[$i] = "$i=Require {$files[$i]}";
	
	die(implode(';', $files));
}

include_once('tester.php');

// perform the require
$files = getRequireFiles();
require_once("../lib/" . $files[$argv[1]]);
pass();

?>
