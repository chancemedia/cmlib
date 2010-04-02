<?php

include_once('CMFileParser.php');

// another change 2

/**
 * @brief This class is for iCal items.
 * 
 * @author Elliot Chance
 */
class CMFileICAL implements CMFileParser {
	
	/**
	 * @brief The version of this class.
	 * @return String version.
	 * @see CMVersion
	 */
	public static function Version() {
		return "1.0";
	}
	
	/**
	 * @brief The version this class was introduced to the library.
	 * @return String version.
	 * @see CMVersion
	 */
	public static function Since() {
		return "1.0";
	}
	
	/**
	 * @brief Input a file in peices.
	 * 
	 * The purpose of this method is when you are dealing with large input files. This method
	 * simply opens the file and requires the code to invoke next() as needed to deal with each
	 * line or object.
	 * 
	 * @note If you attempt to use readFile() the entire file will be processed into RAM according
	 * to the action of that class and how it stores the data.
	 * 
	 * @param $uri URI can be a URL, relative or absolute path.
	 * @param $a Extra attributes.
	 * @return \true if the file handle was successfully created and is ready to start reading, otherwise
	 *         \false.
	 * 
	 * @see error()
	 */
	public function iterateFile($uri, $a = false) {
		return false;
	}
	
	/**
	 * @brief Input a string in peices.
	 * 
	 * This method works in the same way as iterateFile() but works with the string provided rather
	 * than an input file.
	 * 
	 * @note If you attempt to use readString() the entire string will be processed into RAM
	 * according to the action of that class and how it stores the data.
	 * 
	 * @param $str Input string.
	 * @param $a Extra attributes.
	 * @return \true on successful completion, otherwise \false. See error() for a \false return.
	 * 
	 * @see error()
	 */
	public function iterateString($str, $a = false) {
		return false;
	}
	
	/**
	 * @brief Create iCal entry and return it.
	 * 
	 * @param $start
	 * @param $end
	 * @param $summary
	 * @param $description
	 * @param $company
	 * @param $uid
	 */
	public static function CreateICal($start, $end, $summary, $description, $company, $uid = false) {
		if($uid === false)
			$uid = md5(date('Ymd') . date('His'));
			
		$c = "BEGIN:VCALENDAR\n";
		$c .= "VERSION:2.0\n";
		$c .= "PRODID:-//$company//NONSGML $company//EN\n";
		$c .= "METHOD:REQUEST\n"; // requied by Outlook
		$c .= "BEGIN:VEVENT\n";
		$c .= "UID:$uid\n"; // required by Outlook
		$c .= "DTSTAMP:" . date('Ymd') . 'T' . date('His') . "\n"; // required by Outlook
		$c .= "DTSTART:$start\n";
		$c .= "DTEND:$end\n";
		$c .= "SUMMARY:$summary\n";
		$c .= "DESCRIPTION:$description\n";
		$c .= "END:VEVENT\n";
		$c .= "END:VCALENDAR\n";
		
		return $c;
	}
	
	/**
	 * @brief Read an iCal file.
	 * 
	 * @warning This method has not been implemented yet.
	 * 
	 * @param $url Valid PHP URL, relative or absolute path.
	 * @param $a Extra attributes.
	 * @return \false
	 */
	public function readFile($url, $a = false) {
		return false;
	}
	
	/**
	 * @brief Write iCal file.
	 * 
	 * @warning This method has not been implemented yet.
	 * 
	 * @param $url Valid PHP URL, relative or absolute path.
	 * @param $a Extra attributes.
	 * @return \false
	 */
	public function writeFile($url, $a = false) {
		return false;
	}
	
	/**
	 * @brief Parse one ore more iCal items.
	 * 
	 * @warning This method has not been implemented yet.
	 * 
	 * @param $str Input string to parse.
	 * @param $a Extra attributes.
	 * @return \false.
	 */
	public function readString($str, $a = false) {
		return false;
	}
	
	/**
	 * @brief Write full output to a string.
	 * 
	 * This method is supposed to work like writeFile() but returning the value instead of writing
	 * it to an output file/URI.
	 * 
	 * @warning This method has not been implemented yet.
	 * 
	 * @param $a Extra attributes.
	 * @return \false.
	 */
	public function writeString($a = false) {
		return false;
	}
	
	/**
	 * @brief The standard file extensions for this file parser.
	 * 
	 * The first element in the array returned is assumed to be the default file extension.
	 * 
	 * @return Array of file extensions that contain the dot (.) where needed.
	 */
	public function getStandardExtensions() {
		return false;
	}
	
	/**
	 * @brief Get internet media type (originally MIME type.)
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
		return false;
	}
	
	/**
	 * @brief Interate to the next line or object.
	 * 
	 * Not all subclasses will implement this, if not it will return \false. The prupose of this
	 * method is to use in conjuntion with readFile() to read a single entity - whether it be a line
	 * or some other form or entity to the class - without the need to load the entire file
	 * directly into the class.
	 * 
	 * See the documentation for this method in the subclasses to see what it's purpose for that
	 * particular class is.
	 * 
	 * @param $options An optional argument to provide the class with extra options when reciving
	 *        the next object.
	 * @return \false if not avilable or the end of the iteration has been reached. Otherwise the
	 *         string, number, array, object etc of the next iteration.
	 */
	public function next($options = false) {
		return false;
	}
	
	/**
	 * @brief Does this class handle binary files?
	 * 
	 * iCal is not a binary format.
	 * 
	 * @return \false
	 */
	public function isBinary() {
		return false;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
	/**
	 * @param $uri
	 * @param $a
	 */
	public function prepareWriteFile($uri, $a = false) {
		return false;
	}
	
	/**
	 * @see CMFileParser::isCaching()
	 */
	public function isCaching() {
		return false;
	}
	
	/**
	 * @param $mode
	 */
	public function setCache($mode = true) {
		return false;
	}
	
	/**
	 * @param $item
	 */
	public function add($item = false) {
		return false;
	}
	
	/**
	 * @see CMFileParser::finishWriteFile()
	 */
	public function finishWriteFile() {
		return false;
	}
	
}

?>
