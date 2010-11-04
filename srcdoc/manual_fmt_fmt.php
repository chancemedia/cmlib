<?php

/**
 * @page manual_fmt_fmt 4.2. Formatter
 * 
 * 
 * @section manual_fmt_cfmt_contents Contents
 * -# \ref manual_fmt_fmt_intro
 * -# \ref manual_fmt_fmt_options
 * -# \ref manual_fmt_fmt_date
 * -# \ref manual_fmt_fmt_money
 * -# \ref manual_fmt_fmt_percent
 * -# \ref manual_fmt_fmt_bytes
 * -# \ref manual_fmt_fmt_multi
 * -# \ref manual_fmt_fmt_db
 * 
 * 
 * @section manual_fmt_fmt_intro Introduction
 * The CMFormatter makes it easy and consistant to format many types of data. The basic syntax:
 * @code
 * $f = new CMFormatter(type, options);
 * @endcode
 *
 * Where <tt>code</tt> can be one of:
 * -# <tt>'number'</tt> for raw numerical formating, this including formatting currency.
 * -# <tt>'timestamp'</tt> for formatting dates and times.
 * -# <tt>'bytes'</tt> for data size formatting.
 *
 * And <tt>options</tt> can be a single string, or associative array of options for the formatter.
 *
 * <b>Tip:</b> you can replace an array of options with a key-value string split by pipes. The following
 * example:
 * @code
 * $f = new CMFormatter('number', array('fixed' => 2, 'thousands' => ',', 'pre' => '$'));
 * @endcode
 * Will do the same as:
 * @code
 * $f = new CMFormatter('number', 'fixed=2|thousands=,|pre=$'));
 * @endcode
 * 
 * 
 * @section manual_fmt_fmt_options Options
 * <table>
 *   <tr>
 *     <th>Option</th>
 *     <th>Applies to</th>
 *     <th>Default</th>
 *     <th>Notes</th>
 *   </tr>
 *   <tr>
 *     <td><tt>'date'</tt></td>
 *     <td><tt>timestamp</tt></td>
 *     <td><tt>''</tt></td>
 *     <td>The date format specified using the same options as the native PHP date() function.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'dec'</tt></td>
 *     <td><tt>number</tt></td>
 *     <td><tt>'.'</tt></td>
 *     <td>The decimal point character or string.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'fixed'</tt></td>
 *     <td><tt>number</tt></td>
 *     <td><tt>false</tt></td>
 *     <td>Fixed precision. The value to provide is the number of decimal places to be fixed to. For example 3.4 fixed to 3 decimal places is 3.400</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'html'</tt></td>
 *     <td><tt>boolean</tt></td>
 *     <td><tt>false</tt></td>
 *     <td>If this option is set to \true the formatter will escape the result so that it is safe to use in HTML.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'mul'</tt></td>
 *     <td><tt>number</tt></td>
 *     <td><tt>1.0</tt></td>
 *     <td>The multiplier will multiple the raw value before formatting it, this is helpful for dealing with percentages where 0.05 represents 5%.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'post'</tt></td>
 *     <td><tt>timestamp</tt>, <tt>number</tt>, <tt>bytes</tt></td>
 *     <td><tt>''</tt></td>
 *     <td>The character or string to place after the formatted result.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'pre'</tt></td>
 *     <td><tt>timestamp</tt>, <tt>number</tt>, <tt>bytes</tt></td>
 *     <td><tt>''</tt></td>
 *     <td>The character or string to place before the formatted result.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'prec'</tt></td>
 *     <td><tt>number</tt></td>
 *     <td><tt>false</tt></td>
 *     <td>Variable width precision (i.e. up to this many places if needed) use this or <tt>'fixed'</tt> they cannot be used together. Supply the
 *         the number of maximum places of precision. If the raw number contains more precision than <tt>'prec'</tt> the number will be rounded
 *         for the result.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'sizes'</tt></td>
 *     <td><tt>bytes</tt></td>
 *     <td><tt>' bytes; KB; MB; GB; TB; PB; EB; ZB; YB'</tt></td>
 *     <td>When formatting data size you can specify the extension of each power of the <tt>'unit'</tt> to be appended after the value.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'thousands'</tt></td>
 *     <td><tt>number</tt>, <tt>bytes</tt></td>
 *     <td><tt>''</tt></td>
 *     <td>Thousands separator.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'type'</tt></td>
 *     <td>N/A</td>
 *     <td>None</td>
 *     <td>This is an internal place holder for the <tt>type</tt> specified in the first argument of the constructor, you should not modify or set
 *         this manually but i'll document it here anyway.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>'unit'</tt></td>
 *     <td><tt>bytes</tt></td>
 *     <td><tt>1000</tt></td>
 *     <td>The magnitude of each data size step. You may want to choose <tt>1024</tt> as an alternative value.</td>
 *   </tr>
 * </table>
 *
 * 
 * @section manual_fmt_fmt_date Date formatting
 * @code
 * $f = new CMFormatter('timestamp', 'F j, Y, g:i a');
 * echo $f->format(1269298400)            // 'March 23, 2010, 9:53 am'
 * echo $f->format("2010-03-05 12:43:05") // 'March 5, 2010, 12:43 pm'
 * @endcode
 * 
 * 
 * @section manual_fmt_fmt_money Currency formatting
 * @code
 * $f = new CMFormatter('number', array('fixed' => 2, 'thousands' => ',', 'pre' => '$'));
 * echo $f->format(5);           // '$5.00'
 * echo $f->format("12347.237"); // '$12,347.24'
 * @endcode
 *
 *
 * @section manual_fmt_fmt_percent Percentage formatting
 * @code
 * $f = new CMFormatter('number', array('prec' => 1, 'mul' => 100, 'post' => '%'));
 * echo $f->format(0.05);   // '5%'
 * echo $f->format(1.2343); // '123.4%'
 * @endcode
 *
 *
 * @section manual_fmt_fmt_bytes Bytes formatting
 * Example 1:
 * @code
 * $f = new CMFormatter('bytes');
 * echo $f->format(5000);      // '5 KB'
 * echo $f->format(512345678); // '512.4 MB'
 * @endcode
 *
 * Example 2:
 * @code
 * $f = new CMFormatter('bytes', array('fixed' => 2, 'unit' => 1024,
 *                      'sizes' => ' bytes; KiB; MiB', 'thousands' => ','));
 * $f->format(5000);        // '4.88 KiB'
 * $f->format(51234567800); // '48,861.09 MiB'
 * @endcode
 *
 * Example 3:
 * @code
 * $f = new CMFormatter('number', array('prec' => 0, 'mul' => 0.001, 'post' => ' KB',
 *                     'thousands' => ','));
 * $f->format(7450);        // '7 KB'
 * $f->format(51234567800); // '51,234,568 KB'
 * @endcode
 *
 *
 * @section manual_fmt_fmt_multi Multicolumn formatter
 * @code
 * $f = new CMFormatter(array(
 *   'created' => 'timestamp|F j, Y, g:i a',
 *   'cost' => 'number|fixed=2|thousands=,|pre=$'
 * ));
 * $result = $f->format(array('name' => "Bob Smith", 'created' => 1269298400, 'cost' => 450));
 * $result['name'];    // 'Bob Smith'
 * $result['created']; // 'March 23, 2010, 9:53 am'
 * $result['cost'];    // '$450.00'
 * @endcode
 *
 *
 * @section manual_fmt_fmt_db Formatting Directly From a Database Query
 * This is the most commonly used formatting that is built right into the database query:
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
 * See more information at \ref manual_databases_fmt.
 */

?>
