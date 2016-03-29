app.directive("commentView", function() {
	return {
		restrict: "E",
		templateUrl: "../templates/comment-view.php",
		controller: "../controllers/comments-controller.js"
	};
});