app.constant("COMMENT_ENDPOINT", "api/comment/");
app.service("CommentService", function($http, COMMENT_ENDPOINT) {
	function getUrl() {
		return(COMMENT_ENDPOINT);
	}

	function getUrlForId(commentId) {
		return(getUrl() + commentId)
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetchId = function(commentId) {
		return($http.get(getUrlForId(commentId)));
	};

	this.userId = function(userId) {
		return($http.getUrl() + '?userId=' + userId);
	};

	this.commentText = function(commentText) {
		return($http.getUrl() + '?commentText=' + commentText); 
	};

	this.trailId = function(trailId) { 
		return($http.getUrl() + '?trailId=' + trailId);
	 };

	this.create = function(comment) {
		return($http.post(getUrl(), comment));
	};

	this.update = function(commentId, comment) {
		return($http.put(getUrlForId(commentId), comment));
	};

	this.destroy = function(commentId) {
		return($http.delete(getUrlForId(commentId)));
	};
});



