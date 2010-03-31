<?php

include_once('CMClass.php');

/**
 * @brief Validation interface.
 * 
 * @author Elliot Chance
 */
class CMValidator implements CMClass {
	
	/**
	 * @brief An array of invalid field names.
	 */
	public $invalidFields = array();
	
	/**
	 * @brief Validation rules.
	 * 
	 * @see addRules()
	 * @see addRule()
	 */
	public $rules = array();
	
	/**
	 * @brief Perform validation.
	 * 
	 * @param $a
	 */
	public function validate($a = false) {
		return false;
	}
	
	/**
	 * @brief Check if the the last validation succeeded.
	 */
	public function isValid() {
		return count($this->invalidFields) == 0;
	}
	
	/**
	 * @brief Test email address.
	 * 
	 * @param $email The email address to test.
	 */
	public function isValidEmail($email) {
		if($email == "") return true;
		return strpos($email, '@') !== false && strpos($email, '.') !== false;
	}
	
	/**
	 * @brief Test numeric value.
	 * 
	 * @param $number The number to test.
	 */
	public function isValidNumber($number) {
		if($number == "") return true;
		return is_numeric($number);
	}
	
	/**
	 * @brief Return and array of field names that are not valid.
	 */
	public function getInvalidFields() {
		return $this->invalidFields;
	}
	
	/**
	 * @brief Add multiple rules.
	 * 
	 * @param $rules
	 */
	public function addRules($rules) {
		return false;
	}
	
	/**
	 * @brief Add single rule.
	 * 
	 * @param $rule
	 */
	public function addRule($rule) {
		return false;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
