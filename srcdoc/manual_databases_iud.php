<?php

/**
 * @page manual_databases_iud 5.4. INSERT, UPDATE and DELETE
 * 
 * @section manual_databases_iud_contents Contents
 * -# \ref manual_databases_iud_insert
 * -# \ref manual_databases_iud_update
 * -# \ref manual_databases_iud_delete
 * 
 * 
 * @section manual_databases_iud_insert Inserting data
 * The insert() method is designed for 2 purposes:
 * - To have a consistant syntax specific designed for executing \c INSERT statements.
 * - Automatically fetching newly created primary keys.
 * 
 * An example:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $insertID = $dbh->insert('mytable', array(
 *               'firstname' => 'Bob',
 *               'lastname' => 'Smith',
 *               'value' => 45
 *             ));
 * // SQL executed: INSERT INTO mytable (firstname, lastname, value)
 * //               VALUES ('Bob', 'Smith', '45');
 * @endcode
 * If the \c INSERT was successful and the table in which your are inserting into has created a new
 * auto_increment value (in the case of MySQL) the value will be returned:
 * <pre>
 * +----+-----------+----------+-------+
 * | id | firstname | lastname | value |
 * +----+-----------+----------+-------+
 * |  1 | Bob       | Smith    |    45 |
 * +----+-----------+----------+-------+
 * </pre>
 * \c $insertID will have the value of \c 1
 * 
 * 
 * @section manual_databases_iud_update Updating data
 * This method works similar to insert(), however returns \true or \false on the success of the
 * execution.
 * 
 * An example:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $insertID = $dbh->update('mytable', array(
 *               'firstname' => 'Robert',
 *               'value' => 45
 *             ), array(
 *               'firstname' => 'Bob',
 *               'lastname' => 'Smith'
 *             );
 * // SQL executed: UPDATE mytable
 * //               SET firstname='Robert', value='45'
 * //               WHERE firstname='Bob' AND lastname='Smith'
 * @endcode
 * 
 * You may use one of the following characters before the field name in the second array:
 * <table>
 *   <tr>
 *     <th>Character</th>
 *     <th>Description</th>
 *   </tr>
 *   <tr>
 *     <td><tt>=</tt></td>
 *     <td>Equal to. This is the default.</td>
 *   </tr>
 *   <tr>
 *     <td><tt>!</tt> or <tt>!=</tt></td>
 *     <td>Not equal to</td>
 *   </tr>
 *   <tr>
 *     <td><tt>~</tt></td>
 *     <td>IS NULL</td>
 *   </tr>
 *   <tr>
 *     <td><tt>!~</tt></td>
 *     <td>IS NOT NULL</td>
 *   </tr>
 *   <tr>
 *     <td><tt>&lt;</tt></td>
 *     <td>Less than</td>
 *   </tr>
 *   <tr>
 *     <td><tt>&gt;</tt></td>
 *     <td>Greater than</td>
 *   </tr>
 *   <tr>
 *     <td><tt>&lt;=</tt></td>
 *     <td>Less than or equal to</td>
 *   </tr>
 *   <tr>
 *     <td><tt>&gt;=</tt></td>
 *     <td>Greater than or equal to</td>
 *   </tr>
 * </table>
 * 
 * An example using the criteria modifiers:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123/test");
 * $insertID = $dbh->update('mytable', array(
 *               'firstname' => 'Robert',
 *               'value' => 45
 *             ), array(
 *               'firstname' => 'Bob',
 *               'lastname' => 'Smith'
 *             );
 * // SQL executed: UPDATE mytable
 * //               SET firstname='Robert', value='45'
 * //               WHERE firstname='Bob' AND lastname='Smith'
 * @endcode
 * 
 * 
 * @section manual_databases_iud_delete Deleting data
 * 
 */

?>
