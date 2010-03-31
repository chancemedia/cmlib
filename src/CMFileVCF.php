<?php

include_once('CMFileParser.php');

// commit 2

/**
 * @brief vCard files.
 * 
 * @author Elliot Chance
 */
class CMFileVCF implements CMFileParser {
	
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
	 * @brief vCard stack
	 * 
	 * Files or strings can contain multiple VCARD entities, for this reason we use an array to
	 * represent all of the vCards on the stack. You may edit this stack to make changed to the
	 * vCards before purging them to a file or string with writeFile() or writeString() respectivly.
	 */
	public $vCards = array();
	
	/**
	 * @brief Empty constructor creates a new blank vCard stack
	 */
	public function CMFileVCF() {
	}
	
	/**
	 * @brief Decode one or multiple vCards and return as one large array.
	 * 
	 * @param $content
	 */
	public static function DissectVCards($content) {
		// prepare
		$r = array();
		$entry = array();
		
		// split lines
		$lines = explode("\n", $content);
		
		// process the lines
		foreach($lines as $line) {
			// this is important, because ':' is special it has to be recognised
			$line = trim($line);
			if(strlen($line) == 0) continue;
			$line = str_replace('\:', '@@@', $line);
			
			if($line == 'BEGIN:VCARD') {
				$entity = array();
			} else if($line == 'END:VCARD') {
				$r[] = $entity;
			} else {
				$parts = explode(':', $line);
				$k = explode(';', $parts[0]);
				$entity[strtoupper($k[0])][]['value'] = str_replace('@@@', ':', $parts[1]);
				for($i = 1; $i < count($k); ++$i) {
					$attr = explode('=', $k[$i]);
					$entity[strtoupper($k[0])][count($entity[$k[0]]) - 1]['attr'][][$attr[0]] = $attr[1];
				}
			}
		}
		
		return $r;
	}
	
	/**
	 * @brief Create a vCard and return the result.
	 * 
	 * @param $values
	 */
	public static function CreateVCard($values) {
		$r = "BEGIN:VCARD\n";
		foreach($values as $k => $v) {
			$r .= strtoupper(trim(str_replace(':', '\:', $k)));
			if(is_array($v['attr']))
				$r .= ';' . implode(';', $v['attr']);
			$r .= ":" . str_replace(':', '\:', $v['value']) . "\n";
		}
		return $r . "END:VCARD\n";
	}
	
	/**
	 * @brief Read entire vCard file.
	 * 
	 * @param $url Valid PHP URL, relative or absolute path.
	 * @param $a Extra attributes.
	 */
	public function readFile($url, $a = false) {
		return false;
	}
	
	/**
	 * @brief Write entire vCard file.
	 * 
	 * @param $url Valid PHP URL, relative or absolute path.
	 * @param $a Extra attributes.
	 */
	public function writeFile($url, $a = false) {
		return false;
	}
	
	/**
	 * @brief Read one or more vCards from a string.
	 * 
	 * @param $str Input string to parse.
	 * @param $a Extra attributes.
	 */
	public function readString($str, $a = false) {
		return false;
	}
	
	/**
	 * @brief Write all vCards on the stack to an output string.
	 * 
	 * @param $a Extra attributes.
	 */
	public function writeString($a = false) {
		return false;
	}
	
	/**
	 * @brief Get standard extensions associated with vCard.
	 * 
	 * @return array('.vcf', '.vcard')
	 */
	public function getStandardExtensions() {
		return array('.vcf', '.vcard');
	}
	
	/**
	 * @brief Get an array of internet media types (previously known as MIME) associated with vCard.
	 * 
	 * @return array('text/x-vcard', 'text/directory;profile=vCard', 'text/directory')
	 */
	public function getInternetMediaTypes() {
		return array('text/x-vcard', 'text/directory;profile=vCard', 'text/directory');
	}
	
	/**
	 * @brief A type code is the only mechanism used in pre-Mac OS X versions of the Macintosh
	 * operating system.
	 * 
	 * A type code is the only mechanism used in pre-Mac OS X versions of the Macintosh operating
	 * system to denote a file's format, in a manner similar to file extensions in other operating
	 * systems. Codes are four-byte OSTypes. For example, the type code for a HyperCard stack is
	 * STAK; the type code of any application program is APPL.
	 * 
	 * http://en.wikipedia.org/wiki/Type_code
	 * 
	 * @return String value containing the type code. If there is no valid type code, \false is
	 *         returned.
	 */
	public function getTypeCode() {
		return 'vCrd';
	}
	
	/**
	 * @brief The Uniform Type Identifier (UTI.)
	 * 
	 * A Uniform Type Identifier (UTI) is a string defined by Apple Inc. that uniquely identifies
	 * the type of a class of items. Added in Apple's Mac OS X 10.4 operating system, UTIs are used
	 * to identify the type of files and folders, clipboard data, bundles, aliases and symlinks,
	 * and streaming data. Mac OS X's desktop search technology, Spotlight, uses UTIs to categorize
	 * documents. One of the primary design goals of UTIs was to eliminate the ambiguities and
	 * problems associated with inferring a file's content from its MIME type, filename extension,
	 * or type or creator code.
	 * 
	 * http://en.wikipedia.org/wiki/Uniform_Type_Identifier
	 * 
	 * @return A string value representing the UTI. If there is no valid type code, \false is
	 *         returned.
	 */
	public function getUniformTypeIdentifier() {
		return 'public.vcard';
	}
	
	/**
	 * @brief Iterate.
	 * 
	 * @param $options
	 */
	public function next($options = false) {
		return false;
	}
	
	/**
	 * @brief Iterate through input file.
	 * 
	 * @param $url
	 * @param $a Extra attributes.
	 * @return \true if the file handle was successfully created and is ready to start reading, otherwise
	 *         \false.
	 */
	public function iterateFile($url, $a = false) {
		return false;
	}
	
	/**
	 * @brief Iterate through string.
	 * 
	 * @param $url
	 * @param $a Extra attributes.
	 */
	public function iterateString($url, $a = false) {
		return false;
	}
	
	/**
	 * @brief Is vCard a binary file type?
	 * 
	 * vCard is not a binary file type.
	 * 
	 * @return \false.
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
