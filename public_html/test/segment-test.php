<?php
require_once "trail-quail.php";
require_once(dirname(__DIR__). "/php/classes/segment.php");
require_once(dirname(__DIR__). "/php/classes/autoload.php");

use Symm\Gisconverter\Gisconverter;

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
	 * @var mixed $segmentId
	 **/
	protected $VALID_SEGMENTID = null;

	/**
	 * valid starting location of trail segment
	 *
	 * @var Point $segmentStart
	 **/
	protected $VALID_SEGMENTSTART = null;

	/**
	 * valid location for end of segment
	 *
	 * @var Point $segmentStop
	 **/
	protected $VALID_SEGMENTSTOP = null;

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
	protected $VALID_SEGMENTSTARTELEVATION2 = 5785;

	/**
	 * valid elevation at segment end point
	 *
	 * @var int $segmentStopElevation
	 **/
	protected $VALID_SEGMENTSTOPELEVATION = 10253;

	/**
	 * create dependent objects before running each test
	 **/
	public function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create and insert a point for segmentStart
		$this->VALID_SEGMENTSTART = new Point(35.554, 44.546);


		//create and insert a point for segmentStop
		$this->VALID_SEGMENTSTOP = new Point(34.556, 44.435);

	}



	/**
	 *test inserting a valid segmentId entry and confirm the data matches mySQL
	**/

	public function testInsertValidSegment() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new Segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegments = Segment::getSegmentBySegmentId($this->getPDO(), $segment->getSegmentId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("segment"));
		foreach($pdoSegments as $pdoSegment) {
			$this->assertSame($pdoSegment->getSegmentStart()->getX(), $this->VALID_SEGMENTSTART->getX());
			$this->assertSame($pdoSegment->getSegmentStart()->getY(), $this->VALID_SEGMENTSTART->getY());
			$this->assertSame($pdoSegment->getSegmentStop()->getX(), $this->VALID_SEGMENTSTOP->getX());
			$this->assertSame($pdoSegment->getSegmentStop()->getY(), $this->VALID_SEGMENTSTOP->getY());
			$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
			$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
		}
	}

	/**
	 * test inserting a segmentId that already exists
	 *
	 * @expectedException PDOException
	**/

	public function testInsertInvalidSegmentId() {
		//create segmentId with non null value and watch it fail
		$segment = new Segment(SegmentTest::INVALID_KEY, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment-> insert($this->getPDO());
	}

	/**
	 * test inserting a segmentId, editing it and then updating it
	**/
	public function testUpdateValidSegment() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new Segment(null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//edit the stopElevation in segment and update it in mySQL
		$segment->setSegmentStartElevation($this->VALID_SEGMENTSTARTELEVATION2);
		$segment->update($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegments = Segment::getSegmentBySegmentId($this->getPDO(), $segment->getSegmentId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("segment"));
		foreach($pdoSegments as $pdoSegment) {
			$this->assertSame($pdoSegment->getSegmentStart()->getX(), $this->VALID_SEGMENTSTART->getX());
			$this->assertSame($pdoSegment->getSegmentStart()->getY(), $this->VALID_SEGMENTSTART->getY());
			$this->assertSame($pdoSegment->getSegmentStop()->getX(), $this->VALID_SEGMENTSTOP->getX());
			$this->assertSame($pdoSegment->getSegmentStop()->getY(), $this->VALID_SEGMENTSTOP->getY());
			$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
			$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
		}
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
		$segment = new Segment (null , $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//delete this segment from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("segment"));
		$segment->delete($this->getPDO());

		//grab the data from mySQL and make sure the segmentId does not exist
		$pdoSegment = Segment::getSegmentBySegmentId($this->getPDO(), $segment->getSegmentId());
		$this->assertNull($pdoSegment);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("segment"));
	}

	/**
	 * test grabbing a segment by segmentStart
	**/
	public function testGetValidSegmentBySegmentStart() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new Segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegments = Segment::getSegmentBySegmentStart($this->getPDO(), $segment->getSegmentStart());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("segment"));
		foreach($pdoSegments as $pdoSegment) {
			$this->assertSame($pdoSegment->getSegmentStart()->getX(), $this->VALID_SEGMENTSTART->getX());
			$this->assertSame($pdoSegment->getSegmentStart()->getY(), $this->VALID_SEGMENTSTART->getY());
			$this->assertSame($pdoSegment->getSegmentStop()->getX(), $this->VALID_SEGMENTSTOP->getX());
			$this->assertSame($pdoSegment->getSegmentStop()->getY(), $this->VALID_SEGMENTSTOP->getY());
			$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
			$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
		}
	}

	/**
	 * test grabbing a segment by segmentStart that does not exist
	 *
	 * @expectedException RangeException
	 **/

	public function testGetInvalidSegmentBySegmentStart(){
		//grab a segmentStart that does not exist
		$pdoSegments = Segment::getSegmentBySegmentStart($this->getPDO(), new Point(190.222, -190.222));
		foreach($pdoSegments as $pdoSegment){
			$this->assertNull($pdoSegment);
		}
	}

/**
 * test grabbing a segment by segmentStop
 **/
	public function testGetValidSegmentBySegmentStop(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new Segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegments = Segment::getSegmentBySegmentStop($this->getPDO(), $segment->getSegmentStop());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
		foreach($pdoSegments as $pdoSegment) {
			$this->assertSame($pdoSegment->getSegmentStart()->getX(), $this->VALID_SEGMENTSTART->getX());
			$this->assertSame($pdoSegment->getSegmentStart()->getY(), $this->VALID_SEGMENTSTART->getY());
			$this->assertSame($pdoSegment->getSegmentStop()->getX(), $this->VALID_SEGMENTSTOP->getX());
			$this->assertSame($pdoSegment->getSegmentStop()->getY(), $this->VALID_SEGMENTSTOP->getY());
			$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
			$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
		}
	}

	/**
	 * test grabbing a segment by segmentStop that does not exist
	 *
	 * @expectedException RangeException
	 **/

	public function testGetInvalidSegmentBySegmentStop(){
		//grab a segmentStop that does not exist
		$pdoSegments = Segment::getSegmentBySegmentStop($this->getPDO(), new Point(190.222, -190.222));
		foreach($pdoSegments as $pdoSegment) {
			$this->assertNull($pdoSegment);
		}
	}

/**
 * test grabbing a segment by SegmentStartElevation
 **/
	public function testGetValidSegmentBySegmentStartElevation(){
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new Segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegments = Segment::getSegmentBySegmentStartElevation($this->getPDO(),$segment->getSegmentStartElevation());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
		foreach($pdoSegments as $pdoSegment) {
			$this->assertSame($pdoSegment->getSegmentStart()->getX(), $this->VALID_SEGMENTSTART->getX());
			$this->assertSame($pdoSegment->getSegmentStart()->getY(), $this->VALID_SEGMENTSTART->getY());
			$this->assertSame($pdoSegment->getSegmentStop()->getX(), $this->VALID_SEGMENTSTOP->getX());
			$this->assertSame($pdoSegment->getSegmentStop()->getY(), $this->VALID_SEGMENTSTOP->getY());
			$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
			$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
		}
	}


	/**
	 * test grabbing a segment by SegmentStartElevation that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidSegmentByStartElevation(){
		//grab a SegmentStartElevation that does not exist
		$segment = Segment::getSegmentBySegmentStartElevation($this->getPDO(), null);
		$this->assertNull($segment);
	}

	/**
	 * test grabbing a segment by SegmentStopElevation
	 **/
	public function testGetValidSegmentByStopElevation() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("segment");

		//create a new segment and insert it into the database
		$segment = new Segment (null, $this->VALID_SEGMENTSTART, $this->VALID_SEGMENTSTOP, $this->VALID_SEGMENTSTARTELEVATION, $this->VALID_SEGMENTSTOPELEVATION);
		$segment->insert($this->getPDO());

		//grab the data from mySQL and verify the fields
		$pdoSegments = Segment::getSegmentBySegmentStopElevation($this->getPDO(),$segment->getSegmentStopElevation());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("segment"));
		foreach($pdoSegments as $pdoSegment) {
			$this->assertSame($pdoSegment->getSegmentStart()->getX(), $this->VALID_SEGMENTSTART->getX());
			$this->assertSame($pdoSegment->getSegmentStart()->getY(), $this->VALID_SEGMENTSTART->getY());
			$this->assertSame($pdoSegment->getSegmentStop()->getX(), $this->VALID_SEGMENTSTOP->getX());
			$this->assertSame($pdoSegment->getSegmentStop()->getY(), $this->VALID_SEGMENTSTOP->getY());
			$this->assertSame($pdoSegment->getSegmentStartElevation(), $this->VALID_SEGMENTSTARTELEVATION);
			$this->assertSame($pdoSegment->getSegmentStopElevation(), $this->VALID_SEGMENTSTOPELEVATION);
		}
	}

	/**
	 * test grabbing a segment by SegmentStopElevation that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testGetInvalidSegmentByStopElevation(){
		//grab a SegmentStopElevation that does not exist
		$segment = Segment::getSegmentBySegmentStopElevation($this->getPDO(), null);
		$this->assertNull($segment);
	}
}





