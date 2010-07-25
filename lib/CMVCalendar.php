<?php

include_once("CMObject.php");

/**
 * @brief iCalendar object.
 * 
 * @author Elliot Chance
 * @see CMFileICAL
 */
class CMVCalendar implements CMObject {
	
	public $items = array();
	
	public $version = "2.0";
	
	public $prodID;
	
	public function CMVCalendar($company = "Chance MEDIA", $product = "CMLIB") {
		$this->prodID = "-//$company//NONSGML $product//EN";
	}
	
	public function addItem($item) {
		array_push($this->items, $item);
		return true;
	}
	
	private function eventsToString($event, $indent = "  ") {
		$r = $indent . $event->type . " (\n";
			
		foreach($event->attr as $k => $v) {
			$r .= "$indent  $k";
			foreach($v as $k2 => $v2) {
				if($k2 != "VALUE")
					$r .= ";$k2=$v2";
			}
			$r .= " = " . $v['VALUE'] . "\n";
		}
			
		// children
		if(count($event->children) > 0)
			$r .= $this->eventsToString($event->children[0], "$indent  ");
				
		$r .= "$indent)\n";
		
		return $r;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		$r = "CMVCalendar (\n";
		$r .= "  VERSION = " . $this->version . "\n";
		$r .= "  PRODID = " . $this->prodID . "\n";
		
		foreach($this->items as $event)
			$r .= $this->eventsToString($event);
			
		$r .= ")\n";
		return $r;
	}
	
}

?>
