<?php

/**
 * @page manual_databases_connecting 5.2. Connecting
 * 
 * @section manual_databases_connecting_contents Contents
 * -# \ref manual_databases_connecting_connect
 * -# \ref manual_databases_connecting_change
 * 
 * @section manual_databases_connecting_connect Connecting to a Database
 * A connection to a database is made through a URI passed to the constructor.
 * @code
 * // connect
 * $dbh = new CMMySQL("mysql://bob:abc123@localhost/mydb");
 * if($dbh->isErrors())
 *   die("Could not connect to the database: " . $dbh->printErrors());
 * @endcode
 * 
 * @section manual_databases_connecting_change Changing the Database Engine
 * As long as your SQL statements and various other coding is compatible with a different daatabase
 * engine you can change your whole project by simply issuing a different class and URI. So from the
 * example above:
 * @code
 * // connect
 * $dbh = new CMOracle("oracle://bob:abc123@localhost/mydb");
 * if($dbh->error())
 *   die("Could not connect to the database: " . $dbh->error());
 * @endcode
 * 
 */

?>
