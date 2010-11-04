<?php

include_once("CMDatabaseProtocol.php");
include_once("CMMySQLQuery.php");
include_once("CMConstant.php");
include_once("CMError.php");

/**
 * @brief MySQL connectivity class.
 * 
 * 
 * @section cmmysql_desc Description
 * This class acts as a handle for connecting to a MySQL database. PHP has 2 primary ways of doing
 * this with different drivers, see \ref cmmysql_mysqlvsmysqli for more information.
 * 
 * 
 * @section cmmysql_usage Usage
 * Use this class to connect to a local or remote MySQL database. The constructor takes a URI and
 * uses the extracted details to make the connection. See CMMySQL().
 * 
 * 
 * @section cmmysql_example1 Example 1: Connecting to a MySQL database.
 * @code
 * // connect
 * $dbh = new CMMySQL("mysql://bob:abc123@localhost/mydb");
 * if($dbh->error())
 *   die("Could not connect to the database: " . $dbh->error());
 * @endcode
 * 
 * 
 * @section cmmysql_example2 Example 2: Query data from a table.
 * There are two ways of doing this, the first is to iterate the data - that is to only select the data as
 * you intent to process it. This is the most common way:
 * @code
 * // iterating data
 * $q = $dbh->query("select * from mytable where id between ? and ?", array(5, 10));
 * while($r = $q->fetch()) {
 *   print_r($r);
 * }
 * @endcode
 * 
 * The second way to fetch all the of the data into a single array. This is useful when using small selects
 * or data that you need ot process many times. Just be careful, this method requies your PHP to be able
 * to allocate enough RAM to hold the entire result set.
 * @code
 * // all-in-one line
 * $all = $dbh->query("select * from mytable")->fetchAll();
 * @endcode
 * 
 * 
 * @section cmmysql_mysqlvsmysqli MySQL vs MySQLi
 * PHP 5+ encourages the use of the \c mysqli_ functions, but this is an extension that does
 * not come standard with all PHP distibutions and is not easy to install in shared environments.
 * For this reason CMMySQL will automatically choose the best driver when a connection is created -
 * first selecting MySQLi if it is available or falling back to the standard MySQL API if not.
 * 
 * 
 * @section cmmysql_native Native Mapping
 * <table>
 *   <tr>
 *     <th>PHP Function</th>
 *     <th>CMLIB Method</th>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_affected_rows</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_client_encoding</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_close</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_connect</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_create_db</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_data_seek</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_db_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_db_query</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_drop_db</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_errno</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_error</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_escape_string</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_fetch_array</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_fetch_assoc</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_fetch_field</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_fetch_lengths</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_fetch_object</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_fetch_row</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_field_flags</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_field_len</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_field_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_field_seek</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_field_table</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_field_type</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_free_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_get_client_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_get_host_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_get_proto_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_get_server_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_insert_id</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_list_dbs</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_list_fields</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_list_processes</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_list_tables</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_num_fields</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_num_rows</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_pconnect</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_ping</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_query</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_real_escape_string</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_select_db</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_set_charset</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_stat</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_tablename</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_thread_id</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysql_unbuffered_query</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 * </table>
 * 
 * 
 * <table>
 *   <tr>
 *     <th>PHP Function</th>
 *     <th>CMLIB Method</th>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->affected_rows</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::autocommit</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::change_user</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::character_set_name</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->client_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->client_version</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::close</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::commit</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->connect_errno</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->connect_error</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::__construct</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::debug</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::dump_debug_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->errno</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->error</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->field_count</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::get_charset</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->get_client_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->client_version</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::get_connection_stats</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->host_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->protocol_version</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->server_info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->server_version</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::get_warnings</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->info</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::init</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->insert_id</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::kill</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::more_results</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::multi_query</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::next_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::options</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::ping</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::poll</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::prepare</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::query</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::real_connect</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::real_escape_string</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::real_query</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::reap_async_query</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::rollback</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::select_db</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::set_charset</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::set_local_infile_default</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::set_local_infile_handler</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli->sqlstate</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::ssl_set</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::stat</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::stmt_init</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::store_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::thread_id</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::thread_safe</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::use_result</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mysqli::warning_count</tt></td>
 *     <td>(not available)</td>
 *   </tr>
 * </table>
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMMySQL extends CMError implements CMDatabaseProtocol {
	
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
	 * @brief Internal database handle.
	 */
	private $dbh = false;
	
	/**
	 * @brief The driver determines the PHP functions to call.
	 * 
	 * See \ref cmmysql_mysqlvsmysqli
	 */
	private $driver = 'mysqli';
	
	/**
	 * @brief Internal use.
	 * 
	 * @see setAutoCommit()
	 * @see getAutoCommit()
	 */
	private $autoCommit = true;
	
	/**
	 * @brief Connect to a MySQL database.
	 * 
	 * Database connections are made with a URI like;
	 * @code
	 * $dbh = new CMMySQL("mysql://username:password@host:port/dbname");
	 * if($dbh->error())
	 *   die("Oh no! The error was " . $dbh->error());
	 * @endcode
	 * 
	 * \par \c host using MySQLi
	 * Can be either a host name or an IP address. When possible, pipes will be used instead of the
	 * TCP/IP protocol.\n
	 * Prepending host by p: opens a persistent connection. changeUser() is automatically called
	 * on connections opened from the connection pool.
	 * 
	 * \par \c user
	 * The MySQL user name.
	 * 
	 * \par \c password
	 * If not provided, the MySQL server will attempt to authenticate the user against those user
	 * records which have no password only. This allows one username to be used with different
	 * permissions (depending on if a password as provided or not).
	 * 
	 * \par \c dbname
	 * If provided will specify the default database to be used when performing queries.
	 * 
	 * \par \c port
	 * Specifies the port number to attempt to connect to the MySQL server. If this is not provided
	 * \c 3306 (the default MySQL server port) will be used.
	 * 
	 * If the \c mysql driver is used and the \c username and/or \c password is not provided the values are
	 * taken from \c mysql.default_user and \c mysql.default_password respectivly. Unless PHP SQL safe mode
	 * is activated, then the default values are ignored.
	 * 
	 * You can use $a['error'] to assign a different error stack before it makes the connection.
	 * @code
	 * $e = new CMError();
	 * $e->setVerboseLevel(CMErrorType::Fatal);
	 * $fail = new CMMySQL("mysql://blabla@localhost/blabla", array('error' => $e));
	 * $errors = $e->errors();
	 * @endcode
	 * 
	 * @note MySQLi custom socket path is not supported yet.
	 * 
	 * @param $uri URI string.
	 * @param $a Assign extra attributes or actions. See table above.
	 * @return A new CMMySQL object will always be returned regardless of if the connection is
	 *         successfull.
	 */
	public function CMMySQL($uri, $a = false) {
		// $a must be an array
		if(!is_array($a))
			$a = array($a => true);
			
		// set error stack
		if(isset($a['error']))
			$this->useErrorStack($a['error']);
		
		// dissect the URI
		$v = parse_url($uri);
		$v['db'] = basename($v['path']);
		if(!isset($v['port']))
			$v['port'] = 3306;
		
		// make sure the scheme is valid
		if($v['scheme'] != 'mysql') {
			$this->throwError("Unsupported driver '{$v['scheme']}'");
			return $this;
		}
		
		// attempt to connect
		if(class_exists('mysqli')) {
			$this->driver = 'mysqli';
			
			$this->dbh = @new mysqli($v['host'], $v['user'], $v['pass'], $v['db'], $v['port']);
			if($this->dbh->connect_error) {
				$this->dbh = false;
				$this->throwError("Unable to connect via MySQLi",
				  array('number' => $this->dbh->connect_errno, 'message' => $this->dbh->connect_error));
				return $this;
			}
		} else {
			// we have to use the old mysql driver
			$this->driver = 'mysql';
			
			$this->dbh = @mysql_connect($v['host'] . ':' . $v['port'], $v['user'], $v['pass']);
			if(!$this->dbh) {
				$this->dbh = false;
				$this->throwError($this->dbh->connect_error,
				  array('number' => $this->dbh->connect_errno, 'message' => $this->dbh->connect_error));
				return $this;
			}
			
			if(!@mysql_select_db($v['db'])) {
				$this->throwError($this->dbh->connect_error,
				  array('number' => $this->dbh->connect_errno, 'message' => $this->dbh->connect_error));
				return $this;
			}
		}
	}
	
	/**
	 * @brief Perform a query on the database that returns a handle to iterate the results.
	 * 
	 * <b>Example</b>
	 * @code
	 * $q = $dbh->query("select * from mytable");
	 * if($q->error())
	 *   die("Query failed: " . $q->error());
	 * @endcode
	 * 
	 * @note When using \c mysql driver: mysql_query() sends a unique query (multiple queries are not
	 *       supported) to the currently active database on the server.
	 * 
	 * @note For actions that do not require a result use execute().
	 * 
	 * @throwsWarning When the query fails. \c 'sql' attribute attached with raw SQL.
	 * 
	 * @param $sql SQL, this can contain bind marks for $values. The query string should not end with a
	 *        semicolon. Data inside the query should be properly escaped (you should use the binding).
	 * @param $values An non-associative array of values to substitute into the SQL statement. If
	 *        there is only one value to substitute this does not need to be an array.
	 * @param $a An associative array of server options for the query.
	 * @return A new CMMySQLQuery is always returned regarless of if the query fails.
	 * @see execute()
	 * @see insert()
	 */
	public function query($sql, $values = false, $a = false) {
		// $a must be an array
		if(!is_array($a))
			$a = array();
		if(!isset($a['execute']))
			$a['execute'] = true;
		
		// bind values
		$sql = $this->bindValues($sql, $values);
		
		if(isset($a['print']))
			echo $sql;
		
		if($a['execute']) {
			if($this->driver == 'mysqli')
				$r = @$this->dbh->query($sql);
			else $r = mysql_query($sql, $this->dbh);
		}
			
		if(!$r) {
			$this->throwWarning("Query failed", array('sql' => $sql));
			return new CMMySQLQuery($r, 0, $this->driver, $a);
		}
		
		if(isset($a['return']))
			return $sql;
		return new CMMySQLQuery($r, $this->dbh->affected_rows, $this->driver, $a);
	}
	
	/**
	 * @brief Perform a query on the database that does not return a handle.
	 * 
	 * @note For actions that do require a result use query().
	 * 
	 * @param $sql SQL
	 * @param $values An optional associative array of values to bind to the SQL.
	 * @param $a An associative array of server options for the query.
	 * @return \true or \false is the query was successful.
	 */
	public function execute($sql, $values = false, $a = false) {
		$q = $this->query($sql, $values, $a);
		return $q->success();
	}
	
	/**
	 * @brief MySQL \c INSERT
	 * 
	 * This uses a key-value paired array to construct an INSERT statement like:
	 * @code
	 * $dbh->insert('mytable', array('a' => 'Something', 'b' => 123.45));
	 * @endcode
	 * 
	 * Will produce and execute the following SQL:
	 * @code
	 * insert into mytable (a, b) values ('Something', '123.45')
	 * @endcode
	 * 
	 * @throwsWarning When the query fails. \c 'sql' attribute attached with raw SQL.
	 * 
	 * @param $tableName The table name.
	 * @param $kv An associaive array of field names and their respective values.
	 * @param $a See Query options
	 * @return If the insert was successful the last insert ID will be returned. If the query was
	 *         not successful 0 will be returned.
	 */
	public function insert($tableName, $kv = false, $a = false) {
		// $a must be an array
		if(!is_array($a))
			$a = array();
		
		$sql = "insert into `$tableName` (" . implode(',', array_keys($kv)) . ") values (";
		$first = true;
		foreach($kv as $k => $v) {
			if(!$first) $sql .= ",";
			
			// if its a CMConstant we don't encapsulate it
			if($v instanceof CMConstant)
				$sql .= $v;
			else
				$sql .= "'" . mysql_real_escape_string($v) . "'";
			
			$first = false;
		}
		
		if(isset($a['print']))
			echo "$sql)";
		
		if($this->driver == 'mysqli') {
			if(!$this->dbh) {
				$this->throwWarning("No valid database handle");
				return 0;
			}
			
			$q = $this->dbh->prepare("$sql)");
			if($q) {
				$q->execute();
				return $this->query("select last_insert_id()", false, $a)->fetch('cell');
			}
			$this->throwWarning("INSERT failed", array('sql' => "$sql)"));
			return 0;
		}
		
		$q = mysql_query("$sql)", $this->dbh);
		if($q)
			return $this->query("select last_insert_id()", false, $a)->fetch('cell');
		
		$this->throwWarning("INSERT failed", array('sql' => "$sql)"));
		return 0;
	}
	
	/**
	 * @brief Change the active database.
	 * 
	 * In most cases it is easier to set the active database when creating the connection, such:
	 * @code
	 * $dbh = new CMMySQL("mysql://bob:abc123@localhost/mydb");
	 * @endcode
	 * In the above example the active database will be set to <tt>mydb</tt>.
	 * 
	 * @param $dbname New database name.
	 * @param $a Does not do anything right now, but is there for future versions.
	 * @return \true if success, otherwise \false.
	 */
	public function selectDatabase($dbname, $a = false) {
		if($this->driver == 'mysqli')
			return $this->dbh->select_db($dbname);
		return mysql_select_db($dbname, $this->dbh);
	}
	
	/**
	 * @brief Internal use for binding value in SQL statements.
	 * 
	 * Use internally by query() and insert() for substituting values.
	 * @code
	 * select * from mytable where id=? and name=?
	 * @endcode
	 * to
	 * @code
	 * select * from mytable where id='3' and name='Bob'
	 * @endcode
	 * 
	 * @param $sql SQL
	 * @param $values An non-associative array of values to escape and substitute.
	 * @return Substituted string that is automatically escaped.
	 * @see query()
	 * @see execute()
	 * @see insert()
	 */
	public function bindValues($sql, $values = false) {
		if(is_array($values)) {
			$parts = explode('?', $sql);
			$new_sql = "";
			for($i = 0; $i < count($parts) - 1; ++$i) {
				// if its a CMConstant we don't encapsulate it
				if($values[$i] instanceof CMConstant)
					$new_sql .= $parts[$i] . $values[$i];
				else {
					if($this->driver == 'mysqli')
						$new_sql .= $parts[$i] . "'" . $this->dbh->real_escape_string($values[$i]) . "'";
					else
						$new_sql .= $parts[$i] . "'" . mysql_real_escape_string($values[$i]) . "'";
				}
			}
			$sql = $new_sql . $parts[count($parts) - 1];
		} elseif($values !== false) {
			// if its a CMConstant we don't encapsulate it
			if($values[$i] instanceof CMConstant)
				$sql = str_replace('?', $values, $sql);
			else {
				if($this->driver == 'mysqli')
					$sql = str_replace('?', "'" . $this->dbh->real_escape_string($values) . "'", $sql);
				else
					$sql = str_replace('?', "'" . mysql_real_escape_string($values) . "'", $sql);
			}
		}
			
		return $sql;
	}
	
	/**
	 * @brief Fetch the list of tables in the active database.
	 * 
	 * @param $schema MySQL does not support schemas so this value has no effect.
	 */
	public function getTableNames($schema = false) {
		return $this->query("show tables")->fetchAll('cell', 'vertical');
	}
	
	/**
	 * @brief Returns \true or \false for the selected database.
	 * 
	 * @param $table The table name.
	 */
	public function tableExists($table) {
		$q = $this->query("show tables");
		while($r = $q->fetch('line')) {
			if($r[0] == $table)
				return true;
		}
		return false;
	}
	
	/**
	 * @brief Get database names.
	 * 
	 * @return Simple array of database names.
	 */
	public function getDatabaseNames() {
		return $this->query("show databases")->fetchAll('line', 'vertical');
	}

	/**
	 * @brief Get database names.
	 * 
	 * As MySQL does not support schemas, this method will is an alias for getDatabaseNames() and
	 * hence return the same result.
	 * 
	 * @return Simple array of database names.
	 */
	public function getSchemaNames() {
		return $this->getDatabaseNames();
	}
	
	/**
	 * @brief Get available protocol methods.
	 * 
	 * @code
	 * $features = $dbh->availableMethods();
	 * if(in_array($features, 'getDatabaseTables'))
	 *     $q = $dbh->getDatabaseTables();
	 * else echo "Uh-oh, getDatabaseTables() has not been implemented for {$dbh->engine()}";
	 * @endcode
	 */
	public function availableMethods() {
		if($this->driver == 'mysqli')
			return array('query', 'execute', 'insert', 'selectDatabase',
			             'getTableNames', 'tableExists', 'getDatabaseNames',
			             'getSchemaNames', 'isConnected', 'disconnect',
			             'getClientVersion', 'getServerVersion', 'getClientInfo',
			             'getHostInfo', 'getServerInfo', 'getProtocolVersion',
			             'getLastInsertID', 'setAutoCommit', 'changeUser',
			             'getCharacterSetName', 'getCharacterSet', 'commit',
			             'getConnectionStatistics', 'getWarnings', 'killThread',
			             'setOption', 'ping', 'escapeString', 'rollback',
			             'setCharacterSet', 'setLocalInfileDefault',
			             'setLocalInfileHandler', 'SQLState', 'getStatus',
			             'getThreadID', 'isThreadSafe', 'getWarningCount',
			             'engine', 'eraseTable', 'truncateTable', 'update',
			             'delete', 'getAutoCommit');
			
		return array('query', 'execute', 'insert', 'selectDatabase',
		             'getTableNames', 'tableExists', 'getDatabaseNames',
		             'getSchemaNames', 'isConnected', 'disconnect',
		             'getLastInsertID', 'ping', 'escapeString', 'engine',
		             'eraseTable', 'truncateTable', 'update', 'delete',
		             'getAutoCommit');
	}
	
	/**
	 * @brief Check if the database handle is valid.
	 * 
	 * @return \true or \false.
	 */
	public function isConnected() {
		return $this->dbh !== false;
	}
	
	/**
	 * @brief Disconnect database handle.
	 */
	public function disconnect() {
		if($this->driver == 'mysqli')
			return $this->dbh->close();
		return mysql_close($this->dbh);
	}
	
	/**
	 * @brief Get MySQL client info
	 * 
	 * This is useful to quickly determine the version of the client library to know if some
	 * capability exits.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @return A number that represents the MySQL client library version in format:
	 *         main_version*10000 + minor_version *100 + sub_version. For example, 4.1.0 is returned
	 *         as 40100.
	 */
	public function getClientVersion() {
		if($this->driver == 'mysqli')
			return $this->dbh->client_version;
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Returns the version of the MySQL server as an integer
	 * 
	 * The serverVersion() function returns the version of the server connected to (represented by
	 * the link parameter) as an integer.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @return An integer representing the server version. The form of this version number is
	 *         main_version * 10000 + minor_version * 100 + sub_version (i.e. version 4.1.0 is
	 *         40100).
	 */
	public function getServerVersion() {
		if($this->driver == 'mysqli')
			return $this->dbh->server_version;
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Returns the MySQL client version as a string
	 * 
	 * Returns a string that represents the MySQL client library version.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @return A string that represents the MySQL client library version
	 */
	public function getClientInfo() {
		if($this->driver == 'mysqli')
			return $this->dbh->client_info;
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Host information.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 */
	public function getHostInfo() {
		if($this->driver == 'mysqli')
			return $this->dbh->host_info;
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Client information.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 */
	public function getServerInfo() {
		if($this->driver == 'mysqli')
			return $this->dbh->server_info;
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Protocol version.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 */
	public function getProtocolVersion() {
		if($this->driver == 'mysqli')
			return $this->dbh->protocol_version;
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Last insert ID.
	 * 
	 * The last insert ID is the last primary key that was inserted into any table.
	 * 
	 * @return Last insert ID.
	 */
	public function getLastInsertID() {
		if($this->driver == 'mysqli')
			return $this->dbh->insert_id;
		return mysql_insert_id($this->dbh);
	}
	
	/**
	 * @brief Turn on/off auto commit.
	 * 
	 * For tranactional database engines. This is used for manual commiting, when inserting large
	 * sets of data or snapshot information its is recommented you turn autocommit off and
	 * manually commit the transaction. This will be faster and more consistent.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @param $mode Can be any value that will be evaluated to \true or \false according to the
	 *        rules of PHP and the type of argument provided.
	 * @return \true if the change was made/available, otherwise \false.
	 */
	public function setAutoCommit($mode = false) {
		$this->autoCommit = $mode;
		if($this->driver == 'mysqli')
			return $this->dbh->autocommit($mode);
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Change user.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @param $user User name
	 * @param $password Password
	 * @param $database Database name
	 */
	public function changeUser($user, $password, $database) {
		if($this->driver == 'mysqli')
			return $this->dbh->change_user($user, $password, $database);
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Get the current character set.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 */
	public function getCharacterSetName() {
		if($this->driver == 'mysqli')
			return $this->dbh->character_set_name();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Returns a character set object.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 */
	public function getCharacterSet() {
		if($this->driver == 'mysqli')
			return $this->dbh->get_charset();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Commit transaction.
	 * 
	 * Commit a transaction. In most cases you will have to turn autocommit off before passing
	 * your SQL stataments with setAutoCommit(false).
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @note This method will still return \true for engines that are not transactional, such as
	 *       MyISAM.
	 * 
	 * @return \true on success, \false if the transaction could not be commited.
	 * 
	 * @see setAutoCommit()
	 */
	public function commit() {
		if($this->driver == 'mysqli')
			return $this->dbh->commit();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Get connection statistics.
	 *		
	 * @code
	 * Array
	 * (
	 *     [bytes_sent] => 43
	 *     [bytes_received] => 80
	 *     [packets_sent] => 1
	 *     [packets_received] => 2
	 *     [protocol_overhead_in] => 8
	 *     [protocol_overhead_out] => 4
	 *     [bytes_received_ok_packet] => 11
	 *     [bytes_received_eof_packet] => 0
	 *     [bytes_received_rset_header_packet] => 0
	 *     [bytes_received_rset_field_meta_packet] => 0
	 *     [bytes_received_rset_row_packet] => 0
	 *     [bytes_received_prepare_response_packet] => 0
	 *     [bytes_received_change_user_packet] => 0
	 *     [packets_sent_command] => 0
	 *     [packets_received_ok] => 1
	 *     [packets_received_eof] => 0
	 *     [packets_received_rset_header] => 0
	 *     [packets_received_rset_field_meta] => 0
	 *     [packets_received_rset_row] => 0
	 *     [packets_received_prepare_response] => 0
	 *     [packets_received_change_user] => 0
	 *     [result_set_queries] => 0
	 *     [non_result_set_queries] => 0
	 *     [no_index_used] => 0
	 *     [bad_index_used] => 0
	 *     [slow_queries] => 0
	 *     [buffered_sets] => 0
	 *     [unbuffered_sets] => 0
	 *     [ps_buffered_sets] => 0
	 *     [ps_unbuffered_sets] => 0
	 *     [flushed_normal_sets] => 0
	 *     [flushed_ps_sets] => 0
	 *     [ps_prepared_never_executed] => 0
	 *     [ps_prepared_once_executed] => 0
 	 *     [rows_fetched_from_server_normal] => 0
	 *     [rows_fetched_from_server_ps] => 0
	 *     [rows_buffered_from_client_normal] => 0
	 *     [rows_buffered_from_client_ps] => 0
	 *     [rows_fetched_from_client_normal_buffered] => 0
	 *     [rows_fetched_from_client_normal_unbuffered] => 0
	 *     [rows_fetched_from_client_ps_buffered] => 0
	 *     [rows_fetched_from_client_ps_unbuffered] => 0
 	 *     [rows_fetched_from_client_ps_cursor] => 0
	 *     [rows_skipped_normal] => 0
	 *     [rows_skipped_ps] => 0
	 *     [copy_on_write_saved] => 0
	 *     [copy_on_write_performed] => 0
	 *     [command_buffer_too_small] => 0
	 *     [connect_success] => 1
	 *     [connect_failure] => 0
	 *     [connection_reused] => 0
	 *     [reconnect] => 0
	 *     [pconnect_success] => 0
	 *     [active_connections] => 1
	 *     [active_persistent_connections] => 0
	 *     [explicit_close] => 0
	 *     [implicit_close] => 0
	 *     [disconnect_close] => 0
	 *     [in_middle_of_command_close] => 0
	 *     [explicit_free_result] => 0
	 *     [implicit_free_result] => 0
	 *     [explicit_stmt_close] => 0
	 *     [implicit_stmt_close] => 0
	 *     [mem_emalloc_count] => 0
	 *     [mem_emalloc_ammount] => 0
	 *     [mem_ecalloc_count] => 0
	 *     [mem_ecalloc_ammount] => 0
	 *     [mem_erealloc_count] => 0
	 *     [mem_erealloc_ammount] => 0
	 *     [mem_efree_count] => 0
	 *     [mem_malloc_count] => 0
	 *     [mem_malloc_ammount] => 0
	 *     [mem_calloc_count] => 0
	 *     [mem_calloc_ammount] => 0
	 *     [mem_realloc_count] => 0
	 *     [mem_realloc_ammount] => 0
	 *     [mem_free_count] => 0
	 *     [proto_text_fetched_null] => 0
	 *     [proto_text_fetched_bit] => 0
	 *     [proto_text_fetched_tinyint] => 0
	 *     [proto_text_fetched_short] => 0
	 *     [proto_text_fetched_int24] => 0
	 *     [proto_text_fetched_int] => 0
	 *     [proto_text_fetched_bigint] => 0
	 *     [proto_text_fetched_decimal] => 0
	 *     [proto_text_fetched_float] => 0
	 *     [proto_text_fetched_double] => 0
	 *     [proto_text_fetched_date] => 0
	 *     [proto_text_fetched_year] => 0
	 *     [proto_text_fetched_time] => 0
	 *     [proto_text_fetched_datetime] => 0
	 *     [proto_text_fetched_timestamp] => 0
 	 *     [proto_text_fetched_string] => 0
	 *     [proto_text_fetched_blob] => 0
	 *     [proto_text_fetched_enum] => 0
	 *     [proto_text_fetched_set] => 0
	 *     [proto_text_fetched_geometry] => 0
	 *     [proto_text_fetched_other] => 0
	 *     [proto_binary_fetched_null] => 0
	 *     [proto_binary_fetched_bit] => 0
	 *     [proto_binary_fetched_tinyint] => 0
	 *     [proto_binary_fetched_short] => 0
	 *     [proto_binary_fetched_int24] => 0
	 *     [proto_binary_fetched_int] => 0
	 *     [proto_binary_fetched_bigint] => 0
	 *     [proto_binary_fetched_decimal] => 0
	 *     [proto_binary_fetched_float] => 0
	 *     [proto_binary_fetched_double] => 0
	 *     [proto_binary_fetched_date] => 0
	 *     [proto_binary_fetched_year] => 0
	 *     [proto_binary_fetched_time] => 0
	 *     [proto_binary_fetched_datetime] => 0
	 *     [proto_binary_fetched_timestamp] => 0
	 *     [proto_binary_fetched_string] => 0
	 *     [proto_binary_fetched_blob] => 0
	 *     [proto_binary_fetched_enum] => 0
	 *     [proto_binary_fetched_set] => 0
	 *     [proto_binary_fetched_geometry] => 0
	 *     [proto_binary_fetched_other] => 0
	 * )
	 * @endcode
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 */
	public function getConnectionStatistics() {
		if($this->driver == 'mysqli')
			return $this->dbh->get_connection_stats();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Get result of <tt>SHOW WARNINGS</tt>.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 */
	public function getWarnings() {
		if($this->driver == 'mysqli')
			return $this->dbh->get_warnings();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Kill a MySQL thread.
	 * 
	 * Asks the server to kill a MySQL thread.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @param $threadID The thread ID.
	 */
	public function killThread($threadID) {
		if($this->driver == 'mysqli')
			return $this->dbh->kill($threadID);
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Set option.
	 * 
	 * <tt>$option</tt> can be one of the following values:
	 * <table border>
	 * 		<tr>
	 * 		<td><tt>MYSQLI_OPT_CONNECT_TIMEOUT</tt></td>
	 * 			<td>Connection timeout in seconds (supported on Windows with TCP/IP since PHP 5.3.1)</td>
	 * 		</tr>
	 * 		<tr>
	 * 			<td><tt>MYSQLI_OPT_LOCAL_INFILE</tt></td>
	 * 			<td>Enable/disable use of LOAD LOCAL INFILE</td>
	 * 		</tr>
	 * 		<tr>
	 * 			<td><tt>MYSQLI_INIT_COMMAND</tt></td>
	 * 			<td>Command to execute after when connecting to MySQL server</td>
	 * 		</tr>
	 * 		<tr>
	 * 			<td><tt>MYSQLI_READ_DEFAULT_FILE</tt></td>
	 * 			<td>Read options from named option file instead of my.cnf</td>
	 * 		</tr>
	 * 		<tr>
	 * 			<td><tt>MYSQLI_READ_DEFAULT_GROUP</tt></td>
	 * 			<td>Read options from the named group from my.cnf or the file specified with MYSQL_READ_DEFAULT_FILE.</td>
	 * 		</tr>
	 * 	</table>
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * 	@param $option The option that you want to set.
	 * 	@param $value The value for the option.
	 * 	@returns Returns <tt>true</tt> on success or <tt>false</tt> on failure.
	 */
	public function setOption($option, $value) {
		if($this->driver == 'mysqli')
			return $this->dbh->options($option, $value);
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Ping this server connection.
	 * 
	 * Ping this server connection, or tries to reconnect if the connection has gone down.
	 */
	public function ping() {
		if($this->driver == 'mysqli')
			return $this->dbh->ping();
		return mysql_ping($this->dbh);
	}
	
	/**
	 * @brief Escapes special characters in a string for use in a SQL statement.
	 * 
	 * Escapes special characters in a string for use in a SQL statement, taking into account the
	 * current charset of the connection.
	 * 
	 * @param $str The string to be escaped. Characters encoded are NUL (ASCII 0), \\n, \\r, \\,
	 *        ', ", and Control-Z.
	 * @returns Returns an escaped string.
	 */
	public function escapeString($str) {
		if($this->driver == 'mysqli')
			return $this->dbh->real_escape_string($str);
		return mysql_real_escape_string($str);
	}
	
	/**
	 * @brief Rolls back current transaction.
	 * 
	 * Somewhat opposite to the commit() function, this allows a transaction to be rolled back.
	 * 
	 * @note In most cases you must remember to turn autocommit off or else rollback() will not
	 *       have a transaction to rollback on.
	 * 
	 * @note This method will still return \true for engines that are not transactional. Such as
	 *       MyISAM.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @return \true on success, \false if the transaction could not be rolled back.
	 * 
	 * @see setAutoCommit()
	 */ 
	public function rollback() {
		if($this->driver == 'mysqli')
			return $this->dbh->rollback();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Sets the default client character set.
	 * 
	 * Sets the default character set to be used when sending data from and to the database
	 * server.
	 * 
	 * @note To use this function on a Windows platform you need MySQL client library version
	 *       4.1.11 or above (for MySQL 5.0 you need 5.0.6 or above).
	 * 
	 * @note This is the preferred way to change the charset. Using CMMySQL::query() to
	 *       execute <tt>SET NAMES ..</tt> is not recommended.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @param $charset The charset to be set as default.
	 */
	public function setCharacterSet($charset) {
		if($this->driver == 'mysqli')
			return $this->dbh->set_charset($charset);
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Unsets user defined handler for load local infile command.
	 * 
	 * Deactivates a <tt>LOAD DATA INFILE LOCAL</tt> handler previously set with
	 * setLocalInfileHandler().
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @returns No value is returned.
	 */
	public function setLocalInfileDefault() {
		if($this->driver == 'mysqli')
			return $this->dbh->set_local_infile_default();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Set callback function for <tt>LOAD DATA LOCAL INFILE</tt> command.
	 * 
	 * Set callback function for <tt>LOAD DATA LOCAL INFILE</tt> command
	 * 
	 * The callbacks task is to read input from the file specified in the <tt>LOAD DATA
	 * LOCAL INFILE</tt> and to reformat it into the format understood by <tt>LOAD DATA
	 * INFILE</tt>.
	 * 
	 * The returned data needs to match the format specified in the <tt>LOAD DATA</tt>.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @param $readFunction The callback function should return the number of characters
	 * stored in the buffer or a negative value if an error occurred.
	 */
	public function setLocalInfileHandler($readFunction) {
		if($this->driver == 'mysqli')
			return $this->dbh->set_local_infile_handler($readFunction);
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Returns the SQLSTATE error from previous MySQL operation.
	 * 
	 * Returns a string containing the SQLSTATE error code for the last error. The error code
	 * consists of five characters. '00000' means no error. The values are specified by ANSI
	 * SQL and ODBC. For a list of possible values, see
	 * http://dev.mysql.com/doc/mysql/en/error-handling.html.
	 * 
	 * @note Note that not all MySQL errors are yet mapped to SQLSTATE's. The value HY000
	 *       (general error) is used for unmapped errors.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @returns Returns a string containing the SQLSTATE error code for the last error. The
	 * error code consists of five characters. '00000' means no error.
	 */
	public function SQLState() {
		if($this->driver == 'mysqli')
			return $this->dbh->sqlstate;
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Gets the current system status.
	 * 
	 * status() returns a string containing information similar to that provided by the
	 * <tt>mysqladmin status</tt> command. This includes uptime in seconds and the number of
	 * running threads, questions, reloads, and open tables.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @returns A string describing the server status. \false if an error occurred.
	 */
	public function getStatus() {
		if($this->driver == 'mysqli')
			return $this->dbh->stat();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Returns the thread ID for the current connection.
	 * 
	 * The threadID() function returns the thread ID for the current connection which can then
	 * be killed using killThread() function. If the connection is lost and you reconnect with
	 * ping(), the thread ID will be different. Therefore you should get the thread ID only
	 * when you need it.
	 * 
	 * @note The thread ID is assigned on a connection-by-connection basis. Hence, if the
	 *       connection is broken and then re-established a new thread ID will be assigned. To kill
	 *       a running query you can use the SQL command KILL QUERY processid.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @returns Returns the Thread ID for the current connection.
	 */
	public function getThreadID() {
		if($this->driver == 'mysqli')
			return $this->dbh->thread_id();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Returns whether thread safety is given or not.
	 * 
	 * Tells whether the client library is compiled as thread-safe.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @return \true if the client library is thread-safe, otherwise \false.
	 */
	public function isThreadSafe() {
		if($this->driver == 'mysqli')
			return $this->dbh->thread_safe();
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Returns the number of warnings from the last query for the given link.
	 * 
	 * Returns the number of warnings from the last query in the connection.
	 * 
	 * @throwsUnavailable If using older MySQL driver. See \ref cmmysql_mysqlvsmysqli
	 * 
	 * @return Number of warnings or zero if there are no warnings.
	 * @see getWarnings()
	 */
	public function getWarningCount() {
		if($this->driver == 'mysqli')
			return $this->dbh->warning_count;
		return $this->throwUnavailable("Only available with MySQLi");
	}
	
	/**
	 * @brief Get the database product name
	 * 
	 * @return "MySQL"
	 */
	public function engine() {
		return "MySQL";
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
	 * Erasing a table removes all the entries of the table without affecting the auto incrementing
	 * columns. It is effectivly:
	 * @code
	 * DELETE FROM $tableName WHERE 1;
	 * @endcode
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
		
		$q = $this->query("DELETE FROM `$tableName` WHERE 1");
		return $q->success();
	}
	
	/**
	 * @brief Truncate (not erase) a table.
	 * 
	 * Truncate will not only delete the data in the table but also reset auto incrementing columns.
	 * It is effectivly:
	 * @code
	 * TRUNCATE $tableName;
	 * @endcode
	 * 
	 * @param $tableName The name of the table.
	 * @return \true for success, otherwise \false (such as if the table doesn't exist or you do not have
	 *         adequate privileges.)
	 * @see eraseTable()
	 */
	public function truncateTable($tableName) {
		// need a valid database handle
		if($this->dbh === false)
			return false;
		
		$q = $this->query("TRUNCATE `$tableName`");
		return $q->success();
	}
	
	/**
	 * @brief MySQL \c UPDATE
	 * 
	 * This uses a key-value paired array to construct an \c UPDATE statement like:
	 * @code
	 * $dbh = new CMMySQL("mysql://root:abc123@localhost/test");
	 * $affectedRows = $dbh->update('mytable', array(
	 *             		   'firstname' => 'Robert',
	 *             		   'value' => 45
	 *             		), array(
	 *             		   'firstname' => 'Bob',
	 *             		   'lastname' => 'Smith'
	 *             		);
	 * // SQL executed: UPDATE mytable
	 * //               SET firstname='Robert', value='45'
	 * //               WHERE firstname='Bob' AND lastname='Smith'
	 * @endcode
	 * 
	 * @note Your fields will be safely escaped automatically, if you want a value to be binded that is not
	 *       escaped see CMConstant class.
	 *       
	 * @note This method can still return \c 0 rows affected as a successful result. If you want to test
	 *       the execution success compare it with \false.
	 *       @code
	 *       if($dbh->update(...) === false)
	 *       	die("FAILED!");
	 *       @endcode
	 * 
	 * @param $tableName The table name.
	 * @param $newvalues An associative array of new values.
	 * @param $criteria An associaive array of criteria to filter the \c UPDATE.
	 * @param $a Extra options to pass directly to query()
	 * @return The number of rows affected by teh update will be return, otherwise \false.
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
				$sql .= "$k='" . mysql_real_escape_string($v) . "'";
			
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
					$sql .= "$k='" . mysql_real_escape_string($v) . "'";
				
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
	 * @brief MySQL \c DELETE
	 * 
	 * This uses a key-value paired array to construct a \c DELETE statement like:
	 * @code
	 * $dbh = new CMMySQL("mysql://root:abc123@localhost/test");
	 * $insertID = $dbh->update('mytable', array(
	 *               'firstname' => 'Robert',
	 *               'value' => 45
	 *             ), array(
	 *               'firstname' => 'Bob',
	 *               'lastname' => 'Smith'
	 *             );
	 * // SQL executed: UPDATE mytable
	 * //               SET firstname='Robert', value='45'
	 * //               WHERE firstname='Bob' AND lastname='Smith'
	 * @endcode
	 * 
	 * @note Your fields will be safely escaped automatically, if you want a value to be binded that is not
	 *       escaped see CMConstant class.
	 *       
	 * @note This method can still return \c 0 rows affected as a successful result. If you want to test
	 *       the execution success compare it with \false.
	 *       @code
	 *       if($dbh->update(...) === false)
	 *       	die("FAILED!");
	 *       @endcode
	 * 
	 * @param $tableName The table name.
	 * @param $criteria An associaive array of criteria to filter the \c UPDATE.
	 * @param $a Extra options to pass directly to query()
	 * @return The number of rows affected by teh update will be return, otherwise \false.
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
					$sql .= "$k='" . mysql_real_escape_string($v) . "'";
				
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
		return "`$str`";
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
	
}

?>
