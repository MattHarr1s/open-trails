app.controller("SearchResultsController", ["$scope", "SearchService", function($scope, SearchService) {
	$scope.trails = SearchService.getTrails();
}]);