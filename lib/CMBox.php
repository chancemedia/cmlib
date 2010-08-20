<?php

/**
 * @brief Drawing HTML boxes/containers.
 * @author Elliot Chance
 */
class CMBox {
	
	/**
	 * @brief Default attributes.
	 */
	public $a;
	
	/**
	 * @brief Initialise box object.
	 * @param $a Attributes.
	 */
	public function CMBox(array $a = array()) {
		$this->a = $a;
	}
	
	/**
	 * @brief Draw a new box.
	 * @param $attr Overriding attributes.
	 */
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
		if(isset($a['title'])) {
			$r .= "<tr><td";
			foreach($a as $k => $v) {
				if(substr($k, 0, 6) == 'title.')
					$r .= " " . substr($k, 6) . "=\"$v\"";
			}
			$r .= ">$a[title]</td></tr>";
		}
			
		// body
		$r .= "<tr><td>$a[body]</td></tr>";
		
		// end
		$r .= "</table>";
		return $r;
	}
	
}

?>
