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
	 * See full description and usage at \ref manual_html_table.
	 *
	 * @param $a Attributes that build the table.
	 * @return Fully rendered HTML, it will not print the result.
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
			if(in_array($k, array('cellpadding', 'cellspacing', 'border', 'style', 'class', 'id', 'name', 'width')))
				$r .= " $k=\"$v\"";
		}
		$r .= ">";
		
		// find the maximum amount of columns
		$cols = 1;
		if(is_array($a['data'])) {
			foreach($a['data'] as $row) {
				if(is_array($row)) {
					$count = CMHTML::CountColumns($row);
					if($count > $cols)
						$cols = $count;
				}
			}
		}
		
		// header
		if(isset($a['header'])) {
			$r .= "<tr>";
			foreach($a['header'] as $cell)
				$r .= "<th>$cell</th>";
			$r .= "</tr>";
		}
		
		// a normal data array
		if(is_array($a['data'])) {
			$rowid = 0;
			foreach($a['data'] as $row) {
				$trstyle = '';
				if(isset($row['style']))
					$trstyle = ' style="' . $row['style'] . '"';
				elseif(isset($a['trstyle'])) {
					if(is_object($a['trstyle']))
						$trstyle = ' style="' . $a['trstyle'](array_merge($row, array('rowid' => $rowid))) . '"';
					else
						$trstyle = ' style="' . $a['trstyle'] . '"';
				}
				
				$r .= "<tr$trstyle>";
				
				if(!is_array($row))
					$row = array($row);
				
				$i = 0;
				foreach($row as $k => $cell) {
					// skip style
					if(!is_numeric($k))
						continue;
						
					$tdstyle = '';
					if(isset($row["style@$i"]))
						$tdstyle = ' style="' . $row["style@$i"] . '"';
					elseif(isset($row["tdstyle"])) {
						if(is_object($row["tdstyle"]))
							$tdstyle = ' style="' . $row["tdstyle"](array_merge($row, array('rowid' => $rowid, 'colid' => $i))) . '"';
						else
							$tdstyle = ' style="' . $row["tdstyle"] . '"';
					}
					elseif(isset($a['tdstyle'])) {
						if(is_object($a['tdstyle']))
							$tdstyle = ' style="' . $a['tdstyle'](array_merge($row, array('rowid' => $rowid, 'colid' => $i))) . '"';
						else
							$tdstyle = ' style="' . $a['tdstyle'] . '"';
					}
						
					$r .= CMHTML::RenderCell($rowid, $a, $i, $row, $cell, $cols, $tdstyle);
					++$i;
				}
					
				++$rowid;
				$r .= "</tr>";
			}
		}
		
		// a database query handle
		elseif($a['data'] instanceof CMQueryProtocol) {
			$rowid = 0;
			while($row = $a['data']->fetch()) {
				$trstyle = '';
				if(isset($row['style']))
					$trstyle = ' style="' . $row['style'] . '"';
				elseif(isset($a['trstyle'])) {
					if(is_object($a['trstyle']))
						$trstyle = ' style="' . $a['trstyle'](array_merge($row, array('rowid' => $rowid))) . '"';
					else
						$trstyle = ' style="' . $a['trstyle'] . '"';
				}
						
				$r .= "<tr$trstyle>";
						
				$i = 0;
				foreach($row as $cell) {
					$tdstyle = '';
					if(isset($row["style@$i"]))
						$tdstyle = ' style="' . $row["style@$i"] . '"';
					elseif(isset($row["tdstyle"])) {
						if(is_object($row["tdstyle"]))
							$tdstyle = ' style="' . $row["tdstyle"](array_merge($row, array('rowid' => $rowid, 'colid' => $i))) . '"';
						else
							$tdstyle = ' style="' . $row["tdstyle"] . '"';
					}
					elseif(isset($a['tdstyle'])) {
						if(is_object($a['tdstyle']))
							$tdstyle = ' style="' . $a['tdstyle'](array_merge($row, array('rowid' => $rowid, 'colid' => $i))) . '"';
						else
							$tdstyle = ' style="' . $a['tdstyle'] . '"';
					}
						
					$r .= CMHTML::RenderCell($rowid, $a, $i, $row, $cell, 0, $tdstyle);
					++$i;
				}
				
				++$rowid;
				$r .= "</tr>";
			}
		}
		
		$r .= "</table>\n";
		return $r;
	}
	
	/**
	 * @brief Render a table cell.
	 * @param $rowid
	 * @param $a
	 * @param $i
	 * @param $row
	 * @param $cell
	 * @param $cols
	 * @param $tdstyle
	 * @return Rendered table cell.
	 */
	private static function RenderCell($rowid, $a, $i, $row, $cell, $cols, $tdstyle) {
		// look for the data replacer
		if(isset($a["data@$i"])) {
			if(is_object($a["data@$i"]))
				$cell = $a["data@$i"](array_merge($row, array('rowid' => $rowid, 'colid' => $i)));
			else
				$cell = $a["data@$i"];
		}
		
		$r = "<td$tdstyle";
		$count = CMHTML::CountColumns($row);
		if($count != $cols)
			$r .= ' colspan="' . ($cols - $count + 1) . '"';
		$r .= ">$cell</td>";
						
		return $r;
	}
	
	/**
	 * @brief Internal method to count the real number of table cells.
	 * @param $row The row of value to filter.
	 */
	private static function CountColumns($row) {
		$count = 0;
		
		if(is_array($row)) {
			foreach($row as $k => $v) {
				if(is_numeric($k))
					++$count;
			}
		}
		else
			$count = 1;
			
		return $count;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
	/**
	 * @brief Print a box (container.)
	 * @param $a Attributes.
	 */
	public function Box($a) {
		// defaults
		if(!is_array($a))
			$a = array($a);
			
		if(!isset($a['cellspacing']))
			$a['cellspacing'] = 0;
		if(!isset($a['cellpadding']))
			$a['cellpadding'] = 3;
		if(!isset($a['border']))
			$a['border'] = 0;
			
		// start
		$r = "<table cellspacing=\"$a[cellspacing]\" cellpadding=\"$a[cellpadding]\" border=\"$a[border]\" style=\"border: solid 1px #CCCCCC\">";
		
		// title
		if(isset($a['title']))
			$r .= "<tr><td style=\"background-color: #CCCCCC\">$a[title]</td></tr>";
			
		// body
		$r .= "<tr><td>$a[body]</td></tr>";
		
		// end
		$r .= "</table>";
		return $r;
	}
	
}

?>
