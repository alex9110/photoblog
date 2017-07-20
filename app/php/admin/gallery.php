<?php
	$title = "Альбом";
	$whom = 1;
	require_once("header_ad.php"); 		//подключим header
	$config = config();
	$album = $_GET['current']; //посмотрим какой альбом просит пользватель	
?>
<div class="photo_uploader">
	<input class="upload_photo uploader" type="file" multiple="multiple" accept="image/*">
	<div id="upload_photo"  class="uploader">Загрузить</div>
	<div id="save_row" class="uploader">Сохранить ряд</div>	
	<span class="loader"></span>
</div>

<div class="content">
	<?php echo ( show_normal_size_photo("temporarily") ); ?>
	<div class="gallery">	
	<?php echo ( show_photo_r($album, 'last', 1) ); ?>
	</div>
	<div id="loadMore">
		<div>
			<p class="more">Все фото ...</p>
			<span class="public_loader"></span>
			<p class="error"></p>
		</div>
	</div>
</div>
<?php require_once("footer_ad.php"); ?>