
<!-- This in mainly for the Navbar in the header -->

<nav class="navbar navbar-inverse">
	<!-- logo and mobile toggle button get grouped together for better mobile display -->
	<div class="navbar-header">
		<!-- this is the mobile menu button -->
		<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-menu">
			<span class="sr-only">main menu</span>
			<span class="glyphicon glyphicon-menu-hamburger"></span>
		</button>
		<a class="navbar-brand" href="<?php echo $PREFIX;?>#/">Trail Quail - Albuquerque</a>
	</div>

	<!-- here are your main nav links, grouped for toggling -->
	<div class="collapse navbar-collapse" id="main-menu">
		<ul class="nav navbar-nav navbar-right">
			<li>
				<a class="btn btn-default btn-md" href="<?php echo $PREFIX; ?>#/trail-search">Find Trails</a>
			</li>
			<li>
				<a class="btn btn-default btn-md" href="<?php echo $PREFIX; ?>#/trail-site-info">About this site</a></li>

			<!-- if user is not logged in, place buttons for create account -->
			<!-- and log in on the right side of the nab bar					 -->
			<?php if(empty($_SESSION["user"])) { ?>
				<!-- Model+Controller for logging in by L Gill -->
				<li ng-controller="SignupController">
					<a class="btn btn-default btn-def" ng-click="openSignupModal();">
						<i class="fa fa-check" aria-hidden="true"></i>Create Account
					</a>
				</li>

				<!-- Model+Controller for logging in by L Gill  -->
				<li ng-controller="LoginController">
					<a class="btn btn-default btn-md" ng-click="openLoginModal();">
						<i class="fa fa-check" aria-hidden="true"></i>Log In
					</a> <!--aria-hidden="true" -->
				</li>
			<?php } ?>

			<!-- If user is logged in, this section will have different  	-->
			<!-- options based on whether 											-->
			<!-- the user is logged in and if they are a regular user (R), -->
			<!-- super user (S) or suspended user (X) 							-->
			<?php if(!empty($_SESSION["user"])) {

				// grab user account type from session in login-controller.php
				$accountType = $_SESSION["user"]->getUserAccountType();
				$userName = $_SESSION["user"]->getUserName();

				// if user is a superuser, give them access to the approve trail
				// info page and give them a log out button
				if($accountType === "S") { ?>
					<li>
						<a class="btn btn-default btn-md" href="<?php echo $PREFIX; ?>#/trail-update-approval">Approve Updates</a>
					</li>

					<li>
						<a href="" class="btn btn-default btn-def" ng-controller="LogoutController" ng-click="logOut();">
							<i class="fa fa-check" aria-hidden="true"></i>Log out
						</a>
					</li>

				<?php } elseif($accountType === "R") { ?>
					<li>
						<a class="btn btn-link btn-md disabled">Welcome back,&nbsp;<?php echo $userName; ?>!</a>
					</li>

					<li>
						<a class="btn btn-default btn-def" ng-controller="LogoutController"  ng-click="logOut();">
							<i class="fa fa-check" aria-hidden="true"></i>Log out
						</a>
					</li>

				<?php } elseif($accountType === "X") {
					header("Location:" . $PREFIX . "#/trail-suspended-account");
				}
			} ?>

		</ul>
	</div>
</nav>