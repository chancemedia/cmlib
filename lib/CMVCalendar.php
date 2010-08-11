<?php

include_once("CMObject.php");

/**
 * @brief iCalendar object.
 * 
 * @author Elliot Chance
 * @see CMFileICAL
 */
class CMVCalendar implements CMObject {
	
	/**
	 * @brief Items.
	 * @see CMVItem
	 */
	public $items = array();
	
	/**
	 * @brief iCal version.
	 * By default "2.0".
	 */
	public $version = "2.0";
	
	/**
	 * @brief Product ID.
	 * This is automatically geenrated by the constructor with the company and product names.
	 */
	public $prodID;
	
	/**
	 * @brief Create a iCalendar object.
	 * @param $company Company name.
	 * @param $product Product name.
	 */
	public function CMVCalendar($company = "Chance MEDIA", $product = "CMLIB") {
		$this->prodID = "-//$company//NONSGML $product//EN";
	}
	
	/**
	 * @brief Add item.
	 * @param $item VCalendar object.
	 * @return Always \true.
	 */
	public function addItem($item) {
		array_push($this->items, $item);
		return true;
	}
	
	/**
	 * @brief Internal method for converting VCalendar to string.
	 * @param $event VCalendar object.
	 * @param $indent Physical indent.
	 * @return Generated string.
	 */
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
