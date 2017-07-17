<?php 
	$title = "Главная";
	$whom = 0;
	require_once("header_ad.php"); 		//подключим header
	$config = config();
?>		
		<div class="photo_uploader">
			<input class="upload_photo uploader" type="file" multiple="multiple" accept="image/*">
			<div id="upload_photo"  class="uploader">Загрузить</div>
			<div id="save_row" class="uploader">Сохранить ряд</div>	
			<span class="loader"></span>
		</div>
		<div class="content">
		<?php echo ( show_normal_size_photo($config['tmp']) ); ?>
		    <div class="gallery">
				<?php echo ( show_photo_r($config['index']) );?>		
			</div>
		</div>
<?php require_once("footer_ad.php"); 	//подключим footer ?>
