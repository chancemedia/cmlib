<?php

include_once("CMClass.php");
include_once("CMMySQL.php");

// some change

/**
 * @brief HTML form object builder.
 * 
 * @section cmform_desc Description
 * This class is for building dynamic safe form objects. This works by constructing the object
 * from the attributes provided below in the table. The built form object is returned rather
 * than printed.
 * 
 * @author Elliot Chance
 */
class CMForm implements CMClass {
	
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
	 * @brief Internal function for recursing an array to remove slashes.
	 * 
	 * @param $value String or array containing values to have slashes removed.
	 * @return Safe values.
	 * @see Request()
	 * @see Get()
	 * @see Post()
	 */
	public static function StripSlashesRecursive($value) {
		if(is_array($value)) {
			foreach($value as $k => $v)
				$value[$k] = CMForm::StripSlashesRecursive($v);
		} else $value = stripslashes($value);
		
		return $value;
	}
	
	/**
	 * @brief Get the safe value of posted form object.
	 * 
	 * If you are taking values from text boxes or text areas that contain single quotes the value
	 * will be escaped with backslashes. This function grabs a posted varaible and escapes, or
	 * recursivly escapes the values to return the true posted value.
	 * 
	 * @param $objname This is the field \em name, not the string itself.
	 * @return Safe value. This may be a string or an array.
	 * @see Get()
	 * @see Post()
	 */
	public static function Request($objname) {
		return CMForm::StripSlashesRecursive($_REQUEST[$objname]);
	}

	/**
	 * @brief Works like Request() but only fetches data from \c $_GET
	 * 
	 * @param $objname This is the field \em name, not the string itself.
	 * @return Safe value. This may be a string or an array.
	 * @see Request()
	 * @see Post()
	 */
	public static function Get($objname) {
		return CMForm::StripSlashesRecursive($_GET[$objname]);
	}

	/**
	 * @brief Works like Request() but only fetches data from \c $_POST
	 * 
	 * @param $objname This is the field \em name, not the string itself.
	 * @return Safe value. This may be a string or an array.
	 * @see Request()
	 * @see Get()
	 */
	public static function Post($objname) {
		return CMForm::StripSlashesRecursive($_POST[$objname]);
	}
	
	/**
	 * @brief Internal use.
	 * 
	 * This function takes the user specified attributes and makes sure all the defaults and
	 * rules are set. This is really for internal use only. When an attribute does not exist
	 * it is given a default value specified from above.
	 * 
	 * @param $a Associative array of HTML attributes.
	 * @return Array of default elements filled in.
	 */
	private static function DefaultAttributes($a) {
		// firstly it must be an array
		if(!is_array($a))
			$a = array();
			
		$defaults = array(
			'caption' => false,
			'captionempty' => "",
			'class' => false,
			'custom' => false,
  			'data' => false,
			'disabled' => false,
			'height' => false,
			'html' => false,
			'label' => false,
            'name' => "",
			'onblur' => false,
			'onchange' => false,
			'onclick' => false,
			'ondblclick' => false,
			'onfocus' => false,
			'onkeydown' => false,
			'onkeypress' => false,
			'onkeyup' => false,
			'onmousedown' => false,
			'onmouseout' => false,
			'onmousemove' => false,
			'onmouseup' => false,
			'onmouseover' => false,
			'onselect' => false,
			'readonly' => false,
			'style' => false,
			'tabindex' => false,
			'value' => "",
			'width' => false,
			'wrap' => "off",
 			'id' => '$name'
		);
		
		foreach($defaults as $k => $v) {
			if(!isset($a[$k])) {
				if(substr($v, 0, 1) == '$')
					$a[$k] = $a[substr($v, 1)];
				else $a[$k] = $v;
			}
		}
		
		// convert SQL queries into data
		foreach($a as $k => $v) {
			if($v instanceof CMQueryProtocol) {
				// some attributes are special and require an array()
				if($k == 'data') {
					$a[$k] = array();
					while(($r = $v->fetch('line')) !== false)
						$a[$k][] = array($r[0], $r[1]);
				} else {
					$a[$k] = mysql_fetch_row($v);
					$a[$k] = $a[$k][0];
				}
			}
		}
			
		return $a;
	}
	
	/**
	 * @brief Internal use.
	 * 
	 * Translates the main attributes into HTML.
	 * 
	 * @param $a Associative array of HTML attributes
	 * @param $checkbox \true if the object to be returned is a chackbox. This effects the name
	 *        of the object so that checkboxes with the same name can be returned as an array.
	 * @return The main attributes required to build the base of an HTML object.
	 */
	private static function MainAttributes($a, $checkbox = false) {
		if($checkbox)
			$html = " name=\"$a[name][]\"";
		else $html = " name=\"$a[name]\"";
		$html .= " id=\"$a[id]\"";
		if($a['class']) $html .= " class=\"$a[class]\"";
		
		if($a['onblur']) $html .= " onblur=\"$a[onblur]\"";
		if($a['onchange']) $html .= " onchange=\"$a[onchange]\"";
		if($a['onclick']) $html .= " onclick=\"$a[onclick]\"";
		if($a['ondblclick']) $html .= " ondblclick=\"$a[ondblclick]\"";
		if($a['onfocus']) $html .= " onfocus=\"$a[onfocus]\"";
		if($a['onkeydown']) $html .= " onkeydown=\"$a[onkeydown]\"";
		if($a['onkeypress']) $html .= " onkeypress=\"$a[onkeypress]\"";
		if($a['onkeyup']) $html .= " onkeyup=\"$a[onkeyup]\"";
		if($a['onmousedown']) $html .= " onmousedown=\"$a[onmousedown]\"";
		if($a['onmouseout']) $html .= " onmouseout=\"$a[onmouseout]\"";
		if($a['onmousemove']) $html .= " onmousemove=\"$a[onmousemove]\"";
		if($a['onmouseup']) $html .= " onchange=\"$a[onmouseup]\"";
		if($a['onmouseover']) $html .= " onmouseover=\"$a[onmouseover]\"";
		if($a['onselect']) $html .= " onselect=\"$a[onselect]\"";
		
		if($a['style']) $html .= " style=\"$a[style]\"";
		if($a['disabled']) $html .= " disabled=\"disabled\"";
		if($a['readonly']) $html .= " readonly=\"readonly\"";
		if($a['label']) $html .= " label=\"$a[label]\"";
		if($a['tabindex']) $html .= " tabindex=\"$a[tabindex]\"";
		if($a['custom']) $html .= " $a[custom]";
		
		return $html;
	}
	
	/**
	 * @brief Create a single line text box.
	 * 
	 * @param $a An associative array of options.
	 * @return HTML object.
	 */
	public static function TextBox($a) {
		$a = CMForm::DefaultAttributes($a);
		if($a['caption']) {
			if($a['value'] == '')
				$a['value'] = $a['captionempty'];
			return $a['value'] . '&nbsp;';
		}
		$html = "<input type='text'" . CMForm::MainAttributes($a);
		$html .= ' value="' . $a['value'] . '"';
		$html .= " />";
		return $html;
	}
	
	/**
	 * @brief Create a submit button.
	 * 
	 * @param $a
	 */
	public static function SubmitButton($a) {
		$a = CMForm::DefaultAttributes($a);
		if($a['caption']) {
			if($a['value'] == '')
				$a['value'] = $a['captionempty'];
			return $a['value'] . '&nbsp;';
		}
		
		if($a['name'] == '')
			$a['name'] = 'submit';
		
		if($a['value'] == '')
			$a['value'] = 'Submit';
		
		$html = "<input type='submit'" . CMForm::MainAttributes($a);
		$html .= ' value="' . $a['value'] . '"';
		$html .= " />";
		return $html;
	}
	
	/**
	 * @brief Create a form reset button.
	 * 
	 * @param $a Attributes
	 */
	public static function ResetButton($a) {
		$a = CMForm::DefaultAttributes($a);
		if($a['caption']) {
			if($a['value'] == '')
				$a['value'] = $a['captionempty'];
			return $a['value'] . '&nbsp;';
		}
		
		if($a['name'] == '')
			$a['name'] = 'submit';
		
		if($a['value'] == '')
			$a['value'] = 'Submit';
		
		$html = "<input type='reset'" . CMForm::MainAttributes($a);
		$html .= ' value="' . $a['value'] . '"';
		$html .= " />";
		return $html;
	}
	
	/**
	 * @brief Create a non-submitting button.
	 * 
	 * @param $a
	 * @see SubmitButton()
	 * @see ResetButton()
	 */
	public static function Button($a) {
		$a = CMForm::DefaultAttributes($a);
		if($a['caption']) {
			if($a['value'] == '')
				$a['value'] = $a['captionempty'];
			return $a['value'] . '&nbsp;';
		}
		
		if($a['name'] == '')
			$a['name'] = 'button';
		
		$html = "<input type='submit'" . CMForm::MainAttributes($a);
		$html .= ' value="' . $a['value'] . '"';
		$html .= " />";
		return $html;
	}
	
	/**
	 * @brief Create a hidden field.
	 * 
	 * @param $a
	 */
	public static function Hidden($a) {
		$a = CMForm::DefaultAttributes($a);
		$html = "<input type='hidden'" . CMForm::MainAttributes($a);
		$html .= ' value="' . $a['value'] . '"';
		$html .= " />";
		return $html;
	}
	
	/**
	 * @brief Create a password box.
	 * 
	 * @param $a
	 */
	public static function PasswordBox($a) {
		$a = CMForm::DefaultAttributes($a);
		$html = "<input type='password'" . CMForm::MainAttributes($a);
		$html .= ' value="' . $a['value'] . '"';
		$html .= " />";
		return $html;
	}
	
	/**
	 * @brief Create a popup menu.
	 * 
	 * @param $a
	 */
	public static function Menu($a) {
		$a = CMForm::DefaultAttributes($a);
		if($a['caption']) {
			if($a['value'] == '')
				$a['value'] = $a['captionempty'];
			return $a['value'] . '&nbsp;';
		}
		$html = "<select " . CMForm::MainAttributes($a) . ">";
		foreach($a['data'] as $d) {
			if(!is_array($d))
				$d = array($d, $d);
			$html .= '<option value="' . $d[0] . '"';
			if($d[0] == $a['value']) $html .= ' selected';
			$html .= '>';
			if($a['html'] === false)
				$html .= htmlspecialchars($d[1]);
			else $html .= $d[1];
			$html .= '</option>';
		}
		$html .= "</select>";
		return $html;
	}
	
	/**
	 * @brief Create a checkbox.
	 * 
	 * @param $a
	 */
	public static function Checkbox($a) {
		$a = CMForm::DefaultAttributes($a);
		if($a['caption']) {
			if($a['value'] == '')
				$a['value'] = $a['captionempty'];
			return $a['value'] . '&nbsp;';
		}
		$html = "<input type='checkbox' value='" . $a['value'] . "' " . CMForm::MainAttributes($a);
		if($a['checked'] != false)
			$html .= ' checked';
		$html .= " />";
		return $html;
	}
	
	/**
	 * @brief Create a list box.
	 * 
	 * @param $a
	 */
	public static function ListBox($a) {
		$a = CMForm::DefaultAttributes($a);
		if($a['height'] === false)
			$a['height'] = 5;
		$html = "<select " . CMForm::MainAttributes($a) . ' size="' . $a['height'] . '">';
		foreach($a['data'] as $value => $text) {
			$html .= '<option value="' . $value . '"';
			if($value == $a['value']) $html .= ' selected';
			$html .= '>';
			if($a['html'] === false)
				$html .= htmlspecialchars($text);
			else $html .= $text;
			$html .= '</option>';
		}
		$html .= "</select>";
		return $html;
	}
	
	/**
	 * @brief Create a radio button set.
	 * 
	 * @param $a
	 */
	public static function RadioGroup($a) {
		$a = CMForm::DefaultAttributes($a);
		$html = "";
		foreach($a['data'] as $value => $text) {
			$html .= '<input type="radio" value="' . $value . '"';
			if($value == $a['value']) $html .= ' checked';
			$html .= CMForm::MainAttributes($a) . ' />';
			if($a['html'] === false)
				$html .= htmlspecialchars($text);
			else $html .= $text;
			$html .= '&nbsp;';
		}
		return $html;
	}
	
	/**
	 * @brief Create a checkbox set.
	 * 
	 * @param $a
	 */
	public static function CheckboxGroup($a) {
		$a = CMForm::DefaultAttributes($a);
		$html = "";
		foreach($a['data'] as $value => $text) {
			$html .= '<input type="checkbox" value="' . $value . '"';
			if(is_array($a['value']) && in_array($value, $a['value']))
				 $html .= ' checked';
			elseif($value == $a['value']) $html .= ' checked';
			$html .= CMForm::MainAttributes($a, true) . ' />';
			if($a['html'] === false)
				$html .= htmlspecialchars($text);
			else $html .= $text;
			$html .= '&nbsp;';
		}
		return $html;
	}
	
	/**
	 * @brief Create a text area.
	 * 
	 * @param $a
	 */
	public static function TextArea($a) {
		$a = CMForm::DefaultAttributes($a);
		if($a['caption']) {
			if($a['value'] == '')
				$a['value'] = $a['captionempty'];
			return nl2br($a['value']) . '&nbsp;';
		}
		if($a['height'] === false)
			$a['height'] = 5;
		if($a['width'] === false)
			$a['width'] = 45;
		$html = "<textarea" . CMForm::MainAttributes($a) . " rows=\"$a[height]\" cols=\"$a[width]\" wrap=\"$a[wrap]\">";
		if($a['html'] === false)
			$html .= htmlspecialchars($a['value']);
		else $html .= $a['value'];
		$html .= "</textarea>";
		return $html;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
