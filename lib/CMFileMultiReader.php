<?php

include_once("CMFileReader.php");


/**
 * @brief Multiple-entity file reading interface.
 * 
 * @author Elliot Chance
 */
interface CMFileMultiReader extends CMFileReader {
	
	/**
	 * @brief Read the next entity from the prepared file or string.
	 * 
	 * Invoke this after readString() or readFile().
	 * 
	 * @param $a Options.
	 * @return The return type and value is different for each class that overloads readNext() but all
	 *         classes will return \false when the next element cannot be read - because of an error or
	 *         EOF.
	 */
	function readNext($a = array());
	
}

?>
