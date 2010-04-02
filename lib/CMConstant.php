<?php

include_once("CMClass.php");

/**
 * @brief A container for value that need not be modified or encapsulated.
 * 
 * @section cmconstant_desc Description
 * Despite the name 'Constant' this class allows the value to be freely changed via the CMConstant::$value
 * attribute. The purpose of this class is to create a container of a value that when passed ot a function
 * or method that would normally encapsulate its value not to.
 * 
 * A simple example is when you perform a database INSERT where the data is provided with an associative
 * array and every value is automatically escaped so that it translates to the database engine safely.
 * However sometimes it may be an expression or function in which case encapsutating it would stop it working.
 * By wraping the value in CMConstant the database protocol knows not to encapsulate it and simply
 * substitute CMConstant::$value.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMConstant implements CMClass {
	
	/**
	 * @brief Actual value.
	 */
	public $value = false;
	
	/**
	 * @brief Construct a new CMConstant object.
	 * 
	 * @param $value Value to wrap around.
	 */
	public function CMConstant($value = false) {
		$this->value = $value;
	}
	
	/**
	 * @brief Return the string value of this object.
	 * 
	 * The $value is converted in a string using the standard PHP rules. Some examples are:
	 * @code
	 * "<CMConstant: 12>"
	 * "<CMConstant: Bob Smith>"
	 * @endcode
	 */
	public function __toString() {
		return "<" . get_class($this) . ": " . $this->value . ">";
	}
	
}

?>
