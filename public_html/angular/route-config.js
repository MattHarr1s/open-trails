// configure our routes
app.config(function($routeProvider) {
	$routeProvider

	// route for the trail page
		.when('/Trail/:trailId', {
			templateUrl: '../../trail-info/index.php',
			controller: 'TrailController'
		})
});