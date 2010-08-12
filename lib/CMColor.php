<?php

require_once('CMObject.php');

/**
 * @brief RGBA color object.
 * 
 * Even though solid colours do not have an alpha component we keep it 4 components for global
 * compatibility.
 * 
 * There are in fact 16 standard web color names however two colors go under different names so there is
 * 18 constants beginning with HTML_*.
 * 
 * @author Elliot Chance
 */
class CMColor implements CMObject {
	
	/**
	 * @brief Red component.
	 */
	public $red = 0;
	
	/**
	 * @brief Green component.
	 */
	public $green = 0;
	
	/**
	 * @brief Blue component.
	 */
	public $blue = 0;
	
	/**
	 * @brief Alpha component.
	 */
	public $alpha = 0;
	
	/**
	 * @brief Black.
	 */
	public static $Black;
	
	/**
	 * @brief White.
	 */
	public static $White;
	
	/**
	 * @brief Red.
	 */
	public static $Red;
	
	/**
	 * @brief Green.
	 */
	public static $Green;
	
	/**
	 * @brief Blue.
	 */
	public static $Blue;

	
	/**
	 * @brief HTML aqua / cyan.
	 */
	public static $HTML_Aqua;
	
	/**
	 * @brief HTML aqua / cyan.
	 */
	public static $HTML_Cyan;
	
	/**
	 * @brief HTML gray.
	 */
	public static $HTML_Gray;
	
	/**
	 * @brief HTML navy.
	 */
	public static $HTML_Navy;
	
	/**
	 * @brief HTML silver.
	 */
	public static $HTML_Silver;
	
	/**
	 * @brief HTML black.
	 */
	public static $HTML_Black;
	
	/**
	 * @brief HTML green.
	 */
	public static $HTML_Green;
	
	/**
	 * @brief HTML olive.
	 */
	public static $HTML_Olive;
	
	/**
	 * @brief HTML teal.
	 */
	public static $HTML_Teal;
	
	/**
	 * @brief HTML blue.
	 */
	public static $HTML_Blue;
	
	/**
	 * @brief HTML lime.
	 */
	public static $HTML_Lime;
	
	/**
	 * @brief HTML purple.
	 */
	public static $HTML_Purple;
	
	/**
	 * @brief HTML white.
	 */
	public static $HTML_White;
	
	/**
	 * @brief HTML fuchsia.
	 */
	public static $HTML_Fuchsia;
	
	/**
	 * @brief HTML magenta.
	 */
	public static $HTML_Magenta;
	
	/**
	 * @brief HTML maroon.
	 */
	public static $HTML_Maroon;
	
	/**
	 * @brief HTML red.
	 */
	public static $HTML_Red;
	
	/**
	 * @brief HTML yellow.
	 */
	public static $HTML_Yellow;
	
	/**
	 * @brief Create a new color object.
	 * 
	 * @param $red Red component (0 - 255 OR 0.0 - 1.0).
	 * @param $green Green component (0 - 255 OR 0.0 - 1.0).
	 * @param $blue Blue component (0 - 255 OR 0.0 - 1.0).
	 * @param $alpha Alpha component (0 - 127 OR 0.0 - 1.0).
	 */
	public function CMColor($red, $green, $blue, $alpha = 0) {
		list($this->red, $this->green, $this->blue, $this->alpha) =
			CMColor::ConvertColorToAbsolute($red, $green, $blue, $alpha);
	}
	
	/**
	 * @brief Convert absolute or percentage color components into absolute color components.
	 * 
	 * @param $red Red value (0 - 255 OR 0.0 - 1.0)
	 * @param $green Green value (0 - 255 OR 0.0 - 1.0)
	 * @param $blue Blue value (0 - 255 OR 0.0 - 1.0)
	 * @param $alpha Alpha value (0 - 127 OR 0.0 - 1.0)
	 * @return A new array with 4 elements representing red, green, blue and alpha respectivly.
	 */
	public static function ConvertColorToAbsolute($red, $green, $blue, $alpha = 0) {
		if($red < 1)
			$red *= 255;
		if($green < 1)
			$green *= 255;
		if($blue < 1)
			$blue *= 255;
		if($alpha < 1)
			$alpha *= 127;
		
		return array($red, $green, $blue, $alpha);
	}
	
	/**
	 * @brief Translate CMColor with imagecolorallocatealpha().
	 * @param $resource You mst provide a resource to apple the color to.
	 */
	public function getGDColor($resource) {
		return imagecolorallocatealpha($resource, $this->red, $this->green, $this->blue, $this->alpha);
	}
	
	/**
	 * @brief Return the string value of this object.
	 * @return Always "<CMColor>".
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}


// set static colors
CMColor::$Black = new CMColor(0, 0, 0);
CMColor::$White = new CMColor(255, 255, 255);
CMColor::$Red = new CMColor(255, 0, 0);
CMColor::$Green = new CMColor(0, 255, 0);
CMColor::$Blue = new CMColor(0, 0, 255, 0);
CMColor::$HTML_Aqua = new CMColor(0x00, 0xFF, 0xFF);
CMColor::$HTML_Cyan = new CMColor(0x00, 0xFF, 0xFF);
CMColor::$HTML_Gray = new CMColor(0x80, 0x80, 0x80);
CMColor::$HTML_Navy = new CMColor(0x00, 0x00, 0x80);
CMColor::$HTML_Silver = new CMColor(0xC0, 0xC0, 0xC0);
CMColor::$HTML_Black = new CMColor(0x00, 0x00, 0x00);
CMColor::$HTML_Green = new CMColor(0x00, 0x80, 0x00);
CMColor::$HTML_Olive = new CMColor(0x80, 0x80, 0x00);
CMColor::$HTML_Teal = new CMColor(0x00, 0x80, 0x80);
CMColor::$HTML_Blue = new CMColor(0x00, 0x00, 0xFF);
CMColor::$HTML_Lime = new CMColor(0x00, 0xFF, 0x00);
CMColor::$HTML_Purple = new CMColor(0x80, 0x00, 0x80);
CMColor::$HTML_White = new CMColor(0xFF, 0xFF, 0xFF);
CMColor::$HTML_Fuchsia = new CMColor(0xFF, 0x00, 0xFF);
CMColor::$HTML_Magenta = new CMColor(0xFF, 0x00, 0xFF);
CMColor::$HTML_Maroon = new CMColor(0x80, 0x00, 0x00);
CMColor::$HTML_Red = new CMColor(0xFF, 0x00, 0x00);
CMColor::$HTML_Yellow = new CMColor(0xFF, 0xFF, 0x00);

?>
