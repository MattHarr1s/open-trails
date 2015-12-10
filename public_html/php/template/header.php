<!-- This in mainly for the Navbar in the header -->

<nav class="navbar navbar-default">
	<!-- logo and mobile toggle button get grouped together for better mobile display -->
	<div class="navbar-header">
		<!-- this is the mobile menu button -->
		<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-menu">
			<span class="sr-only">main menu</span>
			<span class="glyphicon glyphicon-menu-hamburger"></span>
		</button>
		<a class="navbar-brand" href="#">Trail Quail - Albuquerque</a>
	</div>

	<!-- here are your main nav links, grouped for toggling -->
	<div class="collapse navbar-collapse" id="main-menu">
		<ul class="nav navbar-nav navbar-right">
			<li><a href="trailSearch-template">Find Trails</a></li>
			<li><a href="#">About this site</a></li>

			<!-- Drop down form for create account -->
			<li ng-controller="SignupController">
				<a class="btn btn-info btn-lg" ng-click="openSignupModal();">
					<i class="fa fa-check"></i>Create Account
				</a>
			</li>

			<!-- Drop down form for logging in -->
			<li ng-controller="LoginController">
			 <a class="btn btn-info btn-lg" ng-click="openLoginModal();">
				 <i class="fa fa-check" aria-hidden="true"></i>Log In</>
				</a>										// aria-hidden="true"
			</li>
		</ul>
	</div>
</nav>