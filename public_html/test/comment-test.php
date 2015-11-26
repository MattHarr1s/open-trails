<?php

// grab the project test parameters
require_once("trail-quail.php");

// grab the class that is being tested.
require_once(dirname(__DIR__). "/php/classes/autoload.php");

/**
 * full phpUnit for the comment class
 *
 * this is a complete PHPUnit test of the comment class. It is complete because *ALL mySQL/PDO enabled methods are tested for both invalid an valid inputs
 *
 * @see comment
 * @authur george Kephart <gkephart@cnm.eduu>
 */
class CommentTest extends TrailQuailTest {

	/**
	 *valid browser to use
	 * @var string $VALID_BROWSER
	 * @var string $VALID_BROWSER1
	 * @var string $VALID_BROWSER2
	 */
	protected $VALID_BROWSER = "chrome 46.0.2490.";

	/**
	 *valid browser to use
	 *
	 * @var string $VALID_BROWSER1
	 *
	 */
	protected $VALID_BROWSER1="firefox 41.0.2";

	/**
	 *valid browser to use
	 *
	 * @var string $VALID_BROWSER1
	 *
	 */
	protected $VALID_BROWSER2="IE 7 shit ";


	/**
	 * valid create dates to use for unit testing
	 * @var DATETIME $VALID_CREATEDATE
	 */
	protected $VALID_CREATEDATE = "2015-12-19 12:15:18";


	/**
	 * valid create dates to use for unit testing
	 *@var DATETIME $VALID_CREATEDATE1
	 */

	protected $VALID_CREATEDATE1 = "2015-12-19 12:16:20";


	/**
	 * valid create dates to use for unit testing
	 *@var DATETIME $VALID_CREATEDATE2
	 */
	protected $VALID_CREATEDATE2 = "2015-12-19 11:16:20";


	/**
	 * valid Ip Address to use for unit testing
	 * @var string $VALID_IPADDRESS
	 */
	protected $VALID_IPADDRESS = "2600::dead:beef:cafe";

	/**
	 * valid Ip Address to use for unit testing
	 *
	 * @var string $VALID_IPADDRESS1
	 */
	protected $VALID_IPADDRESS1= "2400::dead:beef:cafe";

	/**
	 * valid Ip Address to use for unit testing
	 *
	 * @var string $VALID_IPADDRESS1
	 */
	protected $VALID_IPADDRESS2 = "2700::dead:beef:cafe";

	/**
	 * valid comment photo path
	 * @var string $VALID_COMMENTPHOTO
	 */
	protected $VALID_COMMENTPHOTO = "bootcamp/coders/trailquail/firstphoto";
	/**
	 * valid comment photo path
	 * @var string $VALID_COMMENTPHOTO1
	 */
	protected $VALID_COMMENTPHOTO1 = "bootcamp/coders/trailquail/secondphoto";
	/**
	 * valid comment photo type
	 * @var string $VALID_COMMENTPHOTOTYPE
	 */
	protected $VALID_COMMENTPHOTOTYPE ="image/jpeg";
	/**
	 * valid comment photo type
	 * @var string $VALID_COMMENTPHOTOTYPE1
	 */
	protected $VALID_COMMENTPHOTOTYPE1 ="image/png";
	/**
	 * valid comment text
	 * @var string $VALID_COMMENTTEXT
	 */
	protected $VALID_COMMENTTEXT = "The fluffy kitten played with that ball of string all through the night. On a lighter note, a Kwik-E-Mart clerk was brutally murdered last night.";
	/**
	 * valid comment text
	 * @var string $VALID_COMMENTTEXT1
	 */
	protected $VALID_COMMENTTEXT1 = "Books are useless I only ever read one book To Kill A Mockingbird, and it gave me absolutely no insight on how to kill mockingbirds!";

	/**
	 * @var Trail $trail
	 */
	protected $trail = null;

	/**
	 * @var User $user
	 *
	 */
	protected $user = null;

	/**
	 * @var Segment $segment
	 */
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



	/**
	 * create various functions to run unit test
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
		$this->user = new User(null, $this->VALID_BROWSER ,$this->VALID_CREATEDATE, $this->VALID_IPADDRESS, "S", "bootbod@trex.com", $this->hash, "george kephart", $this->salt);
		$this->user->insert($this->getPDO());



		// create a trail to own test
		$this->trail = new Trail(null, $this->user->getUserId(), "Safari", $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, null, "y", "Picnic area", "Good", "This trail is a beautiful winding trail located in the Sandia Mountains", 3, 1054.53, "la luz trail ", 1, "Mostly switchbacks with a few sections of rock fall", "Heavy", "Hiking","fpfyRTmt6XeE9ehEKZ5LwF");
		$this->trail->insert($this->getPDO());
	}
	/**
	 * test inserting a valid Comment and verify that the actual mySQL data matches
	 */
	public function testInsertValidComment() {
		// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("comment");

		// create a new profile and insert into mySQL
		$comment = new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match expectations.
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertSame($pdoComment->getTrailId(), $this->trail->getTrailId());
		$this->assertSame($pdoComment->getUserId(), $this->user->getUserId());
		$this->assertSame($pdoComment->getBrowser(), $this->VALID_BROWSER);
		$this->assertEquals($pdoComment->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoComment->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoComment->getCommentPhoto(), $this->VALID_COMMENTPHOTO);
		$this->assertSame($pdoComment->getCommentPhotoType(), $this->VALID_COMMENTPHOTOTYPE);
		$this->assertSame($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
	}
	/**
	 * test inserting a Comment that already exists
	 *
	 * @expectedException PDOException
	 */
	public function testInsertInvalidComment() {
		// create a comment with a non null commentId for the fail!!
		$comment = new Comment(TrailQuailTest::INVALID_KEY,$this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
	}
	/**
	 * test inserting comment,editing it, then updating it
	 *
	 *
	 */
	public function testUpdateValidComment() {
		// count the number of rows and save it
		$numRows = $this->getConnection()->getRowCount("comment");

		//create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//edit the profile and update it in mySQL
		$comment->setCommentText($this->VALID_COMMENTTEXT1);
		$comment->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("comment"));
		$this->assertSame($pdoComment->getTrailId(), $this->trail->getTrailId());
		$this->assertSame($pdoComment->getUserId(), $this->user->getUserId());
		$this->assertSame($pdoComment->getBrowser(), $this->VALID_BROWSER);
		$this->assertEquals($pdoComment->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoComment->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoComment->getCommentPhoto(), $this->VALID_COMMENTPHOTO);
		$this->assertSame($pdoComment->getCommentPhotoType(), $this->VALID_COMMENTPHOTOTYPE);
		$this->assertSame($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT1);
	}
	/**
	 *test updating a Comment that doesn't exist
	 *
	 * @expectedException PDOException
	 */
	public function testUpdateInvalidComment() {
		// create a Comment and try to update without actually inserting it
		$comment= new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->update($this->getPDO());
	}

	/**
	 * test creating a comment then delete it
	 *
	 *
	 */
	public function testDeleteValidComment() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");

		// create a new comment and insert it into mySQL
		$comment = new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//delete the Comment from MySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$comment->delete($this->getPDO());

		// grab the data from mySQL
		$pdoComment= Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertNull($pdoComment);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("comment"));
	}
	/**
	 * test deleting a comment that doesn't exist
	 *
	 * @expectedException PDOException
	 */
	public function testDeleteInvalidComment (){
		// create a comment and than try deleting it without submitting it to mySQL
		$comment=new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->delete($this->getPDO());
	}
	/**
	 * test inserting a comment and grabbing it from mySQl
	 */
	public function testGetValidCommentByCommentId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");

		// create a new comment and insert to mySQL
		$comment= new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		// grab the data from MySQL and enforce the fields match our expectation
		$pdoComment= Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertSame($pdoComment->getTrailId(), $this->trail->getTrailId());
		$this->assertSame($pdoComment->getUserId(), $this->user->getUserId());
		$this->assertSame($pdoComment->getBrowser(), $this->VALID_BROWSER);
		$this->assertEquals($pdoComment->getCreateDate(), $this->VALID_CREATEDATE);
		$this->assertSame($pdoComment->getIpAddress(), $this->VALID_IPADDRESS);
		$this->assertSame($pdoComment->getCommentPhoto(), $this->VALID_COMMENTPHOTO);
		$this->assertSame($pdoComment->getCommentPhotoType(), $this->VALID_COMMENTPHOTOTYPE);
		$this->assertSame($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
	}

	/**
	 * test grabbing a comment that doesn't exist
	 */
	public function testGetInvalidCommentByCommentId(){
		// grab a comment id that exceeds the maximum allowable comment id
		$comment = Comment::getCommentByCommentId($this->getPDO(), TrailQuailTest::INVALID_KEY);
		$this->assertNull($comment);

	}



	/**
	 * test inserting a comment and and grabbing it by trailId
	 */
	public function testGetValidCommentByTrailId() {
		// get the count of rows in the database
		$numRows = $this->getConnection()->getRowCount("comment");

		// create a new comment and insert to mySQL
		$comment= new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//grab the data from mySQL and make sure it matches expectations
		$pdoComments = Comment::getCommentByTrailId($this->getPDO(), $comment->getTrailId());
		foreach($pdoComments as $pdoComment){
			if($pdoComment->getTrailId() === $comment->getTrailId()){
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
				$this->assertSame($pdoComment->getBrowser(), $this->VALID_BROWSER);
				$this->assertEquals($pdoComment->getCreateDate(), $this->VALID_CREATEDATE);
				$this->assertSame($pdoComment->getIpAddress(), $this->VALID_IPADDRESS);
				$this->assertSame($pdoComment->getCommentPhoto(), $this->VALID_COMMENTPHOTO);
				$this->assertSame($pdoComment->getCommentPhotoType(), $this->VALID_COMMENTPHOTOTYPE);
				$this->assertSame($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
			}
		}
	}

	/**
	 * test for grabbing a Comment by a trailId that does not exist
	 */
	public function testGetInvalidCommentByTrailId() {
		$comment = Comment::getCommentByTrailId ($this->getPDO(), TrailQuailTest::INVALID_KEY);
		$this->assertEmpty($comment);
	}



	/**
	 * test inserting a comment and and grabbing it by user Id
	 */
	public function testGetValidCommentByUserId() {
		// get the count of rows in the database
		$numRows = $this->getConnection()->getRowCount("comment");

		// create a new comment and insert to mySQL
		$comment= new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//grab the data from mySQL and make sure it matches expectations
		$pdoComments = Comment::getCommentByUserId($this->getPDO(), $comment->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
		foreach($pdoComments as $pdoComment){
			$this->assertSame($pdoComment->getBrowser(), $this->VALID_BROWSER);
			$this->assertEquals($pdoComment->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoComment->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoComment->getCommentPhoto(), $this->VALID_COMMENTPHOTO);
			$this->assertSame($pdoComment->getCommentPhotoType(), $this->VALID_COMMENTPHOTOTYPE);
			$this->assertSame($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
		}
	}

	/**
	 * test for grabbing a Comment by a UserId that does not exist
	 */
	public function testGetInvalidCommentByUserId() {
		$comment = Comment::getCommentByTrailId ($this->getPDO(), TrailQuailTest::INVALID_KEY);
		$this->assertEmpty($comment);
	}




	/**
	 * test grabbing a comment by its commentText
	 */

	public function testGetValidCommentByCommentText(){
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");

		//create a new comment and insert it into mysql
		$comment = new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		// grab the data from mySQL and enforce it meets expectations
		$pdoComments= Comment::getCommentByCommentText($this->getPDO(), $comment->getCommentText());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
		foreach($pdoComments as $pdoComment) {
			$this->assertSame($pdoComment->getBrowser(), $this->VALID_BROWSER);
			$this->assertEquals($pdoComment->getCreateDate(), $this->VALID_CREATEDATE);
			$this->assertSame($pdoComment->getIpAddress(), $this->VALID_IPADDRESS);
			$this->assertSame($pdoComment->getCommentPhoto(), $this->VALID_COMMENTPHOTO);
			$this->assertSame($pdoComment->getCommentPhotoType(), $this->VALID_COMMENTPHOTOTYPE);
			$this->assertSame($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
		}
	}

	/**
	 * test grabbing a  comment by an email that does not exist
	 */
	public function testGetInvalidCommentByText(){
		$comment = Comment::getCommentByCommentText($this->getPDO(),"homer@comcast.net");
		$this->assertEmpty($comment);
	}













}