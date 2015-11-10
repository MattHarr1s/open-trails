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
	 * @var boolean trailSubmissionType
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
	 *
	 *
	 * @param $newTrailId
	 * @param $newTrailUuId
	 * @param $newSubmitTrailId
	 * @param $newUserId
	 * @param $newTrailAccessibility
	 * @param $newTrailAmenities
	 * @param $newTrailCondition
	 * @param $newTrailDescription
	 * @param $newTrailDifficulty
	 * @param $newTrailDistance
	 * @param $newAntiAbuse
	 * @param $newTrailSubmissionType
	 * @param $newTrailTerrain
	 * @param $newTrailName
	 * @param $newTrailTraffic
	 * @param $newTrailUse
	 * @throws exception
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
			$this->setAntiAbuse($newAntiAbuse);
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
 * @param mixed $newTrailId
 *
 **/
	public function setTrailId($newTrailId){
		$this->trailId = Filter::filterInt($newTrailId,"Trail Id",true);
	}
/**
 * accessor method for trailUuId
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
 * accessor method for trailAccessibility
 *
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
	public function setTrailAccessibility($newTrailAccessibility){
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
	public function setTrailAmenities($newTrailAmenities){
	$this->trailAmenities = Filter::filterString($newTrailAmenities,"Trail Amenities",256);
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
	public function setTrailCondition($newTrailCondition){
		$this->trailCondition = Filter::filterString($newTrailCondition,"Trail Condition",256);
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
		$this->trailDescription = $newTrailDescription;
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
 */
	public function setTrailDifficulty($newTrailDifficulty){
		$this->getTrailDifficulty = Filter::filterInt ($newTrailDifficulty,"Trail Difficulty",false);
	}
/**
 * accessor method for trailDistance
 *
 * @return float value of trailDistance
**/
	public function getTrailDistance() {
		return ($this->trailDistance);
	}
/**
 *mutator method for trailDistance
 *
/**
 * accessor method for antiAbuse ????????
**/

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
**/
	public function setTrailSubmissionType
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
	public function setTrailTerrain($newTrailTerrain){
	$this->$newTrailTerrain = Filter::filterString($newTrailTerrain,"Trail Terrain",128);
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
 * mutator method for trailName
 *
 * @return string
**/
	public function setTrailName($newTrailName){
		$this->$newTrailName = Filter::filterString($newTrailName, "Trail Name",64);
	}
/**
 * accessor method for trailTraffic
 *
 * @return string value of trailTraffic
**/
	public function getTrailTraffic(){
		return($this->trailTraffic);
	}
/**
 * mutator method for trailTraffic
 *
 * @param string
**/
	public function setTrailTraffic($newTrailTraffic){
		$this->$newTrailTraffic = Filter::filterString($newTrailTraffic,"Trail Traffic",16);
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
	public function setTrailUse($newTrailUse){
		$this->$newTrailUse = Filter::filterString($newTrailUse,"Trail Use",64);
	}


}