<?php 
	require_once("header_ad.php"); 
	require_once("../includes/functions.php"); 
	require_once("../includes/config.php"); 

?>

<div class="content">
	
	<ul>
		<?php 
			$config = config();
			$table = $config['contacts'];
			$data = get_data($table);
			$li = '';
			for ($i=0; $i < count($data); $i++) { 
				$name = $data[$i]['name'];
				$value = $data[$i]['value'];
				$li .= '<li class="contacts"><p>'.$name.'</p><input type="text" value="'.$value.'"></li>';
			}
			echo $li;
		 ?>

	</ul>
</div>
<?php require_once("footer_ad.php"); ?>