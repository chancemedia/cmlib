<?php

require_once('CMClass.php');

/**
 * @brief Pack and unpack streams and objects.
 * 
 * This class and its methods are often used with AJAX communication because associative arrays can
 * be passed from JavaScript to PHP and visa-vera easily.
 * 
 * @author Elliot Chance
 */
class CMSerialize implements CMClass {
	
	/**
	 * @brief Constructor does nothing.
	 */
	public function CMSerialize() {
	}
	
	/**
	 * @brief Pack an associative array into a JSON string.
	 * @param $entities Associative array.
	 */
	public static function Pack(array $entities) {
		return json_encode($entities);
	}
	
	/**
	 * @brief Translate a JSON string into an associative array.
	 * @param $string Valid JSON string.
	 */
	public static function Unpack($string) {
		return json_decode($string);
	}
	
	/**
	 * @brief Return the string value of this object.
	 * @return Always "<CMSerialize>".
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
