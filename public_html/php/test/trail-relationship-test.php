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
}