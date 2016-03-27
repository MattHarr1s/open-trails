<div class="container">
	<div class="row">
		<!--map container-->
		<div class="col-md-6">
			<ng-map zoom="15" center="{{points[0]}}" map-type-id="SATELLITE">
				<shape name="polyline"
						 path="{{points}}"
						 geodesic="true"
						 stroke-color="#FF0000"
						 stroke-opacity="1.0"
						 stroke-weight="2">
				</shape>
			</ng-map>
		</div>
		<!--data column-->
		<div class="col-md-6">
			<div>
				<h1>Trail Name: {{currentTrail.trailName}}</h1>
				<hr/>

				<p>
					<span class="fa-stack fa-lg">
						<i class="fa fa-male fa-stack-1x"></i>
						<i class="fa fa-ban fa-stack-2x text-danger"
							ng-hide="currentTrail.trailUse.indexOf('foot: yes') != -1"></i>
					</span>

					<span class="fa-stack fa-lg">
						<i class="fa fa-bicycle fa-stack-1x"></i>
						<i class="fa fa-ban fa-stack-2x text-danger"
							ng-hide="currentTrail.trailUse.indexOf('bicycle: yes') != -1"></i>
					</span>

					<span class="fa-stack fa-lg">
						<i class="fa fa-wheelchair fa-stack-1x"></i>
						<i class="fa fa-ban fa-stack-2x text-danger"
							ng-hide="currentTrail.trailUse.indexOf('wheelchair: yes') != -1"></i>
					</span>
				</p>

				<p>Distance (mi): {{currentTrail.trailDistance | number:3}}</p>

				<p>Difficulty: {{currentTrail.trailDifficulty}}</p>

				<p>Description: {{currentTrail.trailDescription}}</p>
				<br>
				<a class="btn btn-md btn-info" ng-click="openPointAddModal();">Update Map</a>

				<!-- YEAH? HOW DO I ADD TRAIL ALERT TO TRAIL CONTROLLER? -->
				<a class="btn btn-default btn-def" ng-click="openTrailAlertModal();">
					<i class="fa fa-check" aria-hidden="true"></i>Trail Alert
				</a>
				<!--				<button class="btn btn-md btn-warning" type="reset">Trail Alert</button>-->
				<!--continue to fill in content next to map here-->
				<!--				<trail-view></trail-view>-->
			</div>
		</div>
	</div>
	<divcomment-view></div>


	<!-- End of row 1  -->

	<!--	<div class="row comment-margin1	">-->
	<!-- Trail comment form inserted here -->
	<!--		<div class="col-md-12 embed-responsive embed-responsive-4by3">-->
	<!--			<h2 class="page-title">Enter Your Comment(s) for this Trail</h2>-->
	<!--			--><?php //require_once(dirname(dirname(__DIR__)) . "/angular/views/comment-form.php"); ?>
	<!--		</div>-->
	<!--	</div>-->
	<!--	<br>-->
	<!--	<hr>-->
	<!---->
	<!-- Trail comments from database will show below here -->
	<!--	<div class="row" ng-repeat="comment in comments">-->
	<!--		<div class="panel panel-primary">-->
	<!--			<div class="panel-body">-->
	<!--				<p>{{comment.commentText}}</p>-->
	<!--				<small>Posted on: {{comment.createDate | date:"MM/dd/yyyy 'at' h:mma"}}</small>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</div>-->


</div>
<!--.container-->
