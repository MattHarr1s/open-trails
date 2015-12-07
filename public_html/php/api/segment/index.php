<?php

require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
// go over with dylan to make sure this is correct
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(dirname(dirname(dirname(__DIR__)))) . "/vendor/autoload.php";
/**
 * API for segment for segment class
 *
 * allows for the interaction with the rest of the backend via the restful API class
 */


//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

// start the session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

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
	/*
	 * declare that angular is going to send object in point x and point y i need to find a way of bridging the gap between
	 * php and angular like almost how it is done in the actual point class.
	 *
	 */


	$segmentX =
	$segmentY = "segmentStop";
	$elevationX = filter_input(INPUT_GET, "segmentStartElevation", FILTER_VALIDATE_INT);
	$elevationY = filter_input(INPUT_GET, "segmentStopElevation", FILTER_VALIDATE_INT);


	//handle all restful calls
	// get some or all segments
	if ($method === "GET") {
		// not sure if i need to set XSRF COOKIE
		// TL; DR: yes
		setXsrfCookie("/");
		if (empty($id) === false) {
			$reply->data = Segment::getSegmentBySegmentId($pdo, $id);
		} elseif(empty($segmentX) === false) {
			$reply->data = Segment::getSegmentBySegmentStart($pdo, $segmentX)->toArray();
		} elseif(empty($segmentY) === false) {
			$reply->data = Segment::getSegmentBySegmentStop($pdo, $segmentY)->toArray();
		} elseif(empty($elevationX) === false) {
			$reply->data = Segment::getSegmentBySegmentStartElevation($pdo, $elevationX)->toArray();
		} elseif(empty($elevationY) === false) {
			$reply->data = Segment::getSegmentBySegmentStopElevation($pdo, $elevationY)->toArray();
		}
	}
	//if the section belongs to a new an active user allow post, put and delete m
	if(empty($_SESSION["user"]) === false && $_SESSION["user"]->getUserAccountType() !== "X"); {
		if($method === "PUT" || $method === "POST" || $method === "DELETE") {

			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			// make sure al fields are present, in order to prevent database issues
			if(empty($requestObject->segmentStart) === true) {
				throw(new InvalidArgumentException("segment start cannot be empty"));
			}
			if(empty($requestObject->segmentStop) === true) {
				throw(new InvalidArgumentException("segment stop cannot be empty"));
			}
			if(empty($requestObject->segmentStartElevation) === true) {
				throw(new InvalidArgumentException("elevation start cannot be null"));
			}
			if(empty($requestObject->segmentStopElevation) === true) {
				throw(new InvalidArgumentException("elevation stop cannot be null"));
			}

			//preform the a put post or delete
			if($method === "PUT") {
				//verify the xsrf token
				$segment = Segment::getSegmentBySegmentId($pdo, $id);
				// verify the segment in question exists
				if($segment === null) {
					throw(new RuntimeException("segment must exist", 404));
				}
				$segment = new Segment($id, $requestObject->segmentStart, $requestObject->segmentStop, $requestObject->segmentStartElevation, $requestObject->segmentStopElevation);
				$segment->update($pdo);
				$reply->message = "segment update was successful";
			}
			if($method === "POST") {
				// form a mini-constructor to assemble a segmentStart and a segmentStop....?????
				$segment = new Segment(null, $requestObject->segmentStart, $requestObject->segmentStop, $requestObject->segmentStartElevation, $requestObject->segmentStopElevation );
				$segment->insert($pdo);
				$reply->message = "segment insert was successful";
			}
			if($method === "DElETE") {
				$segment = Segment::getSegmentBySegmentId($pdo, $id);
				if($segment === null) {
					throw(new RuntimeException("segment must exist", 404));
				}
				$segment->delete($pdo);
				$deletedObject = new stdClass();
				$deletedObject->segmentId = $id;
			}
		} else {
			if((empty($method) === false) &&($method !=="GET")) {
				throw(new RuntimeException("only active users are allowed to modify entries", 401));
		}
	}


	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);


