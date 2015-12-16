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
		<?php require_once($PREFIX . "/php/template/home.php"); ?>
	</header>



</div>

<footer class="footer">
	<?php require_once("../php/template/footer.php"); ?>
</footer>

</body>
</html>
