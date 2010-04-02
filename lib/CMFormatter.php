<?php

include_once("CMClass.php");

/**
 * @brief A reuseable data formatter.
 * 
 * @author Elliot Chance
 */
class CMFormatter implements CMClass {
	
	/**
	 * @brief The format rule(s).
	 * 
	 * @see setFormat()
	 */
	private $format = false;
	
	/**
	 * @brief Formatting defaults
	 * 
	 * You may change this and it will effect any new CMFormatter objects you create after that
	 * point.
	 */
	public static $FormatDefault =
			array(
				'date' => '',
				'dec' => '.',
				'fixed' => false,
				'mul' => 1.0,
				'post' => '',
				'pre' => '',
				'prec' => 14,
				'sizes' => ' bytes; KB; MB; GB; TB; PB; EB; ZB; YB',
				'thousands' => '',
				'type' => 'string',
				'unit' => 1000
			);
	
	/**
	 * @brief Create a CMFormatter object.
	 * 
	 * @param $type The type of input data
	 * @param $format Format options for output.
	 * @see setType()
	 * @see setFormat()
	 */
	public function CMFormatter($type = 'string', $format = false) {
		$this->format = array();
		if(is_array($type)) {
			foreach($type as $k => $v)
				$this->format[$k] = CMFormatter::InitFormatter($v, $format);
		} else $this->format[0] = CMFormatter::InitFormatter($type, $format);
	}
	
	/**
	 * @brief Internally initialise a single formatter.
	 * 
	 * @param $type The type or short syntaxed format.
	 * @param $format The format string or array.
	 */
	private static function InitFormatter($type, $format) {
		$r = CMFormatter::$FormatDefault;
		$r['type'] = $type;
		
		// check if this is short syntax
		if(strpos($r['type'], '|') !== false) {
			$r['type'] = substr($type, 0, strpos($r['type'], '|'));
			
			$ps = explode('|', substr($type, strpos($type, '|') + 1));
			foreach($ps as $p) {
				$pos = strpos($p, '=');
				if($pos === false)
					$r['date'] = $p;
				else $r[substr($p, 0, $pos)] = substr($p, $pos + 1);
			}
			
			return $r;
		}
		
		// bytes uses prec=1 by default
		if($r['type'] == 'bytes')
			$r['prec'] = 1;
		
		if(is_array($format)) {
			foreach($format as $k => $v)
				$r[$k] = $v;
		} else $r['date'] = $format;
		
		return $r;
	}
	
	/**
	 * @brief Return the current formatter.
	 * 
	 * The format attribute itself is kept private so if in the future format validation is added it
	 * won't deprecate anyones code.
	 * 
	 * @return The complete formatter array.
	 * @see setFormat()
	 */
	public function getFormat() {
		return $this->format;
	}
	
	/**
	 * @brief Format an input.
	 * 
	 * @param $data The data to format.
	 */
	public function format($data) {
		// we have to remember this for the return
		$returnArray = is_array($data);
		if(!is_array($data))
			$data = array($data);
		
		$r = array();
		foreach($data as $k => $v) {
			
			// if the field given has no formatter, then we can passthru
			if(!isset($this->format[$k])) {
				$r[$k] = $v;
				continue;
			}
			
			// we dont want to change the class
			$t = $this->format[$k];
			
			// process date, time and timestamp
			if(in_array($t['type'], array('date', 'time', 'timestamp'))) {
				// epoch seconds
				if(is_numeric($v)) {
					$r[$k] = @date($t['date'], $v);
					continue;
				}
				
				// textual date
				$r[$k] = @date($t['date'], @strtotime($v));
				continue;
			}
			
			// process number or bytes
			if($t['type'] == 'number' || $t['type'] == 'bytes') {
				
				if($t['fixed'] !== false) {
					if($t['type'] == 'bytes')
						$t['prec'] = $t['fixed'] = max($t['prec'], $t['fixed']);
					else $t['prec'] = $t['fixed'] = min($t['prec'], $t['fixed']);
				}
				
				// mul
				$v *= $t['mul'];
				
				// format bytes
				if($t['type'] == 'bytes') {
					if($v == "")
						$v = 0;
						
					$p = explode(';', $t['sizes']);
					$found = false;
					for($i = 0; $i < count($p); ++$i) {
						if($v < pow($t['unit'], $i)) {
							$v /= pow($t['unit'], $i - 1);
							$v = round($v, $t['prec'] + 1);
							$t['post'] = $p[$i - 1] . $t['post'];
							$found = true;
							break;
						}
					}
					
					// its over the largest unit
					if(!$found) {
						$v /= pow($t['unit'], count($p) - 1);
						$v = round($v, $t['prec'] + 1);
						$t['post'] = $p[count($p) - 1] . $t[post];
					}
				}
				
				// correct the fixed
				if($t['fixed'] === false) {
					if(round($v, $t['prec']) == intval($v))
						$t['fixed'] = 0;
					else if(strpos($v, '.') !== false)
						$t['fixed'] = strlen($v) - strpos($v, '.') - 2;
					else $t['fixed'] = 0;
				}
				
				// the rest
				$v = number_format(round($v, $t['prec']), $t['fixed'], $t['dec'], $t['thousands']);
				$r[$k] = $t['pre'] . $v . $t['post'];
				continue;
			}
			
			// process boolean
			if($t['type'] == 'boolean') {
				$r[$k] = $v;
				continue;
			}
			
			// process string
			if($t['type'] == 'string') {
				$r[$k] = $v;
				continue;
			}
			
		}
		
		if($returnArray)
			return $r;
		return $r[0];
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
