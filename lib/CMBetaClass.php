<?php

include_once("CMLicense.php");
CMLicense::CheckLicense();

/**
 * @brief CM beta class interface.
 * 
 * @section cmbetaclass_desc Description
 * Any class that is unfinished, untested or for some other reason is not deemed stable inherits from
 * this class. This is mainly for documenation purposes, but it also allows the programmer to test
 * at runtime if a class is stable.
 * 
 * @section cmbetaclass_example1 Example 1: Testing if a class is stable.
 * @code
 * if(CMFileCSV instanceof CMBetaClass)
 *   trigger_error("It is not recommended you use this beta class", E_WARNING);
 * @endcode
 * 
 * @author Elliot Chance
 * @since 1.0
 */
interface CMBetaClass {

	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString();
	
}

?>
