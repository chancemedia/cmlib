<?php

include_once("CMQueryProtocol.php");
include_once("CMBetaClass.php");

/**
 * @brief PostgreSQL query handle.
 * 
 * @author Elliot Chance
 */
class CMPostgreSQLQuery implements CMQueryProtocol {
	
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
	 * @brief Internal query handle.
	 */
	private $query = false;
	
	/**
	 * @brief Attributes passed down through the database protocol.
	 */
	private $a = array();
	
	/**
	 * @brief Constructor is for internal use.
	 * 
	 * The constructor is only used by the database handle object to create the query object.
	 * This should not be manually executed.
	 * 
	 * @param $q
	 * @param $a
	 */ 
	public function CMPostgreSQLQuery($q, $a = array()) {
		$this->query = $q;
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
			
		if(!$this->query)
			return false;
		
		if($rowMode == 'assoc')
			$r = pg_fetch_assoc($this->query);
		elseif($rowMode == 'line')
			$r = pg_fetch_row($this->query);
		elseif($rowMode == 'row')
			$r = pg_fetch_array($this->query, NULL, PGSQL_BOTH);
		elseif($rowMode == 'pair') {
			$r = pg_fetch_row($this->query);
			if(!$r) return false;
			$r = array($r[0] => $r[1]);
		} elseif($rowMode == 'cell') {
			$r = pg_fetch_row($this->query);
			if(!$r) return false;
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
	 * @param $direction Fetching direction.
	 * @param $formatter Applies a formatting option to all of the cells in the result set.
	 * @see fetch()
	 */
	public function fetchAll($rowMode = 'assoc', $direction = 'horizontal', $formatter = false) {
		if(!$this->query)
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
		return array('availableMethods', 'affectedRows', 'fetch', 'fetchAll', 'totalRows');
	}
	
	/**
	 * @brief Returns the number of affected rows in this query.
	 * 
	 * If this query did not affect any rows 0 is returned.
	 * 
	 * @return The number of rows affected by this query.
	 */
	public function affectedRows() {
		return pg_affected_rows($this->query);
	}
	
	/**
	 * @brief Total number of rows in the result set.
	 * 
	 * If the query failed then 0 is returned.
	 * 
	 * @return The number of rows in the result set.
	 */
	public function totalRows() {
		return pg_num_rows($this->query);
	}
	
	/**
	 * @brief Check if this query was successful.
	 * 
	 * @return \true or \false.
	 */
	public function success() {
		return $this->query !== false;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
