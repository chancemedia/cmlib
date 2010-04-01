<?php

/**
 * @page manual_errors_usage 2.1. Usage
 * 
 * @section manual_errors_usage_contents Contents
 * -# \ref manual_errors_usage_create
 * -# \ref manual_errors_usage_deal
 * -# \ref manual_errors_usage_silent
 * -# \ref manual_errors_usage_redirect
 * -# \ref manual_errors_usage_exit
 * 
 * 
 * @section manual_errors_usage_create Creating an Independant Error Stack
 * @code
 * include_once("CMError.php");
 * 
 * // create a new error stack
 * $e = new CMError();
 * $e->setVerboseLevel(CMErrorType::Fatal); // only print the error if fatal
 * 
 * // a function that simply divides 2 numbers safely
 * function divide($a, $b) {
 *   global $e;
 *   if($b == 0) {
 *     $e->throwError("Cannot divide by zero!");
 *     return 0;
 *   }
 *   return $a / $b;
 * }
 * 
 * // now do some work
 * echo divide(15, 3), "\n";
 * echo divide(7, 0), "\n";
 * echo divide(3, 0), "\n";
 * echo divide(10, 2), "\n";
 * 
 * // lets see if anything we wrong
 * if($e->isErrors()) {
 *   echo "There were ", $e->countErrors(), " errors:\n";
 *   foreach($e->errors() as $error)
 *   	CMError::PrintError($error);
 * }
 * @endcode
 * 
 * 
 * @section manual_errors_usage_deal Dealing With Errors on a Stack
 * To clear a stack of all its errors you can invoke \c dealtWithAll() like:
 * @code
 * $e = new CMError();
 * // ... do some stuff to put errors on the stack
 * $e->dealtWithAll();
 * // continue the script with $e being empty.
 * @endcode
 * 
 * 
 * @section manual_errors_usage_silent Silent Errors
 * In the example above we see:
 * @code
 * $e->setVerboseLevel(CMErrorType::Fatal);
 * @endcode
 * This tells the error stack to be quiet when a error of any kind is thrown. By default this is set
 * to \c CMErrorType::Warning, so anything above or equal to the seriousness of a Warning will be
 * immediatly printed to the page.
 * 
 * 
 * @section manual_errors_usage_redirect Redirecting/Pooling Errors From Multiple Objects
 * Sometimes you may want to redirect all the errors from some or all objects into a central stack.
 * There is a few ways this can be done based on what you require.
 * 
 * The first way is to tell each object (that has an error stack) to send its errors somewhere else.
 * The second way is when you tell PHP "every single object (past and future) direct all your error
 * messages to this instance."
 * 
 * Lets have a look at the first way of redirecting messages:
 * @code
 * // create 2 error stacks
 * $e1 = new CMError();
 * $e2 = new CMError();
 * 
 * // tell $e1 to direct all its error messages to $e2
 * $e1->useErrorStack($e2);
 * 
 * // throw an error message to each
 * $e1->throwError("First error");
 * $e2->throwError("Second error");
 * 
 * // be careful here: this will look like 4 errors because both errors have been sent to $e2
 * // aswell as $e1 pointing to $e2, so $e1 will actually return $e2's errors.
 * 
 * // lets see if anything we wrong
 * if($e2->isErrors()) {
 *   echo "There were ", $e2->countErrors(), " errors:\n";
 *   foreach($e2->errors() as $error)
 *   	CMError::PrintError($error);
 * }
 * @endcode
 * 
 * There is no limit to how many objects can pass their error messages to a central error stack. It is
 * also possible for messages for messages to be redirected through multiple objects, so be careful
 * your error messages don't get caught in an infinite cycle.
 * 
 * The same code above can be applied to objects that inherit a stack, a good example of this is a
 * database connection. It might be easier to pool all of your database connections into a single
 * error stack:
 * @code
 * // create our database aggregate error stack
 * $dbErrors = new CMError();
 * 
 * // create 2 database connections
 * $db1 = new MySQL(...);
 * $db2 = new Oracle(...);
 * 
 * // tell the database connections to use $dbErrors instead of there own error stacks
 * $db1->useErrorStack($dbErrors);
 * $db2->useErrorStack($dbErrors);
 * 
 * // ... do some stuff ...
 * 
 * // lets see if anything we wrong
 * if($e2->isErrors()) {
 *   echo "There were ", $e2->countErrors(), " errors:\n";
 *   foreach($e2->errors() as $error)
 *   	CMError::PrintError($error);
 * }
 * @endcode
 * 
 * The second way is to automatically redirect all objects and objects that inherit an error stack
 * to use the global stack:
 * @code
 * // create a stack and define it as the stack for ALL objects created after or before this point
 * $allErrors = new CMError();
 * CMError::SetGlobalStack($allErrors);
 * 
 * // create two new stacks, which will automatially have their stack changed to $allErrors
 * $e1 = new CMError();
 * $e2 = new CMError();
 * 
 * // throw an error message to each
 * $e1->throwError("First error");
 * $e2->throwError("Second error");
 * 
 * // now lets check out global stack
 * if($allErrors->isErrors()) {
 *   echo "There were ", $allErrors->countErrors(), " errors:\n";
 *   foreach($allErrors->errors() as $error)
 *   	CMError::PrintError($error);
 * }
 * @endcode
 * 
 * 
 * @section manual_errors_usage_exit Changing the Exit Level
 * In most cases you only want your script to exit when something unrecoverable or very illegal has
 * happened. But you can turn up the strictness level so that scipt will force exit at a level below
 * Fatal.
 * 
 * For example, imagine you have a script that opens a database connection, read the daily \c expense
 * table and reports the total for the day. If you are unable to make a connection with the database
 * theres no need to proceed, or manually add in error checking. The problem should be reported and
 * the script exited:
 * @code
 * // as this is a simple script, we can just use a global error stack
 * $allErrors = new CMError();
 * CMError::SetGlobalStack($allErrors);
 * 
 * // lets be strict and attempt to open the database
 * $allErrors->setExitLevel(CMErrorType::Warning);
 * $dbh = new CMMySQL(...);
 * 
 * // If the connection was unsuccessful it would of thrown a Warning that was redirected to the
 * // global error stack and because we've told it to exit on Warnings or higher the script will
 * // exit.
 * // If we make it to this point then the connection was successful and we continue the script
 * // knowing that $allErrors will take care of any future errors aswell.
 * @endcode
 * 
 */

?>
