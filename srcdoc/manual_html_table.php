<?php

/**
 * @page manual_html_table 3.2. Tables
 * 
 * @section manual_html_table_contents Contents
 * -# \ref manual_html_table_intro
 * -# \ref manual_html_table_colspan
 * -# \ref manual_html_table_styles
 *  -# \ref manual_html_table_styles_table
 *  -# \ref manual_html_table_styles_tr
 *   -# \ref manual_html_table_styles_tr1
 *   -# \ref manual_html_table_styles_tr2
 *   -# \ref manual_html_table_styles_tr3
 *  -# \ref manual_html_table_styles_td
 *   -# \ref manual_html_table_styles_td1
 *   -# \ref manual_html_table_styles_td2
 *   -# \ref manual_html_table_styles_td3
 *   -# \ref manual_html_table_styles_td4
 *   -# \ref manual_html_table_styles_td5
 * -# \ref manual_html_table_data
 * -# \ref manual_html_table_header
 * -# \ref manual_html_table_th
 * 
 * 
 * @section manual_html_table_intro Introduction
 * Tables are one of the most comonly used objects in HTML and are used in a wide variety of situations,
 * because of this CMLIB needs to have all the same features so rendering tables in CMLIB spans from very
 * simple to complex depending on how you want your result to come out.
 * 
 * In its most basic raw form, you can create a table like:
 * @code
 * // Example 1.1
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('Bob', 'Brown'),
 *     array('Joe', 'Bloggs')
 *   )
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr><td>Bob</td><td>Brown</td></tr>
 * <tr><td>Joe</td><td>Bloggs</td></tr>
 * </table>
 * 
 * All attributes to CMHTML::Table() are optional, but you should always have a 'data' attribute. Any
 * attribute can be a fixed value (like above) or a query handle. If in the case of a query handle it will
 * automatically read one cell, one row or the entire set depending on what information it needs.
 * 
 * If the information in Example 1.1 was in a table we could easily generate the same table by doing:
 * @code
 * // Example 1.2
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => $dbh->query("select * from people")
 * ));
 * @endcode
 * 
 * 
 * @section manual_html_table_colspan Automatic colspan
 * To be friendly to browsers and remain compliant with the HTML standards you can provide any number of
 * table cells per table row and the rendered result will fill in all the correct colspan values so that
 * all rows remain the same number of columns.
 * 
 * @code
 * // Example 2.1
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('Bob', 'Brown'),
 *     array('Joe Bloggs')
 *   )
 * ));
 * @endcode
 * 
 * As well as automatic colspan, you do not have to provide table rows as an array, they can be raw strings
 * and the rendering engine will assume you mean a table row with only one cell.
 * 
 * @code
 * // Example 2.2
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     'Row 1',
 *     array('Split', 'Up'),
 *     array('Row 3')
 *   )
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr><td colspan="2">Row 1</td></tr>
 * <tr><td>Split</td><td>Up</td></tr>
 * <tr><td colspan="2">Row 3</td></tr>
 * </table>
 * 
 * 
 * @section manual_html_table_styles Styles
 * 
 * 
 * @section manual_html_table_styles_table Apply to Table
 * Table wide styles and attributes are passed directly to CMHTML::Table() through their own attributes
 * like:
 * 
 * @code
 * // Example 3.1
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('Bob', 'Brown'),
 *     array('Joe', 'Bloggs')
 *   ),
 *   
 *   // right here
 *   'cellpadding' => 5,
 *   'border' => 0,
 *   'style' => 'border: solid 1px red'
 * ));
 * @endcode
 * 
 * 
 * @section manual_html_table_styles_tr Apply to Table Row
 * There are three ways to apply styles to table rows, you may use anywhere between none and all three. In
 * operation it will attempt to use \ref manual_html_table_styles_tr2 first before
 * \ref manual_html_table_styles_tr1 or \ref manual_html_table_styles_tr3.
 * 
 * @section manual_html_table_styles_tr1 Method 1
 * The first method is to apply a global table row style.
 * 
 * @code
 * // Example 3.2
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('Bob', 'Brown'),
 *     array('Joe', 'Bloggs')
 *   ),
 *   
 *   // all rows will be gray because this will be applied to every row
 *   'trstyle' => 'background-color: gray'
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr style="background-color: gray"><td>Bob</td><td>Brown</td></tr>
 * <tr style="background-color: gray"><td>Joe</td><td>Bloggs</td></tr>
 * </table>
 * 
 * 
 * @section manual_html_table_styles_tr2 Method 2
 * The second method is to add the attribute to indervidual table rows.
 * 
 * @code
 * // Example 3.3
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('style' => 'background-color: gray', 'Bob', 'Brown'),
 *     array('style' => 'background-color: green', 'Joe', 'Bloggs')
 *   )
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr style="background-color: gray"><td>Bob</td><td>Brown</td></tr>
 * <tr style="background-color: green"><td>Joe</td><td>Bloggs</td></tr>
 * </table>
 * 
 * 
 * @section manual_html_table_styles_tr3 Method 3
 * The third method uses callbacks (anonymous functions) that calculate their value at run time.
 * These are placed outside the 'data' attribute:
 * 
 * @code
 * // Example 3.4
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('Bob', 'Brown'),
 *     array('Joe', 'Bloggs'),
 *     array('John', 'Smith'),
 *     array('Kelly', 'Ripa')
 *   ),
 *   'trstyle' => function($a) {
 *     if($a['rowid'] % 2)
 *       return 'background-color: gray';
 *     return '';
 *   }
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr style=""><td>Bob</td><td>Brown</td></tr>
 * <tr style="background-color: gray"><td>Joe</td><td>Bloggs</td></tr>
 * <tr style=""><td>John</td><td>Smith</td></tr>
 * <tr style="background-color: gray"><td>Kelly</td><td>Ripa</td></tr>
 * </table>
 * 
 * <tt>rowid</tt> is a special value always provided that tells you which row of the table the rendering
 * engine is talking about, where the first row will have a rowid = 0.
 * 
 * You can use all the other data in that row by using the data index, for example if you want to
 * highlight all the rows in a table that have the first or last name Bob you could do:
 * @code
 * // Example 3.4
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => $dbh->query('select firstname, lastname from people limit 100'),
 *   'trstyle' => function($a) {
 *     if($a[0] == 'Bob' || $a[1] == 'Bob')
 *       return 'background-color: yellow';
 *     return '';
 *   }
 * ));
 * @endcode
 * 
 * 
 * @section manual_html_table_styles_td Apply to Table Cell
 * Similar to how \ref manual_html_table_styles_tr works, there are several ways of applying styles to
 * table cells depending on your needs.
 * 
 * 
 * @section manual_html_table_styles_td1 Method 1
 * @code
 * // Example 4.1
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('Bob', 'Brown'),
 *     array('Joe', 'Bloggs')
 *   ),
 *   
 *   // all cells will be yellow because this will be applied to every cell
 *   'tdstyle' => 'background-color: yellow'
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr><td style="background-color: yellow">Bob</td><td style="background-color: yellow">Brown</td></tr>
 * <tr><td style="background-color: yellow">Joe</td><td style="background-color: yellow">Bloggs</td></tr>
 * </table>
 * 
 * 
 * @section manual_html_table_styles_td2 Method 2
 * Like \ref manual_html_table_styles_tr2 of table rows, you can place the styles for table cells in within
 * each row, where the first cell (furthest to the left) is at index 0.
 * @code
 * // Example 4.2
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('style@1' => 'border: solid 2px red', 'Bob', 'Brown'),
 *     array('style@0' => 'background-color: yellow', 'Joe', 'Bloggs')
 *   )
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr><td>Bob</td><td style="border: solid 2px red">Brown</td></tr>
 * <tr><td style="background-color: yellow">Joe</td><td>Bloggs</td></tr>
 * </table>
 * 
 * 
 * @section manual_html_table_styles_td3 Method 3
 * Use <tt>tdstyle</tt> in an indervidual row:
 * @code
 * // Example 4.3
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('tdstyle' => 'border: solid 2px red', 'Bob', 'Brown'),
 *     array('Joe', 'Bloggs')
 *   )
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr><td style="border: solid 2px red">Bob</td><td style="border: solid 2px red">Brown</td></tr>
 * <tr><td>Joe</td><td>Bloggs</td></tr>
 * </table>
 * 
 * 
 * @section manual_html_table_styles_td4 Method 4
 * Using a callback (anonymous function) inside an indervidual row:
 * @code
 * // Example 4.4
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => array(
 *     array('tdstyle' => function($a) {
 *       if($a['colid'] % 2)
 *         return 'border: solid 2px red';
 *       return '';
 *     },
 *       'Bob', 'Brown'),
 *     array('Joe', 'Bloggs')
 *   )
 * ));
 * @endcode
 * 
 * Will generate:
 * <table>
 * <tr><th>First name</th><th>Last name</th></tr>
 * <tr><td style="">Bob</td><td style="border: solid 2px red">Brown</td></tr>
 * <tr><td>Joe</td><td>Bloggs</td></tr>
 * </table>
 * 
 * 
 * @section manual_html_table_styles_td5 Method 5
 * Similar to \ref manual_html_table_styles_td4, except outside the <tt>data</tt> attribute.
 * @code
 * // Example 4.4
 * echo CMHTML::Table(array(
 *   'data' => array(
 *     array(1, 2, 3, 4),
 *     array(5, 6, 7, 8),
 *     array(9, 10, 11, 12),
 *     array(13, 14, 15, 16)
 *   ),
 *   'tdstyle' => function($a) {
 *     if($a['colid'] % 2 && $a['rowid'] % 2)
 *       return 'background-color: black; color: white';
 *     if(!($a['colid'] % 2) && !($a['rowid'] % 2))
 *       return 'background-color: black; color: white';
 *     return '';
 *   }
 * ));
 * @endcode
 * 
 * Will generate a chessboard like effect:
 * <table>
 * <tr>
 * <td style="background-color: black; color: white">1</td>
 * <td style="">2</td>
 * <td style="background-color: black; color: white">3</td>
 * <td style="">4</td>
 * </tr>
 * <tr>
 * <td style="">5</td>
 * <td style="background-color: black; color: white">6</td>
 * <td style="">7</td>
 * <td style="background-color: black; color: white">8</td>
 * </tr>
 * <tr>
 * <td style="background-color: black; color: white">9</td>
 * <td style="">10</td>
 * <td style="background-color: black; color: white">11</td>
 * <td style="">12</td>
 * </tr>
 * <tr>
 * <td style="">13</td>
 * <td style="background-color: black; color: white">14</td>
 * <td style="">15</td>
 * <td style="background-color: black; color: white">16</td>
 * </tr>
 * </table>
 * 
 * 
 * @section manual_html_table_data Data Replacer
 * Just like with styles you can use a data replacer to process and modify the values of the table at runtime, this makes it easy
 * to highlight certain data or add numerical counters to a database output.
 * 
 * @code
 * echo CMHTML::Table(array(
 *   'width' => '100%',
 *   'header' => array('#', 'First name', 'Last name'),
 *   'data' => $dbh->query('select 1, * from people'),
 *   'data@0' => function($data) {
 *     return $data['rowid'] + 1;
 *   }
 * ));
 * @endcode
 * 
 * 
 * @section manual_html_table_header Repeating Header
 * For some long tables you may want to repeat the table header every certain amount of rows. You can do this with the 'repeatheader'
 * key and set the value to the number of rows to render before printing the header row again.
 *
 * @code
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => $dbh->query('select * from people'),
 *   'repeatheader' => 10
 * ));
 * @endcode
 * 
 * 
 * @section manual_html_table_th Table Header Styling
 * Use 'thstyle' to style the &gt;th&lt;&gt;/th&lt; tags.
 *
 * @code
 * echo CMHTML::Table(array(
 *   'header' => array('First name', 'Last name'),
 *   'data' => $dbh->query('select * from people'),
 *   'thstyle' => 'border: solid 1px red; border-right: none'
 * ));
 * @endcode
 */

?>
