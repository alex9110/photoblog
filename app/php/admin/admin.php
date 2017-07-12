<?php 
	require_once("header_ad.php"); 
	//echo (session_status());
	//echo (session_name());
	//$_SESSION = [];
?>

<div class="content">
	
	<ul><?php echo(show_all_contacts() ); ?></ul>
	 <input type="button" class="but" value="сохранить">
</div>

<?php require_once("footer_ad.php"); ?>