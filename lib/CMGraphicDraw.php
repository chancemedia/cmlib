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
	 * @brief The drawing color of the stroke.
	 */
	private $strokeColor = false;
	
	/**
	 * @brief the stroke width (in pixels.)
	 */
	private $strokeWidth = 1;
	
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
			
		// set the stroke color to black
		$this->strokeColor = CMColor::$Black;
	}
	
	/**
	 * @brief Set the current stroke color.
	 * 
	 * This applies to line and perimiter drawing.
	 * 
	 * @param $color CMColor object.
	 * @return The new stroke colour as a CMColor.
	 * @see getStrokeColor()
	 */
	public function setStrokeColor(CMColor $color) {
		$this->strokeColor = $color;
		return $this->strokeColor;
	}
	
	/**
	 * @brief Get the current stroke color.
	 * 
	 * @return CMColor object.
	 * @see setStrokeColor()
	 */
	public function getStrokeColor() {
		return $this->strokeColor;
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
	 * @see setStrokeColor()
	 */
	public function drawArc($cx, $cy, $width, $height, $start, $end, $a = array()) {
		if($this->resource === false)
			return false;
		
		$color = $this->strokeColor->getGDColor($this->resource);
		return imagearc($this->resource, $cx, $cy, $width, $height, $start, $end, $color);
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
		
		$color = $this->strokeColor->getGDColor($this->resource);
		return imagerectangle($this->resource, $x1, $y1, $x2, $y2, $color);
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
	 * @return A CMColor object.
	 */
	public function colorAtPixel($x, $y) {
		if($this->resource === false)
			return false;
		
		$rgb = imagecolorat($this->resource, $x, $y);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		
		return new CMColor($r, $g, $b, 0);
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
		
		$color = $this->strokeColor->getGDColor($this->resource);
		return imageline($this->resource, $x1, $y1, $x2, $y2, $color);
	}
	
	/**
	 * @brief Draw a polygon.
	 * 
	 * @code
	 * $image->drawPolygon(array(
	 *   0,   0,
	 *   100, 200,
	 *   300, 200
	 * ));
	 * @endcode
	 * 
	 * @param $points An array containing the polygon's vertices in the form of
	 *        array(x0, y0, x1, y1 ...)
	 * 
	 * @return \true on success, otherwise \false.
	 */
	public function drawPolygon($points) {
		if($this->resource === false)
			return false;
		
		$color = $this->strokeColor->getGDColor($this->resource);
		return imagepolygon($this->resource, $points, count($points) / 2, $color);
	}
	
	/**
	 * @brief Draw an ellipse.
	 * 
	 * @param $cx x-coordinate of the center.
	 * @param $cy y-coordinate of the center.
	 * @param $width The ellipse width.
	 * @param $height The ellipse height.
	 * @return \true on success, otherwise \false.
	 */
	public function drawEllipse($cx, $cy, $width, $height) {
		if($this->resource === false)
			return false;
		
		$color = $this->strokeColor->getGDColor($this->resource);
		return imageellipse($this->resource, $cx, $cy, $width, $height, $color);
	}
	
	/**
	 * @brief Draw a dashed line.
	 * 
	 * @param $x1 x-coordinate for first point.
	 * @param $y1 y-coordinate for first point.
	 * @param $x2 x-coordinate for second point.
	 * @param $y2 y-coordinate for second point.
	 * @return \true on success, otherwise \false.
	 */
	public function drawDashedLine($x1, $y1, $x2, $y2) {
		if($this->resource === false)
			return false;
		
		$color = $this->strokeColor->getGDColor($this->resource);
		return imagedashedline($this->resource, $x1, $y1, $x2, $y2, $color);
	}
	
	/**
	 * @brief Get the height (in pixels) of the image.
	 * @return An integer on success or \false if there was an error.
	 */
	public function getHeight() {
		if($this->resource !== false)
			return imagesy($this->resource);
			
		return parent::getHeight();
	}
	
	/**
	 * @brief Get the width (in pixels) of the image.
	 * @return An integer on success or \false if there was an error.
	 */
	public function getWidth() {
		if($this->resource !== false)
			return imagesx($this->resource);
			
		return parent::getWidth();
	}
	
	/**
	 * @brief Set a single pixel.
	 * 
	 * @param $x x-coordinate.
	 * @param $y y-coordinate.
	 * @param $color The color to set the pixel to.
	 * @return \true on success, otherwise \false.
	 */
	public function setPixel($x, $y, CMColor $color) {
		if($this->resource === false)
			return false;
		
		$color = $this->strokeColor->getGDColor($this->resource);
		return imagesetpixel($this->resource, $x, $y, $color);
	}
	
	/**
	 * @brief Set the current stroke width in pixels.
	 * 
	 * This applies to line and perimiter drawing.
	 * 
	 * @param $width Stroke width in pixels.
	 * @return The new stroke width or \false if an error occured.
	 * @see getStrokeWidth()
	 */
	public function setStrokeWidth($width) {
		$this->strokeWidth = $width;
		if(imagesetthickness($this->resource, $this->strokeWidth))
			return $this->strokeWidth;
		return false;
	}
	
	/**
	 * @brief Get the current stroke width in pixels.
	 * 
	 * @return Stroke width in pixels.
	 * @see setStrokeWidth()
	 */
	public function getStrokeWidth() {
		return $this->strokeWidth;
	}
	
}

?>
