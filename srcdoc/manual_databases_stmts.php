<?php

/**
 * @page manual_databases_stmts 5.6. Prepared Statements
 * 
 * @section manual_databases_stmts_contents Contents
 * -# \ref manual_databases_stmts_prepare
 * 
 * @section manual_databases_stmts_prepare Prepared Statements
 * Some database engines support the use of prepared statements. A prepared statement is a statement
 * that can be reused by changing the binding parameters. To add consistency with PHP, prepared
 * statements will implement the PHP PDO interfaces.
 * 
 * @note execute() with prepared statements belongs to a subclass of CMStatementProtocol and is not
 *       the same as the execute() method for CMDatabaseProtocol.
 *       
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $s = $dbh->prepare("insert into mytable (name, value) values (?, ?)");
 * $s->execute(array("Bob", 25));
 * $s->execute(array("John", 33));
 * @endcode
 * 
 * Prepared statements are more efficient when reusing the same SQL command many times. For instance,
 * when using Oracle to load data into a table you will want to use a prepared statement inside a
 * transaction which will be much faster and safer than issing many single \c INSERTs.
 * 
 */

?>
