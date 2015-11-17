<?php
require_once(dirname(__DIR__). "/php/classes/segment.php");
require_once(dirname(__DIR__). "/php/classes/autoload.php");

/**
 *
 * Full PHPUnit test for the Segment class
 *
 * This is a complete PHPunit test of the Segment class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Segment
 * @author Matt Harris <mattharr505@gmail.com> and Trail Quail <trailquailabq@gmail.com>
 **/
class SegmentTest extends TrailQuailTest{
	/**
	 *  valid id for this segment; as stated above, this is the primary key
	 *
	 * @var int $segmentId
	 **/
	protected $VALID_SEGMENTID = null;

	/**
	 * valid starting location of trail segment
	 *
	 * @var float $segmentStart
	 **/
	protected $VALID_SEGMENTSTART = 35.21966, -106.48073;

	/**
	 * valid location for end of segment
	 *
	 * @var float $segmentStop
	 **/
	protected $VALID_SEGMENTSTOP = 34.21966, -107.48073;

	/**
	 * valid elevation at segment start point
	 *
	 * @var int $segmentStartElevation
	 **/
	protected $VALID_SEGMENTSTARTELEVATION = 5825;

	/**
	 * valid elevation at segment end point
	 *
	 * @var int $segmentStopElevation
	 **/
	protected $VALID_SEGMENTSTOPELEVATION = 10253;

	/**
	 *test inserting a valid segmentId entry and confirm the data matches mySQL
	**/

	public function testInsertValidSegment(){
	//count the number of rows and save it for later
	$numRows = $this ->getConnection()->getRowCount("segment");

	//create a new segment and insert it into the database
	$segment = new segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
	$segment->insert ($this->getPDO());

	//grab the data from mySQL and verify the fields
	$pdoSegment = Segment::getSegmentById($this->getPDO(),$segment->getSegmentId());
	$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
	$this->assertSame($pdoSegment->getSegmentStart(), $this->VALID_SEGMENTSTART);
	$this->assertSame($pdoSegment->getSegmentStop(), $this->VALID_SEGMENTSTOP);
	$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
	$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
	}

	/**test inserting a segmentId that already exists
	 *
	 * @expectedException PDOException
	**/

	public function testInsertInValidSegmentId() {
		//create segmentId with non null value and watch it fail
		$segment = new Segment(SegmentTest::INVALID_KEY, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION):
		$segment->insert($this->getPDO());
	}

	/**
	 * test inserting a segmentId, editing it and then updating it
	**/


}