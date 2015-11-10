<?php

/**
 * Trait anti-abuse
 *
 * records the user's IP address, browser type, and a timestamp (used in user, comment, & trail classes)
 *
 * @author Louis Gill <lgill7@cnm.edu>
 **/

trait antiAbuse {
	/**
	 * ipAddress
	 * @var string $ipAddress
	 **/
	private $ipAddress;

	/**
	 * browser
	 * @var string $browser
	 **/
	private $browser;

	/**
	 * createDate
	 * @var DateTime $createDate
	 **/
	private $createDate;

	/**
	 * custom filter for mySQL style dates
	 *
	 * Converts a string to a DateTime object or false if invalid. This is designed to be used within a mutator method.
	 *
	 * @param mixed $newDate date to validate
	 * @return mixed DateTime object containing the validated date or false if invalid
	 * @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
	 * @throws InvalidArgumentException if the date is in an invalid format
	 * @throws RangeException if the date is not a Gregorian date
	 **/
	function validateDate($newDate) {
		// base case: if the date is a DateTime object, there's no work to be done
		if(is_object($newDate) === true && get_class($newDate) === "DateTime") {
			return($newDate);
		}

		// treat the date as a mySQL date string: Y-m-d H:i:s
		$newDate = trim($newDate);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newDate, $matches)) !== 1) {
			throw(new InvalidArgumentException("date is not a valid date"));
		}

		// verify the date is really a valid calendar date
		$year   = intval($matches[1]);
		$month  = intval($matches[2]);
		$day	= intval($matches[3]);
		$hour   = intval($matches[4]);
		$minute = intval($matches[5]);
		$second = intval($matches[6]);
		if(checkdate($month, $day, $year) === false) {
			throw(new RangeException("date $newDate is not a Gregorian date"));
		}

		// verify the time is really a valid wall clock time
		if($hour < 0 || $hour >= 24 || $minute < 0 || $minute >= 60 || $second < 0  || $second >= 60) {
			throw(new RangeException("date $newDate is not a valid time"));
		}

		// if we got here, the date is clean
		$newDate = DateTime::createFromFormat("Y-m-d H:i:s", $newDate);
		return($newDate);
	}

	/**
	 * accessor method for ipAddress
	 *
	 * @return string value of ipAddress
	 **/
	public function getIpAddress() {
		$this->ipAddress = filter_var($ipAddress, FILTER_VALIDATE_IP); // ????????????????????
		$this->ipAddress = inet_ntop($ipAddress);
		return($this->ipAddress);
	}

	/**
	 * mutator method for ipAddress
	 *
	 * @param string $newIpAddress new value of ipAddress
	 * @throws UnexpectedValueException if $newIpAddress is not valid
	 **/
	public function setIpAddress($newIpAddress) {
		$newIpAddress = filter_var($newIpAddress, FILTER_VALIDATE_IP);
		if($newIpAddress === false) {
			throw(new UnexpectedValueException("IP address is not valid"));
		}
		$newIpAddress = inet_pton($newIpAddress);
		$this->ipAddress = $newIpAddress;
	}

	/**
	 * accessor method for browser
	 *
	 * @return string value of browser
	 **/
	public function getBrowser() {
		return($this->browser);
	}

	/**
	 * mutator method for browser
	 *
	 * @param string $newBrowser new value of browser
	 * @throws UnexpectedValueException if $newBrowser is not a string or is insecure
	 **/
	public function setBrowser($newBrowser) {
		$newBrowser = trim($newBrowser);
		$newBrowser = filter_var($newBrowser, FILTER_SANITIZE_STRING);
		if(empty($newBrowser) === true) {
			throw(new UnexpectedValueException("browser field is empty"));
		}
		$this->browser = $newBrowser;
	}

	/**
	 * accessor method for createDate
	 *
	 * @return DateTime value for $createDate
	 **/
	public function getCreateDate() {
		return($this->createDate);
	}

	/**
	 * mutator method for createDate
	 *
	 * @param DateTime $newCreateDate new value of createDate
	 * @throws InvalidArgumentException if $newCreateDate is not a valid object or string
	 * @throws RangeException if $newCreateDate is a date that does not exist
	 * @throws Exception if $newCreateDate is
	 **/
	public function setCreateDate($newCreateDate) {
		if($newCreateDate === null) {
			$this->createDate = new DateTime();
		}

		try {
			$newCreateDate = validateDate($newCreateDate);
		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
		$this->createDate = $newCreateDate;
	}
}


//filter sanitize
//accessors & mutators

/**
$ipAddress = $_SERVER['REMOTE_ADDR'];

$browser = $_SERVER['HTTP_USER_AGENT'];
**/