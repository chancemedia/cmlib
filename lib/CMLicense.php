<?php

/**
 * @brief License file.
 * 
 * This class acts as both a license checker and license file. To run CMLIB you need to have an active
 * <tt>CMLicense.php</tt> file. When you renew your license you will receive a new
 * <tt>CMLicense.php</tt> that will replace the existing one. You do not have to restart your server
 * or any services (eg Apache) for the new license to take effect.
 * 
 * You may view your current license and PHP information by using the <tt>phpinfo.php</tt> file
 * provided with the package.
 * 
 * @author Elliot Chance
 */
class CMLicense {
	
	/**
	 * @brief The name or company the library is licensed to.
	 */
	public static $LicenseName;
	
	/**
	 * @brief The name or company the library is licensed to.
	 */
	public static $Expire;
	
	/**
	 * @brief Protection code stops the license being altered.
	 */
	public static $ProtectionCode;
	
	/**
	 * @brief The person to contact for service or renewal.
	 */
	public static $AccountManager;
	
	/**
	 * @brief Contact phone number.
	 */
	public static $AccountContact;
	
	/**
	 * @brief Get the salt for this machine.
	 * @return The salt returned will be used to bind the license to this machine.
	 */
	public static function GetSalt() {
		return php_uname('n');
	}
	
	/**
	 * @brief Get license status.
	 * 
	 * For Invalid or Expired, please contact Chance MEDIA Pty Ltd for license repair or renewal.
	 * 
	 * @return Either "Invalid", "Active" or "Expired".
	 */
	public static function GetStatus() {
		// this software is free
		return "Active";
		
		$s = CMLicense::$LicenseName . " " . CMLicense::$Expire . " " . CMLicense::GetSalt();
		if(sha1($s) !== CMLicense::$ProtectionCode)
			return "Invalid";
			
		if(time() < CMLicense::$Expire)
			return "Active";
			
		return "Expired";
	}
	
	/**
	 * @brief Check if the license is valid for this machine.
	 * 
	 * If your licence is missing, invalid, altered or expired you will not be able to use the CMLIB
	 * software until it is renewed. Chance MEDIA recommends renewal of licenses 30 days before they
	 * expire.
	 * 
	 * @return Nothing.
	 */
	public static function CheckLicense() {
		// this software is free
		return true;
		
		if(CMLicense::$Expire < time())
			die("Your license has expired");
			
		$s = CMLicense::$LicenseName . " " . CMLicense::$Expire . " " . CMLicense::GetSalt();
		if(sha1($s) !== CMLicense::$ProtectionCode)
			die("Your license is invalid");
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
}

?>
