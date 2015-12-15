<?php
/*grab current directory*/
$CURRENT_DIR = __DIR__;
/*set page title here*/
$PAGE_TITLE = "MY PAGE TITLE";
/*load head-utils.php*/
require_once("../php/template/head-utils.php");
?>

<!--	load header content from header.php	-->
<div class="sfooter-content">
	<header>
		<?php require_once(dirname(__DIR__) . "/php/template/header.php"); ?>
	</header>

	<h1>Trail Description</h1>
	<hr>

	<div class="container">
		<div class="row">
			<!--map container-->
			<div class="col-md-6 embed-responsive embed-responsive-4by3">
				<map ng-transclude class="google-map" center="map.center" options="map.options" zoom="map.zoom">
					​<polylines coords="polylines.coords" options="polylines.options"></polylines>
				​</map>
			</div>
			<!--data column-->
			<div class="col-md-6">
				<div>Trail name here</div>
				<br>
				<div>Trail Search Parameters go here</div>
				<br>
				<button class="btn btn-md btn-info" type="submit">Trail Corrections</button>
				<button class="btn btn-md btn-warning" type="reset">Trail Alert</button>
				<!--continue to fill in content next to map here-->
			</div>
		</div><!--.row-->

		<!-- Trail comment form inserted here -->
		<div class="row">
			<div class="col-md-12">
				<h2 class="page-title">Enter Your Comment(s) for this Trail</h2>
				<?php require_once(dirname(__DIR__) . "/angular/views/comment-form.php"); ?>
			</div>
		</div>
		<br>
		<hr>

		<!-- Trail comments from database will show below here -->
		<div class="row">
			<div class="col-md-12">
				List of trail commments here
			</div>
		</div>


	</div><!--.container-->
</div>

<footer class="footer">
	<?php require_once(dirname(__DIR__) . "/php/template/footer.php"); ?>
</footer>

</body>
</html>