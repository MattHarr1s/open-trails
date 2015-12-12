<?php

require_once(dirname(dirname(__DIR__)) . "/php/classes/autoload.php");
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

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

//		echo "test 0";
		try {
			$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/trailquail.ini");

//			echo "test 1" . PHP_EOL;
//			$i = 0;
			if(($fd = @fopen($url, "rb", false, $context)) !== false) {
//				echo "test 2" . PHP_EOL;
				fgetcsv($fd, 0, ",");
				while((($data = fgetcsv($fd, 0, ",", "\"")) !== false) && feof($fd) !== true) {
//					echo $i . PHP_EOL;
//					$i++;
					$trailId = null;
					$userId = 1;
					$browser = "Default";
					$createDate = new DateTime();
					$ipAddress = "::1";
					$submitTrailId = null;
					$trailAmenities = "This trail currently has no amenities information. If you are familiar with this trail, please use the submission form to help us out! Thank you.";
					$trailCondition = "This trail currently has no condition information. If you are familiar with this trail, please use the submission form to help us out! Thank you.";
					$trailDescription = "";
					$trailDifficulty = 2;
					$trailDistance = 0;
					$trailName = $data[1];
					$trailSubmissionType = 2;
					$trailTerrain = "Unknown";
					$trailTraffic = "Unknown";
					$trailUse = "Unknown";
					$trailUuid = null;
					//sets trail description based on available data.
					if(strlen($data[3]) <= 0) {
						$trailDescription = "This trail currently has no description information. If you are familiar with this trail, please use the submission form to help us out! Thank you.";
					} else {
						$trailDescription = $data[3];
					}
					try {
						$trail = new Trail(null, $userId, $browser, $createDate, $ipAddress, $submitTrailId, $trailAmenities, $trailCondition, $trailDescription, $trailDifficulty, $trailDistance, $trailName, $trailSubmissionType, $trailTerrain, $trailTraffic, $trailUse, $trailUuid);
						$trail->insert($pdo);
					} catch(PDOException $pdoException) {
						$sqlStateCode = "23000";
						echo "I knew there was a catch somewhere :" . $pdoException->getMessage() . PHP_EOL;

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
			$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/trailquail.ini");

			if(($jsonData = file_get_contents($url, null, $context)) !== false) {

				if(($jsonFd = @fopen("php://memory", "wb+")) === false) {
					throw(new RuntimeException("Memory Error: I can't remember"));
				}

				//decode the geoJson file
				$jsonConverted = json_decode($jsonData);
				$jsonFeatures = $jsonConverted->features;

				$properties = new SplFixedArray(count($jsonFeatures));
				foreach($jsonFeatures as $jsonFeature) {
					$properties[$properties->key()] = $jsonFeature->properties;
					$properties->next();
				}

				$trails = [];
				$trailGuide = new SplObjectStorage();

				foreach($properties as $property) {
					$trailName = $property->name;
					$trailUse = "";

					//Set $trailUse string based on information in geoJson properties field.
					if($property->bicycle === "yes") {
						$trailUse = $trailUse . "bicycle: yes, ";
					} else {
						$trailUse = $trailUse . "bicycle: no, ";
					}
					if($property->foot === "yes") {
						$trailUse = $trailUse . "foot: yes, ";
					} else {
						$trailUse = $trailUse . "foot: no, ";
					}
					if($property->wheelchair === "yes") {
						$trailUse = $trailUse . "wheelchair: yes ";
					} else {
						$trailUse = $trailUse . "wheelchair: no ";
					}

					try {
						$candidateTrails = Trail::getTrailByTrailName($pdo, $trailName);
						foreach($candidateTrails as $trail) {
							$trail->setTrailUse($trailUse);
							$trail->update($pdo);
							$trails[] = $trail;
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

				try {
					$trailIndex = 0;
					foreach($jsonFeatures as $jsonFeature) {
						$jsonCoordinates = $jsonFeature->geometry->coordinates;
						if($jsonFeature->geometry->type === "LineString") {
							$coordinates = new SplFixedArray(count($jsonCoordinates));
							foreach($jsonCoordinates as $coordinate) {
								$coordinates[$coordinates->key()] = $coordinate;
								$coordinates->next();
							}
							$trailGuide[$trails[$trailIndex]] = $coordinates;
							$trailIndex++;


						} else if($jsonFeature->geometry->type === "MultiLineString") {
							$trailClones = [];
							$trails[$trailIndex]->delete($pdo);
							for($i = 1; $i <= count($jsonCoordinates); $i++) {
								$trail = clone $trails[$trailIndex];
								$trail->setTrailId(null);
								$trail->setTrailName($trail->getTrailName() . " $i");
								$trail->insert($pdo);
								$trailClones[] = $trail;
							}
							array_splice($trails, $trailIndex, 1, $trailClones);


							foreach($jsonCoordinates as $lineCoordinates) {
								$trailGuide[$trails[$trailIndex]] = $lineCoordinates;
								$trailIndex++;
							}
						}
					}

					$trailGuide->rewind();
					foreach($trailGuide as $map) {
						$trail = $trailGuide->current();
						$geo = $trailGuide->getInfo();
						for($indexTwo = 0; $indexTwo < count($geo) - 1; $indexTwo++) {
							$segmentStartX = $geo[$indexTwo][0];
							$segmentStartY = $geo[$indexTwo][1];
//							$segmentStartElevation = $geo[$indexTwo][2];
							$segmentStopX = $geo[$indexTwo + 1][0];
							$segmentStopY = $geo[$indexTwo + 1][1];
//							$segmentStopElevation = $geo[$indexTwo + 1][2];
							$segmentStart = new Point ($segmentStartX, $segmentStartY);
							$segmentStop = new Point ($segmentStopX, $segmentStopY);
							try {
								$segment = new Segment(null, $segmentStart, $segmentStop, 0, 0);
								$segment->insert($pdo);
								$relationship = new TrailRelationship($segment->getSegmentId(), $trail->getTrailId(), "T");
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
		} catch
		(PDOException $pdoException) {
			throw (new PDOException($pdoException->getMessage(), 0, $pdoException));
		} catch
		(Exception $exception) {
			throw (new Exception ($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 *gets all segments for a trail and calculates distance of the trail then inserts calculated trailDistance into trail
	 *
	 *
	 *
	 **/
	public static function calculateTrailDistance() {
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/trailquail.ini");
		$trails = Trail::getAllTrails($pdo);

		$testNum = 0;
		foreach($trails as $trail) {
			//echo "Tracks: " . $testNum . PHP_EOL;
			$testNum++;
			$trailRelationships = TrailRelationship::getTrailRelationshipByTrailId($pdo, $trail->getTrailId());

			$track = new Polyline();
			foreach($trailRelationships as $trailRelationship) {
				$segment = Segment::getSegmentBySegmentId($pdo, $trailRelationship->getSegmentId());
//				echo "SegId: " . $trailRelationship->getSegmentId() . PHP_EOL;
				$track->addPoint(new Coordinate($segment->getSegmentStart()->getY(), $segment->getSegmentStart()->getX()));
//				var_dump($segment->getSegmentStart(), $segment->getSegmentStop());
				$track->addPoint(new Coordinate($segment->getSegmentStop()->getY(), $segment->getSegmentStop()->getX()));
			}

			//calculate trail distance and convert to miles
//			echo "<p style='background-color:red;'>";
//			$test = $track->getLength(new Vincenty());
//			echo $test;
//			echo "</p>";
			$trailDistanceM = $track->getLength(new Vincenty());
			echo "Meters: " . $trailDistanceM . PHP_EOL;
			$trailDistanceMi = $trailDistanceM / 1609.344;
//			var_dump($trailDistanceM);
//			echo($trailDistanceMi);

			//set trail distance
			$trailDistance = $trailDistanceMi;
			$trail->setTrailDistance($trailDistance);
			$trail->update($pdo);
//			echo "<p>Trail distance:</p>";
//			var_dump($trailDistance);
		}
	}
}


DataDownloader::readNamedTrailsCSV("http://data.cabq.gov/community/opentrails/named_trails.csv");
DataDownloader::readTrailSegmentsGeoJson("http://data.cabq.gov/community/opentrails/trail_segments.geojson");
DataDownloader::calculateTrailDistance();