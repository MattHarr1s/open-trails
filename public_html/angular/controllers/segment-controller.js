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

	$scope.getElevationX = function(segmentStartElevation, validated) {
		if (validated === true) {
			SegmentService.fetchElevationX(segmentStartElevation)
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

	//create new segment
	$scope.createSegment = function(segments, validated) {
		console.log("create");
		if(validated === true) {
			console.log("validated");
			for(var i = 0; i < $scope.segments.length - 1; i++) {
				var newSegment = {segmentStart: $scope.segments[i], segmentStop: $scope.segments[i + 1]};
				SegmentService.create(newSegment)
					.then(function(result) {
						console.log(result.data);
						if(result.data.status === 200) {
							$scope.alerts[0] = {type: "success", msg: result.data.message};
						} else {
							$scope.alerts[0] = {type: "danger", msg: result.data.message};
						}

					});
			}
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
	$scope.geoFindMe = function() {
		if (!navigator.geolocation) {
			$scope.alerts[0] = {type: "danger", msg: "Uninstall IE. Good fucking luck!"};
			return;
		}

		function success(position) {
			var latitude  = position.coords.latitude;
			var longitude = position.coords.longitude;

			$scope.segments.push([longitude, latitude]);
		}

		function error() {
			$scope.alerts[0] = {type: "danger", msg: "Can't get location (user probably declined/ignored request)."};
		}

		navigator.geolocation.getCurrentPosition(success, error);
	};

	// temporary: load the array with blank values
	 $scope.loadArray = function() {
	 $scope.segments.length = 0;
	 for(var i = 0; i < $scope.numSegments; i++) {
	 $scope.segments.push([0.0, 0.0]);
	 }
	 };
	 if($scope.segments.length === 0) {
	 $scope.loadArray();
	 }
}]);