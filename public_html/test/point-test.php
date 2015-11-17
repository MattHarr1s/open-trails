<?php
require_once("trail-quail.php");
require_once(dirname(__DIR__). "/php/classes/autoload.php");

/**
 *
 * Full PHPUnit test for the Point container class used by segment
 *
 *
 *
 * @see Point
 * @author Matt Harris <mattharr505@gmail.com> and Trail Quail <trailquailabq@gmail.com>
 **/
class PointTest extends TrailQuailTest{
	/**
	 * valid x value
	 *
	 * @var double $VALID_X
	**/
	protected $VALID_X = 35.6585;
	/**
	 * valid y value
	 *
	 * @var double $VALID_Y
	**/
	protected $VALID_Y = 42.2568;

	/**
	 * invalid x value
	 *
	 * @var double $INVALID_X
	 **/
	protected $INVALID_X = 185.6585;

	/**
	 * invalid valid y value
	 *
	 * @var double $INVALID_Y
	 **/
	protected $INVALID_Y = 102.2568;

	/**
	 * test using valid x, valid y
	**/
	public function testValidPoint(){
		$point = new Point($this->VALID_X, $this->VALID_Y);

		//use the mutators to make a valid test case
		$point->setX($this->VALID_X);
		$point->setY($this->VALID_Y);

		// assertSame() that getFoo() is the same as $VALID_FOO
		$this->assertSame($point->getX(), $this->VALID_X);
		$this->assertSame($point->getY(), $this->VALID_Y);


	}

	/**
	 * test using invalid x
	 **/
	public function testInvalidPoint(){
		$point = new Point($this->INVALID_X,$this->VALID_Y);

		//use the mutators to make a valid test case
		$point->setX($this->INVALID_X);
		$point->setY($this->VALID_Y);

	}

	/**
	 * test using an invalid y
	**/

   public function testInvalidPointY() {
		$point = new Point($this->VALID_X, $this->INVALID_Y);

		// simply use the $INVALID_IP and an exception will be thrown
		$point->setX($this->VALID_X);
		$point->setY($this->INVALID_Y);
	}

}