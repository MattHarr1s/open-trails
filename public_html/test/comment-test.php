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
	 */
	protected $VALID_BROWSER = "chrome 46.0.2490.";
	/**
	 *valid browser to use
	 * @var string $VALID_BROWSER2
	 */
	protected $VALID_BROWSER2="firefox 41.0.2";

	/**
	 * valid create date to use
	 * @var DATETIME $VALID_CREATEDATE
	 */
	protected $VALID_CREATEDATE = "2015-12-19 12:15:18";
	/**
	 * valid create date to use
	 * @var DATETIME $VALID_CREATEDATE1
	 */
	protected $VALID_CREATEDATE1 = "2015-12-19 12:16:20";
	/**
	 * valid Ip Address to use
	 * @var string $VALID_IPADDRESS
	 */
	protected $VALID_IPADDRESS = "2600::dead:beef:cafe";
	/**
	 * valid Ip Address to use
	 * @var string $VALID_IPADDRESS1
	 */
	protected $VALID_IPADDRESS1= "2400::dead:beef:cafe";
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
	protected $VALID_COMMENTPHOTOTYPE ="jpeg";
	/**
	 * valid comment photo type
	 * @var string $VALID_COMMENTPHOTOTYPE1
	 */
	protected $VALID_COMMENTPHOTOTYPE1 ="png";
	/**
	 * valid comment text
	 * @var string $VALID_COMMENTTEXT
	 */
	protected $VALID_COMMENTTEXT = "The fluffy kitten played with that ball of string all through the night. On a lighter note, a Kwik-E-Mart clerk was brutally murdered last night.";
	/**
	 * valid comment text
	 * @var string $VALID_COMMENTTEXT1
	 */
	protected $VALID_COMMENTTEXT1 = " Books are useless! I only ever read one book, \"To Kill A Mockingbird,\" and it gave me absolutely no insight on how to kill mockingbirds! ";

	/**
	 * @var Trail $trail
	 * @var User $user
	 */
	protected $trail = null;

	public function setUp() {
		parent::setUp();
		//create setup for trail
		$this->trail = new Trail();
		$this->trail->insert($this->getPDO());
		//create setup for user
		$this->trail = new User();
		$this->user->insert($this->getPDO());
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
		$this->assertSame($pdoComment->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoComment->getCreateDate(), $this->VALID_CREATEDATE);
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
		$comment = new Comment(DataDesignTest::INVALID_KEY, $this-> VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
	}
	/**
	 * test inserting comment,editing it, then updating it
	 */
	public function testUpdateValidComment() {
		// count the number of rows and save it
		$numRows = $this->getConnection()->getRowCount("comment");

		//create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->trail->getTrailId(), $this->user->getUserId(), $this->VALID_BROWSER, $this->VALID_CREATEDATE, $this->VALID_IPADDRESS, $this->VALID_COMMENTPHOTO, $this->VALID_COMMENTPHOTOTYPE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//edit the profile and update it in mySQL
		$comment->setComment($this->VALID_COMMENTTEXT1);
		$comment->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertSame($numRows +1, $this->getConnection()->getRowCount("comment"));
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertSame($pdoComment->getBrowser(), $this->VALID_BROWSER);
		$this->assertSame($pdoComment->getCreateDate(), $this->VALID_CREATEDATE);
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
		$comment->insert($this->getPDO());
	}

	/**
	 * test creating a comment then delete it
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
	 * test deleting a profile that doesn't exist
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


	}




}