<?php 
	require_once("../includes/functions.php");
	require_once("../includes/config.php");
	$config = config();
	require_once("header_ad.php"); 		//подключим header
	//move_photo($config['index']);
	// remove_info();
	//remove_photo($config['img_folder'].'photo_12.jpg', $config['tmp']);
?>		
		<div style="background-color: #ccc; width: 100%; min-height: 50px">
			<input class="upload_photo" type="file" multiple="multiple" accept="image/*">
			<div style="cursor: pointer;" id="upload_photo" ">Загрузить файлы</div>
			<div style="cursor: pointer;" id="save_row" ">Сохранить ряд</div>	
		</div>
		<div class="content">
		<?php echo ( show_normal_size_photo($config['tmp']) ); ?>
		    <div class="gallery">
		    	
				<?php echo ( show_photo_r($config['index']) );?>		
			</div>
		</div>
<?php require_once("footer_ad.php"); 	//подключим footer ?>
<script>

	//ещё нужно взять данные с первого ul на странице чтобы узнать с какой таблицы удалить запись дале кидаем на сервер дале рубаем на масив управляемся например путями all_photos/photo/ дале проверяем есть ли такие файли и есть ли такие записи в таблице если все ок чистим)))
</script>
