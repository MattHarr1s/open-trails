/**
* custom filter for mySQL style dates
*
* Converts a string to a DateTime object or false if invalid. This is designed to be used within a mutator method.
*
* @param mixed $newCreateDate date to validate
* @return mixed DateTime object containing the validated date or false if invalid
* @see http://php.net/manual/en/class.datetime.php PHP's DateTime class
* @throws InvalidArgumentException if the date is in an invalid format
* @throws RangeException if the date is not a Gregorian date
**/
function validateDate($newCreateDate) {
// base case: if the date is a DateTime object, there's no work to be done
if(is_object($newCreateDate) === true && get_class($newCreateDate) === "DateTime") {
return($newCreateDate);
}

// treat the date as a mySQL date string: Y-m-d H:i:s
$newCreateDate = trim($newCreateDate);
if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newCreateDate, $matches)) !== 1) {
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
throw(new RangeException("date $newCreateDate is not a Gregorian date"));
}

// verify the time is really a valid wall clock time
if($hour < 0 || $hour >= 24 || $minute < 0 || $minute >= 60 || $second < 0  || $second >= 60) {
throw(new RangeException("date $newCreateDate is not a valid time"));
}

// if we got here, the date is clean
$newCreateDate = DateTime::createFromFormat("Y-m-d H:i:s", $newCreateDate);
return($newCreateDate);
}
