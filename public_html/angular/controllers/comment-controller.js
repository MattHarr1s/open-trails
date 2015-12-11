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

	$scope.getComment
])