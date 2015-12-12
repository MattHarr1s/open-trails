app.controller("SegmentController", ["$scope", "$uibModal", "SegmentService", function($scope, $uibModal, SegmentService) {
	//add as needed will come back to add doing of off bradly history on organization
	$scope.segments = [];
	$scope.alerts = [];
	$scope.numSegments = 2;

	//get segments from api
	//come back for other gets
	// make doc blocks better

	$scope.getSegmentId = function(segmentId, validated ) {
		if (validated === true ) {
			SegmentService.fetchId(segmentId)
				.then(function(result){
					if(result.data.status === 200) {
						$scope.segments = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	//comment here
	$scope.getSegmentStart = function(segmentStart, validated) {
		if (validated === true) {
			SegmentService.fetchSegmentStart(segmentStart)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.segments = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	$scope.getSegmentStop = function(segmentStop, validated) {
		if (validated === true) {
			SegmentService.fetchSegmentStop(segmentStop)
				.then(function(result){
					if(result.data.status === 200) {
						$scope.segments = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	$scope.getElevationX = function(segment, validated) {
		if (validated === true) {
			SegmentService.fetchElevationX(elevationX)
				.then(function(result) {
					if(result.data.status === 200){
						$scope.segments = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}

	};
	$scope.getElevationY = function(segmentStopElevation, validated) {
		if (validated === true) {
			SegmentService.fetchElevationY(segmentStopElevation)
				.then(function(result) {
					if(result.data.status === 200){
						$scope.segments = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger",  msg: result.data.message}
					}
				});
		}
	};

	console.log("testing whyyyyyyy");
	//create new segment
	$scope.createSegment = function(segments, validated) {
		console.log("Invalid");
		if(validated === true) {
			console.log("Validated");
			SegmentService.create(segments)
				.then(function(result) {console.log(result);}, function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}

				});
		}
	};

	//update the organization
	$scope.updateSegment = function(segment, validated) {
		if(validated === true && $scope.isEditing === true) {
			//this line of code is violating type hinting why?
			SegmentService.update(segment.Id, segment)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	// temporary: load the array with blank values
	$scope.loadArray = function() {
		$scope.segments.length = 0;
		for(var i = 0; i < $scope.numSegments; i++) {
			$scope.segments.push([0.0, 0.0]);
		}
		$scope.createSegment($scope.segments, true);
	};
	if($scope.segments.length === 0) {
		$scope.loadArray();
	}

}]);