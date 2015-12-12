<!DOCTYPE html>
<html ng-app="TrailQuail">

	<head>
		<!-- Latest compiled and minified Bootstrap CSS -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
				integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!--  -->
		<!-- ALL OTHER 3RD PARTY CSS FILES GO HERE, FONTAWESOME, GOOGLE FONTS, ETC. -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<!--  -->
		<!-- Angular.js -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.js"></script>
		<script type="text/javascript"
				  src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-messages.js"></script>
		<script type="text/javascript"
				  src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.14.3/ui-bootstrap-tpls.min.js"></script>

		<script type="text/javascript" src="../../angular/trail-quail.js"></script>
		<script type="text/javascript" src="../../angular/controllers/segment-controller.js"></script>
		<link rel="stylesheet" href="../../css/style.css" />
	</head>

	<body>
		<main class="container" ng-controller="SegmentController">
			<h1>Adios Plunker!</h1>
			<form class="form-horizontal well" ng-submit="loadArray();">
				<div class="form-group">
					<label>Number of Segments:</label>
					<div class="input-group">
						<input type="number" name="numSegments" class="form-control" ng-model="numSegments" />
					</div>
				</div>
				<button type="submit" class="btn btn-info">Set Number of Segments</button>
			</form>
			<form class="form-horizontal well">
				<div class="form-group" ng-repeat="segment in segments">
					<label>Segment {{ $index }}</label>
					<div class="input-group">
						<input type="number" ng-model="segment[0]" /> ,
						<input type="number" ng-model="segment[1]" />
					</div>
				</div>

			</form>
			<p class="well">{{ segments | json }}</p>
			<input type="submit" ng-click="update(segments)" value="Save" />
		</main>
	</body>

</html>
