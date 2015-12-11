<div class="modal-body">
	<form id="signupForm" name="signupForm" class="form-inline">
		<h2>Join us!</h2>
		<hr/>

		<!-- USER NAME -->
		<label class="control-label" for="name">user name</label>

		<div class="form-group"
			  ng-class="{ 'has-error' : signupData.userName.$touched && signupData.userName.$invalid}">
			<label class="control-label sr-only" for="userName">user name</label>

			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				</div>
				<input type="text" class="form-control" id="userName" name="userName" placeholder="user name"
						 ng-model="signupData.userName" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="signupData.userName.$error"
				  ng-if="signupData.userName.$touched" ng-hide="signupData.userName.$valid">
				<p ng-message="required">Please enter a user name</p>
			</div>

			<!-- PASSWORD -->
			<div class="form-group"
				  ng-class="{ 'has-error': signupData.password.$touched && signupData.password.$invalid }">
				<label class="control-label" for="password">Password</label>

				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-key" aria-hidden="true"></i>
					</div>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password"
							 ng-model="signupData.password" ng-minlength="8" ng-required="true"/>
				</div>
				<div class="alert alert-danger" role="alert" ng-messages="signupData.password.$error"
					  ng-if="signupData.password.$touched" ng-hide="signupData.password.$valid">
					<p ng-message="minlength">Password must be at least 8 characters.</p>

					<p ng-message="required">Please enter your password.</p>
				</div>
			</div>

			<!-- VERIFY PASSWORD -->
			<div class="form-group"
				  ng-class="{ 'has-error': signupData.verifyPassword.$touched && signupData.verifyPassword.$invalid}">
				<label class="control-label">Confirm Password</label>

				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-key" aria-hidden="true"></i>
					</div>
					<input type="password" class="form-control" id="verifyPassword" name="verifyPassword"
							 placeholder="confirm password" match-password="password" ng-model="signupData.verifyPassword"
							 ng-minlength="8" ng-required="true"/>
				</div>
				<div class="alert alert-danger" role="alert" ng-messages="signupData.verifyPassword.$error"
					  ng-if="signupData.verifyPassword.$touched" ng-hide="signupData.verifyPassword.$valid">
					<p ng-message="minlength">Password must be at least 8 characters.</p>

					<p ng-message="passwordMatch">Passwords do not match.</p>

					<p ng-message="required">Please enter your password.</p>
				</div>
			</div>

			<!-- EMAIL -->
			<div class="form-group" ng-class="{ 'has-error': signupData.userEmail.$touched && signupData.userEmail.$invalid}">
				<label class="control-label" for="userEmail">Email</label>

				<div class="input-group">
					<div class="input-group-addon">
						<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
					</div>
					<input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Email" ng-model="signupData.userEmail" ng-required="true"/>
				</div>
				<div class="alert alert-danger" role="alert" ng-messages="signupData.userEmail.$error" ng-if="signupData.userEmail.$touched" ng-hide="signupData.userEmail.$valid">
					<p ng-message="userEmail">Email is invalid.</p>
					<p ng-message="required">Please enter your email.</p>
				</div>
			</div>
		</div>
		<hr/>
		<button type="submit" class="btn btn-lg btn-info" ng-click="ok();" ng-disabled="signupData.$invalid">
			<i class="fa fa-check" aria-hidden="true"></i>Submit
		</button>
	</form>
</div>