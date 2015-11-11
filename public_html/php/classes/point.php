<?php
require_once(dirname(dirname(__DIR__)) . "public_html/php/classes/autoload.php");

/**
 * point class for trail quail trail class
 *
 * point is a container class that two state variables
 * var $x is the longitude
 * var $y is the latitude
 *
 */
class Point {
	/**
	 * @var double $x
	 */
	private $x;
	/**
	 * @var double $y
	 */
	private $y;

	/**
	 * constructor for Point object
	 * @param $newX
	 * @param $newY
	 * @throws exception
	 **/
	public function __construct($newX, $newY) {
		try {
			$this->setX($newX);
			$this->setY($newY);
		} catch(invalidArgumentExcepton $invalidArgument) {
			//rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(rangeException $range) {
			//rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(exception $exception) {
			//rethrow the exception to the caller
			throw(new exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for x
	 **/
	public function getX() {
		return ($this->x);
	}

	/**
	 * mutator method for x
	 * -180 to 180 is the valid input range
	 *
	 * @param double $newX
	 * @throws RangeException
	 * @throws InvalidArgumentException
	 * @return double
	 **/
	public function setX($newX) {
		//make sure the int is not null
		if($newX === null){
			throw(new InvalidArgumentException("longitude cannot be null"));
		}

		//make sure the int in in the proper range
		if($newX <= -180){
			throw(new RangeException("longitude must be greater than -180"));
		}

		if($newX >= 180){
			throw(new RangeException("longitude must be less than or equal to 180"));
		}
		// verify the new int
		$newX = filter_var($newX, FILTER_VALIDATE_FLOAT);
		if($newX === false){
			throw(new InvalidArgumentException("longitude is not a valid double"));
		}

		//convert and return the new int
		return(doubleval($newX));
	}

	/**
	 * accessor method for y
	 **/
	public function getY() {
		return ($this->y);
	}
	/**
	 * mutator method for y
	 *
	 * @param double $newY
	 * @throws InvalidArgumentException
	 * @throws RangeException
	 * @return double
	**/
	public function setY($newY){
		// make sure the int is not null
		if ($newY === null){
			throw(new InvalidArgumentException("latitude cannot be null" ));
		}

		//make sure the int is in the proper range
		if($newY <= -90){
			throw(new RangeException("latitude must be equal to or greater than -90"));
		}

		if($newY >= 90){
			throw(new RangeException("latitude must be equal to less than 90"));
		}

		//verify the new int
		$newY = filter_var($newY,FILTER_VALIDATE_FLOAT);
		if ($newY === false){
			throw(new InvalidArgumentException("latitude is not a valid double"));
		}
	}
}