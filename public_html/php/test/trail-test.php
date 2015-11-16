<?php
require_once("trail.php");
require_once(dirname(__DIR__). "/classes/trail.php");

/**
 *
 * Full PHPUnit test for the Trail class
 *
 * This is a complete PHPunit test of the Trail class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Trail
 * @author Matt Harris <mattharr505@gmail.com> and Trail Quail <trailquailabq@gmail.com>
**/
class TrailTest extends TrailQuailTest{
	/**
	 * valid trailId to use
	 * @var int $VALID_TRAILID
	 */

	protected $VALID_TRAILID ="5";
	/**
	 * id for the content of the submission of the trail object
	 * @var int $VALID_SUBMITTRAILID
 **/
	protected $VALID_SUBMITTRAILID ="7";

	/**
	 * id of user that submits to the trail
	 * @var int $VALID_USERID
	 **/
	protected $VALID_USERID="2";

	/**
	 * accessibility info for trail
	 * @var string $VALID_TRAILACCESSIBILITY
	 **/
	protected $VALID_TRAILACCESSIBILITY ="Wheelchair";

	/**
	 *information on amenities on trail
	 * @var string $VALID_TRAILAMENITIES
	 */
	protected $VALID_TRAILAMENITIES = "Picnic area";
	/**
	 * information on the trail condition
	 * @var string $VALID_TRAILCONDITION
	 **/
	protected $VALID_TRAILCONDITIION = "Good";

	/**
	 * information describing the trail
	 * @var string $VALID_TRAILDESCRIPTION
	 **/
	protected $VALID_TRAILDESCRIPTION = "This trail is a beautiful winding trail located in the Sandia Mountains";

	/**
	 * difficulty rating of trail
	 * @var int $VALID_TRAILDIFFICULTY
	 **/
	protected $VALID_TRAILDIFFICULTY = "3";

	/**
	 * length of the trail
	 * @var int $VALID_TRAILDISTANCE
	 **/
	protected $VALID_TRAILDISTANCE = "1000";

	/**
	 * type of submission made to trail
	 * @var int $VALID_TRAILSUBMISSIONTYPE
	 **/
	protected $VALID_TRAILSUBMISSIONTYPE = "2";

	/**
	 * type of terrain on the trail
	 * @var string $VALID_TRAILTERRAIN
	 **/
	protected $VALID_TRAILTERRAIN = "Mostly switchbacks with a few sections of rock fall";

	/**
	 * name of trail
	 * @var string $VALID_TRAILNAME
	 **/
	protected $VALID_TRAILNAME = "La Luz";

	/**
	 *amount of traffic on trail
	 *@var string $VALID_TRAILTRAFFIC
	 **/
	protected $VALID_TRAILTRAFFIC = "Heavy";

	/**
	 * main use of the trail (hiking, cycling, skiing)
	 * @var string $VALID_TRAILUSE
	 **/
	protected $VALID_TRAILUSE = "Hiking";

	/**
	 * id for the submission on the trail object. Exists so the primary key does not have to get updated.
	 * @var string $VALID_TRAILUUID
	 **/
	protected $VALID_TRAILUUID = "SSEERFFV4444554";
}