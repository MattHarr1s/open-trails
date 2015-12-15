app.controller("LoginController", ["$scope", "$uibModal", "$window", "AlertService", "LoginService", function($scope, $uibModal, $window, AlertService, LoginService) {
	$scope.loginData = {};

	$scope.openLoginModal = function () {
		var signupModalInstance = $uibModal.open({
			templateUrl: "../../js/views/login-modal.php",
			controller: "LoginModal",
			resolve: {
				signinData: function () {
					return($scope.signinData);
				}
			}
		});
		signupModalInstance.result.then(function (loginData) {
			$scope.loginData = loginData;
			LoginService.login(loginData)
				.then(function(reply) {
					if(reply.status === 200) {
						AlertService.addAlert({type: "success", msg: reply.message});
						$window.location.assign("../../php/template/login-landing-page.php")
					} else {
						AlertService.addAlert({type: "danger", msg: reply.message});
					}
				});
		}, function() {
			$scope.loginData = {};
		});
	};
}]);