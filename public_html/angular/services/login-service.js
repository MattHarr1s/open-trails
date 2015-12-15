/**
 * service for login form
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */
app.service("LoginService", function($http) {
	this.LOGIN_ENDPOINT = "../../open-trails/public_html/php/controllers/login-controller.php";

	this.login = function(loginData) {
		console.log("1");
		console.log(loginData);
		return ($http.post(this.LOGIN_ENDPOINT, loginData)
			.then(function(reply) {
				console.log("2");
				console.log(reply.data);
				console.log("3");
				return (reply.data);
			}));
	};
});