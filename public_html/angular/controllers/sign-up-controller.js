/**
 * controller for sign-up form
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */

app.controller("SignupController", ["$scope", "$uibModal", "SignupService", function($scope, $uibModal, SignupService) {
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


/**app.controller("SignupController", function($http, SignupService, $scope, $window) {
	$scope.user = {};
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controlls the action table and will fill the table or display errors
	 */
/**$scope.addUser = function(user) {
		if(user.password === user.verifyPassword) {
			SignupService.addUser(user)
				.then(function(reply) {
					if(reply.status === 200) {
						$window.location.href = "../../index.php";
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
		}
	}
 });

 */