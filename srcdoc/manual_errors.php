<?php

/**
 * @page manual_errors 2. Error Handling
 * 
 * @section manual_errors_subpages Subpages
 * -# \subpage manual_errors_usage
 * -# \subpage manual_errors_extending
 * 
 * 
 * @section manual_errors_contents Contents
 * -# \ref manual_errors_intro
 * -# \ref manual_errors_work
 * -# \ref manual_errors_types
 * 
 * 
 * @section manual_errors_intro Introduction
 * CMLIB has a complete error tracking and reporting system that can be extended into your own scripts
 * seamlessly.
 * 
 * 
 * @section manual_errors_work How Does It Work?
 * CMError is broken down in two major concepts:
 * - Errors are thrown from somewhere and each error carries a level (how serious the error is), a
 *   message string (reporting what actually happened) and any number of associative objects attached
 *   via name (called attributes).
 * - Errors are thrown from somewhere to a stack. By default each instance of each class that inherits
 *   the CMError class has its own error stack, but you are free to create your own stacks and
 *   divert existing class instances to a central stack. An example of this would be if you had
 *   multiple database connections. By creating your own separate stack then connecting all the
 *   database classes to your stack you would be able to handle all the database errors in one central
 *   place.
 * 
 * 
 * @section manual_errors_types Types of Errors
 * Here is a generalised description of the different levels of errors that can be thrown:
 * <table>
 *   <tr>
 *     <th>Name</th>
 *     <th>Description</th>
 *   </tr>
 *   <tr>
 *     <td>\c Debug</td>
 *     <td>These messages are for printing out very finite details about an action that may not of
 *         even needed to report an error but the messages are relevant to the debugging developer.
 *         </td>
 *   </tr>
 *   <tr>
 *     <td>\c Notice</td>
 *     <td>General information about something that has occured (success or failure) that doesn't
 *         cause any problems but a tip or message for the developer.</td>
 *   </tr>
 *   <tr>
 *     <td>\c Unavailable</td>
 *     <td>Are thrown when a function that may conform to an interface but does not do anything. Such as a
 *         database method that is not available with the driver you are using.</td>
 *   </tr>
 *   <tr>
 *     <td>\c Warning</td>
 *     <td>A non-fatal action has occured, either the class ignored it, did it a different way or
 *         canceled the action. These messages should be noted and fixed where possible.</td>
 *   </tr>
 *   <tr>
 *     <td>\c Deprecated</td>
 *     <td>You should not be using this method or function as it may be removed, renamed or redundant in
 *         a future release.</td>
 *   </tr>
 *   <tr>
 *     <td>\c Error</td>
 *     <td>A non-fatal action has occured that must be attended to. Such as dividing by zero.</td>
 *   </tr>
 *   <tr>
 *     <td>\c Exception</td>
 *     <td>A non-fatal action has occured and thrown an exception with an explanation. If there is
 *         no try/catch block in place the script with exit.</td>
 *   </tr>
 *   <tr>
 *     <td>\c Fatal</td>
 *     <td>The script is not recoverable or being used in a way that is impossible. The script will
 *         print an error message and force exit.</td>
 *   </tr>
 * </table>
 * 
 */

?>
