<?php


require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
// go over with dylan to make sure this is correct
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * controller/api for the trail class
 *
 * allows for interaction with the rest of the backend via the restful API class
 *
 * @author George Kephart <g.e.kephart@gmail.com>
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
	// sanitize  and trim the rest of the inputs
	$userId = filter_input(INPUT_GET, "userId", FILTER_VALIDATE_INT);
	$submitId = filter_input(INPUT_GET, "submitId", FILTER_VALIDATE_INT);
	$browser = filter_input(INPUT_GET, "browser", FILTER_SANITIZE_STRING);
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
	$uuid = filter_input(INPUT_GET, "use", FILTER_SANITIZE_STRING);


	// handle all restful calls
	// get some of all trails
	if ($method === "GET") {
		setXsrfCookie("/");
		if(empty($id) === false) {
			$reply->data = Trail::getTrailById($pdo, $id);
		} elseif(empty($userId) === false) {
			$reply->data = Trail::getTrailByUserId($pdo, $userId);
		} elseif(empty($submitId) === false) {
			$reply->data = Trail::getTrailBySubmitTrailId($pdo, $submitId);
		} elseif (empty($amenities) === false) {
			$reply->data = Trail::getTrailByTrailAmenities($pdo, $amenities);
		} elseif (empty($condition) === false) {
			$reply->data = Trail::getTrailByTrailCondition($pdo, $condition);
		} elseif (empty($description) === false) {
			$reply->data = Trail::getTrailByTrailDescription($pdo, $description);
		} elseif (empty($difficulty) === false) {
			$reply->data = Trail::getTrailByTrailDifficulty($pdo, $difficulty);
		} elseif (empty($distance) === false) {
			$reply->data = Trail::getTrailByTrailDistance($pdo, $distance);
		} elseif (empty($name) === false) {
			$reply->data = Trail::getTrailByTrailName($pdo, $name);
		} elseif (empty($submission) === false) {
			$reply->data = Trail::getTrailByTrailSubmissionType($pdo, $submission);
		} elseif (empty($terrain) === false) {
			$reply->data = Trail::getTrailByTrailTerrain($pdo, $terrain);
		} elseif (empty($traffic) === false) {
			$reply->data = Trail::getTrailByTrailTraffic($pdo, $traffic);
		} elseif (empty($use) === false) {
			$reply->data = Trail::getTrailByTrailUse($pdo, $use);
		} elseif (empty($uuid) === false) {
			$reply->data = Trail::getTrailByTrailUuid($pdo, $uuid);
		} else{
			$reply->data = Trail::getAllTrails($pdo)->toArray();

		}

	}

	//verify user and verify object is not empty

	// if the session belongs to an active user allow post
	if(empty($_SESSION["user"]) === false && $_SESSION["user"]->getUserAccountType() !== "X") {
		if($method === "PUT" || $method === "POST" || $method = "DELETE") {

			//verify the XSRF cookie is correct
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			//make sure all fields are present, in order to prevent database issues
			if(empty($requestObject->userId) === true) {
				throw(new InvalidArgumentException("user id cannot be empty"));
			}
			if(empty($requestObject->browser) === true) {
				throw(new InvalidArgumentException("browser cannot be empty"));
			}
			if(empty($requestObject->createDate) === true) {
				throw(new InvalidArgumentException("createDate cannot be empty"));
			}
			if(empty($requestObject->ipAddress) === true) {
				throw(new InvalidArgumentException("ip Address cannot be null"));
			}
			if(empty($requestObject->submitTrailId) === true) {
				$requestObject = null;
			}
			if(empty($requestObject->trailAmenities) === true) {
				$requestObject = null;
			}
			if(empty($requestObject->TrailCondition) === true) {
				$requestObject = null;
			}
			if(empty($requestObject->trailDescription) === true) {
				$requestObject = null;
			}
			if(empty($requestObject->traiDifficulty) === true) {
				$requestObject = null;
			}
			if(empty($requestObject->trailDistance) === true) {
				$requestObject = null;
			}
			if(empty($requestObject->trailName) === true) {
				throw(new InvalidArgumentException("trail name cannot be null"));
			}
			// do i need to put a limit on what this number can be?
			if(empty($requestObject->trailSubmissionType) === true) {
				throw(new InvalidArgumentException("submission type cannot be null"));
			}
			if(empty($requestObject->trailTerrain) === true) {
				$requestObject = null;
			}
			if(empty($requestObject->trailUse) === true) {
				$requestObject = null;
			}
			if(empty($requestObject->trailUuid) === true) {
				$requestObject = null;
			}
			if($method === "PUT") {
				verifyXsrf();
				$trail = Trail::getTrailById($pdo, $id);
				if($trail === null) {
					throw(new RuntimeException("trail does not exist", 404));
				}
				$trail = new Trail(null, $requestObject->userId, $requestObject->browser, $requestObject->creatDate, $requestObject->ipAddress, $requestObject->submitTrailId, $requestObject->trailAmenities, $requestObject->traiilCondition, $requestObject->trailDescription, $requestObject->trailDifficulty, $requestObject->trailD, $requestObject->trailDistance, $requestObject->trailName, $requestObject->trailSubbmissionType, $requestObject->trailTerrain, $requestObject->trailTraffic, $requestObject->trailUse, $requestObject->trailUuid);
				$trail->update($pdo);
			}

			if($method === "POST") {
				verifyXsrf();
				//preform the actual post/do i need to treat foreign keys in any special manner
				$trail = new Trail(null, $requestObject->userId, $requestObject->browser, $requestObject->creatDate, $requestObject->ipAddress, $requestObject->submitTrailId, $requestObject->trailAmenities, $requestObject->traiilCondition, $requestObject->trailDescription, $requestObject->trailDifficulty, $requestObject->trailD, $requestObject->trailDistance, $requestObject->trailName, $requestObject->trailSubbmissionType, $requestObject->trailTerrain, $requestObject->trailTraffic, $requestObject->trailUse, $requestObject->trailUuid);
				$trail->insert($pdo);
				$reply->message = "trail submitted okay";
			}
			if($method === "DELETE") {
				verifyXsrf();
				$trail = Trail::getTrailById($pdo, $id);
				if($trail === null) {
					throw(new RuntimeException("trail does not exist", 404));
				}
				$trail->delete($pdo);
				$deletedObject = new stdClass();
				$deletedObject->traiId = $id;
				//$pusher->trigger("misquote", "delete", $deletedObject);
				$reply->message = "trail deleted OK";
			}
		}
	} else {
	// if not an active user and attempting a method other than get, throw an exception
		if((empty($method) === false) &&($method !=="GET")) {
			throw(new RuntimeException("only active users are allowed to modify entries", 401));
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


