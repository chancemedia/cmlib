<?php

include_once("CMValidator.php");

/**
 * @brief Validator for CMDataModel.
 * 
 * @author Elliot Chance
 */
class CMDataModelValidator extends CMValidator {
	
	/**
	 * @brief The version of this class.
	 * @return String version.
	 * @see CMVersion
	 */
	public static function Version() {
		return "1.0";
	}
	
	/**
	 * @brief The version this class was introduced to the library.
	 * @return String version.
	 * @see CMVersion
	 */
	public static function Since() {
		return "1.0";
	}
	
	/**
	 * @brief Create a CMDataModelValidtor with the supplied rules.
	 * 
	 * @param $rules A string representing the validation rules. See \ref cmvalidator_rules
	 */
	public function CMDataModelValidator($rules) {
		$this->addRules($rules);
	}
	
	/**
	 * @brief Append (add) new rules.
	 * 
	 * @param $rules A string or array representing the validation rules. See \ref cmvalidator_rules.
	 * @return \true
	 */
	public function addRules($rules) {
		if(is_array($rules))
			$parts = $rules;
		else $parts = explode(' ', $rules);
		
		foreach($parts as $p) {
			$p = trim($p);
			if($p == '') continue;
			$this->addRule($p);
		}
		
		return true;
	}
	
	/**
	 * @brief Append (add) a single rule.
	 * 
	 * @param $rule A string representing the validation rules. See \ref cmvalidator_rules
	 * @return \true
	 */
	public function appendRule($rule) {
		$newrule = array(
			'field' => false,
			'mandatory' => false,
			'empty' => false,
			'type' => false, // false, 'email', 'number'
		);
		
		for($i = 0; $i < strlen($rule); ++$i) {
			$c = substr($rule, $i, 1);
			if(ctype_alnum($c)) {
				$newrule['field'] = substr($rule, $i);
				array_push($this->rules, $newrule);
				return true;
			}
			
			if($c == '+')
				$newrule['mandatory'] = true;
			elseif($c == '-')
				$newrule['empty'] = true;
			elseif($c == '@')
				$newrule['type'] = 'email';
			elseif($c == '#')
				$newrule['type'] = 'number';
		}
		
		return true;
	}
	
	/**
	 * @brief Perform validation.
	 * 
	 * @param $dm The CMDataModel object that will provide the data to validate against.
	 * @return \true or \false depending on if all of the rules validate.
	 * @see isValid()
	 */
	public function validate($dm = false) {
		$this->invalidFields = array();
		
		foreach($this->rules as $rule) {
			list($name, $value) = $dm->extractNameValue($rule['field']);
			
			// the rule must exist in the pool
			if($value === NULL)
				$this->invalidFields[$name]['missing'] = "Field was not posted";
			
			// check a mandatory field has a value
			if($rule['mandatory'] && trim($value) == '')
				$this->invalidFields[$name]['mandatory'] = "This field is mandatory";
			
			// check a blank field is blank
			if($rule['empty'] && trim($value) == '')
				$this->invalidFields[$name]['empty'] = "This field must be empty";
		
			// validate email
			if($rule['type'] == "email" && !$this->isValidEmail($value))
				$this->invalidFields[$name]['email'] = "Not a valid email address";
		
			// validate number
			if($rule['type'] == "number" && !$this->isValidNumber($value))
				$this->invalidFields[$name]['number'] = "Not a number";
		}
		
		return $this->isValid();
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
