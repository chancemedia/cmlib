<?php

include_once('CMClass.php');
include_once('CMErrorType.php');

/**
 * @brief Error handling as a stand-alone or for classes vis inheritance.
 * 
 * @section cmerror_desc Description
 * CMError has two main purposes. First is to have a throwing and reporting error interface
 * that allows error tracking and debugging to be consistent between classes. And secondly, allows the
 * PHP coder to adjust the level of error control real-time.
 * 
 * @section cmerror_inherit Inheritance and the Global Stack
 * PHP constructors for parent classes are not implicitly called, this means any class that inherits
 * from CMError will have to remember to invoke <tt>parent::__construct()</tt>. The work around for
 * this is to have the methods check CMError::$GlobalStack at runtime. Which means changing
 * CMError::$GlobalStack will affect ALL objects created at any point in time before or after the
 * change.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMError implements CMClass {
	
	/**
	 * @brief The error stack.
	 */
	private $errorStack = array();
	
	/**
	 * @brief Determines if an error at a given serious level should be printed immediately.
	 */
	private $verboseLevel = CMErrorType::Warning;
	
	/**
	 * @brief Global stack.
	 * 
	 * @see SetGlobalStack()
	 */
	private static $GlobalStack = false;
	
	/**
	 * @brief How serious the error has to be to force exit the script.
	 * 
	 * By default this is CMErrorType::Fatal.
	 * 
	 * @see setExitLevel()
	 */
	private $exitLevel = CMErrorType::Fatal;
	
	/**
	 * @brief How serious the error has to be to force exit the script.
	 * 
	 * By default this is CMErrorType::Fatal and only applies to this error stack (not global)
	 * 
	 * @param $exitLevel Must be a value from CMErrorType.
	 * @return Always \true.
	 */
	public function setExitLevel($exitLevel = CMErrorType::Fatal) {
		$this->$exitLevel = $exitLevel;
		return true;
	}
	
	/**
	 * @brief Get the stack of errors.
	 * 
	 * @param $level The minimum level to count as an error, by default this is 'Warning'.
	 * @return The errors for this instance stack.
	 */
	public function errors($level = CMErrorType::Warning) {
		// check global stack
		if(CMError::$GlobalStack !== false && CMError::$GlobalStack !== $this)
			return CMError::$GlobalStack->errors();
		
		if(is_array($this->errorStack)) {
			// create a new stack of filtered errors
			$r = array();
			foreach($this->errorStack as $e) {
				if($e['_type'] >= $level)
					array_push($r, $e);
			}
			
			return $r;
		} return $this->errorStack->errorStack;
	}
	
	/**
	 * @brief Check if an error has occured.
	 * 
	 * This is just a quick way of finding out if an error occured.
	 * 
	 * @param $level The minimum level to count as an error, by default this is 'Warning'.
	 * @return \true or \false.
	 */
	public function isErrors($level = CMErrorType::Warning) {
		// check global stack
		if(CMError::$GlobalStack !== false && CMError::$GlobalStack !== $this)
			return CMError::$GlobalStack->isErrors();
		
		if(is_array($this->errorStack)) {
			// count filtered errors
			$r = 0;
			foreach($this->errorStack as $e) {
				if($e['_type'] >= $level)
					++$r;
			}
			return $r > 0;
		}
		
		return $this->errorStack->isErrors();
	}
	
	/**
	 * @brief Count the number of errors on the stack.
	 * 
	 * @param $level The minimum level to count as an error, by default this is 'Warning'.
	 * @return The number of items on the stack, this will always be an integer that has a value
	 *         greater than or equal to 0.
	 */
	public function countErrors($level = CMErrorType::Warning) {
		// check global stack
		if(CMError::$GlobalStack !== false && CMError::$GlobalStack !== $this)
			return CMError::$GlobalStack->countErrors();
		
		if(is_array($this->errorStack)) {
			// count filtered errors
			$r = 0;
			foreach($this->errorStack as $e) {
				if($e['_type'] >= $level)
					++$r;
			}
			
			return $r;
		}
		
		return $this->errorStack->countErrors();
	}
	
	/**
	 * @brief Clear the error stack.
	 * 
	 * When an error is dealt with it is removed from the stack. This will remove all errors from the
	 * stack.
	 * 
	 * @return Always \true.
	 */
	public function dealtWithAll() {
		// check global stack
		if(CMError::$GlobalStack !== false && CMError::$GlobalStack !== $this)
			return CMError::$GlobalStack->dealtWithAll();
		
		if(is_array($this->errorStack))
			$this->errorStack = array();
		else $this->errorStack->dealtWithAll();
		return true;
	}
	
	/**
	 * @brief Print a backtrace of an error.
	 * 
	 * @code
	 * if($e->isErrors()) {
	 *   echo "There were ", $e->countErrors(), " errors:\n";
	 *   foreach($e->errors() as $error)
	 *   	CMError::PrintBackTrace($error);
	 * }
	 * @endcode
	 * 
	 * @param $error The error object.
	 */
	public static function PrintBackTrace($error) {
		for($i = 3; $bt = $error['_backtrace'][$i]; ++$i) {
			echo "  ", $bt['file'], ": line ", $bt['line'], ": ";
			if($bt['class'] != "")
				echo $bt['class'], "::";
			echo $bt['function'], "()\n";
		}
		return true;
	}
	
	/**
	 * @brief Print an error.
	 * 
	 * @code
	 * if($e->isErrors()) {
	 *   echo "There were ", $e->countErrors(), " errors:\n";
	 *   foreach($e->errors() as $error)
	 *   	CMError::PrintError($error);
	 * }
	 * @endcode
	 * 
	 * @param $error The error object.
	 */
	public static function PrintError($error) {
		echo "Reason: ", $error['_reason'], "\n";
		CMError::PrintBackTrace($error);
	}
	
	/**
	 * @brief Push an error onto the error stack.
	 * 
	 * This is private because your must use one of the throw methods.
	 * 
	 * @param $type A value from CMErrorType.
	 * @param $attr Error object.
	 */
	private function pushError($type, $attr) {
		// check global stack
		if(CMError::$GlobalStack !== false && CMError::$GlobalStack !== $this)
			return CMError::$GlobalStack->pushError($type, $attr);
		
		if(is_array($this->errorStack)) {
			$toStack = array(
				'_type' => $type,
				'_backtrace' => debug_backtrace()
			);
			foreach($attr as $k => $v)
				$toStack[$k] = $v;
				
			array_push($this->errorStack, $toStack);
		} else $this->errorStack->pushError($type, $attr);
		
		return false;
	}
	
	/**
	 * @brief Push a eror onto the stack.
	 * 
	 * If \p $toStack is not provided \p $msg will be used as the error object.
	 * 
	 * @param $type From CMErrorType.
	 * @param $msg String message to print.
	 * @param $attr Extra attributes for the error.
	 * @return Always \false.
	 */
	public function throwGeneric($type, $msg, array $attr = array()) {
		// if this is a fatal error, exit the script
		if($type === CMErrorType::Fatal)
			die($msg);
			
		// print the message
		if($msg != "") {
			if(is_array($this->errorStack) && $type >= $this->verboseLevel)
				echo $msg, "\n";
			else if($this->errorStack instanceof CMError && $type >= $this->errorStack->verboseLevel)
				echo $msg, "\n";
		}
		
		// push the error onto the stack
		$attr['_reason'] = $msg;
		$this->pushError($type, $attr);
		
		return false;
	}
	
	/**
	 * @brief Throw a Debug level message.
	 * 
	 * If no \p $toStack is provided then the \p $msg will be used.
	 * 
	 * @param $msg The message to print.
	 * @param $attr The number, string, array or object to place on the error stack that will
	 *        replace the $msg.
	 * @return Always \false.
	 */
	public function throwDebug($msg, $attr = array()) {
		return $this->throwGeneric(CMErrorType::Debug, $msg, $attr);
	}
	
	/**
	 * @brief Throw a Notice level message.
	 * 
	 * If no \p $toStack is provided then the \p $msg will be used.
	 * 
	 * @param $msg The message to print.
	 * @param $attr The number, string, array or object to place on the error stack that will
	 *        replace the $msg.
	 * @return Always \false.
	 */
	public function throwNotice($msg, $attr = array()) {
		return $this->throwGeneric(CMErrorType::Notice, $msg, $attr);
	}
	
	/**
	 * @brief Throw a Warning level message.
	 * 
	 * If no \p $toStack is provided then the \p $msg will be used.
	 * 
	 * @param $msg The message to print.
	 * @param $attr The number, string, array or object to place on the error stack that will
	 *        replace the $msg.
	 * @return Always \false.
	 */
	public function throwWarning($msg, $attr = array()) {
		return $this->throwGeneric(CMErrorType::Warning, $msg, $attr);
	}
	
	/**
	 * @brief Throw a Deprecated level message.
	 * 
	 * If no \p $toStack is provided then the \p $msg will be used.
	 * 
	 * @param $msg The message to print.
	 * @param $attr The number, string, array or object to place on the error stack that will
	 *        replace the $msg.
	 * @return Always \false.
	 */
	public function throwDeprecated($msg, $attr = array()) {
		return $this->throwGeneric(CMErrorType::Deprecated, $msg, $attr);
	}
	
	/**
	 * @brief Throw an Unavailable level message.
	 * 
	 * If no \p $toStack is provided then the \p $msg will be used.
	 * 
	 * @param $msg The message to print.
	 * @param $attr The number, string, array or object to place on the error stack that will
	 *        replace the $msg.
	 * @return Always \false.
	 */
	public function throwUnavailable($msg, $attr = array()) {
		return $this->throwGeneric(CMErrorType::Unavailable, $msg, $attr);
	}
	
	/**
	 * @brief Throw a Error level message.
	 * 
	 * If no \p $toStack is provided then the \p $msg will be used.
	 * 
	 * @param $msg The message to print.
	 * @param $attr The number, string, array or object to place on the error stack that will
	 *        replace the $msg.
	 * @return Always \false.
	 */
	public function throwError($msg, $attr = array()) {
		return $this->throwGeneric(CMErrorType::Error, $msg, $attr);
	}
	
	/**
	 * @brief Throw a Exception level message as well as throwing a real exception.
	 * 
	 * If no \p $toStack is provided then the \p $msg will be used.
	 * 
	 * @param $msg The message to print.
	 * @param $attr The number, string, array or object to place on the error stack that will
	 *        replace the $msg.
	 * @return Always \false.
	 */
	public function throwException($msg, $attr = array()) {
		return $this->throwGeneric(CMErrorType::Exception, $msg, $attr);
	}
	
	/**
	 * @brief Print a message and force exit the script.
	 * 
	 * There is no need to pass a \p $toStack item as your wont be able to check it after the script
	 * exists. However it is there to remain consistant with the other throw methods.
	 * 
	 * @param $msg The message to print before exiting.
	 * @param $attr Ignored.
	 * @return Always \false.
	 */
	public function throwFatal($msg, $attr = array()) {
		return $this->throwGeneric(CMErrorType::Fatal, $msg, $attr);
	}

	/**
	 * @brief Change the verbosity level.
	 * 
	 * By default a new CMError verbosity level will be CMErrorType::Warning. That means is an error
	 * is thrown that is Warning or higer seriousness it will be printed immediatly to the page.
	 * 
	 * @param $verboseLevel Must be a value from CMErrorType.
	 * @return Always \true.
	 */
	public function setVerboseLevel($verboseLevel) {
		$this->verboseLevel = $verboseLevel;
		return true;
	}
	
	/**
	 * @brief Redirect the errors to a different stack.
	 * 
	 * The current error stack will be \em replaced with the object for the new stack. That means if
	 * there are any errors currently on this stack they will be discarded.
	 * 
	 * To reset the error stack back to this instance, set \p $newStack to \null or \false. If the
	 * class is already using its own stack and you invoke this method, the stack will always be
	 * replaced with a blank stack.
	 * 
	 * @note When changing the stack remember that all the methods of this instance will use the
	 *       external stack as its true error stack.
	 * 
	 * @param $newStack Must be a CMError object.
	 * @return \true on success, otherwise \false.
	 */
	public function useErrorStack($newStack) {
		// reset
		if($newStack === NULL || $newStack === false) {
			$this->errorStack = array();
			return true;
		}
		
		// must be a CMError
		if($newStack instanceof CMError) {
			$this->errorStack = $newStack;
			return true;
		}
		
		// failed
		return false;
	}
	
	/**
	 * @brief Set the global stack.
	 * 
	 * Any objects created after the point of invoking this static method will inherit the supplied
	 * error stack and NOT use their own stack. You can pass \null or \false to turn the feature off.
	 * 
	 * @note In any case this only affects objects that are created after the point of invoking this
	 *       static method.
	 * 
	 * @param $newStack Must be a CMError object.
	 * @return \true on success, otherwise \false.
	 */
	public static function SetGlobalStack($newStack) {
		// reset
		if($newStack === NULL || $newStack === false) {
			CMError::$GlobalStack = false;
			return true;
		}
		
		// must be a CMError
		if($newStack instanceof CMError) {
			// the new stacks actual stack must be an array to stop possible infinite loops
			if(!is_array($newStack->errorStack))
				$newStack->errorStack = array();
				
			CMError::$GlobalStack = $newStack;
			return true;
		}
		
		// failed
		return false;
	}
	
	/**
	 * @brief Print all the errors on this stack.
	 * 
	 * This is the equivilent to invoking CMError::PrintError() on each error on this stack.
	 * 
	 * @return Always \false.
	 */
	public function printAllErrors() {
		// loop through the stack
		foreach($this->errorStack as $e) {
			CMError::PrintError($e);
			echo "\n";
		}
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
