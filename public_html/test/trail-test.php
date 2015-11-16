<?php
require_once("trail.php");
require_once(dirname(__DIR__). "/classes/trail.php");

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
	 * valid trailId to use
	 * @var int $VALID_TRAILID
	 */

	protected $VALID_TRAILID = "5";
	/**
	 * id for the content of the submission of the trail object
	 * @var int $VALID_SUBMITTRAILID
	 **/
	protected $VALID_SUBMITTRAILID = "7";

	/**
	 * id of user that submits to the trail
	 * @var int $VALID_USERID
	 **/
	protected $VALID_USERID = "2";

	/**
	 * Browser type of user making submission
	 * @var string $VALID_BROWSER
	 **/
	protected $VALID_BROWSER = "Safari";

	/**
	 * createDate of submission to trail
	 * @var $VALID_CREATEDATE
	 **/
	protected $VALID_CREATEDATE = "2015-11-15 12:15:42";

	/**
	 * ipAddress of computer making submission
	 * @var string $VALID_IPADDRESS
	 **/

	protected $VALID_IPADDRESS = "192.168.1.4";


	/**
	 * accessibility info for trail
	 * @var string $VALID_TRAILACCESSIBILITY
	 **/
	protected $VALID_TRAILACCESSIBILITY = "y";

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
	protected $VALID_TRAILDIFFICULTY = "3";

	/**
	 * length of the trail
	 * @var int $VALID_TRAILDISTANCE
	 **/
	protected $VALID_TRAILDISTANCE = "1000";

	/**
	 * type of submission made to trail
	 * @var int $VALID_TRAILSUBMISSIONTYPE
	 **/
	protected $VALID_TRAILSUBMISSIONTYPE = "2";

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
	protected $VALID_TRAILUUID = "SSEERFFV4444554";

	/**
	 * test inserting a valid Trail and verify that the actual mySQL data matches
	 *
	 * grabs the data from mySQL via getTrailByTrailId
	 **/
	public function testInsertValidTrail() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
	}

	/**
	 * test inserting a Trail that already exists
	 *
	 * @expectedException PDOException
	 **/

	public function testInsertInvalidTrail() {
		//create a profile with a non null trailId and break the system
		$trail = new Trail(TrailQuailTest::INVALID_KEY, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
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
		$trail = new Trail(null, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		//edit the trail and update it in mySQL
		$trail->setTrailName($this->VALID_TRAILNAME2);
		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME2);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
	}

	/**
	 * test updating a Trail that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testUpdateInvalidTrail() {
		//create a profile with a non null trailId and break the system
		$trail = new Trail(TrailQuailTest::INVALID_KEY, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
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
		$trail = new Trail(null, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
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
	 *
	 * @expectedException PDOException
	 **/

	public function testDeleteInvalidTrail() {
		//create a profile with a non null trailId and break the system
		$trail = new Trail(TrailQuailTest::INVALID_KEY, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
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
		//create a new trail and insert it into mySQL
		$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByUserId($this->getPDO(), $trail->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
		//create a new trail and insert it into mySQL
		$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailBySubmitTrailId($this->getPDO(), $trail->getSubmitTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
	}

	/**
	 * test grabbing a Trail by submitTrailId that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidTrailBySubmitTrailId() {
		//grab a userId that does not exist
		$trail = Trail::getTrailBySubmitTrailId($this->getPDO(), "null");
		$this->assertNull($trail);
	}

	/**
	 * test grabbing a trail by TrailAccessibility
	 **/
	public function testGetValidTrailByTrailAccessibility() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		//create a new trail and insert it into mySQL
		$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailAccessibility($this->getPDO(), $trail->getTrailAccessibility());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
	}

	/**
	 * test grabbing a Trail by TrailAccessibility that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidTrailByTrailAccessibility() {
		//grab a TrailAccessibility that does not exist
		$trail = Trail::getTrailByTrailAccessibility($this->getPDO(), "<script></script>");
		$this->assertNull($trail);
	}

	/**
	 * test grabbing a trail by TrailAmenities
	 **/
	public function testGetValidTrailByTrailAmenities() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		//create a new trail and insert it into mySQL
		$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailAmenities($this->getPDO(), $trail->getTrailAmenities());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
		//create a new trail and insert it into mySQL
		$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailCondition($this->getPDO(), $trail->getTrailCondition());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
		//create a new trail and insert it into mySQL
		$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
				$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
				$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
				$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByTrailDescription($this->getPDO(), $trail->getTrailDescription());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
		public
		function testGetValidTrailByTrailDifficulty() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailByTrailDifficulty($this->getPDO(), $trail->getTrailDifficulty());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
		}

		/**
		 * test grabbing a Trail by TrailDifficulty that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailDifficulty() {
			//grab a TrailDifficulty that does not exist
			$trail = Trail::getTrailByTrailDifficulty($this->getPDO(), "");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by TrailDistance
		 **/
		public
		function testGetValidTrailByTrailDistance() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailByTrailDistance($this->getPDO(), $trail->getTrailTrailDistance());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
		}

		/**
		 * test grabbing a Trail by TrailDistance that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByTrailDistance() {
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
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailByTrailSubmissionType($this->getPDO(), $trail->getTrailTrailSubmissionType());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailByTrailTerrain($this->getPDO(), $trail->getTrailTerrain());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailByName($this->getPDO(), $trail->getTrailName());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
		public
		function testGetValidTrailByTrailTraffic() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailByTrailTraffic($this->getPDO(), $trail->getTrailTraffic());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailByTrailUse($this->getPDO(), $trail->getTrailUse());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailByTrailUuId($this->getPDO(), $trail->getTrailUuId());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
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

		/**
		 * test grabbing a trail by Browser
		 **/
		public
		function testGetValidTrailByBrowser() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
		}

		/**
		 * test grabbing a Trail by Browser that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByBrowser() {
			//grab a Browser that does not exist
			$trail = Trail::getTrailByBrowser($this->getPDO(), "<script></script>");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by CreateDate
		 **/
		public
		function testGetValidTrailByCreateDate() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
		}

		/**
		 * test grabbing a Trail by CreateDate that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByCreateDate() {
			//grab a CreateDate that does not exist
			$trail = Trail::getTrailByCreateDate($this->getPDO(), "null");
			$this->assertNull($trail);
		}

		/**
		 * test grabbing a trail by IpAddress
		 **/
		public
		function testGetValidTrailByIpAddress() {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("trail");

			//create a new trail and insert it into mySQL
			//create a new trail and insert it into mySQL
			$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID, $this->VALID_USERID, $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_TRAILACCESSIBILITY,
					$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
					$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
					$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

			$trail->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
			$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trail"));
			$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
			$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
			$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
			$this->assertSame($pdoTrail->getBrowser(), $this->VALID_BROWSER);
			$this->assertSame($pdoTrail->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoTrail->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
			$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
			$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
			$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
			$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
			$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
			$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
			$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILTERRAIN);
			$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
			$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
			$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
		}

		/**
		 * test grabbing a Trail by IpAddress that does not exist
		 *
		 * @expectedException PDOException
		 **/

		public
		function testGetInvalidTrailByIpAddress() {
			//grab a IpAddress that does not exist
			$trail = Trail::getTrailByIpAddress($this->getPDO(), "null");
			$this->assertNull($trail);
		}
}











