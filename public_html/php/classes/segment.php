<?php
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");
require_once(dirname(dirname(__DIR__)) . "/php/classes/autoload.php");

use Symm\Gisconverter\Gisconverter;

/**
 * Class Segment for the website TrailQuail.net
 * This class can be used for any trail mapping application
 * The Segment class contains the following attributes:
 *
 * -segmentId, the primary key
 * -segmentStart
 * -segmentStop
 * -segmentStartElevation
 * -segmentStopElevation
 *
 * @author Matt Harris <mattharr505@gmail.com>
 **/
class Segment implements JsonSerializable {
	/**
	 * Id for this segment; as stated above, this is the primary key
	 *
	 * @var int $segmentId
	 **/
	private $segmentId;

	/**
	 * starting location of trail segment
	 *
	 * @var Point $segmentStart
	 **/
	private $segmentStart;

	/**
	 * location for end of segment
	 *
	 * @var Point $segmentStop
	 **/
	private $segmentStop;

	/**
	 * elevation at segment start point
	 *
	 * @var int $segmentStartElevation
	 **/
	private $segmentStartElevation;

	/**
	 * elevation at segment end point
	 *
	 * @var int $segmentStopElevation
	 **/
	private $segmentStopElevation;

	/** Constructor for segment objects
	 *
	 *
	 * @param int $newSegmentId
	 * @param Point $newSegmentStart
	 * @param Point $newSegmentStop
	 * @param int $newSegmentStartElevation
	 * @param int $newSegmentStopElevation
	 * @throws InvalidArgumentException if datatypes are not valid
	 * @throws RangeException if data values are out of bounds (e.g. string instead of int, string too long)
	 * @throws Exception if some other exception is thrown
	 *
	 **/
	public function __construct($newSegmentId, $newSegmentStart, $newSegmentStop, $newSegmentStartElevation, $newSegmentStopElevation) {
		try {
			$this->setSegmentId($newSegmentId);
			$this->setSegmentStart($newSegmentStart);
			$this->setSegmentStop($newSegmentStop);
			$this->setSegmentStartElevation($newSegmentStartElevation);
			$this->setSegmentStopElevation($newSegmentStopElevation);
		} catch(InvalidArgumentException $invalidArgument) {

			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {

			//rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {

			//rethrow generic exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for segmentId
	 *
	 * gains access to segmentId for use by mutator method
	 *
	 * @return mixed value of segmentId
	 **/
	public function getSegmentId() {
		return ($this->segmentId);
	}

	/**
	 * mutator method for segmentId
	 *
	 *
	 * @param mixed $newSegmentId new value of segmentId
	 **/
	public function setSegmentId($newSegmentId) {
		$this->segmentId = Filter::filterInt($newSegmentId, "Segment Id", true);
	}

	/**
	 * accessor method for segmentStart
	 *
	 * @return Point value of segmentStart
	 **/
	public function getSegmentStart() {
		return ($this->segmentStart);
	}

	/**
	 * mutator method for segmentStart
	 *
	 * @param Point $newSegmentStart .
	 **/
	public function setSegmentStart(Point $newSegmentStart) {
		$this->segmentStart = $newSegmentStart;
	}

	/**
	 * accessor method for segmentStop
	 *
	 * @return Point value of segmentStop
	 **/
	public function getSegmentStop() {
		return ($this->segmentStop);
	}

	/**
	 *mutator method for segmentStop
	 *
	 * @param Point $newSegmentStop
	 **/
	public function setSegmentStop(Point $newSegmentStop) {
		$this->segmentStop = $newSegmentStop;
	}

	/**
	 * accessor method for segmentStartElevation
	 *
	 * @return int value of startElevation
	 **/
	public function getSegmentStartElevation() {
		return ($this->segmentStartElevation);
	}

	/**
	 * mutator for segmentStartElevation
	 *
	 * @param int $newSegmentStartElevation
	 **/
	public function setSegmentStartElevation($newSegmentStartElevation) {
		$this->segmentStartElevation = Filter::filterInt($newSegmentStartElevation, "Segment Start Elevation", false);
	}

	/**
	 * accessor method for segmentStopElevation
	 *
	 * @return int value of segmentStopElevation
	 **/
	public function getSegmentStopElevation() {
		return ($this->segmentStopElevation);
	}

	/**
	 * mutator for segmentStopElevation
	 *
	 * @param int $newSegmentStopElevation
	 **/
	public function setSegmentStopElevation($newSegmentStopElevation) {
		$this->segmentStopElevation = Filter::filterInt($newSegmentStopElevation, "Segment Stop Elevation", false);
	}

	/**
	 * inserts this segment into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur.
	 */
	public function insert(PDO &$pdo) {
		//make sure this is a new segment
		if($this->segmentId !== null) {
			throw(new PDOException("Not a new Segment"));
		}

		// create query template
		$query = "INSERT INTO segment(segmentStart, segmentStop, segmentStartElevation, segmentStopElevation)
		VALUES(POINT(:segmentStartX, :segmentStartY), POINT(:segmentStopX, :segmentStopY), :segmentStartElevation, :segmentStopElevation)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = array("segmentStartX" => $this->getSegmentStart()->getX(), "segmentStartY" => $this->getSegmentStart()->getY(),
			"segmentStopX" => $this->getSegmentStop()->getX(), "segmentStopY" => $this->getSegmentStop()->getY(),
			"segmentStartElevation" => $this->getSegmentStartElevation(), "segmentStopElevation" => $this->getSegmentStopElevation());
		$statement->execute($parameters);

		//update the null segmentId with what mySQL has generated
		$this->setSegmentId(intval($pdo->lastInsertId()));
	}

	/**
	 * deletes this segment from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection.
	 * @throws PDOException when mySQL related errors occur
	 */
	public function delete(PDO &$pdo) {
		//make sure this segment already exists
		if($this->getSegmentId() === null) {
			throw(new PDOException("unable to delete a segment that does not exist"));
		}

		//create query template
		$query = "DELETE FROM segment WHERE segmentId = :segmentId";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the placeholders in the templates
		$parameters = array("segmentId" => $this->getSegmentId());
		$statement->execute($parameters);
	}

	/**
	 * updates this segment in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection
	 * @throws PDOException when mySQL related errors occur
	 */
	public function update(PDO &$pdo) {
		//make sure this segment exists
		if($this->segmentId === null) {
			throw(new PDOException("unable to update a segment that does not exist"));
		}

		//create query table
		$query = "UPDATE segment SET segmentStart = :segmentStart, segmentStop = :segmentStop,
segmentStartElevation = :segmentStartElevation, SegmentStopElevation = :segmentStopElevation";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$startX = $this->getSegmentStart()->getX();
		$startY = $this->getSegmentStart()->getY();
		$stopX = $this->getSegmentStop()->getX();
		$stopY = $this->getSegmentStop()->getY();
		$parameters = array("segmentStart" => "POINT($startX $startY)", "segmentStop" => "POINT($stopX $stopY)",
			"segmentStartElevation" => $this->getSegmentStartElevation(), "segmentStopElevation" => $this->getSegmentStopElevation());
		$statement->execute($parameters);
	}

	/**
	 * gets segment by segmentId
	 *
	 * @param PDO $pdo pointer to PDO connection
	 * @param int $segmentId segmentId to search for
	 * @return mixed Segment found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 */
	public static function getSegmentById(PDO &$pdo, $segmentId) {
		//sanitize the ID before searching
		try {
			$segmentId = Filter::filterInt($segmentId, "Segment Id");
		} catch(InvalidArgumentException $invalidArgument) {
			throw(new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new PDOException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT segmentId, ST_AsWKT(segmentStop) AS segmentStop, ST_AsWKT(segmentStart) AS segmentStart, segmentStartElevation, segmentStopElevation FROM segment WHERE segmentId = :segmentId";
		$statement = $pdo->prepare($query);

		//bind segmentId to placeholder
		$parameters = array("segmentId" => $segmentId);
		$statement->execute($parameters);

		//grab the segment from mySQL
		try {
			$segment = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();

			if($row !== false) {
				$segmentStartJSON = Gisconverter::wktToGeojson($row["segmentStart"]);
				$segmentStopJSON = Gisconverter::wktToGeojson($row["segmentStop"]);
				$segmentStartGenericObject = json_decode($segmentStartJSON);
				$segmentStopGenericObject = json_decode($segmentStopJSON);
				$segmentStart = new Point($segmentStartGenericObject->coordinates[0], $segmentStartGenericObject->coordinates[1]);
				$segmentStop = new Point($segmentStopGenericObject->coordinates[0], $segmentStopGenericObject->coordinates[1]);
				$segment = new Segment($row["segmentId"], $segmentStart, $segmentStop, $row["segmentStartElevation"], $row["segmentStopElevation"]);
			}
		} catch(Exception $e) {
			//if the row couldn't be converted, rethrow it
			throw(new PDOException($e->getMessage(), 0, $e));
		}
		return ($segment);
	}

	/**
	 * gets segment by segmentStart
	 *
	 * @param PDO $pdo pointer to PDO connection
	 * @param Point $segmentStart start point to search for
	 * @return mixed Segment found or null if not found
	 * @throws RangeException when range is invalid
	 * @throws Exception for other exception
	 */
//	public static function getSegmentByStart(PDO &$pdo, $segmentStart) {
//		sanitize the float before searching
//		try {
//			$segmentStart = $segmentStart; //
//		} catch (InvalidArgumentException $invalidArgument) {
//			throw(new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
//		} catch (RangeException $range) {
//			throw (new RangeException($range->getMessage(), 0, $range ));
//		} catch  (Exception $exception) {
//			throw (new Exception($exception->getMessage(), 0 ,$exception));
//		}
//
//		create query template
//		$query = "SELECT segmentId, ST_AsWKT(segmentStop) AS segmentStop, ST_AsWKT(segmentStart) AS segmentStart, segmentStartElevation, segmentStopElevation FROM segment WHERE segmentStart = :segmentStart";
//		$statement = $pdo->prepare($query);
//
//		binds segmentStart to placeholder
//		$segmentStart = "segmentStart";
//		$parameters = array("segmentStart" => $segmentStart);
//		$statement->execute($parameters);
//
//		build an array of segments
//		$segments = new SplFixedArray($statement->rowCount());
//		$statement->setFetchMode(PDO::FETCH_ASSOC);
//		while(($row = $statement->fetch()) !== false) {
//			try {
//				 new segment ($segmentId, $segmentStart, $segmentStop, $segmentStartElevation, $segmentStopElevation)
//				$segmentStartJSON = Gisconverter::wktToGeojson($row["segmentStart"]);
//				$segmentStopJSON = Gisconverter::wktToGeojson($row["segmentStop"]);
//				$segmentStartGenericObject = json_decode($segmentStartJSON);
//				$segmentStopGenericObject = json_decode($segmentStopJSON);
//				$segmentStart = new Point($segmentStartGenericObject->coordinates[0], $segmentStartGenericObject->coordinates[1]);
//				$segmentStop = new Point($segmentStopGenericObject->coordinates[0], $segmentStopGenericObject->coordinates[1]);
//				$segment = new Segment($row["segmentId"], $segmentStart, $segmentStop, $row["segmentStartElevation"], $row["segmentStopElevation"]);
//
//				$segments[$segments->key()] = $segment;
//				$segments->next();
//			} catch(Exception $e) {
//				if the row couldn't be converter, rethrow it
//				throw (new PDOException($e->getMessage(), 0, $e));
//			}
//		}

//		return ($segments);
//	}
//
	/**
	 * gets segment by segmentStop
	 *
	 * @param PDO $pdo pointer to PDO connection
	 * @param float $segmentStop stop point to search for
	 * @return mixed segment found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 * @throws RangeException when range is invalid
	 * @throws Exception for other exception
	 */
	public static function getSegmentByStop(PDO &$pdo, $segmentStop) {
		//sanitize the float before searching
//		try {
//			$segmentStop =  $segmentStop;
//		} catch (InvalidArgumentException $invalidArgument) {
//			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
//		} catch (RangeException $range){
//			throw (new RangeException ($range->getMessage(), 0, $range));
//		} catch (Exception $exception) {
//			throw (new Exception($exception->getMessage(),0,$exception));
//		}
		//create query template
		$query = "SELECT SELECT segmentId, ST_AsWKT(segmentStop) AS segmentStop, ST_AsWKT(segmentStart) AS segmentStart, segmentStartElevation, segmentStopElevation FROM segment WHERE segmentStop = :segmentStop";
		$statement = $pdo->prepare($query);

		//binds segmentStop to placeholder
		$segmentStop = "segmentStop";
		$parameters = array("segmentStop" => $segmentStop);
		$statement->execute($parameters);

		//build an array of segments
		$segments = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				// new segment ($segmentId, $segmentStart, $segmentStop, $segmentStartElevation, $segmentStopElevation)
				$segment = new Segment($row ["segmentId"], $row["segmentStart"], $row["segmentStop"], $row["segmentStartElevation"], $row["segmentStopElevation"]);
				$segments[$segments->key()] = $segment;
				$segments->next();
			} catch(Exception $e) {
				//if the row couldn't be converter, rethrow it
				throw (new PDOException($e->getMessage(), 0, $e));
			}
		}
		return ($segments);
	}

	/**
	 * gets segment by segmentStartElevation
	 *
	 * @param PDO $pdo pointer to PDO connection
	 * @param float $segmentStartElevation start point to search for
	 * @return mixed Segment found or null if not found
	 * @throws RangeException when range is invalid
	 * @throws Exception for other exception
	 */
	public static function getSegmentByStartElevation(PDO &$pdo, $segmentStartElevation) {
		//sanitize the float before searching
		try {
			$segmentStartElevation = Filter::filterInt($segmentStartElevation, "segment start elevation");
		} catch(InvalidArgumentException $invalidArgument) {
			throw(new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw (new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			throw (new Exception($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT segmentId, segmentStop, segmentStart, segmentStartElevation, segmentStopElevation, FROM segment WHERE segmentStartElevation = :segmentStartElevation ";
		$statement = $pdo->prepare($query);

		//binds segmentStartElevation to placeholder
		$parameters = array("segmentStartElevation" => $segmentStartElevation);
		$statement->execute($parameters);

		//build an array of segments
		$segments = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				// new segment ($segmentId, $segmentStart, $segmentStop, $segmentStartElevation, $segmentStopElevation)
				$segment = new Segment($row ["segmentId"], $row["segmentStart"], $row["segmentStop"], $row["segmentStartElevation"], $row["segmentStopElevation"]);
				$segments[$segments->key()] = $segment;
				$segments->next();
			} catch(Exception $e) {
				//if the row couldn't be converter, rethrow it
				throw (new PDOException($e->getMessage(), 0, $e));
			}
		}

		return ($segments);
	}

	/**
	 * gets segment by segmentStopElevation
	 *
	 * @param PDO $pdo pointer to PDO connection
	 * @param int $segmentStopElevation stop elevation to search for
	 * @return mixed segment found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 * @throws RangeException when range is invalid
	 * @throws Exception for other exception
	 */
	public static function getSegmentByStopElevation(PDO &$pdo, $segmentStopElevation) {
		//santize the float before searching
		try {
			$segmentStopElevation = Filter::filterInt($segmentStopElevation, "segment stop", false);
		} catch(InvalidArgumentException $invalidArgument) {
			throw (new PDOException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw (new RangeException ($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			throw (new Exception($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT segmentId, ST_AsWKT(segmentStop) AS segmentStop, ST_AsWKT(segmentStart) AS segmentStart, segmentStartElevation, segmentStopElevation, FROM segment WHERE segmentStopElevation LIKE :segmentStopElevation";
		$statement = $pdo->prepare($query);

		//binds segmentStopElevation to placeholder
		$parameters = array("segmentStopElevation" => $segmentStopElevation);
		$statement->execute($parameters);

		//build an array of segments
		$segments = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				// new segment ($segmentId, $segmentStart, $segmentStop, $segmentStartElevation, $segmentStopElevation)
				$segment = new Segment($row ["segmentId"], $row["segmentStart"], $row["segmentStop"], $row["segmentStartElevation"], $row["segmentStopElevation"]);
				$segments[$segments->key()] = $segment;
				$segments->next();
			} catch(Exception $e) {
				//if the row couldn't be converter, rethrow it
				throw (new PDOException($e->getMessage(), 0, $e));
			}
		}
		return ($segments);
	}

	/**
	 * specifies which fields to include in a JSON serialization
	 *
	 * @return array array containing all fields in the Segment
	 **/

	public function jsonSerialize() {
		return (get_object_vars($this));

	}
}