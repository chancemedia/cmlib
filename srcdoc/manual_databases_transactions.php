<?php

/**
 * @page manual_databases_transactions 5.7. Transactions
 * 
 * @section manual_databases_transactions_contents Contents
 * -# \ref manual_databases_transactions_transactions
 * -# \ref manual_databases_transactions_mysql
 * 
 * 
 * @section manual_databases_transactions_transactions Transactions
 * The only difference with using transactions if that you turn off the auto commit before you execute
 * your queries then commit it at the end:
 * @code
 * $dbh = new CMMySQL("mysql://bob:abc123@localhost/mydb");
 * $dbh->setAutoCommit(false);   // turn auto commit off, effectivly starting a new transaction
 * // ... do some queries and execute some stuff as usual
 * if(!$dbh->commit()) {
 *   $dbh->rollback();
 *   die("Oops! There must of been something that went wrong in the transaction!");
 * } else echo "Transaction committed";
 * $dbh->setAutoCommit(true);    // optional, turn the auto commit back on
 * @endcode
 * 
 * 
 * @section manual_databases_transactions_mysql Transactions with MySQL
 * Not all storage engines in MySQL are transactional. Your transactions will still work, however if
 * a table using the MyISAM engine is modified during a transaction the change is immediatly
 * permanent, committing or rolling back will not undo the change.
 * 
 */

?>
