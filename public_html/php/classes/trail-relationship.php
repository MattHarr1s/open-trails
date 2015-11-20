<?php

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
	 * @param int $newSegmentId new value for segmentId
	 * @param int $newTrailId new value for trailId
	 * @param string $newSegmentType new value for segmentType
	 */
	public function __construct($newSegmentId, $newTrailId, $newSegmentType) {
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
		$query = "INSERT INTO trailRelationship(segmentId, trailId, segmentType) VALUES(:segmentId, :trailId, :segmentType)";
		$statement = $pdo->prepare($query);

		$parameters = array("segmentId => $this->segmentId, trailId => $this->trailId, segmentType => $this->segmentType");
		$statement->execute($parameters);
	}

	/**
	 * deletes a trail relationship from MySQL
	 *
	 * @param PDO $pdo PDO connection object
	 * @throws PDOException when MySQL related errors occur
	 **/
	public function delete(PDO $pdo) {
		if ($this->trailId === null) {
			throw(new PDOException("unable to delete a trail relationship that doesn't exist"));
		}
		if ($this->segmentId === null) {
			throw(new PDOException("unable to delete a trail relationship that doesn't exist"));
		}
		$query = "DELETE FROM trailRelationship WHERE trailId = :trailId AND segmentId = :segmentId";
		$statement = $pdo->prepare($query);

		$parameters = array("segmentId => $this->segmentId, trailId => $this->trailId, segmentType => $this->segmentType");
		$statement->execute($parameters);
	}

	/**
	 * updates a trail relationship in MySQL
	 *
	 * @param PDO $pdo PDO connection object
	 * @throws PDOException when MySQL related errors occur
	 **/
	public function update(PDO $pdo) {
		if($this->trailId === null) {
			throw(new PDOException("unable to update a trail relationship that doesn't exist"));
		}
		if($this->segmentId === null) {
			throw(new PDOException("unable to update a trail relationship that doesn't exist"));
		}
		$query = "UPDATE trailRelationship SET segmentType = :segmentType WHERE trailId = :trailId AND segmentId = :segmentId";
		$statement = $pdo->prepare($query);

		$parameters = array("segmentType => $this->segmentType");
		$statement->execute($parameters);
	}

	/**
	 * gets a Trail Relationship by trailId
	 *
	 * @param PDO $pdo PDO connection object
	 * @param int $trailId trail id to search for
	 * @return mixed Trail Relationship found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getTrailRelationshipByTrailId(PDO $pdo, $trailId) {
		// sanitize the trailId before searching
		$trailId = filter_var($trailId, FILTER_VALIDATE_INT);
		if($trailId === false) {
			throw(new PDOException("trailId is not an integer"));
		}
		if($trailId <= 0) {
			throw(new PDOException("trailId is not positive"));
		}

		//create query template
		$query = "SELECT segmentId, trailId, segmentType FROM trailRelationship WHERE trailId = :trailId";
		$statement = $pdo->prepare($query);

		//bind the trailId to the placeholder in the template
		$parameters = array("trailId" => $trailId);
		$statement->execute($parameters);

		// grab the Trail Relationship from mySQL
		try {
			$trailRelationship = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$trailRelationship = new TrailRelationship($row["segmentId"], $row["trailId"], $row["segmentType"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($trailRelationship);
	}

	/**
	 * gets a Trail Relationship by segmentId
	 *
	 * @param PDO $pdo PDO connection object
	 * @param int $segmentId segment id to search for
	 * @return mixed Trail Relationship found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getTrailRelationshipBySegmentId(PDO $pdo, $segmentId) {
		// sanitize the segmentId before searching
		$segmentId = filter_var($segmentId, FILTER_VALIDATE_INT);
		if($segmentId === false) {
			throw(new PDOException("segmentId is not an integer"));
		}
		if($segmentId <= 0) {
			throw(new PDOException("segmentId is not positive"));
		}

		//create query template
		$query = "SELECT segmentId, trailId, segmentType FROM trailRelationship WHERE segmentId = :segmentId";
		$statement = $pdo->prepare($query);

		//bind the trailId to the placeholder in the template
		$parameters = array("segmentId" => $segmentId);
		$statement->execute($parameters);

		// grab the Trail Relationship from mySQL
		try {
			$trailRelationship = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$trailRelationship = new TrailRelationship($row["segmentId"], $row["trailId"], $row["segmentType"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($trailRelationship);
	}

	/**
	 * gets a Trail Relationship by trailId AND segmentId
	 *
	 * @param PDO $pdo PDO connection object
	 * @param int $trailId trail id to search for
	 * @param int $segmentId segment id to search for
	 * @return mixed Trail Relationship found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getTrailRelationshipBySegmentIdAndTrailId(PDO $pdo, $segmentId, $trailId) {
		// sanitize the segmentId before searching
		$segmentId = filter_var($segmentId, FILTER_VALIDATE_INT);
		if($segmentId === false) {
			throw(new PDOException("segmentId is not an integer"));
		}
		if($segmentId <= 0) {
			throw(new PDOException("segmentId is not positive"));
		}

		// sanitize the trailId before searching
		$trailId = filter_var($trailId, FILTER_VALIDATE_INT);
		if($trailId === false) {
			throw(new PDOException("trailId is not an integer"));
		}
		if($trailId <= 0) {
			throw(new PDOException("trailId is not positive"));
		}

		//create query template
		$query = "SELECT segmentId, trailId, segmentType FROM trailRelationship WHERE segmentId = :segmentId AND trailId = :trailId";
		$statement = $pdo->prepare($query);

		//bind the trailId to the placeholder in the template
		$parameters = array("segmentId" => $segmentId, "trailId" => $trailId);
		$statement->execute($parameters);

		// grab the Trail Relationship from mySQL
		try {
			$trailRelationship = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$trailRelationship = new TrailRelationship($row["segmentId"], $row["trailId"], $row["segmentType"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($trailRelationship);
	}

	/**
	 * gets a Trail Relationship by segmentType
	 *
	 * @param PDO $pdo PDO connection object
	 * @param string $segmentType segment type to search for
	 * @return mixed Trail Relationship found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getTrailRelationshipBySegmentType(PDO $pdo, $segmentType) {
		$segmentType = filter_var($segmentType, FILTER_SANITIZE_STRING);
		if(empty($segmentType) === true) {
			throw(new PDOException("segmentType is empty or insecure"));
		}
		// create query template
		$query = "SELECT segmentId, trailId, segmentType FROM trailRelationship WHERE segmentType = :segmentType";
		$statement = $pdo->prepare($query);

		//bind the segment type to the placeholder in the template
		$parameters = array("segmentType" => $segmentType);
		$statement->execute($parameters);

		//grab the Trail Relationship from mySQL
		try {
			$trailRelationship = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$trailRelationship = new TrailRelationship($row["segmentId"], $row["trailId"], $row["segmentType"]);
			}
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		return($trailRelationship);
	}
}