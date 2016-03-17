/**
 * this Service is used to make calls to the comment API to get needed data from the server about specific trails
 * @ param app.constant set end point for the Comment API
 * @ param app.service is the actual service being created to send calls
 */



app.constant("COMMENT_ENDPOINT", "php/api/comment/");
app.service("CommentService", function($http, COMMENT_ENDPOINT) {
	function getUrl() {
		return (COMMENT_ENDPOINT);
	}

	function getUrlForId(commentId) {
		return (getUrl() + commentId)
	}

	this.all = function() {
		return ($http.get(getUrl()));
	};

	this.fetchId = function(commentId) {
		return ($http.get(getUrlForId(commentId)));
	};

	this.fetchUserId = function(userId) {
		return ($http.get(getUrl() + '?userId=' + userId));
	};

	this.fetchCommentText = function(commentText) {
		return ($http.get(getUrl() + '?commentText=' + commentText));
	};

	this.fetchTrailId = function(trailId) {
		return ($http.get(getUrl() + '?trailId=' + trailId));
	};

	this.create = function(comment) {
		return ($http.post(getUrl(), comment));
	};

	this.update = function(commentId, comment) {
		return ($http.put(getUrlForId(commentId), comment));
	};

	this.destroy = function(commentId) {
		return ($http.delete(getUrlForId(commentId)));
	};
});



