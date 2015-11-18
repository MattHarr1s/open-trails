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
		$pdoRating = Rating::getTrailRatingByTrailIdAndUserId($this->getPDO(),$this->trail->getTrailId(), $this->user->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertSame($pdoRating->getAtHandle(), $this->VALID_RATINGVALUE);
	}
	/**
	 * test grabbing a rating that does not exist
	 */
	public function testGetInvalidRatingByIds() {
		//grab a rating value that exceeds the maximum allowable id's
		$rating = Rating::getTrailRatingByTrailIdAndUserId($this->getPDO(), TrailQuailTest::INVALID_KEY);
		$this->assertNull($rating);
	}
	/**
	 * test grabbing a rating by rating value
	 */
	public function testGetValidRatingBy() { 5
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("rating");

		// create a new rating and insert it into my sql
		$rating = new Rating($this->trail->getTrailId(), $this->user->getUserId(), $this->VALIDRATINGVALUE);
		$rating->insert($this->getPDO());

		// grab the data from mySQL and enforce it meets expectation
		$pdoRating = Rating::getRatingByRatingValue($this->getPDO(), $this->VALID_RATINGVALUE);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("rating"));
		$this->assertSame($pdoRating->getAtHandle(), $this->VALID_RATINGVALUE);
	}
	/**
	 * test grabbing a rating by ata handle that doesn't exist
	 */
	public function testGetInvalidRatingByRating(){
		$rating = Rating::geRatingByRatingValue($this->getPDO(), "@doesnotexist");
		$this->assertNull($rating);

	}

}
