<?php 
	$title = "Главная";
	$whom = 0;
	require_once("header.php"); 		//подключим header
	$config = config();
?>		
		<div class="content">
		    <div class="gallery">
		    	<?php echo ( show_photo($config['index']) ); ?>
			</div>
		</div>
		<a href="#up" id="to_up"></a>
<?php
 	require_once("footer.php"); 								//подключим footer 

?>