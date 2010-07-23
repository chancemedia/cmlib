<?php

include_once('CMClass.php');

interface CMFile extends CMClass {
	
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
	 * @brief Multirecord file type.
	 */
	public function isMultiRecord();
	
}

?>
