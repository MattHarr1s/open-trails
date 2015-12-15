// configure our routes
app.config(function($routeProvider) {
	$routeProvider

	// route for the trail page
		.when('/Trail/:trailId', {
			templateUrl: 'george.php',
			controller: 'TrailController'
		})
});