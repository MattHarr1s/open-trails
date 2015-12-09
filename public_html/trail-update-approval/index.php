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

	<h1>Trail Database Updates</h1>
	<!-- trail database updates webpage - super user access only -->
	<hr>

	<!-- current database entry on treil -->
	<div class="container">
		<div class="row">
			<!--map container-->
			<div class="col-md-6>
				<h2>Current Trail Entry</h2>
				<div>Trail Name Here</div>
			 	<div embed-responsive embed-responsive-4by3">
					<div id="map1"></div>
				</div>
				<br>
				<div>Trail Search Parameters go here</div>
				<br>
				<div>Trail Description goes here</div>
			</div> <!-- End column 1 here -->
			<!--Correction/New Trail data column-->
			<div>Trail Name here again</div>
			<div class="col-md-6">
				<h2>Trai Correction/New Trail Entry</h2>
				<div>Trail Name Here again</div>
				<div embed-responsive embed-responsive-4by3">
				<div id="map1"></div>
			</div>
				<br>
				<div>Trail Search Parameters go here</div>
				<br>
				<div>trail description goes here</div>
				<button class="btn btn-md btn-info" type="submit">Approve for update database</button>
				<!--continue to fill in content next to map here-->
			</div>
		</div><!--.row-->


	</div><!--.container-->
</div>

<footer class="footer">
	<?php require_once(dirname(__DIR__) . "/php/template/footer.php"); ?>
</footer>

</body>
</html>