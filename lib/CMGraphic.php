<?php

include_once('CMFile.php');

/**
 * @brief CMGraphic interface defines the methods for dealing with image files.
 * @author Elliot Chance
 */
interface CMGraphic extends CMFile {
	
	/**
	 * @brief Get the height (in pixels) of the image.
	 * @return An integer on success or \false if there was an error.
	 */
	public function getHeight();
	
	/**
	 * @brief Get the width (in pixels) of the image.
	 * @return An integer on success or \false if there was an error.
	 */
	public function getWidth();
	
	/**
	 * @brief Get the extended information available with some image formats.
	 * @return An associative array of extended information or \false if there was an error.
	 */
	public function getExtendedInformation();
	
	/**
	 * @brief Get the image type.
	 *
	 * The image type can be "PNG", "JPEG", "GIF", etc.
	 *
	 * @return A identifying string or \false if there was an error.
	 */
	public function getImageType();
	
}

?>
