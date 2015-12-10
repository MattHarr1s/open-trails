app.controller("CommentController", ["$scope", "$uibModal", "CommentService", function($scope, CommentService) {
	$scope.
}, SignupService) {
	$scope.signupData = {};

	$scope.openSignupModal = function() {
		var signupModalInstance = $uibModal.open({
			templateUrl: "angular/views/create-account-form.php",
			controller: "SignupModal",
			resolve: {
				signupData: function() {
					return ($scope.signupData);
				}
			}
		});
		signupModalInstance.result.then(function(signupData) {
			$scope.signupData = signupData;
			SignupService.signup(signupData)
				.then(function(reply) {
					if(reply.status === 200) {
						AlertService.addAlert({type: "success", msg: reply.message});
						$window.location.reload();
					} else {
						AlertService.addAlert({type: "danger", msg: reply.message});
					}
				});
		}, function() {
			$scope.signupData = {};
		});
	};
}
]);
