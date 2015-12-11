/**
 * service for sign-up form
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */
app.service("SignupService", function($http, $q) {
	this.SIGNUP_ENDPOINT = "../../php/controllers/sign-up-controller.php";													// ???????????????????????????

	this.addUser = function(user) {
		return($http.post(this.SIGNUP_ENDPOINT, user)
			.then(function(reply) {
				if(typeof reply.data === "object") {
					return(reply.data);
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return($q.reject(reply.data));
			}));
	};
});