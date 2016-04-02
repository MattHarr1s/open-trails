app.controller("TrailController", ["$scope", "$routeParams", "$uibModal", "TrailService", "CommentService", function($scope, $routeParams, $uibModal, TrailService, CommentService) {
	// get the trail from the api
	// come back to add other
	// make doc blocks way better
	$scope.currentTrailId = $routeParams.trailId;
	$scope.currentTrail = null;
	$scope.newTrail = {
		trailId: null,
		userId: null,
		browser: null,
		createDate: null,
		ipAddress: null,
		submitTrailId: null,
		trailAmenities: null,
		trailCondition: null,
		trailDescription: null,
		trailDifficulty: null,
		trailDistance: null,
		trailName: null,
		trailSubmissionType: null,
		trailTerrain: null,
		trailTraffic: null,
		trailUse: null,
		trailUuid: null
	};
	$scope.isEditing = false;
	$scope.points = [];
	$scope.trails = [];
	$scope.alerts = [];
	$scope.trailToSubmit = {};
	//$scope.comments = CommentService.fetchTrailId($scope.currentTrailId);
	/**
	$scope.newComment = {
		commentId: null,
		trailId: null,
		userId: null,
		browser: null,
		createDate: null,
		ipAddress: null,
		commentPhoto: null,
		commentPhotoType: null,
		commentText: null
	};
	*/

	$scope.openTrailAlertModal = function() {
		var TrailAlertModalInstance = $uibModal.open({
			templateUrl: "angular/views/trail-alert-modal.php",
			controller: "TrailAlertModal",
			resolve: {
				trails: function() {
					return ($scope.trailCondition);
				}
			}
		});
		TrailAlertModalInstance.result.then(function(trailCondition) {
			$scope.trailToSubmit = $scope.currentTrail;
			$scope.trailToSubmit.trailCondition = trailCondition;
			$scope.trailToSubmit.trailUuid = null;
			$scope.trailToSubmit.submitTrailId = $scope.trailToSubmit.trailId;
			$scope.trailToSubmit.trailId = null;
			TrailService.create($scope.trailToSubmit).then(function(result) {
				if(result.data.status === 200) {
					$scope.alerts[0] = {type: "success", msg: result.data.message};
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
		});
	};

	// Point add modal
	$scope.openPointAddModal = function() {
		var TrailAlertModalInstance = $uibModal.open({
			templateUrl: "angular/views/trail-add-modal.php",
			controller: "TrailAddModal",
			resolve: {
				trails: function() {
					return ($scope.points);
				}
			}
		});
		TrailAlertModalInstance.result.then(function(points) {
			//TrailService.create($scope.trailToSubmit).then(function(result) {
			//	if(result.data.status === 200) {
			//		$scope.alerts[0] = {type: "success", msg: result.data.message};
			//	} else {
			//		$scope.alerts[0] = {type: "danger", msg: result.data.message};
			//	}
			//});
		});
	};


	$scope.getTrailId = function(trailId, validated) {
		if(validated === true) {
			TrailService.fetchId(trailId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.trails = result.data.data;
						$scope.currentTrail = result.data.data;
						$scope.getPoints(result.data.data.trailId, true); // TODO: Check this
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
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.updateTrail = function(trail, validated) {
		if(validated === true) {
			// do i need to add date.
			TrailService.update(trail.trailId, trail)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
					$scope.cancelEditing();
					$scope.getTrails();
				});
		}
	};

	$scope.getPoints = function(trailId, validated) {
		if(validated === true) {

			TrailService.fetchPoints(trailId)
				.then(function(result) {
					if(result.data.status === 200) {
						//console.log(result.data);
						$scope.points = result.data.points;
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};

	$scope.createComment = function(newComment, validated) {
		if(validated === true) {
			newComment.trailId = $scope.currentTrailId;
			CommentService.create(newComment)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	console.log($routeParams);
	if($scope.currentTrail === null && $scope.currentTrailId !== null) {
		$scope.getTrailId($scope.currentTrailId, true);
	}
}]);