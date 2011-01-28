<?php

include_once("CMDatabaseProtocol.php");
include_once("CMPostgreSQLQuery.php");
include_once("CMConstant.php");
include_once("CMError.php");
include_once("CMDecimal.php");

/**
 * @brief PostgreSQL connectivity class.
 * 
 * @section cmpostgresql_native Native Mapping
 * <table>
 *   <tr>
 *     <th>PHP Function</th>
 *     <th>CMLIB Method</th>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_affected_rows</tt></td>
 *     <td>\c CMPostgreSQLQuery::affectedRows()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_cancel_query</tt></td>
 *     <td>(not available, part of the async library)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_client_encoding</tt></td>
 *     <td>\c CMPostgreSQL::getClientEncoding()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_close</tt></td>
 *     <td>\c CMPostgreSQL::disconnect()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_connect</tt></td>
 *     <td>\c CMPostgreSQL::CMPostgreSQL()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_connection_busy</tt></td>
 *     <td>(not available, part of the async library)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_connection_reset</tt></td>
 *     <td>\c CMPostgreSQL::reconnect()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_connection_status</tt></td>
 *     <td>\c CMPostgreSQL::isConnected()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_convert</tt></td>
 *     <td>Automatically done when binding stataments.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_copy_from</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_copy_to</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_dbname</tt></td>
 *     <td>\c CMPostgreSQL::getDatabaseName()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_delete</tt></td>
 *     <td>\c CMPostgreSQL::delete()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_end_copy</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_escape_bytea</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_escape_string</tt></td>
 *     <td>Automatically done when binding stataments.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_execute</tt></td>
 *     <td>\c CMPostgreSQL::execute()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_fetch_all_columns</tt></td>
 *     <td>\c CMPostgreSQLQuery::fetch()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_fetch_all</tt></td>
 *     <td>\c CMPostgreSQLQuery::fetchAll()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_fetch_array</tt></td>
 *     <td>\c CMPostgreSQLQuery::fetch()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_fetch_assoc</tt></td>
 *     <td>\c CMPostgreSQLQuery::fetch()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_fetch_object</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_fetch_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_fetch_row</tt></td>
 *     <td>\c CMPostgreSQLQuery::fetch()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_field_is_null</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_field_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_field_num</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_field_prtlen</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_field_size</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_field_table</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_field_type_oid</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_field_type</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_free_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_get_notify</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_get_pid</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_get_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_host</tt></td>
 *     <td>\c CMPostgreSQL::getHost()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_insert</tt></td>
 *     <td>\c CMPostgreSQL::insert()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_last_error</tt></td>
 *     <td>Taken care of by \c CMPostgreSQL::errors()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_last_notice</tt></td>
 *     <td>Taken care of by \c CMPostgreSQL::errors()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_last_oid</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_close</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_create</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_export</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_import</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_open</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_read_all</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_read</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_seek</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_tell</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_unlink</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_lo_write</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_meta_data</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_num_fields</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_num_rows</tt></td>
 *     <td>\c CMPostgreSQLQuery::totalRows()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_options</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_parameter_status</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_pconnect</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_ping</tt></td>
 *     <td>\c CMPostgreSQL::ping()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_port</tt></td>
 *     <td>\c CMPostgreSQL::getPort()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_prepare</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_put_line</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_query_params</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_query</tt></td>
 *     <td>\c CMPostgreSQL::query()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_result_error_field</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_result_error</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_result_seek</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_result_status</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_select</tt></td>
 *     <td>Use \c CMPostgreSQL::query() instead.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_send_execute</tt></td>
 *     <td>(not available, part of async)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_send_prepare</tt></td>
 *     <td>(not available, part of async)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_send_query_params</tt></td>
 *     <td>(not available, part of async)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_send_query</tt></td>
 *     <td>(not available, part of async)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_set_client_encoding</tt></td>
 *     <td>\c CMPostgreSQL::setClientEncoding()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_set_error_verbosity</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_trace</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_transaction_status</tt></td>
 *     <td>(not available, part of async)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_tty</tt></td>
 *     <td>\c CMPostgreSQL::getTTY()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_unescape_bytea</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_untrace</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_update</tt></td>
 *     <td>\c CMPostgreSQL::update()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pg_version</tt></td>
 *     <td>\c CMPostgreSQL::getClientVersion(), \c CMPostgreSQL::getServerVersion(),
 *         \c CMPostgreSQL::getProtocolVersion()</td>
 *   </tr>
 * </table>
 * 
 * @author Elliot Chance
 */
class CMPostgreSQL extends CMError implements CMDatabaseProtocol {
	
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
	 * @brief Connect to a PostgreSQL database.
	 * 
	 * Database connections are made with a URI in the child class constructor like;
	 * @code
	 * $dbh = new CMPostgreSQL("postgresql://root:password@localhost/db");
	 * $dbh = new CMPostgreSQL("postgres://root:password@localhost/db");
	 * @endcode
	 * 
	 * @throwsWarning If the connection could not be made.
	 * 
	 * @param $uri Connection URI.
	 * @param $a An associative array of server options when connecting.
	 */
	public function CMPostgreSQL($uri, $a = false) {
		// dissect the URI
		$v = parse_url($uri);
		$v['db'] = basename($v['path']);
		
		// make sure the scheme is valid
		if($v['scheme'] != 'postgres' && $v['scheme'] != 'postgresql') {
			$this->throwError("Unsupported driver '{$v['scheme']}'");
			return $this;
		}
		
		// suppress isset warnings and set defaults
		if(!isset($v['host']) || $v['host'] == 'localhost')
			$v['host'] = '';
		if(!isset($v['port']))
			$v['port'] = 5432;
		if(!isset($v['db']))
			$v['db'] = '';
		if(!isset($v['user']))
			$v['user'] = '';
		if(!isset($v['pass']))
			$v['pass'] = '';
		
		// attempt to connect
		$connect_string = "host='{$v['host']}' port='{$v['port']}' dbname='{$v['db']}' user='{$v['user']}' password='{$v['pass']}'";
		$this->dbh = @pg_connect($connect_string);
		if(!$this->dbh) {
			$this->throwError("Could not connect to database.");
			return $this;
		}
	}
	
	/**
	 * @brief Perform a query on the database that returns a handle to iterate the results.
	 * 
	 * For actions that do not require a result use execute().
	 * 
	 * @throwsWarning If the query failed. 'sql' attribute contains the original SQL.
	 * 
	 * @param $sql SQL
	 * @param $values An array of values to bind to <tt>$sql</tt>.
	 * @param $a An associative array of server options for the query.
	 */
	public function query($sql, $values = false, $a = false) {
		// $a must be an array
		if(!is_array($a))
			$a = array($a => true);
			
		$sql = $this->bindValues($sql, $values, $a);
		
		if(isset($a['print']))
			echo "$sql\n";
		
		$q = @pg_query($this->dbh, $sql);
		if(!$q)
			$this->throwWarning("Query failed", array('sql' => $sql));
		return new CMPostgreSQLQuery($q, $a);
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
	 * @param $values An array of values to bind to <tt>$sql</tt>.
	 * @param $a An associative array of server options for the query.
	 */
	public function bindValues($sql, $values = false, $a = false) {
		if(is_array($values)) {
			$parts = explode('?', $sql);
			$new_sql = "";
			for($i = 0; $i < count($parts) - 1; ++$i) {
				// if its a CMConstant we don't encapsulate it
				if($values[$i] instanceof CMConstant || $values[$i] instanceof CMDecimal)
					$new_sql .= $parts[$i] . ((string) $values[$i]);
				else
					$new_sql .= $parts[$i] . "'" . pg_escape_string($values[$i]) . "'";
			}
			$sql = $new_sql . $parts[count($parts) - 1];
		} elseif($values !== false) {
			// if its a CMConstant we don't encapsulate it
			if($values instanceof CMConstant || $values instanceof CMDecimal)
				$sql = str_replace('?', (string) $values, $sql);
			else
				$sql = str_replace('?', "'" . pg_escape_string($values) . "'", $sql);
		}
			
		return $sql;
	}
	
	/**
	 * @brief Perform a query on the database that does not return a handle.
	 * 
	 * For actions that do require a result use query().
	 * 
	 * @throwsWarning If the query failed. 'sql' attribute contains the original SQL.
	 * 
	 * @param $sql SQL
	 * @param $values An array of values to bind to <tt>$sql</tt>.
	 * @param $a An associative array of server options for the query.
	 * @return \true or \false.
	 */
	public function execute($sql, $values = false, $a = false) {
		$q = $this->query($sql, $values, $a);
		return $q->success();
	}
	
	/**
	 * @brief Cast PostgreSQL safe type.
	 *
	 * PostgreSQL is very strict with its typing, this will make sure the SQL type matches the type PostgreSQL wants.
	 *
	 * @param $value Value to make safe.
	 * @param $col Associative array of column information.
	 * @return Escapes type-safe value.
	 */
	private function castSafeValue($value, $col) {
		// work out the real data type
		$type = $col['data_type'];
		if($type == 'USER-DEFINED')
			$type = $col['udt_name'];
		
		// date and time types to look out for
		if(in_array($type, array('timestamp', 'timestamp with time zone', 'timestamp without time zone')) && trim($value) == '')
			$value = NULL;
		if(in_array($type, array('date', 'time')) && trim($value) == '')
			$value = NULL;
			
		// numerical types
		if(substr($type, 0, 3) == 'int' && trim($value) == '')
			$value = NULL;
			
		// array types
		if($type == 'ARRAY') {
			if(is_array($value))
				return "'{" . implode(",", $value) . "}'";
			else if(@substr($value, 0, 1) == '{')
				// we will assume this is the string form of the array
				return "'$value'";
			
			return NULL;
		}
		
		if($value === NULL)
			return "NULL";
		return "'" . pg_escape_string($value) . "'::" . $type;
	}
	
	/**
	 * @brief \c INSERT statement
	 * 
	 * This uses a key-value paired array to construct an INSERT statement like:
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
		// PostgreSQL is very specific about its types so we cast every value
		$desc = $this->describeTable($name);
		
		$sql = "insert into " . $this->escapeEntity($name) . " (" . implode(',', array_keys($kv));
		$sql .= ") values (";
		$first = true;
		foreach($kv as $k => $v) {
			if(!$first)
				$sql .= ",";
			
			// if its a CMConstant we don't encapsulate it
			if($v instanceof CMConstant || $v instanceof CMDecimal)
				$sql .= $v;
			else
				$sql .= $this->castSafeValue($v, $desc[$k]);
				
			$first = false;
		}
		
		if($this->query("$sql)", false, $a)->success())
			return $this->query("select lastval()", false, $a)->fetch('cell');
		return 0;
	}
	
	/**
	 * @brief Describe a table.
	 * @param $table The name of the table.
	 * @param $a Extra attributes. Ignored.
	 */
	public function describeTable($table, $a = array()) {
		$byid = $this->query("select * from information_schema.columns where table_name=? order by ordinal_position", $table)->fetchAll();
		$byname = array();
		foreach($byid as $v)
			$byname[$v['column_name']] = $v;
		return array_merge($byid, $byname);
	}
	
	/**
	 * @brief Fetch the list of tables in the active database.
	 * 
	 * @param $schema Optional. Filter to a specific schema.
	 */
	public function getTableNames($schema = false) {
		$filter = "";
		if($schema !== false)
			$filter = "where table_schema='$schema'";
		return $this->query("select table_schema || '.' || table_name from information_schema.tables $filter order by table_schema, table_name")->fetchAll('line', 'vertical');
	}
	
	/**
	 * @brief Check if a table exists.
	 * 
	 * @param $table The name of the table.
	 */
	public function tableExists($table) {
		return $this->query("select count(1) from information_schema.tables where table_name=?", $table)->fetch('cell');
	}

	/**
	 * @brief Get schema names.
	 * 
	 * @return An array of schema names.
	 */
	public function getSchemaNames() {
		return $this->query("select distinct table_schema from information_schema.tables order by table_schema")->fetchAll('line', 'vertical');
	}
	
	/**
	 * @brief Class methods available implemented class.
	 * 
	 * @code
	 * $features = $dbh->availableMethods();
	 * if(in_array($features, 'getDatabaseTables'))
	 *   $q = $dbh->getDatabaseTables();
	 * else echo "Uh-oh, getDatabaseTables() has not been implemented for {$dbh->engine()}";
	 * @endcode
	 */
	public function availableMethods() {
		return array('commit', 'delete', 'disconnect', 'engine', 'eraseTable', 'escapeString', 'execute',
		             'getClientEncoding', 'getClientVersion', 'getDatabaseName', 'getDatabaseNames',
		             'getHost', 'getPort', 'getProtocolVersion', 'getSchemaNames', 'getServerVersion',
		             'getTableNames', 'getTTY', 'insert', 'isConnected', 'ping', 'query', 'reconnect',
		             'rollback', 'setAutoCommit', 'setClientEncoding', 'tableExists', 'truncateTable',
		             'update', 'loadSQLFile', 'dropTable', 'dropAllTables');
	}
	
	/**
	 * @brief Check if the database is connected.
	 */
	public function isConnected() {
		return pg_connection_status($this->dbh) === PGSQL_CONNECTION_OK;
	}
	
	/**
	 * @brief Disconnect database handle.
	 * 
	 * @return Always \true.
	 */
	public function disconnect() {
		pg_close($this->dbh);
		return true;
	}
	
	/**
	 * @brief Get database product name.
	 * 
	 * @return "PostgreSQL"
	 */
	public function engine() {
		return "PostgreSQL";
	}
	
	/**
	 * @brief \c COMMIT transaction.
	 * 
	 * @throwsWarning If the commit was unsuccessful.
	 * 
	 * @throwsWarning If a new transaction cannot begin.
	 * 
	 * @return \true on success, otherwise \false.
	 */
	public function commit() {
		$success = pg_exec($this->dbh, "COMMIT");
		if(!$success)
			$this->throwWarning("Failed to commit transaction");
		
		// due to the way transactions are done, we manually check if auto commit is off and start a
		// new transaction
		if(!$this->autoCommit)
			if(!pg_exec($this->dbh, "BEGIN WORK"))
				$this->throwWarning("Can not begin transaction");
			
		return $success;
	}

	/**
	 * @brief Get an array of database names.
	 * 
	 * @notimp
	 * 
	 * @return Always \false.
	 */
	public function getDatabaseNames() {
		return false;
	}

	/**
	 * @brief \c ROLLBACK transaction.
	 * 
	 * @throwsWarning If the rollback was unsuccessful.
	 * 
	 * @throwsWarning If a new transaction cannot begin.
	 * 
	 * @return \true on success, otherwise \false.
	 */
	public function rollback() {
		$success = pg_exec($this->dbh, "ROLLBACK");
		if(!$success)
			$this->throwWarning("Failed to rollback transaction");
		
		// due to the way transactions are done, we manually check if auto commit is off and start a
		// new transaction
		if(!$this->autoCommit)
			if(!pg_exec($this->dbh, "BEGIN WORK"))
				$this->throwWarning("Can not begin transaction");
			
		return $success;
	}

	/**
	 * @brief Turn autocommit on/off
	 * 
	 * By default this is off. When turning off auto commit you will have to manually commit the
	 * transaction with commit() or undo with rollback().
	 * 
	 * @warning Changing auto commit from off to on will \em not commit or rollback the current
	 *          transaction. If you are using a transaction make sure you \c COMMIT or \c ROLLBACK
	 *          before you change the auto committing status.
	 * 
	 * @throwsWarning If a new transaction cannot begin.
	 * 
	 * @param $mode \true or \false.
	 * @return Always \true.
	 * @see commit()
	 * @see rollback()
	 */
	public function setAutoCommit($mode = false) {
		$this->autoCommit = $mode;
		if(!$this->autoCommit)
			if(!pg_exec($this->dbh, "BEGIN WORK"))
				$this->throwWarning("Can not begin transaction");
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
	 * Erasing a table removes all the entries of the table without affecting the sequences It is
	 * effectivly:
	 * @code
	 * DELETE FROM $tableName WHERE 1;
	 * @endcode
	 * 
	 * @throws Warning If the query was unsuccessful.
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
		
		$q = $this->query("DELETE FROM " . $this->escapeEntity($tableName) . " WHERE 1");
		return $q->success();
	}
	
	/**
	 * @brief TRUNCATE table.
	 * 
	 * truncateTable() uses the TRUNCATE statement with the default PostgreSQL settings. It is
	 * effectivly:
	 * @code
	 * TRUNCATE TABLE $tableName;
	 * @endcode
	 * 
	 * @throwsWarning If the query was unsuccessful.
	 * 
	 * @param $tableName The name of the table.
	 * @return \true for success, otherwise \false (such as if the table doesn't exist or you do not have
	 *         adequate privileges.)
	 */
	public function truncateTable($tableName) {
		// need a valid database handle
		if($this->dbh === false)
			return false;
		
		$q = $this->query("TRUNCATE TABLE " . $this->escapeEntity($tableName));
		return $q->success();
	}
	
	/**
	 * @brief \c UPDATE statement.
	 * 
	 * See CMDatabaseProtocol::update().
	 * 
	 * @throwsWarning If the query was unsuccessful.
	 * 
	 * @param $tableName
	 * @param $newvalues
	 * @param $criteria
	 * @param $a
	 */
	public function update($tableName, $newvalues, $criteria = false, $a = false) {
		// PostgreSQL is very specific about its types so we cast every value
		$desc = $this->describeTable($tableName);
		
		// $a must be an array
		if(!is_array($a))
			$a = array();
		
		$sql = "UPDATE " . $this->escapeEntity($tableName) . " SET ";
		$first = true;
		foreach($newvalues as $k => $v) {
			if(!$first)
				$sql .= ",";
			
			// if its a CMConstant we don't encapsulate it
			if($v instanceof CMConstant || $v instanceof CMDecimal)
				$sql .= "$k=$v";
			else
				$sql .= "$k=" . $this->castSafeValue($v, $desc[$k]);
			
			$first = false;
		}
		
		// add WHERE clause
		if($criteria !== false) {
			$sql .= " WHERE ";
			$first = true;
			foreach($criteria as $k => $v) {
				if(!$first)
					$sql .= " AND ";
				
				// if its a CMConstant we don't encapsulate it
				if($v instanceof CMConstant || $v instanceof CMDecimal)
					$sql .= "$k=$v";
				else
					$sql .= "$k='" . pg_escape_string($v) . "'";
				
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
	 * @throwsWarning If the query was unsuccessful.
	 * 
	 * @param $tableName
	 * @param $criteria
	 * @param $a
	 */
	public function delete($tableName, $criteria = false, $a = false) {
		// $a must be an array
		if(!is_array($a))
			$a = array();
		
		$sql = "DELETE FROM " . $this->escapeEntity($tableName);
		
		// add WHERE clause
		if($criteria !== false) {
			$sql .= " WHERE ";
			$first = true;
			foreach($criteria as $k => $v) {
				if(!$first) $sql .= " AND ";
				
				// if its a CMConstant we don't encapsulate it
				if($v instanceof CMConstant || $v instanceof CMDecimal)
					$sql .= "$k=$v";
				else
					$sql .= "$k='" . pg_escape_string($v) . "'";
				
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
	 * @brief Gets the client encoding.
	 * 
	 * PostgreSQL supports automatic character set conversion between server and client for certain character
	 * sets. getClientEncoding() returns the client encoding as a string. The returned string will be one of the
	 * standard PostgreSQL encoding identifiers.
	 * 
	 * @return The client encoding, or \false on error.
	 */
	public function getClientEncoding() {
		return pg_client_encoding($this->dbh);
	}
	
	/**
	 * @brief Reconnect (reset) the connection.
	 * 
	 * It is useful for error recovery.
	 * 
	 * @return Returns \true on success or \false on failure.
	 */
	public function reconnect() {
		return pg_connection_reset($this->dbh);
	}
	
	/**
	 * @brief Get the database name.
	 * 
	 * Returns the name of the database for this connection.
	 * 
	 * @return A string containing the name of the database the connection is to, or \false on error.
	 */
	public function getDatabaseName() {
		return pg_dbname($this->dbh);
	}
	
	/**
	 * @brief Returns the host name associated with this connection.
	 * 
	 * @return A string containing the name of the host for this connection, or \false on error.
	 */
	public function getHost() {
		return pg_host($this->dbh);
	}
	
	/**
	 * @brief Pings a database connection and tries to reconnect it if it is broken.
	 * 
	 * @return Returns \true on success or \false on failure.
	 */
	public function ping() {
		return pg_ping($this->dbh);
	}
	
	/**
	 * @brief Return the port number associated with this connection.
	 * 
	 * @return An int containing the port number of the database server this connection is connected to, or
	 *         \false on error.
	 */
	public function getPort() {
		return pg_port($this->dbh);
	}
	
	/**
	 * @brief Set the client encoding.
	 * 
	 * setClientEncoding() sets the client encoding and returns \c 0 if success or \c -1 if error.
	 * 
	 * PostgreSQL will automatically convert data in the backend database encoding into the frontend encoding.
	 * 
	 * @param $encoding The required client encoding. One of \c SQL_ASCII, \c EUC_JP, \c EUC_CN, \c EUC_KR,
	 *        \c EUC_TW, \c UNICODE, \c MULE_INTERNAL, \c LATINX (X=1...9), \c KOI8, \c WIN, \c ALT, \c SJIS,
	 *        \c BIG5 or \c WIN1250. The exact list of available encodings depends on your PostgreSQL version,
	 *        so check your PostgreSQL manual for a more specific list.
	 * @return Returns \c 0 on success or \c -1 on error.
	 */
	public function setClientEncoding($encoding) {
		return pg_set_client_encoding($this->dbh, $encoding);
	}
	
	/**
	 * @brief Return the TTY name associated with the connection.
	 * 
	 * getTTY() returns the TTY name that server side debugging output is sent to on the given PostgreSQL
	 * connection resource.
	 * 
	 * @note getTTY() is obsolete, since the server no longer pays attention to the TTY setting, but the function
	 *       remains for backwards compatibility.
	 * @return A string containing the debug TTY of the connection, or \false on error.
	 */
	public function getTTY() {
		return pg_tty($this->dbh);
	}
	
	/**
	 * @brief Get the client version.
	 */
	public function getClientVersion() {
		$v = pg_version();
		return $v['client'];
	}
	
	/**
	 * @brief Get the protocol version.
	 */
	public function getProtocolVersion() {
		$v = pg_version();
		return $v['protocol'];
	}
	
	/**
	 * @brief Get the server version.
	 */
	public function getServerVersion() {
		$v = pg_version();
		return $v['server_version'];
	}
	
	/**
	 * @brief Escape a string based on the correct rules of the database engine.
	 * 
	 * @param $str The value to be escaped.
	 * @return Escaped string that does not include surrounding quotes.
	 */
	public function escapeString($str) {
		return pg_escape_string($str); 
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
	 * @brief Load a SQL file into the current connection.
	 *
	 * This will read the input file one command at a time (skipping comments) and execute the statements. If a statement fails
	 * an error will be pushed but the loading will not stop. You can review all of the errors after it's complete with
	 * isErrors() and errors().
	 *
	 * As one command is loaded in at a time this will work on very large SQL files.
	 *
	 * @param $path The relative or absolute path to the SQL file. The file does not have to have a .sql extension and can even
	 *        be remote through a URI that PHP's fopen() can understand.
	 * @param $a Associative array of options.
	 * @return \true if ALL the statements executed successfully, otherwise \false. Will also return \false is the input file
	 *         could not be opened.
	 */
	public function loadSQLFile($path, $a = array()) {
		// prepare
		$f = fopen($path, "r");
		if(!$f)
			return $this->throwError("Could not open input file $path");
		
		// read each SQL command
		$success = true;
		$sql = "";
		while(true) {
			$c = fgetc($f);
			
			// skip whitespace
			while(true) {
				$c = fgetc($f);
				if(!ctype_space($c)) {
					fseek($f, -1, SEEK_CUR);
					break;
				}
			}
			
			// comment
			if($c == '-') {
				if(fgetc($f) == '-') {
					// keep reading until the comment ends
					while(true) {
						$c = fgetc($f);
						if($c == "\n" || $c == "\r" || feof($f))
							break;
					}
					continue;
				}
				else
					fseek($f, -1, SEEK_CUR);
			}
			
			// reading SQL
			while(true) {
				$c = fgetc($f);
				if($c == ";" || feof($f)) {
					$sql = trim($sql);
					if($sql != "")
						$this->query($sql);
						
					// reset
					$sql = "";
					break;
				}
				$sql .= $c;
			}
			
			if(feof($f))
				break;
		}
		
		return $success;
	}
	
	/**
	 * @brief Drop (delete) a table.
	 *
	 * Use this will caution, this is irreversible.
	 *
	 * @param $tablename The name of the table to be dropped.
	 * @param $a 'cascade' can be \true or \false. If it is not supplied then \true is used. If 'cascade' is \true it
	 *        will remove any objects related directly to the table likw sequences, indexes, etc.
	 * @return \true on success, otherwise \false.
	 */
	public function dropTable($tablename, $a = array()) {
		$sql = "DROP TABLE $tablename";
		
		if(!isset($a['cascade']))
			$a['cascade'] = true;
		if($a['cascade'])
			$sql .= " CASCADE";
			
		return $this->execute($sql);
	}
	
	/**
	 * @brief Drop all of the tables in the current database.
	 *
	 * @note BE CAREFUL. This cannot be undone and will destory all the tables and the data they contain in an entire
	 *       database.
	 *
	 * @param $a Options. Ignored.
	 * @return \true if all the tables were dropped successfully, otherwise \false.
	 */
	public function dropAllTables($a = array()) {
		$tables = $this->getTableNames('public');
		$success = true;
		
		foreach($tables as $table)
			$success = $success && $this->dropTable($table);
		
		return $success;
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
		return "\"$str\"";
	}
	
	/**
	 * @brief Translate a SQL ARRAY into a PHP array.
	 * @param $data A string in a PostgreSQL ARRAY format like '{1,2,3}'.
	 */
	public static function Arrayify($data) {
		if(@substr($data, 0, 1) != '{')
			return NULL;
		
		return explode(",", substr($data, 1, strlen($data) - 2));
	}
	
}

?>
