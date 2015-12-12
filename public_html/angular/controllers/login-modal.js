app.controller("LoginModal", ["$scope", "$uibModalInstance", function($scope, $uibModalInstance) {
	$scope.loginData = {};

	console.log($scope.loginData);

	$scope.ok = function() {
		$uibModalInstance.close($scope.loginData);
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);