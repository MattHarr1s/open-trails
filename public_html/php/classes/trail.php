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
 * When a new trail object is created it is automagically given the four attributes.
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
	private trailId;

}