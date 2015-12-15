<?php
/*grab current directory*/
$CURRENT_DIR = __DIR__;
/*set page title here*/
$PAGE_TITLE = "Trail Quail Site Info";
/*load head-utils.php*/
require_once(dirname(__DIR__) . "/php/template/head-utils.php");
?>

<!-- ----------------------------------- -->
<!-- Quail Trail Site Info Page          -->
<!--												  -->
<!-- saulj@me.com  December 14, 2015	  -->
<!-- ----------------------------------- -->

<div class="sfooter-content">
	<header>
		<?php require_once(dirname(__DIR__) . "/php/template/header.php"); ?>
	</header>

	<!-- Main jumbotron to welcome users and for a call to action -->
	<div class="jumbotron bg-image">
		<div class="container text-center">
			<br>
			<br>

			<h1>YOUR ACCOUNT HAS BEEN SUSPENDED</h1>
			<br>

			<p><a class="btn btn-primary btn-lg" role="button" href="<?php echo $PREFIX;?>trail-search">Find a Trail</a></p>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class	="col-md-12 embed-responsive embed-responsive-4by3">
				<div>Information on Trail Quail and how to use the site</div>
			</div>

		</div>
	</div>

</div>

<footer class="footer">
	<?php require_once(dirname(__DIR__) . "/php/template/footer.php"); ?>
</footer>