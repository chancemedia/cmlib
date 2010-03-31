<?php

include_once("CMClass.php");

// a change

/**
 * @brief Enumeration base class.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
abstract class CMEnum implements CMClass {

	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
