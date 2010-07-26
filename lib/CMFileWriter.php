<?php

include_once('CMClass.php');


/**
 * @brief Single-entity file writing interface.
 * 
 * @author Elliot Chance
 */
interface CMFileWriter extends CMClass {
	
	/**
	 * @brief Open a file handle ready for writing.
	 * @param $file The file to output to. You will need write permissions and this will remove any file
	 *        that is previously there with the same name.
	 * @return \true on success, otherwise \false.
	 */
	function prepareWriteFile($file);
	
	/**
	 * @brief Finish and close the writing file handle.
	 * @param $a Options.
	 * @return \true on success, otherwise \false.
	 */
	function finishWriteFile($a = array());
	
}

?>
