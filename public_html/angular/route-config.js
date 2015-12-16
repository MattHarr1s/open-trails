// configure our routes
app.config(function($routeProvider) {
	$routeProvider

	// route for the trail page
		.when('/trail/:trailId', {
			templateUrl: '../trail-info/trail-info.php',
			controller: 'TrailController'
		})

		.when('/', {
			templateUrl: 'angular/views/home.php'
		})

		.when('/trail-search', {
			templateUrl: 'angular/views/trail-search.php'
		})

		.when('/trail-site-info', {
			templateUrl: 'angular/views/trail-site-info.php'
		})

		.when('/trail-suspended-user', {
			templateUrl: 'angular/views/trail-suspended-user.php'
		})

		.when('/trail-update', {
			templateUrl: 'angular/views/trail-update.php'
		})

		.when('/trail-update-approval', {
			templateUrl: '/angular/views/trail-update-approval.php'
		});

	// route
});