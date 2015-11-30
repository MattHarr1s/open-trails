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

//TODO set the page that it logs out to
header("https://bootcamp-coders.cnm.edu");