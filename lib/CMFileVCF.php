<?php

include_once('CMFile.php');
include_once('CMError.php');
include_once('CMFileMultiReader.php');
include_once('CMFileMultiWriter.php');
include_once('CMVCard.php');

/**
 * @brief vCard files.
 * 
 * @author Elliot Chance
 */
class CMFileVCF extends CMError implements CMFile, CMFileMultiReader, CMFileMultiWriter {
	
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
	 * @brief Empty constructor creates a new blank vCard stack
	 */
	public function CMFileVCF() {
	}
	
	/**
	 * @brief Internal file handle.
	 */
	private $f = false;
	
	/**
	 * @brief Read one or more vCards from a string.
	 * 
	 * @param $content Input string to parse.
	 * @param $a Extra attributes.
	 */
	public function readString($content, $a = false) {
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
	 * @brief Read vCard file.
	 * 
	 * @param $url Valid PHP URL, relative or absolute path.
	 * @param $a Extra attributes.
	 */
	public function readFile($url, $a = false) {
		// all we have to do with this function is setup the input file handle
		$this->f = fopen($url, "r");
		if(!$this->f) {
			$this->throwError("File could not be opened", array('uri' => $url));
			return false;
		}
			
		// $a must be an array
		if(!is_array($a))
			$a = array($a => true);
		
		// skip lines
		if(isset($a['skip'])) {
			for($i = 0; $i < $a['skip']; ++$i)
				$this->readNext();
		}
		
		return true;
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
	 * @brief Read next vCard object.
	 * 
	 * @param $options
	 */
	public function readNext($options = false) {
		// prechecks
		$r = false;
		$vcard = false;
		if($this->f === false || feof($this->f))
			return $r;
		
		// reading the file one line at a time look for the open
		while(!feof($this->f)) {
			$line = trim(fgets($this->f));
			if($line == "")
				continue;
			
			$pos = strpos($line, ":");
			if($pos !== false) {
				$key = substr($line, 0, $pos);
				$value = substr($line, $pos + 1);
			}
			
			if($line == "BEGIN:VCARD")
				$r = new CMVCard();
			elseif($line == "END:VCARD")
				return $r;
				
			elseif($key == "VERSION")
				$r->setVersion($value);
				
			else {
				$k = explode(';', $key);
				$attributes = array();
				for($i = 1; $i < count($k); ++$i) {
					$attr = explode('=', $k[$i]);
					$attributes[$attr[0]] = $attr[1];
				}
				$r->add($k[0], $value, $attributes);
			}
		}
		
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
	 * @brief Prepare a vCard file for writing.
	 * 
	 * @warning This method will use the default 'w' open method which will ERASE a file if it already
	 *          exists. If you want to append to a file make sure you provide the 'append' option in
	 *          $a like:
	 *          @code
	 *          $vcf->writeFile("outfile.vcf", array('append' => true));
	 *          @endcode
	 * 
	 * @throwsWarning If the output file handle could not be prepared. The \c 'uri' attribute will
	 *                contain the \p $uri passed to this method.
	 * 
	 * @param $uri Valid PHP URL, relative or absolute path.
	 * @param $a An associative array of extra options.
	 * @return \true if the file handle was open sucessfully and the file is ready to be written to,
	 *         otherwise \false.
	 */
	public function prepareWriteFile($uri, $a = false) {
		// $a must be an array
		if(!is_array($a))
			$a = array($a => true);
		
		// this method only has to open the writing file handle
		if(isset($a['append']))
			$this->f = fopen($uri, "a+");
		else $this->f = fopen($uri, "w");
		
		if($this->f === false)
			return $this->throwWarning("The output file could not be opened",
						array('uri' => $uri));
		
		return $this->f !== false;
	}
	
	/**
	 * @brief Close and flush the writing file handle.
	 * 
	 * This is always recommended, but in some cases when the PHP script finishes the file handles will
	 * be flushed and closed for you. Opening a read file handle on a file that has no been closed yet
	 * will cause problems.
	 * 
	 * @param $a Options. Ignored.
	 * @return Always \true.
	 * @see prepareWriteFile()
	 */
	public function finishWriteFile($a = array()) {
		if($this->f !== false)
			fclose($this->f);
		return true;
	}
	
	/**
	 * @brief Write a CMVCard object to the output file.
	 * @param $item CMVCard object.
	 */
	function writeNext($item = false) {
		if($this->f === false)
			return false;
			
		// item must be a CMVCard
		if(get_class($item) != "CMVCard")
			return $this->throwWarning("\$item must be a CMVCard object.");
			
		fwrite($this->f, "BEGIN:VCARD\n");
		fwrite($this->f, "VERSION:" . $item->getVersion() . "\n");
		foreach($item->getData() as $k => $value) {
			foreach($value as $v) {
				fwrite($this->f, strtoupper(trim(str_replace(':', '\:', $k))));
				if(is_array($v['attr'])) {
					foreach($v['attr'] as $ak => $av) {
						fwrite($this->f, ';');
						if($av != "")
							fwrite($this->f, "$ak=$av");
						else
							fwrite($this->f, $ak);
					}
				}
				fwrite($this->f, ":" . str_replace(':', '\:', $v['value']) . "\n");
			}
		}
		fwrite($this->f, "END:VCARD\n");
		
		return true;
	}
	
}

?>
