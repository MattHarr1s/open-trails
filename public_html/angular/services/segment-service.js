app.constant("SEGMENT_ENDPOINT", "../../php/api/segment/");
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

	this.fetchSegmentStart = function(segmentStart) {
		return($http.getUrl() + '?SegmentStart=' + segmentStart);
	};

	this.fetchSegmentStop = function(segmentStop) {
		return($http.getUrl() + '?segmentStop=' + segmentStop);
	};

	this.fetchElevationX = function(segmentStartElevation) {
		return($http.getUrl() + '?elevationX=' + segmentStartElevation);
	};

	this.fetchElevationY = function(segmentStopElevation) {
		return($http.getUrl() + '?elevationY=' + segmentStopElevation);
	};

	this.create = function(segments) {
		console.log("create()");
		for(var i = 0; i < segments.length; i++) {
			var segment = segments[i];
			segment.elevationStart = 0;
			segment.elevationStop = 0;
			return ($http.post(getUrl(), segment));
		}
	};

	this.update = function(segmentId, segment) {
		return($http.put(getUrlForId(segmentId), segment));
	};

	this.destroy = function(segmentId) {
		return($http.delete(getUrlForId(segmentId)));
	};
});

