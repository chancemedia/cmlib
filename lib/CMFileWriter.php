<?php

include_once('CMClass.php');

interface CMFileWriter extends CMClass {
	
	function prepareWriteFile($file);
	
	function writeString();
	
	function writeNext($item);
	
	function writeAll();
	
	function finishWriteFile($file);
	
}

?>
