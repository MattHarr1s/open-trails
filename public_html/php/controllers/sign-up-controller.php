<?php
/**
 * controller for the signing up of a new user
 *
 * @author Louis Gill <lgill7@cnm.edu>
 * contributor code from https://github.com/sandidgec/foodinventory &
 * https://github.com/Skylarity/trufork
 **/

//auto loads classes
require_once dirname(dirname(__DIR__)) . "/php/classes/autoload.php";

//security w/ NG in mind
require_once dirname(dirname(__DIR__)) . "/php/lib/xsrf.php";

//a security file that's on the server created by Dylan
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

// composer for Swiftmailer
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->message = null;

$ipAddress = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];

try {
	//verify the XSRF challenge
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	verifyXsrf();

	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/trailquail.ini");

	// convert POSTed JSON to an object
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);

	// verify the passwords match!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	if($requestObject->password !== $requestObject->verifyPassword) {
		throw(new InvalidArgumentException("Please make sure that the passwords match"));
	}

	//sanitize the email & search by userEmail
	$userEmail = filter_var($requestObject->userEmail, FILTER_SANITIZE_EMAIL);
	$user = User::getUserByUserEmail($pdo, $userEmail);
	if($user !== null) {
		throw (new RuntimeException("This email already has an account", 422));
	}

	// sanitize the username & search by userName
	$userName = filter_var($requestObject->userName, FILTER_SANITIZE_STRING);
	$user = User::getUserByUserName($pdo, $userName);
	if($user !== null) {
		throw (new RuntimeException("This username already exists", 422));
	}

	// create a new salt and email activation
	$userSalt = bin2hex(openssl_random_pseudo_bytes(32));
	$userEmailActivation = bin2hex(openssl_random_pseudo_bytes(8));

	// create the hash
	$userHash = hash_pbkdf2("sha512", $requestObject->password, $userSalt, 262144, 128);

	// create a new User and insert into mySQL
	$user = new User(null, $browser, new DateTime(), $ipAddress, "R", $requestObject->userEmail, $userHash, $requestObject->userName, $userSalt);
	$user->insert($pdo);
	$reply->message = "A new user has been created";

	// create Swift message
	$swiftMessage = Swift_Message::newInstance();

	// attach the sender to the message
	// this takes the form of an associative array where the Email is the key for the real name
	$swiftMessage->setFrom(["trailquailabq@gmail.com" => "Trail Quail"]);

	/**
	 * attach the recipients to the message
	 * notice this is an array that can include or omit the recipient's real name
	 * use the recipient's real name where possible; this reduces the probability of the email being marked as spam
	 */
	$recipients = [$requestObject->userEmail];
	$swiftMessage->setTo($recipients);

	// attach the subject line to the message
	$swiftMessage->setSubject("Please confirm your Trail Quail account");

	/**
	 * attach the actual message to the message
	 * here, we set two versions of the message: the HTML formatted message and a special filter_var()ed
	 * version of the message that generates a plain text version of the HTML content
	 * notice one tactic  used is to display the entire $confirmLink to plain text; this lets users
	 * who aren't viewing HTML content in Emails still access your links
	 */

	// building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
	$lastSlash = strpos($_SERVER["SCRIPT_NAME"], "/");
	$basePath = substr($_SERVER["SCRIPT_NAME"], 0, $lastSlash + 1);
	$urlglue = $basePath . "confirmation.php?emailActivation=" . $userEmailActivation;

	$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
	$message = <<< EOF
<h1>Thank you for registering for Trail Quail!</h1>
<p>Visit the following URL to confirm your email and complete the registration process.</p>
<a href="$confirmLink">$confirmLink</a></p>
EOF;
	$swiftMessage->setBody($message, "text/html");
	$swiftMessage->addPart(html_entity_decode(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)), "text/plain");

	/**
	 * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
	 * this default may or may not be available on all web hosts; consult their documentation/support for details
	 * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling
	 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwiftMailer
	 */
	$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
	$mailer = Swift_Mailer::newInstance($smtp);
	$numSent = $mailer->send($swiftMessage, $failedRecipients);

	/**
	 * the send method returns the number of recipients that accepted the Email
	 * so, if the number attempted is not the number accepted, thpis is an Exception
	 */
	if($numSent !== count($recipients)) {
		// the $failedRecipients parameter passed in the send() method now contains an array of the Emails that failed
		throw(new RuntimeException("unable to send email"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);
