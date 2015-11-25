<?php
// grab the project test parameters
require_once("trail-quail.php");
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

//class being tested
//require_once(dirname(__DIR__). "/php/classes/rating.php");

/**
 * Full PHPUnit test for the trail rating class
 *
 * This is a complete PHPUnit test of the trail rating class.
 * *All* mySQL/PDo enabled methods are tested for both valid and invalid inputs
 * @author George Kephart <gkephart@gmail.com>
 * with help from Jeff saul <scaleup13@gmail.com>
 */
class RatingTest extends TrailQuailTest {
	/**
	 * valid rating value
	 * @var int $VALID_RATINGVALUE
	 */
	protected $VALID_RATINGVALUE = 5;

	/**
	 * valid second rating value
	 * @var int $VALID_RATINGVALUE1
	 */
	protected $VALID_RATINGVALUE1 = 4;

	/**
	* invalid rating values
	 * @var int $INVALID_RATINGVALUE1
	*/
	protected $INVALID_RATINGVALUE1 = "A";

	/**
	 * invalid second rating value
	 * @var int $INVALID_RATINGVALUE2
	 */
	protected $INVALID_RATINGVALUE2 = 8;

	/**
	 * valid browser expressions to use
	 * @var string $VALID_BROWSER
	 */
	protected $VALID_BROWSER ="chrome 46.0.2490.";

	/**
	 * valid create dates to use for unit testing
	 * @var DATETIME $VALID_CREATEDATE
	 */
	protected $VALID_CREATEDATE = "2015-12-19 12:15:18";

	/**
	 * valid Ip Address to use for unit testing
	 * @var string $VALID_IPADDRESS
	 */
	protected $VALID_IPADDRESS = "2600::dead:beef:cafe";

	/**
	 * valid trail to use
	 * @var Trail $trail
	 */
	protected $trail = null;

	/**
	 * valid user to use
	 * @var User $user
	 */
	protected $user = null;

	/**
	 * valid segment to use
	 * @var Segment $segment
	 */
	protected $segment = null;

	/**
	 * valid segment start
	 * @var SegmentStart $segmentStart
	 */
	protected $segmentStop = null;

	/**
	 * valid segment stop
	 * @var SegmentStop $segmentStop
	 */
	protected $segmentStart = null;

	/**
	 *valid user hash
	 * @var string $hash
	 */
	protected $hash = null;

	/**
	 *valid user salt
	 * @var string $salt
	 */
	protected $salt = null;

	/**
	 * This setUp function changes the date string to a DateTime object, creates a segment, creates test values for user salt and hash, and then creates user and trail entries to use for testing
	 */
	public function setUp() {
		parent::setUp();
		// necessary DateTime format to run the test
		$this->VALID_CREATEDATE = DateTime::createFromFormat("Y-m-d H:i:s", $this->VALID_CREATEDATE);

		//create points needed for segment
		$segmentStart = new Point(35.554, 44.546);
		$segmentStop = new Point(35.554, 48.445);

		//create new segment to use for testing
		$this->segment = new Segment(null, $segmentStart, $segmentStop, 7565, 9800);

		$this->segment->insert($this->getPDO());

		//create needed dependencies to ensure user can be created to run unit testing
		$this->salt = bin2hex(openssl_random_pseudo_bytes(32));
		$this->hash = hash_pbkdf2("sha512", "iLoveIllinois", $this->salt, 262144, 128);

		//create a new user to use for testing
		$this->user = new User(null, $this->VALID_BROWSER,$this->VALID_CREATEDATE, $this->VALID_IPADDRESS, "S", "bootboo@trex.com", $this->hash, "george kephart", $this->salt);
		$this->user->insert($this->getPDO());

		// create a trail to own test
		// Trail(trailId, userId, browser, createDate, ipAddress, submitTrailId, trailAccessibility, trailAmenities, trailConditions,
		$this->trail = new Trail(null, $this->user->getUserId(), "Safari", $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, null, "y", "Picnic area", "Good", "This trail is a beautiful winding trail located in the Sandia Mountains", 3, 1054.53, "la luz trail", 1, "Mostly switchbacks with a few sections of rock fall", "Heavy", "Hiking","fpfyRTmt6XeE9ehEKZ5LwF");
		$this->trail->insert($this->getPDO());
	}

/**
 * test for creating a trail rating with an invalid user name
 *
 * @expectedException PDOException
 */
	public function testInsertInvalidUserId() {
		//create a rating with a non null ratingId for the fail!!
		$rating = new Rating($this->trail->getTrailId(), TrailQuailTest::INVALID_KEY, $this->VALID_RATINGVALUE);
		$rating->insert($this->getPDO());
	}

	/**
	 *
	 */


	/**
	 *test inserting rating,  editing it, then updating it
	 *
	 *grabs the data from mySQL via getRatingByTrailId
	 */
	public function testUpdateValidRatingByIds() {
		//count the numbers of rows and save it
		$numRows = $this->getConnection()->getRowCount("rating");

		//create a new rating and inserting it into mysql
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_RATINGVALUE);
		$rating->insert($this->getPDO());

		//edit the rating and and update it into
		$rating->setRatingValue($this->VALID_RATINGVALUE1);
		$rating->update($this->getPDO());

		// grab the data from mysql and enforce the fields meet expectation;
		$pdoRating = Rating::getRatingByTrailIdAndUserId($this->getPDO(), $this->trail->getTrailId(), $this->user->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertSame($pdoRating->getTrailId(), $rating->getTrailId());
		$this->assertSame($pdoRating->getUserId(), $rating->getUserId());
		$this->assertSame($pdoRating->getRatingValue(), $this->VALID_RATINGVALUE1);
	}

	/**
	 * test updating a rating that doesn't exist
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testUpdateInvalidRating() {
		// create a rating then try and insert it for the fail.
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->INVALID_RATINGVALUE1);
		$rating->update($this->getPDO());

	}
	/**
	 * test creating a rating then deleting it
	 */
	public function testDeleteValidRating() {
		$numRows = $this->getConnection()->getRowCount("rating");

		// create a new rating and insert it into mySQL
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_RATINGVALUE);
		$rating->insert($this->getPDO());

		// delete the user from mysql
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$rating->delete($this->getPDO());

		// grab the data from mysql and enforce the fields meet expectation;
		$pdoRating = Rating::getRatingByTrailIdAndUserId($this->getPDO(), $this->trail->getTrailId(), $this->user->getUserId());

		$this->assertNull($pdoRating);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("rating"));
	}

	/**
	 * test inserting a Rating and grabbing it from my sql
	 */

	public function testGetValidRatingByIds(){
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");

		// create a new rating and insert it into my sql
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_RATINGVALUE);
		$rating->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match expectations
		$pdoRating = Rating::getRatingByTrailIdAndUserId($this->getPDO(),$this->trail->getTrailId(), $this->user->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertSame($pdoRating->getRatingValue(), $this->VALID_RATINGVALUE);
	}
	/**
	 * test grabbing a rating that does not exist
	 */
	public function testGetInvalidRatingByIds() {
		//grab a rating value that exceeds the maximum allowable id's
		$rating = Rating::getRatingByTrailIdAndUserId($this->getPDO(), TrailQuailTest::INVALID_KEY,TrailQuailTest::INVALID_KEY);
		$this->assertNull($rating);
	}

	/**
	 * test inserting a Rating and grabbing it from my sql
	 */
	public function testGetValidRatingByTrail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");

		// create a new rating and insert it into my sql
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_RATINGVALUE);
		$rating->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match expectations
		$pdoRatings = Rating::getRatingValueByTrailId($this->getPDO(), $this->trail->getTrailId());
		foreach ($pdoRatings as $pdoRating) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("rating"));
			$this->assertSame($pdoRating->getRatingValue(), $this->VALID_RATINGVALUE);
		}
	}

	/**
	 * test grabbing a rating by trail Id
	 *
	 * @expectedException PDOException
	 */
	public function testGetInvalidRatingByTrailId(){
		$rating = Rating::getRatingValueByTrailId($this->getPDO(), "@doesnotexist");
		$this->assertNull($rating);
	}
}
