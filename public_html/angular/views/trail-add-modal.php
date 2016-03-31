<!--This is an attempt to add a trail update form to the trail add modal. -->

<div class="form-wrap">

	<!-- Form is centered within it's container, and is set to 10 be columns wide RELATIVE TO IT'S CONTAINER, and offset to the right by one column. See classes: col-xs-offset-1 & col-xs-10 -->
	<form method="post" action="#" id="searchTrails-form" class="form-horizontal">


		<br>
		<!--	Setting up container, row, and column for this form -->
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div>Please edit the below information as needed.</div>

					<!-- Edit Trail Difficulty -->
					<div class="form-group">
						<div class="row">
							<label class="control-label">Trail Difficulty</label>
						</div>
						<!--	use div class=“help-block” to explain the form content	-->
						<div class="row">
							<div class="help-block">(1 => Easy 5=> Very Difficulty)</div>
						</div>
						<div class="row">
							<div class="checkbox">
								<label class="checkbox col-md-1">
									<!--	name value contains square brackets which makes it easy to create an array on the back end in php	-->
									<input id="chkTrailDifficulty1" name="chkTrailDifficulty[]" type="checkbox" value="1"/>1
								</label>
								<label class="checkbox col-md-1">
									<input id="chkTrailDifficulty2" name="chkTrailDifficulty[]" type="checkbox" value="2"/>2
								</label>
								<label class="checkbox col-md-1">
									<input id="chkTrailDifficulty3" name="chkTrailDifficulty[]" type="checkbox" value="3"/>3
								</label>
								<label class="checkbox col-md-1">
									<input id="chkTrailDifficulty4" name="chkTrailDifficulty[]" type="checkbox" value="4"/>4
								</label>
								<label class="checkbox col-md-1">
									<input id="chkTrailDifficulty5" name="chkTrailDifficulty[]" type="checkbox" value="5"/>5
								</label>
							</div>
						</div>
					</div>


					<!-- Data correction for trail distance -->
					<div class="form-group">
						<div class="row">
							<label for="distanceRadio" class="control-label">
								Edit Minimum Trail Distance
							</label>
						</div>
						<!--	use div class=“help-block” to explain the form content	-->
						<div class="row">
							<div class="help-block">
								Please correct the trail distance as needed.
							</div>
							<div class="row">
								<div>Note: distance is in miles.</div>
								<div class="row">
									<div class="radio col-md-1">
										<!-- Row of radio buttons here -->
										<label>
											<input type="radio" name="rdoDistance" id="radioDistance1" value="1"/> 0-2
										</label>
									</div>

									<div class="radio col-md-1">
										<label>
											<input type="radio" name="rdoDistance" id="radioDistance2" value="2"/> 2-5
										</label>
									</div>

									<div class="radio col-md-1">
										<label>
											<input type="radio" name="rdoDistance" id="radioDistance3" value="3"/> 5-10
										</label>
									</div>

									<div class="radio col-md-1">
										<label>
											<input type="radio" name="rdoDistance" id="radioDistance4" value="4"/> 10-20
										</label>
									</div>

									<div class="radio col-md-1">
										<label>
											<input type="radio" name="rdoDistance" id="radioDistance5" value="5"/> >20
										</label>
									</div>

								</div>
							</div>
						</div>
					</div>


					<!-- Editing trail uses -->
					<div class="form-group">
						<div class="row">
							<label class="control-label">Edit Trail use</label>
						</div>
						<!--	use div class=“help-block” to explain the form content	-->
						<div class="row">
							<div class="help-block">Please check all that apply</div>
						</div>
						<div class="row">
							<div class="checkbox">
								<label class="checkbox col-md-1">
									<!--	name value contains square brackets which makes it easy to create an array on the back end in php	-->
									<Input id="chkTrailUseHike" name="chkTrailUse[]" type="checkbox" value="Hike"/>Hike
								</label>
								<label class="checkbox col-md-1">
									<Input id="chkTrailUseBike" name="chkTrailUse[]" type="checkbox" value="Bike"/>Bike
								</label>
								<label class="checkbox col-md-2">
									<Input id="chkTrailUseWheelChair" name="chkTrailUse[]" type="checkbox"
											 value="Wheelchair"/>Wheelchair
								</label>
								<label class="checkbox col-md-1">
									<Input id="chkTrailUseSki" name="chkTrailUse[]" type="checkbox" value="Ski"/>Ski
								</label>
								<label class="checkbox col-md-1">
									<Input id="chkTrailUseHorse" name="chkTrailUse[]" type="checkbox" value="Horse"/>Horse
								</label>
							</div>
						</div>
					</div>

					<!-- Trail Description -->
					<div class="form-group">
						<div class="row">
							<label class="control-label" for="txtareaTrailDescription">Trail Description (512 character
								limit)</label>
						</div>
						<div class="row">
							<div class="col-md-8">
								<textarea class="form-control" rows="9" id="txtareaTrailDescription" maxlength="512"
											 placeholder="Located in northern Albuquerque, the Corrales Bosque Trail offers a quick escape nearby. The trail offers scenic views of the Rio Grande.  It also offers opportunities for birding and wildlife viewing. The trail is paved at the beginning turning into a dirt and sand singletrack on a flat wooded trail along the Rio Grande. Restrooms available at the Alameda Open Space parking lot (cross the pedestrian bridge over the river & then go under Alameda to get to the parking lot from the trailhead.)"></textarea>
							</div>
						</div>
					</div>

					<!-- submit button to submit trail corrections -->
					<button class="btn btn-md btn-info" type="submit">Submit Update</button>

				</div>
			</div>
		</div>
		<br>

		<hr>

	</form>







	<!--<div class="model-body">-->
<!--	<div>-->
<!--		<form id="trackModal" name="trackModel" class="form-inline">-->
<!--			<h2> Let Us Track Your Progress</h2>-->
<!--			<button class="btn btn-info" ng-click="geoFindMe();">Begin Tracking</button>-->
<!--			<h2>Save Your Progress</h2>-->
<!--			<button class="btn btn-info" ng-click="ok();">Save Trail</button>-->
<!--			<button class="btn btn-danger" ng-click="cancel();">Cancel</button>-->
<!--			<p>-->
<!--				{{points}}-->
<!--			</p>-->
<!--		</form>-->
<!--	</div>-->
<!--</div>-->