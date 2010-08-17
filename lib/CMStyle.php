<?php

include_once('CMObject.php');

/**
 * @brief Defines a style which is interoperable with CSS.
 * 
 * http://www.htmldog.com/reference/cssproperties
 * 
 * @author Elliot Chance
 */
class CMStyle implements CMObject {
	
	/**
	 * @brief Specifies the font name of a box.
	 * This can be a comma-separated list, of which the browser will use the first font it recognizes.
	 * Font names that are made up of more than one word must be placed within quotation marks.
	 */
	public $fontFamily = false;
	
	/**
	 * @brief Specifies the size of a font in a box.
	 */
	public $fontSize = false;
	
	/**
	 * @brief Specifies the order of relative or absolutely positioned boxes in the z-axis.
	 * The higher the number, the higher that box will be in the stack.
	 */
	public $zIndex = false;
	
	/**
	 * @brief Specifies the boldness of a font.
	 * Browsers tend not to have any levels other than 400 (the same as normal), 700 (the same as bold)
	 * and 900.
	 */
	public $fontWeight = false;
	
	/**
	 * @brief Specifies whether the text in a box is italic or not.
	 */
	public $fontStyle = false;
	
	/**
	 * @brief Specifies whether the lowercase letters in a box should be displayed in small uppercase.
	 */
	public $fontVariant = false;
	
	/**
	 * @brief Specifies the height of a line of text.
	 */
	public $lineHeight = false;
	
	/**
	 * @brief Specifies the spacing in-between letters.
	 */
	public $letterSpacing = false;
	
	/**
	 * @brief Specifies the spacing between words.
	 */
	public $wordSpacing = false;
	
	/**
	 * @brief Specifies the alignment of text inside a block box.
	 */
	public $textAlign = false;
	
	/**
	 * @brief Specifies whether text is underlined, over-lined or has a strikethrough.
	 */
	public $textDecoration = false;
	
	/**
	 * @brief Specifies the indentation of the first line of text in a block box.
	 */
	public $textIndent = false;
	
	/**
	 * @brief Specifies the case of letters.
	 */
	public $textTransform = false;
	
	/**
	 * @brief Specifies the vertical position of an inline box.
	 */
	public $verticalAlign = false;
	
	/**
	 * @brief Specifies how the white space (such as new lines or a sequence of spaces) inside a box
	 * should be handled.
	 */
	public $whiteSpace = false;
	
	/**
	 * @brief Specifies the foreground (text and border) colour in a box.
	 */
	public $color = false;
	
	/**
	 * @brief Specifies the background color of a box.
	 */
	public $backgroundColor = false;
	
	/**
	 * @brief Specifies the background image of a box.
	 */
	public $backgroundImage = false;
	
	/**
	 * @brief Specifies how a background image will repeat itself within a box.
	 */
	public $backgroundRepeat = false;
	
	/**
	 * @brief Specifies the position of a background image within its containing element.
	 * The value can be single, such as top or double such a top right.
	 */
	public $backgroundPosition = false;
	
	/**
	 * @brief Specifies the attachment of the background image to the containing element.
	 * For example, if a background image is applied to a page normally the image will scroll with the
	 * rest of the page, but if the property is set to fixed then the image will stay in the same
	 * position as the user scrolls the page up and down.
	 */
	public $backgroundAttachment = false;
	
	/**
	 * @brief Specifies the padding of a box.
	 */
	public $paddingLeft = false;
	
	/**
	 * @brief Specifies the padding of a box.
	 */
	public $paddingRight = false;
	
	/**
	 * @brief Specifies the padding of a box.
	 */
	public $paddingTop = false;
	
	/**
	 * @brief Specifies the padding of a box.
	 */
	public $paddingBottom = false;
	
	/**
	 * @brief Specifies the border width of a box.
	 */
	public $borderLeftWidth = false;
	
	/**
	 * @brief Specifies the border width of a box.
	 */
	public $borderRightWidth = false;
	
	/**
	 * @brief Specifies the border width of a box.
	 */
	public $borderTopWidth = false;
	
	/**
	 * @brief Specifies the border width of a box.
	 */
	public $borderBottomWidth = false;
	
	/**
	 * @brief Specifies the border style of a box.
	 */
	public $borderBottomStyle = false;
	
	/**
	 * @brief Specifies the border style of a box.
	 */
	public $borderTopStyle = false;
	
	/**
	 * @brief Specifies the border style of a box.
	 */
	public $borderLeftStyle = false;
	
	/**
	 * @brief Specifies the border style of a box.
	 */
	public $borderRightStyle = false;
	
	/**
	 * @brief Specifies the border color of a box.
	 */
	public $borderBottomColor = false;
	
	/**
	 * @brief Specifies the border color of a box.
	 */
	public $borderTopColor = false;
	
	/**
	 * @brief Specifies the border color of a box.
	 */
	public $borderLeftColor = false;
	
	/**
	 * @brief Specifies the border color of a box.
	 */
	public $borderRightColor = false;
	
	/**
	 * @brief Specifies an outline for a box.
	 * Rendered around the outside of the border and on top of the box, so it does not affect its size
	 * or position. The value can combine outline-color, outline-style and outline-width. Not supported
	 * by IE/Win or Mozilla.
	 */
	public $outlineStyle = false;
	
	/**
	 * @brief Specifies an outline for a box.
	 * Rendered around the outside of the border and on top of the box, so it does not affect its size
	 * or position. The value can combine outline-color, outline-style and outline-width. Not supported
	 * by IE/Win or Mozilla.
	 */
	public $outlineColor = false;
	
	/**
	 * @brief Specifies an outline for a box.
	 * Rendered around the outside of the border and on top of the box, so it does not affect its size
	 * or position. The value can combine outline-color, outline-style and outline-width. Not supported
	 * by IE/Win or Mozilla.
	 */
	public $outlineWidth = false;
	
	/**
	 * @brief Specifies the margin around a box.
	 */
	public $marginLeft = false;
	
	/**
	 * @brief Specifies the margin around a box.
	 */
	public $marginRight = false;
	
	/**
	 * @brief Specifies the margin around a box.
	 */
	public $marginTop = false;
	
	/**
	 * @brief Specifies the margin around a box.
	 */
	public $marginBottom = false;
	
	/**
	 * @brief Specifies the width of a block box (not including padding, border or margin).
	 * @note Internet Explorer 5.x will interpret the height as being inclusive of padding.
	 *       Accommodating IE 5.x can be achieved by using the box model hack.
	 */
	public $width = false;
	
	/**
	 * @brief Specifies the height of a block box (not including padding, border or margin).
	 * @note IE will treat height similarly to min-height - content will push the height of a
	 *       box higher if it does not fit in the specified height. Note: Internet Explorer 5.x
	 *       will interpret the height as being inclusive of padding. Accommodating IE 5.x can
	 *       be achieved by using the box model hack.
	 */
	public $height = false;
	
	/**
	 * @brief Specifies the minimum width of a box.
	 * Not supported by IE.
	 */
	public $minWidth = false;
	
	/**
	 * @brief Specifies the maximum width of a box.
	 * Not supported by IE.
	 */
	public $maxWidth = false;
	
	/**
	 * @brief Specifies the minimum height of a box.
	 * Not supported by IE (where height acts the same).
	 */
	public $minHeight = false;
	
	/**
	 * @brief Specifies the maximum height of a box.
	 * Not supported by IE.
	 */
	public $maxHeight = false;
	
	/**
	 * @brief Specifies how a box should be positioned.
	 */
	public $position = false;
	
	/**
	 * @brief For absolutely positioned boxes, specifies how far from the top of the containing box
	 *        (which is the first containing relatively positioned box or the page itself) the box
	 *        should be.
	 * For relatively positioned boxes, specifies how far from the top a box should be shifted.
	 */
	public $top = false;
	
	/**
	 * @brief For absolutely positioned boxes, specifies how far from the right of the containing box
	 *        (which is the first containing relatively positioned box or the page itself) the box
	 *        should be.
	 * For relatively positioned boxes, specifies how far from the right a box should be shifted.
	 */
	public $right = false;
	
	/**
	 * @brief For absolutely positioned boxes, specifies how far from the bottom of the containing box
	 *        (which is the first containing relatively positioned box or the page itself) the box
	 *        should be.
	 * For relatively positioned boxes, specifies how far from the bottom a box should be shifted.
	 */
	public $bottom = false;
	
	/**
	 * @brief For absolutely positioned boxes, specifies how far from the left of the containing box
	 *        (which is the first containing relatively positioned box or the page itself) the box
	 *        should be.
	 * For relatively positioned boxes, specifies how far from the left a box should be shifter.
	 */
	public $left = false;
	
	/**
	 * @brief Specifies the area of an absolutely positioned box that should be visible.
	 */
	public $clip = false;
	
	/**
	 * @brief Specifies what should happen to the overflow.
	 * The portions of content that do not fit inside a box.
	 */
	public $overflow = false;
	
	/**
	 * @brief Specifies whether a fixed-width box should float, shifting it to the right or left with
	 *        surrounding content flowing around it.
	 */
	public $float = false;
	
	/**
	 * @brief Specifies how box is placed after a floated box.
	 */
	public $clear = false;
	
	/**
	 * @brief Specifies the display type of a box.
	 */
	public $display = false;
	
	/**
	 * @brief Specifies whether a box is visible or not.
	 */
	public $visibility = false;
	
	/**
	 * @brief Specifies the style of the list marker bullet or numbering system within a list.
	 */
	public $listStyleType = false;
	
	/**
	 * @brief Specifies an image to be used as the list marker for a list item.
	 */
	public $listStyleImage = false;
	
	/**
	 * @brief Specifies whether the list marker for a list item should appear inside or outside the
	 *        list-item box.
	 */
	public $listStylePosition = false;
	
	/**
	 * @brief Specifies the algorithm that should be used to render a fixed-width table.
	 * Not supported by IE/Win 5.0.
	 */
	public $tableLayout = false;
	
	/**
	 * @brief Specifies which border model should be used in a table
	 */
	public $borderCollapse = false;
	
	/**
	 * @brief Specifies the spacing between the borders of adjacent table cells in the
	 *        "separated borders" model.
	 * Not supported by IE.
	 */
	public $borderSpacing = false;
	
	/**
	 * @brief Applies to tables.
	 * Specifies whether empty table cells should be shown or not. Not recognized by Internet Explorer.
	 */
	public $emptyCells = false;
	
	/**
	 * @brief Specifies on which side of the table a table-caption box (such as the default style of
	 *        the HTML caption element) will be placed.
	 * Not supported by IE.
	 */
	public $captionSide = false;
	
	/**
	 * @brief Specifies generated content that can be displayed before or after an element.
	 * Used in conjunction with the :before and :after pseudo-elements. Not supported by IE.
	 */
	public $content = false;
	
	/**
	 * @brief Increments a named counter.
	 * Only supported by Opera at the time of writing.
	 */
	public $counterIncrement = false;
	
	/**
	 * @brief Resets a named counter.
	 * Only supported by Opera at the time of writing.
	 */
	public $counterReset = false;
	
	/**
	 * @brief Specifies what form the quotes of the open-quote and close-quote values of the
	 *        content property should take.
	 * Not supported by IE.
	 */
	public $quotes = false;
	
	/**
	 * @brief Used in paged media.
	 * Specifies how a page break should be applied before a block box, forcing a new page box.
	 */
	public $pageBreakBefore = false;
	
	/**
	 * @brief Used in paged media.
	 * Specifies how a page break should be applied after a block box, forcing a new page box.
	 */
	public $pageBreakAfter = false;
	
	/**
	 * @brief Used in paged media.
	 * Specifies how a page break should be applied inside a block box, forcing a new page box.
	 */
	public $pageBreakInside = false;
	
	/**
	 * @brief Used in paged media.
	 * Specifies the minimum number of lines in an element must be left at the bottom of a page.
	 */
	public $orphans = false;
	
	/**
	 * @brief Used in paged media.
	 * Specifies the minimum number of lines in a box must be left at the top of a page.
	 */
	public $widows = false;
	
	/**
	 * @brief Specifies the appearance of the cursor when it passes over a box.
	 */
	public $cursor = false;
	
	/**
	 * @brief Specifies writing direction and the direction of embeddings and overrides (used in
	 *        conjunction with unicode-bidi).
	 */
	public $direction = false;
	
	/**
	 * @brief Used in conjunction with direction.
	 * Specifies how text is mapped to the Unicode algorithm, determining its directionality.
	 */
	public $unicodeBidi = false;
	
	/**
	 * @brief Create a new CMStyle object.
	 * @param $style CSS style string.
	 */
	public function CMStyle($style = '') {
		if(trim($style) != '')
			$this->setCSS($style);
	}
	
	/**
	 * @brief Return the string value of this object.
	 * This is the same as getCSS().
	 */
	public function __toString() {
		return $this->getCSS();
	}
	
	/**
	 * @brief Return this object as a validated CSS style attribute.
	 */
	public function getCSS() {
		$vars = get_object_vars($this);
		$r = '';
		
		foreach($vars as $k => $v) {
			// get the css property name
			$name = '';
			for($i = 0; $i < strlen($k); ++$i) {
				$ch = substr($k, $i, 1);
				if(strtolower($ch) == $ch)
					$name .= $ch;
				else
					$name .= '-' . strtolower($ch);
			}
			
			if($v !== false)
				$r .= " $name: $v;";
		}
		
		return trim($r);
	}
	
}

?>
