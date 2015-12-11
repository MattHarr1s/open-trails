app.controller("CommentController", ["$scope", "$uibModal", "SegmentService", function($scope, $uibModal, SegmentService) {
	$scope.segments = [];
	$scope.alerts = [];
	$scope.numSegments = 2;

	$scope.getCommentId = function(commentId, validated) {
		if (validated === true) {
			CommentService.fetchId(commentId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.comments = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	}
};

	$scope.getComments = function() {
		CommentService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.organizations = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	$scope.getCommentByTrailId = function(trailId, validated) {
		if(validated === true) {
			CommentService.fetchTrailId(trailId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.comments = result.data.data;
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.getCommentByUserId = function(userId, validated) {
		if(validated === true) {
			CommentService.fetchUserId(userId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.comments = result.data.data;
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.createComment = function(comment, validated) {
		if(validated === true) {
			CommentService.create(comment)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.updateComment = function(comment, validated) {
		if(validated === true && $scope.isEditing === true) {
			CommentService.update(comment.commentId, comment)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						//cancel the editing mode
						$scope.isEditing = false;
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	// delete the comment
])