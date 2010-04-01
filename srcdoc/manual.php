<?php

/**
 * @page manual Manual
 *
 *
 * @section manual_subpages Subpages
 * -# \subpage manual_about
 * -# \subpage manual_errors
 * -# \subpage manual_html
 * -# \subpage manual_fmt
 * -# \subpage manual_databases
 * -# \subpage manual_dm
 * -# \subpage manual_file
 * 
 * 
 * @section manual_contents Contents
 * -# \ref manual_naming
 * 
 * 
 * @section manual_naming Naming Conventions
 * Classes that are part of the core CMLIB codebase will begin with \c CM. This does not affect any
 * functionality, it is for consistency and protecting against classes with the same name clashing with
 * classes from CMLIB.
 * 
 * All of the public and private variables and methods follow the same capitalisation. Each word
 * starts with a capital letter. The first word only has a capital letter if it is static. Some
 * examples:
 * @code
 * public function doSomethingCool() { ... }
 * private function maybeDoSomethingElse() { ... }
 * public $someVariable
 * private $anotherVariableWithAReallyLongName
 * public static function BlaBla() { ... }
 * private static function MyStaticMethod() { ... }
 * @endcode
 * 
 */

?>
