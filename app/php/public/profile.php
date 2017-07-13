<?php require_once("header.php"); ?>
	<link rel="stylesheet" href="../../css/profile.css">
	<div class="content">
		<div class="about_me">
			<?php echo( show_profile() );?>
		</div>
		<div class="contact">
			<p>Заказать фотосессию</p><br>
			<?php 
				$data = get_contacts('phone');
				for ($i=0; $i < count($data) ; $i++) { 
					$value = $data[$i]['value'];
					echo '<p class="tel">'.$value.'<i class="icon-phone"></i></p>';
				}
			 ?>
		</div>
		<div class="social2">
			<?php 
				$data = get_contacts('mail');
				echo '<div class="mail"><p>'.$data[0]['value'].'</p></div>';
				$data = get_contacts('social');
				for ($i=0; $i < count($data) ; $i++) { 
					$name = $data[$i]['name'];
					$value = $data[$i]['value'];
					echo'<span class="'.$name.'"><a href="'.$value.'" target="_blank"><i class="icon-'.$name.'"></i></a></span>';
				}
			 ?>
		</div>
	</div>
	
<?php require_once("footer.php"); ?>