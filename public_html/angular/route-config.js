// configure our routes
trailQuail.config(function($routeProvider) {
	$routeProvider

	// route for the trail page
		.when('/', {
			templateUrl: '../../trail-info/index.php',
			controller: 'TrailController'
		})

		// route for comments
		.when('/', {
			templateUrl: '../../trail-info/index.php',
			controller: 'CommentController'
		})

		// route for segments
		.when('/', {
			templateUrl: '../../trail-info/index.php',
			controller: 'SegmentController'
		});
});

// create the controller and inject Angular's $scope
trailQuail.controller('TrailController', function($scope) {
	// create a message to display in our view
	$scope.message = 'Blah blah blah';
});

trailQuail.controller('CommentController', function($scope) {
	$scope.message = 'something';
});

trailQuail.controller('SegmentController', function($scope) {
	$scope.message = 'something else';
});