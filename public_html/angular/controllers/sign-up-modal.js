app.controller("SignupModal", ["$scope", "$uibModalInstance", function($scope, $uibModalInstance) {
	$scope.signupData = {};

	$scope.ok = function() {
		$uibModalInstance.close($scope.signupData);
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);