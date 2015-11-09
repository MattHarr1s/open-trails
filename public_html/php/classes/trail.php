<?php
require_once(dirname(dirname(__DIR__))."public_html/php/classes/trail.php");

/**
 * Class trail for the website TrailQuail.com
 * This class can be used for any trail mapping application
 * The Trail class contains 16 attributes as follows:
 *
 * 1.trailId, the primary key
 * 2.trailUuid
 * 3.submitTrailId
 * 4.userId
 * 5.trailAccessibility
 * 6.trailAmenities
 * 7.trailCondition
 * 8.trailDescription
 * 9.trailDifficulty
 * 10.trailDistance
 * 11.antiAbuse
 * 12.trailSubmissionType
 * 13.trailTerrain
 * 14.trailName
 * 15.trailTraffic
 * 16.trailUse
 *
 *
 * When a new trail object is created it is automagically given the 16 attributes.
 * The new Segment entry is then created in the mySQL database where it can be accessed, updated, searched for or
 * deleted.
 *
 * @author Trail Quail <trailquailabq@gmail.com>
 **/
class Trail{
	/**
	 * id for the trail; as stated above, this is the primary key
	 * @var int trailId
	 **/
	private $trailId;
	/**
	 * id for the submission on the trail object. Exists so the primary key does not have to get updated.
	 * @var int trailUuId
	 **/
	private $trailUuId;
	/**
	 * id for the content of the submission of the trail object
	 * @var int submitTrailID
	 **/
	private $submitTrailId;
	/**
	 * id of user that submits to the trail
	 * @var int userId
	 **/
	private $userId;
	/**
	 * information on accessibility of trail
	 * @var string trailAccessibility
	 **/
	private $trailAccessibility;
	/**
	 *information on amenities on trail
	 * @var string trailAmenities
	 */
	private $trailAmenities;
	/**
	 * information on the trail condition
	 * @var string trailConditions
	 **/
	private $trailCondition;
	/**
	 * information describing the trail
	 * @var string trailDescription
	 **/
	private $trailDescription;
	/**
	 * difficulty rating of trail
	 * @var int trailDifficulty
	 **/
	private $trailDifficulty;
	/**
	 * length of the trail
	 * @var int trailDistance
	 **/
	private $trailDistance;
	/**
	 * Anti abuse trait
	 * @trait antiAbuse
	 **/
	private $antiAbuse;
	/**
	 * content of submission made to trail
	 * @var string trailSubmissionType
	 **/
	private $trailSubmissionType;
	/**
	 * type of terrain on the trail
	 * @var string trailTerrain
	 **/
	private $trailTerrain;
	/**
	 * name of trail
	 * @var string trailName
	 **/
	private $trailName;
	/**
	 * main use of the trail (hiking, cycling, skiing)
	 * @var string trailUse
	 **/
	private $trailUse;

	/**
	 * constructor for trail object.
	 *trail object contains the 16 attributes listed above.
	 *
	 * @param mixed $trailId of this trail or null if a new trail
	 * @param bin $trailUuId id for the submission to the trail object. Exists so primary key doesn't get updated.
	 * @param int $submitTrailId identification of info submited to trail entity
	 * @param mixed $userId id of user that makes submission to trail entity
	 * @param string $trailAccessibility info on accessibility of trail
	 * @param string $trailAmenities info on amenities on trail
	 * @param string $trailCondition info on the condition of the trail
	 * @param string $trailDescription description of the trail
	 * @param int $trailDifficulty
	 * @param trait $antiAbuse
	 * @param string $trailSubmissionType content of the submission made to the trail
	 * @param string $trailTerrain terrain found on trail
	 * @param string $trailName common name of the trail
	 * @param int $trailTraffic rating of average volume of users on trail
	 * @param string $trailUse
	 * @throws InvalidArgumentException if data values are out of bounds
	 *
	 */
	public function __construct($newTrailId, $newTrailUuId, $newSubmitTrailId, $newUserId, $newTrailAccessibility,
	$newTrailAmenities, $newTrailCondition, $newTrailDescription, $newTrailDifficulty, $newTrailDistance,$newAntiAbuse,
	$newTrailSubmissionType, $newTrailTerrain, $newTrailName, $newTrailTraffic, $newTrailUse) {
		try{
			$this->setTrailId($newTrailId);
			$this->setTrailUuId($newTrailUuId);
			$this->setSubmitTrailId($newSubmitTrailId);
			$this->setUserId($newUserId);
			$this->setTrailAccessibility($newTrailAccessibility);
			$this->setTrailAmenities($newTrailAmenities);
			$this->setTrailCondition($newTrailCondition);
			$this->setTrailDescription($newTrailDescription);
			$this->setTrailDifficulty($newTrailDifficulty);
			$this->setTrailDistance($newTrailDistance);
			/matttodo/figure out $this->antiAbuse
			$this->setTrailSubmissionType($newTrailSubmissionType);
			$this->setTrailTerrain($newTrailTerrain);
			$this->setTrailName($newTrailName);
			$this->setTrailTraffic($newTrailTraffic);
			$this->setTrailUse($newTrailUse);
		}
	}
}