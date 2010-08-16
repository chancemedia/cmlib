<?php

include_once("CMClass.php");

// commit 3

/**
 * @brief Building HTML objects.
 * 
 * @section cmhtml_desc Description
 * This class can be used for generating HTML objects, such as tables that would otherwise be time
 * consuming.
 * 
 * @section cmhtml_example
 * Example 1: Building a table from a database query:
 * @code
 * $dbh = new CMMySQL("mysql://root:abc123@localhost/test");
 * echo CMHTML::Table(array(
 *   'header' => array('ID', 'First name', 'Last name'),
 *   'data' => $dbh->query("select * from dummy")
 * ));
 * @endcode
 * 
 * @author Elliot Chance
 */
class CMHTML implements CMClass {
	
	/**
	 * @brief Build a HTML table
	 * 
	 * All of the provided attributes can be database query handles, but it's important to note that the
	 * query handle will be converted into an array - but unless it is needed as an array it will take
	 * the first element as the value. For example:
	 * @code
	 * echo CMHTML::Table(array(
	 *   'cellspacing' => $dbh->query("select tablespacing, name from mytable limit 3")
	 * ));
	 * @endcode
	 * As <tt>cellspacing</tt> is not recognised in the table below it is assumed to be a single value
	 * attribute for the &lt;table&gt; tag, so the output may look something like this:
	 * @code
	 * <table cellspacing="5">
	 *   ...
	 * </table>
	 * @endcode
	 * 
	 * @param $a Attributes
	 * Any attribute provided that is not listed in the table below will be added as an attribute to the
	 * &lt;table&gt; tag - examples include <tt>cellpadding</tt>, <tt>style</tt> etc.
	 * <table>
	 *   <tr>
	 *     <th>Name</th>
	 *     <th>Description</th>
	 *   </tr>
	 *   <tr>
	 *     <td><tt>data</tt></td>
	 *     <td>Can be a 2 dimentional array, or a database query handle.</td>
	 *   </tr>
	 *   <tr>
	 *     <td><tt>header</tt></td>
	 *     <td>An array, or a database query handle.</td>
	 *   </tr>
	 * </table>
	 */
	public static function Table($a) {
		// convert queries to data, we dont want to convert the 'data' key because it might be
		// very large
		foreach($a as $k => $v) {
			if($a[$k] instanceof CMQueryProtocol && $k != 'data')
				$a[$k] = $a[$k]->fetchAll('cell', 'vertical');
		}
		
		// create the <table> tag
		$r = "<table";
		foreach($a as $k => $v) {
			if(!in_array($k, array('data', 'header')))
				$r .= " $k=\"$v\"";
		}
		$r .= ">";
		
		// find the maximum amount of columns
		$cols = 1;
		if(is_array($a['data'])) {
			foreach($a['data'] as $row) {
				if(is_array($row)) {
					if(count($row) > $cols)
						$cols = count($row);
				}
			}
		}
		echo "cols = $cols";
		
		// header
		if(isset($a['header'])) {
			$r .= "<tr>";
			foreach($a['header'] as $cell)
				$r .= "<th>$cell</th>";
			$r .= "</tr>";
		}
		
		// a normal data array
		if(is_array($a['data'])) {
			foreach($a['data'] as $row) {
				$r .= "<tr>";
				
				if(is_array($row)) {
					foreach($row as $cell) {
						$r .= "<td";
						if(count($row) != $cols)
							$r .= ' colspan="' . ($cols - count($row) + 1) . '"';
						$r .= ">$cell</td>";
					}
				}
				else {
					$r .= "<td";
					if($cols != 1)
						$r .= ' colspan="' . $cols . '"';
					$r .= ">$row</td>";
				}
					
				$r .= "</tr>";
			}
		}
		
		// a database query handle
		elseif($a['data'] instanceof CMQueryProtocol) {
			while($row = $a['data']->fetch()) {
				$r .= "<tr>";
				foreach($row as $cell)
					$r .= "<td>$cell</td>";
				$r .= "</tr>";
			}
		}
		
		$r .= "</table>\n";
		return $r;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
