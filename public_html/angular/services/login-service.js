/**
 * service for login form
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */
app.service("LoginService", function($http) {
	this.LOGIN_ENDPOINT = "../../open-trails/public_html/php/controllers/login-controller.php";

	this.login = function(loginData) {
		return ($http.post(this.LOGIN_ENDPOINT, loginData)
			.then(function(reply) {
				return (reply.data);
			}));
	};
});