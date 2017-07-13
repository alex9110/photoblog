<?php 
	require_once("header.php"); 		//подключим header
	$config = config();
?>		
		<div class="content">
		    <div class="gallery">
		    	<?php echo ( show_photo($config['index']) ); ?>
			</div>
		</div>
<?php
 	require_once("footer.php"); 								//подключим footer 

?>