<?php
/**
 * controller for sending a confirmation email to a new user
 *
 * @author Louis Gill <lgill7@cnm.edu>
 * @author George Kephart <g.e.kephart@gmail.com>
 * contributor code from https://github.com/skylarity/trufork
 */

//auto loads classes
require_once(dirname(dirname(dirname(__DIR__))) . "/php/classes/autoload.php");
//security w/ NG in mind
require_once(dirname(dirname(__DIR__)) . "/lib/xsrf.php");
// a security file that's on the server created by Sys Admin not found on the actual deployment
require_once("/var/www/trailquail/encrypted-mysql/encrypted-config.php");
// composer for Swiftmailer
require_once dirname(dirname(dirname(dirname(__DIR__)))) . "/vendor/autoload.php";

// verify the the XSRF challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->message = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/var/www/trailquail/encrypted-mysql/open-trails.ini");
	$userEmailActivation = filter_input(INPUT_GET, "emailActivation", FILTER_SANITIZE_STRING);
	if ($userEmailActivation === null) {
		throw(new InvalidArgumentException("testing"));
	}

	$user = User::getUserByActivation($pdo, $userEmailActivation);
	if(empty($user) === true || ($user) === null) {
		throw (new InvalidArgumentException("activation code has already been used or doesn't exist", 404));
	} else {
		$userEmailActivation->setUsersetUserEmailActivation();
		$user->update($pdo);
		$reply->data = "Congratulations, your account has been activated!";
	}


	//pull activation from email. Will this work? If not, throw an exception todo check !OK
	if(isset($_GET["emailActivation"])) {
		$userEmailActivation = $_GET["emailActivation"];
		$user = User::getUserByUserEmailActivation($pdo, $userEmailActivation);

		if(empty($user === true)) {
			throw(new InvalidArgumentException("Activation code has been activated or does not exist"));
		} else {
			$user->setUserEmailActivation(null);
			$user->update($pdo);
		}

		$reply->message = "Congratulations, your account has been activated!";
	}
} catch (Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);