app.controller("LoginController", ["$scope", "$uibModal", "LoginService", function($scope, $uibModal, LoginService) {
	$scope.loginData = {};

	$scope.openLoginModal = function () {
		var loginModalInstance = $uibModal.open({
			templateUrl: "angular/views/login-form.php",
			controller: "LoginModal",
			resolve: {
				loginData: function() {
					return($scope.loginData);
				}
			}
		});
		loginModalInstance.result.then(function(loginData) {
			$scope.loginData = loginData;
			LoginService.login(loginData)
				.then(function(reply) {
					if(reply.status === 200) {
						AlertService.addAlert({type: "success", msg: reply.message});
						$window.location.reload();
					} else {
						AlertService.addAlert({type: "danger", msg: reply.message});
					}
				});
		}, function() {
			$scope.loginData = {};
		});
	};
}]);







/**app.controller("LoginController", function($http, LoginService, $window, $scope) {
	$scope.user = null;
	$scope.statusClass = "alert-success";
	$scope.statusMessage = null;

	/**
	 * method that controls the action table and will fill the table or display errors
	 */

	/**$scope.login = function(user) {
		$http.post("../../php/controllers/login-controller.php", user)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					if(reply.status === 200) {
						$window.location.href = "../../index.php"
					}
				} else {
					return($q.reject(reply.data));
				}
			});
	};

	$scope.logout = function() {
		$http.get("../../php/controllers/logout-controller.php")
			.then(function(reply) {
				if(typeof reply.data === "object") {
					if(reply.status === 200) {
						$window.location.href = "../../index.php"
					}
				}
		});
	};
})

**/