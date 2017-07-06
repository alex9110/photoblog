<?php
	 require_once("header.php");
	require_once("../includes/functions.php");
	$album = $_GET['current']; //посмотрим какой альбом просит пользватель
 ?>
	<link rel="stylesheet" href="../../css/gallery.css">
	<div class="content">
		<div class="gallery">
			<?php echo ( show_photo($album) ); ?>
		</div>
	</div>
<?php require_once("footer.php"); ?>