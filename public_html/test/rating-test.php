<?php
// grab the project test parameters
require_once("trail-quail.php");

//class being tested
require_once(dirname(__DIR__). "/php/classes/trail-rating.php");

/**
 * Full PHPUnit test for the trail rating class
 *
 * This is a comlete PHPUnit test of the trail rating class. it will test *all* mySQL/PDo enabled methods
 * are tested for both valid and invalid inputs
 */
class RatingTest extends TrailQuailTest {
	/**
	 * valid rating value
	 * @var int $VALID_RATINGVALUE
	 *
	 */
	protected $VALID_RATINGVALUE = "5";
	/**
	 * valid second rating value
	 * @var int $VALID_RATINGVALUE1
	 *
	 */
	protected $VALID_RATINGVALUE1= "4";

	/**
	 *valid browser to use
	 * @var string $VALID_BROWSER
	 * @var string $VALID_BROWSER1
	 * @var string $VALID_BROWSER2
	 */
	protected $VALID_BROWSER = "chrome 46.0.2490.";
	protected $VALID_BROWSER1="firefox 41.0.2";
	protected $VALID_BROWSER2="IE 7 shit ";


	/**
	 * valid create dates to use for unit testing
	 * @var DATETIME $VALID_CREATEDATE
	 * @var DATETIME $VALID_CREATEDATE1
	 * @var DATETIME $VALID_CREATEDATE2
	 */
	protected $VALID_CREATEDATE = "2015-12-19 12:15:18";
	protected $VALID_CREATEDATE1 = "2015-12-19 12:16:20";
	protected $VALID_CREATEDATE2 = "2015-12-19 11:16:20";


	/**
	 * valid Ip Address to use for unit testing
	 * @var string $VALID_IPADDRESS
	 * @var string $VALID_IPADDRESS1
	 * @var string $VALID_IPADDRESS2
	 *
	 */
	protected $VALID_IPADDRESS = "2600::dead:beef:cafe";
	protected $VALID_IPADDRESS1= "2400::dead:beef:cafe";
	protected $VALID_IPADDRESS2 = "2700::dead:beef:cafe";

	/**
	 * @var Trail $trail
	 * @var User $user
	 * @var segment $segment
	 */
	protected $trail = null;
	protected $user = null;
	protected $segment = null;


	/**
	 * valid segment start and stop
	 * @var point $segmentStart
	 */
	protected $segmentStop = null;
	protected $segmentStart = null;
	/**
	 *valid user salt and hash to create a user to own the test
	 * @var string user $hash
	 * @var string user $salt
	 */
	protected $hash = null;
	protected $salt = null;

	public final function setUp() {
		parent::setUp();
		// necessary DateTime format to run the test
		$this->VALID_CREATEDATE= DateTime::createFromFormat("2015-12-19 12:30:45", $this->VALID_CREATEDATE);

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
		$this->user = new User(null, $this->VALID_BROWSER ,$this->VALID_CREATEDATE1, $this->VALID_IPADDRESS2, "S", "bootbob@trex.com", $this->hash, "george kephart", $this->salt);
		$this->user->insert($this->getPDO());

		// create a trail to own test
		$this->trail = new Trail(null, $this->user->getUserId(), "Safari", $this->VALID_CREATEDATE2, $this->VALID_IPADDRESS2, null, "y", "Picnic area", "Good", "This trail is a beautiful winding trail located in the Sandia Mountains", 3, 1054.53, "la luz trail ", 1, "Mostly switchbacks with a few sections of rock fall", "Heavy", "Hiking","fpfyRTmt6XeE9ehEKZ5LwF");
		$this->trail->insert($this->getPDO());
	}




	public function testInsertInvalidRating() {
		//create a rating with a non null ratingId for the fail!!
		$rating= new Rating($this->VALID_TRAILID, TrailQuailTest::INVALID_KEY, $this->VALID_RATINGVALUE);
		$rating->nsert($this->getPDO());
	}
	/**
	 *test inserting rating  editing it, then updating it
	 *
	 *grabs the data from mySQL via getRatingByTrailId
	 */
	public function testUpdateValidRatingByTrailId() {
		//count the numbers of rows and save it
		$numRows = $this->getConnection()->getRowCount("rating");

		//create a new rating and inserting it into mysql
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALIDRATINGVALUE);
		$rating->update($this->getPDO());

		//edit the rating and and update it into
		$rating->setRatingValue($this->VALID_RATINGVALUE1);
		$rating->update($this->getPDO());

		// grab the data from mysql and enforce the fields meet expectation;
		$pdoRating = Rating::getRatingValueByTrailIdAndUserId($this->getPDO(), $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_RATINGVALUE1);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertSame($pdoRating->getRatingVale(), $this->VALID_RATINGVALUE1);

	}
	/**
	 * test updating a rating that doesn't exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvalidRating() {
		// create a rating then try and insert it for the fail.
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALIDRATINGVALUE);
		$rating->nsert($this->getPDO());
	}
	/**
	 * test creating a rating then deleting it
	 */
	public function testDeleteValidRating() {
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new rating and insert it into mySQL
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALIDRATINGVALUE);
		$rating->insert($this->getPDO());

		// delete the user from mysql
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$rating->delete($this->getPDO());

		// grab the data from mysql and enforce the fields meet expectation;
		$pdoRating = Rating::getRatingByTrailIdAndUserId($this->getPDO(), $this->trail->getTrailId(), $this->user->getUserId());

		$this->assertNull($pdoRating);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("rating"));
	}

	/**
	 * test deleting a rating that does not exist
	 *
	 * @expectedException pdoException
	 */
	public function testDeleteInvalidRating() {
		// create a Rating and try to delete it without actually inserting it
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALIDRATINGVALUE);
		$rating->delete($this->getPDO());
	}
	/**
	 * test inserting a Rating and grabbing it from my sql
	 */
	public function testGetValidRatingByIds(){
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new rating and insert it into my sql
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALIDRATINGVALUE);
		$rating->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match expectations
		$pdoRating = Rating::getRatingByTrailIdAndUserId($this->getPDO(),$this->trail->getTrailId(), $this->user->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertSame($pdoRating->getAtHandle(), $this->VALID_RATINGVALUE);
	}
	/**
	 * test grabbing a rating that does not exist
	 */
	public function testGetInvalidRatingByIds() {
		//grab a rating value that exceeds the maximum allowable id's
		$rating = Rating::getRatingByTrailIdAndUserId($this->getPDO(), TrailQuailTest::INVALID_KEY);
		$this->assertNull($rating);
	}
	/**
	 * test inserting a Rating and grabbing it from my sql
	 */
	public function testGetValidRatingByTrail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new rating and insert it into my sql
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALIDRATINGVALUE);
		$rating->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match expectations
		$pdoRating = Rating::getTrailRatingByTrailId($this->getPDO(), $this->trail->getTrailId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertSame($pdoRating->getRating(), $this->VALID_RATINGVALUE);
	}

	/**
	 * test grabbing a rating by rating value
	 */
	public function testGetInvalidRatingByTrail(){
		$rating = Rating::getRatingValueByTrailId($this->getPDO(), "@doesnotexist");
		$this->assertNull($rating);
	}
}
