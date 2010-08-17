<?php

include_once('CMObject.php');

/**
 * @brief This is used in conjuction with CMStyle to validate CSS styles.
 * 
 * All possible validation rules are;
 * -# @font
 * -# @fontlist
 * -# @percent
 * -# @length
 * -# @int
 * 
 * @author Elliot Chance
 */
abstract class CMStyleValidator implements CMClass {
	
	/**
	 * @brief Specifies the font name of a box.
	 * This can be a comma-separated list, of which the browser will use the first font it recognizes.
	 * Font names that are made up of more than one word must be placed within quotation marks.
	 */
	public $fontFamily = array('inherit', '@font', '@fontlist');
	
	/**
	 * @brief Specifies the size of a font in a box.
	 */
	public $fontSize = array('inherit', '@percent', '@length', 'larger', 'smaller', 'xx-small', 'x-small',
		'small', 'medium', 'large', 'x-large', 'xx-large');
	
	/**
	 * @brief Specifies the order of relative or absolutely positioned boxes in the z-axis.
	 * The higher the number, the higher that box will be in the stack.
	 */
	public $zIndex = array('inherit', 'auto', '@int');
	
}

?>
