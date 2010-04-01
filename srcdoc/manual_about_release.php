<?php

/**
 * @page manual_about_release 1.1. Release Procedure
 * 
 * The following ordered steps must be taken before each beta or stable release.
 * -# Internal \c build.php script run.<br>
 *    This will compile all the files for the \c bin folder, run \c testall.php, then run a sloc counter
 *    based on \c CMSLOC.
 * -# The full testing output is put into Manual > About > Testing.
 * -# Doxygen is run, making sure it reports no documentation errors.
 * -# \c doc, \c bin and \c src are packaged with a version number like <tt>cmlib-1.0a1.zip</tt>
 * 
 */

?>
