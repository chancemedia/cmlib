<?php

/**
 * @page manual_about_release 1.1. Acquiring and Updating Procedure
 * 
 * 
 * @section manual_about_release_contents Contents
 * -# \ref manual_about_release_intro
 * -# \ref manual_about_release_install
 * -# \ref manual_about_release_update
 * 
 * 
 * @section manual_about_release_intro Introduction
 * 
 * cmlib is maintained at a central git repository at http://www.github.com/chancemedia/cmlib.
 * 
 * 
 * @section manual_about_release_install First Time Installation
 * 
 * If you are installing a new copy of cmlib you can install it from two main methods:
 * 
 * 1. Use:
 * 
 * <code>$ git clone git://github.com/chancemedia/cmlib.git</code>
 * 
 * 2. Goto the download page at http://github.com/chancemedia/cmlib/downloads and download the latest
 * stable tag.
 * 
 * Do not change any files in your cmlib/ directory or future updates will be overridden.
 * 
 * 
 * @section manual_about_release_update Updating
 * 
 * It is recommended you use git to update:
 * 
 * <code>$ cd change/to/inside/cmlib/</code>
 * 
 * <code>$ git pull</code>
 * 
 * Once all the latest changes have been downloaded you want to use to choose the latest stable tag so that
 * you are not left with debug or bleeding edge code.
 * <pre>$ git tags
v1.0a1
v1.0a2
v1.0
v1.2
v1.2.1
v1.3b</pre>
 * 
 * Select the latest stable release version "v1.2.1" and checkout the tag. This will move your cmlib version
 * to this snapshot in time.
 * 
 * <code>$ git checkout v1.2.1</code>
 * 
 * And your ready to go.
 * 
 */

?>
