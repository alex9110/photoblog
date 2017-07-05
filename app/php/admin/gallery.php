<?php
	require_once("../includes/functions.php");
	require_once("../includes/config.php");
	$config = config();
	require_once("header_ad.php"); 		//подключим header
	//move_photo("work_1");
	// remove_info();
	//remove_photo($config['img_folder'].'photo_12.jpg', $config['tmp']);
	

?>
	<link rel="stylesheet" href="../../css/gallery.css">

	<div style="background-color: #ccc; width: 100%; min-height: 50px">
		<input class="upload_photo" type="file" multiple="multiple" accept=".txt,image/*">
		<a href="#" id="upload_photo" ">Загрузить файлы</a>
		<div class="ajax-respond"></div>
	</div>

	<div class="content">
		<div class="gallery">
		<?php echo ( show_normal_size_photo("temporarily") ); ?>
			<ul class="ul_2">
				<li  class="gallery-box" id="gall_box11">
					<div class="heigth"></div>
					 <div class="gallery-box__image" style="background-image: url(img/photo1_1.jpg)"></div>
				</li>
			    <li class="gallery-box" id="gall_box12">
				    <div class="heigth"></div>
				   	 <div class="gallery-box__image" style="background-image: url(img/photo1_2.jpg)"></div>
			    </li>
		 	</ul>
		<?php echo ( show_photo("work_1") ); ?>
		</div>
	</div>
<?php require_once("footer_ad.php"); ?>