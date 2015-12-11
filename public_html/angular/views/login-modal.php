<!--modal for login
<--
<-- @author Louis Gill <lgill7@cnm.edu>
-->
<div class="modal-body">
	<form id="loginForm" name="loginForm">
		<h2>Welcome Back!</h2>
		<hr/>
		<div class="form-group form-group-lg" ng-class="{ 'has-error': loginForm.userEmail.$touched && loginForm.userEmail.$invalid }">
			<label class="control-label" for="userEmail">Email</label>
			<div class="input-group">
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-envelope" aria-hidden="true"></i>
					</div>
					<input type="userEmail" class="form-control" id="userEmail" name="userEmail" placeholder="What's your email?" ng-model="loginData.userEmail" ng-required="true"/>
				</div>
				<div class="alert alert-danger" role="alert" ng-messages="loginForm.userEmail.$error" ng-if="loginForm.userEmail.$touched" ng-hide="loginForm.userEmail.$valid"></div>
					<p ng-message="userEmail">Email is invalid.</p>
					<p ng-message="required">Please enter your email.</p>
			</div>
		</div>
		<div class="form-group form-group-lg" ng-class="{ 'has-error': loginForm.password.$touched && loginForm.password.$invalid }">
			<label class="control-label" for="password">Password</label>
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-key" aria-hidden="true"></i>
				</div>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password" ng-model="loginData.password" ng-minlength="8" ng-required="true" />
			</div>
			<div class="alert alert-danger" role="alert" ng-messages="loginForm.password.$error" ng-if="loginForm.password.$touched" ng-hide="loginForm.password.$valid"></div>
				<p ng-message="minlength">Password must be at least 8 characters.</p>
				<p ng-message="required">Please enter your password.</p>
			</div>
		</div>
		<hr/>
		<button type="submit" class="btn btn-lg btn-info" ng-click="ok();" ng-disabled="loginForm.$invalid"><i class="fa fa-login" aria-hidden="true"></i>Log In</button>
		<button type=""
	</form>
</div>