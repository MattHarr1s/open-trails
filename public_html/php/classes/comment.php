<?php

/**
 cross section of trail quail that is user submitted comments
 *
 * this feature will be a comment thread that will allow for users to communicate important information about the trail,
 * to have conversations about hiking, to upload photos, and to get official information from the city about the trail
 *
 *@author George Kephart <gkephart@cnm.edu>
 */
class comment {
	/**
	 *id for this comment; this is a primary key
	 * @var int $tweetId
	 */
	private $commentId;
	/**
	 * id of the trail that is associated with the comment; this is a foreign key
	 * @var int $trailId
	 *
	 */
	private $trailId;
	/**
	 * id of the user that sent this comment; this is a foreign key
	 * @var int $userId
	 */
	private $userId;
	/**
	 *this is a photo that is uploaded as a comment from a user about a specfic trail
	 * @var string $commentPhoto
	 */
	private $commentPhoto;
	/**
	 * this is the type of photo that was uploaded.
	 * @var string $commentPhotoType
	 */
	private $commentPhotoType;
	/**
	 *this is the actual comment that is uploaded by a user about a specific trail
	 * @var string $commentPost
	 */
	private $commentText;

	/**
	 * constructor for this comment
	 * @param mixed $newCommentId id of this comment or null if a new comment
	 * @param int $newTrailId id of the trail that is associated with this coomment
	 * @param int $newUserId id of the user that sent this comment
	 * @param string $newBrowser the browser associated with the user who posted the comment
	 * @param datetime $newCreateDate the date time the comment was created
	 * @param binary $newIpAddress associated with the user that posted the comment.
	 * @param string $newCommentPhoto link of the photo, the user posted in the comment thread, about the trail.
	 * @param string $newCommentPhotoType file type of the photo that was uploaded by the user that posted in the comment thread about the  trail..
	 * @param string $newCommentText the actual comment the user posted in the comment forum about a specif trail.
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown (foo only needed if more than three exceptions are thrown
	 */
	public function __construct($newCommentId, $newTrailId, $newUserId, $newBrowser, $newCreateDate, $newIpAddress, $newCommentPhoto, $newCommentPhotoType, $newCommentText) {
		try {
			$this->setCommentId($newCommentId);
			$this->setTrailId($newTrailId);
			$this->setUserId($newUserId);
			$this->setBrowser($newBrowser);
			$this->setCreateDate($newCreateDate);
			$this->setIpaddress($newIpAddress);
			$this->setCommentPhoto($newCommentPhoto);
			$this->setCommentPhotoType($newCommentPhotoType);
			$this->setCommentText($newCommentText);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			// rethrow generic exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for comment id
	 *
	 * @return mixed value of comment id
	 */
	public function getCommentId() {
		return($this->commentId);
	}
	/**
	 *mutator method for comment id
	 *
	 * @param mixed $newCommentId new value of comment Id
	 * @throws InvalidArgumentException if $newCommentId is not an integer
	 * @throws RangeException if $newCommentId is not positive
	 */
	public function setCommentId($newCommentId){
		//base case: if the id is null, this is a new tweet without a mySQl assign id (yet)
		if($newCommentId === null) {
			$this->commentId = null;
			return;
		}

		//verify the tweet id is valid
		$newCommentId = filter_var($newCommentId, FILTER_VALIDATE_INT);
		if($newCommentId === false) {
			throw(new InvalidArgumentException("comment is not a valid integer"));
		}
		// verify the comment id is positive
		if ($newCommentId <= 0) {
			throw(new RangeException("comment id is not positive"));
		}
		// convert and store the comment id
		$this->commentId = intval($newCommentId);
	}

	/**
	 * accessor method for trail id
	 *
	 * @return int value of trail id
	 */
	public function getTrailId() {
		return $this->trailId;
	}
	/**
	 * mutator method for trail id
	 *
	 * @param int $newTrailId new value of trail id
	 * @throws InvalidArgumentException if $newTrail id is not an integer or not positive
	 * @throws RangeException if $newProfileId is not an integer or not positive
	 */
	public function setTrailId($newTrailId) {
		// verify the trail id is valid
		$newTrailId = filter_var($newTrailId, FILTER_VALIDATE_INT);
		if($newTrailId === false) {
			throw(new InvalidArgumentException("trail id is not a valid integer"));
		}

		// verify the trail id is positive
		if($newTrailId <= 0) {
			throw(new RangeException("trail id is not positive"));
		}

		//convert and store the trail id
		$this->trailId = intval($newTrailId);
	}
	 /**
	  * accessor method for user id
	  *
	  * @return int value of user id
	  */
	public function getUserId() {
		return $this->userId;
	}
	/**
	 * mutator method for user id
	 *
	 * @param int $newUserId new value of user id
	 * @throws InvalidArgumentException if $newUserId is not an integer or not positive
	 * @throws RangeException if $newUserId is not positive
	 */
	public function setUserId($newUserId) {
		// verify the user id is valid
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if($newUserId === false){
			throw(new InvalidArgumentException("profile id is not a valid integer"));
		}

		// verify the user id is positive
		if($newUserId <= 0) {
			throw(new RangeException('trail id is not positive'));
		}

		//convert and store the user id
		$this->userId = intval($newUserId);
	}
	/**
	 *accessor method for comment photo file extension
	 *
	 * @return string value of comment photo file extension
	 */
	public function getCommentPhoto() {
		return $this->commentPhoto;
	}
	/**
	 *mutator method for comment photo file extension
	 *
	 * @param string $newCommentPhoto new value of photo file extension
	 * @throws InvalidArgumentException if $newCommentPhoto is not a string or insecure
	 * @throws RangeException if comment photo  link is larger than > 256
	 */
	public function setCommentPhoto($newCommentPhoto) {
		// verify if comment photo path is secure
		$newCommentPhoto = trim($newCommentPhoto);
		$newCommentPhoto = filter_var($newCommentPhoto, FILTER_SANITIZE_STRING);
		if (empty($newCommentPhoto) === true ) {
			throw(new InvalidArgumentException("comment photo path is empty or insecure"));

		}

		//verify the comment photo path is the correct length to fit into the
		if(strlen($newCommentPhoto) > 256) {
			throw (new RangeException("comment photo  file path is to long"));
		}

		// store the file path of the comment photo
		$this->commentPhoto = $newCommentPhoto;
	}
	/**
	 * accessor method for comment photo type
	 *
	 * @return string value of the comment photo type.
	 */
	public function getCommentPhotoType() {
		return $this->commentPhotoType;
	}
	/**
	 * mutator method for comment photo type
	 *
	 * @param string $newCommentPhotoType new value of the comment photo type
	 * @throws InvalidArgumentException if $newCommentPhotoType is not supported file type
	 */
	public function setCommentPhotoType($newCommentPhotoType) {
		//verify the photo file type is supported
		$goodFileType = ["image/png", "image/jpeg"];
		if(in_array($goodFileType, $newCommentPhotoType) === false) {
			throw (new InvalidArgumentException("comment photo file type not supported"));
		}
		// store the comment photo type
		$this->commentPhotoType = $newCommentPhotoType;
	}

	 //method $foo("cry in a") = $bar("hole till rip"); place holder will come back to change to upload photos method
	/**
	 * accessor method for comment text
	 *
	 * @return string value of comment text
	 */
	publ














}





