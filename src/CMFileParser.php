<?php

include_once('CMClass.php');

// change

/**
 * @brief File parser interface.
 * 
 * @section cmfileparser_description Description
 * Classes that implement this interface are required to implement all the method, however are not
 * required to return a non-\false value for method that either do not apply, are not available or
 * caused some kind of error.
 * 
 * @section cmfileparser_usage Usage
 * You are free to write your own file parsing classes from this interface but the interface alone
 * has no purpose in your application.
 * 
 * @section cmfileparser_example Example
 * See subclasses for specific examples.
 * 
 * @section cmfileparser_cache Caching vs Noncaching File Parsers
 * Some file parsers do not hold any information about the file they are reading from or writing to and
 * merely act as a standard interface for the reading and writing of the file. These are called
 * noncaching parsers. Noncaching file parser may not implement all of the methods in this interface,
 * such as writeFile() or writeString() which renders the output of the class storage for that file
 * format.
 * 
 * On the other hand caching file parsers will maintain an internal storage of data that can be
 * manipulated and committed or read from a file in one go. This can prove troublesome for large files.
 * For example the CSV file format is text and in most cases quite small files, however if you had to
 * process a file that was 100MB or a value above the amount of memory PHP is allowed to allcate your
 * program would stop functioning properly. The solution for this is to separate methods for
 * reading/writing and entire file with methods for reading/writing a single 'item' at a time. In the 
 * case of CSV the 'item' would be a single line.
 * 
 * Here is a table showing the methods that are usually available with each type of file parser:
 * <table>
 *   <tr>
 *     <th>Function</th>
 *     <th>Caching Parser</th>
 *     <th>Noncaching Parser</th>
 *     <th>Description</th>
 *   </tr>
 *   <tr>
 *     <td>add()</td>
 *     <td>Yes</td>
 *     <td>Yes</td>
 *     <td>Add a new 'item'. The 'item' depends on what the file parser handles, but for example if the
 *         class was CMFileCSV the add() would take an array representing the field to write to the
 *         file as a single line.</td>
 *   </tr>
 *   <tr>
 *     <td>iterateFile()</td>
 *     <td>Yes</td>
 *     <td>Yes</td>
 *     <td>Open a file handle and wait for next().</td>
 *   </tr>
 *   <tr>
 *     <td>iterateString()</td>
 *     <td>Yes</td>
 *     <td>Yes</td>
 *     <td>Assign a string but do not start reading it until a next() is invoked.</td>
 *   </tr>
 *   <tr>
 *     <td>prepareWriteFile()</td>
 *     <td>No</td>
 *     <td>Yes</td>
 *     <td>For noncaching file parsers this will initiate the output file handle which is performing
 *         the reverse of iterateFile() then use add() to write each item to the output file.</td>
 *   </tr>
 *   <tr>
 *     <td>readFile()</td>
 *     <td>Yes</td>
 *     <td>No</td>
 *     <td>Process an entire file.</td>
 *   </tr>
 *   <tr>
 *     <td>readString()</td>
 *     <td>Yes</td>
 *     <td>No</td>
 *     <td>Process an entire string.</td>
 *   </tr>
 *   <tr>
 *     <td>writeFile()</td>
 *     <td>Yes</td>
 *     <td>No</td>
 *     <td>Render the internal storage and write the whole thing to an output file.</td>
 *   </tr>
 *   <tr>
 *     <td>writeString()</td>
 *     <td>Yes</td>
 *     <td>No</td>
 *     <td>Render the internal storage and return it.</td>
 *   </tr>
 * </table>
 * 
 * @author Elliot Chance
 */
interface CMFileParser extends CMClass {
	
	/**
	 * @brief Add/write a new item to the class.
	 * 
	 * This method is avilable to caching and noncaching file parsers. In the case of a caching file
	 * parser the $item will be added to an internal storage stack. In the case of a noncaching file
	 * parser the $item will be processed and commited directly to the file, this means you must use
	 * writeFile().
	 * 
	 * @param $item New item.
	 * @return \true on success, otherwise \false.
	 */
	public function add($item = false);
	
	/**
	 * @brief Input a file in peices.
	 * 
	 * The purpose of this method is when you are dealing with large input files. Or when the file
	 * parsing class does not handle its own storage (noncaching.) This method simply opens the file
	 * and requires the code to invoke next() as needed to deal with each line or object.
	 * 
	 * @note If you attempt to use readFile() the entire file will be processed into RAM according
	 *       to the action of that class and how it stores the data.
	 * 
	 * @param $uri URI can be a URL, relative or absolute path.
	 * @param $a An associative array of extra options.
	 * @return \true if the file was opened and is ready to start reading from, otherwise \false.
	 * @see error()
	 */
	public function iterateFile($uri, $a = false);
	
	/**
	 * @brief Input a string in peices.
	 * 
	 * This method works in the same way as iterateFile() but works with the string provided rather
	 * than an input file. The size limit $str is upto PHP limits, if you are dealing with large files
	 * consider using temporary disk files or temporary database storage.
	 * 
	 * @note If you attempt to use readString() the entire string will be processed into RAM
	 *       according to the action of that class and how it stores the data.
	 * 
	 * @param $str Input string.
	 * @param $a An associative array of extra options.
	 * @return \true almost always. \false is only returned if the class knows ahead of time that the
	 *         string will not be able to be processed.
	 * @see error()
	 */
	public function iterateString($str, $a = false);
	
	/**
	 * @brief Load entire file.
	 * 
	 * @note This method is only only available to caching file parsers.
	 * 
	 * @note For use with large files, use iterateFile().
	 * 
	 * @param $uri Valid PHP URL, relative or absolute path.
	 * @param $a An associative array of extra options.
	 * @return \true on successful completion, otherwise \false. See error() for a \false return.
	 * @see error()
	 * @see isCaching()
	 * @see setCaching()
	 */
	public function readFile($uri, $a = false);
	
	/**
	 * @brief Load an entire string.
	 * 
	 * @note This method is only only available to caching file parsers.
	 * 
	 * @note For use with large strings, use iterateString().
	 * 
	 * @param $str Input string to parse.
	 * @param $a An associative array of extra options.
	 * @return \true on successful completion, otherwise \false. See error() for a \false return.
	 * @see error()
	 * @see isCaching()
	 * @see setCaching()
	 */
	public function readString($str, $a = false);
	
	/**
	 * @brief Write rendered output to a file.
	 * 
	 * @note This method is only only available to caching file parsers.
	 * 
	 * writeFile() effectivly does the same thing as writeString() with the main difference being it
	 * writes the rendered output to a given URI.
	 * 
	 * @param $url Valid PHP URL, relative or absolute path.
	 * @param $a An associative array of extra options.
	 * @return \true on successful completion, otherwise \false. See error() for a \false return.
	 * @see error()
	 * @see isCaching()
	 * @see setCaching()
	 */
	public function writeFile($url, $a = false);
	
	/**
	 * @brief Return the rendered output.
	 * 
	 * @note This method is only only available to caching file parsers.
	 * 
	 * writeString() and writeFile() do the same thing, but the first returns the value and the
	 * second writes that same value to a supplied URI.
	 * 
	 * @param $a An associative array of extra options.
	 * @return \true on successful completion, otherwise \false. See error() for a \false return.
	 * @see error()
	 * @see isCaching()
	 * @see setCaching()
	 */
	public function writeString($a = false);
	
	/**
	 * @brief The standard file extensions for this file parser.
	 * 
	 * The first element in the array returned is assumed to be the default file extension.
	 * 
	 * @return Array of file extensions that contain the dot (.) where needed.
	 * @see CMFileType::GetClassForExtension().
	 */
	public function getStandardExtensions();
	
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
	public function getInternetMediaTypes();
	
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
	public function next($options = false);
	
	/**
	 * @brief Binary file type.
	 * 
	 * Some file types can be both binary or text. This function is constant and returns \true
	 * if the file type this class deals with <i>can be</i>, but is not limited to a binary
	 * type.
	 * 
	 * @return \true if the file type this class handles (regardless of the file it is actually
	 *         handling) is allowed to be binary.
	 */
	public function isBinary();
	
	/**
	 * @brief Prepare the output write file.
	 * 
	 * The prepareWriteFile() method only applies to class that are noncaching. prepareWriteFile() will
	 * create the file to then wait for one or more add() to be issued and the data immediatly purged
	 * to the output file.
	 * 
	 * @param $uri A valid PHP URL, relative or absolute path.
	 * @param $a Extra optional options.
	 * @see finishWriteFile()
	 */
	public function prepareWriteFile($uri, $a = false);
	
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
	public function finishWriteFile();
	
	/**
	 * @brief Return \true if this file parser instance is caching.
	 * 
	 * @return \true or \false for on and off respectivly.
	 * @see setCache()
	 */
	public function isCaching();
	
	/**
	 * @brief Turn on/off the caching for this parse.
	 * 
	 * @param $mode \true or \false for on and off respectivly.
	 * @see isCaching()
	 */
	public function setCache($mode = true);
	
}

?>
