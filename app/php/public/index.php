<?php 
	require_once("../includes/functions.php");
	require_once("../includes/config.php");
	$config = config();
	require_once("header.php"); 		//подключим header
?>		
		<div class="content">
		    <div class="gallery">
		    	<?php echo ( show_photo($config['index']) ); ?>
			</div>
		</div>
<?php
 	require_once("footer.php"); 								//подключим footer 

?>