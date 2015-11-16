<?php
require_once("trail-quail.php");
require_once(dirname(__DIR__). "/php/classes/autoload.php");

/**
 *
 * Full PHPUnit test for the User class
 *
 * This is a complete PHPUnit test of the User class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see user.php in the classes directory
 * @author Jeff Saul <scaleup13@gmail.com> and Trail Quail <trailquailabq@gmail.com>
 **/
class UserTest extends TrailQuailTest {
	/**
	 * valid user Id to use
	 * @var int $VALID_USERID
	 */
	protected $VALID_USERID = "27";

		/**
		 * valid user Browser type to use
		 * @var string $VALID_BROWSER
		 */
	protected $VALID_BROWSER = "Chrome";

	/**
	 * valid user account creation date to use
	 * @var datetime $VALID_CREATEDATE
	 */
	protected $VALID_CREATEDATE = "2015-11-15 09:45:30";

	/**
	 * valid user IP address to use
	 * @var string $VALID_IPADDRESS
	 */
	protected $VALID_IPADDRESS = "192.168.1.168";

	/**valid user account type to use
	 * @var string $VALID_USERACCOUNTTYPE
	 */
	protected $VALID_USERACCOUNTTYPE = "S";

	/**valid user email to use
	 * @var string $VALID_EMAIL
	 */
	protected $VALID_USEREMAIL= "saul.jeff@gmail.com";

	/**valid user hash to use
	 * @var string $VALID_USERHASH
	 */
	protected $VALID_USERHASH= "saul.jeff@gmail.com";