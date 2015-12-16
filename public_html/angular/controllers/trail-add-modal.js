app.controller("TrailAddModal", ["$scope", "$uibModalInstance", function($scope, $uibModalInstance) {
	$scope.points = [];

	$scope.geoFindMe = function() {
		if(!navigator.geolocation) {
			$scope.alerts[0] = {type: "danger", msg: "Uninstall IE. Good fucking luck!"};
			return;
		}

		function success(position) {
			var longitude = position.coords.longitude;
			var latitude = position.coords.latitude;
			$scope.points.push([latitude, longitude]);
		}

		function error() {
			$scope.alerts[0] = {type: "danger", msg: "Can't get location (user probably declined/ignored request)."};
		}

		navigator.geolocation.getCurrentPosition(success, error);
	};

	$scope.ok = function() {
		$uibModalInstance.close($scope.points);
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);