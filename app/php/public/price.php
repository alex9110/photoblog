<?php require_once("header.php"); ?>
	<link rel="stylesheet" href="../../css/price.css">
	<div class="content">
		<div class="service_box">
			<?php echo(show_prices()); ?>
		</div>
		<?php echo(show_extra_service());?>
	</div>
<?php require_once("footer.php"); ?>