<?php

include_once('CMGraphic.php');
include_once('CMColor.php');

/**
 * @brief CMGraphicDraw interface defines the methods for drawing image files.
 * 
 * Where arguments for red, green, blue or alpha are permitted you may use the absolute value
 * (0 - 255 for RGB and 0 - 127 for A) or use a percentage betwen 0.0 and LESS THAN 1.0 which
 * will automatically be translated into the corresponding absolute value. 1.0 will be
 * interpreted as an absolute value of 1 which will not be translated into 255.
 * 
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
	
	/**
	 * @brief The brush color in RGBA.
	 * 
	 * The default brush color is black.
	 */
	private $brushColorRGBA = array(0, 0, 0, 0);
	
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
		
		// if we were given a file location then we need to create the resource from that
		if($this->getImageType() == "GIF")
			$this->resource = imagecreatefromgif($file);
		else if($this->getImageType() == "JPEG")
			$this->resource = imagecreatefromjpeg($file);
		else if($this->getImageType() == "PNG")
			$this->resource = imagecreatefrompng($file);
			
		// set the brush color to black
		$this->brushColor = imagecolorallocatealpha($this->resource, 0, 0, 0, 0);
	}
	
	/**
	 * @brief Convert absolute or percentage color components into absolute color components.
	 * 
	 * @param $red Red value (0 - 255 OR 0.0 - 1.0)
	 * @param $green Green value (0 - 255 OR 0.0 - 1.0)
	 * @param $blue Blue value (0 - 255 OR 0.0 - 1.0)
	 * @param $alpha Alpha value (0 - 127 OR 0.0 - 1.0)
	 * @return A new array with 4 elements representing red, green, blue and alpha respectivly.
	 */
	public function convertColorToAbsolute($red, $green, $blue, $alpha = 0) {
		if($red < 1)
			$red *= 255;
		if($green < 1)
			$green *= 255;
		if($blue < 1)
			$blue *= 255;
		if($alpha < 1)
			$alpha *= 127;
		
		return array($red, $green, $blue, $alpha);
	}
	
	/**
	 * @brief Set the current brush color.
	 * 
	 * @param $red Red value (0 - 255 OR 0.0 - 1.0)
	 * @param $green Green value (0 - 255 OR 0.0 - 1.0)
	 * @param $blue Blue value (0 - 255 OR 0.0 - 1.0)
	 * @param $alpha Alpha value (0 - 127 OR 0.0 - 1.0)
	 * @return The current brush colour as created by imagecolorallocate().
	 * @see getBrushColor()
	 */
	public function setBrushColor($red, $green, $blue, $alpha = 0) {
		if($this->resource === false)
			return false;
			
		// translate colours
		list($red, $green, $blue, $alpha) = $this->brushColorRGBA =
			$this->convertColorToAbsolute($red, $green, $blue, $alpha);
		
		// set bruch color
		$this->brushColor = imagecolorallocatealpha($this->resource, $red, $green, $blue, $alpha);
		return $this->brushColor;
	}
	
	/**
	 * @brief Get the current brush color.
	 * 
	 * @return An array of 3 elements in the order of red, green and blue.
	 * @see setBrushColor()
	 */
	public function getBrushColor() {
		return $this->brushColorRGB;
	}
	
	/**
	 * @brief Draw an arc.
	 * 
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
		
		return imagearc($this->resource, $cx, $cy, $width, $height, $start, $end, $this->brushColor);
	}
	
	/**
	 * @brief Draw a rectangle.
	 * 
	 * @param $x1 Upper left x coordinate.
	 * @param $y1 Upper left y coordinate 0, 0 is the top left corner of the image.
	 * @param $x2 Bottom right x coordinate.
	 * @param $y2 Bottom right y coordinate.
	 * @return \true on success, otherwise \false.
	 */
	public function drawRectangle($x1, $y1, $x2, $y2) {
		if($this->resource === false)
			return false;
		
		return imagerectangle($this->resource, $x1, $y1, $x2, $y2, $this->brushColor);
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
	 * 
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
	 * 
	 * @return \true or \false.
	 */
	public function getAntiAlias() {
		return $this->antialias;
	}
	
	/**
	 * @brief Get the RGBA of a single pixel.
	 * 
	 * Returns the index of the color of the pixel at the specified location.
	 * 
	 * If PHP is compiled against GD library 2.0 or higher and the image is a truecolor image,
	 * this function returns the RGBA value of that pixel as integer.
	 * 
	 * @param $x x-coordinate of the point.
	 * @param $y y-coordinate of the point.
	 * @return A four element array containing red, green, blue and alpha respectivly.
	 */
	public function colorAtPixel($x, $y) {
		if($this->resource === false)
			return false;
		
		$rgb = imagecolorat($this->resource, $x, $y);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		
		return array($r, $g, $b, 0);
	}
	
	/**
	 * @brief Draw a line.
	 * 
	 * @param $x1 x-coordinate for first point.
	 * @param $y1 y-coordinate for first point.
	 * @param $x2 x-coordinate for second point.
	 * @param $y2 y-coordinate for second point.
	 * @return \true on success, otherwise \false.
	 */
	public function drawLine($x1, $y1, $x2, $y2) {
		if($this->resource === false)
			return false;
		
		return imageline($this->resource, $x1, $y1, $x2, $y2, $this->brushColor);
	}
	
}

?>
