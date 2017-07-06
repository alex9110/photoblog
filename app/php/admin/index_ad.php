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
		<?php echo ( show_normal_size_photo("temporarily") ); ?>
		    <div class="gallery">
		    	
				<?php //echo ( show_photo_r("index_photo") );
				$x = show_photo_r("index_photo");
				print_r($x);
				 ?>		
			</div>
		</div>
<?php
 	require_once("footer_ad.php"); 								//подключим footer 
?>