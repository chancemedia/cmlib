<?php

include_once("CMObject.php");

/**
 * @brief iCalendar object.
 * 
 * @author Elliot Chance
 * @see CMFileICAL
 */
class CMICalendar implements CMObject {
	
	/**
	 * @brief Create iCal entry.
	 * 
	 * @param $start The begin time.
	 * @param $end The end time.
	 * @param $summary Short description.
	 * @param $description Longer description.
	 * @param $company Company name.
	 * @param $uid Unique ID.
	 */
	public static function CreateICal($start, $end, $summary, $description, $company, $uid = false) {
		if($uid === false)
			$uid = md5(date('Ymd') . date('His'));
			
		$c = "BEGIN:VCALENDAR\n";
		$c .= "VERSION:2.0\n";
		$c .= "PRODID:-//$company//NONSGML $company//EN\n";
		$c .= "METHOD:REQUEST\n"; // requied by Outlook
		$c .= "BEGIN:VEVENT\n";
		$c .= "UID:$uid\n"; // required by Outlook
		$c .= "DTSTAMP:" . date('Ymd') . 'T' . date('His') . "\n"; // required by Outlook
		$c .= "DTSTART:$start\n";
		$c .= "DTEND:$end\n";
		$c .= "SUMMARY:$summary\n";
		$c .= "DESCRIPTION:$description\n";
		$c .= "END:VEVENT\n";
		$c .= "END:VCALENDAR\n";
		
		return $c;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
