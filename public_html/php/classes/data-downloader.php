<?php

require_once "autoload.php";
require_once("/ect/apache2/mysql/encrypted-config.php");

/**
 * This class will download date from the City of Albuquerque Open-Trails Database.
 * This class can be modified to grab data from the databases of other cities using the open-trails specification.
 *
 * @author Matt Harris mattharr505@gmail.com
 *
**/
class DataDownloader{

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
	public static function getMetaData ($url, $redirect = 1) {
		$context = stream_context_create(array("http" => array("follow_location" => $redirect, "ignore_errors" => true, "method" => "HEAD")));

		//"@" suppresses warnings and errors
		$fd = @fopen($url, "rb", false, $context);

		//grab the stream data
		$streamData = stream_get_meta_data($fd);

		fclose($fd);

		$wrapperData = $streamData["wrapper_data"];

		//loop through and find the "HTTP" atribute
		$http ="";
		foreach ($wrapperData as $data) {
			if(strpos($data, "HTTP") !== false){
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
		if(strpos($http,"418")) {
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
	public static function getLastModifiedDate ($url) {
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
		foreach($files as $file){
			unlink($file);
		}
	}



}
