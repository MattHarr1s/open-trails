<?php


require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
// go over with dylan to make sure this is correct
require_once("etc/apache2/capstone-msql/encrypted-config.php");

/**
 * controller/api for the trail class
 *
 * allows for interaction with the rest of the backend via the restful API class
 *
 * @author George Kephart <g.e.kephart@gmail.com>
 */

// verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{
	//grab the mySQL connection get correct path from dylan
	$pdo = connectToEncrptedMysql("foo");

	// this is a place holder taken from bread basket and has been molded to mirror your project.
	// will go over what needs to be changed tp make sure quail trails user experience is correct.
	if(empty($_SESSION["user"]) === true) {
		setXsrfCookie("/");
		throw(new RuntimeException("Please log-in or sign up", 401));
	}
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// sanitize  and trim the rest of the inputs
	$userId = filter_input(INPUT_GET, "userId", FILTER_VALIDATE_INT);
	$browser = filter_input(INPUT_GET, "browser", FILTER_SANITIZE_STRING);
	// do i need to add create date
	// do i need to add ip address
	// do i need to add submit trail id
	$accessibility = filter_input(INPUT_GET, "accessibility", FILTER_SANITIZE_STRING);
	$amenities = filter_input(INPUT_GET, "amenities", FILTER_SANITIZE_STRING);
	$condition = filter_input(INPUT_GET, "condition", FILTER_SANITIZE_STRING);
	$description = filter_input(INPUT_GET, "description", FILTER_SANITIZE_STRING);
	$difficulty = filter_input(INPUT_GET, "difficulty", FILTER_VALIDATE_INT);
	$distance = filter_input(INPUT_GET, "distance", FILTER_VALIDATE_INT);
	$name = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);
	$submission = filter_input(INPUT_GET,"submission", FILTER_VALIDATE_INT);
	$terrain = filter_input(INPUT_GET, "terrain", FILTER_SANITIZE_STRING);
	$traffic = filter_input(INPUT_GET, "traffic", FILTER_SANITIZE_STRING);
	$use = filter_input(INPUT_GET, "use", FILTER_SANITIZE_STRING);
	// do i need to add uuid?

	//grab the mySql connection
	// filler $pdo = foo

	// handle all restful calls
	// get some of all trails
	if ($method === "GET") {
		//set an XSRF cookie request
		setXsrfCookie("/");
		if(empty($id) === false) {
			$reply->data = Trail::getTrailById($pdo, $id);
		}// get trail by user id
		// get trail by sumbit type
		// get trail by accesibility
		// get trail by ammenities
		//  get trail by condition
		// get trail by describsion
		// get trail by difficulty
		// get trail by distance
		// get trail by submission type
		// get trail by terrain
		// get trail by name
		// get trail by traffic
		// get trail by use
		// get trail by trail uuid
	}



}
