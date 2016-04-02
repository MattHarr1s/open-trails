<?php

/**
 * controller for logging in
 *
 * @author Louis Gill <lgill7@cnm.edu>
 * contributing code from TruFork https://github.com/Skylarity/trufork & foodinventory
 */

//auto loads classes
require_once dirname(dirname(__DIR__)) . "/php/classes/autoload.php";

//security w/ NG in mind
require_once dirname(dirname(__DIR__)) . "/php/lib/xsrf.php";

//a security file that's on the server created by Dylan
require_once("/var/www/trailquail/encrypted-mysql/encrypted-config.php");

//prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->message = null;

try {
	// start the session and create an XSRF token
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	verifyXsrf();

	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/var/www/trailquail/encrypted-mysql/trailquail.ini");

	//convert POSTed JSON to an object
	$requestContent = file_get_contents("php://input");
	$requestedObject = json_decode($requestContent);

	//sanitize the email & search by userEmail
	$userEmail = filter_var($requestedObject->userEmail, FILTER_SANITIZE_EMAIL);
	$user = User::getUserByUserEmail($pdo, $userEmail);
	
	if($user !== null) {
		$userHash = hash_pbkdf2("sha512", $requestedObject->password, $user->getUserSalt(), 262144, 128);
		if($userHash === $user->getUserHash()) {
			$_SESSION["user"] = $user;
			$reply->status = 200;
			$reply->message = "Successfully logged in";
		} else {
			throw(new InvalidArgumentException("work god dammit", 401));
		}
	} else {
		throw(new InvalidArgumentException("password is invalid", 401));
	}

	//create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);