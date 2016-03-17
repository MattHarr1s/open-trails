/**
 * this Service is used to make calls to the sgement API to get needed data from the server about point segments on trails
 * @ param app.constant set end point for the Segment API
 * @ param app.service is the actual service being created to send calls
 */

app.constant("SEGMENT_ENDPOINT", "../../php/api/segment/");
app.service("SegmentService", function($http, SEGMENT_ENDPOINT) {
	// not sure why this is here creating: a point and setting it to a blank array
	this.point = [];

	// gets the needed url
	function getUrl() {
		return(SEGMENT_ENDPOINT);
	}

	//gets the needed segment by its URL
	function getUrlForId(segmentId) {
		return(getUrl() + segmentId);
	}

	//returns all segments
	this.all = function() {
		return($http.get(getUrl()));
	};

	//grabs the needed segment by its primary KEy
	this.fetchId = function(segmentId) {
		return($http.get(getUrlForId(segmentId)));
	};

	// grabs a segment by its geopoint start
	this.fetchSegmentStart = function(segmentStart) {
		return($http.getUrl() + '?SegmentStart=' + segmentStart);
	};

	//grabs a segment by its geopoint stop
	this.fetchSegmentStop = function(segmentStop) {
		return($http.getUrl() + '?segmentStop=' + segmentStop);
	};

	//grabs a segment by its start elevation
	this.fetchElevationX = function(segmentStartElevation) {
		return($http.getUrl() + '?elevationX=' + segmentStartElevation);
	};

	// grabs a segment by its stop elevation
	this.fetchElevationY = function(segmentStopElevation) {
		return($http.getUrl() + '?elevationY=' + segmentStopElevation);
	};

	//creates a new segment
	this.create = function(segments) {
		return ($http.post(getUrl(), segments));
	};

	// updates a new segment
	this.update = function(segmentId, segment) {
		return($http.put(getUrlForId(segmentId), segment));
	};

	// deletes a segment
	this.destroy = function(segmentId) {
		return($http.delete(getUrlForId(segmentId)));
	};

	this.setPoint = function(point) {
		this.point = point;
	};

	this.fetchPoint = function() {
		return(this.point);
	};
});

