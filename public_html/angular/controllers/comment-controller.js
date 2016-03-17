/**
 * controller created to handle View logic for comments this is a work in progress
 */

//define the name of the controller
app.controller("CommentController", ["$scope", "$uibModal", "CommentService", function($scope, $uibModal, CommentService) {
	$scope.comments = [];
	$scope.alerts = [];
	$scope.isEditing = false;
	$scope.editedComment = [];
	$scope.newComment = {commentId: null, trailId: null, userId: null, browser: null, createDate: null, ipAddress: null, commentPhoto: null, commentPhotoType: null, commentText: null};

	$scope.setEditedComment = function() {
		$scope.isEditing = true;
	};

	/**
	 *cancels editing and clears out the comment being edited
	 */
	$scope.cancelEditing = function() {
		$scope.isEditing = false;
	};

	/**
	 * grabs the specific comment by its ID and validates it.
	 * @param commentId
	 * @param validated either returns 200 for success or nothing if failure/danger
	 */

	$scope.getCommentId = function(commentId, validated) {																	// IS THIS A THING?????????????????????????????????
		if(validated === true) {
			CommentService.fetchId(commentId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.comment = result.data.data
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message}
					}
				});
		}
	};


	/**
	 * fulfills the promise from retrieving the comments from the comment API
	 */
	$scope.getComments = function() {
		CommentService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.comments = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};


	/**
	 * I have no idea what this line of code does or if it is even needed
	 */

	$scope.getCurrentComment = function() {
		CommentService.fetchCurrent()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.comment = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	/**
	 * grabs the comments based on the trail Id most important get param because all comments need to be tied to a trail
	 * @param trailId
	 * @param validated
	 */

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

	/**
	 * grabs the comment by the userId if no user is signed in the person will not be able to make a comment
	 * @param userId Primary key for the user, used for validation in API
	 * @param validated
	 */

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

	/**
	 * Creates a brand new comment and passes it to the API for insertion into the database
	 * @param comment
	 * @param validated
	 */
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

	/**
	 * checks to make sure that the comment being edittied exists then passes it the backend for storage
	 * @param comment
	 * @param validated must equal 200 for sucess
	 */
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

	/**
	 * Creates a prompt that will make sure the person wants to delete their comment, if selected yes the comment is then deleted from the backend, with a 200 form the API of course
	 * @param commentId
	 */
	$scope.deleteComment = function(commentId) {
		// create a modal to ask for confirmation
		var message = "Do you really want to delete this comment?";
		var modalHtml = '<div class="modal-body">' + message + '</div><div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';
		var modalInstance = $uibModal.open({
			template: modalHtml,
			controller: ModalInstanceCtrl
		});

		// if yes is selected, delete the comment
		modalInstance.result.then(function() {
			CommentService.destroy(commentId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				})
		});
	};
}]);

/**
 * this need to be moved to its own file
 * @param $scope
 * @param $uibModalInstance
 * @constructor
 */
	// modal instance controller for deletion prompt
	var ModalInstanceCtrl = function($scope, $uibModalInstance) {
		$scope.yes = function() {
			$uibModalInstance.close();
		};
		$scope.no = function() {
			$uibModalInstance.dismiss('cancel');
		};
	};