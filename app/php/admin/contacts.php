<?php 
	require_once("header_ad.php"); 
?>
<link rel="stylesheet" href="../../css/contacts.css">
<div class="content">
	
	<ul><?php echo(show_all_contacts() ); ?></ul>
	 <input type="button" class="but" value="сохранить">
</div>

<?php require_once("footer_ad.php"); ?>