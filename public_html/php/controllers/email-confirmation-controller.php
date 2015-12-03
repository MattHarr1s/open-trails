<?php
/**
 * controller for sending a confirmation email to a new user
 *
 * @author Louis Gill <lgill7@cnm.edu>
 * contributor code from https://github.com/skylarity/trufork
 */

//auto loads classes
require_once(dirname(dirname(__DIR__)) . "/php/classes/autoload.php");
//security w/ NG in mind
require_once(dirname(__DIR__) . "/lib/xsrf.php");
// a security file that's on the server created by Dylan because it's on the server it's not found	// ???????????
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
// composer for Swiftmailer
require_once(dirname(dirname(__DIR__))) . "/vendor/autoload.php";

//prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->message = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/open-trails.ini");

	//do I need to pull the JSON data here? If not how do I pull the data?

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