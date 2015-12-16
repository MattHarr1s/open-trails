<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Search results:</h1>
		</div>
	</div>
	<div class="row" ng-repeat="trail in trails">
		<div class="col-md-12">
			<a class="btn" href="#/trail/{{trail.trailId}}">
				<div class="panel panel-primary text-center">
					<div class="panel-heading">{{trail.trailName}}</div>
					<div class="panel-body">
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
					</div>
				</div>
			</a>
		</div>
	</div>
</div>
