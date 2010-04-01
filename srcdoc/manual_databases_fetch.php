<?php

/**
 * @page manual_databases_fetch 5.4. Fetching Data
 * 
 * @section manual_databases_fetch_contents Contents
 * -# \ref manual_databases_fetch_fetch
 * -# \ref manual_databases_fetch_fetchall
 * 
 * 
 * @section manual_databases_fetch_fetch Fetching Data
 * Data from a query handle can be retrived in a few ways, the simplest way is to use the fetch()
 * method like;
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $q = $dbh->query("select * from mytable");
 * while($r = $q->fetch()) {
 *   echo $r['name'], "\n";
 * }
 * @endcode
 * 
 * With the default options fetch() will return the new row from the result set an associative array,
 * that is with the names of the fields as the keys and respective values. There are extra parameters
 * that can be passed to fetch() to get a different desired result:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $q = $dbh->query("select id, name, value from mytable");
 * while($r = $q->fetch('line')) {
 *   echo $r[1], "\n"; // the 'name' field.
 * }
 * @endcode
 * 
 * The list of row types are as follows:
 * <table border>
 * 	<tr>
 * 		<td>\c 'assoc'</td>
 * 		<td>Associative array. This is the default</td>
 * 	</tr>
 * 	<tr>
 * 		<td>\c 'line'</td>
 * 		<td>Non-associative array.</td>
 * 	</tr>
 * 	<tr>
 * 		<td>\c 'pair'</td>
 * 		<td>First and second column become key-value.</td>
 * 	</tr>
 * 	<tr>
 * 		<td>\c 'cell'</td>
 * 		<td>Only use the first column and return it as a scalar not an array.</td>
 * 	</tr>
 * </table>
 * 
 * Another example using \c 'cell' to fetch a single value:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $q = $dbh->query("select name from mytable where id=? limit 1", 5);
 * $name = $q->fetch('cell'); // $name is "Bob"
 * @endcode
 * 
 * The second parameter that can be passed is a CMFormatter, see \ref manual_databases_fmt_intro
 * below.
 * 
 * 
 * @section manual_databases_fetch_fetchall Fetching All Data
 * You may fetch all the data from a query with the fetchAll() method. Just like with fetch(), you
 * can attach a row mode and formatter, but with a third option to determine the direction of how
 * the database rows are joined. The possible values are:
 * <table border>
 * 	<tr>
 * 	  <td>\c 'horizontal'</td>
 * 	  <td>Each row is appended to the return array. This is the default</td>
 * 	</tr>
 * 	<tr>
 * 	  <td>\c 'vertical'</td>
 * 	  <td>All the rows are appended in a single linear array.</td>
 * 	</tr>
 * 	<tr>
 * 	  <td>\c 'single'</td>
 * 	  <td>Only use the first row.</td>
 * 	</tr>
 * </table>
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
 */

?>
