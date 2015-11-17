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
		 * valid elevation at segment start point
		 *
		 * @var int $segmentStartElevation2
		 **/
	protected $VALID_SEGMENTSTARTELEVATION2 = 5285;

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
		$segment = new Segment(SegmentTest::INVALID_KEY, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment-> insert($this->getPDO());
	}

	/**
	 * test inserting a segmentId, editing it and then updating it
	**/
	public function testUpdateValidSegment(){
	//count the number of rows and save it for later
	$numRows = $this ->getConnection()->getRowCount("segment");

	//create a new segment and insert it into the database
	$segment = new segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
	$segment-> insert ($this->getPDO());

	//edit the stopElevation in segment and update it in mySQL
	$segment->setSegmentStartElevation($this->VALID_SEGMENTSTARTELEVATION2);
	$segment-> update($this->getPDO());

	//grab the data from mySQL and verify the fields
	$pdoSegment = Segment::getSegmentById($this->getPDO(),$segment->getSegmentId());
	$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
	$this->assertSame($pdoSegment->getSegmentStart(), $this->VALID_SEGMENTSTART);
	$this->assertSame($pdoSegment->getSegmentStop(), $this->VALID_SEGMENTSTOP);
	$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
	$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
	}

	/**test updating a segmentId that already exists
	 *
	 * @expectedException PDOException
	 **/

	public function testUpdateInvalidSegmentId() {
		//create segmentId with non null value and watch it fail
		$segment = new Segment(SegmentTest::INVALID_KEY, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment-> update($this->getPDO());
	}

	/**
	 * test creating a segment, and then deleting it
	 **/
	public function testDeleteValidSegment() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//delete this segment from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("segment"));
		$segment->delete($this->getPDO());

		//grab the data from mySQL and make sure the segmentId does not exist
		$pdoSegment = Segment::getSegmentById($this->getPDO(), $segment->getSegmentId());
		$this->assertNull($pdoSegment);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("segment"));
	}

	/**
	 * test grabbing a segment by segmentStart
	**/
	public function testGetValidSegmentByStart(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegment = Segment::getSegmentByStart($this->getPDO(),$segment->getSegmentStart());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
		$this->assertSame($pdoSegment->getSegmentStart(), $this->VALID_SEGMENTSTART);
		$this->assertSame($pdoSegment->getSegmentStop(), $this->VALID_SEGMENTSTOP);
		$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
		$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
	}

	/**
	 * test grabbing a segment by segmentStart that does not exist
	 *
	 * @expectedException PDOException
	**/

	public function testGetInvalidSegmentByStart(){
		//grab a segmentStart that does not exist
		$segment = Segment::getSegmentByStart($this->getPDO(), null);
		$this->assertNull($segment);
	}

/**
 * test grabbing a segment by segmentStop
 **/
	public function testGetValidSegmentByStop(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegment = Segment::getSegmentByStop($this->getPDO(),$segment->getsegmentStop());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
		$this->assertSame($pdoSegment->getSegmentStart(), $this->VALID_SEGMENTSTART);
		$this->assertSame($pdoSegment->getSegmentStop(), $this->VALID_SEGMENTSTOP);
		$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
		$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
	}

	/**
	 * test grabbing a segment by segmentStop that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidSegmentByStop(){
		//grab a segmentStop that does not exist
		$segment = Segment::getSegmentByStop($this->getPDO(), null);
		$this->assertNull($segment);
	}

/**
 * test grabbing a segment by SegmentStartElevation
 **/
	public function testGetValidSegmentBySegmentStartElevation(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegment = Segment::getSegmentByStartElevation($this->getPDO(),$segment->getSegmentStartElevation());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
		$this->assertSame($pdoSegment->getSegmentStart(), $this->VALID_SEGMENTSTART);
		$this->assertSame($pdoSegment->getSegmentStop(), $this->VALID_SEGMENTSTOP);
		$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
		$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
	}

	/**
	 * test grabbing a segment by SegmentStartElevation that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidSegmentByStartElevation(){
		//grab a SegmentStartElevation that does not exist
		$segment = Segment::getSegmentByStartElevation($this->getPDO(), null);
		$this->assertNull($segment);
	}

	/**
	 * test grabbing a segment by SegmentStopElevation
	 **/
	public function testGetValidSegmentByStopElevation(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegment = Segment::getSegmentByStopElevation($this->getPDO(),$segment->getSegmentStopElevation());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
		$this->assertSame($pdoSegment->getSegmentStart(), $this->VALID_SEGMENTSTART);
		$this->assertSame($pdoSegment->getSegmentStop(), $this->VALID_SEGMENTSTOP);
		$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
		$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
	}

	/**
	 * test grabbing a segment by SegmentStopElevation that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidSegmentByStopElevation(){
		//grab a SegmentStopElevation that does not exist
		$segment = Segment::getSegmentByStopElevation($this->getPDO(), null);
		$this->assertNull($segment);
	}
}





