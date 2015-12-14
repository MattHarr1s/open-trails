app.controller("Trail-Controller", ["$scope", "$uiModal", "TrailService", function($scope, $uibModal, TrailService) {
	// get the trail from the api
	// come back to add other
	// make doc blocks way better
	$scope.trails = [];
	$scope.alerts = [];

	$scope.getTrailId = function(trailId, validated) {
		if(validated === true) {
			TrailService.fetchId(trailId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};
	$scope.getTrailUser = function(userId, validated) {
		if(validated === true) {
			TrailService.fetchUserId(userId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};
	$scope.getSubmitId = function(TrailSubmitId, validated) {
		if(validated === true) {
			TrailService.fetchSubmitId(TrailSubmitId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	$scope.getTrailDifficulty = function(trailDifficulty, validated) {
		if(validated === true) {
			TrailService.fetchDifficulty(trailDifficulty)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};
	$scope.getTrailDistance = function(trailDistance, validated) {
		if(validated === true) {
			TrailService.fetchDistance(trailDistance)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	$scope.getTrailName = function(TrailName, validated) {
		if(validated === true) {
			TrailService.fetchName(TrailName)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	$scope.getTrailSubmission = function(trailSubmissionType, validated) {
		if(validated === true) {
			TrailService.fetchSubmission(trailSubmissionType)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	$scope.createTrail = function(trail, validated) {
		if(validated === true) {
			// do i need to add the date
			TrailService.createTrail(trail)
				.then(function(result) {
					$scope.displayStatus(result.data);
				});
		}
	};

	$scope.updateTrail = function(trail, validated) {
		if(validated === true) {
			// do i need to add date.
			TrailService.update(trail.trailId, trail)
				.then(function(result) {
					$scope.displayStatus(result.data);
					$scope.cancelEditing();
					$scope.getTrails();
				});
		}
	};


}]);