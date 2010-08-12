<?php

/**
 * @brief An abstract class for colors using RGBA.
 * 
 * Even though solid colours do not have an alpha component we keep it 4 components for global
 * compatibility.
 * 
 * There are in fact 16 standard web color names however two colors go under different names so there is
 * 18 constants beginning with HTML_*.
 * 
 * @author Elliot Chance
 */
class CMColor {
	
	/**
	 * @brief Black.
	 */
	public static $Black = array(0, 0, 0, 0);
	
	/**
	 * @brief White.
	 */
	public static $White = array(255, 255, 255, 0);
	
	/**
	 * @brief Red.
	 */
	public static $Red = array(255, 0, 0, 0);
	
	/**
	 * @brief Green.
	 */
	public static $Green = array(0, 255, 0, 0);
	
	/**
	 * @brief Blue.
	 */
	public static $Blue = array(0, 0, 255, 0);

	
	/**
	 * @brief HTML aqua / cyan.
	 */
	public static $HTML_Aqua = array(0x00, 0xFF, 0xFF, 0);
	
	/**
	 * @brief HTML aqua / cyan.
	 */
	public static $HTML_Cyan = array(0x00, 0xFF, 0xFF, 0);
	
	/**
	 * @brief HTML gray.
	 */
	public static $HTML_Gray = array(0x80, 0x80, 0x80, 0);
	
	/**
	 * @brief HTML navy.
	 */
	public static $HTML_Navy = array(0x00, 0x00, 0x80, 0);
	
	/**
	 * @brief HTML silver.
	 */
	public static $HTML_Silver = array(0xC0, 0xC0, 0xC0, 0);
	
	/**
	 * @brief HTML black.
	 */
	public static $HTML_Black = array(0x00, 0x00, 0x00, 0);
	
	/**
	 * @brief HTML green.
	 */
	public static $HTML_Green = array(0x00, 0x80, 0x00, 0);
	
	/**
	 * @brief HTML olive.
	 */
	public static $HTML_Olive = array(0x80, 0x80, 0x00, 0);
	
	/**
	 * @brief HTML teal.
	 */
	public static $HTML_Teal = array(0x00, 0x80, 0x80, 0);
	
	/**
	 * @brief HTML blue.
	 */
	public static $HTML_Blue = array(0x00, 0x00, 0xFF, 0);
	
	/**
	 * @brief HTML lime.
	 */
	public static $HTML_Lime = array(0x00, 0xFF, 0x00, 0);
	
	/**
	 * @brief HTML purple.
	 */
	public static $HTML_Purple = array(0x80, 0x00, 0x80, 0);
	
	/**
	 * @brief HTML white.
	 */
	public static $HTML_White = array(0xFF, 0xFF, 0xFF, 0);
	
	/**
	 * @brief HTML fuchsia.
	 */
	public static $HTML_Fuchsia = array(0xFF, 0x00, 0xFF, 0);
	
	/**
	 * @brief HTML magenta.
	 */
	public static $HTML_Magenta = array(0xFF, 0x00, 0xFF, 0);
	
	/**
	 * @brief HTML maroon.
	 */
	public static $HTML_Maroon = array(0x80, 0x00, 0x00, 0);
	
	/**
	 * @brief HTML red.
	 */
	public static $HTML_Red = array(0xFF, 0x00, 0x00, 0);
	
	/**
	 * @brief HTML yellow.
	 */
	public static $HTML_Yellow = array(0xFF, 0xFF, 0x00, 0);
	
}

?>
