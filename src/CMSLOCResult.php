<?php

include_once('CMObject.php');

/**
 * @brief CMSLOC result object.
 * 
 * See CMSLOC.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMSLOCResult implements CMObject {
	
	/**
	 * @brief The total number of files processed.
	 */
	public $files = 0;
	
	/**
	 * @brief The physical lines are the number of new line characters + 1 in each file.
	 */
	public $physicalLines = 0;
	
	/**
	 * @brief Logical lines of code.
	 * 
	 * Logical lines are determined by:
	 * 
	 * Each semi-colon represents 1 point. Each block declaration (such as a class, function, etc
	 * declaration) represents 1 point. Each statement (if, while etc) represents 1 point. 'for' statements
	 * represent 3 points.
	 */
	public $logicalLines = 0;
	
	/**
	 * @brief The number of bare functions.
	 * 
	 * Bare functions are functions that do not belong to a class.
	 */
	public $functions = 0;
	
	/**
	 * @brief The number of classes.
	 */
	public $classes = 0;
	
	/**
	 * @brief Methods are non-static class functions.
	 */
	public $methods = 0;
	
	/**
	 * @brief Static methods are static functions that belong to a class.
	 */
	public $staticMethods = 0;
	
	/**
	 * @brief The total number of single characters.
	 */
	public $characters = 0;
	
	/**
	 * @brief Blank lines include lines that only include whitespace.
	 */
	public $blankLines = 0;
	
	/**
	 * @brief The total lines for commenting.
	 */
	public $commentLines = 0;
	
	/**
	 * @brief Total number of interfaces.
	 */
	public $interfaces = 0;
	
	/**
	 * @brief Method declarations inside an interface.
	 */
	public $interfaceMethods = 0;
	
	/**
	 * @brief Print a single line formatted result.
	 * 
	 * @param $name Key
	 * @param $value Numerical value
	 * @param $nl String to print after the line.
	 * @return Always \true.
	 */
	public function printField($name, $value, $nl) {
		echo "$name = " . number_format($value, 0) . $nl;
		return true;
	}
	
	/**
	 * @brief Print all results.
	 * 
	 * @param $nl String to print after the line.
	 * @return Always \true.
	 */
	public function printResults($nl = "\n") {
		$this->printField("blankLines      ", $this->blankLines, $nl);
		$this->printField("characters      ", $this->characters, $nl);
		$this->printField("classes         ", $this->classes, $nl);
		$this->printField("commentLines    ", $this->commentLines, $nl);
		$this->printField("files           ", $this->files, $nl);
		$this->printField("functions       ", $this->functions, $nl);
		$this->printField("interfaceMethods", $this->interfaceMethods, $nl);
		$this->printField("interfaces      ", $this->interfaces, $nl);
		$this->printField("logicalLines    ", $this->logicalLines, $nl);
		$this->printField("methods         ", $this->methods, $nl);
		$this->printField("physicalLines   ", $this->physicalLines, $nl);
		$this->printField("staticMethods   ", $this->staticMethods, $nl);
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
