<div class="container">
	<div class="row" ng-repeat="trail in trails">
		<a class="well" href="#/trail/{{trail.trailId}}">
			<h2>{{trail.trailName}}</h2>

			<p>{{trail.trailDescription}}</p>

			<p>
					<span class="fa-stack fa-lg">
						<i class="fa fa-male fa-stack-1x"></i>
						<i class="fa fa-ban fa-stack-2x text-danger"
							ng-hide="trail.trailUse.indexOf('foot: yes') != -1"></i>
					</span>

					<span class="fa-stack fa-lg">
						<i class="fa fa-bicycle fa-stack-1x"></i>
						<i class="fa fa-ban fa-stack-2x text-danger"
							ng-hide="trail.trailUse.indexOf('bicycle: yes') != -1"></i>
					</span>

					<span class="fa-stack fa-lg">
						<i class="fa fa-wheelchair fa-stack-1x"></i>
						<i class="fa fa-ban fa-stack-2x text-danger"
							ng-hide="trail.trailUse.indexOf('wheelchair: yes') != -1"></i>
					</span>
			</p>
		</a>
	</div>
</div>