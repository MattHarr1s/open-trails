app.controller("TrailAlertModal", ["$scope", "$uibModalInstance", function($scope, $uibModalInstance) {
	$scope.trailCondition = "";

	$scope.ok = function() {
		$uibModalInstance.close($scope.trailCondition);
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);