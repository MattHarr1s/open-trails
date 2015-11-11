<?php
require_once("trail-quail.php");
require_once(dirname(__DIR__) . "/classes/trail-relationship.php");

/**
 * Full PHPUnit test for the TrailRelationship class
 *
 * This is a complete PHPUnit test of the TrailRelationship class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Profile
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
	 **/
	public function testInsertValidTrailRelationship() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("trailRelationship");

		//create a new Trail Relationship and insert it into mySQL
		$trailRelationship = new TrailRelationship($this->VALID_TRAILID, $this->VALID_SEGMENTID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoTrailRelationship = TrailRelationship::getTrailRelationshipBy ?????
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
		$trailRelationship = new TrailRelationship(TrailQuailTest::INVALID_KEY, $this->VALID_TRAILID, $this->VALID_SEGMENTID, $this->VALID_SEGMENTTYPE);
		$trailRelationship->insert($this->getPDO());
	}

	/**
	 * test inserting a Trail Relationship,
	 */
}