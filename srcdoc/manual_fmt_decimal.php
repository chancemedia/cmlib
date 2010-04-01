<?php

/**
 * @page manual_fmt_decimal 4.4. Decimals
 * 
 * 
 * @section manual_fmt_decimal_contents Contents
 * -# \ref manual_fmt_decimal_intro
 * -# \ref manual_fmt_decimal_math
 * -# \ref manual_fmt_decimal_native
 * 
 * 
 * @section manual_fmt_decimal_intro Introduction
 * CMDecimal is designed for dealing with exact numbers - most commonly used with currency
 * calculations. In some cases using normal floating-point numbers is not always the best idea
 * because computers are not always able to give an exact binary representation of even simple
 * floating-point values.
 * 
 * This is certainly not a new problem in computer terms, but still remains important to remember.
 * Take the following example of a modern MySQL installation using a sample table:
 * <pre>
 * create table cmlib_test (
 *   id int auto_increment primary key,
 *   name varchar(255),
 *   num float default 0
 * );
 * 
 * mysql> insert into cmlib_test (name, num) values ('John Smith', 3.7);
 * 
 * mysql> select * from cmlib_test;
 * +----+------------+------+
 * | id | name       | num  |
 * +----+------------+------+
 * |  1 | John Smith |  3.7 | 
 * +----+------------+------+
 * 1 row in set (0.00 sec)
 * </pre>
 * 
 * But when we try to query the table:
 * <pre>
 * mysql> select * from cmlib_test where num = 3.7;
 * Empty set (0.00 sec)
 * 
 * mysql> select * from cmlib_test where num > 3.7;
 * +----+------------+------+
 * | id | name       | num  |
 * +----+------------+------+
 * |  1 | John Smith |  3.7 | 
 * +----+------------+------+
 * 1 row in set (0.00 sec)
 * </pre>
 * 
 * If we up the precision you can see the problem:
 * <pre>
 * mysql> select num*1.0 from cmlib_test;
 * +------------------+
 * | num*1.0          |
 * +------------------+
 * | 3.70000004768372 | 
 * +------------------+
 * 1 row in set (0.00 sec)
 * </pre>
 * 
 * Use a different type and try again:
 * <pre>
 * mysql> alter table cmlib_test modify column num decimal(18,6);
 * Query OK, 1 row affected, 1 warning (0.13 sec)
 * Records: 1  Duplicates: 0  Warnings: 1
 * 
 * mysql> select * from cmlib_test where num=3.7;
 * +----+------------+----------+
 * | id | name       | num      |
 * +----+------------+----------+
 * |  1 | John Smith | 3.700000 | 
 * +----+------------+----------+
 * 1 row in set (0.00 sec)
 * </pre>
 * 
 * As you can see it works now.
 * 
 * 
 * @section manual_fmt_decimal_math Arithmetic operations
 * PHP 5.2 does not nativly support operator overloading, until (or if) the feature ever becomes
 * available you will have to use the following methods:
 * <table>
 *   <tr>
 *     <th>Operator</th>
 *     <th>Method</th>
 *   </tr>
 *   <tr>
 *     <td><tt>=</tt></td>
 *     <td>\c set()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>+</tt></td>
 *     <td>\c add()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>-</tt></td>
 *     <td>\c subtract()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>*</tt></td>
 *     <td>\c multiply()</td>
 *   </tr>
 *   <tr>
 *     <td><tt>/</tt></td>
 *     <td>\c divide()</td>
 *   </tr>
 * </table>
 * 
 * The following code:
 * @code
 * $a = 5.2;
 * $b = ($a + 2.3) / 1.3;
 * @endcode
 * 
 * Using CMDecimal would work like:
 * @code
 * $a = new CMDecimal(8, 1, 5.2);
 * $b = $a->add(2.3)->divide(1.3);
 * @endcode
 * 
 * 
 * @section manual_fmt_decimal_native Native integration
 * Like all \c CM classes, CMDecimal overrides the <tt>__toString()</tt> method so that a
 * CMDecimal object passed to any other function that doesn't understand/expect it can use it.
 * 
 * For example:
 * @code
 * $cost = new CMDecimal(8, 2, 15.35);
 * $msg = "The product costs \$$cost";  // The product costs $15.35
 * @endcode
 * 
 */

?>
