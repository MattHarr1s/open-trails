<?php
/**
 * Trail Quail user class -- this is where user information is stored
 * This is part of the Trail Quail web application.  This feature will determine who the registered users
 * are and what level of access they have.  It will also store the userId, the user's name, their email address,
 * their browsing information, and datetime stamp when their account was set up.
 *
 * author Jeff Saul <scaleup13@gmail.com>
 */
Class user  {
	/**
	 * user Id is an unsigned integer; this is the primary key for class user
	 * @var integer $userId
	 */
	private $userId;

	/**
	 * This indicates what type of account and what type of access each user has
	 * @var string $userAccountType
	 */
	private $userAccountType;

	/**
	 * This is the user's email address
	 * @var string $userEmail
	 */
	private $userEmail;

	/**
	 * This is the 128 byte hash variable for user authentication
	 * @var string $userHash
	 */
	private $userHash;

	/**
	 * This is the user's username
	 * @var string $userName
	 */
	private $userName;

	/**
	 * This is the 64 byte salt variable for user authentication
	 * @var string $userSalt
	 */
	private $userSalt;


}