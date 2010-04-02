<?php

/**
 * @brief Generised library and application testing.
 * 
 * This class is used to tes the CMLIB package itself, but can be use for your own library or application
 * testing.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMTest {
	
	/**
	 * @brief The name of the test.
	 * 
	 * This does not have to be unique, it's simply a label.
	 */
	public $name = "";
	
	/**
	 * @brief The path to the PHP script to be executed.
	 */
	public $script = false;
	
	/**
	 * @brief The indervidual units for this test.
	 */
	public $units = array();
	
	/**
	 * @brief The system executable for PHP.
	 */
	public static $PHP = "php";
	
	/**
	 * @brief The number of units that passed.
	 */
	public $pass = 0;
	
	/**
	 * @brief The number of units that failed.
	 */
	public $fail = 0;
	
	/**
	 * @brief The number of units that were skipped (these do not count as failure).
	 */
	public $skip = 0;
	
	/**
	 * @brief Setup test.
	 * 
	 * @param $name The name of the test, this is just a label.
	 * @param $script The path to the script we will be testing against.
	 */
	public function CMTest($name, $script) {
		$this->name = $name;
		$this->script = $script;
	}
	
	/**
	 * @brief Run a test.
	 */
	public function run() {
		echo $this->name;
		
		// get the test units
		$cmd = CMTest::$PHP . ' ' . $this->script . ' getTestUnits';
		$us = explode(';', `$cmd`);
		foreach($us as $u)
			$this->units[substr($u, 0, strpos($u, '='))] = substr($u, strpos($u, '=') + 1);
		
		// run init(), this can tell us to skip the test
		$cmd = CMTest::$PHP . ' ' . $this->script . ' init';
		$result = `$cmd`;
		if($result == "SKIP") {
			echo " (SKIPPED)";
			return true;
		}
		echo "\n";
			
		// run the units
		$i = 1;
		foreach($this->units as $k => $v) {
			$cmd = CMTest::$PHP . ' ' . $this->script . ' ' . $k;
			$result = `$cmd`;
			echo "  ($i/", count($this->units), ") $result: $v\n";
			if($result == "PASS")
				++$this->pass;
			else if($result == "SKIP")
				++$this->skip;
			else ++$this->fail;
			++$i;
		}
		
		// run finish()
		$cmd = CMTest::$PHP . ' ' . $this->script . ' finish';
		$result = `$cmd`;
		
		// print stats
		echo "Done: $this->pass passed, $this->skip skipped, $this->fail failed\n\n";
	}
	
}

?>
