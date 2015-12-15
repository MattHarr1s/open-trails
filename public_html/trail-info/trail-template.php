<div class="container">
	<div class="row">
		<!--map container-->
		<div class="col-md-6 embed-responsive embed-responsive-4by3">
			<div id="map"></div>
		</div>
		<!--data column-->
		<div class="col-md-6">
			<div ng-controller="TrailController">
				<trail-view></trail-view>
				<h1>Trail Name: {{currentTrail.trailName}}</h1>
				<hr/>
				<p>Distance (mi): {{currentTrail.trailDistance}}</p>
				<p>Difficulty: {{currentTrail.trailDifficulty}}</p>
				<p>Use: {{currentTrail.trailUse}}</p>
				<p>Description: {{currentTrail.trailDescription}}</p>
				<br>
				<button class="btn btn-md btn-info" type="submit">Trail Corrections</button>
				<button class="btn btn-md btn-warning" type="reset">Trail Alert</button>
				<!--continue to fill in content next to map here-->
				<!--				<trail-view></trail-view>-->
			</div>

		</div>
		<!--.row-->

		<!-- Trail comment form inserted here -->
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<h2 class="page-title">Enter Your Comment(s) for this Trail</h2>
				<?php require_once(dirname(__DIR__) . "/angular/views/comment-form.php"); ?>
			</div>
		</div>
		<br>
		<hr>

		<!-- Trail comments from database will show below here -->
		<div ng-controller="CommentController">
			<div ng-repeat="comment in comments">
				<comment-view></comment-view>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<!--				List of trail comments here-->
			</div>
		</div>


	</div>
	<!--.container-->
</div>