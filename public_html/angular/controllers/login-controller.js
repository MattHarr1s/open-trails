







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