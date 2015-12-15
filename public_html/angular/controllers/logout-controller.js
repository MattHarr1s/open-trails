app.controller("LogoutController", ["$scope", "LogoutService", function($scope, LogoutService) {
	$scope.logOut = function() {
		LogoutService.logout();
		location.reload(true);
	}
}]);