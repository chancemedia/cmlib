<?php

include_once("CMObject.php");

/**
 * @brief iCalendar object.
 * 
 * @author Elliot Chance
 * @see CMFileICAL
 */
class CMICalendar implements CMObject {
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
