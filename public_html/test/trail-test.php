<?php

require_once "trail-quail.php";
require_once(dirname(__DIR__). "/php/classes/trail.php");
require_once(dirname(__DIR__). "/php/classes/autoload.php");
require_once(dirname(dirname(__DIR__)) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
use PascalDeVink\ShortUuid\ShortUuid;

/**
 *
 * Full PHPUnit test for the Trail class
 *
 * This is a complete PHPunit test of the Trail class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Trail
 * @author Matt Harris <mattharr505@gmail.com> and Trail Quail <trailquailabq@gmail.com>
**/
class TrailTest extends TrailQuailTest {

	/**
	 * placeholder to prevent regression
	 * @var null
	 **/
	protected $VALID_SUBMITTRAILID = null;

	/**
	 * Browser type of user making submission
	 * @var string $VALID_BROWSER
	 **/
	protected $VALID_BROWSER = "";

	/**
	 * valid create dates to use for unit testing
	 * @var DATETIME $VALID_CREATEDATE
	 * @var DATETIME $VALID_CREATEDATE1
	 * @var DATETIME $VALID_CREATEDATE2
	 */
	protected $VALID_CREATEDATE = "2015-12-19 12:15:18";
	protected $VALID_CREATEDATE1 = "2015-12-19 12:16:20";
	protected $VALID_CREATEDATE2 = "2015-12-19 12:19:20";

	/**
	 * ipAddress of computer making submission
	 * @var string $VALID_IPADDRESS
	 **/

	protected $VALID_IPADDRESS = "192.168.1.4";


	/**
	 *information on amenities on trail
	 * @var string $VALID_TrailDescription
	 */
	protected $VALID_TRAILAMENITIES = "Picnic area";
	/**
	 * information on the trail condition
	 * @var string $VALID_TRAILCONDITION
	 **/
	protected $VALID_TRAILCONDITIION = "Good";

	/**
	 * information describing the trail
	 * @var string $VALID_TRAILDESCRIPTION
	 **/
	protected $VALID_TRAILDESCRIPTION = "This trail is a beautiful winding trail located in the Sandia Mountains";

	/**
	 * difficulty rating of trail
	 * @var int $VALID_TRAILDIFFICULTY
	 **/
	protected $VALID_TRAILDIFFICULTY = 3;

	/**
	 * length of the trail
	 * @var float $VALID_TRAILDISTANCE
	 **/
	protected $VALID_TRAILDISTANCE = 1054.52;

	/**
	 * type of submission made to trail
	 * @var int $VALID_TRAILSUBMISSIONTYPE
	 **/
	protected $VALID_TRAILSUBMISSIONTYPE = 2;

	/**
	 * type of terrain on the trail
	 * @var string $VALID_TRAILTERRAIN
	 **/
	protected $VALID_TRAILTERRAIN = "Mostly switchbacks with a few sections of rock fall";

	/**
	 * name of trail
	 * @var string $VALID_TRAILNAME
	 **/
	protected $VALID_TRAILNAME = "La Luz";

	/**
	 * alternate name of trail
	 * @var string $VALID_TRAILNAME2
	 **/
	protected $VALID_TRAILNAME2 = "Ho Chi Minh";

	/**
	 *amount of traffic on trail
	 * @var string $VALID_TRAILTRAFFIC
	**/
	protected $VALID_TRAILTRAFFIC = "Heavy";

	/**
	 * main use of the trail (hiking, cycling, skiing)
	 * @var string $VALID_TRAILUSE
	**/
	protected $VALID_TRAILUSE = "Hiking";

	/**
	 * id for the submission on the trail object. Exists so the primary key does not have to get updated.
	 * @var string $VALID_TRAILUUID
	**/
	protected $VALID_TRAILUUID = null;

	/**
	 * @var string $VALID_USERHASH
	 */
	protected $VALID_USERHASH = "";

	/**
	 * @var string $VALID_USERSALT
	 */
	protected $VALID_USERSALT = "";

	/**
	 * id for the user
	 * @var User $userId
	**/
	protected $user = null;

	/**
	 * create dependent objects before running each test
	 *
	 */
	public function setUp(){
		//run the default setUp() method first
		parent::setUp();

		$this->VALID_TRAILUUID = ShortUuid::uuid4();
//		var_dump($this->VALID_TRAILUUID);

		//create and insert a datetime object
		$this->VALID_CREATEDATE = DateTime::createFromFormat("Y-m-d H:i:s", $this->VALID_CREATEDATE);

		//create browser
		$this->VALID_BROWSER ="Safari";

		$this->VALID_USERSALT = bin2hex(openssl_random_pseudo_bytes(32));
		$this->VALID_USERHASH = $this->VALID_USERHASH = hash_pbkdf2("sha512", "password4321", $this->VALID_USERSALT, 262144, 128);

		//create and insert a userId to own the trail
		$this->user = new User(null, $this->VALID_BROWSER, $this->VALID_CREATEDATE, "192.168.1.168", "S", "louisgill6@gmail.com", $this->VALID_USERHASH, "Hyourname.tomorrow", $this->VALID_USERSALT);
		$this->user->insert($this->getPDO());
	}

	protected function longUuidToShortUuid($longUuid) {
		$uuid = Uuid::fromString($longUuid);
		$shortUuid = new ShortUuid();
		return((string)$shortUuid->encode($uuid));
	}

	/**
	 * test inserting a valid Trail and verify that the actual mySQL data matches
	 *
	 * grabs the data from mySQL via getTrailByTrailId
	 **/
	public function testInsertValidTrail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrails = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
		foreach($pdoTrails as $pdoTrail) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertLessThan($pdoTrail->getTrailId(),0);
			$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
		}
	}

	/**
	 * test inserting a Trail that already exists
	 *
	 * @expectedException InvalidArgumentException
	 **/

	public function testInsertInvalidTrail() {
		//create a profile with a non null trailId and break the system
		$trail = new Trail(TrailQuailTest::INVALID_KEY, $this->VALID_SUBMITTRAILID, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$trail->insert($this->getPDO());
	}

	/**
	 * test inserting a trail, editing it, and then updating it
	 **/
	public function testUpdateValidTrail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$trail->insert($this->getPDO());

		//edit the trail and update it in mySQL
		$trail->setTrailName($this->VALID_TRAILNAME2);
		$trail->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertLessThan($pdoTrail->getTrailId(),0);
		$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME2);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
	}

	/**
	 * test updating a Trail that does not exist
	 *
	 * @expectedException InvalidArgumentException
	 **/

	public function testUpdateInvalidTrail() {
		//create a profile with a non null trailId and break the system
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, null, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$trail->update($this->getPDO());
	}

	/**
	 * test creating a Trail and then deleting it
	 *
	 **/
	public function testDeleteValidTrail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$trail->insert($this->getPDO());

		//delete the trail from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$trail->delete($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
		$this->assertNull($pdoTrail);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("trail"));
	}

	/**
	 * test deleting a Trail that does not exist
	 * @expectedException InvalidArgumentException
	 **/

	public function testDeleteInvalidTrail() {
		//create a profile with a non null trailId and break the system
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, null, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$trail->delete($this->getPDO());
	}

	/**
	 * test grabbing a trail by userId
	 **/
	public function testGetValidTrailByUserId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");


		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrails = Trail::getTrailByUserId($this->getPDO(), $trail->getUserId());
		foreach($pdoTrails as $pdoTrail) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertLessThan($pdoTrail->getTrailId(),0);
			$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
		}
	}

	/**
	 * test grabbing a Trail by userId that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidTrailByUserId() {
		//grab a userId that does not exist
		$trail = Trail::getTrailByUserId($this->getPDO(), "null");
		$this->assertNull($trail);
	}

	/**
	 * test grabbing a trail by submitTrailId
	 **/
	public function testGetValidTrailBySubmitTrailId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, null, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, null);
		$trail->insert($this->getPDO());
		$submitTrail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $trail->getTrailId(), $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$submitTrail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrails = Trail::getTrailBySubmitTrailId($this->getPDO(), $submitTrail->getSubmitTrailId());
		foreach($pdoTrails as $pdoTrail) {
			$this->assertSame($numRows + 2, $this->getConnection()->getRowCount("trail"));
			$this->assertLessThan($pdoTrail->getTrailId(),0);
			$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $submitTrail->getSubmitTrailId());
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
		}

		// clean up to prevent PHPUnit from fucking up
		$submitTrail->delete($this->getPDO());
		$trail->delete($this->getPDO());
	}


	/**
	 * test grabbing a Trail by submitTrailId that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidTrailBySubmitTrailId() {
		//grab a trail that does not exist
		$trail = Trail::getTrailBySubmitTrailId($this->getPDO(), "null");
		$this->assertNull($trail);
	}

	/**
	 * test grabbing a trail by TrailAccessibility
	 **/
	public function testGetValidAllTrails() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrails = Trail::getAllTrails($this->getPDO());
		foreach($pdoTrails as $pdoTrail) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertLessThan($pdoTrail->getTrailId(),0);
			$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
		}
	}


	/**
	 * test grabbing all trails that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidAllTrails() {
		//grab a TrailAccessibility that does not exist
		$trail = Trail::getAllTrails($this->getPDO(), "<script></script>");
		$this->assertNull($trail);
	}

	/**
	 * test grabbing a trail by TrailAmenities
	 **/
	public function testGetValidTrailByTrailAmenities() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrails = Trail::getTrailByTrailAmenities($this->getPDO(), $trail->getTrailAmenities());
		foreach($pdoTrails as $pdoTrail) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertLessThan($pdoTrail->getTrailId(),0);
			$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
		}
	}

	/**
	 * test grabbing a Trail by TrailAmenities that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidTrailByTrailAmenities() {
		//grab a TrailAmenities that does not exist
		$trail = Trail::getTrailByTrailAmenities($this->getPDO(), "<script></script>");
		$this->assertNull($trail);
	}

	/**
	 * test grabbing a trail by TrailCondition
	 **/
	public function testGetValidTrailByTrailCondition() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrails = Trail::getTrailByTrailCondition($this->getPDO(), $trail->getTrailCondition());
		foreach($pdoTrails as $pdoTrail) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertLessThan($pdoTrail->getTrailId(),0);
			$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
		}
	}

	/**
	 * test grabbing a Trail by TrailCondition that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidTrailByTrailCondition() {
		//grab a TrailCondition that does not exist
		$trail = Trail::getTrailByTrailCondition($this->getPDO(), "<script></script>");
		$this->assertNull($trail);
	}

	/**
	 * test grabbing a trail by TrailDescription
	 **/
	public function testGetValidTrailByTrailDescription() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
				$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrails = Trail::getTrailByTrailDescription($this->getPDO(), $trail->getTrailDescription());
		foreach($pdoTrails as $pdoTrail) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertLessThan($pdoTrail->getTrailId(),0);
			$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
		}
	}

		/**
		 * test grabbing a Trail by TrailDescription that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailDescription() {
			//grab a TrailDescription that does not exist
			$trail = Trail::getTrailByTrailDescription($this->getPDO(), "<script></script>");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailDifficulty
		 **/
		public function testGetValidTrailByTrailDifficulty() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
					$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrails = Trail::getTrailByTrailDifficulty($this->getPDO(), $trail->getTrailDifficulty());
			foreach($pdoTrails as $pdoTrail) {
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
				$this->assertLessThan($pdoTrail->getTrailId(),0);
				$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
				$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
				$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
				$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
				$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
				$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
				$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
				$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
				$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
				$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
				$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
			}
		}

		/**
		 * test grabbing a Trail by TrailDifficulty that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public function testGetInvalidTrailByTrailDifficulty() {
			//grab a TrailDifficulty that does not exist
			$trail = Trail::getTrailByTrailDifficulty($this->getPDO(), "");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailDistance
		 **/
		public function testGetValidTrailByTrailDistance() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
					$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrails = Trail::getTrailByTrailDistance($this->getPDO(), $trail->getTrailDistance());
			foreach($pdoTrails as $pdoTrail) {
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
				$this->assertLessThan($pdoTrail->getTrailId(), 0);
				$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
				$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
				$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
				$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
				$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
				$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
				$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
				$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
				$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
				$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
				$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
			}
		}

		/**
		 * test grabbing a Trail by TrailDistance that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public function testGetInvalidTrailByTrailDistance() {
			//grab a TrailDistance that does not exist
			$trail = Trail::getTrailByTrailDistance($this->getPDO(), "null");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailSubmissionType
		 **/
		public
		function testGetValidTrailByTrailSubmissionType() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
					$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrails = Trail::getTrailByTrailSubmissionType($this->getPDO(), $trail->getTrailSubmissionType());
			foreach($pdoTrails as $pdoTrail) {
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
				$this->assertLessThan($pdoTrail->getTrailId(),0);
				$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
				$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
				$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
				$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
				$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
				$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
				$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
				$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
				$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
				$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
				$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
			}
		}

		/**
		 * test grabbing a Trail by TrailSubmissionType that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailSubmissionType() {
			//grab a TrailSubmissionType that does not exist
			$trail = Trail::getTrailByTrailSubmissionType($this->getPDO(), "null");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailTerrain
		 **/
		public
		function testGetValidTrailByTrailTerrain() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
					$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrails = Trail::getTrailByTrailTerrain($this->getPDO(), $trail->getTrailTerrain());
			foreach($pdoTrails as $pdoTrail) {
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
				$this->assertLessThan($pdoTrail->getTrailId(),0);
				$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
				$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
				$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
				$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
				$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
				$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
				$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
				$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
				$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
				$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
				$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
			}
		}

		/**
		 * test grabbing a Trail by TrailTerrain that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailTerrain() {
			//grab a TrailTerrain that does not exist
			$trail = Trail::getTrailByTrailTerrain($this->getPDO(), "<script></script>");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailName
		 **/
		public
		function testGetValidTrailByTrailName() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
					$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrails = Trail::getTrailByTrailName($this->getPDO(), $trail->getTrailName());
			foreach($pdoTrails as $pdoTrail) {
				$this->assertLessThan($pdoTrail->getTrailId(),0);
				$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
				$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
				$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
				$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
				$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
				$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
				$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
				$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
				$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
				$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
				$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
			}
		}

		/**
		 * test grabbing a Trail by TrailName that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailName() {
			//grab a TrailName that does not exist
			$trail = Trail::getTrailByTrailName($this->getPDO(), "<script></script>");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailTraffic
		 **/
		public function testGetValidTrailByTrailTraffic() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
					$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrails = Trail::getTrailByTrailTraffic($this->getPDO(), $trail->getTrailTraffic());
			foreach($pdoTrails as $pdoTrail) {
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
				$this->assertLessThan($pdoTrail->getTrailId(),0);
				$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
				$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
				$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
				$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
				$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
				$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
				$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
				$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
				$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
				$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
				$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
			}
		}

		/**
		 * test grabbing a Trail by TrailTraffic that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailTraffic() {
			//grab a TrailTraffic that does not exist
			$trail = Trail::getTrailByTrailTraffic($this->getPDO(), "<script></script>");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailUse
		 **/
		public
		function testGetValidTrailByTrailUse() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
					$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrails = Trail::getTrailByTrailUse($this->getPDO(), $trail->getTrailUse());
			foreach($pdoTrails as $pdoTrail) {
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
				$this->assertLessThan($pdoTrail->getTrailId(),0);
				$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
				$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
				$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
				$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
				$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
				$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
				$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
				$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
				$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
				$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
				$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
			}
		}

		/**
		 * test grabbing a Trail by TrailUse that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailUse() {
			//grab a TrailUse that does not exist
			$trail = Trail::getTrailByTrailUse($this->getPDO(), "<script></script>");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailUuId
		 **/
		public
		function testGetValidTrailByTrailUuId() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			$trail = new Trail(null, $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_SUBMITTRAILID, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILNAME, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC,
					$this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrails = Trail::getTrailByTrailUuId($this->getPDO(), $trail->getTrailUuId());
			foreach($pdoTrails as $pdoTrail) {
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
				$this->assertLessThan($pdoTrail->getTrailId(),0);
				$this->assertSame($pdoTrail->getUserId(), $this->user->getUserId());
				$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
				$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
				$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
				$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
				$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
				$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
				$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
				$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
				$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
				$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
				$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
				$this->assertSame($this->longUuidToShortUuid($pdoTrail->getTrailUuId()), $this->VALID_TRAILUUID);
			}
		}

		/**
		 * test grabbing a Trail by TrailUuId that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailUuId() {
			//grab a TrailUuId that does not exist
			$trail = Trail::getTrailByTrailUuId($this->getPDO(), "<script></script>");
			$this->assertNull($trail);
		}


}











