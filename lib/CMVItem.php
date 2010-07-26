<?php

include_once('CMObject.php');

/**
 * @brief Used by CMVCalendar.
 * 
 * @author Elliot Chance
 */
class CMVItem implements CMObject {
	
	/**
	 * @brief The type of item.
	 * Official types include "VEVENT", "VTODO", "VJOURNAL", "VFREEBUSY".
	 */
	public $type = "";
	
	/**
	 * @brief Attributes.
	 * See \ref cmvcalendar_properties.
	 */
	public $attr = array();
	
	/**
	 * @brief Sub-items.
	 * This is often used for VALARM.
	 */
	public $children = array();
	
	/**
	 * @brief Create a CMVItem of a given type.
	 * @param $type Item type.
	 * @see $type
	 */
	public function CMVItem($type) {
		$this->type = strtoupper($type);
	}
	
	/**
	 * @brief Add an attribute.
	 * 
	 * Attributes are not not unique and multiple attributes can exist with the same name and value.
	 * 
	 * @param $attr Attribute name. This is non-casesensitive, but it will be converted to uppercase.
	 * @param $value Attribute value.
	 * @param $a Extra subattributes.
	 */
	public function addAttribute($attr, $value, $a = array()) {
		$add = array('VALUE' => $value);
		foreach($a as $k => $v)
			$add[strtoupper($k)] = $v;
		$this->attr[strtoupper($attr)][] = $add;
		return true;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
	/**
	 * @brief Create iCal VEVENT.
	 * 
	 * @param $start The begin time.
	 * @param $end The end time.
	 * @param $summary Short description.
	 * @param $description Full description.
	 * @param $a Extra attributes.
	 */
	public static function CreateEvent($start, $end, $summary, $description, $a = array()) {
		// turn keys uppercase
		foreach($a as $k => $v)
			$a[strtoupper($k)] = $v;
		
		if(is_numeric($start))
			$a['DTSTART'] = @date('Ymd', $start) . 'T' . @date('His', $start);
		else
			$a['DTSTART'] = $start;
			
		if(is_numeric($end))
			$a['DTEND'] = @date('Ymd', $end) . 'T' . @date('His', $end);
		else
			$a['DTEND'] = $end;
			
		$a['SUMMARY'] = $summary;
		$a['DESCRIPTION'] = $description;
		
		// required by Outlook
		$a['DTSTAMP'] = @date('Ymd') . 'T' . @date('His');
		$a['METHOD'] = "REQUEST";
		if(!isset($a['UID']))
			$a['UID'] = md5(@date('YmdHis'));
			
		$r = new CMVItem("VEVENT");
		foreach($a as $k => $v)
			$r->addAttribute($k, $v);
		
		return $r;
	}
	
}

?>
