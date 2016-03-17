/**
 * service for sign-up form
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */
app.service("SignupService", function($http, $q) {
	this.SIGNUP_ENDPOINT = "../public_html/php/controllers/sign-up-controller.php";

	//beginning of Closure to add a new user
	this.addUser = function(user) {

		// return of the method post to the user controller
		return($http.post(this.SIGNUP_ENDPOINT, user)
			.then(function(reply) {
				//make sure reply is an object, if it is accept it
				if(typeof reply.data === "object") {
					return(reply.data);
				//if it is not an object reject it
				} else {
					return ($q.reject(reply.data));
				}
			}, function(reply) {
				return($q.reject(reply.data));
			}));
	};
});