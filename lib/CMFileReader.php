<?php

include_once('CMClass.php');


interface CMFileReader extends CMClass {
	
	function readFile($uri, $a = false);
	
	function readString($str, $a = false);
	
}

?>
