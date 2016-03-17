/**
* this Service is used to make calls to the Trail API to get needed data from the server about specific trails
* @ param app.constant set end point for the trail API
* @ param app.service is the actual service being created to send calls
 */
app.constant("TRAIL_ENDPOINT", "php/api/trail/");
app.service("TrailService", function($http, TRAIL_ENDPOINT) {
	function getUrl() {
		return (TRAIL_ENDPOINT);
	}

	// gets the url for the specified traill id
	function getUrlForId(trailId) {
		return (getUrl() + trailId);
	}

	// gets all trails
	this.all = function() {
		return ($http.get(getUrl()));
	};

	//grabs the trail needed by is primary Key
	this.fetchId = function(trailId) {
		return ($http.get(getUrlForId(trailId)));
	};

	// grabs segment points associated with the trail in question
	this.fetchPoints = function(trailId) {
		return ($http.get(getUrlForId(trailId)));
	};

	//grabs the needed user Id not sure why we need this
	this.fetchUserId = function(userId) {
		return ($http.getUrl() + '?userId=' + userId);
	};

	this.fetchUserId = function(userId) {
		return ($http.getUrl() + '?userId=' + userId);
	};

	//grabs the trail submit id needed
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

	this.fetchUuid = function(trailUuid) {
		return ($http.getUrl() + '?uuid=' + trailUuid);
	};

	//creates a brand new trail
	this.create = function(trail) {
		return ($http.post(getUrl(), trail));
	};
	// Updates an existing trail
	this.update = function(trailId, trail) {
		return ($http.put(getUrlForId(trailId), trail));
	};
});


