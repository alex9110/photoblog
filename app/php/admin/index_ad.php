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
			<input class="upload_photo" type="file" multiple="multiple" accept=".txt,image/*">
			<a href="#" id="upload_photo" ">Загрузить файлы</a>
			<div class="ajax-respond"></div>
		</div>
		<div class="content">
		    <div class="gallery">
		    	<?php echo ( show_normal_size_photo("temporarily") ); ?>
				<?php echo ( show_photo("index_photo") ); ?>		
			</div>
		</div>
<?php
 	require_once("footer_ad.php"); 								//подключим footer 
?>