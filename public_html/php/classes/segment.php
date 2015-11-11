<?php
require_once(dirname(dirname(__DIR__))."public_html/php/classes/autoload.php");

/**
 * Class Segment for the website TrailQuail.net
 * This class can be used for any trail mapping application
 * The Segment class contains the following attributes:
 *
 * segmentId, the primary key
 * segmentStart
 * segmentStop
 * segmentStartElevation
 * segmentStopElevation
 *
 * @author Matt Harris <mattharr505@gmail.com>
 **/
class Segment {
	/**
	 * Id for this segment; as stated above, this is the primary key
	 *
	 * @var int $segmentId
	 **/
	private $segmentId;

	/**
	 * starting location of trail segment
	 *
	 * @var float $segmentStart
	 **/
	private $segmentStart;

	/**
	 * location for end of segment
	 *
	 * @var float $segmentStop
	 **/
	private $segmentStop;

	/**
	 * elevation at segment start point
	 *
	 * @var int $segmentStartElevation
	 **/
	private $segmentStartElevation;

	/**
	 * elevation at segment end point
	 *
	 * @var int $segmentStopElevation
	 **/
	private $segmentStopElevation;

	/** Constructor for segment objects
	 *
	 *
	 * @param mixed $segmentId
	 * @param float $segmentStart
	 * @param float $segmentStop
	 * @param int $segmentStartElevation
	 * @param int $segmentStopElevation
	 * @throws InvalidArgumentException if datatypes are not valid
	 * @throws RangeException if data values are out of bounds (e.g. string instead of int, string too long)
	 * @throws Exception if some other exception is thrown
	 *
	 **/
	public function __construct($newSegmentId, $newSegmentStart, $newSegmentStop, $newSegmentStartElevation, $newSegmentStopElevation) {
		try{
			$this->setSegmentId($newSegmentId);
			$this->setSegmentStart($newSegmentStart);
			$this->setSegmentStop($newSegmentStop);
			$this->setSegmentStartElevation($newSegmentStartElevation);
			$this->setSegmentStopElevation($newSegmentStopElevation);
	}catch(InvalidArgumentException $invalidArgument){

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
 * @return mixed value of segmentId
**/
	public function getSegmentId(){
		return ($this->segmentId);
	}
/**
 * mutator method for segmentId
 *
 *
 * @param mixed $newSegmentId new value of segmentId
 **/
	public function setSegmentId($newSegmentId){
		$this->segmentId = Filter::filterInt($newSegmentId,"Segment Id",true);
	}
/**
 * accessor method for segmentStart
 *
 * @return float value of segmentStart
**/
	public function getSegmentStart(){
		return ($this->segmentStart);
	}

/**
 * mutator method for segmentStart
 *
 * @param float $newSegmentStart.
**/
	public function setSegmentStart($newSegmentStart){

	}

/**
 * accessor method for segmentStop
 *
 * @return float value of segmentStop
**/
	public function getSegmentStop(){
		return ($this->segmentStop);
	}

/**
 *mutator method for segmentStop
 *
 *@param float $newSegmentStop
**/
	public function setSegmentStop($newSegmentStop){

	}
/**
 * accessor method for segmentStartElevation
 *
 * @return int value of startElevation
**/
	public function getSegmentStartElevation(){
		return ($this->segmentStartElevation);
	}

/**
 * mutator for segmentStartElevation
 *
 *@param int $newSegmentStartElevation
**/
	public function setSegmentStartElevation($newSegmentStartElevation){
		$this->segmentStartElevation = Filter::filterInt($newSegmentStartElevation,"Segment Start Elevation",false);
	}

/**
 * accessor method for segmentStopElevation
 *
 * @return int value of segmentStopElevation
**/
	public function getSegmentStopElevation(){
		return ($this->segmentStopElevation);
	}

/**
 * mutator for segmentStopElevation
 *
 * @param int $newSegmentStopElevation
**/
	public function setSegmentStopElevation($newSegmentStopElevation){
		$this->segmentStopElevation = Filter::filterInt($newSegmentStopElevation,"Segment Stop Elevation",false);
	}
}