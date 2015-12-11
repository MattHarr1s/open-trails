/**
 * modal for sign-up form
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */

app.controller("SignupModal", ["$scope", "$uibModalInstance", function($scope, $uibModalInstance) {
	$scope.signupData = {};

	$scope.ok = function() {
		$uibModalInstance.close($scope.signupData);
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);