<?php

include_once("CMFileReader.php");


interface CMFileMultiReader extends CMFileReader {
	
	function readNext();
	
}

?>
