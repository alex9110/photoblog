<?php
	$title = "Альбом";
	$whom = 1;
	 require_once("header.php");
	$album = $_GET['current']; //посмотрим какой альбом просит пользватель
?>
	<div class="content">
		<div class="gallery">
			<?php echo ( show_photo_r($album, 0, 5) ); ?>
		</div>
		<div id="loadMore">
			<div>
				<p class="more">Ещё фото ...</p>
				<span class="public_loader"></span>
				<p class="error"></p>
			</div>
		</div>
	</div>
	<a href="#up" id="to_up"></a>
<?php require_once("footer.php"); ?>