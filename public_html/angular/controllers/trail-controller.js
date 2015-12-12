
app.controller ("Trail-Controller", ["$scope", "$uiModal", "TrailService", function($scope, $uibModal, TrailService) {
	// get the trail from the api
	// come back to add other
	// make doc blocks way better

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
		if (validated === true) {
			TrailService.fetchUserId(userId)
				.then(function(result){
					if(result.data.status === 200){
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};
	$scope.getSubmitId = function(submitId, validated) {
		if (validated === true) {
			TrailService.fetchSubmitId(submitId)
				.then(function(result){
					if(result.data.status === 200) {
						$scope.trails = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	$scope.getSubmission = function(submission, validated) {
		if (validated === true) {
			TrailService.fetchSubmission(submission)
				.then(function(result) {
					if(result.data.status === 200){
						$scope.trails = result.data.data
					} else {
						$scope.alrts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};
	$scope.getName = function(name, validated) {
		if (validated === true) {
			TrailService.fetchName(name)
		}
	}




}]);