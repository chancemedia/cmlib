<?php

include_once('CMClass.php');


interface CMFileWriter extends CMClass {
	
	function prepareWriteFile($file);
	
	function finishWriteFile($a = array());
	
}

?>
