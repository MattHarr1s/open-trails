app.controller("GoogleMapsController", ["$scope", "uiGmapGoogleMapApi", function($scope, uiGmapGoogleMapApi) {
	$scope.markers = [];

	// uiGmapGoogleMapApi is a promise.
	// The "then" callback function provides the google.maps object.
	uiGmapGoogleMapApi.then(function(maps) {

	});
}]);