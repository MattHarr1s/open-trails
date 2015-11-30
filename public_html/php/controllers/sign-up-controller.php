<?php
/**
 * controller for the signing up of a new user
 *
 * @author Louis Gill <lgill7@cnm.edu>
 * contributor code from https://github.com/sandidgec/foodinventory &
 * https://github.com/Skylarity/trufork
 **/

//auto loads classes
require_once(dirname(dirname(__DIR__)) . "/php/classes/autoload.php");

//security w/ NG in mind
require_once(dirname(dirname(__DIR__)) . "/php/lib/xsrf.php");

//a security file that's on the server created by Dylan
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");					// ???????????????

//composer??																			//DO WE NEED TO REQUIRE OUR COMPOSER PACKAGE??????

// prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->message = null;

$ipAddress = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$createDate = 													// ???????????????????

try {
	// ensures that the fields are filled out
	if(@isset($_POST["email"]) === false || @isset($_POST["username"]) === false || @isset($_POST["password"]) === false || @isset($_POST["verifyPassword"]) === false) {
		throw(new InvalidArgumentException("Form not complete. Please verify and try again."));
	}

	//verify the XSRF challenge
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	verifyXsrf();

	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/open-trails.ini");		//CORRECT FILE NAME?????

	// convert POSTed JSON to an object
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);											//WHAT???????????

	//sanitize the email & search by userEmail
	$email = filter_var($requestObject->email, FILTER_SANITIZE_EMAIL);
	$user = User::getUserByUserEmail($pdo, $email);
	if($user !== null) {
		throw new RuntimeException("This email already has an account", 422);
	}

	// sanitize the username & search by userName
	$userName = filter_var($requestObject->userName, FILTER_SANITIZE_STRING);
	$user = User::getUserByUserName($pdo, $userName);
	if($user !== null) {
		throw new RuntimeException("This username already exists", 422);
	}

	// create a new salt and email activation
	$userSalt = bin2hex(openssl_random_pseudo_bytes(32));								//WE DIDN'T DO THIS IS IN THE USER CLASS??????????
	$userEmailActivation = bin2hex(openssl_random_pseudo_bytes(8));				//WHERE DOES THIS COME INTO PLAY????????

	// create the hash
	$userHash = hash_pbkdf2("sha512", $requestObject->password, $userSalt, 262144, 128);			//WHAT DO THESE NUMBERS MEAN????????

	// create a new User and insert into mySQL
	$user = new User(null, $this->browser, $this->createDate, $this->ipAddress, accountType?, $requestObject->userEmail, $userHash, $requestObject->$userName, $userSalt);	// HOW DO YOU DO ACCOUNT TYPE????????
	$user->insert($pdo);
	$reply->message = "A new user has been created";

	if($user->getUserIsAdmin() === true) {
		$_SESSION["user"] = $user;
		$reply->status = 200;
		$reply->message = "Logged in as administrator";							// HUH??????????
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

/**header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply); **/								// WHAT IS GOING ON HERE???????????

?>
