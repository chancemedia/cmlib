<?php

include_once("CMQueryProtocol.php");
include_once("CMBetaClass.php");

if(!function_exists("oci_fetch_assoc")) {
	function oci_fetch_assoc($a) {
		return false;
	}
}

if(!function_exists("oci_fetch_row")) {
	function oci_fetch_row($a) {
		return false;
	}
}

if(!function_exists("oci_fetch_array")) {
	function oci_fetch_array($a, $b) {
		return false;
	}
}

/**
 * @brief Oracle database query handler.
 * 
 * @author Elliot Chance
 */
class CMOracleQuery implements CMQueryProtocol {
	
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
	 * @brief Internal result handle.
	 */
	private $result = false;
	
	/**
	 * @brief Attributes passed down through the database protocol.
	 */
	private $a = array();
	
	/**
	 * @brief Check if this query was successful.
	 */
	public function success() {
		return $this->result !== false;
	}
	
	/**
	 * @brief The constructor is not used for anything.
	 *
	 * @param $result
	 * @param $a
	 */
	public function CMOracleQuery($result, $a = array()) {
		$this->result = $result;
		$this->a = $a;
	}
	
	/**
	 * @brief Return the next result row from the query as an associative array.
	 * 
	 * Once all the rows in the result set have been interated <tt>false</tt> is returned.
	 * @code
	 * $q = $dbh->query("select * from mytable");
	 * while($r = $q->next()) {
	 * 	print_r($r);
	 * }
	 * @endcode
	 * 
	 * @param $rowMode How each row is converted into an array.
	 * <table border>
	 * 	<tr>
	 * 		<td><tt>'assoc'</tt></td>
	 * 		<td>Associative array. This is the default</td>
	 * 	</tr>
	 * 	<tr>
	 * 		<td><tt>'line'</tt></td>
	 * 		<td>Non-associative array.</td>
	 * 	</tr>
	 * 	<tr>
	 * 		<td><tt>'pair'</tt></td>
	 * 		<td>First and second column become key-value.</td>
	 * 	</tr>
	 * 	<tr>
	 * 		<td><tt>'cell'</tt></td>
	 * 		<td>Only use the first column.</td>
	 * 	</tr>
	 * </table>
	 * @param $formatter See \ref cmqueryprotocol_formatter
	 */
	public function fetch($rowMode = 'assoc', $formatter = false) {
		if(isset($this->a['formatter']) && $formatter === false)
			$formatter = $this->a['formatter'];
			
		if(!$this->result)
			return false;
		
		if($rowMode == 'assoc')
			$r = oci_fetch_assoc($this->result);
		elseif($rowMode == 'line')
			$r = oci_fetch_row($this->result);
		elseif($rowMode == 'row')
			$r = oci_fetch_array($this->result, OCI_BOTH);
		elseif($rowMode == 'pair') {
			$r = oci_fetch_row($this->result);
			$r = array($r[0], $r[1]);
		} elseif($rowMode == 'cell') {
			$r = oci_fetch_row($this->result);
			$r = $r[0];
		} else $r = false;
		
		// apply formatter
		if($formatter !== false)
			$r = $formatter->format($r);
		
		return $r;
	}
	
	/**
	 * @brief Fetch all rows.
	 * 
	 * @param $rowMode How each row is converted into an array.
	 * @param $direction The fetching direction.
	 * @param $formatter Applies a formatting option to all of the cells in the result set.
	 * @see fetch().
	 */
	public function fetchAll($rowMode = 'assoc', $direction = 'horizontal', $formatter = false) {
		if(!$this->result)
			return false;
		$r = array();
		
		if($direction == 'single')
			return $this->fetch($rowMode, $formatter);
		
		while($row = $this->fetch($rowMode, $formatter)) {
			if($direction == 'horizontal')
				$r[] = $row;
			elseif($direction == 'vertical') {
				if(is_array($row)) {
					foreach($row as $k => $v)
						$r[] = $v;
				} else $r[] = $row;
			} else return false;
		}
		
		return $r;
	}
	
	/**
	 * @brief Get available methods.
	 * 
	 * This method works in the same way availableMethods() for CMDatabaseProtocol works.
	 * 
	 * @code
	 * $q = $dbh->query("select * from mytable");
	 * $features = $q->availableMethods();
	 * if(!in_array($features, 'fetch'))
	 *   die("We can't read the result!");
	 * @endcode
	 * 
	 * @return An array of method names.
	 */
	public function availableMethods() {
		return array();
	}
	
	/**
	 * @brief Returns the number of affected rows in this query.
	 * 
	 * If this query did not affect any rows 0 is returned.
	 * 
	 * @return The number of rows affected by this query.
	 */
	public function affectedRows() {
		return 0;
	}
	
	/**
	 * @brief Total number of rows in the result set.
	 * 
	 * If the query failed then 0 is returned.
	 * 
	 * @return The number of rows in the result set.
	 */
	public function totalRows() {
		return 0;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
