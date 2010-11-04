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
	 * @brief Get the height (in pixels) of a file.
	 * @param $file The path of the file.
	 * @return An integer on success or \false if there was an error.
	 */
	public static function ImageHeight($file) {
		$dimentions = getimagesize($file);
		return $dimentions[1];
	}
	
	/**
	 * @brief Get the width (in pixels) of a file.
	 * @param $file The path of the file.
	 * @return An integer on success or \false if there was an error.
	 */
	public static function ImageWidth($file) {
		$dimentions = getimagesize($file);
		return $dimentions[0];
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
	
	/**
	 * @brief The standard file extensions for all support image formats.
	 * 
	 * @return Array of file extensions that contain the dot (.) where needed.
	 * @see CMFileType::GetClassForExtension().
	 */
	public function getStandardExtensions() {
		return array('.gif', '.jpg', '.jpeg', '.png');
	}
	
	/**
	 * @brief Get internet media type (originally MIME type.)
	 * 
	 * Return the internet media types for all the image formats supported.
	 * 
	 * An Internet media type, originally called a MIME type after MIME and sometimes a
	 * <tt>Content-type</tt> after the name of a header in several protocols whose value is such a
	 * type, is a two-part identifier for file formats on the Internet. The identifiers were
	 * originally defined in <tt>RFC 2046</tt> for use in e-mail sent through SMTP, but their use
	 * has expanded to other protocols such as HTTP, RTP and SIP.
	 * 
	 * A media type is composed of at least two parts: a type, a subtype, and one or more optional
	 * parameters. For example, subtypes of text type have an optional charset parameter that can be
	 * included to indicate the character encoding, and subtypes of multipart type often define a
	 * boundary between parts.
	 * 
	 * Types or subtypes that begin with <tt>x-</tt> are nonstandard (they are not registered with
	 * IANA). Subtypes that begin with <tt>vnd.</tt> are vendor-specific; subtypes in the personal
	 * or vanity tree begin with <tt>prs.</tt>.
	 * 
	 * MIME is short for Multipurpose Internet Mail Extensions, a specification for formatting
	 * non-ASCII messages so that they can be sent over the Internet. Many e-mail clients now
	 * support MIME, which enables them to send and receive graphics, audio, and video files via the
	 * Internet mail system. In addition, MIME supports messages in character sets other than ASCII.
	 * 
	 * http://en.wikipedia.org/wiki/Internet_media_type
	 * 
	 * @return An array of internet media types.
	 */
	public function getInternetMediaTypes() {
		return array('image/gif', 'image/jpeg', 'image/png');
	}
	
	/**
	 * @brief Binary file type.
	 * 
	 * All supported image formats are binary.
	 * 
	 * @return Always \true.
	 */
	public function isBinary() {
		return true;
	}
	
	/**
	 * @brief Return the string value of this object.
	 * @return Always "<CMFileCSV>".
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
