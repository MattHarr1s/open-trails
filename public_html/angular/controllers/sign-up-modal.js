/**
 * modal for sign-up form
 *
 * @author Louis Gill <lgill7@cnm.edu>
 */

app.controller("SignupModal", ["$scope", "$uibModalInstance", "signupData", function($scope, $uibModalInstance, signupData) {
	$scope.signupData = signupData;

	$scope.ok = function() {
		$uibModalInstance.close($scope.signupData);
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss("cancel");
	};
}]);