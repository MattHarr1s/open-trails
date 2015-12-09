app.controller("SignupController", function($http, SignupService, $scope, $window) {
	$scope.user = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controlls the action table and will fill the table or display errors
	 */
	$scope.addUser = function(user) {
		if(user.password === user.verifyPassword) {
			SignupService.addUser(user)
				.then(function(reply) {
					if(reply.status === 200) {
						$window.location.href = "../lib/angular/controllers";																				file path?????
					} else {
						$scope.statusClass = "alert-danger";
						$scope.statusMessage = reply.message;
					}
				});
		}
	}
});