<?php

require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * controller/api for the listing class
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */

// verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/open-trails.ini");

	// if the volunteer session is empty, the user is not logged in, throw an exception
	if(empty($_SESSION["user"]) === true) {
		setXsrfCookie("/");																						// ????????????????????????????
		throw(new RuntimeException("Please log-in or sign up", 401));								// THIS GOES ELSEWHERE??????????????????????????
	}

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];			// WHAT IS GOING ON HERE??????????

	// sanitize the commentId
	$commentId = filter_input(INPUT_GET, "commentId", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($commentId) === true || $commentId < 0)) {
		throw(new InvalidArgumentException("comment ID cannot be empty or negative", 405));
	}

	// sanitize and trim the other fields
	// trailId, userId, browser, createDate, ipAddress, commentPhoto, commentPhotoType, commentText			// only fields are commentPhoto, commentPhotoType, & commentText?!?!?!!?!?!?
	$commentPhoto = filter_input
	$commentPhotoType = filter_input;																							// HOW DO YOU FILTER THESE???????????????
	$commentText = filter_input(INPUT_GET, "commentText", FILTER_SANITIZE_STRING);

	// handle all RESTful calls to listing
	//get some or all Comments
	if($method === "GET") {
		// set an XSRF cookie on get requests
		setXsrfCookie("/");
		if(empty($commentId) === false) {
			$reply->data = Comment::getCommentByCommentId($pdo, $commentId);
		} elseif(empty($trailId) === false) {
			$reply->data = Comment::getCommentByUserId($pdo, $userId);
		} elseif(empty($commentText) === false) {
			$reply->data = Comment::getCommentByCommentText($pdo, $commentText);		// DO I NEED THE OTHER ATTRIBUTES???????????????
		} else {
			$reply->data = Comment::getAllComments($pdo)->toArray();						//toArray??????????????
		}
	}

	// verify admin and verify object not empty
	// if the session belongs to an admin, allow post, put, and delete methods
	if(empty($_SESSION["user"]) === false && $_SESSION["user"]->getUserAccountType() !== "X") {
		if($method === "PUT" || $method === "POST" || $method === "DELETE") {												// DELETE???????????????????
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			//make sure all the fields are present, in order to prevent database issues
			if(empty($requestObject->trailId) === true) {
				throw(new InvalidArgumentException("Trail ID cannot be empty", 405));
			}
			if(empty($requestObject->userId) === true) {
				throw(new InvalidArgumentException("User ID cannot be empty", 405));						// DO I NEED TO DO THE ANTI-ABUSE TRAITS??????????????
			}
			if(empty($requestObject->commentPhoto) === true) {
				$requestObject->commentPhoto = null;
			}
			if(empty($requestObject->commentPhotoType) === true) {
				$requestObject->commentPhotoType = null;															// WHY DO YOU EVEN HAVE TO DO THIS??????????????????
			}
			if(empty($requestObject->commentText) === true) {
				throw(new InvalidArgumentException("Comment Text cannot be empty", 405));
			}

			// perform the actual put or post
			if($method === "PUT") {
				$comment = Comment::getCommentByCommentId($pdo, $commentId);
				if($comment === null) {
					throw(new RuntimeException("Comment does not exist", 404));
				}
				// trailId, userId, browser, createDate, ipAddress, commentPhoto, commentPhotoType, commentText
				$comment = new Comment($commentId, $trailId, $userId, $browser, $createDate, $ipAddress, $requestObject->commentPhoto, $requestObject->commentPhotoType, $requestObject->commentText);			// SHOULD COMMENTID BE NULL? HOW DO YOU GET TRAIL & USER IDs? DO ANTIABUSE CORRECTLY!!!!!!!!!!!!!!!
				$comment->insert($pdo);
			}
		}
	}
}