<?php
/*grab current directory*/
$CURRENT_DIR = __DIR__;
/*set page title here*/
$PAGE_TITLE = "MY PAGE TITLE";
/*load head-utils.php*/
require_once("php/template/head-utils.php");
?>

<div class="sfooter-content">
	<header>
		<?php require_once("php/template/header.php"); ?>
	</header>

	<!-- Main jumbotron to welcome users and for a call to action -->
	<div class="jumbotron bg-image">
		<div class="container text-center">
			<br>
			<br>

			<h1>Explore the Outdoors around Albuquerque</h1>

			<p>Find hiking, mountain biking, skiing, <br>and horseback riding trails</p>
			<br>

			<p><a class="btn btn-primary btn-lg" role="button" href="trailSearch-template.php">Find a Trail</a></p>

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
		<p class="text-muted">Copyright Comments<span class="pull-right"><a class="btn btn-primary" href="#"
																								  role="button">Contact Us</a></span>
		</p>
	</div>
</footer>

</body>
</html>
