<?php

include_once("CMClass.php");

/**
 * @brief All database connectivity classes implement this interface.
 * 
 * @section cmdatabaseprotocol_desc Description
 * As classes are not required to implement all interface methods, you may use availableMethods() to
 * see which methods work with that database class like:
 * @code
 * $features = $dbh->availableMethods();
 * if(in_array($features, 'getDatabaseTables'))
 *   $q = $dbh->getDatabaseTables();
 * else
 *   echo "Uh-oh, getDatabaseTables() has not been implemented for " . $dbh->engine();
 * @endcode
 * 
 * 
 * @section cmdatabaseprotocol_usage Usage
 * The interface can be inherited from but performs no action or purpose on it own.
 * 
 * 
 * @see CMMySQL
 * @see CMPostgreSQL
 * @see CMOracle
 * 
 * @author Elliot Chance
 * @since 1.0
 */
interface CMDatabaseProtocol extends CMClass {
	
	/**
	 * @brief Perform a query.
	 * 
	 * Perform a query on the database that returns a handle to iterate the results.
	 * For actions that do not require a result use execute().
	 * 
	 * @param $sql SQL
	 * @param $values An associative array of keys that represent field names and their
	 *        respective values.
	 * @param $a An associative array of server options for the query.
	 * @return Query handle.
	 * @see execute()
	 * @see insert()
	 */
	public function query($sql, $values = false, $a = false);
	
	/**
	 * @brief Execute a query (no query handle returned.)
	 * 
	 * Perform a query on the database that does not return a handle.
	 * 
	 * @note For actions that do require a result use query().
	 * 
	 * @param $sql SQL
	 * @param $values An associative array of keys that represent field names and their
	 *        respective values.
	 * @param $a An associative array of server options for the query.
	 * @return \true on success, otherwise \false.
	 * @see query()
	 * @see insert()
	 */
	public function execute($sql, $values = false, $a = false);
	
	/**
	 * @brief Generate and execute an \c INSERT statement.
	 * 
	 * See the full description at \ref manual_databases_iud_insert.
	 * 
	 * This uses a key-value paired array to construct an \c INSERT statement like:
	 * @code
	 * $dbh->insert('mytable', array('a' => 'Something', 'b' => 123.45));
	 * @endcode
	 * 
	 * Will produce and execute the following SQL:
	 * @code
	 * insert into mytable (a, b) values ('Something', '123.45')
	 * @endcode
	 * 
	 * @note This function can return 0 even when the the SQL was successful. To test if the
	 *       statament actually executed successfully use:
	 *       @code
	 *       if($dbh->insert(...) === false)
	 *         die("SQL failed");
	 *       @endcode
	 * 
	 * @param $tableName The name of the table to \c INSERT into. This is directly substituted into
	 *        the SQL using a safe entity name - that is, for example \c "Table" for PostgreSQL,
	 *        \c `Table` for MySQL etc.
	 * @param $kv An associative array of keys that represent field names and their
	 *        respective values.
	 * @param $a An associative array of database specific options for the query. If this is
	 *        available for any particular database, see the documentation for that subclass.
	 * @return If the query was successful the insert ID of the record will be returned. If the
	 *         query failed \false is returned.
	 * @see query()
	 * @see execute()
	 * @see update()
	 * @see delete()
	 */
	public function insert($tableName, $kv = false, $a = false);
	
	/**
	 * @brief \c UPDATE statement.
	 * 
	 * See the full description at \ref manual_databases_iud_update.
	 * 
	 * @note This function can return 0 affected rows even when the the SQL was successful. To test
	 *       if the statament actually executed successfully use:
	 *       @code
	 *       if($dbh->update(...) === false)
	 *         die("SQL failed");
	 *       @endcode
	 * 
	 * @param $tableName The name of the table.
	 * @param $newvalues An associative array of new field data.
	 * @param $criteria An associative array of items to filter the \c WHERE clause with.
	 * @param $a Extra options.
	 * @return \false on failure, or an integer of the number of affected rows.
	 * @see query()
	 * @see execute()
	 * @see insert()
	 * @see delete()
	 */
	public function update($tableName, $newvalues, $criteria = false, $a = false);
	
	/**
	 * @brief \c DELETE statement.
	 * 
	 * See the full description at \ref manual_databases_iud_delete.
	 * 
	 * @note This function can return 0 affected rows even when the the SQL was successful. To test
	 *       if the statament actually executed successfully use:
	 *       @code
	 *       if($dbh->delete(...) === false)
	 *         die("SQL failed");
	 *       @endcode
	 * 
	 * @param $tableName The name of the table.
	 * @param $criteria An associative array of items to filter the \c WHERE clause with.
	 * @param $a Extra options.
	 * @see query()
	 * @see execute()
	 * @see update()
	 * @see insert()
	 */
	public function delete($tableName, $criteria = false, $a = false);
	
	/**
	 * @brief Fetch the list of tables in the active database.
	 * 
	 * Fetch the list of tables in the active database, for the database engines that support
	 * schemas as well the values returned will be:
	 * @code
	 * array('schema1.table1', 'schema1.table2', 'schema2.table1'); // PostgreSQL
	 * array('table1', 'table2', 'table3');                         // MySQL
	 * @endcode
	 * 
	 * @param $schema For databases that support schemas this will only return the tables that
	 *        belong to that schema. It can be omitted to get all tables.
	 * @return An array of tables similar to the example shown above. If the method fails or the
	 *         list of tables could not be retrieved \false is returned.
	 * @see tableExists()
	 * @see getDatabaseNames()
	 */
	public function getTableNames($schema = false);
	
	/**
	 * @brief Check if a table exists.
	 * 
	 * Returns \true if the table exists in the currently active database, otherwise \false.
	 * 
	 * @param $table The name of the table, this should not be quoted or encapsulated and may
	 *               contain the name of the schema before it.
	 * @return \true if the table exists, otherwise \false.
	 * @see getTableNames()
	 */
	public function tableExists($table);
	
	/**
	 * @brief Returns and array of database names.
	 * 
	 * For databases that do not support schemas (eg MySQL) this method will give the same result
	 * as getSchemaNames().
	 * 
	 * @return A simple array of database names not quoted or encapsulated. If the list of
	 *         databases cannot be retrieved then \false is returned.
	 * @see getTableNames()
	 * @see getSchemaNames()
	 */
	public function getDatabaseNames();
	
	/**
	 * @brief Returns and array of schema names.
	 * 
	 * For databases that do not support schemas (eg MySQL) this method will give the same result
	 * as getDatabaseNames().
	 * 
	 * @return A simple array of schema names not quoted or encapsulated. If the list of
	 *         databases cannot be retrieved then \false is returned.
	 * @see getTableNames()
	 * @see getDatabaseNames()
	 */
	public function getSchemaNames();
	
	/**
	 * @brief List the methods implemented by this database protocol.
	 * 
	 * @code
	 * $features = $dbh->availableMethods();
	 * if(in_array($features, 'getDatabaseTables'))
	 *   $q = $dbh->getDatabaseTables();
	 * else echo "Uh-oh, getDatabaseTables() has not been implemented for {$dbh->engine()}";
	 * @endcode
	 * 
	 * @return An array of bare method names.
	 */
	public function availableMethods();
	
	/**
	 * @brief Check if the database is currently active.
	 * 
	 * Ping or otherwise check if the connection is still alive. If this function is not
	 * implemented in the subclass or the database has lost connection \false will be returned.
	 * Otherwise \true will be returned.
	 * 
	 * @return \true if the current connection is still active, otherwise \false.
	 */
	public function isConnected();
	
	/**
	 * @brief Disconnect database handle.
	 * 
	 * @return \true is disconnect is possible, \false is for some reason the action could not be
	 *         taken.
	 */
	public function disconnect();
	
	/**
	 * @brief Turn on/off auto commit.
	 * 
	 * For tranactional database engines. This is used for manual commiting, when inserting large
	 * sets of data or snapshot information its is recommented you turn autocommit off and
	 * manually commit the transaction. This will be faster and more consistent.
	 * 
	 * @param $mode Can be any value that will be evaluated to \true or \false according to the
	 *        rules of PHP and the type of argument provided.
	 * @return \true if the change was made/available, otherwise \false.
	 * @see getAutoCommit()
	 */
	public function setAutoCommit($mode = false);
	
	/**
	 * @brief Return the auto commit status.
	 * 
	 * @return \true or \false.
	 * @see setAutoCommit()
	 */
	public function getAutoCommit();
	
	/**
	 * @brief Commit transaction.
	 * 
	 * Commit a transaction. In most cases you will have to turn autocommit off before passing
	 * your SQL stataments with setAutoCommit(false).
	 * 
	 * @note This method will still return \true for engines that are not transactional.
	 * 
	 * @return \true on success, \false if the transaction could not be commited.
	 * @see setAutoCommit()
	 */
	public function commit();
	
	/**
	 * @brief Rolls back current transaction.
	 * 
	 * Somewhat opposite to the commit() function, this allows a transaction to be rolled back.
	 * 
	 * @note In most cases you must remember to turn autocommit off or else rollback() will not
	 * have a transaction to rollback on.
	 * 
	 * @note This method will still return \true for engines that are not transactional.
	 * 
	 * @return \true on success, \false if the transaction could not be rolled back.
	 * @see setAutoCommit()
	 */ 
	public function rollback();
	
	/**
	 * @brief The name of the database.
	 * 
	 * This is the name of the database product rather than a singular storage engine inside it.
	 * 
	 * @return The name of the database product.
	 */
	public function engine();
	
	/**
	 * @brief Erase (not truncate) a table.
	 * 
	 * Erasing a table removes all the entries of the table without affecting any sequences or auto
	 * incrementing columns. It is effectivly:
	 * @code
	 * DELETE FROM $tableName WHERE 1;
	 * @endcode
	 * 
	 * @param $tableName The name of the table.
	 * @return \true for success, otherwise \false (such as if the table doesn't exist or you do not have
	 *         adequate privileges.)
	 * @see truncateTable()
	 */
	public function eraseTable($tableName);
	
	/**
	 * @brief Truncate (not erase) a table.
	 * 
	 * Truncate will not only delete the data in the table but also reset any sequences and auto
	 * incrementing columns. It is equivilent to cascade drop then recreate the tables and sequences.
	 * 
	 * @param $tableName The name of the table.
	 * @return \true for success, otherwise \false (such as if the table doesn't exist or you do not have
	 *         adequate privileges.)
	 * @see eraseTable()
	 */
	public function truncateTable($tableName);
	
	/**
	 * @brief Escape a string based on the correct rules of the database engine.
	 * 
	 * @param $str The value to be escaped.
	 * @return Escaped string that does not include surrounding quotes.
	 */
	public function escapeString($str);
	
	/**
	 * @brief Escape an entity based on the correct rules of the database engine.
	 *
	 * An entity is a table name, view name, column name, etc. Most databases require a different quote
	 * encapsulation than escapeString().
	 * 
	 * @param $str The value to be escaped.
	 * @return Escaped entity which includes and quotes or encapsulation.
	 */
	public function escapeEntity($str);
	
	/**
	 * @brief Describe the columns in a table.
	 * 
	 * The result is based on the SQL standard information_schema. Using the following table as an
	 * example:
	 * <pre>
	 * CREATE TABLE mytable (
	 *   id integer default 0,
	 *   sometext varchar(255) not null
	 * );
	 * </pre>
	 * 
	 * The result of <tt>information_schema.columns</tt> may look like this (table has been split):
	 * <table>
	 *   <tr>
	 *     <th>table_catalog</th>
	 *     <th>table_schema</th>
	 *     <th>table_name</th>
	 *     <th>column_name</th>
	 *     <th>ordinal_position</th>
	 *     <th>column_default</th>
	 *   </tr>
	 *   <tr>
	 *     <td>postgres </td>
	 *     <td>public </td>
	 *     <td>mytable </td>
	 *     <td>id </td>
	 *     <td> 1</td>
	 *     <td>0 </td>
	 *   </tr>
	 *   <tr>
	 *     <td>postgres </td>
	 *     <td>public </td>
	 *     <td>mytable </td>
	 *     <td>sometext </td>
	 *     <td> 2</td>
	 *     <td></td>
	 *   </tr>
	 * </table>
	 * <table>
	 *   <tr>
	 *     <th>is_nullable</th>
	 *     <th>data_type</th>
	 *     <th>character_maximum_length</th>
	 *     <th>character_octet_length</th>
	 *     <th>numeric_precision</th>
	 *   </tr>
	 *   <tr>
	 *     <td>YES </td>
	 *     <td>integer </td>
	 *     <td></td>
	 *     <td></td>
	 *     <td> 32</td>
	 *   </tr>
	 *   <tr>
	 *     <td>NO</td>
	 *     <td>character varying</td>
	 *     <td> 255</td>
	 *     <td> 1073741824</td>
	 *     <td></td>
	 *   </tr>
	 * </table>
	 * <table>
	 *   <tr>
	 *     <th>numeric_precision_radix</th>
	 *     <th>numeric_scale</th>
	 *     <th>datetime_precision</th>
	 *     <th>interval_type</th>
	 *     <th>interval_precision</th>
	 *   </tr>
	 *   <tr>
	 *     <td>2</td>
	 *     <td> 0</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *   </tr>
	 *   <tr>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *   </tr>
	 * </table>
	 * <table>
	 *   <tr>
	 *     <th>character_set_catalog</th>
	 *     <th>character_set_schema</th>
	 *     <th>character_set_name</th>
	 *     <th>collation_catalog</th>
	 *     <th>collation_schema</th>
	 *   </tr>
	 *   <tr>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *   </tr>
	 *   <tr>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *   </tr>
	 * </table>
	 * <table>
	 *   <tr>
	 *     <th>collation_name</th>
	 *     <th>domain_catalog</th>
	 *     <th>domain_schema</th>
	 *     <th>domain_name</th>
	 *     <th>udt_catalog</th>
	 *     <th>udt_schema</th>
	 *     <th>udt_name</th>
	 *   </tr>
	 *   <tr>
	 *     <td></td>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td>postgres </td>
	 *     <td>pg_catalog</td>
	 *     <td>int4 </td>
	 *   </tr>
	 *   <tr>
	 *     <td></td>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td>postgres </td>
	 *     <td>pg_catalog</td>
	 *     <td>varchar </td>
	 *   </tr>
	 * </table>
	 * <table>
	 *   <tr>
	 *     <th>scope_catalog</th>
	 *     <th>scope_schema</th>
	 *     <th>scope_name</th>
	 *     <th>maximum_cardinality</th>
	 *     <th>dtd_identifier</th>
	 *     <th>is_self_referencing</th>
	 *   </tr>
	 *   <tr>
	 *     <td></td>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td>1 </td>
	 *     <td>NO </td>
	 *   </tr>
	 *   <tr>
	 *     <td></td>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td>2 </td>
	 *     <td>NO </td>
	 *   </tr>
	 * </table>
	 * <table>
	 *   <tr>
	 *     <th>is_identity</th>
	 *     <th>identity_generation</th>
	 *     <th>identity_start</th>
	 *     <th>identity_increment</th>
	 *     <th>identity_maximum</th>
	 *   </tr>
	 *   <tr>
	 *     <td>NO </td>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *   </tr>
	 *   <tr>
	 *     <td>NO </td>
	 *     <td>&nbsp;</td>
	 *     <td></td>
	 *     <td></td>
	 *     <td></td>
	 *   </tr>
	 * </table>
	 * <table>
	 *   <tr>
	 *     <th>identity_minimum</th>
	 *     <th>identity_cycle</th>
	 *     <th>is_generated</th>
	 *     <th>generation_expression</th>
	 *     <th>is_updatable</th>
	 *   </tr>
	 *   <tr>
	 *     <td></td>
	 *     <td></td>
	 *     <td>NEVER</td>
	 *     <td></td>
	 *     <td>YES</td>
	 *   </tr>
	 *   <tr>
	 *     <td></td>
	 *     <td></td>
	 *     <td>NEVER</td>
	 *     <td></td>
	 *     <td>YES</td>
	 *   </tr>
	 * </table>
	 * 
	 * The array returned contains all off the above attributes that can be accessed through the column
	 * number or the column name.
	 * @code
	 * print_r($dbh->describeTable("mytable"));
	 * @endcode
	 * 
	 * <pre>
	 * Array (
	 *   [0] => Array (
	 *     [table_catalog] => postgres
	 *     [table_schema] => public
	 *     [table_name] => mytable
	 *     [column_name] => id
	 *     ...
	 *   ),
	 *   [1] => Array (
	 *     [table_catalog] => postgres
	 *     [table_schema] => public
	 *     [table_name] => mytable
	 *     [column_name] => sometext
	 *     ...
	 *   ),
	 *   [id] => Array (
	 *     [table_catalog] => postgres
	 *     [table_schema] => public
	 *     [table_name] => mytable
	 *     [column_name] => id
	 *     ...
	 *   ),
	 *   [sometext] => Array (
	 *     [table_catalog] => postgres
	 *     [table_schema] => public
	 *     [table_name] => mytable
	 *     [column_name] => sometext
	 *     ...
	 *   )
	 * )
	 * </pre>
	 * 
	 * @return An array as described above.
	 * @param $tableName The name of the table.
	 * @param $a Extra attributes.
	 */
	public function describeTable($tableName, $a = array());
	
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
	public function loadSQLFile($path, $a = array());
	
}

?>
