app.controller("TrailAlertModal", ["$scope", "$uibModalInstance", function($scope, $uibModalInstance) {
	$scope.trail = {};

	$scope.ok = function() {
		$uibModalInstance.close($scope.trail);
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);