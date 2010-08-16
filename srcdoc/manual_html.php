<?php

/**
 * @page manual_html 3. HTML & CSS
 * 
 * @section manual_html_subpages Subpages
 * -# \subpage manual_html_form
 * -# \subpage manual_html_table
 * 
 * 
 * @section manual_html_contents Contents
 * -# \ref manual_html_table
 * 
 * 
 * @section manual_html_table Building a Table From a Database Query
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123@localhost/test");
 * echo CMHTML::Table(array(
 *   'header' => array('ID', 'First name', 'Last name'),
 *   'data' => $dbh->query("select * from dummy")
 * ));
 * @endcode
 * 
 */

?>
