<?php

include_once('CMSLOCResult.php');
include_once('CMClass.php');

/**
 * @brief "Software Lines of Code" processor.
 * 
 * CMSLOC currently only supports the PHP language.
 * 
 * @author Elliot Chance
 */
class CMSLOC implements CMClass {
	
	/**
	 * @brief CMSLOCResult result object.
	 */
	public $result;
	
	/**
	 * @brief Internal use to measure the current class depth.
	 */
	private $classDepth = 0;
	
	/**
	 * @brief Initialise CMSLOC.
	 */
	public function CMSLOC() {
		$this->result = new CMSLOCResult();
	}
	
	/**
	 * @brief Process a directory or path.
	 * 
	 * If a directory is given, it will be recursed so all files and directories inside will be processed.
	 * This function will ignore hidden files (files starting with a dot.)
	 * 
	 * @param $path Relative or absolute directory or file.
	 * @return TRUE on success, otherwise FALSE.
	 */
	public function processPath($path) {
		// if its a directory we process all of the items
		if(is_dir($path)) {
			if($handle = opendir($path)) {
			    while(false !== ($file = readdir($handle))) {
			    	if(substr($file, 0, 1) != '.')
			        	$this->processPath("$path/$file");
			    }
			    closedir($handle);
			}
			return true;
		}
		
		// process a single file
		return $this->processFilePHP($path);
	}
	
	/**
	 * @brief Process a PHP file.
	 * 
	 * This method is private because you should always use processPath().
	 * 
	 * @param $path Relative or absolute path.
	 * @return TRUE on success, otherwise FALSE.
	 * @see processPath()
	 */
	private function processFilePHP($path) {
		// get the contents of the file to process
		$contents = file_get_contents($path);
		
		// we only want the code thats in the <?php tags
		$start = strpos($contents, '<?php') + strlen('<?php');
		$end = strrpos($contents, '?>');
		$contents = substr($contents, $start, $end - $start);
		$len = strlen($contents);
		
		// increment the file count
		++$this->result->files;
		
		// count the characters
		$this->result->characters += $len;
		
		// count the blank lines
		$line = "";
		for($i = 0; $i < $len; ++$i) {
			$c = substr($contents, $i, 1);
			
			if($c == "\n") {
				if(trim($line) == "")
					++$this->result->blankLines;
				$line = "";
			} else $line .= $c;
		}
		
		// count the physicalLines
		for($i = 0; $i < $len; ++$i) {
			$c = substr($contents, $i, 1);
			if($c == "\n")
				++$this->result->physicalLines;
		}
		++$this->result->physicalLines;
		
		// strip out all the comments and strings
		$newContents = "";
		for($i = 0; $i < $len; ++$i) {
			$c = substr($contents, $i, 1);
			
			// single quotes
			if($c == "'") {
				++$i;
				for(; $i < $len; ++$i) {
					$c = substr($contents, $i, 1);
					if($c == "'")
						break;
				}
			} else
			
			// double quotes
			if($c == "\"") {
				++$i;
				for(; $i < $len; ++$i) {
					$c = substr($contents, $i, 1);
					if($c == "\"")
						break;
				}
			} else
			
			// multi line comment
			if(substr($contents, $i, 2) == '/*') {
				++$this->result->commentLines;
				while(substr($contents, $i, 2) != '*/' && $i < $len) {
					if(substr($contents, $i, 1) == "\n")
						++$this->result->commentLines;
					++$i;
				}
				++$i;
			} else
			
			// single line comment
			if(substr($contents, $i, 2) == '//') {
				++$this->result->commentLines;
				$i = strpos($contents, "\n", $i);
				if($i === false)
					break;
			} else
			
			$newContents .= $c;
		}
		
		return $this->processBlockPHP('', $newContents);
	}
	
	/**
	 * @brief Process a PHP block.
	 * 
	 * This is a nested method to recurse though blocks surrounded by {}.
	 * 
	 * @param $iden The identifier before the block starts.
	 * @param $b The block contents
	 * @return TRUE.
	 */
	private function processBlockPHP($iden, $b) {
		// process the keyword
		$keyword = "";
		$isStatic = false;
		$objectType = '';
		
		if(trim($iden) != "")
			++$this->result->logicalLines;
		
		for($i = 0; $i < strlen($iden); ++$i) {
			$c = substr($iden, $i, 1);
			if($c == "(" || ctype_space($c)) {
				$keyword = trim($keyword);
				
				if($keyword == 'function') {
					$objectType = 'function';
					if($this->classDepth) {
						if($isStatic)
							++$this->result->staticMethods;
						else ++$this->result->methods;
					} else ++$this->result->functions;
				} elseif($keyword == 'class') {
					++$this->result->classes;
					++$this->classDepth;
					$objectType = 'class';
				} elseif($keyword == 'interface') {
					++$this->result->interfaces;
					++$this->classDepth;
					$objectType = 'interface';
				} elseif($keyword == 'static') {
					$isStatic = true;
				} elseif($keyword == 'for') {
					$this->result->logicalLines += 2;
				}
				
				$keyword = "";
			} else $keyword .= $c;
		}
		
		$len = strlen($b);
		$cmd = "";
		$gb1 = 0; // ()
		$gb2 = 0; // []
		$gb3 = 0; // {}
		
		// process the block
		for($i = 0; $i < $len; ++$i) {
			$c = substr($b, $i, 1);
			
			     if($c == '(') ++$gb1;
			else if($c == ')') --$gb1;
			else if($c == '[') ++$gb2;
			else if($c == ']') --$gb2;
			else if($c == '{') ++$gb3;
			else if($c == '}') --$gb3;
			
			// logical lines
			if($c == ";" && !$gb1 && !$gb2 && !$gb3) {
				// check for interface methods
				if($objectType == 'interface' && strpos($cmd, 'function') !== false)
					++$this->result->interfaceMethods;
				
				if(strlen(trim($cmd)) != 0)
					++$this->result->logicalLines;
				$cmd = "";
				continue;
			} else $cmd .= $c;
			
			// blocks
			if($c == "{") {
				$newblock = "";
				$b1 = 0; // ()
				$b2 = 0; // []
				$b3 = 0; // {}
				
				for(; $i < $len; ++$i) {
					$c = substr($b, $i, 1);
					
					     if($c == '(') ++$b1;
					else if($c == ')') --$b1;
					else if($c == '[') ++$b2;
					else if($c == ']') --$b2;
					else if($c == '{') ++$b3;
					else if($c == '}') --$b3;
					
					if($c == '}' && !$b1 && !$b2 && !$b3) {
						$this->processBlockPHP($cmd, substr($newblock, 1, strlen($newblock) - 1));
						$cmd = "";
						break;
					}
					$newblock .= $c;
				}
				++$i;
				continue;
			}
		}
		
		// decrement class depth
		if($objectType == 'class' || $objectType == 'interface')
			--$this->classDepth;
	
		// assume success
		return true;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
