<?php

include_once("CMLicense.php");
CMLicense::CheckLicense();

/**
 * @brief CM class interface.
 * 
 * @section cmclass_description Description
 * All CM classes inherit from this interface.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
interface CMClass {
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString();
	
}

?>
