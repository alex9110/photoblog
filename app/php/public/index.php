<?php 
	require_once("../includes/functions.php");
	require_once("header.php"); 		//подключим header
	// require_once("admin_p.php");
?>		
		<div class="content">
		    <div class="gallery">
		    	<?php echo ( show_photo("index_photo") ); ?>
			</div>
		</div>
<?php
 	require_once("footer.php"); 								//подключим footer 

?>