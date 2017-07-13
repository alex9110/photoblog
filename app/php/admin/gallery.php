<?php
	require_once("header_ad.php"); 		//подключим header
	$config = config();
	$album = $_GET['current']; //посмотрим какой альбом просит пользватель	
?>
<div class="photo_uploader">
	<input class="upload_photo uploader" type="file" multiple="multiple" accept="image/*">
	<div id="upload_photo"  class="uploader">Загрузить</div>
	<div id="save_row" class="uploader">Сохранить ряд</div>	
</div>

<div class="content">
	<?php echo ( show_normal_size_photo("temporarily") ); ?>
	<div class="gallery">
		
	<?php echo ( show_photo_r($album) ); ?>
	</div>
</div>
<?php require_once("footer_ad.php"); ?>