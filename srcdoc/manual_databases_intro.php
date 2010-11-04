<?php

/**
 * @page manual_databases_intro 5.1. Introduction
 * 
 * @section manual_databases_intro_contents Contents
 * -# \ref manual_databases_intro_dbs
 * -# \ref manual_databases_intro_interface
 * -# \ref manual_databases_intro_features
 * 
 * @section manual_databases_intro_dbs Supported Databases
 * The current supported databases supported by CMLIB are:
 * <table>
 *   <tr>
 *     <th>Name</th>
 *     <th>CMLIB Class</th>
 *     <th>Database Server Version</th>
 *     <th>Notes</th>
 *   </tr>
 *   <tr>
 *     <td>MySQL</td>
 *     <td>CMMySQL</td>
 *     <td>3.23+</td>
 *     <td>CMMySQL will attempt to use the newer PHP MySQLi driver where possible, otherwise the
 *         standard MySQL driver with slightly less features will come into affect. This is
 *         transparent to the PHP coder.</td>
 *   </tr>
 *   <tr>
 *     <td>Oracle</td>
 *     <td>CMOracle</td>
 *     <td>8i and above</td>
 *     <td>&nbsp;</td>
 *   </tr>
 *   <tr>
 *     <td>PostgreSQL</td>
 *     <td>CMPostgreSQL</td>
 *     <td>6.5 and above</td>
 *     <td>PostgreSQL 8.0+ required for extra module features.</td>
 *   </tr>
 * </table>
 * 
 * @section manual_databases_intro_interface Database Interface
 * CMLIB has two primary interfaces CMDatabaseProtocol and CMQueryProtocol that make database
 * communication and functionality as consistent as possible throughout all the support database
 * engines. If you are unfamilar with this concept (like JDBC) it is easiest to explain with examples
 * further through this manual.
 * 
 * 
 * @section manual_databases_intro_features How Can Every Database Support EVERY Feature?
 * Simple answer - it can't.
 * 
 * Longer answer - as part of the CMDatabaseProtocol and CMQueryProtocol there is a method in each
 * called availableMethods(). You can use this to test if any method at any point in time is supported
 * by the database engine:
 * @code
 * $features = $dbh->availableMethods();
 * if(in_array($features, 'getDatabaseTables'))
 *   $q = $dbh->getDatabaseTables();
 * else echo "Uh-oh, getDatabaseTables() has not been implemented for " . $dbh->engine();
 * @endcode
 * 
 * The same applies with the query handle:
 * @code
 * $q = $dbh->query("select * from mytable");
 * if(!in_array('totalRows', $q->availableMethods()))
 *   echo "Hmm, we can't get the total rows for this query. It may be a cursor of some sort?";
 * @endcode
 * 
 * You can get more information about each method by looking at the specific documentation, for example
 * CMMySQL::totalRows().
 * 
 */

?>
