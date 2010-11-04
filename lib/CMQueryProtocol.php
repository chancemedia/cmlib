<?php

include_once("CMClass.php");

/**
 * @brief Database query interface.
 * 
 * @section cmqueryprotocol_desc Description
 * To make the results from different databases compatible with the same set of generic
 * methods all databases that return a database query return it in a class that fits to
 * this protocol.
 * 
 * 
 * @section cmqueryprotocol_formatter Using a formatter on indervidual fetch() calls
 * You may optionally attach a formatter that will process your results before they are returned. But
 * only on the fetch() calls the formatter is attached to:
 * @code
 * $f = new CMFormatter(array(
 *        'created' => 'timestamp|F j, Y, g:i a',
 *        'cost' => 'number|fixed=2|thousands=,|pre=$'
 *      ));
 *      
 * $q = $dbh->query("select * from mytable where cost>? and productname=?",
 *                  array(100, 'Magic Carpet'));     // bind values
 * 
 * // retrive, format and return the next result row
 * while($r = $q->fetch('assoc', $f)) {
 *   print_r($r);
 * }
 * 
 * // Array
 * // (
 * //     [productname] => Magic Carpet
 * //     [colour] => Blue
 * //     [created] => March 5, 2010, 3:35 pm
 * //     [cost] => $450.00
 * // )
 * // Array
 * // (
 * //     [productname] => Magic Carpet
 * //     [colour] => Green
 * //     [created] => March 10, 2010, 11:52 am
 * //     [cost] => $429.00
 * // )
 * @endcode
 * 
 * Alternativly you can attach the formatter to the query so that allow rows are passed through the
 * same formatter. See \ref manual_databases_fmt_intro
 * 
 * @author Elliot Chance
 */
interface CMQueryProtocol extends CMClass {
	
	/**
	 * @brief Check if the query was successful.
	 * 
	 * Returned if the database engine that created the query handle was unable to
	 * execute the query. You can see the last error with CMQueryProtocol::error() like;
	 * @code
	 * $q = $dbh->query("select * from mytable"); // mytable does not exist
	 * if($q->success)
	 * 	die("Failed: " . $q->error());
	 * @endcode
	 * 
	 * CMQueryProtocol::$QueryFailed is an alias for <tt>false</tt> for compatibility and
	 * ease of use. Hence, the above example is the same as;
	 * 
	 * @code
	 * $q = $dbh->query("select * from mytable"); // mytable does not exist
	 * if(!$q)
	 * 	die("Failed: " . $q->error());
	 * @endcode
	 * 
	 * @code
	 * // mytable does not exist
	 * $q = $dbh->query("select * from mytable") or die("Failed: " . $q->error());
	 * @endcode
	 */
	public function success();
	
	/**
	 * @brief Return the next result row from the query as an associative array.
	 * 
	 * Once all the rows in the result set have been interated <tt>false</tt> is returned.
	 * 
	 * @code
	 * $q = $dbh->query("select * from mytable");
	 * while($r = $q->fetch()) {
	 *   print_r($r);
	 * }
	 * @endcode
	 * 
	 * @param $rowMode How each row is converted into an array.
	 * 		<table border>
	 * 			<tr>
	 * 				<td><tt>'assoc'</tt></td>
	 * 				<td>Associative array. This is the default</td>
	 * 			</tr>
	 * 			<tr>
	 * 				<td><tt>'line'</tt></td>
	 * 				<td>Non-associative array.</td>
	 * 			</tr>
	 * 			<tr>
	 * 				<td><tt>'row'</tt></td>
	 * 				<td>Associative and non-associative array.</td>
	 * 			</tr>
	 * 			<tr>
	 * 				<td><tt>'pair'</tt></td>
	 * 				<td>First and second column become key-value.</td>
	 * 			</tr>
	 * 			<tr>
	 * 				<td><tt>'cell'</tt></td>
	 * 				<td>Only use the first column.</td>
	 * 			</tr>
	 * 		</table>
	 * 
	 * @param $formatter Attach an optional CMFormatter.
	 * @return The return value(s) and type(s) depend on the arguments given.
	 */
	public function fetch($rowMode = 'assoc', $formatter = false);
	
	/**
	 * @brief Fetch all rows.
	 * 
	 * An example of using \c 'vertical' row direction and \c 'cell' to get a single array of IDs:
	 * @code
	 * $dbh = new CMMySQL("mysql://root:abc123/test");
	 * $q = $dbh->query("select id from mytable limit 5");
	 * $ids = $q->fetchAll('cell', 'vertical'); // $ids = array(1, 5, 7, 9, 10)
	 * @endcode
	 * 
	 * Or shorten the above code into a single line:
	 * @code
	 * $dbh = new CMMySQL("mysql://root:abc123/test");
	 * $ids = $dbh->query("select id from mytable limit 5")->fetchAll('cell', 'vertical');
	 * @endcode
	 * 
	 * @param $rowMode How each row is converted into an array.
	 * 		<table border>
	 * 			<tr>
	 * 				<td><tt>'assoc'</tt></td>
	 * 				<td>Associative array. This is the default</td>
	 * 			</tr>
	 * 			<tr>
	 * 				<td><tt>'line'</tt></td>
	 * 				<td>Non-associative array.</td>
	 * 			</tr>
	 * 			<tr>
	 * 				<td><tt>'pair'</tt></td>
	 * 				<td>First and second column become key-value.</td>
	 * 			</tr>
	 * 			<tr>
	 * 				<td><tt>'cell'</tt></td>
	 * 				<td>Only use the first column.</td>
	 * 			</tr>
	 * 		</table>
	 * 
	 * @param $direction Fetching direction.
	 *        <table border>
	 *        	<tr>
	 *        	  <td>\c 'horizontal'</td>
	 *        	  <td>Each row is appended to the return array. This is the default</td>
	 *        	</tr>
	 *        	<tr>
	 *        	  <td>\c 'vertical'</td>
	 *        	  <td>All the rows are appended in a single linear array.</td>
	 *        	</tr>
	 *        	<tr>
	 *        	  <td>\c 'single'</td>
	 *        	  <td>Only use the first row.</td>
	 *        	</tr>
	 *        </table>
	 * @param $formatter Applies a formatting option to all of the cells in the result set.
	 * @see fetch()
	 * @see CMFormatter::format()
	 */
	public function fetchAll($rowMode = 'assoc', $direction = 'horizontal', $formatter = false);
	
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
	public function availableMethods();
	
	/**
	 * @brief Returns the number of affected rows in this query.
	 * 
	 * If this query did not affect any rows 0 is returned.
	 * 
	 * @return The number of rows affected by this query.
	 */
	public function affectedRows();
	
	/**
	 * @brief Total number of rows in the result set.
	 * 
	 * If the query failed then 0 is returned.
	 * 
	 * @return The number of rows in the result set.
	 */
	public function totalRows();
	
}

?>
