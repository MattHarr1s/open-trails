<!-------------------------------------------------------->
<!-- This is the search for trails form for the Trail Quail website -->
<!-- 																	  -->
<!-- @author saulj@me.com  (December 2015)  				  -->
<!-------------------------------------------------------->

<!-- The div class="form-wrap" is the black box containing the form. It's set to a column width of 12 for small screens, and a column width of 6 for medium screens on up -->

<div class="form-wrap container">

	<!-- Form is centered within it's container, and is set to 10 be columns wide RELATIVE TO IT'S CONTAINER, and offset to the right by one column. See classes: col-xs-offset-1 & col-xs-10 -->
	<form method="post" ng-submit="search();" id="searchTrails-form" class="form-horizontal">

		<!-- Enter Trail Name -->
		<div class="form-group">
			<!-- Labels for each field are places within a <label> tag. Use the "for" attribute. the class="control-label" is for styling. -->
			<label for="searchTrailName" class="control-label">Trail Name</label>
			<!-- the div class="input-group" contains both the text field and the icon to the left -->
			<div class="input-group">
				<!-- this div and span contains the glyphicon to the left. aria-hidden is so that screen readers don't read this element -->
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
				</div>
				<!-- text field input. pay attention to the id, placeholder text, type, and placeholder attributes -->
				<input ng-model="flags.trailName" type="text" class="form-control" id="searchTrailName"
						 placeholder="If you know the trail name, please enter it here." maxlength="150"/>
			</div>
		</div>

		<!-- Enter Trail Difficulty -->
		<br>

		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">Select Trail Difficulty</label>
						<!--	use div class=“help-block” to explain the form content	-->
						<div class="help-block">Please check all that apply</div>
						<div class="help-block">(Easy to hard)</div>
						<div class="checkbox" ng-repeat="(difficulty, enabled) in difficulties">
							<label for="difficulties" class="checkbox">
								<input name="difficulties" type="checkbox" ng-change="checkDifficulty();"
										 ng-model="difficulties[difficulty]"/>{{difficulty}}
							</label>
						</div>
					</div>
				</div>

				<!-- Data entry for minimum trail distance -->
				<div class="col-md-4">

					<div class="form-group">
						<label for="distanceRadio" class="control-label">Select Minimum Trail Distance</label>
						<!--	use div class=“help-block” to explain the form content	-->
						<div class="help-block">Please check one box. All trails with that distance or greater will be listed.
						</div>
						<!-- Radio buttons here -->
						<div class="radio">
							<label for="distance">
								<input name="distance" ng-model="flags.trailDistance" type="radio" value="2"/> less than 2 mi
							</label>
						</div>
						<div class="radio">
							<label for="distance">
								<input name="distance" ng-model="flags.trailDistance" type="radio" value="5"/> less than 5 mi
							</label>
						</div>
						<div class="radio">
							<label for="distance">
								<input name="distance" ng-model="flags.trailDistance" type="radio" value="10"/> less than 10 mi
							</label>
						</div>
						<div class="radio">
							<label for="distance">
								<input name="distance" ng-model="flags.trailDistance" type="radio" value="20"/> less than 20 mi
							</label>
						</div>
						<div class="radio">
							<label for="distance">
								<input name="distance" ng-model="flags.trailDistance" type="radio" value="0"/> no limit
							</label>
						</div>
					</div>
				</div>
				<!-- End of column 2: entering desired minimum distance-->

				<!-- Column 3: entering trail uses -->

				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">Select Trail use</label>
						<!--	use div class=“help-block” to explain the form content	-->
						<div class="help-block">Please check all that apply</div>
						<div class="checkbox" ng-repeat="(use, enabled) in uses">
							<label for="uses" class="checkbox">
								<input name="uses" type="checkbox" ng-change="checkUse();" ng-model="uses[use]"/>{{use}}
							</label>
						</div>
					</div>

				</div>
			</div>
		</div>
		<br>


		<!-- buttons for submit and reset -->
		<div class="form-horizontal">
			<button class="btn btn-md btn-info pull-right" type="submit">Search</button>
		</div>
		<hr>

	</form>
</div>