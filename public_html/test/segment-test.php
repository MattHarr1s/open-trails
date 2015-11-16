<?php
require_once("segment.php");
require_once(dirname(__DIR__). "/php/classes/segment.php");

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
	 * Id for this segment; as stated above, this is the primary key
	 *
	 * @var int $segmentId
	 **/
	protected $segmentId;

	/**
	 * starting location of trail segment
	 *
	 * @var float $segmentStart
	 **/
	protected $segmentStart;

	/**
	 * location for end of segment
	 *
	 * @var float $segmentStop
	 **/
	protected $segmentStop;

	/**
	 * elevation at segment start point
	 *
	 * @var int $segmentStartElevation
	 **/
	protected $segmentStartElevation;

	/**
	 * elevation at segment end point
	 *
	 * @var int $segmentStopElevation
	 **/
	protected $segmentStopElevation;

}