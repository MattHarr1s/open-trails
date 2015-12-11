<?php
/**
 * controller for logging out
 *
 * @author Louis Gill <lgill7@cnm.edu>
 * contributing code from TruFork https://github.com/Skylarity/trufork







 */

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
unset($_SESSION["user"]);

$reply = new stdClass();
$reply->status = 200;
$reply->message = "You have successfully logged out";

header("Content-type: application/json");
echo json_encode($reply);