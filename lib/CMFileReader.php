<?php

include_once('CMClass.php');


/**
 * @brief Single-entity file reading interface.
 * 
 * @author Elliot Chance
 */
interface CMFileReader extends CMClass {
	
	/**
	 * @brief Open and prepare a file for reading.
	 * 
	 * When this method is used with CMFileReader it will usually load the entire single entity file, however
	 * if readFile() is used with CMFileMultiReader is will usually simply open and prepare the file handle
	 * ready for readNext().
	 * 
	 * @param $uri Location of the file to read.
	 * @param $a An associative array of extra attributes and options. See inherited class for specific
	 *        details.
	 * @return \true on success, otherwise \false.
	 */
	function readFile($uri, $a = false);
	
	/**
	 * @brief Open and prepare a string for reading.
	 * 
	 * This method should work in exactly the same way as readFile() except that the input stream is a string
	 * rather than a file.
	 * 
	 * @param $str String stream.
	 * @param $a An associative array of extra attributes and options. See inherited class for specific
	 *        details.
	 * @return \true on success, otherwise \false.
	 */
	function readString($str, $a = false);
	
}

?>
