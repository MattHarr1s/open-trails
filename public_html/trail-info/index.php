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
				<div id="map"></div>
			</div>
			<!--data column-->
			<div class="col-md-6">
				<div>Trail name here</div>
				<div>Trail Search Parameters go here</div>
				<!--continue to fill in content next to map here-->
			</div>
		</div><!--.row-->

		<div class="row">
			<div class="col-md-12">
				full width column here
			</div>
		</div>


	</div><!--.container-->
</div>

<footer class="footer">
	<?php require_once("../php/template/footer.php"); ?>
</footer>

</body>
</html>