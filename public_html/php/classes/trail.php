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
	 * @throws exception
	 *
	 */
	public function __construct($newTrailId, $newTrailUuId, $newSubmitTrailId, $newUserId,$newBrowser, $newCreateDate,
	$newIpAddress, $newTrailAccessibility,$newTrailAmenities, $newTrailCondition, $newTrailDescription, $newTrailDifficulty,
	$newTrailDistance, $newTrailSubmissionType, $newTrailTerrain, $newTrailName, $newTrailTraffic, $newTrailUse) {
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
	 * @param string $newBrowser
	 **/
	public function setBrowser($newBrowser) {
		$this->browser = $browser;
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
	 * accessor method for ipAddress
	 *
	 * @return int ipAddress
	 **/
	public function getIpAddress() {
		return $this->ipAddress;
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
			$this->trailDescription = Filter::filterString($newTrailDescription,"Trail Description",512);
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
			$this->trailDifficulty = Filter::filterInt ($newTrailDifficulty,"Trail Difficulty",false);
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
	 */
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
		public function setTrailSubmissionType($newTrailSubmissionType){

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