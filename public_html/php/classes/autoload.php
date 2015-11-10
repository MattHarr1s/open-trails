<?php

/**
 * Class Autoloader
 * stolen from Skyler
 * sin verguenza
 *
 * @author Skyler Rexroad
 */
spl_autoload_register("Autoloader::classLoader");
class Autoloader {
	/**
	 * This function autoloads classes if they exist
	 *
	 * @param string $className name of class to load
	 * @return bool false if classes can not be loaded
	 **/
	public static function classLoader($className) {
		$className = strtolower($className);
		if(is_readable(__DIR__ . "/$className.php")) {
			require_once(__DIR__ . "/$className.php");
		} else {
			return(false);
		}
	}
}