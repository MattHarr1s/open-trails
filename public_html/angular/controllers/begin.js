app.controller("BeginTrackModal", ["$scope", "$uibModalInstance", function($scope, $uibModalInstance) {
	$scope.geoFindMe() = [];

	$scope.ok = function() {
		$uibModalInstance.close($scope.geoFindMe());
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);