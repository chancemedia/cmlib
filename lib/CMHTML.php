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
		
		// get the table id or create one, we may need this later
		$table_id = substr(md5(time()), 0, 8);
		if(isset($a['table.id']))
			$table_id = $a['table.id'];
		
		// create the <table> tag
		$r = CMHTML::BuildTag('table', 'table.', $a);
		
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
		
		// generate header (and save for later)
		$header = '';
		if(isset($a['header'])) {
			$header .= CMHTML::BuildTag('tr', 'thead.', $a);
			
			foreach($a['header'] as $cell)
				$header .= CMHTML::BuildTag('th', 'th.', $a) . $cell . '</th>';
				
			$header .= '</tr>';
			$r .= $header;
		}
		
		// a normal data array
		if(is_array($a['data'])) {
			$rowid = 0;
			foreach($a['data'] as $row) {
				if(!is_array($row))
					$row = array($row);
				
				// create id
				if(isset($a['ids']) && $a['ids'])
					$row['tr.id'] = "{$table_id}_tr$rowid";
				
				$r .= CMHTML::BuildTag('tr', 'tr.', $a, $row, array_merge($row, array('rowid' => $rowid)));
				
				$i = 0;
				foreach($row as $k => $cell) {
					// create id
					if(isset($a['ids']) && $a['ids'])
						$row['td.id'] = "{$table_id}_tr{$rowid}_td$i";
					if(CMHTML::CountColumns($row) != $cols)
						$row['td.colspan'] = $cols - CMHTML::CountColumns($row) + 1;
						
					// skip tag attributes
					if(substr($k, 0, 3) == 'tr.' || substr($k, 0, 3) == 'td.')
						continue;
						
					// data replacer
					if(isset($a["data@$i"])) {
						if(is_object($a["data@$i"]))
							$cell = $a["data@$i"](array_merge($row, array('rowid' => $rowid, 'colid' => $i)));
						else
							$cell = $a["data@$i"];
					}
						
					$r .= CMHTML::BuildTag('td', 'td.', $a, $row, array_merge($row, array('rowid' => $rowid, 'colid' => $i))) . $cell . '</td>';
					++$i;
				}
					
				++$rowid;
				$r .= "</tr>";
				
				// repeat header
				if(isset($a['repeatheader']) && !($rowid % $a['repeatheader']))
					$r .= $header;
			}
		}
		
		// a database query handle
		elseif($a['data'] instanceof CMQueryProtocol) {
			$rowid = 0;
			while($row = $a['data']->fetch()) {
				// create id
				if(isset($a['ids']) && $a['ids'])
					$row['tr.id'] = "{$table_id}_tr$rowid";
				
				$r .= CMHTML::BuildTag('tr', 'tr.', $a, $row, array_merge($row, array('rowid' => $rowid)));
						
				$i = 0;
				foreach($row as $k => $v) {
					// create id and colspan
					if(isset($a['ids']) && $a['ids'])
						$row['td.id'] = "{$table_id}_tr{$rowid}_td$i";
					
					// skip tag attributes
					if(substr($k, 0, 3) == 'tr.' || substr($k, 0, 3) == 'td.')
						continue;
						
					// data replacer
					if(isset($a["data@$i"])) {
						if(is_object($a["data@$i"]))
							$v = $a["data@$i"](array_merge($row, array('rowid' => $rowid, 'colid' => $i)));
						else
							$v = $a["data@$i"];
					}
						
					$r .= CMHTML::BuildTag('td', 'td.', $a, $row, array_merge($row, array('rowid' => $rowid, 'colid' => $i))) . $v . '</td>';
					++$i;
				}
				
				++$rowid;
				$r .= "</tr>";
				
				// repeat header
				if(isset($a['repeatheader']) && !($rowid % $a['repeatheader']))
					$r .= $header;
			}
		}
		
		$r .= "</table>\n";
		return $r;
	}
	
	/**
	 * @brief Internal method to generate a openeing HTML tag.
	 * @param $tag Actual HTML tag.
	 * @param $look The prefix to look for.
	 * @param $a Global attributes.
	 * @param $row Table row.
	 * @param $args Callback args.
	 * @return HTML open tag.
	 */
	private static function BuildTag($tag, $look, $a, $row = array(), $args = false) {
		$r = "<$tag";
		$attr = array();
		
		// create an array with parent and child attributes
		foreach($a as $k => $v) {
			if(substr($k, 0, strlen($look)) == $look && strpos($k, '@') === false)
				$attr[substr($k, strlen($look))] = $v;
		}
		foreach($row as $k => $v) {
			if(substr($k, 0, strlen($look)) == $look && strpos($k, '@') === false)
				$attr[substr($k, strlen($look))] = $v;
		}
		
		if(isset($args['colid'])) {
			foreach($row as $k => $v) {
				$pos = strpos($k, '@');
				if($pos !== false && substr($k, $pos + 1) == $args['colid']) {
					$pos2 = strpos($k, '.');
					$attr[substr($k, $pos2 + 1, $pos - $pos2 - 1)] = $v;
				}
			}
		}
		
		// create tag
		foreach($attr as $k => $v) {
			if(is_object($v))
				$r .= " $k=\"" . $v($args) . '"';
			else
				$r .= " $k=\"$v\"";
		}
		
		return "$r>";
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
