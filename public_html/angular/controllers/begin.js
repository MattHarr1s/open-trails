app.controller("BeginTrackModal", ["$scope", "$uibModalInstance", function($scope, $uibModalInstance) {
	$scope.trailCondition = "";

	$scope.ok = function() {
		$uibModalInstance.close($scope.);
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);