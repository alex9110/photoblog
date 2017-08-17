<?php 
	$title = "Главная";
	$whom = 0;
	require_once("php/public/header.php"); 		//подключим header
	$config = config();
?>		
		<div class="content">
		    <div class="gallery">
		    	<?php echo ( show_photo_r($config['index'], 0, 5) ); ?>
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
<?php
 	require_once("php/public/footer.php"); 								//подключим footer 
?>