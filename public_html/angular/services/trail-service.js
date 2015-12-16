app.constant("TRAIL_ENDPOINT", "php/api/trail/");
app.service("TrailService", function($http, TRAIL_ENDPOINT) {
	function getUrl() {
		return (TRAIL_ENDPOINT);
	}

	function getUrlForId(trailId) {
		return (getUrl() + trailId);
	}

	this.all = function() {
		return ($http.get(getUrl()));
	};

	this.fetchId = function(trailId) {
		return ($http.get(getUrlForId(trailId)));
	};

	this.fetchPoints = function(trailId) {
		return ($http.get(getUrlForId(trailId)));
	};

	this.fetchUserId = function(userId) {
		return ($http.getUrl() + '?userId=' + userId);
	};

	this.fetchUserId = function(userId) {
		return ($http.getUrl() + '?userId=' + userId);
	};

	this.fetchSubmitId = function(trailSubmitId) {
		return ($http.getUrl() + '?submitId=' + trailSubmitId);
	};

	this.fetchAmenities = function(trailAmenities) {
		return ($http.getUrl() + '?amenities=' + trailAmenities);
	};

	this.fetchCondition = function(trailCondition) {
		return ($http.getUrl() + '?condition=' + trailCondition);
	};

	this.fetchDescription = function(trailDescription) {
		return ($http.getUrl() + '?description=' + trailDescription);
	};

	this.fetchDifficulty = function(trailDifficulty) {
		return ($http.getUrl() + '?difficulty=' + trailDifficulty);
	};

	this.fetchDistance = function(trailDistance) {
		return ($http.getUrl() + '?distance=' + trailDistance);
	};

	this.fetchName = function(trailName) {
		return ($http.getUrl() + '?name=' + trailName);
	};

	this.fetchSubmission = function(trailSubmissionType) {
		return ($http.getUrl() + '?submission=' + trailSubmissionType);
	};

	this.fetchUse = function(trailuse) {
		return ($http.getUrl() + '?use=' + trailuse);
	};

	this.uuid = function(trailUuid) {
		return ($http.getUrl() + '?uuid=' + trailUuid);
	};

	this.create = function(trail) {
		return ($http.post(getUrl(), trail));
	};

	this.update = function(trailId, trail) {
		return ($http.put(getUrlForId(trailId), trail));
	};
});


