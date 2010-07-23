<?php

include_once('CMClass.php');


interface CMFileWriter extends CMClass {
	
	function prepareWriteFile($file);
	
	function writeString($a = false);
	
	function writeFile($uri, $a = false);
	
	function finishWriteFile($a = array());
	
}

?>
