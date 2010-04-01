<?php

/**
 * @page manual_fmt 4. Data Processing
 * 
 * @section manual_fmt_subpages Subpages
 * -# \subpage manual_fmt_vd
 * -# \subpage manual_fmt_fmt
 * -# \subpage manual_fmt_constants
 * -# \subpage manual_fmt_decimal
 * 
 * @section cmformatter_desc Description
 * The CMFormatter can be used to format or manipulate dates, times, timestamps, numbers, booleans,
 * file sizes or string values. It is reusable so that a format can applied to many values, such as
 * the output from a database.
 * 
 * @section cmformatter_example Example
 * Example #1: Dates
 * @code
 * $f = new CMFormatter('timestamp', 'F j, Y, g:i a');
 * echo $f->format(time()), "\n";                // March 10, 2001, 5:16 pm
 * echo $f->format("2010-03-05 12:43:05"), "\n"; // March 5, 2010, 12:43 pm
 * @endcode
 * 
 * Example #2: Currency
 * @code
 * $f = new CMFormatter('number', array('fixed' => 2, 'thousands' => ',', 'pre' => '$'));
 * echo $f->format(5), "\n";           // $5.00
 * echo $f->format("12347.237"), "\n"; // $12,347.24
 * @endcode
 * 
 * Example #3: Percentages
 * @code
 * $f = new CMFormatter('number', array('prec' => 1, 'mul' => 100, 'post' => '%'));
 * echo $f->format(0.05), "\n";   // 5%
 * echo $f->format(1.2343), "\n"; // 123.4%
 * @endcode
 * 
 * Example #4: File sizes (base 10)
 * @code
 * $f = new CMFormatter('bytes');
 * echo $f->format(5000), "\n";      // 5 KB
 * echo $f->format(512345678), "\n"; // 512.4 MB
 * @endcode
 * 
 * Example #5: File sizes (base 2) with a max memory unit being MiB
 * @code
 * $f = new CMFormatter('bytes', array('fixed' => 2, 'unit' => 1024,
 *        'sizes' => ' bytes; KiB; MiB', 'thousands' => ','));
 * echo $f->format(5000), "\n";        // 4.88 KiB
 * echo $f->format(51234567800), "\n"; // 48,861.09 MiB
 * @endcode
 * 
 * Example #6: File sizes (display all sizes in KB)
 * @code
 * $f = new CMFormatter('number', array('prec' => 0, 'mul' => 0.001, 'post' => ' KB',
 *        'thousands' => ','));
 * echo $f->format(7450), "\n";        // 7 KB
 * echo $f->format(51234567800), "\n"; // 51,234,568 KB
 * @endcode
 * 
 * Example #7: Short syntax
 * @code
 * $f = new CMFormatter('number|prec=1|mul=100|post=%');
 * echo $f->format(0.05), "\n";   // 5%
 * echo $f->format(1.2343), "\n"; // 123.4%
 * @endcode
 * 
 * Example #8: Formatting multiple columns
 * @code
 * $f = new CMFormatter(array(
 *        'created' => 'timestamp|F j, Y, g:i a',
 *        'cost' => 'number|fixed=2|thousands=,|pre=$'
 *      ));
 * print_r($f->format(array('name' => "Bob Smith", 'created' => time(), 'cost' => 450)));
 * //  Array
 * //  (
 * //      [name] => Bob Smith
 * //      [created] => March 5, 2010, 5:35 pm
 * //      [cost] => $450.00
 * //  )
 * @endcode
 * 
 * @section cmformatter_set Why is there no setType() or setFormat()?
 * These functions would be unnecessarily complicated due to the fact a formatter can support multiple
 * formatters for multiple columns. To change the format(s) or type(s) simply create a new CMFormatter
 * object.
 * 
 * @section cmformatter_options_date Formatting options for 'date', 'time' and 'timestamp'
 * These options are passed as a single string like <tt>'F j, Y, g:i a'</tt>:
 * <table>
 *   <tr>
 *     <th>Character</th>
 *     <th>Description</th>
 *     <th>Example</th>
 *   </tr>
 *   <tr>
 *     <td><tt>a</tt></td>
 *     <td>Lowercase Ante meridiem and Post meridiem</td>
 *     <td>am or pm</td>
 *   </tr>
 *   <tr>
 *     <td><tt>A</tt></td>
 *     <td>Uppercase Ante meridiem and Post meridiem</td>
 *     <td>AM or PM</td>
 *   </tr>
 *   <tr>
 *     <td><tt>B</tt></td>
 *     <td>Swatch Internet time</td>
 *     <td>000 through 999</td>
 *   </tr>
 *   <tr>
 *     <td><tt>c</tt></td>
 *     <td>ISO 8601 date (added in PHP 5)</td>
 *     <td>2004-02-12T15:19:21+00:00</td>
 *   </tr>
 *   <tr>
 *     <td><tt>d</tt></td>
 *     <td>Day of the month, 2 digits with leading zeros</td>
 *     <td>01 - 31</td>
 *   </tr>
 *   <tr>
 *     <td><tt>D</tt></td>
 *     <td>A textual representation of a day, three letters</td>
 *     <td>Mon through Sun</td>
 *   </tr>
 *   <tr>
 *     <td><tt>e</tt></td>
 *     <td>Timezone identifier (added in PHP 5.1.0)</td>
 *     <td>Examples: UTC, GMT, Atlantic/Azores</td>
 *   </tr>
 *   <tr>
 *     <td><tt>F</tt></td>
 *     <td>A full textual representation of a month, such as January or March</td>
 *     <td>January through December</td>
 *   </tr>
 *   <tr>
 *     <td><tt>g</tt></td>
 *     <td>12-hour format of an hour without leading zeros</td>
 *     <td>1 through 12</td>
 *   </tr>
 *   <tr>
 *     <td><tt>G</tt></td>
 *     <td>24-hour format of an hour without leading zeros</td>
 *     <td>0 through 23</td>
 *   </tr>
 *   <tr>
 *     <td><tt>h</tt></td>
 *     <td>12-hour format of an hour with leading zeros</td>
 *     <td>01 through 12</td>
 *   </tr>
 *   <tr>
 *     <td><tt>H</tt></td>
 *     <td>24-hour format of an hour with leading zeros</td>
 *     <td>00 through 23</td>
 *   </tr>
 *   <tr>
 *     <td><tt>i</tt></td>
 *     <td>Minutes with leading zeros</td>
 *     <td>00 to 59</td>
 *   </tr>
 *   <tr>
 *     <td><tt>I</tt></td>
 *     <td>Whether or not the date is in daylight saving time</td>
 *     <td>1 if Daylight Saving Time, 0 otherwise.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>j</tt></td>
 *     <td>Day of the month without leading zeros</td>
 *     <td>1 to 31</td>
 *   </tr>
 *   <tr>
 *     <td><tt>l</tt></td>
 *     <td>A full textual representation of the day of the week</td>
 *     <td>Sunday through Saturday</td>
 *   </tr>
 *   <tr>
 *     <td><tt>L</tt></td>
 *     <td>Whether it's a leap year</td>
 *     <td>1 if it is a leap year, 0 otherwise.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>m</tt></td>
 *     <td>Numeric representation of a month, with leading zeros</td>
 *     <td>01 through 12</td>
 *   </tr>
 *   <tr>
 *     <td><tt>M</tt></td>
 *     <td>A short textual representation of a month, three letters</td>
 *     <td>Jan through Dec</td>
 *   </tr>
 *   <tr>
 *     <td><tt>n</tt></td>
 *     <td>Numeric representation of a month, without leading zeros</td>
 *     <td>1 through 12</td>
 *   </tr>
 *   <tr>
 *     <td><tt>N</tt></td>
 *     <td>ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0)</td>
 *     <td>1 (for Monday) through 7 (for Sunday)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>o</tt></td>
 *     <td>ISO-8601 year number. This has the same value as Y, except that if the ISO week number
 *         (W) belongs to the previous or next year, that year is used instead. (added in PHP 5.1.0)
 *         </td>
 *     <td>Examples: 1999 or 2003</td>
 *   </tr>
 *   <tr>
 *     <td><tt>O</tt></td>
 *     <td>Difference to Greenwich time (GMT) in hours</td>
 *     <td>Example: +0200</td>
 *   </tr>
 *   <tr>
 *     <td><tt>P</tt></td>
 *     <td>Difference to Greenwich time (GMT) with colon between hours and minutes (added in PHP
 *         5.1.3)</td>
 *     <td>Example: +02:00</td>
 *   </tr>
 *   <tr>
 *     <td><tt>r</tt></td>
 *     <td>RFC 2822 formatted date</td>
 *     <td>Example: Thu, 21 Dec 2000 16:01:07 +0200</td>
 *   </tr>
 *   <tr>
 *     <td><tt>s</tt></td>
 *     <td>Seconds, with leading zeros</td>
 *     <td>00 through 59</td>
 *   </tr>
 *   <tr>
 *     <td><tt>S</tt></td>
 *     <td>English ordinal suffix for the day of the month, 2 characters</td>
 *     <td>st, nd, rd or th. Works well with j</td>
 *   </tr>
 *   <tr>
 *     <td><tt>t</tt></td>
 *     <td>Number of days in the given month</td>
 *     <td>28 through 31</td>
 *   </tr>
 *   <tr>
 *     <td><tt>T</tt></td>
 *     <td>Timezone abbreviation</td>
 *     <td>Examples: EST, MDT ...</td>
 *   </tr>
 *   <tr>
 *     <td><tt>u</tt></td>
 *     <td>Microseconds (added in PHP 5.2.2)</td>
 *     <td>Example: 654321</td>
 *   </tr>
 *   <tr>
 *     <td><tt>U</tt></td>
 *     <td>Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)</td>
 *     <td>PHP time() function</td>
 *   </tr>
 *   <tr>
 *     <td><tt>w</tt></td>
 *     <td>Numeric representation of the day of the week</td>
 *     <td>0 (for Sunday) through 6 (for Saturday)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>W</tt></td>
 *     <td>ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0)</td>
 *     <td>42 (the 42nd week in the year)</td>
 *   </tr>
 *   <tr>
 *     <td><tt>y</tt></td>
 *     <td>A two digit representation of a year</td>
 *     <td>Examples: 99 or 03</td>
 *   </tr>
 *   <tr>
 *     <td><tt>Y</tt></td>
 *     <td>A full numeric representation of a year, 4 digits</td>
 *     <td>Examples: 1999 or 2003</td>
 *   </tr>
 *   <tr>
 *     <td><tt>z</tt></td>
 *     <td>The day of the year (starting from 0)</td>
 *     <td>0 through 365</td>
 *   </tr>
 *   <tr>
 *     <td><tt>Z</tt></td>
 *     <td>Timezone offset in seconds. The offset for timezones west of UTC is always negative, and
 *         for those east of UTC is always positive.</td>
 *     <td>-43200 through 50400</td>
 *   </tr>
 * </table>
 * 
 * @section cmformatter_options_number Formatting options for 'number' and 'bytes'
 * <table>
 *   <tr>
 *     <th>Name</th>
 *     <th>Value</th>
 *     <th>Default</th>
 *     <th>Description</th>
 *   </tr>
 *   <tr>
 *     <td><tt>date</tt></td>
 *     <td>string</td>
 *     <td><tt>""</tt></td>
 *     <td>Date format</td>
 *   </tr>
 *   <tr>
 *     <td><tt>dec</tt></td>
 *     <td>string</td>
 *     <td><tt>.</tt></td>
 *     <td>Decimal point character</td>
 *   </tr>
 *   <tr>
 *     <td><tt>fixed</tt></td>
 *     <td>integer</td>
 *     <td><tt>false</tt></td>
 *     <td>Force fixed precision</td>
 *   </tr>
 *   <tr>
 *     <td><tt>mul</tt></td>
 *     <td>number</td>
 *     <td><tt>1</tt></td>
 *     <td>Multiply the given input before formatting</td>
 *   </tr>
 *   <tr>
 *     <td><tt>post</tt></td>
 *     <td>string</td>
 *     <td><tt>""</tt></td>
 *     <td>Attach to the end of the formatted value</td>
 *   </tr>
 *   <tr>
 *     <td><tt>pre</tt></td>
 *     <td>string</td>
 *     <td><tt>""</tt></td>
 *     <td>Attach to the start of the formatted value</td>
 *   </tr>
 *   <tr>
 *     <td><tt>prec</tt></td>
 *     <td>integer</td>
 *     <td>14 for 'number', 1 for 'bytes'</td>
 *     <td>Round to precision</td>
 *   </tr>
 *   <tr>
 *     <td><tt>sizes</tt></td>
 *     <td>string separated by ';'</td>
 *     <td><tt>' bytes; KB; MB; GB; TB; PB; EB; ZB; YB'</tt></td>
 *     <td>This only applies in 'bytes' mode. The extension to use for each magnitude. See
 *         <tt>unit</tt></td>
 *   </tr>
 *   <tr>
 *     <td><tt>thousands</tt></td>
 *     <td>string</td>
 *     <td><tt>""</tt></td>
 *     <td>Use this for thousands separator</td>
 *   </tr>
 *   <tr>
 *     <td><tt>type</tt></td>
 *     <td>string</td>
 *     <td><tt>'string'</tt></td>
 *     <td>This is the same as the $type argument in the constructor</td>
 *   </tr>
 *   <tr>
 *     <td><tt>unit</tt></td>
 *     <td>integer</td>
 *     <td><tt>1000</tt></td>
 *     <td>This only applies in 'bytes' mode. The unit for each magnitude when formating data
 *         sizes. Another common value is <tt>1024</tt>.</td>
 *   </tr>
 * </table>
 * 
 * @section cmvalidator_rules Validation Rules
 * Validation rules are set via a space separeted string where each word represents the rule for a field
 * name, for example:
 * @code
 * // Example 1
 * $v = new CMDataModelValidator('+firstname +lastname +@email #age');
 * @endcode
 * In the above example validator will only validate if all of the following items are true;
 *  - <tt>firstname</tt>, <tt>lastname</tt> have a value.
 *  - <tt>email</tt> has a value AND it is a valid email address.
 *  - <tt>age</tt> can be blank, but if it has a value that value must be a valid number.
 *  
 * When using the validator with CMDataModel you must also include the pool name to match the field
 * naming convention of CMDataModel. For example if the fields in the example above exist in a
 * <tt>person</tt> pool;
 * @code
 * // Example 2
 * $v = new CMDataModelValidator('+person[firstname] +person[lastname] '.
 *                               '+@person[email] #person[age]');
 * @endcode
 * 
 * Alternativly, you can use an array of rules. Example 3 does the same thing as Example 1:
 * @code
 * // Example 3
 * $v = new CMDataModelValidator(array('+firstname', '+lastname', '+@email', '#age'));
 * @endcode
 * 
 * If a field has no validation characters it will only fail validation if the field itself was neve
 * posted. A blank value posted is still valid.
 * 
 * @section cmvalidator_chars Validation characters
 * One or more of the characters below can be applied before a field name in any order.
 * <table>
 *   <tr>
 *     <th>Character</th>
 *     <th>Description</th>
 *   </tr>
 *   <tr>
 *     <td>+</td>
 *     <td>The field must have a value.</td>
 *   </tr>
 *   <tr>
 *     <td>-</td>
 *     <td>The field must be blank (of zero length).</td>
 *   </tr>
 *   <tr>
 *     <td>\@</td>
 *     <td>The field must be blank OR a valid email address, use '+@' to specify a mandatory valid
 *         email address.</td>
 *   </tr>
 *   <tr>
 *     <td>#</td>
 *     <td>The field must be blank OR a valid number, use '+#' to specify a mandatory valid number.
 *         A number can be an integer (whole number), fractional value or scientific notation.</td>
 *   </tr>
 * </table>
 * 
 */

?>
