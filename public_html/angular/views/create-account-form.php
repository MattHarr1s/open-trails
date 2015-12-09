<!-------------------------------------------------------->
<!-- This is the create-account form for the Trail Quail website -->
<!-- 																	  -->
<!-- @author saulj@me.com  (December 2015)  				  -->
<!-------------------------------------------------------->

<!-- The div class="form-wrap" is the black box containing the form. It's set to a column width of 12 for small screens, and a column width of 6 for medium screens on up -->
<div class="form-wrap" ng-controller="SignupController">

	<!-- Form is centered within it's container, and is set to 10 be columns wide RELATIVE TO IT'S CONTAINER, and offset to the right by one column. See classes: col-xs-offset-1 & col-xs-10 -->
	<form method="post" action="#" id="login-form" class="form-horizontal" ng-submit="addUser(user);">

		<div class="form-group">
			<!-- Labels for each field are places within a <label> tag. Use the "for" attribute. the class="control-label" is for styling. -->
			<label for="userName" class="control-label">Username</label>
			<!-- the div class="input-group" contains both the text field and the icon to the left -->
			<div class="input-group">
				<!-- this div and span contains the glyphicon to the left. aria-hidden is so that screen readers don't read this element -->
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				</div>
				<!-- text field input. pay attention to the id, placeholder text, type, and placeholder attributes -->
				<input type="text" class="form-control" id="userName" placeholder="Your username here." maxlength="150" ng-model="user.userName"/>
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="control-label">Password</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
				</div>
				<input type="password" id="password" class="form-control" maxlength="150"
						 placeholder="Your password here" ng-model="user.password"/>
			</div>
		</div>

		<div class="form-group">
			<label for="verifyPassword" class="control-label">Verify Password</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
				</div>
				<input type="password" id="verifyPassword" class="form-control" maxlength="150"
						 placeholder="Verify your password here" ng-model="user.verifyPassword"/>
			</div>
		</div>

		<div class="form-group">
			<label for="userEmail1" class="control-label">Email</label>
			<div class="input-group">
				<div class="input-group-addon">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
				</div>
				<input type="Email" id="userEmail" class="form-control" maxlength="150"
						 placeholder="your-email@something.com" ng-model="user.userEmail"/>
			</div>
		</div>

		<!-- buttons for submit and reset -->
		<hr>
		<button class="btn btn-md btn-info" type="submit">Submit</button>
		<button class="btn btn-md btn-warning" type="reset">Reset</button>

	</form>
</div> <!-- CLOSE FORM WRAP -->