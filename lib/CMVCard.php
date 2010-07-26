<?php

include_once("CMObject.php");

/**
 * @brief vCard.
 * 
 * @author Elliot Chance
 * @see CMFileVCF
 */
class CMVCard implements CMObject {
	
	/**
	 * @brief To hold the vCard data.
	 * 
	 * Use the other methods of this class to manipulate the vCard data.
	 */
	private $data = array();
	
	/**
	 * @brief vCard version.
	 * @see CMVCard()
	 * @see getVersion()
	 * @see setVersion()
	 */
	private $version = "3.0";
	
	/**
	 * @brief Create a new vCard.
	 * 
	 * @param $version An optional version for the vCard. Unless you have a special reason to force your
	 *        vCard into an older format it is recommnded you leave this option out.
	 */
	public function CMVCard($version = "3.0") {
		$this->version = $version;
	}
	
	/**
	 * @brief Get the version of this vCard.
	 * 
	 * @return vCard version as a string.
	 */
	public function getVersion() {
		return $this->version;
	}
	
	/**
	 * @brief Manually set the version of this vCard.
	 * 
	 * @param $newVersion The new vCard version.
	 * @return \true.
	 */
	public function setVersion($newVersion) {
		$this->version = $newVersion;
		return true;
	}
	
	/**
	 * @brief Get a property
	 * 
	 * Properties are always an array, even when there is only one value associated with it.
	 * 
	 * @param $property Property name.
	 * @return An array of values associated with a property.
	 */
	public function get($property) {
		return $this->data[strtoupper($property)];
	}
	
	/**
	 * @brief Set a property.
	 * 
	 * This method works differently from add() as this replaces all of the values associated with a
	 * property with the new value given. You are allowed to supply a string (which will automatically
	 * be converted into a single element array) or an array.
	 * 
	 * @param $property The name of the property, this must be a string.
	 * @param $value A string value or an array of values to set the property to.
	 * @return \true.
	 */
	public function set($property, $value, $attr = array()) {
		// $value must be an array
		if(!is_array($value))
			$value = array($value);
		
		$this->data[strtoupper($property)] = $value;
		return true;
	}
	
	/**
	 * @brief Add a value to an attribute.
	 * 
	 * You may give an array for $value to add multiple values to the property.
	 * 
	 * @note This function does not check if the value is already associated with a property and always
	 * adds the new value on. For value checking see addUnique().
	 * 
	 * @param $property The name of the property, this must be a string. This is not case sensitive, all
	 *        property names will always be converted and treated as upper case.
	 * @param $value A string value or an array of multiple values to add.
	 * @return \true.
	 */
	public function add($property, $value, $attr = array()) {
		// add multiple values
		if(is_array($value)) {
			foreach($value as $v)
				$this->add($property, $v);
			return true;
		}
		
		// add a single value
		$property = strtoupper($property);
		if(!isset($this->data[$property]))
			$this->data[$property] = array();
		array_push($this->data[$property], array('value' => $value, 'attr' => $attr));
		
		return true;
	}
	
	/**
	 * @brief Add a value to a property only if it doesnt exist yet.
	 * 
	 * This function works in the same way as add() but only adds the value(s) if they do not exist on
	 * the property.
	 * 
	 * @param $property The name of the property, this must be a string. This is not case sensitive, all
	 *        property names will always be converted and treated as upper case.
	 * @param $value A string value or an array of multiple values to add.
	 * @return \true.
	 */
	public function addUnique($property, $value) {
		// add multiple values
		if(is_array($value)) {
			foreach($value as $v)
				$this->addUnique($property, $v);
			return true;
		}
		
		// add a single value
		$property = strtoupper($property);
		if(!in_array($value, $this->data[$property]))
			array_push($this->data[$property], $value);
			
		return true;
	}
	
	/**
	 * @brief Remove all values associated with a property.
	 * 
	 * @param $property The name of the property, this must be a string. This is not case sensitive, all
	 *        property names will always be converted and treated as upper case.
	 * @return \true.
	 */
	public function remove($property) {
		$property = strtoupper($property);
		if(isset($this->data[$property]))
			unset($this->data[$property]);
		return true;
	}
	
	/**
	 * @brief Create a vCard and return the result.
	 * 
	 * @param $values
	 */
	public static function CreateVCard($values) {
		$r = "BEGIN:VCARD\n";
		foreach($values as $k => $v) {
			$r .= strtoupper(trim(str_replace(':', '\:', $k)));
			if(is_array($v['attr']))
				$r .= ';' . implode(';', $v['attr']);
			$r .= ":" . str_replace(':', '\:', $v['value']) . "\n";
		}
		return $r . "END:VCARD\n";
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		if(isset($this->data['FN']))
			return "<" . get_class($this) . ": " . $this->data['FN'][0] . ">";
		return "<" . get_class($this) . ": (unnamed)>";
	}
	
	public function getDisplayName() {
		// use the FN if it exists
		if(isset($this->data['FN']))
			return $this->data['FN'][0]['value'];
			
		return "No name";
	}
	
}

?>
