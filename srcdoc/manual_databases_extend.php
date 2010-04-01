<?php

/**
 * @page manual_databases_extend 5.8. Custom Engines
 * 
 * @section manual_databases_extend_contents Contents
 * -# \ref manual_databases_extend_intro
 * -# \ref manual_databases_extend_how
 * 
 * @section manual_databases_extend_intro Introduction
 * You are able to implement your own database engines that allow native integration with all of the
 * CMLIB classes by simply extending two classes with CMDatabaseProtocol and CMQueryProtocol
 * respectivly.
 * 
 * @section manual_databases_extend_how How?
 * First you must create your database communication class:
 * @code
 * include_once("CMDatabaseProtocol.php");
 * 
 * class MyDatabase implements CMDatabaseProtocol {
 *   // You must implement all methods according to PHP rules. However you may only need to make
 *   // some of them functional, the rest simply return false.
 * }
 * @endcode
 * 
 * Next you will need to create a query handle class:
 * @code
 * include_once("CMQueryProtocol.php");
 * 
 * class MyQueryHandle implements CMQueryProtocol {
 *   // Again, you must implement all methods according to PHP rules. However you may only need to
 *   // make some of them functional, the rest simply return false.
 * }
 * @endcode
 * 
 * If all goes well you should be able to use it immediatly with all of the other CMLIB classes:
 * @code
 * include_once("CMForm.php");
 * include_once("MyDatabase.php");
 * 
 * $md = new MyDatabase("foo://bar@localhost");
 * 
 * echo CMForm::Menu(array(
 *   'name' => 'myfield',
 *   'data' => $md->query("select * from whatever")
 * ));
 * @endcode
 * 
 */

?>
