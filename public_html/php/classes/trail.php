<?php
require_once(dirname(dirname(__DIR__))."/autoload.php");

/**
 * Class trail for the website TrailQuail.com
 * This class can be used for any trail mapping application
 * The Trail class contains 18 attributes as follows:
 *
 * trailId, the primary key
 * trailUuid
 * submitTrailId
 * userId
 * browser
 * createDate
 * ipAddress
 * trailAccessibility
 * trailAmenities
 * trailCondition
 * trailDescription
 * trailDifficulty
 * trailDistance
 * antiAbuse
 * trailSubmissionType
 * trailTerrain
 * trailName
 * trailTraffic
 * trailUse
 *
 *
 * @author Trail Quail <trailquailabq@gmail.com>
 **/
class Trail {
		use AntiAbuse;
		/**
		 * id for the trail; as stated above, this is the primary key
		 * @var int trailId
		 **/
		private $trailId;
		/**
		 * id for the submission on the trail object. Exists so the primary key does not have to get updated.
		 * @var int trailUuId
		 **/
		private $trailUuId;
		/**
		 * id for the content of the submission of the trail object
		 * @var int submitTrailID
		 **/
		private $submitTrailId;
		/**
		 * id of user that submits to the trail
		 * @var int userId
		 **/
		private $userId;
		/**
		 * log browser type
		 * @var string browser
		 **/
		private $browser;
		/**
		 * log date
		 * @var datetime createDate
		 **/
		private $createDate;
		/**
		 *log ip address
		 *@var int $ipAddress
		 **/
		private $ipAddress;
		/**
		 * information on accessibility of trail
		 * @var string trailAccessibility
		 **/
		private $trailAccessibility;
		/**
		 *information on amenities on trail
		 * @var string trailAmenities
		 */
		private $trailAmenities;
		/**
		 * information on the trail condition
		 * @var string trailConditions
		 **/
		private $trailCondition;
		/**
		 * information describing the trail
		 * @var string trailDescription
		 **/
		private $trailDescription;
		/**
		 * difficulty rating of trail
		 * @var int trailDifficulty
		 **/
		private $trailDifficulty;
		/**
		 * length of the trail
		 * @var int trailDistance
		 **/
		private $trailDistance;
		/**
		 * name of trail
		 * @var string trailName
		 **/
		private $trailName;
		/**
		 * content of submission made to trail
		 * @var int trailSubmissionType
		 **/
		private $trailSubmissionType;
		/**
		 * type of terrain on the trail
		 * @var string trailTerrain
		 **/
		private $trailTerrain;
		/**
		 *amount of traffic on trail
		 *@var string trailTraffic
		 **/
		private $trailTraffic;
		/**
		 * main use of the trail (hiking, cycling, skiing)
		 * @var string trailUse
		 **/
		private $trailUse;

		/**
		 *constructor for trail object.
		 *
		 *
		 * @param $newTrailId
		 * @param $newTrailUuId
		 * @param $newSubmitTrailId
		 * @param $newUserId
		 * @param $newBrowser
		 * @param $newIpAddress
		 * @param $newCreateDate
		 * @param $newTrailAccessibility
		 * @param $newTrailAmenities
		 * @param $newTrailCondition
		 * @param $newTrailDescription
		 * @param $newTrailDifficulty
		 * @param $newTrailDistance
		 * @param $newTrailSubmissionType
		 * @param $newTrailTerrain
		 * @param $newTrailName
		 * @param $newTrailTraffic
		 * @param $newTrailUse
		 * @param $newTrailUuId
		 * @throws InvalidArgumentException if data types are not valid
		 * @throws RangeException if values are out of bounds
		 * @throws Exception if some other exception is thrown
		 **/
		public function __construct($newTrailId, $newTrailUuId, $newSubmitTrailId, $newUserId,$newBrowser, $newCreateDate,
		$newIpAddress, $newTrailAccessibility,$newTrailAmenities, $newTrailCondition, $newTrailDescription, $newTrailDifficulty,
		$newTrailDistance, $newTrailSubmissionType, $newTrailTerrain, $newTrailName, $newTrailTraffic, $newTrailUse, $newTrailUuid) {
			try{
				$this->setTrailId($newTrailId);
				$this->setTrailUuId($newTrailUuId);
				$this->setSubmitTrailId($newSubmitTrailId);
				$this->setUserId($newUserId);
				$this->setBrowser($newBrowser);
				$this->setCreateDate($newCreateDate);
				$this->setIpAddress($newIpAddress);
				$this->setTrailAccessibility($newTrailAccessibility);
				$this->setTrailAmenities($newTrailAmenities);
				$this->setTrailCondition($newTrailCondition);
				$this->setTrailDescription($newTrailDescription);
				$this->setTrailDifficulty($newTrailDifficulty);
				$this->setTrailDistance($newTrailDistance);
				$this->setTrailSubmissionType($newTrailSubmissionType);
				$this->setTrailTerrain($newTrailTerrain);
				$this->setTrailName($newTrailName);
				$this->setTrailTraffic($newTrailTraffic);
				$this->setTrailUse($newTrailUse);
			}catch(InvalidArgumentException $invalidArgument){
					//rethrow the exception to the caller
					throw(new InvalidArgumentException($invalidArgument->getMessage(),0,$invalidArgument));
			}catch(RangeException $range){
					//rethrow the exception to the caller
					throw(new RangeException($range->getMessage(),0,$range));
			}catch(Exception $exception){
					//rethrow the exception to the caller
					throw(new exception($exception->getMessage(),0,$exception));
			}
	}

		/**
		 * accessor method for trailId
		 *
		 * @return mixed value of trailId
		**/
			public function getTrailId() {
				return ($this->trailId);
			}

		/**
		 * mutator method for trailId
		 *
		 * @param mixed $newTrailId
		 **/
			public function setTrailId($newTrailId){
				$this->trailId = Filter::filterInt($newTrailId,"Trail Id",true);
			}

		/**
		 * accessor method for trailUuId
		 *
		 * @return int value of trailUuId
		 **/
			public function getTrailUuId(){
				return ($this->trailUuId);
		}

		/**
		 * mutator method for trailUuId
		 *
		 * @param string $newTrailUuId
		 **/
			public function setTrailUuId($newTrailUuId){
				$this->trailUuId = Filter::filterString($newTrailUuId,"Trail UuId",36);
			}

		/**
		 * accessor method for submitTrailId
		 *
		 * @return int value of submitTrailId
		**/
			public function getSubmitTrailId() {
				return ($this->submitTrailId);
			}

		/**
		 * mutator method for submitTrailId
		 *
		 * @param int $newSubmitTrailId
		 **/
			public function setSubmitTrailId($newSubmitTrailId) {
				$this->submitTrailId = Filter::filterInt($newSubmitTrailId, "Submit Trail Id", true);
			}

		/**
		 * accessor method for userId
		 *
		 * @return int value of userId
		 **/
			public function getUserId() {
				return $this->userId;
			}

		/**
		 * mutator method for userId
		 *
		 * @param int $newUserId
		 **/
			public function setUserId($newUserId){
				$this->userId = Filter::filterInt($newUserId,"User Id",false);
			}

		/**
		 * accessor method for browser
		 *
		 * @return string browser
		 **/
			public function getBrowser(){
				return $this->browser;
		}

		/**
		 * mutator method for browser
		 *
		 * @param string $newBrowser new value of browser
		 * @throws UnexpectedValueException if $newBrowser is not a string or is insecure
		 * @throws LengthException if $newBrowser is more than 128 characters long
		 **/
			public function setBrowser($newBrowser) {
				$newBrowser = trim($newBrowser);
				$newBrowser = filter_var($newBrowser, FILTER_SANITIZE_STRING);
				if(empty($newBrowser) === true) {
					throw(new UnexpectedValueException("browser field is empty"));
				} else if(strlen($newBrowser) > 128) {
					throw(new LengthException("browser string length is too long"));
				}
				$this->browser = $newBrowser;
		}

		/**
		 * accessor method for createDate
		 *
		 * @return datetime createDate
		 **/
			public function getCreateDate(){
				return $this->createDate;
		}

		/**
		 * mutator method for createDate
		 *
		 * @param DateTime $newCreateDate new value of createDate
		 * @throws InvalidArgumentException if $newCreateDate is not a valid object or string
		 * @throws RangeException if $newCreateDate is a date that does not exist
		 * @throws Exception if $newCreateDate is
		 **/
		public function setCreateDate($newCreateDate) {
			if($newCreateDate === null) {
				$this->createDate = new DateTime();
			}

			try {
				$newCreateDate = validateDate($newCreateDate);
			} catch(InvalidArgumentException $invalidArgument) {
				throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
			} catch(RangeException $range) {
				throw(new RangeException($range->getMessage(), 0, $range));
			} catch(Exception $exception) {
				throw(new Exception($exception->getMessage(), 0, $exception));
			}
			$this->createDate = $newCreateDate;
		}

		/**
		 * accessor method for ipAddress
		 *
		 * @return int ipAddress
		 **/
		public function getIpAddress() {
			return $this->ipAddress;
		}

		/**
		 * mutator method for ipAddress
		 *
		 * @param string $newIpAddress new value of ipAddress
		 * @throws UnexpectedValueException if $newIpAddress is not valid
		 **/
		public function setIpAddress($newIpAddress) {
			if (inet_pton($newIpAddress) !== false) {
				$newIpAddress = inet_pton($newIpAddress);
			} else if(inet_ntop($newIpAddress) === false) {
				throw(new UnexpectedValueException("ipAddress is not valid"));
			}
			$this->ipAddress = $newIpAddress;
		}
		/**
		 * accessor method for trailAccessibility
		 *
		 * @return string value of trailAccessibility
		 **/
			public function getTrailAccessibility() {
				return ($this->trailAccessibility);
			}
		/**
		 *mutator method for trailAccessibility
		 *
		 *@param string $newTrailAccessibility new value of trailAccessibility
		 **/
			public function setTrailAccessibility($newTrailAccessibility) {
				$this->trailAccessibility = Filter::filterString($newTrailAccessibility,"Trail Accessibility", 256);
			}
		/**
		 * accessor method for trailAmenities
		 *
		 * @return string value of trailAmenities
		 **/
			public function getTrailAmenities() {
				return ($this->trailAmenities);
			}
		/**
		 *mutator method for trailAmenities
		 *
		 *@param string $newTrailAmenities information on trail amenities
		 **/
			public function setTrailAmenities($newTrailAmenities) {
			$this->trailAmenities = Filter::filterString($newTrailAmenities,"Trail Amenities", 256);
			}
		/**
		 * accessor method for trailCondition
		 *
		 * @return string value of trailCondition
		 **/
			public function getTrailCondition() {
				return ($this->trailCondition);
			}
		/**
		 * mutator method for trailCondition
		 *
		 * @param string $newTrailCondition information on trail condition
		 **/
			public function setTrailCondition($newTrailCondition) {
				$this->trailCondition = Filter::filterString($newTrailCondition,"Trail Condition", 256);
			}
		/**
		 * accessor method for trailDescription
		 *
		 * @return string value of trailDescription
		 **/
			public function getTrailDescription() {
				return ($this->trailDescription);
			}
		/**
		 * mutator method for trailDescription
		 *
		 *@param string $newTrailDescription information describing the trail
		 **/
			public function setTrailDescription($newTrailDescription) {
				$this->trailDescription = Filter::filterString($newTrailDescription,"Trail Description", 512);
			}
		/**
		 * accessor method for trailDifficulty
		 *
		 * @return int value of trailDifficulty
		 **/
			public function getTrailDifficulty() {
				return ($this->trailDifficulty);
			}
		/**
		 * mutator method for trailDifficulty
		 *
		 * @param int $newTrailDifficulty
		 **/
			public function setTrailDifficulty($newTrailDifficulty){
				$this->trailDifficulty = Filter::filterInt ($newTrailDifficulty,"Trail Difficulty", true);
			}
		/**
		 * accessor method for trailDistance
		 *
		 * @return int value of trailDistance
		 **/
			public function getTrailDistance() {
				return ($this->trailDistance);
			}
		/**
		 *mutator method for trailDistance
		 *
		 * @param int $newTrailDistance
		 **/
		public function setTrailDistance($newTrailDistance) {
			$this->trailDistance = Filter::filterDouble($newTrailDistance, "Trail Distance");
		}
		/**
		 * accessor method for trailName
		 *
		 * @return string value of trailName
		 **/
		public function getTrailName() {
			return($this->trailName);
		}
		/**
		 * mutator method for trailName
		 *
		 * @param $newTrailName
		 * @return string
		 **/
		public function setTrailName($newTrailName) {
			$this->$newTrailName = Filter::filterString($newTrailName, "Trail Name", 64);
		}
		/**
		 * accessor method for trailSubmissionType
		 *
		 * @return int value of trailSubmissionType
		 */
			public function getTrailSubmissionType() {
				return ($this->trailSubmissionType);
			}
		/**
		 * mutator method for trailSubmissionType
		 *
		 * @param int
		 * @return int
		**/
			public function setTrailSubmissionType($newTrailSubmissionType){
				$newTrailSubmissionType = filter_var($newTrailSubmissionType, FILTER_VALIDATE_INT);
				if($newTrailSubmissionType === false) {
					throw(new InvalidArgumentException("Trail Submission Type is not a valid integer"));
				}

				// Verify the new int is positive
				if($newTrailSubmissionType < 0) {
					throw(new RangeException("Trail Submission Type not positive"));
				}

				// Make sure the int is not greater than 2
				if($newTrailSubmissionType > 2) {
					throw(new InvalidArgumentException("Trail Submission Type cannot be greater than 2"));
				}

				//convert and store the trail submission type
				$this->trailSubmissionType=intval($newTrailSubmissionType);
			}
		/**
		 * accessor method for trailTerrain
		 *
		 *@return string value of trailTerrain
		 */
			public function getTrailTerrain() {
				return ($this->trailTerrain);
			}
		/** mutator method for trailTerrain
		 *
		 * @param string
		**/
			public function setTrailTerrain($newTrailTerrain) {
			$this->$newTrailTerrain = Filter::filterString($newTrailTerrain,"Trail Terrain", 128);
			}

		/**
		 * accessor method for trailTraffic
		 *
		 * @return string value of trailTraffic
		**/
			public function getTrailTraffic() {
				return($this->trailTraffic);
			}
		/**
		 * mutator method for trailTraffic
		 *
		 * @param string
		**/
			public function setTrailTraffic($newTrailTraffic) {
				$this->$newTrailTraffic = Filter::filterString($newTrailTraffic,"Trail Traffic", 16);
			}
		/**
		 * accessor method for trailUse
		 *
		 * @return string value of trailUse
		**/
			public function getTrailUse(){
				return($this->trailUse);
			}
		/**
		 * mutator method for trailUse
		**/
			public function setTrailUse($newTrailUse) {
				$this->$newTrailUse = Filter::filterString($newTrailUse,"Trail Use",64);
			}

		/**
		 * inserts this trail into mySQL
		 *
		 * @param PDO $pdo pointer to PDO connection, by reference
		 * @throws PDOException when mySQL related errors occur
		**/
		public function insert(PDO &$pdo) {
			if($this->trailId !== null) {
				throw (new PDOException("not a new trail"));
			}

			//create query template
			$query = "INSERT INTO trail(userId, submitTrailId, browser, createDate, ipAddress,
trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid) VALUES (:userId, :submitTrailId, :browser, :createDate,
:ipAddress, :trailAccessibility, :trailAmenities, :trailCondition, :trailDescription, :trailDifficulty, :trailDistance,
:trailSubmissionType, :trailTerrain, :trailName, :trailTraffic, :trailUse, :trailUuid)";
				$statement = $pdo->prepare($query);

				//bind the member variables to the placeholders in the template
				$parameters = array("userid" => $this->getUserId(), "submitTrailId" => $this->getTrailId(), "browser" => $this->getBrowser(),
"createDate" => $this->getCreateDate(), "ipAddress" => $this->getIpAddress(), "trailAccessibility" => $this->getTrailAccessibility(), "trailAmenities" => $this->getTrailAmenities(),
"trailCondition" => $this->getTrailCondition(), "trailDescription" =>$this->getTrailDescription(), "trailDifficulty" =>$this->getTrailDifficulty(), "trailDistance" =>$this->getTrailDistance(),
"trailSubmissionType" =>$this->getTrailSubmissionType(), "trailTerrain" =>$this->getTrailTerrain(), "trailName" =>$this->getTrailName(), "trailTraffic" =>$this->getTrailTraffic(),
"trailUse" =>$this->getTrailUse(), "trailUuid" =>$this->getTrailUuId());
				$statement = $pdo->prepare($query);

				//update the null trailId with what mySQL has generated
				$this->setTrailId(intval($pdo->lastInsertId()));
			}

			/**
			 * Deletes this trail from mySQL
			 *
			 * @param PDO $pdo pointer to PDO connection, by reference
			 * @throws PDOException when mySQL related errors occur
			**/
			public function delete(PDO &$pdo) {
				//make sure this trail already exists
				if($this->getTrailId() === null) {
					throw(new PDOException("Unable to delete a restaurant that does not exist"));
				}

				//create query template
				$query = "DELETE FROM trail WHERE trailId = :trailId";
				$statement = $pdo->prepare($query);

				//bind the member variables to the placeholders in the templates
				$parameters
			}

			/**
			 * updates this trail in mySQL
			 *
			 * @param PDO $pdo pointer to PDO connection, by reference
			 * @throws PDOException when mySQL related errors occur
			**/
			public function update(PDO &$pdo) {
				//make sure this trail exists
				if($this->getTrailId() === null) {
					throw(new PDOException ("unable to update a trail that does not exist"));
				}

				//create a query template
				$query ="UPDATE trail SET userId =:userId, submitTrailId =:submitTrailId, browser =:browser, createDate =:createDate, ipAddress =:ipAddress,
trailAccessibility =:trailAccessibility, trailAmenities =:trailAmenities, trailCondition =:trailCondition, trailDescription =:trailDescription, trailDifficulty =:trailDifficulty,
trailDistance =:trailDistance, trailSubmissionType =:trailSubmissionType,trailTerrain =:trailTerrain, trailName =:trailName, trailTraffic =:trailTraffic, trailUse =:trailUse, trailUuid =:trailUuid";
				$statement =$pdo->prepare($query);

				//bind the member variables to the placeholders in the templates
				$parameters = array("userid" => $this->getUserId(), "submitTrailId" => $this->getTrailId(), "browser" => $this->getBrowser(),
				"createDate" => $this->getCreateDate(), "ipAddress" => $this->getIpAddress(), "trailAccessibility" => $this->getTrailAccessibility(), "trailAmenities" => $this->getTrailAmenities(),
				"trailCondition" => $this->getTrailCondition(), "trailDescription" =>$this->getTrailDescription(), "trailDifficulty" =>$this->getTrailDifficulty(), "trailDistance" =>$this->getTrailDistance(),
				"trailSubmissionType" =>$this->getTrailSubmissionType(), "trailTerrain" =>$this->getTrailTerrain(), "trailName" =>$this->getTrailName(), "trailTraffic" =>$this->getTrailTraffic(),
				"trailUse" =>$this->getTrailUse(), "trailUuid" =>$this->getTrailUuId());
				$statement->execute($parameters);
			}

		/**
		 * gets the trail by trailId
		 *
		 * @param PDO $pdo pointer to PDO connection, by reference
		 * @param int $trailId trailID to search for
		 * @return mixed trail found or null if not found
		 * @throws PDOException when mySQL related errors occur
		 *
		**/
	public static function getTrailById (PDO &$pdo, $trailId) {
		//sanitize the id before searching
		try {
			$trailId = Filter::filterInt($trailId, "trailId");
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT userId, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE trailId = :trailId";
		$statement = $pdo->prepare($query);

		//bind trailId to placeholder
		$parameters = array("trailId" => $trailId);
		$statement->execute($parameters);

		//grab the trail from mySQL
		try {
			$trail = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if($row !== false) {
				//new trail ($trailId, $userId, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail ($row["trailId"], $row["userId"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
			$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
			$row["trailUse"], $row["trailUuid"]);
			}
			}catch (Exception $e) {
			//if the row could not be converted, rethrow it
			throw (new PDOException($e->getMessage(), 0, $e));
		}

		return($trail);
	}

	/**
	 * gets the trail by userId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $userId userId to search for
	 * @return mixed trail found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 *
	 **/
	public static function getTrailByUserId (PDO &$pdo, $userId) {
		//sanitize the id before searching
		try {
			$userId = Filter::filterInt($userId, "userId");
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT userId, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		//bind userId to placeholder
		$parameters = array("userId" => $userId);
		$statement->execute($parameters);

		//build an array of trails
		$trails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		While (($row = $statement->fetch()) !== false) {
			try {
				//new trail ($trailId, $userId, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail($row["trailId"], $row["userId"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
						$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
						$row["trailUse"], $row["trailUuid"]);
				$trails[$trails->key()] = $trail;
				$trails->next();
			} catch (Exception $e) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($e->getMessage(),0 , $e));
			}
		}
		return($trails);
	}

	/**
	 * gets the trail by submitTrailId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $submitTrailId submitTrailId to search for
	 * @return mixed trail found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 *
	 **/
	public static function getTrailBysubmitTrailId (PDO &$pdo, $submitTrailId) {
		//sanitize the id before searching
		try {
			$submitTrailId = Filter::filterInt($submitTrailId, "submitTrailId");
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT userId, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE submitTrailId = :submitTrailId";
		$statement = $pdo->prepare($query);

		//bind submitTrailId to placeholder
		$parameters = array("submitTrailId" => $submitTrailId);
		$statement->execute($parameters);

		//build an array of trails
		$trails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		While (($row = $statement->fetch()) !== false) {
			try {
				//new trail ($trailId, $userId, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail($row["trailId"], $row["userId"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
						$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
						$row["trailUse"], $row["trailUuid"]);
				$trails[$trails->key()] = $trail;
				$trails->next();
			} catch (Exception $e) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($e->getMessage(),0 , $e));
			}
		}
		return($trails);
	}

	/**
	 * gets the trail by browser
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $browser browser to search for
	 * @return mixed trail found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 *
	 **/
	public static function getTrailByBrowser (PDO &$pdo, $browser) {
		//sanitize the id before searching
		try {
			$browser = Filter::filterString($browser, "browser", 128);
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT browser, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE browser = :browser";
		$statement = $pdo->prepare($query);

		//bind browser to placeholder
		$parameters = array("browser" => $browser);
		$statement->execute($parameters);

		//build an array of trails
		$trails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		While (($row = $statement->fetch()) !== false) {
			try {
				//new trail ($trailId, $userId, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail($row["trailId"], $row["createDate"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
						$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
						$row["trailUse"], $row["trailUuid"]);
				$trails[$trails->key()] = $trail;
				$trails->next();
			} catch (Exception $e) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($e->getMessage(),0 , $e));
			}
		}
		return($trails);
	}

	/**
	 * gets the trail by createDate
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $createDate createDate to search for
	 * @return mixed trail found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 *
	 **/
	public static function getTrailByCreateDate (PDO &$pdo, $createDate) {
		//sanitize the id before searching
		try {
			$createDate = Filter::filterDate($createDate, "createDate");
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT userId, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE createDate = :createDate";
		$statement = $pdo->prepare($query);

		//bind createDate to placeholder
		$parameters = array("createDate" => $createDate);
		$statement->execute($parameters);

		//build an array of trails
		$trails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		While (($row = $statement->fetch()) !== false) {
			try {
				//new trail ($trailId, $userId, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail($row["trailId"], $row["ipAddress"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
						$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
						$row["trailUse"], $row["trailUuid"]);
				$trails[$trails->key()] = $trail;
				$trails->next();
			} catch (Exception $e) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($e->getMessage(),0 , $e));
			}
		}
		return($trails);
	}

	/**
	 * gets the trail by ipAddress
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $ipAddress ipAddress to search for
	 * @return mixed trail found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 *
	 **/
	public static function getTrailByIpAddress (PDO &$pdo, $ipAddress) {
		//sanitize the id before searching
		try {
			$IpAddress = Filter::filterInt($ipAddress, "ipAddress");
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT userId, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE IpAddress = :IpAddress";
		$statement = $pdo->prepare($query);

		//bind IpAddress to placeholder
		$parameters = array("IpAddress" => $IpAddress);
		$statement->execute($parameters);

		//build an array of trails
		$trails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		While (($row = $statement->fetch()) !== false) {
			try {
				//new trail ($trailId, $userId, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail($row["trailId"], $row["trailAccessibility"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
						$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
						$row["trailUse"], $row["trailUuid"]);
				$trails[$trails->key()] = $trail;
				$trails->next();
			} catch (Exception $e) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($e->getMessage(),0 , $e));
			}
		}
		return($trails);
	}

	/**
	 * gets the trail by trailAccessibility
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $trailAccessibility trailAccessibility to search for
	 * @return mixed trail found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 *
	 **/
	public static function getTrailByTrailAccessibility (PDO &$pdo, $trailAccessibility) {
		//sanitize the id before searching
		try {
			$trailAccessibility = Filter::filterString($trailAccessibility, "trailAccessibility", 256);
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT userId, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE trailAccessibility = :trailAccessibility";
		$statement = $pdo->prepare($query);

		//bind trailAccessibility to placeholder
		$parameters = array("trailAccessibility" => $trailAccessibility);
		$statement->execute($parameters);

		//build an array of trails
		$trails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		While (($row = $statement->fetch()) !== false) {
			try {
				//new trail ($trailId, $trailAmenities, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail($row["trailId"], $row["userId"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
						$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
						$row["trailUse"], $row["trailUuid"]);
				$trails[$trails->key()] = $trail;
				$trails->next();
			} catch (Exception $e) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($e->getMessage(),0 , $e));
			}
		}
		return($trails);
	}

	/**
	 * gets the trail by trailAmenities
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $trailAmenities trailAmenities to search for
	 * @return mixed trail found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 *
	 **/
	public static function getTrailByTrailAmenities (PDO &$pdo, $trailAmenities) {
		//sanitize the id before searching
		try {
			$trailAmenities = Filter::filterString($trailAmenities, "trailAmenities", 256);
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT trailAmenities, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE trailAmenities = :trailAmenities";
		$statement = $pdo->prepare($query);

		//bind trailAmenities to placeholder
		$parameters = array("trailAmenities" => $trailAmenities);
		$statement->execute($parameters);

		//build an array of trails
		$trails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		While (($row = $statement->fetch()) !== false) {
			try {
				//new trail ($trailId, $userId, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail($row["trailId"], $row["userId"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
						$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
						$row["trailUse"], $row["trailUuid"]);
				$trails[$trails->key()] = $trail;
				$trails->next();
			} catch (Exception $e) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($e->getMessage(),0 , $e));
			}
		}
		return($trails);
	}

	/**
	 * gets the trail by trailCondition
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $trailCondition trailCondition to search for
	 * @return mixed trail found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 *
	 **/
	public static function getTrailByTrailCondition (PDO &$pdo, $trailCondition) {
		//sanitize the id before searching
		try {
			$trailCondition = Filter::filterString($trailCondition, "trailCondition", 256);
		} catch (InvalidArgumentException $invalidArgument ) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range){
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch (Exception $exception){
			throw(new PDOException($exception->getMessage(), 0, $exception);
		}

		//create query template
		$query = "SELECT trailAmenities, submitTrailId, browser, createDate, ipAddress,trailAccessibility, trailAmenities, trailCondition,trailDescription, trailDifficulty, trailDistance, trailSubmissionType,
trailTerrain, trailName, trailTraffic, trailUse, trailUuid FROM trail WHERE trailCondition = :trailCondition";
		$statement = $pdo->prepare($query);

		//bind trailCondition to placeholder
		$parameters = array("trailCondition" => $trailCondition);
		$statement->execute($parameters);

		//build an array of trails
		$trails = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		While (($row = $statement->fetch()) !== false) {
			try {
				//new trail ($trailId, $userId, $submitTrailId, $browser, $createDate, $ipAddress, $trailAccessibility, $trailAmenities, $trailCondition,$trailDescription, $trailDifficulty, $trailDistance, $trailSubmissionType,$trailTerrain, $trailName, $trailTraffic, $trailUse, $trailUuid)
				$trail = new Trail($row["trailId"], $row["userId"], $row["submitTrailId"], $row["browser"], $row["createDate"], $row["ipAddress"], $row["trailAccessibility"], $row["trailAmenities"],
						$row["trailCondition"], $row["trailDescription"], $row["trailDifficulty"], $row["trailDistance"], $row ["trailSubmission"], $row["trailTerrain"], $row["trailName"], $row["trailTraffic"],
						$row["trailUse"], $row["trailUuid"]);
				$trails[$trails->key()] = $trail;
				$trails->next();
			} catch (Exception $e) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($e->getMessage(),0 , $e));
			}
		}
		return($trails);
	}
}