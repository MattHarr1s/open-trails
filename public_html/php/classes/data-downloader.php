<?php

require_once "autoload.php";
require_once("/etc/apache2/mysql/encrypted-config.php");

use Symm\Gisconverter\Gisconverter;

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
	 * stewards: http://data.cabq.gov/community/opentrails/stewards.csv
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
	 * gets the "Last-Modified" attribute from a file url
	 *
	 * @param string $url url to check
	 * @return string "Last-Modified" attribute
	 **/
	public static function getLastModified($url) {
		// get the stream data
		$streamData = DataDownloader::getMetaData($url);

		//get the wrapper data that contains the "Last-Modified" attribute
		$wrapperData = $streamData["wrapper_data"];

		// loop through to find the "Last-Modified" attribute
		$lastModified = "";
		foreach($wrapperData as $data) {
			if(strpos($data, "Last-Modified") !== false) {
				$lastModified = $data;
				break;
			}
		}

		return $lastModified;
	}

	/**
	 * gets the "Last-Modified" date from a file url
	 *
	 * @param string $url url to check
	 * @return DateTime date last modified
	 **/
	public static function getLastModifiedDate($url) {
		// get the "Last-Modified" attribute
		$lastModified = DataDownloader::getLastModified($url);
		$dateString = null;

		if(strpos($lastModified, "Last-Modified") !== false) {
			//grab the string after "Last-Modified: "
			$dateString = substr($lastModified, 15);
		}

		$date = new DateTime($dateString);
		$date->setTimezone(new DateTimeZone(date_default_timezone_get()));

		//$formattedDate = $date->format ("Y-m-d H:i:s");

		return $date;
	}

	/**
	 * deletes a file or files from a directory
	 *
	 * @param string $path path to file
	 * @param string $name filename
	 * @param string $extension extension of the file
	 **/
	public static function deleteFiles($path, $name, $extension) {
		//Delete file(s)
		$files = glob("$path$name*$extension");
		foreach($files as $file) {
			unlink($file);
		}
	}

	/**
	 * gets the date of a stored file
	 *
	 * @param string $path path to stored file
	 * @param string $name name of stored file
	 * @param string $extension extension of stored file
	 * @return DateTime date of stored file
	 * @throws Exception if file does not exist
	 **/

	public static function getDateFromStoredFile($path, $name, $extension) {
		//get date from stored file
		$currentDateStr = null;
		$currentFile = null;
		$files = glob("$path$name*$extension");
		if(count($files) > 0) {
			$currentFile = $files[0];
		} else {
			return DateTime::createFromFormat("U", "0");
		}

		// get date from filename
		$matches = array();
		preg_match("/\\d+", $currentFile, $matches);
		$currentDateStr = $matches[0];

		//create date
		$currentDate = DateTime::createFromFormat("U", $currentDateStr);

		return $currentDate;
	}

	/**
	 * Downloads a file to a path from a url
	 *
	 * @param string $url url to grab from
	 * @param string $path path to save to
	 * @param string $name filename to save in
	 * @param string $extension extension to save in
	 **/

	public static function downloadFile($url, $path, $name, $extension) {
		//delete old file(s)
		DataDownloader::deleteFiles($path, $name, $extension);

		//create new file
		$newFile = null;
		$newFileName = $path . $name . DataDownloader::getLastModifiedDate($url)->getTimestamp() . ".csv";

		$file = fopen($url, "rb");
		if($file) {
			$newFile = fopen($newFileName, "wb");

			if($newFile)
				while(!feof($file)) {
					fwrite($newFile, fread($file, 1024 * 8), 1024 * 8);
				}
		}

		if($file) {
			fclose($file);
		} else {
			fclose($newFile);
		}
	}

	/**
	 *This function grabs the named_trails.csv file and reads it
	 *
	 * @param string $urlBegin beginning of url to grab file at
	 * @param string $urlEnd end of url to grab file at
	 * @throws PDOException PDO related errors
	 * @throws Exception catch-all exception
	 **/
	public static function readNamedTrailsCSV($urlBegin, $urlEnd) {
		$urls = glob("$urlBegin*$urlEnd");
		if(count($urls) > 0) {
			$url = $urls[0];
		}

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
					if ($data[3] === null){
					$trailDescription = "This trail currently has no description. If you are familiar with this trail, please use the submission form to help us out! Thank you.";
					} else{
					$trailDescription = $data[3];
					}

					//convert fields to UTF-8
					$trailDescription = mb_convert_encoding($trailDescription, "UTF-8");
					$trailName = mb_convert_encoding($trailName, "UTF-8");

					try {
						$trail = new Trail($trailName, $userId, $browser, $createDate, $ipAddress, $submitTrailId, $trailAmenities, $trailCondition, $trailDescription, $trailDifficulty, $trailDistance, $trailName, $trailSubmissionType, $trailTerrain, $trailUse, $trailUuid);
						$trail = insert($pdo);
					} catch(PDOException $pdoException) {
						$sqlStateCode = "23000";

						$errorInfo = $pdoException->errorInf;
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
	 * Slurp Slurp
	 * Decodes geoJson file, converts to string, sifts through the string and inserts the data into the database
	 *
	 * @param string $urlBegin beginning of url to grab file at
	 * @param string $urlEnd end of url to grab file at
	 * @throws PDOException PDO related errors
	 * @throws Exception catch-all exception
	 **/
	public static function readTrailSegmentsGeoJson($urlBegin, $urlEnd) {
		$urls = glob("$urlBegin*$urlEnd");
		if(count($urls) > 0) {
			$url = $urls[0];
		} else {
			throw(new RuntimeException("No file exists at specified location"));
		}
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

				$coordinates = $jsonFeatures->geometry->coordinates;
				for($index = 0; $index < count($coordinates) - 1; $index++) {
					$segmentStartX = $coordinates[$index][0];
					$segmentStartY = $coordinates[$index][1];
					$segmentStartElevation = $coordinates[$index][2];
					$segmentStopX = $coordinates[$index + 1][0];
					$segmentStopY = $coordinates[$index +1][1];
					$segmentStopElevation = $coordinates[$index +1][2];
					$segmentStart = new Point ($segmentStartX, $segmentStartY);
					$segmentStop = new Point ($segmentStopX, $segmentStopY);
			}
				$properties = $jsonFeatures->properties;
				foreach($properties as $property){
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
					$trailName = "";
					$trailSubmissionType = "";
					$trailTerrain = "";
					$trailUse = "";
					$trailUuid = "";

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
					if($property['wheelchair'] === "yes"){
						$trailUse = $trailUse . "wheelchair: yes ";
					} else {
						$trailUse = $trailUse . "wheelchair: no ";
					}
				}
					//convert the fields to UTF-8
					$trailUse = mb_convert_encoding($trailUse, "UTF-8");

					try {
						$segment = new Segment($segmentId, $segmentStart, $segmentStop, $segmentStartElevation, $segmentStopElevation);
						$segment = insert($pdo);
					} catch(PDOException $pdoException) {
						$sqlStateCode = "23000";

						$errorInfo = $pdoException->errorInf;
						if($errorInfo [0] === $sqlStateCode) {
						} else {
							throw (new PDOException($pdoException->getMessage(), 0, $pdoException));
						}
					} catch(Exception $exception) {
						throw (new Exception ($exception->getMessage(), 0, $exception));
					}

					try {
					$trail = new Trail($trailName, $userId, $browser, $createDate, $ipAddress, $submitTrailId, $trailAmenities, $trailCondition, $trailDescription, $trailDifficulty, $trailDistance, $trailName, $trailSubmissionType, $trailTerrain, $trailUse, $trailUuid);
					$trail = insert($pdo);
					} catch(PDOException $pdoException) {
					$sqlStateCode = "23000";

					$errorInfo = $pdoException->errorInf;
					if($errorInfo [0] === $sqlStateCode) {
					} else {
						throw (new PDOException($pdoException->getMessage(), 0, $pdoException));
					}
					} catch(Exception $exception) {
					throw (new Exception ($exception->getMessage(), 0, $exception));
				}

		}
	}
}






