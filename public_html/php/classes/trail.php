<?php
require_once(dirname(dirname(__DIR__))."public_html/php/classes/trail.php");

/**
 * Class trail for the website TrailQuail.com
 * This class can be used for any trail mapping application
 * The Segment class contains 18 attributes as follows:
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
 * 11.browser
 * 12.ipAddress
 * 13.createDate
 * 14.trailSubmissionType
 * 15.trailTerrain
 * 16.trailName
 * 17.trailTraffic
 * 18.trailUse
 *
 *
 * When a new trail object is created it is automagically given the 18 attributes.
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
	 * id for the submission on the trail object. Exists so the primary key doesn't have to get updated.
	 **/
	private $trailUuId;
	/**
	 * id for the content of the submission of the trail object
	 **/
	private $submitTrailId;
	/**
	 * id of user that submits to the trail
	 **/
	private $userId;
	/**
	 * information on accessibility of trail
	 **/
	private $trailAccessibility;
	/**
	 *information on amenities on trail
	 */
	private $trailAmenities;
	/**
	 * information on the trail condition
	 **/
	private $trailCondition;
	/**
	 * information describing the trail
	 **/
	private $trailDescription;
	/**
	 * difficulty rating of trail
	 **/
	private $trailDifficulty;
	/**
	 * length of the trail
	 **/
	private $trailDistance;
	/**
	 * Anti abuse trait
	 **/
	private $antiAbuse;
	/**
	 * content of submission made to trail
	 **/
	private $trailSubmissionType;
	/**
	 * type of terrain on the trail
	 **/
	private $trailTerrain;
	/**
	 * name of trail
	 **/
	private $trailName;
	/**
	 * main use of the trail (hiking, cycling, skiing)
	 **/
}