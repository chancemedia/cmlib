<?php

include_once('CMFile.php');

/**
 * @brief CMGraphic interface defines the methods for dealing with image files.
 * @author Elliot Chance
 */
class CMGraphic implements CMFile {
	
	/**
	 * @brief The file location for opening and saving.
	 */
	public $file = false;
	
	/**
	 * @brief Create a new CMGraphic object with or without a file.
	 */
	function CMGraphic($file = false) {
		$this->file = $file;
	}
	
	/**
	 * @brief Get the height (in pixels) of the image.
	 * @return An integer on success or \false if there was an error.
	 */
	public function getHeight() {
		if($this->file === false)
			return false;
			
		$dimentions = getimagesize($this->file);
		return $dimentions[1];
	}
	
	/**
	 * @brief Get the width (in pixels) of the image.
	 * @return An integer on success or \false if there was an error.
	 */
	public function getWidth() {
		if($this->file === false)
			return false;
			
		$dimentions = getimagesize($this->file);
		return $dimentions[0];
	}
	
	/**
	 * @brief Get the extended information available with some image formats.
	 * @return An associative array of extended information or \false if there was an error.
	 */
	public function getExtendedInformation() {
		if($this->file === false)
			return false;
			
		getimagesize($this->file, $extrainfo);
		return $extrainfo;
	}
	
	/**
	 * @brief Get the image type.
	 *
	 * The image type can be "PNG", "JPEG", "GIF", etc.
	 *
	 * @return A identifying string or \false if there was an error.
	 */
	public function getImageType() {
		if($this->file === false)
			return false;
			
		$ext = strtoupper(substr($this->file, strrpos($this->file, '.') + 1));
		
		// normalise shorter extensions
		if($ext == "JPG")
			return "JPEG";
			
		return $ext;
	}
	
}

?>
