<?php

include_once("CMClass.php");

/**
 * @brief Dealing with versioning.
 * 
 * @section description Description
 * This abstract class is used for creating and dissecting version number, particually from
 * ::Version() and ::Since() that all CM classes use.
 * 
 * @section usage Usage
 * See the examples below.
 * 
 * @section example Example
 * A common example is to make sure the class is at least a given version:
 * @code
 * if(CMVersion::MakeVersion(CMFileVCF::Version()) < CMVersion::MakeVersion("1.0.3"))
 *   die("Sorry, you need at least v1.0.3 of CMFileVCF");
 * @endcode
 * 
 * The same example above can be written simpler with:
 * @code
 * if(CMVersion::AtLeast(CMFileVCF::Version(), "1.0.3"))
 *   die("Sorry, you need at least v1.0.3 of CMFileVCF");
 * @endcode
 * 
 * @author Elliot Chance
 */
abstract class CMVersion implements CMClass {
	
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
	 * @brief Translate a string version into a numerical version.
	 * 
	 * Versions are in the form of MAJOR.MINOR.REVISION where the REVSISION can be ommited and have
	 * a value of 0. The MAJOR, MINOR and REVISION each have a respective weight of 1000000, 1000 and
	 * 1 respectivly. So the following versions get calculated as follows:
	 * 
	 * <pre>
	 * 1.0.0   -> 1000000
	 * 1.23.34 -> 1023034
	 * 2.5     -> 2005000
	 * </pre>
	 * 
	 * @warning As this is a purely methematical function, if a version if given in an unacceptable
	 *          format it may return unexpected or illogical results.
	 * 
	 * @param $versionString The version string in the form of <tt>MAJOR.MINOR.REVISION</tt> or
	 *        <tt>MAJOR.MINOR</tt>.
	 * @return Numerical value of the version.
	 */
	public static function MakeVersion($versionString) {
		$parts = explode('.', $versionString);
		return (1000000 * $parts[0]) + (1000 * $parts[1]) + $parts[2];
	}
	
	/**
	 * @brief Check if one version is greater or equal to than another.
	 * 
	 * $version1 and $version2 will automatically be determined to be numerical or string versions
	 * and calculated as needed.
	 * 
	 * @param $version1 Numerical or string value of the version.
	 * @param $version2 Numerical or string value of the version.
	 * @return \true if $version2 is greater than OR equal to $version1.
	 */
	public static function AtLeast($version1, $version2) {
		// translate versions to numeric
		if(!is_numeric($version1))
			$version1 = CMVersion::MakeVersion($version1);
		if(!is_numeric($version2))
			$version2 = CMVersion::MakeVersion($version2);
			
		return $version1 >= $version2;
	}
	
	/**
	 * @brief Check if one version is only greater to than another.
	 * 
	 * $version1 and $version2 will automatically be determined to be numerical or string versions
	 * and calculated as needed.
	 * 
	 * @param $version1 Numerical or string value of the version.
	 * @param $version2 Numerical or string value of the version.
	 * @return \true if $version2 is greater than $version1.
	 */
	public static function Over($version1, $version2) {
		// translate versions to numeric
		if(!is_numeric($version1))
			$version1 = CMVersion::MakeVersion($version1);
		if(!is_numeric($version2))
			$version2 = CMVersion::MakeVersion($version2);
			
		return $version1 > $version2;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
