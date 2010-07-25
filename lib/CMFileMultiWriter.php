<?php

include_once("CMFileWriter.php");


interface CMFileMultiWriter extends CMFileWriter {
	
	function writeNext($item = false);
	
}

?>
