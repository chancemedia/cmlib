<?php

include_once('CMFileParser.php');
include_once('CMError.php');

if(!function_exists('str_getcsv')) {
	function str_getcsv($input, $delimiter = ',', $enclosure = '"',
	                    $escape = "\\", $eol = '\n') {
		if(is_string($input) && !empty($input)) {
			$output = array ();
			$tmp = preg_split("/" . $eol . "/", $input);
			if (is_array($tmp) && !empty($tmp)) {
				while ( list ( $line_num, $line ) = each($tmp) ) {
					if (preg_match("/" . $escape . $enclosure . "/", $line)) {
						while ( $strlen = strlen($line) ) {
							$pos_delimiter = strpos($line, $delimiter);
							$pos_enclosure_start = strpos($line, $enclosure);
							if(is_int($pos_delimiter) &&
							   is_int($pos_enclosure_start) &&
							   ($pos_enclosure_start < $pos_delimiter)) {
								$enclosed_str = substr($line, 1);
								$pos_enclosure_end =
									strpos($enclosed_str, $enclosure);
								$enclosed_str = substr($enclosed_str, 0,
									$pos_enclosure_end);
								$output [$line_num] [] = $enclosed_str;
								$offset = $pos_enclosure_end + 3;
							} else {
								if(empty($pos_delimiter) &&
								   empty($pos_enclosure_start)) {
									$output [$line_num][] = substr($line, 0);
									$offset = strlen($line);
								} else {
									$output [$line_num][] =
										substr($line, 0, $pos_delimiter);
									$offset = (!empty($pos_enclosure_start) &&
									($pos_enclosure_start < $pos_delimiter)) ?
									$pos_enclosure_start : $pos_delimiter + 1;
								}
							}
							$line = substr($line, $offset);
						}
					} else {
						$line = preg_split("/" . $delimiter . "/", $line);
						
						// Validating against pesky extra line breaks creating
						// false rows.
						if(is_array($line) && !empty($line[0]))
							$output [$line_num] = $line;
					}
				}
				
				return $output;
			}
			else
				return false;
		}
		else
			return false;
	}
}

/**
 * @brief Class for handling CSV (comma-separated values) files.
 * 
 * @section cmfilecsv_desc Description
 * The CMFileCSV only acts as an interface for reading and writing CSV files but not contain any
 * storage or caching. As CSV files cannot be directly updated from anywhere but the end of the file
 * a CMFileCSV will word as a reader or writer. It is common and recommended to use two CMFileCSV's
 * when rewriting a CSV file as Example 4 shows.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMFileCSV extends CMError implements CMFileParser {
	
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
	 * @brief Delimiter.
	 * 
	 * @see cmfilecsv_format
	 */
	public $delimiter = ',';
	
	/**
	 * @brief Enclosure.
	 * 
	 * @see cmfilecsv_format
	 */
	public $enclosure = '"';
	
	/**
	 * @brief Internal file handle.
	 */
	private $f = false;
	
	/**
	 * @brief Mapped field names.
	 */
	private $fields = false;
	
	/**
	 * @brief Used when this->f is a string handle.
	 * 
	 * As the string is read incrementally this variable will keep track of the read position.
	 */
	private $pos = 0;
	
	/**
	 * @brief Create a new CMFileCSV with optional field names.
	 * 
	 * This constructor does nothing more than set the field names, you will need to initiate a read or
	 * write CSV with another method in this class.
	 * 
	 * @throwsWarning If \p $fields is provided but is not an array. The \p $fields will be ignored
	 *                after the error is thrown. The \c 'fields' attribute will hold the value of
	 *                the incorrect value passed.
	 * 
	 * @param $fields Optional array of field names.
	 */
	public function CMFileCSV($fields = false) {
		if($fields !== false) {
			if(is_array($fields))
				$this->fields = $fields;
			else $this->throwWarning("The provided \$fields is not an array",
					array('fields' => $fields));
		}
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
	 * @throwsError If the file handle cannot be opened. The \c 'uri' attribute will hold the URI
	 *              that was unable to be opened. And the method will immediatly return \false.
	 * 
	 * @param $uri URI can be a URL, relative or absolute path.
	 * @param $a An associative array of extra options.
	 * @return \true if the file handle was successfully created and is ready to start reading, otherwise
	 *         \false.
	 * 
	 * @see error()
	 */
	public function iterateFile($uri, $a = false) {
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
				$this->next();
		}
		
		return true;
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
	 * @param $a An associative array of extra options.
	 * @return \true on successful completion, otherwise \false. See error() for a \false return.
	 */
	public function iterateString($str, $a = false) {
		// assign the string to our internal handle with a trailing line, this is very important
		$this->f = "$str\n";
		
		// $a must be an array
		if(!is_array($a))
			$a = array($a => true);
		
		// skip lines
		if(isset($a['skip'])) {
			for($i = 0; $i < $a['skip']; ++$i)
				$this->next();
		}
		
		return true;
	}
	
	/**
	 * @brief Read a CSV file.
	 * 
	 * Parse an entire file and return a two-dimentional array of parsed data.
	 * 
	 * @param $url Valid PHP URL, relative or absolute path.
	 * @param $a An associative array of extra options.
	 * @return \false on error, otherwise an array.
	 */
	public function readFile($url, $a = false) {
		// open the file
		if($this->iterateFile($url, $a) === false)
			return false;
			
		// read all the elements
		$r = array();
		while($line = $this->next())
			$r[] = $line;
		
		return $r;
	}
	
	/**
	 * @brief Not available.
	 * 
	 * See cmfileparser_cache for more information.
	 *
	 * @param $uri A valid PHP URL, relative or absolute path.
	 * @param $a Extra options.
	 * @return \false.
	 */
	public function writeFile($uri, $a = false) {
		return false;
	}
	
	/**
	 * @brief Parse one ore more CSV lines.
	 * 
	 * Parse an entire string and return a two-dimentional array of parsed data.
	 * 
	 * @param $str Input string to parse.
	 * @param $a An associative array of extra options.
	 * @return \false on error, otherwise an array.
	 */
	public function readString($str, $a = false) {
		// open the file
		if($this->iterateString($str, $a) === false)
			return false;
			
		// read all the elements
		$r = array();
		while($line = $this->next())
			$r[] = $line;
		
		return $r;
	}
	
	/**
	 * @brief Not available.
	 * 
	 * See cmfileparser_cache for more information.
	 * 
	 * @param $a An associative array of extra options.
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
		return array('.csv', '.txt');
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
		return array('text/csv', 'text/comma-separated-values');
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
	 * @throwsWarning If the data is not a stream or file. The method will immediatly return \false.
	 * 
	 * @param $options An optional argument to provide the class with extra options when reciving
	 *        the next object.
	 * @return \false if not available or the end of the iteration has been reached. Otherwise the
	 *         string, number, array, object etc of the next iteration.
	 */
	public function next($options = false) {
		// iterateFile
		if(is_resource($this->f) && (get_resource_type($this->f) == 'stream' ||
		   get_resource_type($this->f) == 'file')) {
			// make sure the file handle is open and still got data left
			if($this->f === false || feof($this->f))
				return false;
				
			// get and split the data
			$r = fgetcsv($this->f, 4096, $this->delimiter, $this->enclosure);
		} else {
			// grab the next line
			$new_pos = strpos($this->f, "\n", $this->pos);
			
			// return false when we reach the end
			if($new_pos === false || $new_pos >= strlen($this->f))
				return false;
				
			$line = substr($this->f, $this->pos, $new_pos - $this->pos);
			$r = str_getcsv($line, $this->delimiter, $this->enclosure);
			$this->pos = $new_pos + 1;
		}
			
		// map the field names
		if($this->fields !== false) {
			$newr = array();
			for($i = 0; $i < count($r); ++$i)
				$newr[$this->fields[$i]] = $r[$i];
			$r = $newr;
		}
		
		// trim off the new line if needed
		$temp = $r[count($r) - 1];
		if(substr($temp, strlen($temp) - 1, 1) == "\n")
			$r[count($r) - 1] = substr($temp, 0, strlen($temp) - 1);
		
		return $r;
	}
	
	/**
	 * @brief File is binary?
	 * 
	 * CSV files are not binary.
	 * 
	 * @return Always \false.
	 */
	public function isBinary() {
		return false;
	}
	
	/**
	 * @brief Return the string value of this object.
	 * @return Always "<CMFileCSV>".
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
	/**
	 * @brief Prepare a CSV file for writing.
	 * 
	 * @warning This method will use the default 'w' open method which will ERASE a file if it already
	 *          exists. If you want to append to a file make sure you provide the 'append' option in
	 *          $a like:
	 *          @code
	 *          $csv->writeFile("outfile.csv", array('append' => true));
	 *          @endcode
	 * 
	 * @warning When using append mode, this function will assume that the last character on the end of the
	 *          file is a line delimiter. If it is not then the first record will be written to the file
	 *          on the same line as the last record making the CSV invalid.
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
	 * @brief Check if this class instance is in caching mode.
	 * 
	 * CMFileCSV does not support caching so this function will always return \false.
	 * 
	 * @return \false.
	 * @see setCache()
	 */
	public function isCaching() {
		return false;
	}
	
	/**
	 * @brief Enable/disable caching for this instance.
	 * 
	 * CMFileCSV does not support file caching so this invoked method will be ignored.
	 * 
	 * @param $mode \true or \false for on and off respectivly.
	 * @return \false.
	 * @see isCaching()
	 */
	public function setCache($mode = true) {
		return false;
	}
	
	/**
	 * @brief Immediatly write a line to the output CSV file.
	 * 
	 * @note Before you can invoke this function you need to invoke prepareWriteFile().
	 * 
	 * @throwsWarning If the stream could not be opened for writing. The method will immediatly
	 *                return \false.
	 * 
	 * @throwsWarning If the stream is invalid. The method will immediatly return \false.
	 * 
	 * @throwsError If the provided \p $item is not an array. The \c 'item' attribute will hold the
	 *              \p $item argument that was passed. The method will immediatly return \false.
	 * 
	 * @param $item This must be a non-associative array. You can not use an associtave array because
	 *        associative arrays do not have a key order and it is likely the data will be written in a
	 *        scrambled order.
	 * @return \true if the new line was successfully purged to the output file, otherwise \false.
	 * @see prepareWriteFile()
	 */
	public function add($item = false) {
		// we need an open file handle
		if($this->f === false)
			return $this->throwError("Item could not be added");
			
		// item must be an array or we fail
		if(!is_array($item))
			return $this->throwError("\$item is not an array", array('item' => $item));
		
		$success = fputcsv($this->f, $item, $this->delimiter, $this->enclosure);
		if(!$success)
			return $this->throwError("Item could not be added");
			
		return $success;
	}
	
	/**
	 * @brief Close and flush the writing file handle.
	 * 
	 * This is always recommended, but in some cases when the PHP script finishes the file handles will
	 * be flushed and closed for you. Opening a read file handle on a file that has no been closed yet
	 * will cause problems.
	 * 
	 * @return Always \true.
	 * @see prepareWriteFile()
	 */
	public function finishWriteFile() {
		if($this->f !== false)
			fclose($this->f);
		return true;
	}
	
}

?>
