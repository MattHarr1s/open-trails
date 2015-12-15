/**
 * service for logout form
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */

app.service("LogoutService", function($http) {
	this.LOGOUT_ENDPOINT = "php/controllers/logout-controller.php";

	this.logout = function() {
		return($http.get(this.LOGOUT_ENDPOINT));
	}
});