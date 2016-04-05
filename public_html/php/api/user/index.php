<?php
/**
 * API for user class. this API will handle both the sign-up, changes made to accounts, and allows for get methods for users
 *
 *	@author George <G.e.kephart@gmail.com>
 * help from: https://github.com/davidmancini/jpegery/blob/master/php/api/profile/index.php, https://github.com/brbrown59/bread-basket/blob/master/public_html/php/controllers/sign-up-controller.php*
 */

require_once dirname(dirname(__DIR__)) . "/php/classes/autoload.php";
//security w/ NG in mind
require_once dirname(dirname(__DIR__)) . "/php/lib/xsrf.php";
//a security file that's on the server created by Dylan
require_once("/var/www/trailquail/encrypted-mysql/encrypted-config.php");
// composer for Swiftmailer
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

//verify the XSRF challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->message = null;

//needed global variables that need to be set universally for
$ipAddress = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];

//beginning of the actual logic for user API
try {

	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/var/www/trailquail/encrypted-mysql/trailquail.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//permissions check to make sure the session is correct and to verify XSRF so site doesn't get jacked for Transylvanian porn

	if(empty($_SESSION["user"]) === true && $method !== "POST") {
		setXsrfCookie("/");
		throw(new RuntimeException("Please log-in or sign up", 401));
	}

	//sanitation of dirty inputs can never trust those pesky end users
	$userId = filter_input(INPUT_GET, "userId", FILTER_VALIDATE_INT);

	//make sure the Id is valid for methods that require it.
	if(($method === "DELETE" || $method === "PUT") && (empty($userId) === true || $userId <0)) {
		throw(new RuntimeException("Id cannot be negative or empty", 405));
	}

	//sanitation of the remaining fields (userEmail, userEmailActivation, userName for get methods
	//$userAccountType = filter_input(INPUT_GET, "userAccountType", FILTER_SANITIZE_STRING);
	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_EMAIL);
	$userEmailActivation = filter_input(INPUT_GET, "userEmailActivation", FILTER_SANITIZE_STRING);
	$userName = filter_input(INPUT_GET, "userName", FILTER_SANITIZE_STRING);

	/**
	 * the actual get method if get by hash or salt do exist they have been left off for now, because i feel like they are a security threat.
	 * the get by methods included is by ( userId, accountType, email, emailActivation, username)
	 * I will also verify that the XSRF token Exists.
	 */
	if($method === "GET") {
		//set the XSRF token
		setXsrfCookie("/");
		//grab the profile based on userId
		if(empty($userId) === false) {
			$reply->data = User::getUserByUserId($pdo, $userId);
		}

		if(empty($userEmail) === false) {
			$reply->data = User::getUserByUserEmail($pdo, $userEmail);
		}

		if(empty($userEmailActivation) === false) {
			$reply->data = User::getUserByActivation($pdo, $userEmailActivation);
		}

		if(empty($userName) === false) {
			$reply->data = User::getUserByUserName($pdo, $userName);
		}
	}



}













