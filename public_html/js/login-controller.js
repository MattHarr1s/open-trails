app.controller("SigninController", ["$scope", "$uibModal", "$window", "AlertService", "SigninService", function($scope, $uibModal, $window, AlertService, SigninService) {
	$scope.signinData = {};

	$scope.openSigninModal = function () {
		var signupModalInstance = $uibModal.open({
			templateUrl: "../../js/views/signin-modal.php",
			controller: "SigninModal",
			resolve: {
				signinData: function () {
					return($scope.signinData);
				}
			}
		});
		signupModalInstance.result.then(function (signinData) {
			$scope.signinData = signinData;
			SigninService.signin(signinData)
				.then(function(reply) {
					if(reply.status === 200) {
						AlertService.addAlert({type: "success", msg: reply.message});
						$window.location.assign("../../php/template/login-landing-page.php")
					} else {
						AlertService.addAlert({type: "danger", msg: reply.message});
					}
				});
		}, function() {
			$scope.signinData = {};
		});
	};
}]);