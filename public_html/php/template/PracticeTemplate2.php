<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- The 3 meta tags *must* come first in the head; any other head content must come *after* these tags  		-->
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"

		<!-- Bootstrap latest compiled and minified CSS		-->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

		<!-- Optional Bootstrap Theme -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

		<!-- Custom CSS -->
		<link rel="stylesheet" href="../../css/style.css" type="text/css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!-- [if it IE 9]>
			<script src="//css.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="//css.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<! [endif]-->

		<!-- jQuery (required for Bootstrap's JS plugins) -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

		<!-- Bootstrap latest compiled and minified Javascript -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"  integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

		<title>Basic Bootstrap Wireframe Exercise</title>
	</head>

	<body class="sfooter">
		<div class="sfooter-content">
			<nav class="navbar navbar-inverse">
				<!-- logo and mobile toggle button get grouped together for better mobile display -->
				<div class="navbar-header">
					<!-- this is the mobile menu button -->
					<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-menu">
						<span class="sr-only">main menu</span>
						<span class="glyphicon glyphicon-menu-hamburger"></span>
					</button>
					<a class="navbar-brand" href="#">Trail-Quail: Albuquerque</a>
				</div>

				<!-- here are your main nav links, grouped for toggling -->
				<div class="collapse navbar-collapse" id="main-menu">
					<u1 class="nav navbar-nav navbar-right"
					</u1>
					<li><a href="#">Home</a></li>
					<li><a href="#">Search Trails</a></li>
					<li><a href="#">Log in</a></li>
					<li><a href="#">About this site</a></li>
				</div>
			</nav>

			<div class="container">
				<div class="row">
					<div class="col-md-12">Column One: 12/12 columns, 100% of container width</div>
				</div>

				<div class="row">
					<div class="col-md-3"> Column Two: 3/12 columns, 25% of container width.</div>
					<div class="col-md-3"> Column Three: 3/12 columns, 25% of container width.</div>
					<div class="col-md-3"> Column Four: 3/12 columns, 25% of container width.</div>
					<div class="col-md-3"> Column Five: 3/12 columns, 25% of container width.</div>
				</div>
				<p></p>

				<div class="row">
					<div class="col-md-6"> Column Six: 6/12 columns, 50% of container width.</div>
					<div class="col-md-6"> Column Seven: 6/12 columns, 50% of container width.</div>
				</div>

			</div>
		</div>

		<footer class="footer">
			<div class="container">
				<p class="text-muted">This is a bootstrap assignment</p>
			</div>
		</footer>

	</body>
</html>