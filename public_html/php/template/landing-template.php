<!DOCTYPE html>
<html lang="en">

	<!-- ----------------------------------------------------- -->
	<!--	This is the landing page for the trail quail website -->
	<!--																		  -->
	<!--  @author saulj@me.com  (December 2015)                -->
	<!-- ----------------------------------------------------- -->


	<head>
		<!-- The 3 meta tags *must* come first in the head; any other head content must come *after* these tags  		-->
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"

		<!-- Bootstrap latest compiled and minified CSS		-->
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"
				integrity="sha256-MfvZlkHCEqatNoGiOXveE8FIwMzZg4W85qfrfIFBfYc= sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
				crossorigin="anonymous">

		<!-- Optional Bootstrap Theme -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"
				integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

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
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"
				  integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ=="
				  crossorigin="anonymous"></script>


		<!-- load the googlemaps api -->
		<script src="https://maps.googleapis.com/maps/api/js?=trailquail-1152""></script>

		<!-- Initialize the Google Map -->
		<script>
		function initialize() {
			var mapCanvas = document.getElementById('map');
			var mapOptions = {
				center: new google.maps.LatLng(35.1318, -106.5925),
				zoom: 8,
				mapTypeId: google.maps.MapTypeId.TERRAIN
			}
			var map = new google.maps.Map(mapCanvas, mapOptions)
		}
		google.maps.event.addDomListener(window, 'load', initialize);
		</script>

		<title>Quail Trail - Albuquerque: Landing Page</title>
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
					<a class="navbar-brand" href="#">Trail Quail - Albuquerque</a>
				</div>

				<!-- here are your main nav links, grouped for toggling -->
				<div class="collapse navbar-collapse" id="main-menu">
					<u1 class="nav navbar-nav navbar-right"
					</u1>
					<li><a href="#">Find Trails</a></li>
					<li><a href="#">About this site</a></li>
					<li><a href="#">Create Account</a></li>
					<li><a href="#">Log in</a></li>
				</div>
			</nav>

			<!-- Main jumbotron to welcome users and for a call to action -->
			<div class="jumbotron bg-image">
				<div class="container text-center">
					<br>
					<br>

					<h1>Explore the Outdoors around Albuquerque</h1>

					<p>Find hiking, mountain biking, skiing, <br>and horseback riding trails</p>
					<br>

					<p><a class="btn btn-primary btn-lg" href="#" role="button">Find a Trail</a></p>

					<p><a class="btn btn-primary" href="#" role="button">Learn More</a></p>
				</div>
			</div>

			<div class="container">
				<div class="row">
					<div class="col-md-12" embed-responsive embed-responsive-4by3>
						<div id="map"></div>
					</div>

				</div>
			</div>

		</div>

		<footer class="footer">
			<div class="container">
				<p class="text-muted">Copyright Comments<span class="pull-right"><a class="btn btn-primary" href="#" role="button">Contact Us</a></span>
				</p>
			</div>
		</footer>

	</body>
</html>