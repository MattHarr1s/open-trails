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
	public final function setUp() {
		//create setup for trail
		$this->trail = new Trail(null, "Safari", DateTime::createFromFormat("Y-m-d H:i:s", "2015-11-15 12:15:42"), "192.168.1.4", 5, "y", "Picnic area", "Good", "This trail is a beautiful winding trail located in the Sandia Mountains", 3, 1054.53, "La Luz", 1, "Mostly switchbacks with a few sections of rock fall", "Heavy", "Hiking", "SSEERFFV4444554");
		$this->trail->insert($this->getPDO());

		//create and insert a userId to own the trail
		$this->user =new User(null, "Chrome", "2015-11-15 09:45.30", "192.168.1.168", "S", "saul.jeff@gmail.com", null, "Hyourname.tomorrow", null);
		$this->user->insert($this->getPDO());

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
		$pdoRating = Rating::getRatingValueByTrailIdAndUserId($this->getPDO(), $this->trail->getTrailId(), $this->user->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertSame($pdoRating->getRatingVale(), $this->VALID_RATINGVALUE1);
	}``





}
