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
		$newTrailId = filter_var ($newTrailId, FILTER_VALIDATE_INT);
		if ($newTrailId === false) {
			throw(new UnexpectedValueException("trailId is not a valid integer"));
		}
		if ($newTrailId <= 0) {
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
	 * @param int $newSegmentId
	 */
	/**
	 * accessor method for segmentType
	 *
	 * @return string value for segmentType
	 **/
	public function getSegmentType() {
		return ($this->segmentType);
	}

}