<?php

require_once(dirname(__DIR__)  .  "/traits/anti-abuse.php");
require_once "autoload.php";

/**
 cross section of trail quail that is user submitted comments
 *
 * this feature will be a comment thread that will allow for users to communicate important information about the trail,
 * to have conversations about hiking, to upload photos, and to get official information from the city about the trail
 *
 *@author George Kephart <gkephart@cnm.edu>
 */
class comment {
	use AntiAbuse;
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
	 * @param string $newIpAddress associated with the user that posted the comment.
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
		return ($this->commentId);
	}

	/**
	 *mutator method for comment id
	 *
	 * @param mixed $newCommentId new value of comment Id
	 * @throws InvalidArgumentException if $newCommentId is not an integer
	 * @throws RangeException if $newCommentId is not positive
	 */
	public function setCommentId($newCommentId) {
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
		if($newCommentId <= 0) {
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
		if($newUserId === false) {
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
		if(empty($newCommentPhoto) === true) {
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
	 *
	 * /**
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

	/**
	 * @param string $inputTagName
	 * @throws ErrorException if there was an upload error
	 * @throws InvalidArgumentException for invalid image type - must be jpeg or png
	 * @throws InvalidArgumentException for invalid file extension
	 * @throws error exception if createImage fails
	 * @throws error exception if image save fails
	 *
	 * @authur Derek-Mauldin
	 */
	public function uploadPhoto($inputTagName) {
		// if upload fails throw an error
		if($_FILES[$inputTagName] ["error"] !== UPLOAD_ERR_OK) {
			throw(new ErrorException("image upload error"));
		}
		// setup image type arrays
		$acceptedTypes = ["image/jpeg", "image/png"];
		$acceptedExt = ["jpeg", "png"];

		//grab data from $_FILES
		$imgType = $_FILES[$inputTagName] ["type"];
		$imgName = $_FILES[$inputTagName] ["name"];
		$imageFileName = $_FILES[$inputTagName] ["temp_name"];

		//setup extensions for verification
		$extension = end(explode(".", $imgName));
		$extension = strtolower($extension);

		// check image type
		if([$imgType, $acceptedTypes] === false) {
			throw(new InvalidArgumentException("invalid Image Type"));
		}

		// verify the extension
		if(in_array($extension, $acceptedExt) === "png") {
			throw(new InvalidArgumentException("invalid File Extension"));
		}

		//create image depending on the type
		if($extension === "png") {
			$img = imagecreatefrompng($imageFileName);
			$type = "image/png";
		} else {
			$img = imagecreatefromjpeg($imageFileName);
			$type = "image/jpeg";
		}

		// if image create failed throw exception
		if($img === false) {
			throw(new ErrorException("create image failed"));
		}

		//scale the uploaded photo
		imagescale($imageFileName, $new_width = 1024, [$mode = IMG_BILINEAR_FIXED]);

		// setup path name to store image
		$path = "/var/www/html/public_html/trailquail/trail-images-" . $this->commentId;

		// save image depending on type
		if($type === "image/png") {
			$path = $path . "png";
			$save = @imagepng($imageFileName, $path);
		} else {
			$path = $path . "jpeg";
			$save = @imagejpeg($imageFileName, $path);
		}

		if($save === false) {
			throw(new ErrorException("image save failed"));
		}

		// store photo data in this comment
		$this->setCommentPhoto($path);
		$this->setCommentPhotoType($type);

		//free up resources
		imagedestroy($imageFileName);

	}

	/**
	 * accessor method for comment text
	 *
	 * @return string value of comment text
	 */
	public function getCommentText() {
		return $this->commentText;
	}

	/**
	 *mutator method for comment photo file extension
	 *
	 * @param string $newCommentText new value of the actual comment text
	 * @throws InvalidArgumentException if $newCommentText is not a string or insecure
	 * @throws RangeException if comment text content is larger than > 256
	 */
	public function setCommentText($newCommentText) {
		// verify if comment text is not a string or insecure
		$newCommentText = trim($newCommentText);
		$newCommentText = filter_var($newCommentText, FILTER_SANITIZE_STRING);
		if(empty($newCommentText) === true) {
			throw(new InvalidArgumentException("comment photo path is empty or insecure"));
		}
		//verify the comment text is the correct length to fit into the database
		if(strlen($newCommentText) > 256) {
			throw (new RangeException("comment photo  file path is to long"));
		}
		// store the content of CommentText
		$this->commentText = $newCommentText;
	}

	/** inserts this comment into mySQL
	 *
	 * @param PDO $pdo PDo connection object
	 * @throws PDOException when MySQL related errors happen
	 */
	public function insert(PDO $pdo) {
		// enforce the commentId is null
		if($this->commentId !== null) {
			throw(new PDOException("not a new comment"));
		}
		// create query template
		$query = "INSERT INTO comment(trailId, userId, browser, createDate, ipAddress, commentPhoto, commentPhotoType, commentText ) VALUES (:trailId, :userId, :browser,:createDate, :ipAddress, :CommentPhoto, :commentPhotoType, :commentText)";
		$statement = $pdo->prepare($query);


		//Im going to treat ip address like its formatted i may have to change name


		//bind the member variables to the place holders in the template
		$formattedDate = $this->createDate->format("Y-m-d H:i:s");
		$parameters = ["trailId" => $this->trailId, "userId" => $this->userId, "browser" => $this->browser, "createDate" => $formattedDate, ["ipAddress" => $this->ipAddress], "commentPhoto" => $this->commentPhoto, "commentPhotoType " => $this->commentPhotoType, "commentText" => $this->commentText];
		$statement->execute($parameters);

		// update the null tweetId with what mySqL juat gave us
		$this->commentId = intval($pdo->lastInsertId());
	}

	/**
	 *deletes this Tweet from mySql
	 *
	 * @param PDO $pdo PDO connect object
	 * @throws PDOException when mySql related errors occur
	 */
	public function delete(PDO $pdo) {
		// enforce the commentId is not null (i.e., don't delete a tweet that hasn't been inserted)
		if($this->commentId === null) {
			throw(new PDOException("unable to delete a comment that does not exist"));
		}

		//create query template
		$query = "DELETE FROM comment WHERE commentId = :commentId ";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder in the template
		$parameters = ["commentId" => $this->commentId];
		$statement->execute($parameters);
	}

	/**
	 * updates this comment in mySQL
	 *
	 * @param PDO $pdo PDO connection object
	 * @throws PDOException when mySQL related errors occur
	 */
	public function update(PDO $pdo) {
		// enforce the comment id is not null
		if($this->commentId === null) {
			throw(new PDOException("unable to update a that does not exist"));
		}
		$query = "UPDATE comment SET trailId = :trailId, userid = :userId, browser = :browserId, createDate = :createDate, ipAddress = :ipAddress, commentPhoto = :commentPhoto, commentPhotoType = :commentPhotoType, commentText = :commentText ";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->createDate->format("Y-m-d H:i:s");
		$parameters = ["trailId" => $this->trailId, "userId" => $this->userId, "browser" => $this->browser, "createDate" => $formattedDate, "ipAddress" => $this->ipAddress, "commentPhoto" => $this->commentPhoto, "commentPhotoType " => $this->commentPhotoType, "commentText" => $this->commentText];
		$statement->execute($parameters);
	}

	/**
	 * gets the comment by content
	 *
	 * @param PDO $pdo PDO connection object
	 * @param string $commentText tweet content to search for
	 * @return SplFixedArray all tweets found for this search
	 * @throws PDOException when mySql related errors occur
	 */
	public static function getCommentByCommentText(PDO $pdo, $commentText) {
		// sanitize the description before searching
		$commentText = trim($commentText);
		$commentText = filter_var($commentText, FILTER_SANITIZE_STRING);
		if(empty($commentText) === true) {
			throw(new PDOException("comment text is invalid"));
		}
		//create query template
		$query = "SELECT commentId, trailId, userId, browser, createDate, ipAddress, commentPhoto, commentPhotoType, commentText WHERE tweetContent LIKE :tweetContent";
		$statement = $pdo->prepare($query);

		// bind the tweet content to the place holder in the template
		$commentText = "%$commentText%";
		$parameters = ["$commentText" => $parameters = ["commentText" => $commentText]];
		$statement->execute($parameters);

		// build an array of tweets
		$comments = new SplFixedarray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["trailId"], $row["userId"], $row["createDate"], $row["ipAddress"], $row["commentPhoto"], $row["commentType"], $row["commentText"]);
				$comments [$comments->key()] = $comment;
				$comments-> next();
			} catch(Exception $exception) {
				// if the couldn't be converted rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
	return($comments);
	}
	/**
	 * gets the comment by comment text
	 *
	 * @param PDO $pdo PDO connection object
	 * @param int $commentId comment id to search for
	 * @return mixed comment found or null if not found
	 * @throws PDOException when mySql related errors occur
	 */
	public static function getCommentByCommentId( PDO $pdo, $commentId) {
		// sanitize the tweetId before searching
		$commentId = filter_var($commentId, FILTER_VALIDATE_INT);
		if($commentId === false) {
			throw(new PDOException("comment id is not an integer"));
		}
		if($commentId <= 0) {
			throw(new PDOException("comment id is not positive"));
		}

		//create query template
		$query =  "SELECT commentId, trailId, userId, browser, createDate, ipAddress, commentPhoto, commentPhotoType, commentText WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		// bind the tweet id to the place holder in the template
		$parameters = array("commentId" => $commentId);
		$statement->execute($parameters);

		// grab the comment from mySQL
		try {
			$comment = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$comment = new Comment($row["commentId"]), ($row["trailId"]), ($row["userId"]), ($row["browser"]), ($row["createDate"]), ($row["IpAddress"]), ($row["commentPhoto"]), ($row["commentPhotoType"]), ($row["commentText"]);
			}
			} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($comment);
	}
}







