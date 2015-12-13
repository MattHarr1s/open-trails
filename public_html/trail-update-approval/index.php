<?php
/*grab current directory*/
$CURRENT_DIR = __DIR__;
/*set page title here*/
$PAGE_TITLE = "Trail Update Check";
/*load head-utils.php*/
require_once("../php/template/head-utils.php");
?>

<!--	load header content from header.php	-->
<div class="sfooter-content">
	<header>
		<?php require_once(dirname(__DIR__) . "/php/template/header.php"); ?>
	</header>

	<h1>Make Trail Corrections</h1>
	<div>Help us fix our trail information</div>
	<!-- trail database updates webpage - super user access only -->
	<hr>

	<!-- current database entry on trail -->
	<div class="container">
		<div class="row">
			<!--map container-->
			<div class="col-md-6">
				<h2>Current Trail DB Entry</h2>

			<!--	Will need to define variables for currentTrailId, antiabuse trait, currentTrailName, currentTrailDistance, currentTrailDifficulty, currentTrailUse, and currentTrailDescription	-->

				<!-- Dummy data for now -->
<!--					$trailName = "Corrales Bosque Trail";-->
<!--					$trailDistance = 13.0;-->
<!--					$trailDifficulty = 1;-->
<!--					$trailUse[] = [1, 1, 0, 0, 1];-->
<!--					$trailDescription = "Located in northern Albuquerque, the Corrales Bosque Trail offers a quick escape nearby. The trail offers scenic views of the Rio Grande.  It also offers opportunities for birding and wildlife viewing. The trail is paved at the beginning turning into a dirt and sand singletrack on a flat wooded trail along the Rio Grande. Restrooms available at the Alameda Open Space parking lot (cross the pedestrian bridge over the river & then go under Alameda to get to the parking lot from the trailhead.";-->
<!--					-->

				<h3>Corrales Bosque Trail</h3>
				<div class="row">
					<div class="col-md-10 embed-responsive embed-responsive-4by3">
						<div id="map"></div>
					</div>
					<!-- End of Map row / beginning of trail info -->
				</div>
				<div>The information below is what is currently in the database:</div>
				<!-- trail difficulty goes here as a row -->
				<div class="row"></div>
				<div>Trail Difficulty goes here</div>
				<div class="row"></div>
				<div>Minimum Trail Distance goes here</div>
				<div class="row"></div>
				<div>Trail Use goes here</div>
				<br>

				<div class="row"></div>
				<h3>Trail Description:</h3>
				<div>Located in northern Albuquerque, the Corrales Bosque Trail offers a quick escape nearby. The trail offers scenic views of the Rio Grande.  It also offers opportunities for birding and wildlife viewing. The trail is paved at the beginning turning into a dirt and sand singletrack on a flat wooded trail along the Rio Grande. Restrooms available at the Alameda Open Space parking lot (cross the pedestrian bridge over the river & then go under Alameda to get to the parking lot from the trailhead.)</div>
			</div> <!-- End column 1 here -->
			<!--Correction/New Trail data column-->

			<div class="col-md-6">
				<h2>Trail Correction(s)</h2>

				<h3>Corrales Bosque Trail</h3>
				<!--	Note that all current trail information will be copied into update fields	-->
				<div class="row">
					<div class="col-md-10 embed-responsive embed-responsive-4by3">
						<div id="map2"></div>
					</div>
					<!-- End of Map row / beginning of trail info -->
				</div>
				<?php require_once(dirname(__DIR__) . "/angular/views/trail-correction-form.php"); ?>
				<div>Trail Search Parameters go here</div>
				<br>

				<div>trail description goes here</div>
				<br>

				<div>
					Do you want to approve the above trail information to go into the database?
				</div>
				<?php require_once(dirname(__DIR__) . "/angular/views/accept-dbchange-form.php"); ?>
			</div>  <!-- End of column 2 -->
		</div><!--.row-->


	</div><!--.container-->
</div>

<footer class="footer">
	<?php require_once(dirname(__DIR__) . "/php/template/footer.php"); ?>
</footer>

</body>
</html>