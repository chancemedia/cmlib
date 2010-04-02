<?php

include_once("CMQueryProtocol.php");

/**
 * @brief MySQL query handle.
 * 
 * To make the results from different databases compatible with the same set of generic
 * methods all databases that return a database query return it in a class that fits to
 * this protocol. This is for MySQL.
 * 
 * @author Elliot Chance
 */
class CMMySQLQuery implements CMQueryProtocol {
	
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
	 * @brief Internal use.
	 * 
	 * @see affectedRows()
	 */
	private $affectedRows = 0;
	
	/**
	 * @brief Internal result handle.
	 */
	private $result = false;
	
	/**
	 * @brief The driver determines the PHP functions to call.
	 * 
	 * See "MySQL vs MySQLi" in CMMySQL.
	 */
	private $driver = 'mysqli';
	
	/**
	 * @brief Attributes passed down through the database protocol.
	 */
	private $a = array();
	
	/**
	 * @brief The constructor is not used for anything. This object is created from CMMySQL.
	 * 
	 * @param $r
	 * @param $affected
	 * @param $driver
	 * @param $a
	 */
	public function CMMySQLQuery($r, $affected = 0, $driver = 'mysqli', $a = array()) {
		$this->result = $r;
		$this->affectedRows = $affected;
		$this->driver = $driver;
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
			
		if($this->driver == 'mysqli') {
			
			if($rowMode == 'assoc')
				$r = $this->result->fetch_assoc();
			elseif($rowMode == 'line')
				$r = $this->result->fetch_row();
			elseif($rowMode == 'pair') {
				$r = $this->result->fetch_row();
				if(!$r) return false;
				$r = array($r[0] => $r[1]);
			} elseif($rowMode == 'cell') {
				$r = $this->result->fetch_row();
				if(!$r) return false;
				$r = $r[0];
			} else $r = false;
			
		} else {
		
			if($rowMode == 'assoc')
				$r = mysql_fetch_assoc($this->result);
			elseif($rowMode == 'line')
				$r = mysql_fetch_array($this->result);
			elseif($rowMode == 'pair') {
				$r = mysql_fetch_array($this->result);
				if(!$r) return false;
				$r = array($r[0] => $r[1]);
			} elseif($rowMode == 'cell') {
				$r = mysql_fetch_array($this->result);
				if(!$r) return false;
				$r = $r[0];
			} else $r = false;
			
		}
		
		// apply formatter
		if($formatter !== false)
			$r = $formatter->format($r);
		
		return $r;
	}
	
	/**
	 * @brief Fetch all rows.
	 * 
	 * <tt>$direction</tt>
	 * <table border>
	 * 	<tr>
	 * 		<td><tt>'horizontal'</tt></td>
	 * 		<td>Each row is a new array. This is the default</td>
	 * 	</tr>
	 * 	<tr>
	 * 		<td><tt>'vertical'</tt></td>
	 * 		<td>All the rows are appended in a single linear array.</td>
	 * 	</tr>
	 * 	<tr>
	 * 		<td><tt>'single'</tt></td>
	 * 		<td>Only use the first row.</td>
	 * 	</tr>
	 * </table>
	 * 
	 * @param $rowMode How each row is converted into an array.
	 * @param $direction The fetching direction.
	 * @param $formatter See \ref cmqueryprotocol_formatter
	 * @see fetch()
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
	 * @brief Class methods this query supports.
	 * 
	 * @code
	 * $q = $dbh->query("select * from mytable");
	 * $features = $q->availableMethods();
	 * if(!in_array($features, 'next'))
	 *   die("We can't read the result!");
	 * @endcode
	 */
	public function availableMethods() {
		return array('fetch', 'fetchAll', 'affectedRows', 'totalRows');
	}
	
	/**
	 * @brief Returns the number of affected rows in this query.
	 */
	public function affectedRows() {
		return $this->affectedRows;
	}
	
	/**
	 * @brief Total number of rows in the result set.
	 * 
	 * If the query failed then 0 is returned.
	 * 
	 * @return The number of rows in the result set.
	 */
	public function totalRows() {
		if($this->driver == 'mysqli')
			return $this->result->num_rows;
		return mysql_num_rows($this->result);
	}
	
	/**
	 * @brief Check if this query handle was successful.
	 */
	public function success() {
		return $this->result !== false;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
