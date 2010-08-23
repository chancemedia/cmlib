<?php

include_once("CMDatabaseProtocol.php");
include_once("CMOracleQuery.php");
include_once("CMConstant.php");
include_once("CMError.php");

if(!function_exists("oci_parse")) {
	function oci_parse($a) {
		return false;
	}
}

if(!function_exists("oci_execute")) {
	function oci_execute($a) {
		return false;
	}
}

if(!function_exists("oci_connect")) {
	function oci_connect($a) {
		return false;
	}
}

if(!function_exists("oci_error")) {
	function oci_error($a) {
		return false;
	}
}

if(!function_exists("oci_commit")) {
	function oci_commit($a) {
		return false;
	}
}

if(!function_exists("oci_rollback")) {
	function oci_rollback($a) {
		return false;
	}
}

if(!function_exists("oci_close")) {
	function oci_close($a) {
		return false;
	}
}


/**
 * @brief Oracle Database connectivity.
 * 
 * @note Oracle (OCI8) requires the oci8 pecl extension to be installed. You can do this by
 * running:
 * @code
 * pecl install oci8
 * @endcode
 * 
 * 
 * @section cmoracle_native Native Mapping
 * <table>
 *   <tr>
 *     <th>PHP Function</th>
 *     <th>CMLIB Method</th>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_bind_array_by_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_bind_by_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_cancel</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_close</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Collection->append</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Collection->assign</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Collection->assignElem</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Collection->free</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Collection->getElem</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Collection->max</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Collection->size</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Collection->trim</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_commit</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_connect</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_define_by_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_error</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_execute</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_fetch_all</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_fetch_array</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_fetch_assoc</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_fetch_object</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_fetch_row</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_fetch</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_field_is_null</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_field_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_field_precision</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_field_scale</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_field_size</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_field_type_raw</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_field_type</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_free_statement</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_internal_debug</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->append</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->close</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_lob_copy</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->eof</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->erase</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->export</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->flush</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->free</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->getBuffering</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->import</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_lob_is_equal</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->load</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->read</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->rewind</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->save</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->saveFile</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->seek</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->setBuffering</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->size</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->tell</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->truncate</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->write</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->writeTemporary</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>OCI-Lob->writeToFile</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_new_collection</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_new_connect</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_new_cursor</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_new_descriptor</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_num_fields</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_num_rows</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_parse</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_password_change</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_pconnect</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_rollback</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_server_version</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_set_action</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_set_client_identifier</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_set_client_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_set_edition</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_set_module_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_set_prefetch</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>oci_statement_type</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 * </table>
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMOracle extends CMError implements CMDatabaseProtocol {
	
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
	 * @brief Internal auto commit flag.
	 * 
	 * @see setAutoCommit()
	 * @see commit()
	 * @see rollback()
	 */
	private $autoCommit = true;
	
	/**
	 * @brief Internal database handle.
	 */
	private $dbh = false;
	
	/**
	 * @brief Connect to a database.
	 *
	 * @note This connection method only supports Oracle SID authentication.
	 * 
	 * Database connections are made with a URI in the form of;
	 * @code
	 * oracle://<user>:<pass>@<location>/<sid>
	 * @endcode
	 * @code
	 * $dbh = new CMOracle("oracle://scott:tiger@localhost/orcl");
	 * @endcode
	 * 
	 * @throwsError If the schema is invalid. Only \c 'oracle' is supported.
	 * 
	 * @throwsError If the connection was unsuccessful.
	 * 
	 * @param $uri Connection URI.
	 * @param $a An associative array of server options when connecting.
	 * <table border>
	 * 	<tr>
	 * 		<th>Name</th>
	 * 		<th>Required</th>
	 * 		<th>Description</th>
	 * 	</tr>
	 * 	<tr>
	 * 		<td>\c ORACLE_HOME</td>
	 * 		<td>No</td>
	 * 		<td>The location of the Oracle Database home. If you do not provide this value
	 * 		it will be taken from the Apache which much be set up manually.</td>
	 * 	</tr>
	 * 	<tr>
	 * 		<td>\c LD_LIBRARY_PATH</td>
	 * 		<td>No</td>
	 * 		<td>The location of the Oracle Database library include path. If you do not set
	 * 		this, the value will be <tt>$ORACLE_HOME/lib</tt></td>
	 * 	</tr>
	 * </table>
	 */
	public function CMOracle($uri, $a = false) {
		// dissect the URI
		$v = parse_url($uri);
		$v['db'] = basename($v['path']);
		
		// make sure the scheme is valid
		if($v['scheme'] != 'oracle') {
			$this->throwError("Unsupported driver '{$v['scheme']}'");
			return $this;
		}
		
		// server options
		if(!isset($a['LD_LIBRARY_PATH']))
			$a['LD_LIBRARY_PATH'] = "$a[ORACLE_HOME]/lib";

		// environment variables
		if(isset($v['db']))
			PutEnv("ORACLE_SID=$v[db]");
		if(isset($a['ORACLE_HOME']))
			PutEnv("ORACLE_HOME=$a[ORACLE_HOME]");
		if(isset($a['LD_LIBRARY_PATH']))
			PutEnv("LD_LIBRARY_PATH=$a[LD_LIBRARY_PATH]");
		
		// attempt to connect
		$this->dbh = oci_connect($v['user'], $v['pass'], $v['host'] . '/' . $v['db']);
		if(!$this->dbh) {
			$this->throwError(oci_error());
			return $this;
		}
	}
	
	/**
	 * @brief Perform a query on the database that returns a handle to iterate the results.
	 * 
	 * For actions that do not require a result use execute().
	 * 
	 * @throwsWarning If the query was unable to be executed.
	 * 
	 * @param $sql SQL.
	 * @param $values An array of values to bind to $sql.
	 * @param $a An associative array of server options for the query.
	 * @return New CMOracleQuery object regardless of success or failure.
	 * @see execute()
	 */
	public function query($sql, $values = false, $a = false) {
		$sql = $this->bindValues($sql, $values);
		
		if($a !== false && in_array('print', $a))
			echo $sql;
		
		$stid = oci_parse($this->dbh, $sql);
		$success = false;
		if($this->autoCommit)
			$success = oci_execute($stid);
		else $success = oci_execute($stid, OCI_NO_AUTO_COMMIT);
		
		if(!$success)
			$this->throwWarning("Query failed", array('sql' => $sql));
		
		return new CMOracleQuery($stid, $a);
	}
	
	/**
	 * @brief Perform a query on the database that does not return a handle.
	 * 
	 * For actions that do require a result use query().
	 * 
	 * @param $sql SQL
	 * @param $values The array of values to bind to $sql.
	 * @param $a An associative array of server options for the query.
	 * @return \true or \false.
	 * @see query()
	 */
	public function execute($sql, $values = false, $a = false) {
		$q = $this->query($sql, $values, $a);
		return $q->success();
	}
	
	/**
	 * @brief Use internally by query() and insert() for substituting values.
	 * 
	 * @code
	 * select * from mytable where id=? and name=?
	 * @endcode
	 * to
	 * @code
	 * select * from mytable where id='3' and name='Bob'
	 * @endcode
	 * 
	 * @param $sql SQL
	 * @param $values The values to bind.
	 * @return New bound string.
	 */
	public function bindValues($sql, $values = false) {
		if(is_array($values)) {
			$parts = explode('?', $sql);
			$new_sql = "";
			for($i = 0; $i < count($parts) - 1; ++$i) {
				// if its a CMConstant we don't encapsulate it
				if($values[$i] instanceof CMConstant)
					$new_sql .= $parts[$i] . $values[$i];
				else
					$new_sql .= $parts[$i] . "'" . str_replace("'", "''", $values[$i]) . "'";
			}
			$sql = $new_sql . $parts[count($parts) - 1];
		} elseif($values !== false) {
			// if its a CMConstant we don't encapsulate it
			if($values instanceof CMConstant)
				$sql = str_replace('?', $values, $sql);
			else
				$sql = str_replace('?', "'" . str_replace("'", "''", $values) . "'", $sql);
		}
			
		return $sql;
	}
	
	/**
	 * @brief \c INSERT statement
	 * 
	 * @warning Unlink the other protocols, this function will only return the success of the query
	 *          and not the newly created key.
	 * 
	 * This uses a key-value paired array to construct an \c INSERT statement like:
	 * 
	 * @code
	 * $dbh->insert('mytable', array('a' => 'Something', 'b' => 123.45));
	 * @endcode
	 * 
	 * Will produce and execute the following SQL:
	 * @code
	 * insert into mytable (a, b) values ('Something', '123.45')
	 * @endcode
	 * 
	 * @throwsWarning If the query failed. 'sql' attribute contains the original SQL.
	 * 
	 * @param $name The name of the table.
	 * @param $kv Associative array of fields and data.
	 * @param $a Extra options.
	 */
	public function insert($name, $kv = false, $a = false) {
		$sql = "insert into $name (" . implode(',', array_keys($kv)) . ") values (";
		$first = true;
		foreach($kv as $k => $v) {
			if(!$first)
				$sql .= ",";
			
			// if its a CMConstant we don't encapsulate it
			if($v instanceof CMConstant)
				$sql .= $v;
			else
				$sql .= "'" . str_replace("'", "''", $v) . "'";
				
			$first = false;
		}
		
		$success = $this->query("$sql)")->success();
		if(!$success)
			$this->throwWarning("Query failed", array('sql' => "$sql)"));
		
		return $success;
	}
	
	/**
	 * @brief Fetch the list of tables in the active database.
	 * 
	 * @notimp
	 * 
	 * @param $schema Schema name.
	 * @return Always \false.
	 */
	public function getTableNames($schema = false) {
		return false;
	}
	
	/**
	 * @brief Returns true or false for the selected database.
	 * 
	 * @notimp
	 * 
	 * @param $table The name of the table.
	 * @return Always \false.
	 */
	public function tableExists($table) {
		return false;
	}
	
	/**
	 * @brief Not supported.
	 * 
	 * @notimp
	 * 
	 * @return Always \false.
	 */
	public function getDatabaseNames() {
		return false;
	}

	/**
	 * @brief Not supported.
	 * 
	 * @notimp
	 * 
	 * @return Always \false.
	 */
	public function getSchemaNames() {
		return false;
	}
	
	/**
	 * @brief Class methods available to this query handle.
	 * 
	 * @code
	 * $features = $dbh->availableMethods();
	 * if(in_array($features, 'getDatabaseTables'))
	 *   $tables = $dbh->getDatabaseTables();
	 * else echo "Uh-oh, getDatabaseTables() has not been implemented for {$dbh->engine()}";
	 * @endcode
	 * 
	 * @return An array of available methods.
	 */
	public function availableMethods() {
		return array('commit', 'delete', 'disconnect', 'engine', 'eraseTable', 'escapeString',
					 'execute', 'getDatabaseNames', 'getSchemaNames', 'getTableNames', 'insert',
					 'isConnected', 'query', 'rollback', 'setAutoCommit', 'tableExists',
					 'truncateTable', 'update', 'getAutoCommit');
	}
	
	/**
	 * @brief Check if the database connection is still active.
	 * 
	 * @return \true or \false.
	 */
	public function isConnected() {
		return $this->dbh !== false;
	}
	
	/**
	 * @brief Disconnect database handle.
	 * 
	 * @return \true.
	 */
	public function disconnect() {
		if($this->dbh !== false)
			oci_close($this->dbh);
		return true;
	}
	
	/**
	 * @brief The name of the database product.
	 * 
	 * @return "Oracle"
	 */
	public function engine() {
		return "Oracle";
	}
	
	/**
	 * @brief COMMIT transaction.
	 * 
	 * @note This function is only relevant if you use setAutoCommit(false) before running any statements.
	 * 
	 * @return \true if the transaction committed successfully, otherwise \false.
	 * @see rollback()
	 * @see setAutoCommit()
	 */
	public function commit() {
		if($this->dbh === false)
			return false;
		return oci_commit($this->dbh);
	}

	/**
	 * @brief ROLLBACK transaction.
	 * 
	 * @note This function is only relevant if you use setAutoCommit(false) before running any statements.
	 * 
	 * @return \true if the transaction rolled back successfully, otherwise \false.
	 * @see commit()
	 * @see setAutoCommit()
	 */
	public function rollback() {
		if($this->dbh === false)
			return false;
		return oci_rollback($this->dbh);
	}

	/**
	 * @brief Turn autocommit on/off
	 * 
	 * By default this is off. When turning off auto commit you will have to manually commit the transaction
	 * with commit() or undo with rollback()
	 * 
	 * @param $mode \true or \false.
	 * @return Always \true.
	 * @see commit()
	 * @see rollback()
	 */
	public function setAutoCommit($mode = false) {
		$this->autoCommit = $mode;
		return true;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
	/**
	 * @brief Erase (not truncate) a table.
	 * 
	 * Erasing a table removes all the entries of the table by deleteing each row. It is
	 * effectivly:
	 * @code
	 * DELETE FROM $tableName WHERE 1;
	 * @endcode
	 * 
	 * This has a higher overhead than truncateTable() because it requires space in the UNDO log.
	 * 
	 * @param $tableName The name of the table.
	 * @return \true for success, otherwise \false (such as if the table doesn't exist or you do not have
	 *         adequate privileges.)
	 * @see truncateTable()
	 */
	public function eraseTable($tableName) {
		// need a valid database handle
		if($this->dbh === false)
			return false;
		
		$q = $this->query("DELETE FROM $tableName WHERE 1");
		return $q->success();
	}
	
	/**
	 * @brief TRUNCATE table.
	 * 
	 * truncateTable() uses the TRUNCATE statement with the default Oracle settings. It is effectivly:
	 * @code
	 * TRUNCATE $tableName;
	 * @endcode
	 * 
	 * @param $tableName The name of the table.
	 * @return \true for success, otherwise \false (such as if the table doesn't exist or you do not have
	 *         adequate privileges.)
	 */
	public function truncateTable($tableName) {
		// need a valid database handle
		if($this->dbh === false)
			return false;
		
		$q = $this->query("TRUNCATE TABLE $tableName");
		return $q->success();
	}
	
	/**
	 * @brief \c UPDATE statement.
	 * 
	 * See CMDatabaseProtocol::update().
	 * 
	 * @param $tableName
	 * @param $newvalues
	 * @param $criteria
	 * @param $a
	 */
	public function update($tableName, $newvalues, $criteria = false, $a = false) {
		// $a must be an array
		if(!is_array($a))
			$a = array();
		
		$sql = "UPDATE `$tableName` SET ";
		$first = true;
		foreach($newvalues as $k => $v) {
			if(!$first) $sql .= ",";
			
			// if its a CMConstant we don't encapsulate it
			if($v instanceof CMConstant)
				$sql .= "$k=$v";
			else
				$sql .= "$k='" . str_replace("'", "''", $v) . "'";
			
			$first = false;
		}
		
		// add WHERE clause
		if($criteria !== false) {
			$sql .= " WHERE ";
			$first = true;
			foreach($criteria as $k => $v) {
				if(!$first) $sql .= " AND ";
				
				// if its a CMConstant we don't encapsulate it
				if($v instanceof CMConstant)
					$sql .= "$k=$v";
				else
					$sql .= "$k='" . str_replace("'", "''", $v) . "'";
				
				$first = false;
			}
		}
		
		if(isset($a['print']))
			echo $sql;
		
		$q = $this->query($sql, false, $a);
		if($q->success())
			return $q->affectedRows();
		return false;
	}
	
	/**
	 * @brief \c DELETE statement.
	 * 
	 * See CMDatabaseProtocol::delete().
	 * 
	 * @param $tableName
	 * @param $criteria
	 * @param $a
	 */
	public function delete($tableName, $criteria = false, $a = false) {
		// $a must be an array
		if(!is_array($a))
			$a = array();
		
		$sql = "DELETE FROM `$tableName`";
		
		// add WHERE clause
		if($criteria !== false) {
			$sql .= " WHERE ";
			$first = true;
			foreach($criteria as $k => $v) {
				if(!$first) $sql .= " AND ";
				
				// if its a CMConstant we don't encapsulate it
				if($v instanceof CMConstant)
					$sql .= "$k=$v";
				else
					$sql .= "$k='" . str_replace("'", "''", $v) . "'";
				
				$first = false;
			}
		}
		
		if(isset($a['print']))
			echo $sql;
		
		$q = $this->query($sql, false, $a);
		if($q->success())
			return $q->affectedRows();
		return false;
	}
	
	/**
	 * @brief Escape a string based on the correct rules of the database engine.
	 * 
	 * @param $str The value to be escaped.
	 * @return Escaped string that does not include surrounding quotes.
	 */
	public function escapeString($str) {
		return str_replace("'", "''", $str); 
	}
	
	/**
	 * @brief Return the auto commit status.
	 * 
	 * @return \true or \false.
	 * @see setAutoCommit()
	 */
	public function getAutoCommit() {
		return $this->autoCommit;
	}
	
	/**
	 * @brief Escape an entity based on the correct rules of the database engine.
	 *
	 * An entity is a table name, view name, column name, etc. Most databases require a different quote
	 * encapsulation than escapeString().
	 * 
	 * @param $str The value to be escaped.
	 * @return Escaped entity which includes and quotes or encapsulation.
	 */
	public function escapeEntity($str) {
		return $str;
	}
	
	/**
	 * @brief Describe a table.
	 * @notimp
	 * @param $tableName The name of the table.
	 * @param $a Extra attributes. Ignored.
	 */
	public function describeTable($tableName, $a = array()) {
		return false;
	}

}

?>
