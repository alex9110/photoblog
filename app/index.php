<?php require_once("php/includes/functions.php"); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Главная</title>
	<link rel="shortcut icon" href="img/camera.png" type="image/png">
	<link rel="stylesheet" href="libs/icons/fontello/css/flickr.css">
	<link rel="stylesheet" href="css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
</head>
<body>
	<div class="wrapper">
		<header>
			<div class="header_box">
				<div class="logo"><a href="index.php"><h2>Helena Nazarenko</h2></a></div>
				<div class="social">
					<ul>
						<?php 
							$data = get_contacts('social');
							for ($i=0; $i < count($data) ; $i++) { 
								$name = $data[$i]['name'];
								$url = $data[$i]['value'];
								echo '<li><a href="'.$url.'" target="_blank" ><i class="icon-'.$name.'"></i></a></li>';
							}
						 ?>
					</ul>
				</div>
				<nav>
					<ul>
						<li class="active"><a href="php/public/index.php">Главная</a></li>
						<li><a href="php/public/portfolio.php">Портфолио</a></li>
						<li><a href="php/public/price.php">Услуги и цены</a></li>
						<li><a href="php/public/profile.php">Профайл</a></li>
					</ul>
				</nav>	
			</div>
		</header>		
		<div class="content">
		    <div class="gallery">
		    	<?php $config = config(); ?>
		    	<?php echo ( show_photo($config['index']) ); ?>
			</div>
		</div>
		<footer>
			<a id="author" target="_blank" href="https://www.facebook.com/AlexLychyk">
				<p>сайт от Aleksandr Lychyk</p>
				<img src="img/external.png" alt="" style="width: 10px; height: auto; margin-left: 4px;">
			</a>
			<a href="php/admin/login.php" id="in"></a>
		</footer>
	</div>
	<script src="js/libs.min.js"></script>
	<script src="js/common.js"></script>
</body>
</html>