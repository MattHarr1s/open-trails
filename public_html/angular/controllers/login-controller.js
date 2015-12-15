app.controller("LoginController", ["$scope", "$uibModal", "LoginService", function($scope, $uibModal, LoginService) {
	$scope.loginData = {};

	$scope.openLoginModal = function() {
		var loginModalInstance = $uibModal.open({
			templateUrl: "angular/views/login-modal.php",
			controller: "LoginModal",
			resolve: {
				loginData: function() {
					//console.log($scope.loginData);
					return ($scope.loginData);
				}
			}
		});
		loginModalInstance.result.then(function(loginData) {
			$scope.loginData = loginData;
			LoginService.login(loginData)
				.then(function(reply) {
					if(reply.status === 200) {
						//AlertService.addAlert({type: "success", msg: reply.message});
						location.reload(true);
					} else {
						//AlertService.addAlert({type: "danger", msg: reply.message});
					}
				});
		}, function() {
			$scope.loginData = {};
		});
	};
}]);