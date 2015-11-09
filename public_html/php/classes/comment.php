<?php

/**
 cross section of trail quail that is user submitted comments
 *
 * this feature will be a comment thread that will allow for users to communicate important information about the trail,
 * to have conversations about hiking, to upload photos, and to get official information from the city about the trail
 *
 *@author George Kephart <gkephart@cnm.edu>
 */
class comment {
	/**
	 *id for this comment; this is a primary key
	 * @var int $tweetId
	 */
	private $commentId;
	/**
	 * id of the trail that is associated with the comment; this is a foreign key
	 * @var int $trailId
	 *
	 */
	private $trailId;
	/**
	 * id of the user that sent this comment; this is a foreign key
	 * @var int $userId
	 */
	private $userId;
	/**
	 *this is a photo that is uploaded as a comment from a user about a specfic trail
	 * @var string $commentPhoto
	 */
	private $commentPhoto;
	/**
	 *this is the actual comment that is uploaded by a user about a specific trail
	 * @var string
	 */

	/**
	 * constructor for this comment
	 * @param mixed $newCommentId id of this comment or null if a new comment
	 * @param int $newTrailId id of the trail that is associated with this coomment
	 * @param int $newUserId id of the user that sent this comment
	 * @param string
	 *
	 *
	 *
	 */


}