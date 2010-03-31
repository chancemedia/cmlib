<?php

include_once("CMClass.php");

/**
 * @brief Generic class for discovering file types.
 * 
 * @author Elliot Chance
 */
class CMFileType implements CMClass {
	
	/**
	 * @brief Return the MIME type for a given extension.
	 * 
	 * @param $ext The extension <i>including</i> the dot, for example ".csv"
	 * @return String value for the MIME type or \false if it cannot be found.
	 */
	public static function GetMimeTypeForExtension($ext) {
		$mimeTypes = array(
			'jpg' => 'image/jpg',
			'jpeg' => 'image/jpg'
		);
		
		// see if we have this file extension
		$ext = strtolower($ext);
		if(isset($mimeTypes[$ext]))
			return $mimeTypes[$ext];
			
		// we don't know what this extension is
		return false;
	}
	
	/**
	 * @brief Get the class name for an extension.
	 * 
	 * @param $ext The extension <i>including</i> the dot, for example ".csv"
	 * @return A string name of a class, or \false if the file type is unknown.
	 */
	public static function GetClassForExtension($ext) {
		$exts = array(
			'.csv'       => 'CMFileCSV',
			'.ical'      => 'CMFileICAL',
			'.icalendar' => 'CMFileICAL',
			'.ics'       => 'CMFileICAL',
			'.ifb'       => 'CMFileICAL',
			'.vcard'     => 'CMFileVCF',
			'.vcf'       => 'CMFileVCF',
		);
		
		// see if we have a class for this file extension
		$ext = strtolower($ext);
		if(isset($exts[$ext]))
			return $exts[$ext];
			
		// we don't know what this file is
		return false;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
