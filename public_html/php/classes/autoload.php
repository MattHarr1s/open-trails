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
		$className[0] = strtolower($className[0]);
		$className = preg_replace_callback("/([A-Z])/", function($matches) {
			return("-" . strtolower($matches[0]));
		}, $className);
		$classFile = __DIR__ . "/" . $className . ".php";
		if(is_readable($classFile) === true && require_once($classFile)) {
			return(true);
		} else {
			return(false);
		}
	}
}