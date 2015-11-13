<?php
require_once("trail-quail.php");
require_once(dirname(__DIR__) . "/traits/anti-abuse.php");

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

class TraitTest extends TrailQuailTest{

	/**
	 * valid ipAddress to use
	 * @var string $VALID_IP
	 **/
	protected $VALID_IP = "168.176.85.163";

	/**
	 * valid browser to use
	 * @var string $VALID_BROWSER
	 **/
	protected $VALID_BROWSER = "Mozilla Firefox";

	/**
	 * valid createDate to use
	 * @var DateTime $VALID_CREATEDATE
	 **/
	protected $VALID_CREATEDATE = "2012-03-24 17:45:12";

	public function testValidAntiAbuse() {
		$antiAbuse = new AntiAbuse($this->VALID_IP, $this->VALID_BROWSER, $this->VALID_CREATEDATE);
		$antiAbuse->insert($this->getPDO());

		$pdoAntiAbuse = AntiAbuse::getIpAddress($this->getPDO(), $antiAbuse->getIpAddress());
		$this->assertSame($pdoAntiAbuse->getIpAddress(), $this->VALID_IP);
		$this->assertSame($pdoAntiAbuse->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoAntiAbuse->getCreateDate(), $this->VALID_CREATEDATE);
	}

	public function testInvalidAntiAbuse() {
		$antiAbuse = new AntiAbuse($th
	}
}