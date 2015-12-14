// configure our routes
app.config(function($routeProvider) {
	$routeProvider

	// route for the trail page
		.when('/', {
			templateUrl: '../../trail-info/index.php'
		})
});