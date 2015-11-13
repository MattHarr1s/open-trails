<?php
require_once("trail-quail.php");
require_once(dirname(__DIR__) . "/classes/trail-relationship.php");

/**
 * Full PHPUnit test for the TrailRelationship class
 *
 * This is a complete PHPUnit test of the TrailRelationship class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see TrailRelationship
 * @author Louis Gill <lgill7@cnm.edu>
 **/
class TrailRelationshipTest extends TrailQuailTest {
	/**
	 * valid trailId to use
	 * @var int $VALID_TRAILID
	 **/
	protected $VALID_TRAILID = "5";

	/**
	 * second valid trailId to use
	 * @var int $VALID_TRAILID2
	 **/
	protected $VALID_TRAILID2 = "31";

	/**
	 * valid segmentId to use
	 * @var int $VALID_SEGMENTID
	 **/
	protected $VALID_SEGMENTID = "1";

	/**
	 * second valid segmentId to use
	 * @var int $VALID_SEGMENTID2
	 **/
	protected $VALID_SEGMENTID2 = "2";

	/**
	 * valid segmentType to use
	 * @var string $VALID_SEGMENTTYPE
	 **/
	protected $VALID_SEGMENTTYPE = "H";

	/**
	 * valid segmentType to use
	 * @var string $VALID_SEGMENTTYPE2
	 **/
	protected $VALID_SEGMENTTYPE2 = "S";

	/**
	 * test inserting a valid Trail Relationship and verify that the actual mySQL data matches
	 *
	 * grabs the data from mySQL via getTrailRelationshipByTrailId
	 **/
	public function testGetValidTrailRelationshipByTrailId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipByTrailId($this->getPDO(), $trailRelationship->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE);
	}

	/**
	 * test inserting a valid Trail Relationship and verify that the actual mySQL data matches
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentId
	 **/
	public function testGetValidTrailRelationshipBySegmentId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentId($this->getPDO(), $trailRelationship->getSegmentId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE);
	}

	/**
	 * test inserting a valid Trail Relationship and verify that the actual mySQL data matches
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentIdAndTrailId
	 **/
	public function testGetValidTrailRelationshipBySegmentIdAndTrailId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentIdAndTrailId($this->getPDO(), $trailRelationship->getSegmentId(), $trailRelationship->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE);
	}

	/**
	 * test inserting a Trail Relationship that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidTrailRelationship() {
		// create a Trail Relationship with a non-null trailId and watch it fail
		$trailRelationship = new TrailRelationship($this->VALID_TRAILID, TrailQuailTest::INVALID_KEY, $this->VALID_SEGMENTID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());
	}

	/**
	 * test inserting a Trail Relationship, editing it, and then updating it
	 *
	 * grabs the data from mySQL via getTrailRelationshipByTrailId
	 **/
	public function testUpdateValidTrailRelationshipByTrailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// edit the Trail Relationship and update it in mySQL
		$trailRelationship->setSegmentType($this->VALID_SEGMENTTYPE2);
		$trailRelationship->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipByTrailId($this->getPDO(), $trailRelationship->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE2);
	}

	/**
	 * test inserting a Trail Relationship, editing it, and then updating it
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentId
	 **/
	public function testUpdateValidTrailRelationshipBySegmentId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// edit the Trail Relationship and update it in mySQL
		$trailRelationship->setSegmentType($this->VALID_SEGMENTTYPE2);
		$trailRelationship->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentId($this->getPDO(), $trailRelationship->getSegmentId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE2);
	}

	/**
	 * test inserting a Trail Relationship, editing it, and then updating it
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentIdAndTrailId
	 **/
	public function testUpdateValidTrailRelationshipBySegmentIdAndTrailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// edit the Trail Relationship and update it in mySQL
		$trailRelationship->setSegmentType($this->VALID_SEGMENTTYPE2);
		$trailRelationship->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentIdAndTrailId($this->getPDO(), $trailRelationship->getSegmentId(), $trailRelationship->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE2);
	}

	/**
	 *test updating a Trail Relationship that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidTrailRelationship() {
		// create a Trail Relationship and try to update it without actually inserting it
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTTYPE);
		$trailRelationship->update($this->getPDO());
	}

	/**
	 * test creating a Trail Relationship and then deleting it
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentId
	 **/
	public function testDeleteValidTrailRelationshipBySegmentId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		// create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// delete the Trail Relationship from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$profile->delete($this->getPDO());

		//grab the data from my mySQL and enforce the Trail Relationship does not exist
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentId($this->getPDO(), $trailRelationship->getSegmentId());
		$this->assertNull($pdoTrailRelationship);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("trailRelationship"));
	}

	/**
	 * test creating a Trail Relationship and then deleting it
	 *
	 * grabs the data from mySQL via getTrailRelationshipByTrailId
	 **/
	public function testDeleteValidTrailRelationshipByTrailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		// create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// delete the Trail Relationship from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$profile->delete($this->getPDO());

		//grab the data from my mySQL and enforce the Trail Relationship does not exist
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipByTrailId($this->getPDO(), $trailRelationship->getTrailId());
		$this->assertNull($pdoTrailRelationship);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("trailRelationship"));
	}

	/**
	 * test creating a Trail Relationship and then deleting it
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentIdAndTrailId
	 **/
	public function testDeleteValidTrailRelationshipBySegmentIdAndTrailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		// create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// delete the Trail Relationship from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$profile->delete($this->getPDO());

		//grab the data from my mySQL and enforce the Trail Relationship does not exist
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentIdAndTrailId($this->getPDO(), $trailRelationship->getSegmentId(), $trailRelationship->getTrailId());
		$this->assertNull($pdoTrailRelationship);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("trailRelationship"));
	}

	/**
	 * test deleting a Trail Relationship that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidTrailRelationship() {
		// create a Trail Relationship and try to delete it without actually inserting it
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->delete($this->getPDO());
	}

	/**
	 * test grabbing a Trail Relationship that does not exist
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentId
	 **/
	public function testGetInvalidTrailRelationshipBySegmentId() {
		//grab a segmentId that exceeds the maximum allowable segmentId
		$trailRelationship = TrailRelationship::getTrailRelationshipBySegmentId($this->getPDO(), TrailQuailTest::INVALID_KEY);
		$this->assertNull($trailRelationship);
	}

	/**
	 * test grabbing a Trail Relationship that does not exist
	 *
	 * grabs the data from mySQL via getTrailRelationshipByTrailId
	 **/
	public function testGetInvalidTrailRelationshipByTrailId() {
		//grab a trailId that exceeds the maximum allowable trailId
		$trailRelationship = TrailRelationship::getTrailRelationshipByTrailId($this->getPDO(), TrailQuailTest::INVALID_KEY);
		$this->assertNull($trailRelationship);
	}

	/**
	 * test grabbing a Trail Relationship that does not exist
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentIdAndTrailId
	 **/
	public function testGetInvalidTrailRelationshipBySegmentIdAndTrailId() {
		//grab a segmentId that exceeds the maximum allowable segmentId
		$trailRelationship = TrailRelationship::getTrailRelationshipBySegmentIdAndTrailId($this->getPDO(), TrailQuailTest::INVALID_KEY, TrailQuailTest::INVALID_KEY);
		$this->assertNull($trailRelationship);
	}

	/**
	 * test grabbing a Trail Relationship that does not exist
	 *
	 * grabs the data from mySQL via getTrailRelationshipBySegmentType
	 **/
	public function testGetInvalidTrailRelationshipBySegmentType() {
		//grab a segmentType that exceeds the maximum allowable segmentType
		$trailRelationship = TrailRelationship::getTrailRelationshipBySegmentType($this->getPDO(), "Q");
		$this->assertNull($trailRelationship);
	}

	/**
 * test grabbing a Trail Relationship by segmentId
 **/
	public function testGetValidTrailRelationshipBySegmentId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentId($this->getPDO(), $this->VALID_SEGMENTID);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE);
	}

	/**
	 * test grabbing a Trail Relationship by trailId
	 **/
	public function testGetValidTrailRelationshipByTrailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipByTrailId($this->getPDO(), $this->VALID_TRAILID);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE);
	}

	/**
	 * test grabbing a Trail Relationship by segmentIdAndTrailId
	 **/
	public function testGetValidTrailRelationshipBySegmentIdAndTrailId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentIdAndTrailId($this->getPDO(), $this->VALID_SEGMENTID, $this->VALID_TRAILID);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE);
	}

	/**
	 * test grabbing a Trail Relationship by segmentType
	 **/
	public function testGetValidTrailRelationshipBySegmentType() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_SEGMENTID, $this->VALID_TRAILID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBySegmentId($this->getPDO(), $this->VALID_SEGMENTTYPE);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("trailRelationship"));
		$this->assertSame($pdoTrailRelationship->getSegmentId(), $this->VALID_SEGMENTID);
		$this->assertSame($pdoTrailRelationship->getTrailId(), $this->VALID_TRAILID);
		$this->assertSame($pdoTrailRelationship->getSegmentType(), $this->VALID_SEGMENTTYPE);
	}
}