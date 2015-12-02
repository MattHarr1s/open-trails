//attributes in segment
// segment Id
// segmentStart
// segmentStop
// segmentStartElevation
// segmentStopElevation

<?php

require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
// go over with dylan to make sure this is correct
require_once("etc/apache2/capstone-mySQL/encrypted-config.php");
/**
 * API for segment for segment class
 *
 * allows for the interaction with the rest of the backend via the restful API class
 */


//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

//set XSRF cookie
setXsrfCookie("/");

try{
	//grab the mySQL connection get correct path from dylan
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/trailquail.ini");


	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	//sanitize and trim the rest of the inputs
	//$SegmentA = filter_
	//$SegmentW = filter_
	$ElevationA = filter_input(INPUT_GET, "segmentStartElevation", FILTER_VALIDATE_INT);
	$ElevationW = filter_input(INPUT_GET, "segmentStopElevation", FILTER_VALIDATE_INT);


	//handle all restful calls
	// get some or all segments
	if ($method === "GET") {
		// not sure if i need to set XSRF COOKIE
		setXsrfCookie("/");
		if (empty($id) === false) {
			$reply->data = Segment::getSegmentBySegmentId($pdo, $id);
		} elseif(empty($segmentA) === false) {
			$reply->data = Segment::getSegmentBySegmentStart($pdo, $segmentStart );
		} elseif(empty($segmentB) === false) {
			$reply->data = Segment::getSegmentBySegmentStart($pdo, $segmentStop);
		} elseif(empty($segmentStartElevation) === false) {
			$reply->data = Segment::getSegmentBySegmentStartElevation($pdo, $segme)
		}
	}

}
