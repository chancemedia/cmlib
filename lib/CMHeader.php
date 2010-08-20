<?php

include_once('CMClass.php');

/**
 * @brief Controlling HTTP headers and how the browser controls downloading of files.
 * 
 * @author Elliot Chance
 */
class CMHeader implements CMClass {
	
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
	 * @brief Redirect the browser to a new location.
	 * 
	 * This method allows you to put in wild cards that are filled in safely from the \p $values
	 * parameter. For example:
	 * @code
	 * CMHeader::Location("index.php?id=^&name=^", array(12, "Bob Smith"));
	 * @endcode
	 * Will generate and redirect to:
	 * <pre>
	 * index.php?id=12&name=Bob+Smith
	 * </pre>
	 * 
	 * @note The substituted values will be escaped with urlencode(). If any passed value are of type
	 *       CMConstant they will not be escaped.
	 * 
	 * @param $url New location.
	 * @param $values Substitute URL values.
	 * @return Nothing.
	 */
	public static function Location($url, $values = array()) {
		// substitute values
		if(is_array($values)) {
			$parts = explode('^', $url);
			$new_url = "";
			for($i = 0; $i < count($parts) - 1; ++$i) {
				// if its a CMConstant we don't encapsulate it
				if($values[$i] instanceof CMConstant)
					$new_url .= $parts[$i] . $values[$i];
				else
					$new_url .= $parts[$i] . "'" . urlencode($values[$i]) . "'";
			}
			$url = $new_url . $parts[count($parts) - 1];
		} elseif($values !== false) {
			// if its a CMConstant we don't encapsulate it
			if($values instanceof CMConstant)
				$url = str_replace('?', $values, $url);
			else
				$url = str_replace('?', "'" . urlencode($values) . "'", $url);
		}
		
		// change header to notify the browser to redirect
		header("Location: $url");
		exit(0);
	}
	
	/**
	 * @brief Notify the browser this page is an attachment.
	 * 
	 * @param $name The name of the file.
	 * @param $type The content type. By default this is <tt>text/plain</tt>.
	 * @return Always \true.
	 */
	public static function SaveAsFile($name, $type = "text/plain") {
		header("Content-type: $type");
		header("Content-Disposition: attachment; filename=\"$name\"");
		return true;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
