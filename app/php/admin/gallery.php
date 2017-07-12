<?php
	require_once("header_ad.php"); 		//подключим header
	$config = config();
	$album = $_GET['current']; //посмотрим какой альбом просит пользватель
		
?>
	<link rel="stylesheet" href="../../css/gallery.css">

	<div style="background-color: #ccc; width: 100%; min-height: 50px">
		<input class="upload_photo" type="file" multiple="multiple" accept="image/*">
		<div style="cursor: pointer;" id="upload_photo" ">Загрузить файлы</div>
		<div style="cursor: pointer;" id="save_row" ">Сохранить ряд</div>	
	</div>

	<div class="content">
		<?php echo ( show_normal_size_photo("temporarily") ); ?>
		<div class="gallery">
			
		<?php echo ( show_photo_r($album) ); ?>
		</div>
	</div>
<?php require_once("footer_ad.php"); ?>