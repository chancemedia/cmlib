<?php

/**
 * @page manual_fmt_constants 4.3. Constants
 * 
 * 
 * @section manual_fmt_constants_contents Contents
 * -# \ref manual_fmt_constants_intro
 * -# \ref manual_fmt_constants_usage
 * -# \ref manual_fmt_constants_native
 * 
 * 
 * @section manual_fmt_constants_intro Introduction
 * The automatic nature of CMLIB means that values are parsed to be safe with the system they are
 * going to be used with. A simple example of this is a string that is passed to a database will
 * be escaped to make sure the value will not cause the SQL to fail.
 * 
 * In some cases you may want to avoid this. Using the example above, a SQL statement may include
 * strings, numbers but also expressions which should not be escaped. The CMConstant class is simply
 * a wrapper around a value of any type. Contrary to the name the value inside the CMConstant object
 * remains always malleable.
 * 
 * 
 * @section manual_fmt_constants_usage Usage
 * Creating a constant is very easy, simply send the value as a single argument to the constructor:
 * @code
 * $value = new CMConstant("some value");
 * @endcode
 * 
 * Or pass it directly to a database without it escaping the value:
 * @code
 * $dbh->insert('mytable', array(
 *   'name' => "Bob Smith",
 *   'secretnumber' => 34.5,
 *   'created' => new CMConstant("now()")
 * );
 * @endcode
 * 
 * Will generate and execute the SQL:
 * <pre>
 * INSERT INTO mytable (name, secretnumber, created)
 * VALUES ('Bob Smith', '34.5', now());
 * </pre>
 * 
 * 
 * @section manual_fmt_constants_native Native integration
 * Like all \c CM classes, CMConstant overrides the <tt>__toString()</tt> method so that a
 * CMConstant object passed to any other function that doesn't understand/expect it can use it.
 * 
 * For example:
 * @code
 * $msg = new CMConstant("Hello");
 * $name = "Bob Smith";
 * $greeting = "$msg $name!";      // Hello Bob Smith!
 * @endcode
 * 
 */

?>
