<nav class="navbar navbar-inverse">
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
		<u1 class="nav navbar-nav navbar-right"
		</u1>
		<li><a href="trailSearch-template">Find Trails</a></li>
		<li><a href="#">About this site</a></li>

		<!-- Drop down form for create account -->
		<li ng-controller="DropdownCtrl">
			<span uib-dropdown on-toggle="toggled"(open)>
				<a href id="create-account-dropdown" uib-dropdown-toggle>
					Create Account
				</a>
				<ul class="uib-dropdown-menu" aria-labelledby="create-account-dropdown">
					<?php require_once(dirname(dirname(__DIR__)) . "/angular/views/create-account-form.php"); ?>
				</ul>
			</span>
		</li>

			<!-- Drop down form for logging in -->
		<li>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
						  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Log in
					<span class="caret"></span>
				</button>
				<div class="dropdown-menu"
					  aria-labelledby="dropdownMenu1">
					<?php require_once(dirname(dirname(__DIR__)) . "/angular/views/login-form.php"); ?>
				</div>

			</div>
		</li>
	</div>
</nav>