<?php

/**
 * @page manual_errors_extending 2.2. Extending CMError
 * 
 * @section manual_errors_extending_contents Contents
 * -# \ref manual_errors_extending_reporting
 * 
 * @section manual_errors_extending_reporting Throwing Errors
 * The best way to explain this is with an example:
 * @code
 * class MyFileReader extends CMError {
 *   public function readFile() {
 *     // to be able to read the file we need a valid file handle
 *     if($this->fileHandle === false)
 *       return $this->throwWarning("File handle isn't ready! This function will be ignored.");
 *     
 *     // OK now do the rest ...
 *   }
 * }
 * @endcode
 * 
 * For errors that exit the script you do not need to issue your own exit:
 * @code
 * class MyFileReader extends CMError {
 *   public function readFile() {
 *     // to be able to read the file we need a valid file handle
 *     if($this->fileHandle === false)
 *       $this->throwFatal("File handle isn't ready! I'm really strict about this.");
 *     
 *     // OK now do the rest ...
 *   }
 * }
 * @endcode
 * 
 */

?>
