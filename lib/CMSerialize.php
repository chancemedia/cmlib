<?php

require_once('CMClass.php');

class CMSerialize implements CMClass {
	
	/**
	 * @brief Constructor does nothing.
	 */
	public function CMSerialize() {
	}
	
	public static function Pack(array $entities) {
		return json_encode($entities);
	}
	
	public static function Unpack($string) {
		return json_decode($string);
	}
	
	/**
	 * @brief Return the string value of this object.
	 * @return Always "<CMColor>".
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
