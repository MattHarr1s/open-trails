<?

/**
 * The relationship between trails and their segments
 *
 * Indicates which trails belong to which segments and vice versa. Also, indicates what type of segment each is
 *
 * @author Louis Gill <lgill7@cnm.edu>
 **/

class TrailRelationship {
	/**
	 * trailId; this is a foreign key
	 * @var int $trailId
	 **/
	private $trailId;
	/**
	 * segmentId; this is a foreign key
	 * @var int $segmentId
	 **/
	private $segmentId;
	/**
	 * segmentType; indicates whether the segment contains a trailhead or not
	 * @var string $segmentType
	 **/
	private $segmentType;

	/**
	 * constructor for this trail/segment relationship
	 *
	 * @param int $newTrailId new value for trailId
	 * @param int $newSegmentId new value for segmentId
	 * @param string $newSegmentType new value for segmentType
	 * @throws UnexpectedValueException if any of the parameters are invalid
	 **/
	public function __construct($newTrailId, $newSegmentId, $newSegmentType) {
		try {
			$this->setTrailId($newTrailId);
			$this->setNewSegmentId($newSegmentId);
			$this->setSegmentType($newSegmentType);
		} catch(UnexpectedValueException $exception) {
			throw(new UnexpectedValueException("Unable to construct trail relationship", 0, $exception));
		}
	}

	/**
	 * accessor method for trailId
	 *
	 * @return int value for trailId
	 **/
	public function getTrailId() {
		return ($this->trailId);
	}

	/**
	 * mutator method for trailId
	 *
	 * @param int $newTrailId new value of trailId
	 * @throws UnexpectedValueException if $newTrailId is not an integer
	 * @throws RangeException if $newTrailId is not positive
	 **/
	public function setTrailId($newTrailId) {
		$newTrailId = filter_var($newTrailId, FILTER_VALIDATE_INT);
		if($newTrailId === false) {
			throw(new UnexpectedValueException("trailId is not a valid integer"));
		}
		if($newTrailId <= 0) {
			throw(new RangeException("trailId is not positive"));
		}
		$this->trailId = intval($newTrailId);
	}

	/**
	 * accessor method for segmentId
	 *
	 * @return int value for trailId
	 **/
	public function getSegmentId() {
		return ($this->segmentId);
	}

	/**
	 * mutator method for segmentId
	 *
	 * @param int $newSegmentId new value of segmentId
	 * @throws UnexpectedValueException if $newSegmentId is not an integer
	 * @throws RangeException if $newSegmentId is not positive
	 **/
	public function setNewSegmentId($newSegmentId) {
		$newSegmentId = filter_var($newSegmentId, FILTER_VALIDATE_INT);
		if($newSegmentId === false) {
			throw(new UnexpectedValueException("segmentId is not a valid integer"));
		}
		if($newSegmentId <= 0) {
			throw(new RangeException("segmentId is not positive"));
		}
		$this->segmentId = intval($newSegmentId);
	}

	/**
	 * accessor method for segmentType
	 *
	 * @return string value for segmentType
	 **/
	public function getSegmentType() {
		return ($this->segmentType);
	}

	/**
	 * mutator method for segmentType
	 *
	 * @param string $newSegmentType new value of segmentType
	 * @throws UnexpectedValueException if $newSegmentType is not a string or is insecure
	 **/
	public function setSegmentType($newSegmentType) {
		$newSegmentType = trim($newSegmentType);
		$newSegmentType = filter_var($newSegmentType, FILTER_SANITIZE_STRING);
		if(empty($newSegmentType) === true) {
			throw(new UnexpectedValueException("segmentType is empty or insecure"));
		}
		$this->segmentType = $newSegmentType;
	}

	/**
	 * inserts a trail relationship into MySQL
	 *
	 * @param PDO $pdo PDO connection object
	 * @throws PDOException when MySQL related errors occur
	 **/
	public function insert(PDO $pdo) {
		if ($this->trailId === null) {
			throw(new PDOException("not an existing trailId"));
		}
		if ($this->segmentId === null) {
			throw(new PDOException("not an existing segmentId"));
		}
		$query = "INSERT INTO trailRelationship(trailId,segmentId,segmentType)"
	}
}