<?php

include_once('CMFile.php');
include_once('CMFileMultiReader.php');
include_once('CMFileMultiWriter.php');
include_once('CMVCalendar.php');
include_once('CMVItem.php');

/**
 * @brief This class is for iCal items.
 * 
 * @author Elliot Chance
 */
class CMFileICAL implements CMFile, CMFileMultiReader, CMFileMultiWriter {
	
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
	 * @brief Internal file handle.
	 */
	private $f = false;
	
	/**
	 * @brief Input a file in peices.
	 * 
	 * @param $uri URI can be a URL, relative or absolute path.
	 * @param $a Extra attributes.
	 * @return \true if the file handle was successfully created and is ready to start reading, otherwise
	 *         \false.
	 * 
	 * @see error()
	 */
	public function readFile($uri, $a = false) {
		// all we have to do with this function is setup the input file handle
		$this->f = fopen($uri, "r");
		if(!$this->f) {
			$this->throwError("File could not be opened", array('uri' => $uri));
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
	 * @brief Input a string in peices.
	 * 
	 * @param $str Input string.
	 * @param $a Extra attributes.
	 * @return \true on successful completion, otherwise \false. See error() for a \false return.
	 * 
	 * @see error()
	 */
	public function readString($str, $a = false) {
		// assign the string to our internal handle with a trailing line, this is very important
		$this->f = "$str\n";
		
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
	 * @brief The standard file extensions for this file parser.
	 * 
	 * The first element in the array returned is assumed to be the default file extension.
	 * 
	 * @return Array of file extensions that contain the dot (.) where needed.
	 */
	public function getStandardExtensions() {
		return array('.ical', '.ics', '.ifb', '.icalendar');
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
		return array('text/calendar');
	}
	
	/**
	 * @brief Replace escapes with literal characters.
	 * @param $str Input string.
	 * @see escapeString()
	 */
	public function unescapeString($str) {
		$str = str_replace('\n', "\n", $str);
		$str = str_replace('\t', "\t", $str);
		$str = str_replace('\r', "\r", $str);
		return $str;
	}
	
	/**
	 * @brief Replace literal characters with escapes.
	 * @param $str Input string.
	 * @see unescapeString()
	 */
	public function escapeString($str) {
		$str = str_replace("\n", '\n', $str);
		$str = str_replace("\t", '\t', $str);
		$str = str_replace("\r", '\r', $str);
		return $str;
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
	public function readNext($options = false) {
		// prechecks
		$r = false;
		$event = false;
		$depth = 0;
		$child = new CMVItem("");
		if($this->f === false || feof($this->f))
			return $r;
		
		// reading the file one line at a time look for the open
		while(!feof($this->f)) {
			$line = trim(fgets($this->f));
			$pos = strpos($line, ":");
			if($pos !== false) {
				$key = substr($line, 0, $pos);
				$value = substr($line, $pos + 1);
			}
			
			if($line == "BEGIN:VCALENDAR")
				$r = new CMVCalendar();
			elseif($line == "END:VCALENDAR")
				return $r;
			elseif($key == "BEGIN") {
				if($depth == 0)
					$event = new CMVItem($value);
				else
					$child = new CMVItem($value);
				++$depth;
			} elseif($key == "END") {
				if($depth == 1)
					$r->addItem($event);
				else
					$event->children[] = $child;
				--$depth;
			}
				
			elseif($key == "VERSION")
				$r->version = $value;
			elseif($key == "PRODID")
				$r->prodID = $value;
				
			else {
				$a = explode(";", $key);
				$a2 = array();
				for($i = 1; $i < count($a); ++$i) {
					$item = $a[$i];
					$pos = strpos($item, "=");
					$a2[substr($item, 0, $pos)] = substr($item, $pos + 1);
				}
				
				$value = $this->unescapeString($value);
				if($depth == 1)
					$event->addAttribute($a[0], $value, $a2);
				else
					$child->addAttribute($a[0], $value, $a2);
			}
		}
		
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
	 * @brief Prepare a iCal file for writing.
	 * 
	 * @warning This method will use the default 'w' open method which will ERASE a file if it already
	 *          exists. If you want to append to a file make sure you provide the 'append' option in
	 *          $a like:
	 *          @code
	 *          $ical->writeFile("outfile.ical", array('append' => true));
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
			return $this->throwWarning("The output file could not be opened", array('uri' => $uri));
		
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
	 * @brief Internal method for writing CMVCalendar objects.
	 * @param $it CMVCalendar object.
	 * @see writeNext()
	 * @return Always \true.
	 */
	private function writeNextItem($it) {
		fwrite($this->f, "BEGIN:" . $it->type . "\n");
		foreach($it->attr as $k => $vs) {
			foreach($vs as $v) {
				fwrite($this->f, $k);
				foreach($v as $k2 => $v2) {
					if($k2 != "VALUE")
						fwrite($this->f, ";$k2=$v2");
				}
				fwrite($this->f, ":" . $this->escapeString($v['VALUE']) . "\n");
			}
		}
			
		if(count($it->children) > 0) {
			foreach($it->children as $item)
				$this->writeNextItem($item);
		}
				
		fwrite($this->f, "END:" . $it->type . "\n");
		
		return true;
	}
	
	/**
	 * @brief Write the next VCalendar item to the file.
	 * @param $item CMVCalendar object.
	 * @return Always \true.
	 */
	public function writeNext($item = false) {
		if($this->f === false)
			return false;
			
		fwrite($this->f, "BEGIN:VCALENDAR\n");
		fwrite($this->f, "VERSION:" . $item->version . "\n");
		fwrite($this->f, "PRODID:" . $item->prodID . "\n");
		
		foreach($item->items as $it)
			$this->writeNextItem($it);
		
		fwrite($this->f, "END:VCALENDAR\n");
		
		return true;
	}
	
}

?>
