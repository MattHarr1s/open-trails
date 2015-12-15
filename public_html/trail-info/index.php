<?php
/*grab current directory*/
$CURRENT_DIR = __DIR__;
/*set page title here*/
$PAGE_TITLE = "Trail Info";
/*load head-utils.php*/
require_once(dirname(__DIR__) . "/php/template/head-utils.php");
?>

<!--	load header content from header.php	-->
<div class="sfooter-content">
	<header>
		<?php require_once(dirname(__DIR__) . "/php/template/header.php"); ?>
	</header>


	<h2>Trail Description</h2>
	<hr>

	<div ng-view></div>
</div>

<footer class="footer">
	<?php require_once(dirname(__DIR__) . "/php/template/footer.php"); ?>
</footer>

</body>
</html>