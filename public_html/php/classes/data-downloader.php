<?php

require_once "autoload.php";
require_once("/etc/apache2/mysql/encrypted-config.php");

use Symm\Gisconverter\Gisconverter;
use Location\Coordinate;
use Location\Polyline;
use Location\Distance\Vincenty;

/**
 * This class will download date from the City of Albuquerque Open-Trails Database.
 * This class can be modified to grab data from the databases of other cities using the open-trails specification.
 *
 * @author Matt Harris mattharr505@gmail.com
 *
 **/
class DataDownloader {

	/**
	 * named trails:http://data.cabq.gov/community/opentrails/named_trails.csv
	 * trail segments: http://data.cabq.gov/community/opentrails/trail_segments.geojson
	 *
	 **/

	/**
	 * Gets the metadata from a file url
	 *
	 * @param string %url to grab from
	 * @param int $redirect whether to redirect or not
	 * @return mixed stream data
	 * @throws Exception if file doesn't exist.
	 **/
	public static function getMetaData($url, $redirect = 1) {
		$context = stream_context_create(array("http" => array("follow_location" => $redirect, "ignore_errors" => true, "method" => "HEAD")));

		//"@" suppresses warnings and errors
		$fd = @fopen($url, "rb", false, $context);

		//grab the stream data
		$streamData = stream_get_meta_data($fd);

		fclose($fd);

		$wrapperData = $streamData["wrapper_data"];

		//loop through and find the "HTTP" attribute
		$http = "";
		foreach($wrapperData as $data) {
			if(strpos($data, "HTTP") !== false) {
				$http = $data;
				break;
			}
		}

		if(strpos($http, "400")) {
			throw (new Exception("Bad request"));
		}
		if(strpos($http, "401")) {
			throw (new Exception ("Unauthorized"));
		}
		if(strpos($http, "403")) {
			throw (new Exception ("Forbidden"));
		}
		if(strpos($http, "404")) {
			throw (new Exception("Not Found"));
		}
		if(strpos($http, "418")) {
			throw(new Exception("Get your tea set"));
		}

		return $streamData;
	}

	/**
	 *This function grabs the named_trails.csv file and reads it
	 *
	 * @param string $url url to grab file at
	 * @throws PDOException PDO related errors
	 * @throws Exception catch-all exception
	 **/
	public static function readNamedTrailsCSV($url) {


		$context = stream_context_create(array("http" => array("ignore_errors" => true, "method" => "GET")));

		try {
			$pdo = connectToEncryptedMySQL("/ect/apache2/mysql/trailquail.ini");

			if(($fd = @fopen($url, "rb", false, $context)) !== false) {
				fgetcsv($fd, 0, "'");
				while((($data = fgetcsv($fd, 0, "'")) !== false) && feof($fd) === false) {
					$trailId = null;
					$userId = "";
					$browser = "";
					$createDate = "";
					$ipAddress = "";
					$submitTrailId = "";
					$trailAmenities = "";
					$trailCondition = "";
					$trailDescription = "";
					$trailDifficulty = "";
					$trailDistance = "";
					$trailName = $data[1];
					$trailSubmissionType = "";
					$trailTerrain = "";
					$trailUse = "";
					$trailUuid = "";

					//sets trail description based on available data.
					if(strlen($data[3]) <= 0) {
						$trailDescription = "This trail currently has no description information. If you are familiar with this trail, please use the submission form to help us out! Thank you.";
					} else {
						$trailDescription = $data[3];
					}

					try {
						$trail = new Trail($trailName, $userId, $browser, $createDate, $ipAddress, $submitTrailId, $trailAmenities, $trailCondition, $trailDescription, $trailDifficulty, $trailDistance, $trailName, $trailSubmissionType, $trailTerrain, $trailUse, $trailUuid);
						$trail->insert($pdo);
					} catch(PDOException $pdoException) {
						$sqlStateCode = "23000";

						$errorInfo = $pdoException->errorInfo;
						if($errorInfo [0] === $sqlStateCode) {
						} else {
							throw (new PDOException($pdoException->getMessage(), 0, $pdoException));
						}
					} catch(Exception $exception) {
						throw (new Exception ($exception->getMessage(), 0, $exception));
					}
				}
				fclose($fd);
			}
		} catch(PDOException $pdoException) {
			throw (new PDOException($pdoException->getMessage(), 0, $pdoException));
		} catch(Exception $exception) {
			throw(new Exception ($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 *
	 * Decodes geoJson file, converts to string, sifts through the string and inserts the data into the database
	 *
	 * @param string $url
	 * @throws PDOException PDO related errors
	 * @throws Exception catch-all exception
	 **/
	public static function readTrailSegmentsGeoJson($url) {

		$context = stream_context_create(array("http" => array("ignore_errors" => true, "method" => "GET")));

		try {
			$pdo = connectToEncryptedMySQL("/etc/apache2/mysql/trailquail.ini");

			if(($jsonData = file_get_contents($url, null, $context)) === false) {

				if(($jsonFd = @fopen("php://memory", "wb+")) === false) {
					throw(new RuntimeException("Memory Error: I can't remember"));
				}

				//decode the geoJson file
				$jsonConverted = json_decode($jsonData, true);
				$jsonFeatures = $jsonConverted->features;

				$properties = $jsonFeatures->properties;
				foreach($properties as $property) {
					$trailName = "";
					$trailUse = "";

					//Set $trailUse string based on information in geoJson properties field.
					if($property['bicycle'] === "yes") {
						$trailUse = $trailUse . "bicycle: yes, ";
					} else {
						$trailUse = $trailUse . "bicycle: no, ";
					}
					if($property['foot'] === "yes") {
						$trailUse = $trailUse . "foot: yes, ";
					} else {
						$trailUse = $trailUse . "foot: no, ";
					}
					if($property['wheelchair'] === "yes") {
						$trailUse = $trailUse . "wheelchair: yes ";
					} else {
						$trailUse = $trailUse . "wheelchair: no ";
					}

					try {
						$trails = Trail::getTrailByTrailName($pdo, $trailName);
						$trail = null;
						foreach($trails as $trailToSet) {
							$trail = $trailToSet;
						}
						$trail = $trail->setTrailUse($trailUse);
						$trail->update($pdo);

						$coordinates = $jsonFeatures->geometry->coordinates;
						for($index = 0; $index < count($coordinates) - 1; $index++) {
							$segmentStartX = $coordinates[$index][0];
							$segmentStartY = $coordinates[$index][1];
							$segmentStartElevation = $coordinates[$index][2];
							$segmentStopX = $coordinates[$index + 1][0];
							$segmentStopY = $coordinates[$index + 1][1];
							$segmentStopElevation = $coordinates[$index + 1][2];
							$segmentStart = new Point ($segmentStartX, $segmentStartY);
							$segmentStop = new Point ($segmentStopX, $segmentStopY);

							try {
								$segment = new Segment(null, $segmentStart, $segmentStop, $segmentStartElevation, $segmentStopElevation);
								$segment->insert($pdo);

								$relationship = new TrailRelationship(null, $trail->getTrailId(), $segment->getSegmentId());
								$relationship->insert($pdo);

							} catch(PDOException $pdoException) {
								$sqlStateCode = "23000";

								$errorInfo = $pdoException->errorInfo;
								if($errorInfo [0] === $sqlStateCode) {
								} else {
									throw (new PDOException($pdoException->getMessage(), 0, $pdoException));
								}
							} catch(Exception $exception) {
								throw (new Exception ($exception->getMessage(), 0, $exception));
							}
						}
					} catch(PDOException $pdoException) {
						$sqlStateCode = "23000";

						$errorInfo = $pdoException->errorInfo;
						if($errorInfo [0] === $sqlStateCode) {
						} else {
							throw (new PDOException($pdoException->getMessage(), 0, $pdoException));
						}
					} catch(Exception $exception) {
						throw (new Exception ($exception->getMessage(), 0, $exception));
					}
				}

				fclose($jsonFd);
			}
		} catch(PDOException $pdoException) {
			throw (new PDOException($pdoException->getMessage(), 0, $pdoException));
		} catch(Exception $exception) {
			throw (new Exception ($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 *gets all segments for a trail and calculates distance of the trail then inserts calculated trailDistance into trail
	 * using
	 *
	 *
	 **/
	public static function calculateTrailDistance() {
		$trails = Trail::getAllTrails($pdo);
		foreach($trails as $trail) {
			$trailRelationships = TrailRelationship::getTrailRelationshipByTrailId($pdo, $trail->getTrailId());
			$track = new Polyline();
			foreach($trailRelationships as $trailRelationship) {

				$segment = Segment::getSegmentBySegmentId($pdo, $trailRelationship->getSegmentId());

				$track->addPoint(new Coordinate($segment->getSegmentStart()->getX(), $segment->getSegmentStart()->getY()));
				$track->addPoint(new Coordinate($segment->getSegmentStop()->getX(), $segment->getSegmentStop()->getY));
			}
			//need to repeat and skip every other segment.
			$trailDistanceM = $track->getLength(new Vincenty());
			$trailDistanceKM = $trailDistanceM / 1000;
			$trailDistanceMi = $trailDistanceM / 1609.344;

			// TODO: Set the trail distance
		}
	}
}

DataDownloader::readTrailSegmentsGeoJson("http://data.cabq.gov/community/opentrails/trail_segments.geojson");
