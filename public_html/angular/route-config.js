// configure our routes
app.config(function($routeProvider) {
	$routeProvider

		// route for the trail page
		.when('/trail/:trailId', {
			templateUrl: '../trail-info/trail-template.php',
			controller: 'TrailController'
		})
});