app.constant("TRAIL_ENDPOINT", "api/segment/");
app.service("TrailService", function($http, TRAIL_ENDPOINT) {
	function getUrl() {
		return(TRAIL_ENDPOINT);
	}

	function getUrlForId(trailId) {
		return(getUrl() + trailId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetchId = function(trailId) {
		return($http.get(getUrlForId(trailId)));
	};

	this.userId = function(userId) { 
		return($http.getUrl() + '?userId=' + userId); 
	};

	this.submitId = function(trailSubmitId) { 
		return($http.getUrl() + '?submitId=' + trailSubmitId);
	 };

	this.amenities = function(trailAmenities) { 
		return($http.getUrl() + '?amenities=' + trailAmenities);
	 };

	this.condition= function(trailCondition) { 
		return($http.getUrl() + '?condition=' + trailCondition);
	 };
	this.description = function(trailDescription) { 
		return($http.getUrl() + '?description=' + trailDescription); 
	};

	this.difficulty = function(traildifficulty) { 
		return($http.getUrl() + '?difficulty=' + traildifficulty); 
	};

	this.distance = function(trailDistance) { 
		return($http.getUrl() + '?distance=' + trailDistance);
	 };

	this.name = function(trailName) { 
		return($http.getUrl() + '?name=' + trailName); 
	};

	this.submission = function(trailSubmissionType) {
		return($http.getUrl() + '?submission=' + trailSubmissionType); 
	};

	this.terrain = function(trailTerrain)
	{ 	return($http.getUrl() + '?terrain=' + trailTerrain);
		 };

	this.traffic = function(trailTraffic) {
		return($http.getUrl() + '?traffic=' + trailTraffic);
		 };

	this.use = function(trailuse) {
		return($http.getUrl() + '?use=' + trailuse)
	};

	this.uuid = function(trailUuid) {
		 return($http.getUrl() + '?uuid=' + trailUuid); 
	};

	this.create = function(trail) {
		return($http.post(getUrl(), trail));
	};

	this.update = function(trailId,trail) {
		return($http.put(getUrlForId(trailId), trail));
	};

	this.destroy = function(trailId) {
		return($http.delete(getUrlForId(trailId)));
	};
});


