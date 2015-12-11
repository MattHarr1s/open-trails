<div class="modal-body">
	<form id="signupForm" name="signupForm">
		<h2>Join us!</h2>
		<hr/>

		<!-- USER NAME -->
		<label class="control-label" for="name">user name</label>

		<div class="form-inline"
			  ng-class="{ 'has-error' : signupData.userName.$touched && signupData.userName.$invalid}">
			<label class="control-label sr-only" for="userName">user name</label>

			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				</div>
				<input type="text" class="form-control" id="userName" name="userName" placeholder="user name" ng-model="signupData.userName" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="signupData.userName.$error" ng-if="signupData.userName.$touched" ng-hide="signupData.userName.$valid">
				<p ng-message="required">Please enter a user name</p>
			</div>

		<!-- PASSWORD -->
			<label class="control-label sr-only" for="password">Password</label>

			<div class="input-group">
				<input type="text" class="form-control" id="password" name="password" placeholder="password" ng-model="signupData.password" ng-required="true"/>
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="signupData.password.$error" ng-if="signupData.password.$touched" ng-hide="signupData.password.$valid">
				<p ng-message="required">Please enter a password</p>
			</div>

			<!-- VERIFY PASSWORD -->

		</div>
	</form>
</div>