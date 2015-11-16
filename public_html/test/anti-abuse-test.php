<?php
require_once(dirname(__DIR__) . "/php/traits/anti-abuse.php");

/**
 * Full PHPUnit test for the AntiAbuse trait
 *
 * It tests for both valid and invalid cases of the AntiAbuse trait
 *
 * @see AntiAbuse
 * @author Louis Gill <lgill7@cnm.edu>
 **/
class UseTheTrait {
	use AntiAbuse;
}

class TraitTest extends PHPUnit_Framework_TestCase {

	/**
	 * valid ipAddress to use
	 * @var string $VALID_IP
	 **/
	protected $VALID_IP = "168.176.85.163";

	/**
	 * invalid ipAddress to use
	 * @var string $INVALID_IP
	 **/
	protected $INVALID_IP = "168.176.85.396";

	/**
	 * valid browser to use
	 * @var string $VALID_BROWSER
	 **/
	protected $VALID_BROWSER = "Mozilla Firefox";

	/**
	 * invalid browser to use
	 * @var string $INVALID_BROWSER
	 **/
	protected $INVALID_BROWSER = "Internet Explorer 7";

	/**
	 * valid createDate to use
	 * @var DateTime $VALID_CREATEDATE
	 **/
	protected $VALID_CREATEDATE = "2012-03-24 17:45:12";

	public function testValidAntiAbuse() {
		$useTheTrait = new UseTheTrait();

		// use the three mutators to make a valid test case
		$useTheTrait->setIpAddress($this->VALID_IP);
		$useTheTrait->setBrowser($this->VALID_BROWSER);
		$useTheTrait->setCreateDate($this->VALID_CREATEDATE);

		// assertSame() that getFoo() is the same as $VALID_FOO
		$this->assertSame($useTheTrait->getIpAddress(), $this->VALID_IP);
		$this->assertSame($useTheTrait->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($useTheTrait->getCreateDate(), $this->VALID_CREATEDATE);
	}

	public function testInvalidAntiAbuse() {
		$useTheTrait = new UseTheTrait();

		// simply use the $INVALID_IP and an exception will be thrown
		$useTheTrait->setIpAddress($this->INVALID_IP);
	}
}