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
 * else echo "Uh-oh, getDatabaseTables() has not been implemented for " . $dbh->engine();
 * @endcode
 * 
 * 
 * @section cmdatabaseprotocol_usage Usage
 * The interface can be inherited from but performs no action or purpose on it own.
 * 
 * 
 * @section cmdatabaseprotocol_spec Database Protocol Specification
 * @note This includes the specification for the relevant CMQueryProtocol classes.
 * 
 * <table>
 *   <tr>
 *     <th>Name</th>
 *     <th>Description</th>
 *   </tr>
 *   <tr>
 *     <td>\c DB001</td>
 *     <td>A connection can be made through the constructor via a URI.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB002</td>
 *     <td>CMDatabaseProtocol::availableMethods() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB003</td>
 *     <td>CMDatabaseProtocol::commit() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB004</td>
 *     <td>CMDatabaseProtocol::disconnect() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB005</td>
 *     <td>CMDatabaseProtocol::engine() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB006</td>
 *     <td>CMDatabaseProtocol::eraseTable() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB007</td>
 *     <td>Conforms to CMError.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB008</td>
 *     <td>CMDatabaseProtocol::execute() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB009</td>
 *     <td>CMDatabaseProtocol::getDatabaseNames() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB010</td>
 *     <td>CMDatabaseProtocol::getSchemaNames() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB011</td>
 *     <td>CMDatabaseProtocol::getTableNames() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB012</td>
 *     <td>CMDatabaseProtocol::insert() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB013</td>
 *     <td>CMDatabaseProtocol::isConnected() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB014</td>
 *     <td>CMDatabaseProtocol::query() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB015</td>
 *     <td>CMDatabaseProtocol::rollback() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB016</td>
 *     <td>CMDatabaseProtocol::setAutoCommit() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB017</td>
 *     <td>CMDatabaseProtocol::tableExists() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB018</td>
 *     <td>CMDatabaseProtocol::truncateTable() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB019</td>
 *     <td>Bind values to CMDatabaseProtocol::query() and CMDatabaseProtocol::execute().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB020</td>
 *     <td>Accept a CMFormatter on CMQueryProtocol::fetch().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB021</td>
 *     <td>Accept a CMFormatter on CMQueryProtocol::fetchAll().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB022</td>
 *     <td>Accept a row type on CMQueryProtocol::fetch() (\ref manual_databases_fetch_fetch)</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB023</td>
 *     <td>Accept a direction on CMQueryProtocol::fetchAll() (\ref manual_databases_fetch_fetchall)
 *         </td>
 *   </tr>
 *   <tr>
 *     <td>\c DB024</td>
 *     <td>Conforms to \ref manual_databases_queries_options.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB025</td>
 *     <td>Implements CMQueryProtocol::affectedRows().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB026</td>
 *     <td>Implements CMQueryProtocol::availableMethods().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB027</td>
 *     <td>Implements CMQueryProtocol::fetch().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB028</td>
 *     <td>Implements CMQueryProtocol::fetchAll().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB029</td>
 *     <td>Implements CMQueryProtocol::success().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB030</td>
 *     <td>Implements CMQueryProtocol::totalRows().</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB031</td>
 *     <td>CMDatabaseProtocol::update() implemented.</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB032</td>
 *     <td>CMDatabaseProtocol::delete() implemented.</td>
 *   </tr>
 * </table>
 * 
 * 
 * @section cmdatabaseprotocol_driver Database Driver Implementation
 * <table>
 *   <tr>
 *     <td>Name</td>
 *     <td>\c CMMySQL</td>
 *     <td>\c CMOracle</td>
 *     <td>\c CMPostgreSQL</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB001</td>
 *     <td>\yes</td>
 *     <td>\yes</td>
 *     <td>\yes</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB002</td>
 *     <td>\yes</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB003</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB004</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB005</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB006</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB007</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB008</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB009</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB010</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB011</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB012</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB013</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB014</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB015</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB016</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB017</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB018</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB019</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB020</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB021</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB022</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB023</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB024</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB025</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB026</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB027</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB028</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB029</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB030</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB031</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>\c DB032</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *     <td>&nbsp;</td>
 *   </tr>
 * </table>
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
	 */
	public function setAutoCommit($mode = false);
	
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
	
}

?>
