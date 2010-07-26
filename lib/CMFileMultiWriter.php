<?php

include_once("CMFileWriter.php");


/**
 * @brief Multiple-entity file writing interface.
 * 
 * @author Elliot Chance
 */
interface CMFileMultiWriter extends CMFileWriter {
	
	/**
	 * @brief Write the next entity.
	 * 
	 * This method can only be invoked after CMFileWriter::prepareWriteFile() but before
	 * CMFileWriter::finishWriteFile(). Depending on the application it can be invoked zero or more times.
	 * 
	 * @param $item The data type and value of $item is specific to what the inheriting class expects. See
	 *        the documentation for each subclass.
	 * @return \true on success, otherwise \false.
	 */
	function writeNext($item = false);
	
}

?>
