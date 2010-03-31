<?php

include_once('CMError.php');
include_once('CMObject.php');

/**
 * @brief Handling exact values.
 * 
 * @section cmdecimal_desc Description
 * CMDecimal is used when dealing with exact values such as currencies.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMDecimal extends CMError implements CMObject {
	
	/**
	 * @brief Internal string-based decimal value.
	 */
	private $f = '0';
	
	/**
	 * @brief The total size of the decimal (not including the decimal point)
	 */
	private $size = 18;
	
	/**
	 * @brief The precision after the decimal point.
	 * 
	 * This must be greater than or equal to \c 0. If \c $prec is zero then the '.' character will not be
	 * printed - in other words to treat numbers are integers.
	 */
	private $prec = 6;
	
	/**
	 * @brief Create a decimal object.
	 * 
	 * @param $size The total size of the decimal (not including the decimal point)
	 * @param $prec The precision after the decimal point.
	 * @param $value An optional value to assign now. If this is not provided then \c 0 will be used.
	 */
	public function CMDecimal($size, $prec, $value = 0) {
		$this->size = $size;
		$this->prec = $prec;
		$this->set($value);
	}
	
	/**
	 * @brief Set the value.
	 * 
	 * @throwsError If the \p $value provided is to large to fit in the given \c $size. This function will
	 *              return \false.
	 * @throwsWarning If the \p $value precision is greater than that of this class and the number has to
	 *                be truncated.
	 * 
	 * @param $value Can be a string or CMDecimal object.
	 * @return This object as a CMDecimal.
	 */
	public function set($value) {
		// get the raw number
		$p = explode('.', $value);
		
		// truncate
		if(strlen($p[0]) > ($this->size - $this->prec))
			return $this->throwError("Out of range", array('value' => $value));
			
		if(count($p) > 1 && strlen($p[1]) > $this->prec) {
			$this->throwWarning("Number truncated", array('value' => $value));
			$p[1] = substr($p[1], 0, $this->prec);
		}
		
		// pad
		for($i = strlen($p[1]); $i < $this->prec; ++$i)
			$p[1] .= '0';
		
		// set
		if($this->prec > 0)
			$this->f = "$p[0].$p[1]";
		else $this->f = $p[0];
		
		return $this;
	}
	
	/**
	 * @brief Addition.
	 * 
	 * The new value will be \em returned, and not assigned. You must assign the value yourself like:
	 * @code
	 * $d = new CMDecimal(8, 2, "53.78");
	 * $d = $d->add("13.73");
	 * @endcode
	 * 
	 * @param $value The new value can be a string or CMDecimal.
	 * @return New CMDecimal object.
	 */
	public function add($value) {
		if(!($value instanceof CMDecimal))
			$value = new CMDecimal($this->size, $this->prec, $value);
		return new CMDecimal($this->size, $this->prec, bcadd($this->f, $value, $this->prec));
	}
	
	/**
	 * @brief Subtraction.
	 * 
	 * The new value will be \em returned, and not assigned. You must assign the value yourself like:
	 * @code
	 * $d = new CMDecimal(8, 2, "53.78");
	 * $d = $d->subtract("13.73");
	 * @endcode
	 * 
	 * @param $value The new value can be a string or CMDecimal.
	 * @return New CMDecimal object.
	 */
	public function subtract($value) {
		if(!($value instanceof CMDecimal))
			$value = new CMDecimal($this->size, $this->prec, $value);
		return new CMDecimal($this->size, $this->prec, bcsub($this->f, $value, $this->prec));
	}
	
	/**
	 * @brief Multiplication.
	 * 
	 * The new value will be \em returned, and not assigned. You must assign the value yourself like:
	 * @code
	 * $d = new CMDecimal(8, 2, "53.78");
	 * $d = $d->multiply("13.73");
	 * @endcode
	 * 
	 * @param $value The new value can be a string or CMDecimal.
	 * @return New CMDecimal object.
	 */
	public function multiply($value) {
		if(!($value instanceof CMDecimal))
			$value = new CMDecimal($this->size, $this->prec, $value);
		return new CMDecimal($this->size, $this->prec, bcmul($this->f, $value, $this->prec));
	}
	
	/**
	 * @brief Division.
	 * 
	 * The new value will be \em returned, and not assigned. You must assign the value yourself like:
	 * @code
	 * $d = new CMDecimal(8, 2, "53.78");
	 * $d = $d->divide("13.73");
	 * @endcode
	 * 
	 * @param $value The new value can be a string or CMDecimal.
	 * @return New CMDecimal object.
	 */
	public function divide($value) {
		if(!($value instanceof CMDecimal))
			$value = new CMDecimal($this->size, $this->prec, $value);
		return new CMDecimal($this->size, $this->prec, bcdiv($this->f, $value, $this->prec));
	}
	
	/**
	 * @brief Return a \c 0 based on the precision of this object.
	 */
	public function zero() {
		$r = "0";
		if($this->prec > 0) {
			$r .= ".";
			for($i = 0; $i < $this->prec; ++$i)
				$r .= "0";
		}
		return new CMDecimal($this->size, $this->prec, $r);
	}
	
	/**
	 * @brief Return a \c 1 based on the precision of this object.
	 */
	public function one() {
		$r = "1";
		if($this->prec > 0) {
			$r .= ".";
			for($i = 0; $i < $this->prec; ++$i)
				$r .= "0";
		}
		return new CMDecimal($this->size, $this->prec, $r);
	}
	
	/**
	 * @brief String value
	 * 
	 * @return String value of the decimal value.
	 */
	public function __toString() {
		return $this->f;
	}
	
}

?>
