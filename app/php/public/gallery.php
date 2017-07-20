<?php
	$title = "Альбом";
	$whom = 1;
	 require_once("header.php");
	$album = $_GET['current']; //посмотрим какой альбом просит пользватель
?>
	<div class="content">
		<div class="gallery">
			<?php echo ( show_photo_r($album,1,1) ); ?>
		</div>
	</div>
<?php require_once("footer.php"); ?>