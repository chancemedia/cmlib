<?php

class CMBox {
	
	public $a;
	
	public function CMBox(array $a = array()) {
		$this->a = $a;
	}
	
	public function draw(array $attr = array()) {
		// overrides
		$a = $this->a;
		foreach($attr as $k => $v)
			$a[$k] = $v;
			
		// start
		$r = "<table";
		foreach($a as $k => $v) {
			if(substr($k, 0, 4) == 'box.')
				$r .= " " . substr($k, 4) . "=\"$v\"";
		}
		$r .= ">";
		
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
