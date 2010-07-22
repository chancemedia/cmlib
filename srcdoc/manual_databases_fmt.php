<?php

/**
 * @page manual_databases_fmt 5.8. Formatter
 * 
 * @section manual_databases_fmt_contents Contents
 * -# \ref manual_databases_fmt_intro
 * 
 * @section manual_databases_fmt_intro Using a Formatter
 * You may optionally attach a formatter that will process your results before they are returned.
 * @code
 * $f = new CMFormatter(array(
 *        'created' => 'timestamp|F j, Y, g:i a',
 *        'cost' => 'number|fixed=2|thousands=,|pre=$'
 *      ));
 *      
 * $q = $dbh->query("select * from mytable where cost>? and productname=?",
 *                  array(100, 'Magic Carpet'),    // bind values
 *                  array('formatter' => $f));     // attach formatter
 * 
 * while($r = $q->fetch()) {
 *   print_r($r);
 * }
 * 
 * // Array
 * // (
 * //     [productname] => Magic Carpet
 * //     [colour] => Blue
 * //     [created] => March 5, 2010, 3:35 pm
 * //     [cost] => $450.00
 * // )
 * // Array
 * // (
 * //     [productname] => Magic Carpet
 * //     [colour] => Green
 * //     [created] => March 10, 2010, 11:52 am
 * //     [cost] => $429.00
 * // )
 * @endcode
 * 
 * Alternativly you can attach a formatter to indervidual fetch() call. See
 * \ref cmqueryprotocol_formatter.
 * 
 */

?>
