<?php
require_once(dirname(dirname(__DIR__))."public_html/php/classes/segment.php");

/**
 * Class Segment for the website TrailQuail.com
 * This class can be used for any trail mapping application
 * The Segment class contains four attributes as follows:
 *
 * 1.segmentId, the primary key
 * 2.elevation
 * 3.start
 * 4.stop
 *
 * When a new Segment object is created it is automagically given the four attributes.
 * The new Segment entry is then created in the mySQL database where it can be accessed, updated, searched for or
 * deleted.
 *
 * @author Matt Harris <mattharr505@gmail.com>
 **/
class Segment {
	/**
	 * Id for this segment; as stated above, this is the primary key
	 * @var int $segmentId
	 **/
	private $segmentId;

	/**
	 * elevation attribute for the trail segment in feet.
	 * @var int $elevation
	 **/

	private $elevation;

	/**
	 * location for start of segment
	 * @var int $start
	 **/
	private $start;

	/**
	 * location for end of segment
	 * @var int $stop
	 *
	 **/

	private $stop;

	/** Constructor for segment objects
	 *
	 creates a new segment object which inherits the traits of the segment class
	 object contains the 4 attributes listed above in the parent class.
	 *
	 * @param mixed $segmentId id of this  segment or null if new segment
	 * @param int $elevation elevation of the segment in feet, or null if unavailable.
	 /matttodo/figure out lat and longitude/
	 * @param $start lattidue and longitude of start
	 * @param $stop  lattitude and longitude of stop
	 * @throws InvalidArgumentException if datatypes are not valid
	 * @throws RangeException if data values are out of bounds (e.g. string insted of int, string too long)
	 * @throws Exception if some other exception is thrown
	 *
	 **/
	public function __construct($newSegmentId, $newElevation, $newStart, $newStop) {
		try{
			$this->setSegmentId($newSegmentId);
			$this->setElevation($newElevation);
			$this->setStart($newStart);
			$this->setStop($newStop);
	}catch(invalidArgumentException $invalidArgument){
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(),0,$invalidArgument));
	}catch(RangeException $range){
			//rethrow the exception to the caller
			throw(new RangeException($range->getMessage(),0,$range));
	}catch(Exception $exception){
			//rethrow generic exception
			throw(new Exception($exception->getMessage(),0,$exception));
		}
}
/**
 * accessor method for segmentId
 *
 * gains access to segmentId for use by mutator method
 *
 *@return mixed value of segmentId
**/
	public function getSegmentId() {
		return $this->segmentId;
	}
/**
 * mutator method for segmentId
 *
 * modifies values of segmentId using the access given by the accessor method.
 *
 * @param mixed $newSegmentId new value of segmentId
 * @throws InvalidArgumentException if $newSegmentId is not an integer
 * @throws RangeException if $newSegmentId is not positive
 **/
	public function setSegmentId($newSegmentId){
		//base case: if the segmentId is null, this is a new segment without a mySQL assigned if (yet)
		if($newSegmentId === false){
			$this->segmentId = null;
			return;
		}
		// verify the segmentId is valid
		$newSegmentId = filter_var($newSegmentId, FILTER_VALIDATE_INT);
		if($newSegmentId === false){
			throw(new InvalidArgumentException("segment id is not a valid integer"));
		}
		// verify the segmentId is positive
		if($newSegmentId <=0){
			throw(new RangeException("segment id is not positive"));
		}
		// convert and store the segmentId
		$this->segmentId = intval($newSegmentId);
	}
}