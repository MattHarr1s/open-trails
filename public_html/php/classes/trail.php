<?php
require_once(dirname(dirname(__DIR__))."");

/**
 * Class trail for the website TrailQuail.com
 * This class can be used for any trail mapping application
 * The Trail class contains 16 attributes as follows:
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
 * 11.antiAbuse
 * 12.trailSubmissionType
 * 13.trailTerrain
 * 14.trailName
 * 15.trailTraffic
 * 16.trailUse
 *
 *
 * When a new trail object is created it is automagically given the 16 attributes.
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
	 * Anti abuse trait
	 * @trait antiAbuse
	 **/
	private $antiAbuse;
	/**
	 * content of submission made to trail
	 * @var string trailSubmissionType
	 **/
	private $trailSubmissionType;
	/**
	 * type of terrain on the trail
	 * @var string trailTerrain
	 **/
	private $trailTerrain;
	/**
	 * name of trail
	 * @var string trailName
	 **/
	private $trailName;
	/**
	 * main use of the trail (hiking, cycling, skiing)
	 * @var string trailUse
	 **/
	private $trailUse;

	/**
	 *constructor for trail object.
	 *trail object contains the 16 attributes listed above.
	 *
	 * @param mixed $trailId of this trail or null if a new trail
	 * @param int $trailUuId id for the submission to the trail object. Exists so primary key doesn't get updated.
	 * @param int $submitTrailId identification of info submited to trail entity
	 * @param mixed $userId id of user that makes submission to trail entity
	 * @param string $trailAccessibility info on accessibility of trail
	 * @param string $trailAmenities info on amenities on trail
	 * @param string $trailCondition info on the condition of the trail
	 * @param string $trailDescription description of the trail
	 * @param int $trailDifficulty
	 * @param trait $antiAbuse
	 * @param string $trailSubmissionType content of the submission made to the trail
	 * @param string $trailTerrain terrain found on trail
	 * @param string $trailName common name of the trail
	 * @param int $trailTraffic rating of average volume of users on trail
	 * @param string $trailUse
	 * @throws InvalidArgumentException if data values are out of bounds
	 * @throws RangeException if data values are out of bounds
	 * @throws  Exception if some other exception is thrown
	 *
	 */
	public function __construct($newTrailId, $newTrailUuId, $newSubmitTrailId, $newUserId, $newTrailAccessibility,
	$newTrailAmenities, $newTrailCondition, $newTrailDescription, $newTrailDifficulty, $newTrailDistance, $newAntiAbuse,
	$newTrailSubmissionType, $newTrailTerrain, $newTrailName, $newTrailTraffic, $newTrailUse) {
		try{
			$this->setTrailId($newTrailId);
			$this->setTrailUuId($newTrailUuId);
			$this->setSubmitTrailId($newSubmitTrailId);
			$this->setUserId($newUserId);
			$this->setTrailAccessibility($newTrailAccessibility);
			$this->setTrailAmenities($newTrailAmenities);
			$this->setTrailCondition($newTrailCondition);
			$this->setTrailDescription($newTrailDescription);
			$this->setTrailDifficulty($newTrailDifficulty);
			$this->setTrailDistance($newTrailDistance);
			/matttodo/figure out $this->antiAbuse
			$this->setTrailSubmissionType($newTrailSubmissionType);
			$this->setTrailTerrain($newTrailTerrain);
			$this->setTrailName($newTrailName);
			$this->setTrailTraffic($newTrailTraffic);
			$this->setTrailUse($newTrailUse);
	}catch(invalidArgumentExcepton $invalidArgument){
			//rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(),0,$invalidArgument));
	}catch(rangeException $range){
			//rethrow the exception to the caller
			throw(new RangeException($range->getMessage(),0,$range));
	}catch(exception $exception){
			//rethrow the exception to the caller
			throw(new exception($exception->getMessage(),0,$exception));
		}
	}
/**
 * accessor method for trailId
 *
 * gains access to trailId for use by mutator method
 *
 * @return mixed value of trailId
**/
	public function getTrailId() {
		return ($this->trailId);
	}
/**
 * mutator method for trailId
 *
 * modifies values of trailId using access given by the accessor method.
 *
 * @param mixed $newTrailId
 * @throws InvalidArgumentException if $newTrailId is not an integer
 * @throws RangeException if $newTrailId is not positive
 **/
	public function setTrailId($newTrailId){
		//base case: if the trailId is null, this is a new trail without a  mySQL assigned (yet)
		if($newTrailId === null){
			$this->trailId = null;
			return;
		}
		//verify the trailId is valid
		$newTrailId = filter_var($newTrailId, FILTER_VALIDATE_INT);
		if($newTrailId=== false){
			throw(new InvalidArgumentException("trail id is not a valid integer"));
		}
		//verify the trailID is positive
		if($newTrailId <=0){
			throw(new RangeException("trail id is not positive"));
		}
		// convert and store the trailId
		$this->trailId = intval($newTrailId);
	}
/**
 * accessor method for trailUuId
 *
 * gains access to trailUuId
 *
 * @return int value of trailUuId
 */
	public function getTrailUuId(){
		return ($this->trailUuId);
}
/**
 * mutator method for trailUuId
 *
 * @param int $newTrailUuId
 * @throws InvalidArgumentException if $newTrailUuId is not an integer or not positive
 * @throws RangeException is $newTrailUuId is not positive
**/
	public function setTrailUuId($newTrailUuId){
		// verify the trailUuId is valid

	}
/**
 * accessor method for submitTrailId
 *
 * gains access to submitTrailId
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
	 * @throws InvalidArgumentException if $newSubmitTrailId is not an integer or not positive
	 * @throws RangeException if the $newSubmitTrailId is not positive
	**/
	public function setSubmitTrailId($newSubmitTrailId) {
		// verify the submitTrailId exists
		if($newSubmitTrailId === null){
			$this->submitTrailId = null;
			return;
		}
	//verify the submitTrailId is valid
	$newSubmitTrailId = filter_var($newSubmitTrailId, FILTER_VALIDATE_INT);
		if($newSubmitTrailId === false){
			throw(new InvalidArgumentException("submit trail id is not a valid integer"));
		}
	//verify the submitTrailId is positive
		if($newSubmitTrailId <= 0){
			throw(new RangeException("submit trail id is not positive"));
		}
	//convert and store the submitTrailId
		$this->submitTrailId = intval($newSubmitTrailId);
	}
/**
 * accessor method for userId
 *
 * gains access to userId
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
 * @throws InvalidArgumentException if $newUserId is not an integer or not positive
 * @throws RangeException if the $newUserId is not positive.
**/
	public function setUserId($newUserId){
		//verify the user id is valid
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if($newUserId === false){
			throw(new InvalidArgumentException("user id is not a valid integer"));
		}
		//verify the userId is positive
		if($newUserId<=0){
			throw(new RangeException("user id is not positive"));
		}
		//convert and store the user id
		$this->userId = intval($newUserId);
	}
/**
 * accessor method for trailAccessibility
 *
 * gains access to trailAccessibility
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
 *@throws InvalidArgumentException if $newTrailAccessibility is not a string or insecure
 *@throws RangeException if $newTrailAccessibility is > 256 characters
**/
	public function setTrailAccessibility($newTrailAccessibility){
		//verify the trail accessibility content is secure
		$newTrailAccessibility = trim($newTrailAccessibility);
		$newTrailAccessibility = filter_var($newTrailAccessibility,FILTER_SANITIZE_STRING);
		if(empty($newTrailAccessibility)=== true){
			throw(new InvalidArgumentException(" trail accessibility content is empty or insecure "));
		}
		// verify the trail accessibility content will fit in the database
		if(strlen($newTrailAccessibility)>256){
			throw (new RangeException("trail accessibility content too large"));
		}
		//store the trail accessibility content
		$this->trailAccessibility =$newTrailAccessibility;
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
 *@throws InvalidArgumentException if $newTrailAmenities is not a string or insecure
 *@throws RangeException if $newTrailAmenities > 256 characters
**/
	public function setTrailAmenities($newTrailAmenities){
		//verify the trail amenities content is secure
		$newTrailAmenities = trim($newTrailAmenities);
		$newTrailAmenities = filter_var($newTrailAmenities, FILTER_SANITIZE_STRING);
		if(empty($newTrailAmenities)===true){
			throw(new InvalidArgumentException("trail amenities content is empty or insecure"));
		}
		//verify the trail amenities content will fit in the database
		if(strlen($newTrailAmenities)>256){
			throw(new RangeException("trail amenities content too large"));
		}
		//store the trail amenities content
		$this->trailAmenities = $newTrailAmenities;
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
 * @throws InvalidArgumentException if $newTrailCondition content is not a string or insecure
 * @throws RangeException is $newTrailCondition content is greater than 256 characters
**/
	public function setTrailCondition($newTrailCondition){
		//verify the trail condition content is secure
		$newTrailCondition = trim($newTrailCondition);
		$newTrailCondition = filter_var($newTrailCondition, FILTER_SANITIZE_STRING);
		if(empty($newTrailCondition)=== true) {
			throw(new InvalidArgumentException("trail condition content is empty or insecure"));
		}
		//verify the trail condition will fit in the database
		if(strlen($newTrailCondition)> 256){
			throw(new RangeException("trail condition content too large"));
		}
		//store the trail condition content
		$this->trailCondition=$newTrailCondition;
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
 *@throws InvalidArgumentException if $newTrailDescription is not a string or insecure
 *@throws RangeException if $newTrailDescription is greater than 512 characters
**/
	public function setTrailDescription($trailDescription) {
		//verify the trail content is secure
		$newTrailDescription = trim($newTrailDescription);
		$newTrailDescription = filter_var($newTrailDescription, FILTER_SANITIZE_STRING);
		//verify the trail description will fit in the database
		if(strlen($newTrailDescription)> 512){}
		$this->trailDescription = $trailDescription;
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
 * accessor method for trailDistance
 *
 * @return int value of trailDistance
**/
	public function getTrailDistance() {
		return ($this->trailDistance);
	}
/**
 * accessor method for antiAbuse ????????
**/

/**
 * accessor method for trailSubmissionType
 *
 * @return string value of trailSubmissionType
 */
	public function getTrailSubmissionType() {
		return ($this->trailSubmissionType);
	}
/**
 * accessor method for trailTerrain
 *
 *@return string value of trailTerrain
 */
	public function getTrailTerrain() {
		return ($this->trailTerrain);
	}
/**
 * accessor method for trailName
 *
 * @return string value of trailName
**/
	public function getTrailName(){
		return($this->trailName);
	}
/**
 * accessor method for trailTraffic
 *
 * @return int value of trailTraffic
**/
	public function getTrailTraffic(){
		return($this->trailTraffic);
	}
/**
 * accessor method for trailUse
 *
 * @return string value of trailUse
**/
	public function getTrailUse(){
		return($this->trailUse);
	}


}