app.controller("TrailSearchController", ["$scope", "TrailService", function($scope, TrailService) {
	$scope.flags = {};
	$scope.trails = [];
	$scope.alerts = [];

	$scope.search = function() {
		if(isset($scope.flags.trailName)) {
			TrailService.fetchName($scope.flags.trailName)
				.then(function(reply) {
					if(reply.status === 200) {
						if(reply.data.submitTrailId == null) {
							$scope.trails.push(reply.data); // Adds trail to array
						}
					} else {
						$scope.alerts[0] = {type: "danger", msg: reply.data.message}
					}
				});
		}
		if(isset($scope.flags.trailDifficulty)) {
			TrailService.fetchDifficulty($scope.flags.trailDifficulty)
				.then(function(reply) {
					if(reply.status === 200) {
						if(reply.data.submitTrailId == null) {
							$scope.trails.push(reply.data); // Adds trail to array
						}
					} else {
						$scope.alerts[0] = {type: "danger", msg: reply.data.message}
					}
				});
		}
		if(isset($scope.flags.trailDistance)) {
			TrailService.fetchDistance($scope.flags.trailDistance)
				.then(function(reply) {
					if(reply.status === 200) {
						if(reply.data.submitTrailId == null) {
							$scope.trails.push(reply.data); // Adds trail to array
						}
					} else {
						$scope.alerts[0] = {type: "danger", msg: reply.data.message}
					}
				});
		}
		if(isset($scope.flags.trailUse)) {
			TrailService.fetchUse($scope.flags.trailUse)
				.then(function(reply) {
					if(reply.status === 200) {
						if(reply.data.submitTrailId == null) {
							$scope.trails.push(reply.data); // Adds trail to array
						}
					} else {
						$scope.alerts[0] = {type: "danger", msg: reply.data.message}
					}
				});
		}

		for(var i = 0; i < $scope.trails.length; i++) {
			if(isset($scope.flags.trailName)) {
				if($scope.trails[i].trailName != $scope.flags.trailName) {
					$scope.trails[i].pop(); // Removes trail from array
				}
			}
			if(isset($scope.flags.trailDifficulty)) {
				if($scope.trails[i].trailDifficulty != $scope.flags.trailDifficulty) {
					$scope.trails[i].pop(); // Removes trail from array
				}
			}
			if(isset($scope.flags.trailDistance)) {
				if($scope.trails[i].trailDistance != $scope.flags.trailDistance) {
					$scope.trails[i].pop(); // Removes trail from array
				}
			}
			if(isset($scope.flags.trailUse)) {
				if($scope.trails[i].trailUse != $scope.flags.trailUse) {
					$scope.trails[i].pop(); // Removes trail from array
				}
			}
		}
	}
}])