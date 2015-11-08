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
	 */

}