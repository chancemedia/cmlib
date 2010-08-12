<?php

include_once('CMGraphic.php');

/**
 * @brief CMGraphicDraw interface defines the methods for drawing image files.
 * @author Elliot Chance
 */
class CMGraphicDraw extends CMGraphic {
	
	/**
	 * @brief The resource handle for creating images.
	 */
	public $resource = false;
	
	/**
	 * @brief The drawing color of the brush.
	 */
	private $brushColor = false;
	
	private $brushColorRGB = array(0, 0, 0);
	
	/**
	 * @brief Anti alias enabled.
	 * @see getAntiAlias()
	 * @see setAntiAlias()
	 */
	private $antialias = false;
	
	/**
	 * @brief Alpha blending enabled.
	 * @see getAlphaBlending()
	 * @see setAlphaBlending()
	 */
	private $alphablending = false;
	
	/**
	 * @brief Create a new CMGraphicDraw object with or without a file.
	 * @param $file An optional file name.
	 */
	public function CMGraphicDraw($file = false) {
		parent::CMGraphic($file);
	}
	
	/**
	 * @brief Set the current brush color.
	 * @param $red Red value (0 - 255)
	 * @param $green Green value (0 - 255)
	 * @param $blue Blue value (0 - 255)
	 * @return The current brush colour as created by imagecolorallocate().
	 */
	public function setBrushColor($red, $green, $blue) {
		if($this->resource === false)
			return false;
			
		$this->brushColor = imagecolorallocate($this->resource, $red, $green, $blue);
		return $this->brushColor;
	}
	
	/**
	 * @brief Draw an arc.
	 * @param $cx x-coordinate of the center.
	 * @param $cy y-coordinate of the center.
	 * @param $width The arc width.
	 * @param $height The arc height.
	 * @param $start The arc start angle, in degrees.
	 * @param $end The arc end angle, in degrees. 0° is located at the three-o'clock position, and
	 *        the arc is drawn clockwise.
	 * @param $a Options. Ignored.
	 * @return \true on success, otherwise \false.
	 * @see setBrushColor()
	 */
	public function drawArc($cx, $cy, $width, $height, $start, $end, $a = array()) {
		if($this->resource === false)
			return false;
			
		// set the brush color to black if one has not been set
		if($this->brushColor === false)
			$this->brushColor = imagecolorallocate($this->resource, 0, 0, 0);
		
		return imagearc($this->resource, $cx, $cy, $width, $height, $start, $end, $this->brushColor);
	}
	
	/**
	 * @brief Set the blending mode for an image.
	 * 
	 * setAlphaBlending() allows for two different modes of drawing on truecolor images. In
	 * blending mode, the alpha channel component of the color supplied to all drawing function,
	 * such as setPixel() determines how much of the underlying color should be allowed to shine
	 * through. As a result, gd automatically blends the existing color at that point with the
	 * drawing color, and stores the result in the image. The resulting pixel is opaque. In
	 * non-blending mode, the drawing color is copied literally with its alpha channel information,
	 * replacing the destination pixel. Blending mode is not available when drawing on palette
	 * images.
	 * 
	 * @param $blendmode Whether to enable the blending mode or not. On true color images the
	 *        default value is \true otherwise the default value is \false.
	 * @return Returns \true on success or \false on failure.
	 */
	public function setAlphaBlending($blendmode) {
		if($this->resource === false)
			return false;
		
		return imagealphablending($this->resource, $blendmode);
	}
	
	/**
	 * @brief Find if alpha blending is enabled.
	 * @return \true or \false.
	 */
	public function getAlphaBlending() {
		return $this->alphablending;
	}
	
	/**
	 * @brief Should antialias functions be used or not.
	 * 
	 * Activate the fast drawing antialiased methods for lines and wired polygons. It does not
	 * support alpha components. It works using a direct blend operation. It works only with
	 * truecolor images.
	 * 
	 * Thickness and styled are not supported.
	 * 
	 * Using antialiased primitives with transparent background color can end with some unexpected
	 * results. The blend method uses the background color as any other colors. The lack of alpha
	 * component support does not allow an alpha based antialiasing method.
	 * 
	 * @param $enabled Whether to enable antialiasing or not.
	 * @return Returns \true on success or \false on failure.
	 */
	public function setAntiAlias($enabled) {
		if($this->resource === false)
			return false;
		
		$this->antialias = $enabled;
		return imageantialias($this->resource, $enabled);
	}
	
	/**
	 * @brief Find if anti aliasing is enabled.
	 * @return \true or \false.
	 */
	public function getAntiAlias() {
		return $this->antialias;
	}
	
}

?>
