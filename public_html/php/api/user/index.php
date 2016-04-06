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

	//make sure that all needed fields are present, in order to prevent database issues
	if($method === "POST" || $method === "PUT") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//enforce that needed info was provided from the end user
		// (stuff defined at the server level can be left out, and in this case both salt and hash)
		// (userEmail, userName,)
		if(empty($requestObject->userEmail) === true) {
			throw(new InvalidArgumentException("email is a required field", 406));
		}
		if(empty($requestObject->userName) === true) {
			throw(new InvalidArguementException("username is a required field", 406));
		}
	}

	// actual put method taking place
	if($method === "PUT") {
		//verify that the user attempting to be edited exists
		$user = User::getUserByUserId($pdo, $_SESSION["user"]->getUserId());
		if($user === null) {
			throw(new RuntimeException("requested user does not exist", 404));
		}
		//verify the user is only trying to edit there own profile
		//if not throw an exception
		$security = User::getUserByUserId($pdo, $_SESSION["user"]->getUserId());
		if(($security->getUserId() ===false) && ($_SESSION["user"]->userId() !== $user->getUserId())) {
			throw(new RuntimeException("you can only modify your own Information", 403));
		}

		// extract the data needed to be passed to the user class
		$user->setUserEmail($requestObject->userEmail);
		$user->setUserName($requestObject->userName);

		//require a password then salt and hash it
		if($requestObject->password !== null) {
			$hash = hash_pbkdf2("sha512", $requestObject->password, $user->getUserSalt(), 262144, 128);
			$user->setUserHash($hash);
		}
		//enforce the password is not null
		if(($user->getUserId() === false) && ($requestObject->password !== null)) {
			$_SESSION["user"]->setUserId(false);
		}
		$reply->message = "profile has been updated";
	// begining of the post method need to finish in the next fourty minutes
	} elseif ($method === "POST") {

		//needed encryption for user password and creation of email activation value
		$password = $requestObject->userPassword;
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$hash = hash_pbkdf2("sha512", $password, $salt, 262144);
		$userEmailActivation = bin2hex(openssl_random_pseudo_bytes(8));

		//create a brand new user
		$user =  User(null, $browser, new DateTime(), $ipAddress, "R", $requestObject->userEmail, $userEmailActivation, $userHash, $requestObject->userName, $userSalt);
		$user->insert($pdo);
		$_SESSION["user"] = $user;
		$reply->message = "user has been created";

		//compose and send the email for confirmation and setting a new password
		// create Swift message
		$swiftMessage = Swift_Message::newInstance();

		// attach the sender to the message
		// this takes the form of an associative array where the Email is the key for the real name
		$swiftMessage->setFrom(["noreply@trailquail.net" => "trailQuail"]);

		/**
		 * attach the recipients to the message
		 * this is an array that can include or omit the the recipient's real name
		 * use the recipients' real name where possible; this reduces the probability of the Email being marked as spam
		 **/
		$recipients = [$requestObject->userEmail];
		$swiftMessage->setTo($recipients);
		// attach the subject line to the message
		$swiftMessage->setSubject("Please confirm your trailquail account");

		/**
		 * attach the content to the message
		 * here, we set two versions of the message: the HTML formatted message and a special filter_var()ed
		 * version of the message that generates a plain text version of the HTML content
		 * notice one tactic used is to display the entire $confirmLink to plain text; this lets users
		 * who aren't viewing HTML content in Emails still access your links
		 **/
		// building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
		$basePath = $_SERVER["SCRIPT_NAME"];
		for($i = 0; $i < 3; $i++) {
			$lastSlash = strrpos($basePath, "/");
			$basePath = substr($basePath, 0, $lastSlash);
		}
		//this line of code will almost certainly need some playing around with
		$urlGlue = $basePath . "/controllers/email-confirmation?profileVerify=" . $user->getUserEmailActivation();
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlGlue;
		$message = <<< EOF
<h1>welcome to Trailquail!<h1>
<p>click the link now to finish setting up your Account<p>
<a herf="$confirmLink>$confirmLink</a>
EOF;

		$swiftMessage->setBody($message, "text/html");
		$swiftMessage->addPart(html_entity_decode(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)), "text/plain");

		/**
		 * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
		 * this default may or may not be available on all web hosts; consult their documentation/support for details
		 * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling
		 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
		 **/
		/**
		 * the send method returns the number of recipients that accepted the Email
		 * so, if the number attempted is not the number accepted, this is an Exception
		 **/
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("unable to send email", 404));
		}

	}
} catch (Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTrace();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);














