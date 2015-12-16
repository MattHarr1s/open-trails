// configure our routes
app.config(function($routeProvider) {
	$routeProvider

	// route for the trail page
		.when('/trail/:trailId', {
			templateUrl: '../trail-info/trail-template.php',
			controller: 'TrailController'
		})

		.when('/', {
			templateUrl: 'angular/views/home.php'
		})

		.when('/trail-search', {
			templateUrl: 'angular/views/trail-search.php'
		});

	// route
});