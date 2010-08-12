<?php

require_once('CMObject.php');

/**
 * @brief Font object for CMGraphicDraw.
 * @author Elliot Chance
 */
class CMFont implements CMObject {
	
	/**
	 * @brief Built in font number 1.
	 */
	public static $BuiltIn1;
	
	/**
	 * @brief Built in font number 2.
	 */
	public static $BuiltIn2;
	
	/**
	 * @brief Built in font number 3.
	 */
	public static $BuiltIn3;
	
	/**
	 * @brief Built in font number 4.
	 */
	public static $BuiltIn4;
	
	/**
	 * @brief Built in font number 5.
	 */
	public static $BuiltIn5;
	
	/**
	 * @brief Internal registered font ID.
	 */
	private $id = 0;
	
	/**
	 * @brief Create a CMFont object with a registered font ID.
	 * @param $id Registered font ID.
	 */
	public function CMFont($id) {
		$this->id = $id;
	}
	
	/**
	 * @brief Return the string value of this object.
	 * @return Always "<CMFont>".
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
	/**
	 * @brief Get the internal registered font ID.
	 * @return An integer value of the registered font ID.
	 */
	public function getFontID() {
		return $this->id;
	}
	
}

?>
