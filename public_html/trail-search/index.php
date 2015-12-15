<?php
/*grab current directory*/
$CURRENT_DIR = __DIR__;
/*set page title here*/
$PAGE_TITLE = "MY PAGE TITLE";
/*load head-utils.php*/
require_once(dirname(__DIR__) . "/php/template/head-utils.php");
?>

<!--	load header content from header.php	-->
<div class="sfooter-content">
	<header>
		<?php require_once(dirname(__DIR__) . "/php/template/header.php"); ?>
	</header>

	<!--	Load Trail Search Form here	-->
	<div class="col-xs-12 col-md-12">
		<h1 class="page-title">Search for Local Trails</h1>
		<?php require_once(dirname(__DIR__) . "/angular/views/search-trails-form.php"); ?>
	</div>
	<br/>
	<hr/>


	<div class="container">
		<div class="row">
			<div class="col-md-12 embed-responsive embed-responsive-4by3">
				<ng-map zoom="3" center="0, -180" map-type-id="TERRAIN">
					<shape name="polyline"
							 path="[
        [37.772323, -122.214897],
        [21.291982, -157.821856],
        [-18.142599, 178.431],
        [-27.46758, 153.027892]
      ]"
							 geodesic="true"
							 stroke-color="#FF0000"
							 stroke-opacity="1.0"
							 stroke-weight="2">
					</shape>
				</ng-map>
			</div>

		</div>
	</div>

</div>

<footer class="footer">
	<?php require_once("../php/template/footer.php"); ?>
</footer>

</body>
</html>
