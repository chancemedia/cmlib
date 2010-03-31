<?php

include_once("CMEnum.php");

// another change

/**
 * @brief Type (or level) of error thrown to CMError.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
abstract class CMErrorType extends CMEnum {
	
	/**
	 * @brief Debug.
	 */
	const Debug = 1;
	
	/**
	 * @brief Notice.
	 */
	const Notice = 2;
	
	/**
	 * @brief Unavailable.
	 */
	const Unavailable = 3;
	
	/**
	 * @brief Warning.
	 */
	const Warning = 4;
	
	/**
	 * @brief Deprecated.
	 */
	const Deprecated = 5;
	
	/**
	 * @brief Error.
	 */
	const Error = 6;
	
	/**
	 * @brief Exception.
	 */
	const Exception = 7;
	
	/**
	 * @brief Fatal.
	 */
	const Fatal = 8;
	
}

?>
