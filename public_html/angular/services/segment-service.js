app.constant("SEGMENT_ENDPOINT", "api/segment/");
app.service("SegmentService", function($http, SEGMENT_ENDPOINT) {
	function getUrl() {
		return(SEGMENT_ENDPOINT);
	}

	function getUrlForId(segmentId) {
		return(getUrl() + segmentId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetchId = function(segmentId) {
		return($http.get(getUrlForId(segmentId)));
	};

	this.fetchSegmentX = function(segmentStart) {
		return($http.getUrl() + '?segmentX=' + segmentStart);
	};

	this.fetchSegmentY = function(segmentStop) {
		return($http.getUrl() + '?segmentY=' + segmentStop);
	};

	this.elevationX = function(segmentStartElevation) {
		return($http.getUrl() + '?elevationX=' + segmentStartElevation);
	};

	this.elevationY = function(segmentStopElevation) {
		return($http.getUrl() + '?elevationY=' + segmentStopElevation);
	};

	this.create = function(segment) {
		return($http.post(getUrl(), segment));
	};

	this.update = function(segmentId, segment) {
		return($http.put(getUrlForId(segmentId), segment));
	};

	this.destroy = function(segmentId) {
		return($http.delete(getUrlForId(segmentId)));
	};
});

