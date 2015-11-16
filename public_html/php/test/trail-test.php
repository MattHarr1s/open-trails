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
class TrailTest extends TrailQuailTest{
	/**
	 * valid trailId to use
	 * @var int $VALID_TRAILID
	 */

	protected $VALID_TRAILID ="5";
	/**
	 * id for the content of the submission of the trail object
	 * @var int $VALID_SUBMITTRAILID
 **/
	protected $VALID_SUBMITTRAILID ="7";

	/**
	 * id of user that submits to the trail
	 * @var int $VALID_USERID
	 **/
	protected $VALID_USERID="2";

	/**
	 * accessibility info for trail
	 * @var string $VALID_TRAILACCESSIBILITY
	 **/
	protected $VALID_TRAILACCESSIBILITY ="Wheelchair";

	/**
	 *information on amenities on trail
	 * @var string $VALID_TRAILAMENITIES
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
	 *@var string $VALID_TRAILTRAFFIC
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
	public function testInsertValidTrail(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->VALID_SUBMITTRAILID,$this->VALID_USERID $this->VALID_TRAILACCESSIBILITY,
	$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
	$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
	$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection() ->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSema($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
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
	 * test inserting a Trail that already exists
	 *
	 * @expectedException PDOException
	**/

	public function testInsertInvalidTrail() {
		//create a profile with a non null trailId and break the system
		$trail = new Trail(TrailQuailTest::INVALID_KEY,$this->VALID_SUBMITTRAILID,$this->VALID_USERID $this->VALID_TRAILACCESSIBILITY,
	$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
	$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
	$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$trail->insert($this->getPDO());
	}

	/**
	 * test inserting a trail, editing it, and then updating it
	**/
	public function testUpdateValidTrail(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail(null, $this->VALID_SUBMITTRAILID,$this->VALID_USERID $this->VALID_TRAILACCESSIBILITY,
	$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
	$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
	$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$trail->insert($this->getPDO());

		//edit the trail and update it in mySQL
		$trail->setTrailName($this->VALID_TRAILNAME2);
		$trail->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailById($this->getPDO(), $trail->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection() ->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSema($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
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
	 * test inserting a valid Trail and verify that the actual mySQL data matches
	 *
	 * grabs the data from mySQL via getTrailByUserId
	 **/
	public function testGetValidTrailByUserId(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID,$this->VALID_USERID $this->VALID_TRAILACCESSIBILITY,
	$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
	$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
	$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);
		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailByUserId($this->getPDO(), $trail->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection() ->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSema($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
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
	 * test inserting a valid Trail and verify that the actual mySQL data matches
	 *
	 * grabs the data from mySQL via getTrailBySubmitTrailId
	 **/
	public function testGetValidTrailBySubmitTrailId(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trail");

		//create a new trail and insert it into mySQL
		$trail = new Trail($this->VALID_TRAILID, $this->VALID_SUBMITTRAILID,$this->VALID_USERID $this->VALID_TRAILACCESSIBILITY,
	$this->VALID_TRAILAMENITIES, $this->VALID_TRAILCONDITIION, $this->VALID_TRAILDESCRIPTION, $this->VALID_TRAILDIFFICULTY,
	$this->VALID_TRAILDISTANCE, $this->VALID_TRAILSUBMISSIONTYPE, $this->VALID_TRAILNAME,
	$this->VALID_TRAILTERRAIN, $this->VALID_TRAILTRAFFIC, $this->VALID_TRAILUSE, $this->VALID_TRAILUUID);

		$trail->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrail = Trail::getTrailBySubmitTrailId($this->getPDO(), $trail->getSubmitTrailId());
		$this->assertSame($numRows + 1, $this->getConnection() ->getRowCount("trail"));
		$this->assertSame($pdoTrail->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrail->getSubmitTrailId(), $this->VALID_SUBMITTRAILID);
		$this->assertSame($pdoTrail->getUserId(), $this->VALID_USERID);
		$this->assertSame($pdoTrail->getTrailAccessibility(), $this->VALID_TRAILACCESSIBILITY);
		$this->assertSame($pdoTrail->getTrailAmenities(), $this->VALID_TRAILAMENITIES);
		$this->assertSame($pdoTrail->getTrailCondition(), $this->VALID_TRAILCONDITIION);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSema($pdoTrail->getTrailDifficulty(), $this->VALID_TRAILDIFFICULTY);
		$this->assertSame($pdoTrail->getTrailDistance(), $this->VALID_TRAILDISTANCE);
		$this->assertSame($pdoTrail->getTrailDescription(), $this->VALID_TRAILDESCRIPTION);
		$this->assertSame($pdoTrail->getTrailSubmissionType(), $this->VALID_TRAILSUBMISSIONTYPE);
		$this->assertSame($pdoTrail->getTrailName(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTerrain(), $this->VALID_TRAILNAME);
		$this->assertSame($pdoTrail->getTrailTraffic(), $this->VALID_TRAILTRAFFIC);
		$this->assertSame($pdoTrail->getTrailUse(), $this->VALID_TRAILUSE);
		$this->assertSame($pdoTrail->getTrailUuId(), $this->VALID_TRAILUUID);
	}

}