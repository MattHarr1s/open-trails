<?php
/*grab current directory*/
$CURRENT_DIR = __DIR__;
/*set page title here*/
$PAGE_TITLE = "Trail Quail";
/*load head-utils.php*/
require_once("php/template/head-utils.php");
?>

<!-- ----------------------------------- -->
<!-- Quail Trail Homepage                -->
<!--
<!-- saulj@me.com  December 14, 2015
<!-- ----------------------------------- -->

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

			<p><a class="btn btn-primary btn-lg" role="button" href="/trailsearch/index.php">Find a Trail</a></p>

			<p><a class="btn btn-primary" href="#" role="button">Learn More</a></p>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class	="col-md-12 embed-responsive embed-responsive-4by3">
				<div id="map"></div>
			</div>

		</div>
	</div>

</div>

<footer class="footer">
	<?php require_once("php/template/footer.php"); ?>
</footer>

</body>
</html>
