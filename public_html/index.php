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
		<?php require_once($PREFIX . "php/template/header.php"); ?>
	</header>

	<main>
		<ng-view></ng-view>
	</main>

</div>

<footer class="footer">
	<?php require_once("php/template/footer.php"); ?>
</footer>

</body>
</html>
