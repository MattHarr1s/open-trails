app.controller("SegmentController", ["$scope", "$uibModal", "SegmentService", function($scope, SegmentService){
	//add as needed will come back to add doing of off bradly history on organization
	$scope.segments = [];
	$scope.alerts = [];
	$scope.numSegments = 2;

	//get segments from api
	//come back for other gets
	// make doc blocks better
	$scope.getSegments = function() {
		SegmentService.all()
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.segments = result.data.data;
					} else {
						$scope.alerts[0] = {type: "danger, msg: result.data.message"};
					}
				});

	};

	//create new segment
	$scope.createSegment = function(segment, validated) {
		if(validated === true) {

			SegmentService.create(segment)
					.then(function(result) {
						if(result.data.status === 200) {
							$scope.alerts[0] = {type: "success", msg: result.data.message};
						} else {
							$scope.alerts[0] = {type: "danger", msg: result.data.message};
						}
					});
		}
	};

	//update the organization
	$scope.updateSegment = function(segment, validated) {
		if(validated === true && $scope.isEditing === true) {
			//this line of code is violating type hinting why?
			SegmentService.update(segment.Id, segment)
					.then(function(result) {
						if(result.data.status === 200) {
							$scope.alerts[0] = {type: "success", msg: result.data.message};
						} else {
							$scope.alerts[0] = {type: "danger", msg: result.data.message};
						}
					});
		}
	};








}]);