<?php

/**
 * @page manual_file_csv 7.1. CSV
 * 
 * 
 * @section manual_file_csv_contents Contents
 * -# \ref manual_file_csv_read
 * -# \ref manual_file_csv_readmap
 * -# \ref manual_file_csv_write
 * -# \ref manual_file_csv_format
 * -# \ref manual_file_csv_options
 * 
 * 
 * @section manual_file_csv_read Reading a CSV File
 * @code
 * $csv = new CMFileCSV();
 * if(!$csv->iterateFile('csv1.csv'))
 *   die("Unable to read file!");
 * 
 * while($line = $csv->next()) {
 *   print_r($line);
 * }
 * 
 * // Array (
 * //     [0] => begin_ip
 * //     [1] => end_ip
 * //     [2] => begin_num
 * //     [3] => end_num
 * //     [4] => country
 * //     [5] => name
 * // )
 * // Array (
 * //     [0] => 61.88.0.0
 * //     [1] => 61.91.255.255
 * //     [2] => 1029177344
 * //     [3] => 1029439487
 * //     [4] => AU
 * //     [5] => Australia
 * // )
 * // ...
 * @endcode
 * 
 * 
 * @section manual_file_csv_readmap Reading a CSV with mapped field names.
 * @code
 * $fields = array('begin_ip', 'end_ip', 'begin_num', 'end_num', 'country', 'name');
 * $csv = new CMFileCSV($fields);
 * if(!$csv->iterateFile('csv1.csv', array('skip' => 1)))
 * die("Unable to read file!");
 * 
 * while($line = $csv->next()) {
 *   print_r($line);
 * }
 * 
 * // Array (
 * //     [begin_ip] => 61.88.0.0
 * //     [end_ip] => 61.91.255.255
 * //     [begin_num] => 1029177344
 * //     [end_num] => 1029439487
 * //     [country] => AU
 * //     [name] => Australia
 * // )
 * // ...
 * @endcode
 * 
 * 
 * @section manual_file_csv_write Outputting a CSV file.
 * @code
 * $csv = new CMFileCSV();
 * if(!$csv->prepareWriteFile('csv2.csv'))
 *   die("Unable to open file!");
 * 
 * $data = array(
 *   array('first', 'last', 'email'),
 *   array('Bob', 'Smith', 'bob@smith.com'),
 *   array('Joe', 'Bloggs', 'joe@bloggs.com')
 * );
 * 
 * foreach($data as $d)
 *   $csv->add($d);
 * @endcode
 * 
 * @section cmfilecsv_example4 Example 4: Rewriting a CSV file.
 * @code
 * $csvIn = new CMFileCSV();
 * $csvOut = new CMFileCSV();
 * if(!$csvIn->iterateFile('csv1.csv') || !$csvOut->prepareWriteFile('csv3.csv'))
 *   die("One of the files could not be opened");
 * 
 * // add an ID field at the beginning
 * $csvOut->add(array_merge(array('id'), $csvIn->next()));
 * for($i = 1; $line = $csvIn->next(); ++$i) {
 *   $csvOut->add(array_merge(array($i), $line));
 * }
 * $csvOut->finishWriteFile();
 * 
 * // id,begin_ip,end_ip,begin_num,end_num,country,name
 * // 1,61.88.0.0,61.91.255.255,1029177344,1029439487,AU,Australia
 * // 2,61.92.0.0,61.93.255.255,1029439488,1029570559,HK,"Hong Kong"
 * // 3,61.94.0.0,61.94.7.255,1029570560,1029572607,ID,Indonesia
 * @endcode
 * 
 * 
 * @section manual_file_csv_format Changing the Input/Output Delimiter and Enclosure
 * These attributes can be accessed directly within your CMFileCSV instance, the change affect
 * immediatly even if you are in the middle of reading/write a CSV file.
 * @code
 * $csv = new CMFileCSV();
 * $csv->delimiter = "\t"; // change the column delimiter to a tab
 * $csv->enclosure = "\""; // this is the default
 * @endcode
 * 
 * 
 * @section manual_file_csv_options Options for Reading CSV Files
 * <table>
 *   <tr>
 *     <th>Name</th>
 *     <th>Applies to</th>
 *     <th>Description</th>
 *   </tr>
 *   <tr>
 *     <td>\c append</td>
 *     <td>Writing CSV</td>
 *     <td>If a value is given that evaluates to \true, then the file handle is placed at the end of the
 *         newly opened file handle and any data will be written to the end of the file. Alternativly, if
 *         this is not provided it takes a value of \false which will cause the file that exists in the
 *         location to be replaced. See prepareWriteFile() for more information.</td>
 *   </tr>
 *   <tr>
 *     <td>\c skip</td>
 *     <td>Reading CSV</td>
 *     <td>The number of lines to skip when opening the read file handle. A common value is '1' used to skip
 *         the field names that appear in some CSV files.</td>
 *   </tr>
 * </table>
 * 
 */

?>
