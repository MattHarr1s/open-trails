/**
 * Created by George on 3/30/16.
 */
app.controller('commentsController', ['$scope', "$uibModal", 'commentService', function($scope, $uibModal, commentService) {
	$scope.commentData = {};
	$scope.alerts = [];
	$scope.isEditing = false;
	$scope.username = null;
	$scope.user = null;
	$scope.trailId = null;
	$scope.comments = [];
	$scope.

	$scope.getCommentByTrailId = function() {
		$scope.trailId = $scope.currentTrailId;
		commentService.fetchTrailId($scope.trailId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.comments = result.data.data;
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "comments could not be loaded"
					}
				}
			})
	};
	if($scope.comments.length === 0 && $scope.trail !== null) {
		$scope.comments = $scope.getCommentByTrailId()

	}
	
	

}]);
