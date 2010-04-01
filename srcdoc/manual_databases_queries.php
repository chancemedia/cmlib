<?php

/**
 * @page manual_databases_queries 5.3. Queries
 * 
 * @section manual_databases_queries_contents Contents
 * -# \ref manual_databases_queries_query
 * -# \ref manual_databases_queries_binding
 * -# \ref manual_databases_queries_options
 * 
 * 
 * @section manual_databases_queries_query Using query() vs execute()
 * These two method perform the same way with the only difference being that query() returns a new
 * CMQueryProtocol object regardless of the success of the query (so never compare a query() result
 * with \false.) Whereas execute() simply executes the SQL and returns a boolean value of its
 * success.
 * 
 * 
 * @section manual_databases_queries_binding Binding and Constants
 * Binding allows values to be safely substituted into SQL statements based on the quotation rules of
 * the database engine you are using. The bound value are passed as the second parameter to the
 * query() or execute() methods.
 * 
 * A simple example:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $q = $dbh->query("select * from mytable where name=? and age>?", array('Bob', 18));
 * // SQL executed: select * from mytable where name='Bob' and age>'18'
 * @endcode
 * 
 * @note The bound values must be a non-associative array so the order of the bound values fall into
 *       their correct place.
 * 
 * The bound values are not required to be an array, if a single value is passed it will be applied
 * to all bindings:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $q = $dbh->query("select * from person where firstname=? or lastname=?", 'Bob');
 * // SQL executed: select * from person where firstname='Bob' or lastname='Bob'
 * @endcode
 * 
 * Using \false for the bound values will not bind any values regardless of if the string contains the
 * <tt>?</tt> character. This is the default.
 * 
 * You can only bind values and not SQL context statements. So the following will not work:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $q = $dbh->query("select * from ? where 1", 'mytable');
 * // SQL executed: select * from 'mytable' where 1
 * // SQL standard requires entity names to be encapsulated in double-quotes.
 * @endcode
 * 
 * Sometimes you need a bound value to be substituted without escaping it, for example when using
 * expressions. This is possible by using CMConstant:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $q = $dbh->query("update person set updated=? where id=?",
 *                    array(new CMConstant("now()"), 5));
 * // SQL executed: update person set updated=now() where id='5'
 * @endcode
 * 
 * 
 * @section manual_databases_queries_options Query Options
 * Some methods including query(), execute() and insert() allow extra options through the \c $a
 * argument. These options are passed as an array with the following values, in the order they they
 * are executed:
 * <table>
 *   <tr>
 *     <th>Key</th>
 *     <th>Value</th>
 *     <th>Description</th>
 *     <th>Example</th>
 *   </tr>
 *   <tr>
 *     <td>\c print </td>
 *     <td><i>Ignored</i></th>
 *     <td>Print the generated SQL before executing</th>
 *     <td>
 *     @code
 *     $dbh->query("select * from people where firstname=? and age>?",
 *                 array('Bob', 18),
 *                 array('print'));
 *     @endcode
 *     </td>
 *   </tr>
 *   <tr>
 *     <td>\c execute </td>
 *     <td>Boolean value</td>
 *     <td>The SQL is executed based on the boolean value.</td>
 *     <td>
 *     @code
 *     $dbh->query("select * from people where firstname=? and age>?",
 *                 array('Bob', 18),
 *                 array('execute' => true));
 *     @endcode
 *     </td>
 *   </tr>
 *   <tr>
 *     <td>\c die</td>
 *     <td><i>Ignored</i></td>
 *     <td>If the query fails, die with the error message</td>
 *     <td>
 *     @code
 *     $dbh->query("select * from thisTableDoesntExist", false, array('die'));
 *     @endcode
 *     </td>
 *   </tr>
 *   <tr>
 *     <td>\c return </td>
 *     <td><i>Ignored</i></td>
 *     <td>Return the generated SQL instead of the query handle or the result.</td>
 *     <td>
 *     @code
 *     $sql = $dbh->query("select * from people where firstname=? and age>?",
 *                        array('Bob', 18),
 *                        array('return', 'execute' => false));
 *     @endcode
 *     </td>
 *   </tr>
 * </table>
 * 
 */

?>
