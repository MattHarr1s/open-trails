<!-------------------------------------------------------->
<!-- This is the search for trails form for the Trail Quail website -->
<!-- 																	  -->
<!-- @author saulj@me.com  (last modified December 12, 2015)  				  -->
<!-------------------------------------------------------->

<!-- The div class="form-wrap" is the black box containing the form. It's set to a column width of 12 for small screens, and a column width of 6 for medium screens on up -->

<div class="form-wrap">

	<!-- Form is centered within it's container, and is set to 10 be columns wide RELATIVE TO IT'S CONTAINER, and offset to the right by one column. See classes: col-xs-offset-1 & col-xs-10 -->
	<form method="post" action="#" id="searchTrails-form" class="form-horizontal">

		<!-- Enter Trail Difficulty -->
		<br>

		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div>Please edit the below information as needed.</div>
					<div class="form-group">
						<div class="row">
							<label class="control-label">Trail Difficulty</label>
						</div>
						<!--	use div class=“help-block” to explain the form content	-->
						<div class="row">
							<div class="help-block">Please Edit as needed</div>
							<div>(1 => Easy 5=> Very Difficulty)</div>
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
					</div>

					<!-- Data entry for minimum trail distance -->
					<div class="col-md-4">

						<div class="form-group">
							<label for="distanceRadio" class="control-label">Select Minimum Trail Distance</label>
							<!--	use div class=“help-block” to explain the form content	-->
							<div class="help-block">Please check one box. All trails with that distance or greater will be
								listed.
							</div>
							<!-- Radio buttons here -->
							<div class="radio">
								<label>
									<input type="radio" name="rdoDistance" id="radioDistance1" value="1"/> 0 - 2 miles
								</label>
							</div>

							<div class="radio">
								<label>
									<input type="radio" name="rdoDistance" id="radioDistance2" value="2"/> 2 - 5 miles
								</label>
							</div>

							<div class="radio">
								<label>
									<input type="radio" name="rdoDistance" id="radioDistance3" value="3"/> 5 - 10 miles
								</label>
							</div>

							<div class="radio">
								<label>
									<input type="radio" name="rdoDistance" id="radioDistance4" value="4"/> 10 - 20 miles
								</label>
							</div>

							<div class="radio">
								<label>
									<input type="radio" name="rdoDistance" id="radioDistance5" value="5"/> > 20 miles
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
							<div class="checkbox">
								<label class="checkbox">
									<!--	name value contains square brackets which makes it easy to create an array on the back end in php	-->
									<Input id="chkTrailUseHike" name="chkTrailUse[]" type="checkbox" value="Hike"/>Hike
								</label>
								<label class="checkbox">
									<Input id="chkTrailUseBike" name="chkTrailUse[]" type="checkbox" value="Bike"/>Bike
								</label>
								<label class="checkbox">
									<Input id="chkTrailUseWheelChair" name="chkTrailUse[]" type="checkbox" value="Wheelchair"/>Wheelchair
								</label>
								<label class="checkbox">
									<Input id="chkTrailUseSki" name="chkTrailUse[]" type="checkbox" value="Ski"/>Ski
								</label>
								<label class="checkbox">
									<Input id="chkTrailUseHorse" name="chkTrailUse[]" type="checkbox" value="Horse"/>Horse
								</label>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<br>

		<hr>

	</form>
</div>
