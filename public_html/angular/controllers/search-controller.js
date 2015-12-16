app.controller("TrailSearchController", ["$scope", "$location", "TrailService", "SearchService", function($scope, $location, TrailService, SearchService) {
	$scope.flags = {trailName: "", selectedDifficulties: [], trailDistance: 0, selectedUses: []};
	$scope.trails = [];
	$scope.alerts = [];
	$scope.difficulties = {1: false, 2: false, 3: false, 4: false, 5: false};
	$scope.uses = {hike: false, bike: false, wheelchair: false};

	$scope.checkDifficulty = function() {
		$scope.flags.selectedDifficulties = [];
		for(difficulty in $scope.difficulties) {
			if($scope.difficulties[difficulty] === true) {
				$scope.flags.selectedDifficulties.push(difficulty);
			}
		}
	};

	$scope.checkUse = function() {
		$scope.flags.selectedUses = [];
		for(use in $scope.uses) {
			if($scope.uses[use] === true) {
				$scope.flags.selectedUses.push(use);
			}
		}
	};

	$scope.search = function() {
		TrailService.all()
			.then(function(reply) {
				if(reply.status === 200) {
					$scope.trails = reply.data.data; // Adds trails to array
					for(var i = 0; i < $scope.trails.length; i++) {
						if($scope.flags.trailName !== "") {
							if($scope.trails[i].trailName !== $scope.flags.trailName) {
								$scope.trails[i].pop(); // Removes trail from array
							}
						}
						if(typeof $scope.flags.trailDifficulty !== "undefined") {
							if($scope.trails[i].trailDifficulty !== $scope.flags.trailDifficulty) {
								$scope.trails[i].pop(); // Removes trail from array
							}
						}
						if($scope.flags.trailDistance > 0) {
							if($scope.trails[i].trailDistance != $scope.flags.trailDistance) {
								$scope.trails[i].pop(); // Removes trail from array
							}
						}
						if(typeof $scope.flags.trailUse !== "undefined") {
							if($scope.trails[i].trailUse !== $scope.flags.trailUse) {
								$scope.trails[i].pop(); // Removes trail from array
							}
						}
					}
					SearchService.setTrails($scope.trails);
					$location.path("search-results");
				} else {
					$scope.alerts[0] = {type: "danger", msg: reply.data.message}
				}
			});
	}
}]);